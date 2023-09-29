//package Project;

import com.vividsolutions.jump.feature.*;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import org.locationtech.jts.geom.GeometryFactory;
import org.locationtech.jts.io.ParseException;
import org.locationtech.jts.io.WKTReader;


/**
 * Class to manage the database
 */
public class Database {

  /**
   * Url of the database to use. In our case the db is in local, so we put localhost
   */
  private static final String dbUrl =
    "jdbc:postgresql://localhost:5432/gis";

  private Connection conn;

  /**
   * Connection to the database
   */

  public Database(String username, char[] password) {
    try {
      conn =
        DriverManager.getConnection(
          dbUrl,
          username,
          new String(password)
        );
      System.out.println("Connected to the server!");
    } catch (SQLException e) {
      System.out.println(e.getMessage());
    }
  }

  /**
   * Retrieves the feature collection with all the reports
   * @return a @code{FeatureCollection} with all the reports
   */
  public FeatureCollection getReports() {
    FeatureSchema fs = new FeatureSchema();

    //create schema
    fs.addAttribute("id_report", AttributeType.INTEGER);
    fs.addAttribute("coordinate", AttributeType.GEOMETRY);
 
    FeatureCollection fc = new FeatureDataset(fs);

    GeometryFactory gf = new GeometryFactory();

    WKTReader wkt = new WKTReader(gf);

    String query = "SELECT ST_AsText(coordinate) as coordinate, * FROM report ";

    try (Statement stmt = conn.createStatement()) {
      ResultSet rs = stmt.executeQuery(query);
      while (rs.next()) {
        Feature f = new BasicFeature(fs);

        f.setAttribute("id_report", rs.getInt("id_report"));
        f.setGeometry(wkt.read(rs.getString("coordinate")));
        
        fc.add(f);
      }
    } catch (SQLException e) {
      System.out.println(e);
    } catch (ParseException e) {
      e.printStackTrace();
    }

    return fc;
  }
  
  /**
   * Retrieves the feature collection with shed info
   * @return a @code{FeatureCollection} with the information about the shed
   */
  public FeatureCollection getShed() {
	    FeatureSchema fs = new FeatureSchema();

	    //create schema
	    fs.addAttribute("gid", AttributeType.INTEGER);
	    fs.addAttribute("geom", AttributeType.GEOMETRY);

	    FeatureCollection fc = new FeatureDataset(fs);

	    GeometryFactory gf = new GeometryFactory();

	    WKTReader wkt = new WKTReader(gf);

	    String query = "SELECT ST_AsText(geom) as geom, * FROM shed";

	    try (Statement stmt = conn.createStatement()) {
	      ResultSet rs = stmt.executeQuery(query);
	      while (rs.next()) {
	        Feature f = new BasicFeature(fs);

	        f.setAttribute("gid", rs.getInt("gid"));
	        f.setGeometry(wkt.read(rs.getString("geom")));
	       
	        fc.add(f);
	      }
	    } catch (SQLException e) {
	      System.out.println(e);
	    } catch (ParseException e) {
	      e.printStackTrace();
	    }

	    return fc;
	  }

  /**
   * check if the connection is working properly
   * @return true if the connection works
   */
  public boolean isConnected() {
    return conn != null;
  }

  /**
   * close the connection
   * @return true if the connection is closed
   */
  public boolean close() {
    try {
      conn.close();
      return true;
    } catch (SQLException e) {
      return false;
    }
  }
}
