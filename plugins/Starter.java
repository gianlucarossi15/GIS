public class Starter {
    public static void main(String[] args) {

        String[] arg=new String[] {
                "-i18n", "en",
                "-default-plugins", "/Library/openJump/OpenJUMP-2.2.0-r5193[9e7ba88]-PLUS/bin/default-plugins.xml",
                "-properties", "/Users/gianluca/Documents/Universita/GIS/exam/source/plugins.xml",
                "-extensions-directory","/Library/openJump/OpenJUMP-2.2.0-r5193[9e7ba88]-PLUS/lib/ext"
        };
        com.vividsolutions.jump.workbench.JUMPWorkbench.main(arg);
    }
}