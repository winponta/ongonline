package br.com.ongonline.fingerkey;

import java.applet.Applet;
import java.awt.Graphics;

/**
 *
 * @author Ademir Mazer Jr <ademir.mazer.jr@gmail.com>
 */
public class NitgenEnrollApplet extends Applet {

    public Nitgen nitgen;

    private StringBuffer strBuffer;

    private static String VERSION = "0.1.20";

    void showMessage(String word) {
        System.out.println(word);
        strBuffer.append(word + "\r\n");
        repaint();
    }

    @Override
    public void init() {
        strBuffer = new StringBuffer();
        showMessage("Iniciando sistema de reconhecimento digital");
        this.nitgen = new Nitgen();
    }

    @Override
    public void destroy() {
        super.destroy();
        this.nitgen.closeDevice();
    }

    public void paint(Graphics g) {
        //Draw a Rectangle around the applet's display area.
        g.drawRect(0, 0,
                getWidth() - 1,
                getHeight() - 1);

        //display the string inside the rectangle.
        g.drawString(strBuffer.toString(), 10, 20);
    }

    public String getVersion() {
        return NitgenEnrollApplet.VERSION;
    }

}
