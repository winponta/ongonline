import com.nitgen.SDK.BSP.NBioBSPJNI;

public class NBioAPI_JavaUITest extends javax.swing.JDialog {

    /** Creates new form NBioAPI_JavaUITest */
    public NBioAPI_JavaUITest(java.awt.Frame parent, boolean modal) {
        super(parent, modal);
        initComponents();

        addWindowListener(new java.awt.event.WindowAdapter() {
            public void windowClosing(java.awt.event.WindowEvent e) {
                Closing();
                System.exit(0);
            }
        });

        bsp = new NBioBSPJNI();

        if (CheckError())
            return ;

        setTitle("NBioAPI_JavaUITest BSP version: " + bsp.GetVersion());

        bsp.OpenDevice();

        if (CheckError())  {
            btnCapture.setEnabled(false);
            btnEnroll.setEnabled(false);
        }
        else
            labelStatus.setText("NBioBSP Initialize success");
    }

    public void dispose()
    {
        if (bsp != null) {
            bsp.CloseDevice();
            bsp.dispose();
            bsp = null;
        }
    }

    private Boolean CheckError()
    {
        if (bsp.IsErrorOccured())  {
            labelStatus.setText("NBioBSP Error Occured [" + bsp.GetErrorCode() + "]");
            return true;
        }

        return false;
    }

    private Boolean SetWindowOption()
    {
        if (winOption != null)
            winOption = null;

        winOption = bsp.new WINDOW_OPTION();
        
        if (ShowStyle.isSelected(rbtnPopup.getModel()))  {
            winOption.WindowStyle = NBioBSPJNI.WINDOW_STYLE.POPUP;

            if (checkNFI.isSelected())
                winOption.WindowStyle |= NBioBSPJNI.WINDOW_STYLE.NO_FPIMG;

            if (checkNTMW.isSelected())
                winOption.WindowStyle |= NBioBSPJNI.WINDOW_STYLE.NO_TOPMOST;

            if (checkNWP.isSelected())
                winOption.WindowStyle |= NBioBSPJNI.WINDOW_STYLE.NO_WELCOME;
        }
        else  {
            winOption.WindowStyle = NBioBSPJNI.WINDOW_STYLE.INVISIBLE;

            if (checkSFW.isSelected())
                winOption.FingerWnd = FPWindow;
        }

        String szValue;

        szValue = textCaption.getText();

        if (szValue.length() > 0)
            winOption.CaptionMsg = szValue;

        szValue = textCancel.getText();

        if (szValue.length() > 0)
            winOption.CancelMsg = szValue;

        if (checkLThumb.isSelected())
            winOption.DisableFingerForEnroll0 = 0;
        else
            winOption.DisableFingerForEnroll0 = 1;

        if (checkLIndex.isSelected())
            winOption.DisableFingerForEnroll1 = 0;
        else
            winOption.DisableFingerForEnroll1 = 1;

        if (checkLMiddle.isSelected())
            winOption.DisableFingerForEnroll2 = 0;
        else
            winOption.DisableFingerForEnroll2 = 1;

        if (checkLRing.isSelected())
            winOption.DisableFingerForEnroll3 = 0;
        else
            winOption.DisableFingerForEnroll3 = 1;

        if (checkLLittle.isSelected())
            winOption.DisableFingerForEnroll4 = 0;
        else
            winOption.DisableFingerForEnroll4 = 1;

        if (checkRThumb.isSelected())
            winOption.DisableFingerForEnroll5 = 0;
        else
            winOption.DisableFingerForEnroll5 = 1;

        if (checkRIndex.isSelected())
            winOption.DisableFingerForEnroll6 = 0;
        else
            winOption.DisableFingerForEnroll6 = 1;

        if (checkRMiddle.isSelected())
            winOption.DisableFingerForEnroll7 = 0;
        else
            winOption.DisableFingerForEnroll7 = 1;

        if (checkRRing.isSelected())
            winOption.DisableFingerForEnroll8 = 0;
        else
            winOption.DisableFingerForEnroll8 = 1;

        if (checkRLittle.isSelected())
            winOption.DisableFingerForEnroll9 = 0;
        else
            winOption.DisableFingerForEnroll9 = 1;

        try  {
            szValue = textFpColorR.getText();
            winOption.FPForeColorR = Integer.parseInt(szValue);

            szValue = textFpColorG.getText();
            winOption.FPForeColorG = Integer.parseInt(szValue);

            szValue = textFpColorB.getText();
            winOption.FPForeColorB = Integer.parseInt(szValue);

            szValue = textBKColorR.getText();
            winOption.FPBackColorR = Integer.parseInt(szValue);

            szValue = textBKColorG.getText();
            winOption.FPBackColorG = Integer.parseInt(szValue);

            szValue = textBKColorB.getText();
            winOption.FPBackColorB = Integer.parseInt(szValue);
        }
        catch (NumberFormatException e) {
            labelStatus.setText("Invalid Input value");
            return false;
        }

        return true;
    }

    /** This method is called from within the constructor to
     * initialize the form.
     * WARNING: Do NOT modify this code. The content of this method is
     * always regenerated by the Form Editor.
     */
    @SuppressWarnings("unchecked")
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        ShowStyle = new javax.swing.ButtonGroup();
        jPanel1 = new javax.swing.JPanel();
        jPanel4 = new javax.swing.JPanel();
        checkNFI = new javax.swing.JCheckBox();
        checkNTMW = new javax.swing.JCheckBox();
        checkNWP = new javax.swing.JCheckBox();
        rbtnPopup = new javax.swing.JRadioButton();
        rbtnInvisible = new javax.swing.JRadioButton();
        jPanel7 = new javax.swing.JPanel();
        jPanel5 = new javax.swing.JPanel();
        jLabel3 = new javax.swing.JLabel();
        textFpColorR = new javax.swing.JTextField();
        textFpColorG = new javax.swing.JTextField();
        jLabel4 = new javax.swing.JLabel();
        textFpColorB = new javax.swing.JTextField();
        jLabel5 = new javax.swing.JLabel();
        jPanel6 = new javax.swing.JPanel();
        jLabel6 = new javax.swing.JLabel();
        textBKColorR = new javax.swing.JTextField();
        textBKColorG = new javax.swing.JTextField();
        jLabel7 = new javax.swing.JLabel();
        textBKColorB = new javax.swing.JTextField();
        jLabel8 = new javax.swing.JLabel();
        checkSFW = new javax.swing.JCheckBox();
        FPWindow = new java.awt.Canvas();
        jPanel2 = new javax.swing.JPanel();
        btnCapture = new javax.swing.JButton();
        btnEnroll = new javax.swing.JButton();
        jPanel3 = new javax.swing.JPanel();
        jLabel1 = new javax.swing.JLabel();
        textCaption = new javax.swing.JTextField();
        jLabel2 = new javax.swing.JLabel();
        textCancel = new javax.swing.JTextField();
        jPanel10 = new javax.swing.JPanel();
        checkRThumb = new javax.swing.JCheckBox();
        checkRIndex = new javax.swing.JCheckBox();
        checkRMiddle = new javax.swing.JCheckBox();
        checkRRing = new javax.swing.JCheckBox();
        checkRLittle = new javax.swing.JCheckBox();
        checkLThumb = new javax.swing.JCheckBox();
        checkLIndex = new javax.swing.JCheckBox();
        checkLMiddle = new javax.swing.JCheckBox();
        checkLRing = new javax.swing.JCheckBox();
        checkLLittle = new javax.swing.JCheckBox();
        jPanel12 = new javax.swing.JPanel();
        labelStatus = new javax.swing.JLabel();

        setDefaultCloseOperation(javax.swing.WindowConstants.DISPOSE_ON_CLOSE);

        jPanel1.setBorder(javax.swing.BorderFactory.createTitledBorder("Window Style"));

        jPanel4.setBorder(javax.swing.BorderFactory.createTitledBorder("Popup"));

        checkNFI.setText("No Finger Image(only for capture)");

        checkNTMW.setText("No Top Most Window");

        checkNWP.setText("No Welcome Page (only for enroll)");

        org.jdesktop.layout.GroupLayout jPanel4Layout = new org.jdesktop.layout.GroupLayout(jPanel4);
        jPanel4.setLayout(jPanel4Layout);
        jPanel4Layout.setHorizontalGroup(
            jPanel4Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
            .add(jPanel4Layout.createSequentialGroup()
                .addContainerGap()
                .add(jPanel4Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
                    .add(checkNFI)
                    .add(checkNTMW)
                    .add(checkNWP))
                .addContainerGap(343, Short.MAX_VALUE))
        );
        jPanel4Layout.setVerticalGroup(
            jPanel4Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
            .add(org.jdesktop.layout.GroupLayout.TRAILING, jPanel4Layout.createSequentialGroup()
                .addContainerGap(org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                .add(checkNFI)
                .addPreferredGap(org.jdesktop.layout.LayoutStyle.UNRELATED)
                .add(checkNTMW)
                .addPreferredGap(org.jdesktop.layout.LayoutStyle.UNRELATED)
                .add(checkNWP)
                .addContainerGap())
        );

        ShowStyle.add(rbtnPopup);
        rbtnPopup.setSelected(true);
        rbtnPopup.setText("Popup");
        rbtnPopup.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                rbtnPopupActionPerformed(evt);
            }
        });

        ShowStyle.add(rbtnInvisible);
        rbtnInvisible.setText("Invisible (only for capture)");
        rbtnInvisible.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                rbtnInvisibleActionPerformed(evt);
            }
        });

        jPanel7.setBorder(javax.swing.BorderFactory.createTitledBorder("Invisible"));

        jPanel5.setBorder(javax.swing.BorderFactory.createTitledBorder("FP COLOR"));

        jLabel3.setText("R");

        textFpColorR.setText("0");
        textFpColorR.setEnabled(false);

        textFpColorG.setText("0");
        textFpColorG.setEnabled(false);

        jLabel4.setText("G");

        textFpColorB.setText("0");
        textFpColorB.setEnabled(false);

        jLabel5.setText("B");

        org.jdesktop.layout.GroupLayout jPanel5Layout = new org.jdesktop.layout.GroupLayout(jPanel5);
        jPanel5.setLayout(jPanel5Layout);
        jPanel5Layout.setHorizontalGroup(
            jPanel5Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
            .add(jPanel5Layout.createSequentialGroup()
                .addContainerGap()
                .add(jPanel5Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
                    .add(jPanel5Layout.createSequentialGroup()
                        .add(jLabel3)
                        .addPreferredGap(org.jdesktop.layout.LayoutStyle.RELATED)
                        .add(textFpColorR, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, 61, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE))
                    .add(jPanel5Layout.createSequentialGroup()
                        .add(jLabel4)
                        .addPreferredGap(org.jdesktop.layout.LayoutStyle.RELATED)
                        .add(textFpColorG, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, 61, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE))
                    .add(jPanel5Layout.createSequentialGroup()
                        .add(jLabel5)
                        .addPreferredGap(org.jdesktop.layout.LayoutStyle.RELATED)
                        .add(textFpColorB, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, 61, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE)))
                .addContainerGap(org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
        );
        jPanel5Layout.setVerticalGroup(
            jPanel5Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
            .add(jPanel5Layout.createSequentialGroup()
                .addContainerGap()
                .add(jPanel5Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.BASELINE)
                    .add(jLabel3)
                    .add(textFpColorR, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE))
                .addPreferredGap(org.jdesktop.layout.LayoutStyle.RELATED)
                .add(jPanel5Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.BASELINE)
                    .add(jLabel4)
                    .add(textFpColorG, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE))
                .addPreferredGap(org.jdesktop.layout.LayoutStyle.RELATED)
                .add(jPanel5Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.BASELINE)
                    .add(jLabel5)
                    .add(textFpColorB, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE))
                .addContainerGap(19, Short.MAX_VALUE))
        );

        jPanel6.setBorder(javax.swing.BorderFactory.createTitledBorder("BK COLOR"));

        jLabel6.setText("R");

        textBKColorR.setText("255");
        textBKColorR.setEnabled(false);

        textBKColorG.setText("255");
        textBKColorG.setEnabled(false);

        jLabel7.setText("G");

        textBKColorB.setText("255");
        textBKColorB.setEnabled(false);

        jLabel8.setText("B");

        org.jdesktop.layout.GroupLayout jPanel6Layout = new org.jdesktop.layout.GroupLayout(jPanel6);
        jPanel6.setLayout(jPanel6Layout);
        jPanel6Layout.setHorizontalGroup(
            jPanel6Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
            .add(jPanel6Layout.createSequentialGroup()
                .addContainerGap()
                .add(jPanel6Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
                    .add(jPanel6Layout.createSequentialGroup()
                        .add(jLabel6)
                        .addPreferredGap(org.jdesktop.layout.LayoutStyle.RELATED)
                        .add(textBKColorR, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, 61, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE))
                    .add(jPanel6Layout.createSequentialGroup()
                        .add(jLabel7)
                        .addPreferredGap(org.jdesktop.layout.LayoutStyle.RELATED)
                        .add(textBKColorG, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, 61, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE))
                    .add(jPanel6Layout.createSequentialGroup()
                        .add(jLabel8)
                        .addPreferredGap(org.jdesktop.layout.LayoutStyle.RELATED)
                        .add(textBKColorB, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, 61, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE)))
                .addContainerGap(org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
        );
        jPanel6Layout.setVerticalGroup(
            jPanel6Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
            .add(jPanel6Layout.createSequentialGroup()
                .addContainerGap()
                .add(jPanel6Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.BASELINE)
                    .add(jLabel6)
                    .add(textBKColorR, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE))
                .addPreferredGap(org.jdesktop.layout.LayoutStyle.RELATED)
                .add(jPanel6Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.BASELINE)
                    .add(jLabel7)
                    .add(textBKColorG, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE))
                .addPreferredGap(org.jdesktop.layout.LayoutStyle.RELATED)
                .add(jPanel6Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.BASELINE)
                    .add(jLabel8)
                    .add(textBKColorB, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE))
                .addContainerGap(19, Short.MAX_VALUE))
        );

        checkSFW.setText("Set Finger Window");
        checkSFW.setEnabled(false);

        FPWindow.setBackground(new java.awt.Color(255, 255, 255));

        org.jdesktop.layout.GroupLayout jPanel7Layout = new org.jdesktop.layout.GroupLayout(jPanel7);
        jPanel7.setLayout(jPanel7Layout);
        jPanel7Layout.setHorizontalGroup(
            jPanel7Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
            .add(jPanel7Layout.createSequentialGroup()
                .addContainerGap()
                .add(jPanel5, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(org.jdesktop.layout.LayoutStyle.RELATED)
                .add(jPanel6, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(org.jdesktop.layout.LayoutStyle.RELATED, 15, Short.MAX_VALUE)
                .add(checkSFW)
                .add(21, 21, 21)
                .add(FPWindow, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, 134, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE)
                .add(19, 19, 19))
        );
        jPanel7Layout.setVerticalGroup(
            jPanel7Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
            .add(jPanel7Layout.createSequentialGroup()
                .add(jPanel7Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
                    .add(jPanel7Layout.createSequentialGroup()
                        .add(2, 2, 2)
                        .add(jPanel7Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
                            .add(jPanel6, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE)
                            .add(jPanel5, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE)))
                    .add(jPanel7Layout.createSequentialGroup()
                        .addContainerGap()
                        .add(checkSFW))
                    .add(FPWindow, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, 149, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE))
                .addContainerGap(12, Short.MAX_VALUE))
        );

        jPanel7Layout.linkSize(new java.awt.Component[] {jPanel5, jPanel6}, org.jdesktop.layout.GroupLayout.VERTICAL);

        org.jdesktop.layout.GroupLayout jPanel1Layout = new org.jdesktop.layout.GroupLayout(jPanel1);
        jPanel1.setLayout(jPanel1Layout);
        jPanel1Layout.setHorizontalGroup(
            jPanel1Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
            .add(jPanel1Layout.createSequentialGroup()
                .addContainerGap()
                .add(jPanel1Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
                    .add(org.jdesktop.layout.GroupLayout.TRAILING, jPanel7, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                    .add(jPanel1Layout.createSequentialGroup()
                        .add(rbtnPopup)
                        .add(18, 18, 18)
                        .add(rbtnInvisible))
                    .add(org.jdesktop.layout.GroupLayout.TRAILING, jPanel4, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
                .addContainerGap())
        );
        jPanel1Layout.setVerticalGroup(
            jPanel1Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
            .add(jPanel1Layout.createSequentialGroup()
                .addContainerGap()
                .add(jPanel1Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.BASELINE)
                    .add(rbtnPopup)
                    .add(rbtnInvisible))
                .addPreferredGap(org.jdesktop.layout.LayoutStyle.RELATED)
                .add(jPanel4, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(org.jdesktop.layout.LayoutStyle.RELATED)
                .add(jPanel7, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE)
                .addContainerGap(org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
        );

        jPanel2.setBorder(javax.swing.BorderFactory.createTitledBorder("Test Functions"));

        btnCapture.setText("CAPTURE");
        btnCapture.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                btnCaptureActionPerformed(evt);
            }
        });

        btnEnroll.setText("ENROLL");
        btnEnroll.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                btnEnrollActionPerformed(evt);
            }
        });

        org.jdesktop.layout.GroupLayout jPanel2Layout = new org.jdesktop.layout.GroupLayout(jPanel2);
        jPanel2.setLayout(jPanel2Layout);
        jPanel2Layout.setHorizontalGroup(
            jPanel2Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
            .add(jPanel2Layout.createSequentialGroup()
                .addContainerGap()
                .add(btnCapture, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, 180, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE)
                .add(18, 18, 18)
                .add(btnEnroll)
                .addContainerGap(212, Short.MAX_VALUE))
        );

        jPanel2Layout.linkSize(new java.awt.Component[] {btnCapture, btnEnroll}, org.jdesktop.layout.GroupLayout.HORIZONTAL);

        jPanel2Layout.setVerticalGroup(
            jPanel2Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
            .add(jPanel2Layout.createSequentialGroup()
                .addContainerGap()
                .add(jPanel2Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.BASELINE)
                    .add(btnCapture)
                    .add(btnEnroll))
                .addContainerGap(org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
        );

        jPanel3.setBorder(javax.swing.BorderFactory.createTitledBorder("Message (only for enroll)"));

        jLabel1.setText("Caption message:");

        jLabel2.setText("Cancel message:");

        org.jdesktop.layout.GroupLayout jPanel3Layout = new org.jdesktop.layout.GroupLayout(jPanel3);
        jPanel3.setLayout(jPanel3Layout);
        jPanel3Layout.setHorizontalGroup(
            jPanel3Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
            .add(jPanel3Layout.createSequentialGroup()
                .addContainerGap()
                .add(jPanel3Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
                    .add(jLabel1)
                    .add(jLabel2))
                .addPreferredGap(org.jdesktop.layout.LayoutStyle.RELATED)
                .add(jPanel3Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
                    .add(textCancel, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, 464, Short.MAX_VALUE)
                    .add(textCaption, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, 464, Short.MAX_VALUE))
                .addContainerGap())
        );
        jPanel3Layout.setVerticalGroup(
            jPanel3Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
            .add(org.jdesktop.layout.GroupLayout.TRAILING, jPanel3Layout.createSequentialGroup()
                .addContainerGap(org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                .add(jPanel3Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.BASELINE)
                    .add(jLabel1)
                    .add(textCaption, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE))
                .addPreferredGap(org.jdesktop.layout.LayoutStyle.UNRELATED)
                .add(jPanel3Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.BASELINE)
                    .add(jLabel2)
                    .add(textCancel, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE))
                .addContainerGap())
        );

        jPanel10.setBorder(javax.swing.BorderFactory.createTitledBorder("Select finger for enrollment"));

        checkRThumb.setSelected(true);
        checkRThumb.setText("R-Thumb");

        checkRIndex.setSelected(true);
        checkRIndex.setText("R-Index");

        checkRMiddle.setSelected(true);
        checkRMiddle.setText("R-Middle");

        checkRRing.setSelected(true);
        checkRRing.setText("R-Ring");

        checkRLittle.setSelected(true);
        checkRLittle.setText("R-Little");

        checkLThumb.setSelected(true);
        checkLThumb.setText("L-Thumb");

        checkLIndex.setSelected(true);
        checkLIndex.setText("L-Index");

        checkLMiddle.setSelected(true);
        checkLMiddle.setText("L-Middle");

        checkLRing.setSelected(true);
        checkLRing.setText("L-Ring");

        checkLLittle.setSelected(true);
        checkLLittle.setText("L-Little");

        org.jdesktop.layout.GroupLayout jPanel10Layout = new org.jdesktop.layout.GroupLayout(jPanel10);
        jPanel10.setLayout(jPanel10Layout);
        jPanel10Layout.setHorizontalGroup(
            jPanel10Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
            .add(jPanel10Layout.createSequentialGroup()
                .addContainerGap(33, Short.MAX_VALUE)
                .add(jPanel10Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
                    .add(checkLThumb, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, 109, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE)
                    .add(checkRThumb, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, 109, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE))
                .addPreferredGap(org.jdesktop.layout.LayoutStyle.UNRELATED)
                .add(jPanel10Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
                    .add(checkLIndex)
                    .add(checkRIndex))
                .addPreferredGap(org.jdesktop.layout.LayoutStyle.UNRELATED)
                .add(jPanel10Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
                    .add(checkLMiddle)
                    .add(checkRMiddle))
                .addPreferredGap(org.jdesktop.layout.LayoutStyle.UNRELATED)
                .add(jPanel10Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
                    .add(checkLRing)
                    .add(checkRRing))
                .addPreferredGap(org.jdesktop.layout.LayoutStyle.UNRELATED)
                .add(jPanel10Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
                    .add(checkLLittle)
                    .add(checkRLittle))
                .addContainerGap())
        );

        jPanel10Layout.linkSize(new java.awt.Component[] {checkRIndex, checkRLittle, checkRMiddle, checkRRing, checkRThumb}, org.jdesktop.layout.GroupLayout.HORIZONTAL);

        jPanel10Layout.linkSize(new java.awt.Component[] {checkLIndex, checkLLittle, checkLMiddle, checkLRing, checkLThumb}, org.jdesktop.layout.GroupLayout.HORIZONTAL);

        jPanel10Layout.setVerticalGroup(
            jPanel10Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
            .add(jPanel10Layout.createSequentialGroup()
                .addContainerGap()
                .add(jPanel10Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.BASELINE)
                    .add(checkRIndex)
                    .add(checkRMiddle)
                    .add(checkRRing)
                    .add(checkRLittle)
                    .add(checkRThumb))
                .addPreferredGap(org.jdesktop.layout.LayoutStyle.UNRELATED)
                .add(jPanel10Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.BASELINE)
                    .add(checkLIndex)
                    .add(checkLMiddle)
                    .add(checkLRing)
                    .add(checkLLittle)
                    .add(checkLThumb))
                .addContainerGap(9, Short.MAX_VALUE))
        );

        jPanel12.setBorder(javax.swing.BorderFactory.createBevelBorder(javax.swing.border.BevelBorder.RAISED));

        labelStatus.setText("No Error");

        org.jdesktop.layout.GroupLayout jPanel12Layout = new org.jdesktop.layout.GroupLayout(jPanel12);
        jPanel12.setLayout(jPanel12Layout);
        jPanel12Layout.setHorizontalGroup(
            jPanel12Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
            .add(labelStatus, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, 632, Short.MAX_VALUE)
        );
        jPanel12Layout.setVerticalGroup(
            jPanel12Layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
            .add(labelStatus)
        );

        org.jdesktop.layout.GroupLayout layout = new org.jdesktop.layout.GroupLayout(getContentPane());
        getContentPane().setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
            .add(org.jdesktop.layout.GroupLayout.TRAILING, layout.createSequentialGroup()
                .addContainerGap()
                .add(layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
                    .add(jPanel10, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                    .add(org.jdesktop.layout.GroupLayout.TRAILING, jPanel1, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                    .add(org.jdesktop.layout.GroupLayout.TRAILING, jPanel3, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                    .add(jPanel2, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
                .addContainerGap())
            .add(jPanel12, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(org.jdesktop.layout.GroupLayout.LEADING)
            .add(org.jdesktop.layout.GroupLayout.TRAILING, layout.createSequentialGroup()
                .add(jPanel1, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(org.jdesktop.layout.LayoutStyle.RELATED)
                .add(jPanel10, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(org.jdesktop.layout.LayoutStyle.RELATED)
                .add(jPanel3, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(org.jdesktop.layout.LayoutStyle.RELATED)
                .add(jPanel2, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, 76, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(org.jdesktop.layout.LayoutStyle.RELATED)
                .add(jPanel12, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE, org.jdesktop.layout.GroupLayout.DEFAULT_SIZE, org.jdesktop.layout.GroupLayout.PREFERRED_SIZE))
        );

        pack();
    }// </editor-fold>//GEN-END:initComponents

    public void Closing()
    {
        dispose();
    }

    private void rbtnPopupActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_rbtnPopupActionPerformed
        checkNFI.setEnabled(true);
        checkNTMW.setEnabled(true);
        checkNWP.setEnabled(true);

        textFpColorR.setEnabled(false);
        textFpColorG.setEnabled(false);
        textFpColorB.setEnabled(false);

        textBKColorR.setEnabled(false);
        textBKColorG.setEnabled(false);
        textBKColorB.setEnabled(false);

        checkSFW.setEnabled(false);
    }//GEN-LAST:event_rbtnPopupActionPerformed

    private void rbtnInvisibleActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_rbtnInvisibleActionPerformed
        checkNFI.setEnabled(false);
        checkNTMW.setEnabled(false);
        checkNWP.setEnabled(false);

        textFpColorR.setEnabled(true);
        textFpColorG.setEnabled(true);
        textFpColorB.setEnabled(true);

        textBKColorR.setEnabled(true);
        textBKColorG.setEnabled(true);
        textBKColorB.setEnabled(true);

        checkSFW.setEnabled(true);
    }//GEN-LAST:event_rbtnInvisibleActionPerformed

    private void btnCaptureActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_btnCaptureActionPerformed
        labelStatus.setText("Capture start");

        NBioBSPJNI.FIR_HANDLE hFIR = bsp.new FIR_HANDLE();

        if (SetWindowOption() == false)  {
            labelStatus.setText("Set Windows Option failed");
            return ;
        }

        bsp.Capture(NBioBSPJNI.FIR_PURPOSE.VERIFY, hFIR, -1, null, winOption);
        
        if (CheckError())
            return ;

        hFIR.dispose();
        hFIR = null;

        labelStatus.setText("Capture success");
    }//GEN-LAST:event_btnCaptureActionPerformed

    private void btnEnrollActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_btnEnrollActionPerformed
        labelStatus.setText("Enroll start");

        NBioBSPJNI.FIR_HANDLE hFIR = bsp.new FIR_HANDLE();

        if (SetWindowOption() == false)  {
            labelStatus.setText("Set Windows Option failed");
            return ;
        }

        bsp.Enroll(null, hFIR, null, -1, null, winOption);

        if (CheckError())
            return ;

        hFIR.dispose();
        hFIR = null;

        labelStatus.setText("Enroll success");
    }//GEN-LAST:event_btnEnrollActionPerformed

    /**
    * @param args the command line arguments
    */
    public static void main(String args[]) {
        java.awt.EventQueue.invokeLater(new Runnable() {
            public void run() {
                NBioAPI_JavaUITest dialog = new NBioAPI_JavaUITest(new javax.swing.JFrame(), true);
                dialog.setVisible(true);
            }
        });
    }

    // NBioBSPJNI Variables
    NBioBSPJNI                  bsp;
    NBioBSPJNI.WINDOW_OPTION    winOption;

    // Variables declaration - do not modify//GEN-BEGIN:variables
    private java.awt.Canvas FPWindow;
    private javax.swing.ButtonGroup ShowStyle;
    private javax.swing.JButton btnCapture;
    private javax.swing.JButton btnEnroll;
    private javax.swing.JCheckBox checkLIndex;
    private javax.swing.JCheckBox checkLLittle;
    private javax.swing.JCheckBox checkLMiddle;
    private javax.swing.JCheckBox checkLRing;
    private javax.swing.JCheckBox checkLThumb;
    private javax.swing.JCheckBox checkNFI;
    private javax.swing.JCheckBox checkNTMW;
    private javax.swing.JCheckBox checkNWP;
    private javax.swing.JCheckBox checkRIndex;
    private javax.swing.JCheckBox checkRLittle;
    private javax.swing.JCheckBox checkRMiddle;
    private javax.swing.JCheckBox checkRRing;
    private javax.swing.JCheckBox checkRThumb;
    private javax.swing.JCheckBox checkSFW;
    private javax.swing.JLabel jLabel1;
    private javax.swing.JLabel jLabel2;
    private javax.swing.JLabel jLabel3;
    private javax.swing.JLabel jLabel4;
    private javax.swing.JLabel jLabel5;
    private javax.swing.JLabel jLabel6;
    private javax.swing.JLabel jLabel7;
    private javax.swing.JLabel jLabel8;
    private javax.swing.JPanel jPanel1;
    private javax.swing.JPanel jPanel10;
    private javax.swing.JPanel jPanel12;
    private javax.swing.JPanel jPanel2;
    private javax.swing.JPanel jPanel3;
    private javax.swing.JPanel jPanel4;
    private javax.swing.JPanel jPanel5;
    private javax.swing.JPanel jPanel6;
    private javax.swing.JPanel jPanel7;
    private javax.swing.JLabel labelStatus;
    private javax.swing.JRadioButton rbtnInvisible;
    private javax.swing.JRadioButton rbtnPopup;
    private javax.swing.JTextField textBKColorB;
    private javax.swing.JTextField textBKColorG;
    private javax.swing.JTextField textBKColorR;
    private javax.swing.JTextField textCancel;
    private javax.swing.JTextField textCaption;
    private javax.swing.JTextField textFpColorB;
    private javax.swing.JTextField textFpColorG;
    private javax.swing.JTextField textFpColorR;
    // End of variables declaration//GEN-END:variables

}
