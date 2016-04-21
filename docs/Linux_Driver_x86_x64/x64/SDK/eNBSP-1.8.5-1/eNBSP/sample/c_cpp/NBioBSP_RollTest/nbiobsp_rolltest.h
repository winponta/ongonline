#ifndef NBIOBSP_ROLLTEST_H
#define NBIOBSP_ROLLTEST_H

#include <QDialog>
#include <QThread>
#include <QMutex>
#include "../../../include/NBioAPI.h"

namespace Ui {
    class NBioBSP_RollTest;
}


class CaptureThread : public QThread
{
    Q_OBJECT
public:
    CaptureThread(QDialog* pMain)  { m_pMain = pMain; }

protected:
    void run();

private:
    QDialog*   m_pMain;
};


class NBioBSP_RollTest : public QDialog {
    Q_OBJECT
public:
    NBioBSP_RollTest(QWidget *parent = 0);
    ~NBioBSP_RollTest();

    void SetDrawImage(unsigned char* pImageBuf);
    void DrawImage();
    NBioAPI_RETURN Capture();

protected:
    void DisplayError(NBioAPI_RETURN nRet);
    void InitNBSPSDK();
    void TerminateNBSPSDK();
    NBioAPI_RETURN SetDeviceList();
    NBioAPI_RETURN OpenDevice();
    NBioAPI_RETURN Verify();

protected:
    void changeEvent(QEvent *e);
    void customEvent(QEvent *e);
    void closeEvent(QCloseEvent *e);

private:
    Ui::NBioBSP_RollTest*   ui;

    QVector<QRgb>           colorTable;
    NBioAPI_HANDLE          m_hNBioBSP;
    NBioAPI_FIR_HANDLE      m_hCapturedFIR;
    NBioAPI_DEVICE_INFO_0   m_DeviceInfo;
    unsigned char*          m_pImageBuf;
    CaptureThread           m_CaptureThread;
    QMutex                  m_Mutex;

private slots:
    void on_btVERIFY_pressed();
    void on_btROLL_pressed();
    void on_btOPEN_pressed();
};


#endif // NBIOBSP_ROLLTEST_H
