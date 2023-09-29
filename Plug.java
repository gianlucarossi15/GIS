//package Project;

import com.vividsolutions.jump.feature.*;
import com.vividsolutions.jump.workbench.plugin.AbstractPlugIn;
import com.vividsolutions.jump.workbench.plugin.PlugInContext;
import com.vividsolutions.jump.workbench.ui.plugin.FeatureInstaller;
import javax.swing.JFrame;
import javax.swing.JOptionPane;

/**
 * This class implement the part of the plugin that has to load all the reports made by the users
 */
public class Plug extends AbstractPlugIn {

  @Override
  public void initialize(PlugInContext context) throws Exception {
    FeatureInstaller fi = FeatureInstaller.getInstance(
      context.getWorkbenchContext()
    );
    fi.addMainMenuPlugin(
      this,
      new String[] { "GIS", "Layer" }, //menu path
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
              "Missing username or password!",
              "Error",
              JOptionPane.ERROR_MESSAGE
      );
      return false;
    }

    // Connection to the database
    Database app = new Database(login.getUserName(), login.getPassword());

    if (!app.isConnected()) {
      System.err.println("No connection with the database!");
      JOptionPane.showMessageDialog(
        new JFrame(),
        "Wrong username or password!",
        "Error",
        JOptionPane.ERROR_MESSAGE
      );
      return false;
    }

    // Load all the reports in a dedicated layer
    FeatureCollection reports = app.getReports();
    context.getLayerManager().addLayer("Layer", "Reports", reports);
    
    return false;
  }

  /**
   * gets the name of the plugin
   */
  @Override
  public String getName() {
    return "Load layer";
  }
}

