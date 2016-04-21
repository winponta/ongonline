#ifndef NBIOBSP_DEMO_H
#define NBIOBSP_DEMO_H

#include <QDialog>
#include "../../../include/NBioAPI.h"

#ifndef LPBYTE
typedef unsigned char*      LPBYTE;
#endif // LPBYTE

namespace Ui {
    class NBioBSP_Demo;
}

class NBioBSP_Demo : public QDialog {
    Q_OBJECT
public:
    NBioBSP_Demo(QWidget *parent = 0);
    ~NBioBSP_Demo();

    void DrawFingerImage(LPBYTE pImageBuf);

protected:
    void changeEvent(QEvent *e);

protected:
    void DisplayError(NBioAPI_RETURN nRet);
    void InitNBSPSDK();
    void TerminateNBSPSDK();
    NBioAPI_RETURN GetInitInfo();
    NBioAPI_RETURN SetInitInfo();
    NBioAPI_RETURN SetDeviceList();
    NBioAPI_RETURN OpenDevice();
    NBioAPI_RETURN Capture();
    NBioAPI_RETURN Verify();

    void MakeStreamFromFIR(NBioAPI_FIR_PTR pFullFIR, LPBYTE pBinaryStream);
    void MakeFIRFromStream(LPBYTE pBinaryStream, NBioAPI_FIR_PTR pFullFIR);
    void MakeStreamFromTextFIR(NBioAPI_FIR_TEXTENCODE_PTR pTextFIR, LPBYTE pTextStream);
    void MakeTextFIRFromStream(LPBYTE pTextStream, NBioAPI_FIR_TEXTENCODE_PTR pTextFIR);

private:
    Ui::NBioBSP_Demo*       ui;

    QVector<QRgb>           colorTable;
    NBioAPI_HANDLE          m_hNBioBSP;
    NBioAPI_FIR_HANDLE      m_hCapturedFIR;
    NBioAPI_DEVICE_INFO_0   m_DeviceInfo;
    bool                    m_bIsCapture;

private slots:
    void on_btVerify_pressed();
    void on_btCapture_pressed();
    void on_btOpen_pressed();
    void on_btGetInit_pressed();
    void on_btSetInit_pressed();
};

#endif // NBIOBSP_DEMO_H
