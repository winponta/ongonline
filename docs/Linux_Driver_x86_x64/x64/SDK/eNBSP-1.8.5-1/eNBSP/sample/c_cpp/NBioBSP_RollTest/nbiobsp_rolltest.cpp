/************************************************************************
** COPYRIGHT (C) 2011 NITGEN&COMPANY
**
** THIS WORK CONTAINS TRADE SECRET AND PROPRIETARY INFORMATION WHICH IS
** THE PROPERTY OF NITGEN&COMPANY
**
** PROJECT NAME: eNBSP SDK
**
** FILE NAME: NBioBSP_RollTest.cpp
**
** PURPOSE: eNBSP SDK Roll Demo
**
** FUNCTIONS:
**
** AUTHOR: chul
**
** VERSION:
**
** LAST MODIFIED: [2011-3-15 14:24 by chul]
**
*************************************************************************/
/*************************************************************************
NOTE:

*************************************************************************/

#include "nbiobsp_rolltest.h"
#include "ui_nbiobsp_rolltest.h"
#include "../../../include/NBioAPI_Export.h"
#include <stdio.h>
#include <QCloseEvent>

void CaptureThread::run()
{
    ((NBioBSP_RollTest*) m_pMain)->Capture();
}

NBioBSP_RollTest::NBioBSP_RollTest(QWidget *parent) :
    QDialog(parent),
    ui(new Ui::NBioBSP_RollTest),
    m_CaptureThread(this)
{
    ui->setupUi(this);

    colorTable.resize(256);

    for (int i = 0; i < 256; i++)
        colorTable[i] = qRgb(i,i,i);

    m_hNBioBSP = NULL;
    m_hCapturedFIR = NULL;
    m_pImageBuf = NULL;
    memset(&m_DeviceInfo, 0, sizeof(NBioAPI_DEVICE_INFO_0));

    InitNBSPSDK();

    // DeviceList
    NBioAPI_RETURN nRet = SetDeviceList();

    if (NBioAPIERROR_NONE != nRet)
        DisplayError(nRet);
    else
        ui->labelStatus->setText("eNBSP SDK Initialize Success");
}

NBioBSP_RollTest::~NBioBSP_RollTest()
{
    delete ui;
    TerminateNBSPSDK();

    if (m_pImageBuf)
        delete[] m_pImageBuf;
}

void NBioBSP_RollTest::changeEvent(QEvent *e)
{
    QDialog::changeEvent(e);
    switch (e->type()) {
    case QEvent::LanguageChange:
        ui->retranslateUi(this);
        break;
    default:
        break;
    }
}

void NBioBSP_RollTest::customEvent(QEvent *e)
{
    if (e->type() == QEvent::User + 100)
        DrawImage();
}

void NBioBSP_RollTest::closeEvent(QCloseEvent *e)
{
    if (m_CaptureThread.isRunning())
        e->ignore();
    else
        e->accept();
}

/////////////////////////////////////////////////////////////////
// NBioBSP_Demo class: Capture CallBack function

NBioAPI_RETURN MyRollCaptureCallback(NBioAPI_WINDOW_CALLBACK_PARAM_PTR_0 pCallbackParam, NBioAPI_VOID_PTR pUserParam)
{
    NBioBSP_RollTest* pWidget = (NBioBSP_RollTest*) pUserParam;

    QEvent* pEvent = new QEvent((QEvent::Type)(QEvent::User + 100));
    pWidget->SetDrawImage(pCallbackParam->lpImageBuf);
    QApplication::postEvent(pWidget, pEvent);

    return NBioAPIERROR_NONE;
}

NBioAPI_RETURN MyFlatCaptureCallback(NBioAPI_WINDOW_CALLBACK_PARAM_PTR_0 pCallbackParam, NBioAPI_VOID_PTR pUserParam)
{
    NBioBSP_RollTest* pWidget = (NBioBSP_RollTest*) pUserParam;

    pWidget->SetDrawImage(pCallbackParam->lpImageBuf);
    pWidget->DrawImage();

    return NBioAPIERROR_NONE;
}

/////////////////////////////////////////////////////////////////
// NBioBSP_RollTest class: proteted member functions

void NBioBSP_RollTest::DisplayError(NBioAPI_RETURN nRet)
{
    QString szErrorMsg;

    if (NBioAPIERROR_NONE == nRet)
        ui->labelStatus->setText("NBioBSP Function Call Success");
    else  {
        switch (nRet)  {
            case NBioAPIERROR_INVALID_HANDLE:
            szErrorMsg = "NBioAPIERROR_INVALID_HANDLE";
            break;

            case NBioAPIERROR_INVALID_POINTER:
            szErrorMsg = "NBioAPIERROR_INVALID_POINTER";
            break;

            case NBioAPIERROR_INVALID_TYPE:
            szErrorMsg = "NBioAPIERROR_INVALID_TYPE";
            break;

            case NBioAPIERROR_FUNCTION_FAIL:
            szErrorMsg = "NBioAPIERROR_FUNCTION_FAIL";
            break;

            case NBioAPIERROR_STRUCTTYPE_NOT_MATCHED:
            szErrorMsg = "NBioAPIERROR_STRUCTTYPE_NOT_MATCHED";
            break;

            case NBioAPIERROR_ALREADY_PROCESSED:
            szErrorMsg = "NBioAPIERROR_ALREADY_PROCESSED";
            break;

            case NBioAPIERROR_EXTRACTION_OPEN_FAIL:
            szErrorMsg = "NBioAPIERROR_EXTRACTION_OPEN_FAIL";
            break;

            case NBioAPIERROR_VERIFICATION_OPEN_FAIL:
            szErrorMsg = "NBioAPIERROR_VERIFICATION_OPEN_FAIL";
            break;

            case NBioAPIERROR_DATA_PROCESS_FAIL:
            szErrorMsg = "NBioAPIERROR_DATA_PROCESS_FAIL";
            break;

            case NBioAPIERROR_MUST_BE_PROCESSED_DATA:
            szErrorMsg = "NBioAPIERROR_MUST_BE_PROCESSED_DATA";
            break;

            case NBioAPIERROR_INTERNAL_CHECKSUM_FAIL:
            szErrorMsg = "NBioAPIERROR_INTERNAL_CHECKSUM_FAIL";
            break;

            case NBioAPIERROR_ENCRYPTED_DATA_ERROR:
            szErrorMsg = "NBioAPIERROR_ENCRYPTED_DATA_ERROR";
            break;

            case NBioAPIERROR_UNKNOWN_FORMAT:
            szErrorMsg = "NBioAPIERROR_UNKNOWN_FORMAT";
            break;

            case NBioAPIERROR_UNKNOWN_VERSION:
            szErrorMsg = "NBioAPIERROR_UNKNOWN_VERSION";
            break;

            case NBioAPIERROR_VALIDITY_FAIL:
            szErrorMsg = "NBioAPIERROR_VALIDITY_FAIL";
            break;

            case NBioAPIERROR_INIT_MAXFINGER:
            szErrorMsg = "NBioAPIERROR_INIT_MAXFINGER";
            break;

            case NBioAPIERROR_INIT_SAMPLESPERFINGER:
            szErrorMsg = "NBioAPIERROR_INIT_SAMPLESPERFINGER";
            break;

            case NBioAPIERROR_INIT_ENROLLQUALITY:
            szErrorMsg = "NBioAPIERROR_INIT_ENROLLQUALITY";
            break;

            case NBioAPIERROR_INIT_VERIFYQUALITY:
            szErrorMsg = "NBioAPIERROR_INIT_VERIFYQUALITY";
            break;

            case NBioAPIERROR_INIT_IDENTIFYQUALITY:
            szErrorMsg = "NBioAPIERROR_INIT_IDENTIFYQUALITY";
            break;

            case NBioAPIERROR_INIT_SECURITYLEVEL:
            szErrorMsg = "NBioAPIERROR_INIT_SECURITYLEVEL";
            break;

            case NBioAPIERROR_INVALID_MINSIZE:
            szErrorMsg = "NBioAPIERROR_INVALID_MINSIZE";
            break;

            case NBioAPIERROR_INVALID_TEMPLATE:
            szErrorMsg = "NBioAPIERROR_INVALID_TEMPLATE";
            break;

            case NBioAPIERROR_EXPIRED_VERSION:
            szErrorMsg = "NBioAPIERROR_EXPIRED_VERSION";
            break;

            case NBioAPIERROR_INVALID_SAMPLESPERFINGER:
            szErrorMsg = "NBioAPIERROR_INVALID_SAMPLESPERFINGER";
            break;

            case NBioAPIERROR_UNKNOWN_INPUTFORMAT:
            szErrorMsg = "NBioAPIERROR_UNKNOWN_INPUTFORMAT";
            break;

            case NBioAPIERROR_INIT_ENROLLSECURITYLEVEL:
            szErrorMsg = "NBioAPIERROR_INIT_ENROLLSECURITYLEVEL";
            break;

            case NBioAPIERROR_INIT_NECESSARYENROLLNUM:
            szErrorMsg = "NBioAPIERROR_INIT_NECESSARYENROLLNUM";
            break;

            case NBioAPIERROR_DEVICE_OPEN_FAIL:
            szErrorMsg = "NBioAPIERROR_DEVICE_OPEN_FAIL";
            break;

            case NBioAPIERROR_INVALID_DEVICE_ID:
            szErrorMsg = "NBioAPIERROR_INVALID_DEVICE_ID";
            break;

            case NBioAPIERROR_WRONG_DEVICE_ID:
            szErrorMsg = "NBioAPIERROR_WRONG_DEVICE_ID";
            break;

            case NBioAPIERROR_DEVICE_ALREADY_OPENED:
            szErrorMsg = "NBioAPIERROR_DEVICE_ALREADY_OPENED";
            break;

            case NBioAPIERROR_DEVICE_NOT_OPENED:
            szErrorMsg = "NBioAPIERROR_DEVICE_NOT_OPENED";
            break;

            case NBioAPIERROR_DEVICE_BRIGHTNESS:
            szErrorMsg = "NBioAPIERROR_DEVICE_BRIGHTNESS";
            break;

            case NBioAPIERROR_DEVICE_CONTRAST:
            szErrorMsg = "NBioAPIERROR_DEVICE_CONTRAST";
            break;

            case NBioAPIERROR_DEVICE_GAIN:
            szErrorMsg = "NBioAPIERROR_DEVICE_GAIN";
            break;

            case NBioAPIERROR_LOWVERSION_DRIVER:
            szErrorMsg = "NBioAPIERROR_LOWVERSION_DRIVER";
            break;

            case NBioAPIERROR_DEVICE_INIT_FAIL:
            szErrorMsg = "NBioAPIERROR_DEVICE_INIT_FAIL";
            break;

            case NBioAPIERROR_USER_CANCEL:
            szErrorMsg = "NBioAPIERROR_USER_CANCEL";
            break;

            case NBioAPIERROR_USER_BACK:
            szErrorMsg = "NBioAPIERROR_USER_BACK";
            break;

            case NBioAPIERROR_CAPTURE_TIMEOUT:
            szErrorMsg = "NBioAPIERROR_CAPTURE_TIMEOUT";
            break;

            default:
            szErrorMsg.sprintf("%04X", nRet);
            break;
        }

        QString szTemp = QString("NBioBSP Error: %1").arg(szErrorMsg);
        ui->labelStatus->setText(szTemp);
    }
}

void NBioBSP_RollTest::InitNBSPSDK()
{
    // NBioBSP SDK module initialization.
    NBioAPI_RETURN nRet = NBioAPI_Init(&m_hNBioBSP);

    if (NBioAPIERROR_NONE != nRet)  {
        DisplayError(nRet);
        m_hNBioBSP = NULL;
        return ;
    }

    NBioAPI_VERSION ver;

    memset(&ver, 0, sizeof(NBioAPI_VERSION));

    //NBioAPI Get Version
    nRet = NBioAPI_GetVersion(m_hNBioBSP, &ver);

    if (NBioAPIERROR_NONE != nRet)  {
        DisplayError(nRet);
        return ;
    }

    QString szTitle;

    szTitle.sprintf("NBioBSP_RollTest eNBSP SDK version : %d.%04d", ver.Major, ver.Minor);
    setWindowTitle(szTitle);
}

void NBioBSP_RollTest::TerminateNBSPSDK()
{
    //Free FIR Handle.
    if (m_hNBioBSP)  {
        if (m_hCapturedFIR)
            NBioAPI_FreeFIRHandle(m_hNBioBSP, m_hCapturedFIR);

        NBioAPI_DEVICE_ID deviceID = NBioAPI_GetOpenedDeviceID(m_hNBioBSP);

        //Device Close.
        if (NBioAPI_DEVICE_ID_NONE != deviceID)
            NBioAPI_CloseDevice(m_hNBioBSP, deviceID);

        //NBioAPI Terminate
        NBioAPI_Terminate(m_hNBioBSP);
    }
}

NBioAPI_RETURN NBioBSP_RollTest::SetDeviceList()
{
    NBioAPI_UINT32 nDeviceCnt;                  // Device Total Count
    NBioAPI_DEVICE_ID* pDeviceList;             // Device ID
    NBioAPI_DEVICE_INFO_EX_PTR pDeviceInfoEx;   // Device Information

    //NBioAPI Enumerate Device List
    NBioAPI_RETURN nRet = NBioAPI_EnumerateDeviceEx(m_hNBioBSP, &nDeviceCnt, &pDeviceList, &pDeviceInfoEx);

    ui->comboDEVICE->clear();

    if (NBioAPIERROR_NONE == nRet)  {
        NBioAPI_UINT32 i;
        QString szDevice;
        NBioAPI_DEVICE_ID deviceID;

        //Add Device List
        ui->comboDEVICE->addItem("Auto_Detect", NBioAPI_DEVICE_ID_AUTO);

        for (i = 0; i < nDeviceCnt; i++)  {
            szDevice.sprintf("%s (ID: %02d)", pDeviceInfoEx[i].Name, pDeviceInfoEx[i].Instance);
            deviceID = pDeviceInfoEx[i].NameID | (pDeviceInfoEx[i].Instance << 8);
            ui->comboDEVICE->addItem(szDevice, deviceID);
        }

        ui->comboDEVICE->setCurrentIndex(0);
        ui->btOPEN->setEnabled(true);
    }

    return nRet;
}

NBioAPI_RETURN NBioBSP_RollTest::OpenDevice()
{
    NBioAPI_RETURN nRet;
    NBioAPI_DEVICE_ID deviceID = NBioAPI_GetOpenedDeviceID(m_hNBioBSP);  //Get Device ID

    //Close Before Module Device.
    if (NBioAPI_DEVICE_ID_NONE != deviceID)
        NBioAPI_CloseDevice(m_hNBioBSP, deviceID);

    int nIndex = ui->comboDEVICE->currentIndex();
    deviceID = (NBioAPI_DEVICE_ID) ui->comboDEVICE->itemData(nIndex).toInt();

    //Open Device
    nRet = NBioAPI_OpenDevice(m_hNBioBSP, deviceID);

    ui->btROLL->setEnabled(false);

    if (NBioAPIERROR_NONE == nRet)  {
        nRet = NBioAPI_GetDeviceInfo(m_hNBioBSP, deviceID, 0, &m_DeviceInfo);

        if (NBioAPIERROR_NONE == nRet)  {
            if (m_pImageBuf)  {
                delete[] m_pImageBuf;
                m_pImageBuf = NULL;
            }

            m_pImageBuf = new unsigned char[m_DeviceInfo.ImageWidth * m_DeviceInfo.ImageHeight];

            ui->btROLL->setEnabled(true);
        }
    }

    return nRet;
}

NBioAPI_RETURN NBioBSP_RollTest::Verify()
{
    NBioAPI_RETURN nRet;
    NBioAPI_INPUT_FIR inputFIR;
    NBioAPI_BOOL bMatchRet;

    inputFIR.Form = NBioAPI_FIR_FORM_HANDLE;
    inputFIR.InputFIR.FIRinBSP = &m_hCapturedFIR;

    // Windows Option setting
    NBioAPI_WINDOW_OPTION winOption;

    memset(&winOption, 0, sizeof(NBioAPI_WINDOW_OPTION));
    winOption.Length = sizeof(NBioAPI_WINDOW_OPTION);
    winOption.WindowStyle = NBioAPI_WINDOW_STYLE_INVISIBLE;
    winOption.CaptureCallBackInfo.CallBackType = 0;
    winOption.CaptureCallBackInfo.CallBackFunction = MyFlatCaptureCallback;
    winOption.CaptureCallBackInfo.UserCallBackParam = this;

    //NBioAPI FIR Verify
    nRet = NBioAPI_Verify(m_hNBioBSP, &inputFIR, &bMatchRet, NULL, -1, NULL, &winOption);

    if (NBioAPIERROR_NONE == nRet)  {
        if (bMatchRet)
            ui->labelStatus->setText("Verify Success!!");
        else
            ui->labelStatus->setText("Verify Failed!!");
    }

    return nRet;
}


/////////////////////////////////////////////////////////////////
// NBioBSP_Demo class: public member functions

void NBioBSP_RollTest::SetDrawImage(unsigned char *pImageBuf)
{
    m_Mutex.lock();
    memcpy(m_pImageBuf, pImageBuf, m_DeviceInfo.ImageWidth * m_DeviceInfo.ImageHeight);
    m_Mutex.unlock();
}

void NBioBSP_RollTest::DrawImage()
{
    m_Mutex.lock();

    QImage DrawImage = QImage(m_pImageBuf, m_DeviceInfo.ImageWidth, m_DeviceInfo.ImageHeight, QImage::Format_Indexed8);
    DrawImage.setColorTable(colorTable);
    QPixmap ImgFinger = QPixmap::fromImage(DrawImage.scaled(400, 400, Qt::IgnoreAspectRatio), Qt::NoOpaqueDetection);

    if (ImgFinger.isNull() == false)  {
        ui->FPLabel->setPixmap(ImgFinger);
        ui->FPLabel->repaint();
    }

    m_Mutex.unlock();
}

NBioAPI_RETURN NBioBSP_RollTest::Capture()
{
    NBioAPI_RETURN nRet;

    //Free FIR Handle
    if (m_hCapturedFIR)  {
        NBioAPI_FreeFIRHandle(m_hNBioBSP, m_hCapturedFIR);
        m_hCapturedFIR = NULL;
    }

    // Windows Option setting
    NBioAPI_WINDOW_OPTION winOption;

    memset(&winOption, 0, sizeof(NBioAPI_WINDOW_OPTION));
    winOption.Length = sizeof(NBioAPI_WINDOW_OPTION);
    winOption.WindowStyle = NBioAPI_WINDOW_STYLE_INVISIBLE;
    winOption.CaptureCallBackInfo.CallBackType = 0;
    winOption.CaptureCallBackInfo.CallBackFunction = MyRollCaptureCallback;
    winOption.CaptureCallBackInfo.UserCallBackParam = this;

    NBioAPI_FIR_HANDLE hCapturedAudit = NBioAPI_INVALID_HANDLE;

    ui->btVERIFY->setEnabled(false);

    //NBioAPI FIR Capture
    nRet = NBioAPI_RollCapture(m_hNBioBSP, NBioAPI_FIR_PURPOSE_VERIFY, 20000, &m_hCapturedFIR, &hCapturedAudit, &winOption);

    if (nRet == NBioAPIERROR_NONE)  {
        ui->labelStatus->setText("Roll capture success");

        if (hCapturedAudit)  {
            NBioAPI_EXPORT_AUDIT_DATA exportAudit;
            NBioAPI_INPUT_FIR inputFIR;

            inputFIR.Form = NBioAPI_FIR_FORM_HANDLE;
            inputFIR.InputFIR.FIRinBSP = &hCapturedAudit;

            nRet = NBioAPI_NBioBSPToImage(m_hNBioBSP, &inputFIR, &exportAudit);

            if (nRet == NBioAPIERROR_NONE)  {
                char szFileName[256];
                FILE* fp;

                sprintf(szFileName, "RollCaptureRaw_%d_%d.raw", exportAudit.ImageWidth, exportAudit.ImageHeight);

                fp = fopen(szFileName, "wb");

                if (fp)  {
                    fwrite(exportAudit.AuditData[0].Image[0].Data, 1, exportAudit.ImageWidth*exportAudit.ImageHeight, fp);
                    fclose(fp);
                }

                NBioAPI_FreeExportAuditData(m_hNBioBSP, &exportAudit);
            }

            NBioAPI_FreeFIRHandle(m_hNBioBSP, hCapturedAudit);
        }

        ui->btVERIFY->setEnabled(true);
    }
    else
        DisplayError(nRet);

    ui->btROLL->setEnabled(true);

    return nRet;
}

/////////////////////////////////////////////////////////////////
// NBioBSP_RollTest class: slots functions

void NBioBSP_RollTest::on_btOPEN_pressed()
{
    //Device Open.
    NBioAPI_RETURN nRet = OpenDevice();

    if (NBioAPIERROR_NONE != nRet)
        DisplayError(nRet);
    else
        ui->labelStatus->setText("Open Device API Success");
}

void NBioBSP_RollTest::on_btROLL_pressed()
{
    ui->btROLL->setEnabled(false);

    if (m_CaptureThread.isRunning() == false)
        m_CaptureThread.start();
}

void NBioBSP_RollTest::on_btVERIFY_pressed()
{
    //Verify.
    NBioAPI_RETURN nRet = Verify();

    if (NBioAPIERROR_NONE != nRet)
        DisplayError(nRet);
}
