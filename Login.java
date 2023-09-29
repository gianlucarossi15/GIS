//package Project;

import java.awt.*;
import java.awt.event.*;
import javax.swing.*;

/**
 * Login for the database
 */
public class Login extends JDialog implements ActionListener {

  JPanel panel;
  JLabel user_label, password_label;
  JTextField username_text;
  JPasswordField password_text;
  JButton submit;
  private String username;
  private char[] password;

  /**
   * Window to login to the database
   */
  Login() {
	  
    //Label to insert the user name
    setModal(true);
    user_label = new JLabel();
    user_label.setText("Username:");
    username_text = new JTextField();
    
    //Label to insert the password
    password_label = new JLabel();
    password_label.setText("Password:");
    password_text = new JPasswordField();
    
    //Submission button
    submit = new JButton("Login");
    JPanel buttonPanel = new JPanel();
    buttonPanel.setLayout(new FlowLayout(FlowLayout.CENTER));
    buttonPanel.add(submit);
    panel = new JPanel(new GridLayout(3, 1));
    panel.add(user_label);
    panel.add(username_text);
    panel.add(password_label);
    panel.add(password_text);
    panel.add(buttonPanel, BorderLayout.CENTER);

    //Adding the listeners to components
    submit.addActionListener(this);
    add(panel, BorderLayout.CENTER);
    setTitle("Database login");
    setSize(380, 230);
    // Put the JDialog in the center of the window
    pack();
    setLocationRelativeTo(null);
    setVisible(true);
    
  }

  /**
   * Function to  get the user name insert by the user
   */
  public String getUserName() {
    return username;
  }

  /**
   * Function to get the password insert by the user
   */
  public char[] getPassword() {
    return password;
  }

  /**
   * Save the user name and password
   */
  public void actionPerformed(ActionEvent ae) {
    username = username_text.getText();
    password = password_text.getPassword();
    setVisible(false);
    dispose();
  }
}
