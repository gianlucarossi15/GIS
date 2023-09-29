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
import java.io.FileWriter;   // Import the FileWriter class
import java.io.IOException;
import javax.swing.*;

/**
 * This class exports the route in a .kml file to be visualized on Google Earth
 */
public class Export extends AbstractPlugIn {
  @Override
  public void initialize(PlugInContext context) throws Exception {
    FeatureInstaller fi = FeatureInstaller.getInstance(
      context.getWorkbenchContext()
    );
    fi.addMainMenuPlugin(
      this,
      new String[] { "GIS", "Export" },
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
      System.err.println("Missing username or password\n");
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
      System.err.println("database not connected");
      JOptionPane.showMessageDialog(
              new JFrame(),
              "Wrong username or password",
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

    // Count the number of reports
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
    System.out.println("length "+length);
    line.setGeometry(gf.createLineString(coordinate));
    line.setAttribute("type", "line");
    route.add(line);

    // Export the route computed in a .xml file
    StringBuilder linestring = new StringBuilder();
    linestring.append("<coordinates>");
    
    /*
    for(Coordinate c: coordinate){
      c=srs_conversion(c);
      linestring.append(c.x).append(",").append(c.y).append(" ").append("\n");
      System.out.println(j+ "th point: "+c.x+"-"+c.y);
      j++;
    }
    */
    
    // Read the coordinate of all reports
    for(i = 0; i < coordinate.length-1; i++)
    {
      coordinate[i] = srs_conversion(coordinate[i]);
      linestring.append(coordinate[i].x).append(",").append(coordinate[i].y).append(" ").append("\n");
    }
    
    // Coordinate of the shed
    linestring.append(coordinate[0].x).append(",").append(coordinate[0].y).append(" ").append("\n");
    
    // Writing of the .kml file
    linestring.append("</coordinates>");
    try {
      FileWriter myWriter = new FileWriter("route.kml");
      myWriter.write("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" +
              "<kml xmlns=\"http://www.opengis.net/kml/2.2\"><Document>\n" +
              "  <Placemark>\n" +
              "    <name>Truck route</name>\n" +
              "    <description>Here it is the route made by the truck from the shed \n" +
              "       to all reports coordinate and back.</description>\n" +
              "    <LineString>\n" +
              linestring +
              "    </LineString>\n" +
              "  </Placemark></Document>\n" +
              "</kml>");
      myWriter.close();
      System.out.println("Successfully wrote to the file.");
    } catch (IOException e) {
      System.out.println("An error occurred.");
      e.printStackTrace();
    }

    return false;
  }

  /**
   * gets the name of the plugin
   */
  @Override
  public String getName(){
    return "Export route";
  }
  
  // Method to convert the coordinate from EPSG:3857 to EPSG:4326
  public Coordinate srs_conversion(Coordinate c) {
    double x = c.x;
    double y = c.y;
    
    x = x * 180 / 20037508.34 ;
    y = y * 180 / 20037508.34 ;
    y = (Math.atan(Math.pow(Math.E, y * (Math.PI / 180))) * 360) / Math.PI - 90;

    c.x = x;
    c.y = y;

    return c;
  }

}



