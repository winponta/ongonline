/************************************************************************
** COPYRIGHT (C) 2011 NITGEN&COMPANY
**
** THIS WORK CONTAINS TRADE SECRET AND PROPRIETARY INFORMATION WHICH IS
** THE PROPERTY OF NITGEN&COMPANY
**
** PROJECT NAME: eNBSP SDK
**
** FILE NAME: NBioBSP_Demo.cpp
**
** PURPOSE: eNBSP SDK Demo
**
** FUNCTIONS:
**
** AUTHOR: chul
**
** VERSION:
**
** LAST MODIFIED: [2011-3-14 14:24 by chul]
**
*************************************************************************/
/*************************************************************************
NOTE:

*************************************************************************/

#include "nbiobsp_demo.h"
#include "ui_nbiobsp_demo.h"
#include "qmessagebox.h"

NBioBSP_Demo::NBioBSP_Demo(QWidget *parent) :
    QDialog(parent),
    ui(new Ui::NBioBSP_Demo)
{
    ui->setupUi(this);

    colorTable.resize(256);

    for (int i = 0; i < 256; i++)
        colorTable[i] = qRgb(i,i,i);

    ui->comboSL->addItem("Lowest");
    ui->comboSL->addItem("Lower");
    ui->comboSL->addItem("Low");
    ui->comboSL->addItem("Below Normal");
    ui->comboSL->addItem("Normal");
    ui->comboSL->addItem("Above Normal");
    ui->comboSL->addItem("High");
    ui->comboSL->addItem("Higher");
    ui->comboSL->addItem("Highest");
    ui->comboSL->setCurrentIndex(4);

    ui->comboDataType->addItem("Handle in NBSPSDK");
    ui->comboDataType->addItem("Full FIR");
    ui->comboDataType->addItem("Text FIR");
    ui->comboDataType->addItem("Binary Stream");
    ui->comboDataType->addItem("Text Stream");
    ui->comboDataType->setCurrentIndex(0);

    m_hNBioBSP = NULL;
    m_hCapturedFIR = NULL;
    memset(&m_DeviceInfo, 0, sizeof(NBioAPI_DEVICE_INFO_0));

    InitNBSPSDK();

    // DeviceList
    NBioAPI_RETURN nRet = SetDeviceList();

    if (NBioAPIERROR_NONE != nRet)
        DisplayError(nRet);
    else
        ui->labelStatus->setText("eNBSP SDK Initialize Success");
}

NBioBSP_Demo::~NBioBSP_Demo()
{
    delete ui;
    TerminateNBSPSDK();
}

void NBioBSP_Demo::changeEvent(QEvent *e)
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


/////////////////////////////////////////////////////////////////
// NBioBSP_Demo class: Capture CallBack function

NBioAPI_RETURN MyCaptureCallback(NBioAPI_WINDOW_CALLBACK_PARAM_PTR_0 pCallbackParam, NBioAPI_VOID_PTR pUserParam)
{
    NBioBSP_Demo* pWidget = (NBioBSP_Demo*) pUserParam;

    pWidget->DrawFingerImage(pCallbackParam->lpImageBuf);

    return NBioAPIERROR_NONE;
}


/////////////////////////////////////////////////////////////////
// NBioBSP_Demo class: proteted member functions

void NBioBSP_Demo::DisplayError(NBioAPI_RETURN nRet)
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

void NBioBSP_Demo::InitNBSPSDK()
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

    szTitle.sprintf("NBioBSP_Demo eNBSP SDK version : %d.%04d", ver.Major, ver.Minor);
    setWindowTitle(szTitle);

    //Get Init module Information
    nRet = GetInitInfo();

    if (NBioAPIERROR_NONE != nRet)  {
        DisplayError(nRet);
        return ;
    }

    ui->btGetInit->setEnabled(TRUE);
    ui->btSetInit->setEnabled(TRUE);
    ui->btOpen->setEnabled(TRUE);
}

void NBioBSP_Demo::TerminateNBSPSDK()
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

NBioAPI_RETURN NBioBSP_Demo::GetInitInfo()
{
    NBioAPI_RETURN nRet;
    NBioAPI_INIT_INFO_0 init_info0;

    memset(&init_info0, 0, sizeof(init_info0));

    //Get NBioAPI initial information.
    nRet = NBioAPI_GetInitInfo(m_hNBioBSP, 0, &init_info0);

    if (NBioAPIERROR_NONE == nRet)  {
        ui->editEIQ->setText(QString("%1").arg(init_info0.EnrollImageQuality));
        ui->editVIQ->setText(QString("%1").arg(init_info0.VerifyImageQuality));
        ui->editMEF->setText(QString("%1").arg(init_info0.MaxFingersForEnroll));
        ui->editSPF->setText(QString("%1").arg(init_info0.SamplesPerFinger));
        ui->editDTO->setText(QString("%1").arg(init_info0.DefaultTimeout));
        ui->comboSL->setCurrentIndex(init_info0.SecurityLevel - 1);
    }

    return nRet;
}

NBioAPI_RETURN NBioBSP_Demo::SetInitInfo()
{
    NBioAPI_RETURN nRet;
    NBioAPI_INIT_INFO_0 init_info0;

    memset(&init_info0, 0, sizeof(init_info0));

    bool bOk;

    init_info0.StructureType = 0;

    init_info0.EnrollImageQuality = ui->editEIQ->text().toInt(&bOk);
    if (bOk == false)  {
        QMessageBox::warning(this, "NBioBSP_Demo", "Invalid Input value ==> EnrollImageQuality");
        return NBioAPIERROR_FUNCTION_FAIL;
    }

    init_info0.IdentifyImageQuality = 50;

    init_info0.VerifyImageQuality = ui->editVIQ->text().toInt(&bOk);
    if (bOk == false)  {
        QMessageBox::warning(this, "NBioBSP_Demo", "Invalid Input value ==> VerifyImageQuality");
        return NBioAPIERROR_FUNCTION_FAIL;
    }

    init_info0.MaxFingersForEnroll = ui->editMEF->text().toInt(&bOk);
    if (bOk == false)  {
        QMessageBox::warning(this, "NBioBSP_Demo", "Invalid Input value ==> MaxFingersForEnroll");
        return NBioAPIERROR_FUNCTION_FAIL;
    }

    init_info0.SamplesPerFinger = ui->editSPF->text().toInt(&bOk);
    if (bOk == false)  {
        QMessageBox::warning(this, "NBioBSP_Demo", "Invalid Input value ==> SamplesPerFinger");
        return NBioAPIERROR_FUNCTION_FAIL;
    }

    init_info0.DefaultTimeout = ui->editDTO->text().toInt(&bOk);
    if (bOk == false)  {
        QMessageBox::warning(this, "NBioBSP_Demo", "Invalid Input value ==> DefaultTimeout");
        return NBioAPIERROR_FUNCTION_FAIL;
    }

    init_info0.SecurityLevel = ui->comboSL->currentIndex() + 1;

    //Set NBioAPI Initial Information
    nRet = NBioAPI_SetInitInfo(m_hNBioBSP, 0, &init_info0);

    return nRet;
}

NBioAPI_RETURN NBioBSP_Demo::SetDeviceList()
{
    NBioAPI_UINT32 nDeviceCnt;                  // Device Total Count
    NBioAPI_DEVICE_ID* pDeviceList;             // Device ID
    NBioAPI_DEVICE_INFO_EX_PTR pDeviceInfoEx;   // Device Information

    //NBioAPI Enumerate Device List
    NBioAPI_RETURN nRet = NBioAPI_EnumerateDeviceEx(m_hNBioBSP, &nDeviceCnt, &pDeviceList, &pDeviceInfoEx);

    ui->comboDevice->clear();

    if (NBioAPIERROR_NONE == nRet)  {
        NBioAPI_UINT32 i;
        QString szDevice;
        NBioAPI_DEVICE_ID deviceID;

        //Add Device List
        ui->comboDevice->addItem("Auto_Detect", NBioAPI_DEVICE_ID_AUTO);

        for (i = 0; i < nDeviceCnt; i++)  {
            szDevice.sprintf("%s (ID: %02d)", pDeviceInfoEx[i].Name, pDeviceInfoEx[i].Instance);
            deviceID = pDeviceInfoEx[i].NameID | (pDeviceInfoEx[i].Instance << 8);
            ui->comboDevice->addItem(szDevice, deviceID);
        }

        ui->comboDevice->setCurrentIndex(0);
        ui->btOpen->setEnabled(TRUE);
    }

    return nRet;
}

NBioAPI_RETURN NBioBSP_Demo::OpenDevice()
{
    NBioAPI_RETURN nRet;
    NBioAPI_DEVICE_ID deviceID = NBioAPI_GetOpenedDeviceID(m_hNBioBSP);  //Get Device ID

    //Close Before Module Device.
    if (NBioAPI_DEVICE_ID_NONE != deviceID)
        NBioAPI_CloseDevice(m_hNBioBSP, deviceID);

    int nIndex = ui->comboDevice->currentIndex();
    deviceID = (NBioAPI_DEVICE_ID) ui->comboDevice->itemData(nIndex).toInt();

    //Open Device
    nRet = NBioAPI_OpenDevice(m_hNBioBSP, deviceID);

    ui->btCapture->setEnabled(FALSE);

    if (NBioAPIERROR_NONE == nRet)  {
        nRet = NBioAPI_GetDeviceInfo(m_hNBioBSP, deviceID, 0, &m_DeviceInfo);

        if (NBioAPIERROR_NONE == nRet)
            ui->btCapture->setEnabled(TRUE);
    }

    return nRet;
}

NBioAPI_RETURN NBioBSP_Demo::Capture()
{
    NBioAPI_RETURN nRet;

    m_bIsCapture = true;

    //Free FIR Handle
    if (m_hCapturedFIR)  {
        NBioAPI_FreeFIRHandle(m_hNBioBSP, m_hCapturedFIR);
        m_hCapturedFIR = NULL;
    }

    // Payload data
    QString szPayload = ui->editPayload->text();
    int nPayloadLen = 0;
    LPBYTE pPayload = NULL;

    if (szPayload.length() > 0)  {
        QByteArray baPayload;

        nPayloadLen = szPayload.length() + 1;

        pPayload = new unsigned char[nPayloadLen];
        memset(pPayload, 0, nPayloadLen);
        baPayload = szPayload.toLocal8Bit();

        strcpy((char*) pPayload, baPayload.data());
    }

    // Windows Option setting
    NBioAPI_WINDOW_OPTION winOption;

    memset(&winOption, 0, sizeof(NBioAPI_WINDOW_OPTION));
    winOption.Length = sizeof(NBioAPI_WINDOW_OPTION);
    winOption.CaptureCallBackInfo.CallBackType = 0;
    winOption.CaptureCallBackInfo.CallBackFunction = MyCaptureCallback;
    winOption.CaptureCallBackInfo.UserCallBackParam = this;

    NBioAPI_FIR_HANDLE hCapturedFIR1 = NBioAPI_INVALID_HANDLE;
    NBioAPI_FIR_HANDLE hCapturedFIR2 = NBioAPI_INVALID_HANDLE;
    NBioAPI_INPUT_FIR inputCapture1;
    NBioAPI_INPUT_FIR inputCapture2;

    //NBioAPI FIR Capture
    nRet = NBioAPI_Capture(m_hNBioBSP, NBioAPI_FIR_PURPOSE_VERIFY, &hCapturedFIR1, -1, NULL, &winOption);

    if (nRet == NBioAPIERROR_NONE)  {
        nRet = NBioAPI_Capture(m_hNBioBSP, NBioAPI_FIR_PURPOSE_VERIFY, &hCapturedFIR2, -1, NULL, &winOption);

        if (nRet == NBioAPIERROR_NONE)  {
            NBioAPI_BOOL bResult = NBioAPI_FALSE;

            inputCapture1.Form = NBioAPI_FIR_FORM_HANDLE;
            inputCapture1.InputFIR.FIRinBSP = &hCapturedFIR1;
            inputCapture2.Form = NBioAPI_FIR_FORM_HANDLE;
            inputCapture2.InputFIR.FIRinBSP = &hCapturedFIR2;

            nRet = NBioAPI_VerifyMatch(m_hNBioBSP, &inputCapture1, &inputCapture2, &bResult, NULL);

            if (nRet == NBioAPIERROR_NONE)  {
                if (bResult)  {
                    NBioAPI_FIR_PAYLOAD payload;

                    if (pPayload)  {
                        memset(&payload, 0, sizeof(NBioAPI_FIR_PAYLOAD));

                        payload.Length = nPayloadLen;
                        payload.Data = pPayload;
                    }

                    nRet =  NBioAPI_CreateTemplate(m_hNBioBSP, &inputCapture1, NULL, &m_hCapturedFIR, pPayload ? &payload : NULL);

                    if (nRet == NBioAPIERROR_NONE)
                        ui->labelStatus->setText("Enroll success");
                }
                else
                    ui->labelStatus->setText("The captured data not matched");
            }
        }
    }

    ui->btVerify->setEnabled(FALSE);

    if (nRet != NBioAPIERROR_NONE)
        DisplayError(nRet);
    else
        ui->btVerify->setEnabled(TRUE);

    if (pPayload)
        delete[] pPayload;

    return nRet;
}

NBioAPI_RETURN NBioBSP_Demo::Verify()
{
    NBioAPI_RETURN nRet;
    NBioAPI_FIR fullFIR;
    NBioAPI_FIR_TEXTENCODE textFIR;	//In coding Text FIR
    NBioAPI_INPUT_FIR inputFIR;
    bool bDeleteFIR = false;
    bool bDeleteTextFIR = false;
    bool bFreeFIR = false;
    bool bFreeTextFIR = false;

    m_bIsCapture = false;

    //Get FIR Data Type.
    int nIndex = ui->comboDataType->currentIndex();

    switch (nIndex)  {
        case 0:
        {
            inputFIR.Form = NBioAPI_FIR_FORM_HANDLE;
            inputFIR.InputFIR.FIRinBSP = &m_hCapturedFIR;
            nRet = NBioAPIERROR_NONE;
        }
        break;

        case 1:
        {
            inputFIR.Form = NBioAPI_FIR_FORM_FULLFIR;
            inputFIR.InputFIR.FIR = &fullFIR;
            memset(&fullFIR, 0, sizeof(NBioAPI_FIR));

            //Get ExtendFIR data
            nRet = NBioAPI_GetExtendedFIRFromHandle(m_hNBioBSP, m_hCapturedFIR, &fullFIR, NBioAPI_FIR_FORMAT_STANDARD);

            if (NBioAPIERROR_NONE == nRet)
                bFreeFIR = true;
        }
        break;

        case 2:
        {
            // Shows how to convert TextFIR ==> Binary Stream
            inputFIR.Form = NBioAPI_FIR_FORM_TEXTENCODE;
            inputFIR.InputFIR.FIR = &textFIR;
            memset(&textFIR, 0, sizeof(NBioAPI_FIR_TEXTENCODE));

            //Get ExtendText FIR data from Handle
            nRet = NBioAPI_GetExtendedTextFIRFromHandle(m_hNBioBSP, m_hCapturedFIR, &textFIR, NBioAPI_FALSE, NBioAPI_FIR_FORMAT_STANDARD);

            if (NBioAPIERROR_NONE == nRet)  {
                LPBYTE pBinaryTextFIR = NULL;
                size_t dwLen = strlen(textFIR.TextFIR);

                pBinaryTextFIR = new unsigned char[dwLen];

                if (pBinaryTextFIR)  {
                    MakeStreamFromTextFIR(&textFIR, pBinaryTextFIR);

                    //NBioAPI Free Payload
                    NBioAPI_FreeTextFIR(m_hNBioBSP, &textFIR);

                    // pBinaryTextFIR save in DB or ....
                    // ......


                    // Make TextFIR from DB or ....
                    MakeTextFIRFromStream(pBinaryTextFIR, &textFIR);
                    textFIR.IsWideChar = NBioAPI_FALSE;
                    delete[] pBinaryTextFIR;
                    bDeleteTextFIR = true;
                }
            }
        }
        break;

        case 3:
        {
            // Shows how to convert TextFIR ==> Binary Stream
            inputFIR.Form = NBioAPI_FIR_FORM_TEXTENCODE;
            inputFIR.InputFIR.FIR = &textFIR;
            memset(&textFIR, 0, sizeof(NBioAPI_FIR_TEXTENCODE));

            //Get extended text FIR from Handle
            nRet = NBioAPI_GetExtendedTextFIRFromHandle(m_hNBioBSP, m_hCapturedFIR, &textFIR, NBioAPI_FALSE, NBioAPI_FIR_FORMAT_STANDARD);

            if (NBioAPIERROR_NONE == nRet)
                bFreeTextFIR = true;
        }
        break;

        case 4:
        {
            inputFIR.Form = NBioAPI_FIR_FORM_FULLFIR;
            inputFIR.InputFIR.FIR = &fullFIR;
            memset(&fullFIR, 0, sizeof(NBioAPI_FIR));

            //Get ExtendFIR data
            nRet = NBioAPI_GetExtendedFIRFromHandle(m_hNBioBSP, m_hCapturedFIR, &fullFIR, NBioAPI_FIR_FORMAT_STANDARD);

            if (NBioAPIERROR_NONE == nRet)  {
                LPBYTE pBinaryFullFIR = NULL;
                size_t dwLen = fullFIR.Header.DataLength + fullFIR.Header.Length + sizeof(NBioAPI_FIR_FORMAT);

                pBinaryFullFIR = new unsigned char[dwLen];

                if (pBinaryFullFIR)  {
                    //Make Stream file from FIR
                    MakeStreamFromFIR(&fullFIR, pBinaryFullFIR);

                    //Free NBioAPI
                    NBioAPI_FreeFIR(m_hNBioBSP, &fullFIR);

                    // pBinaryFullFIR save in DB or ....
                    // ......


                    // Make FullFIR from DB or ....
                    MakeFIRFromStream(pBinaryFullFIR, &fullFIR);
                    delete[] pBinaryFullFIR;

                    bDeleteFIR = true;
                }
            }
        }
        break;

        default:
        ui->labelStatus->setText("Undefined FIR data format");
        nRet = NBioAPIERROR_UNKNOWN_FORMAT;
        break;
    }

    if (NBioAPIERROR_NONE == nRet)  {
        NBioAPI_BOOL bMatchRet;
        NBioAPI_FIR_PAYLOAD payLoad;

        // Windows Option setting
        NBioAPI_WINDOW_OPTION winOption;

        memset(&winOption, 0, sizeof(NBioAPI_WINDOW_OPTION));
        winOption.Length = sizeof(NBioAPI_WINDOW_OPTION);
        winOption.CaptureCallBackInfo.CallBackType = 0;
        winOption.CaptureCallBackInfo.CallBackFunction = MyCaptureCallback;
        winOption.CaptureCallBackInfo.UserCallBackParam = this;

        //NBioAPI FIR Verify
        nRet = NBioAPI_Verify(m_hNBioBSP, &inputFIR, &bMatchRet, &payLoad, -1, NULL, &winOption);

        if (NBioAPIERROR_NONE == nRet)  {
            if (bMatchRet)  {
                QString szPayLoad;

                ui->labelStatus->setText("Verify Success!!");

                if (payLoad.Length > 0)  {
                    szPayLoad.sprintf("There is payload in template[Payload: %s]", (char*) payLoad.Data);

                    //NBioAPI Free Payload
                    NBioAPI_FreePayload(m_hNBioBSP, &payLoad);
                    QMessageBox::information(this, "NBioBSP_Demo", szPayLoad);
                }
            }
            else  {
                ui->labelStatus->setText("Verify Failed!!");
            }
        }
    }

    if (bDeleteFIR)  {
        if (fullFIR.Data)
            delete[] fullFIR.Data;
    }

    if (bDeleteTextFIR)  {
        if (textFIR.TextFIR)
        delete[] textFIR.TextFIR;
    }

    //Free FIR Memory
    if (bFreeFIR)
        NBioAPI_FreeFIR(m_hNBioBSP, &fullFIR);

    //Free TextFIR Memory
    if (bFreeTextFIR)
        NBioAPI_FreeTextFIR(m_hNBioBSP, &textFIR);

    return nRet;
}

void NBioBSP_Demo::MakeStreamFromFIR(NBioAPI_FIR_PTR pFullFIR, LPBYTE pBinaryStream)
{
   memcpy(pBinaryStream, &pFullFIR->Format, sizeof(NBioAPI_FIR_FORMAT) + pFullFIR->Header.Length);
   memcpy(pBinaryStream + sizeof(NBioAPI_FIR_FORMAT) + pFullFIR->Header.Length, pFullFIR->Data, pFullFIR->Header.DataLength);
}

void NBioBSP_Demo::MakeFIRFromStream(LPBYTE pBinaryStream, NBioAPI_FIR_PTR pFullFIR)
{
   memcpy(&pFullFIR->Format, pBinaryStream, sizeof(NBioAPI_FIR_FORMAT));
   memcpy(&pFullFIR->Header, pBinaryStream + sizeof(NBioAPI_FIR_FORMAT), sizeof(pFullFIR->Header));

   pFullFIR->Data = new unsigned char[pFullFIR->Header.DataLength];
   memcpy(pFullFIR->Data, pBinaryStream + sizeof(NBioAPI_FIR_FORMAT) + pFullFIR->Header.Length, pFullFIR->Header.DataLength);
}

void NBioBSP_Demo::MakeStreamFromTextFIR(NBioAPI_FIR_TEXTENCODE_PTR pTextFIR, LPBYTE pTextStream)
{
   memcpy(pTextStream, pTextFIR->TextFIR, strlen(pTextFIR->TextFIR));
}

void NBioBSP_Demo::MakeTextFIRFromStream(LPBYTE pTextStream, NBioAPI_FIR_TEXTENCODE_PTR pTextFIR)
{
   pTextFIR->TextFIR = new CHAR[strlen((CHAR*) pTextStream)];
   memcpy(pTextFIR->TextFIR, pTextStream, strlen((CHAR*) pTextStream));
}


/////////////////////////////////////////////////////////////////
// NBioBSP_Demo class: public member functions

void NBioBSP_Demo::DrawFingerImage(LPBYTE pImageBuf)
{
    QImage DrawImage = QImage(pImageBuf, m_DeviceInfo.ImageWidth, m_DeviceInfo.ImageHeight, QImage::Format_Indexed8);
    DrawImage.setColorTable(colorTable);
    QImage scalImage = DrawImage.scaled(200, 200, Qt::IgnoreAspectRatio);

    if (m_bIsCapture)  {
        ui->FPReg->setPixmap(QPixmap::fromImage(scalImage, Qt::NoOpaqueDetection));
        ui->FPReg->repaint();
    }
    else  {
        ui->FPVerify->setPixmap(QPixmap::fromImage(scalImage, Qt::NoOpaqueDetection));
        ui->FPVerify->repaint();
    }
}

/////////////////////////////////////////////////////////////////
// NBioBSP_Demo class: slots functions

void NBioBSP_Demo::on_btSetInit_pressed()
{
    //Set NBioAPI Module Initial Information
    NBioAPI_RETURN nRet = SetInitInfo();

    if (NBioAPIERROR_NONE != nRet)
        DisplayError(nRet);
    else
        ui->labelStatus->setText("SetInitInfo API Success");
}

void NBioBSP_Demo::on_btGetInit_pressed()
{
    //Get NBioAPI Module Initial Information
    NBioAPI_RETURN nRet = GetInitInfo();

    if (NBioAPIERROR_NONE != nRet)
        DisplayError(nRet);
    else
        ui->labelStatus->setText("GetInitInfo API Success");
}

void NBioBSP_Demo::on_btOpen_pressed()
{
    //Device Open.
    NBioAPI_RETURN nRet = OpenDevice();

    if (NBioAPIERROR_NONE != nRet)
        DisplayError(nRet);
    else
        ui->labelStatus->setText("Open Device API Success");
}

void NBioBSP_Demo::on_btCapture_pressed()
{
    //Capture.
    NBioAPI_RETURN nRet = Capture();

    if (NBioAPIERROR_NONE != nRet)
        DisplayError(nRet);
}

void NBioBSP_Demo::on_btVerify_pressed()
{
    //Verify.
    NBioAPI_RETURN nRet = Verify();

    if (NBioAPIERROR_NONE != nRet)
        DisplayError(nRet);
}

