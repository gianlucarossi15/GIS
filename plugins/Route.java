//package Project;

import com.vividsolutions.jump.feature.*;
import com.vividsolutions.jump.feature.BasicFeature;
import com.vividsolutions.jump.feature.Feature;
import com.vividsolutions.jump.feature.FeatureCollection;
import com.vividsolutions.jump.workbench.plugin.AbstractPlugIn;
import com.vividsolutions.jump.workbench.plugin.PlugInContext;
import com.vividsolutions.jump.workbench.ui.plugin.FeatureInstaller;
import org.locationtech.jts.geom.Coordinate;
import org.locationtech.jts.geom.GeometryFactory;
import javax.swing.*;

/**
 * This class implements the computation of the route and its visualization using a LineString
 */
public class Route extends AbstractPlugIn {

  @Override
  public void initialize(PlugInContext context) throws Exception {
    FeatureInstaller fi = FeatureInstaller.getInstance(
      context.getWorkbenchContext()
    );
    fi.addMainMenuPlugin(
      this,
      new String[] { "GIS", "Route" },
      this.getName(),
      false,
      null,
      null
    );
  }

  @Override
  public boolean execute(PlugInContext context) throws Exception {
    Login login = new Login();

    // Call the login method to authenticate the user
    if (login.getPassword().equals("") || login.getUserName().equals("")) {
      System.err.println("Missing username or password");
      JOptionPane.showMessageDialog(
              new JFrame(),
              "Missing username or password",
              "Error",
              JOptionPane.ERROR_MESSAGE
      );
      return false;
    }

    // Connection to the database
    Database app = new Database(login.getUserName(), login.getPassword());

    if (!app.isConnected()) {
      System.err.println("database not conneted");
      JOptionPane.showMessageDialog(
              new JFrame(),
              "Username or password not corret",
              "Error",
              JOptionPane.ERROR_MESSAGE
      );
      return false;
    }

    // Load all reports with their attributes
    FeatureCollection reports = app.getReports();
    // Load the shed with its attributes
    FeatureCollection shed = app.getShed();

    // Close connection with the database
    app.close();

    Feature sh = null;
    for (Feature f : shed.getFeatures()) {
      sh = f;
    }

    // Count number of reports
    int count = 0;
    Feature rep = null;
    for (Feature f : reports.getFeatures()) {
      rep = f;
      count++;
    }

    FeatureSchema fs = new FeatureSchema();
    
    fs.addAttribute("coordinate", AttributeType.GEOMETRY);
    fs.addAttribute("type", AttributeType.STRING);
    
    FeatureCollection route = new FeatureDataset(fs);
    GeometryFactory gf = new GeometryFactory();

    // Computation of the route 
    Feature line = new BasicFeature(fs);
    Coordinate[] coordinate = new Coordinate[count + 2];
    // Starting point of the route is the shed location
    coordinate[0] = sh.getGeometry().getCoordinate();
    int i = 1;
    // Iterate over all reports to extract their coordinate
    for (Feature f : reports.getFeatures()) {
      coordinate[i] = f.getGeometry().getCoordinate();
      i++;
    }
    // Final point of the route must be equal to the starting point
    coordinate[i] = coordinate[0];
    
    // Creation of the LineString using the coordinate computed before
    double length = gf.createLineString(coordinate).getLength();
    System.out.println("Length of the route: "+length);
    line.setGeometry(gf.createLineString(coordinate));
    line.setAttribute("type", "line");
    route.add(line);

    // Load in 3 different layer the reports, the computed route and the shed
    context.getLayerManager().addLayer("Layer", "Reports", reports);
    context.getLayerManager().addLayer("Layer", "Route", route);
    context.getLayerManager().addLayer("Layer", "Shed", shed);

    return false;
  }

  /**
   * gets the name of the plugin
   */
  @Override
  public String getName(){
    return "Calculate route";
  }

}


