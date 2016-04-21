/************************************************************************
** COPYRIGHT (C) 2011 NITGEN&COMPANY
**
** THIS WORK CONTAINS TRADE SECRET AND PROPRIETARY INFORMATION WHICH IS
** THE PROPERTY OF NITGEN&COMPANY
**
** PROJECT NAME: eNBSP SDK
**
** FILE NAME: NBioBSP_DataConvert.cpp
**
** PURPOSE:
**
** FUNCTIONS:
**
** AUTHOR: chul
**
** VERSION:
**
** LAST MODIFIED: [2011-3-15 11:05 by chul]
**
*************************************************************************/
/*************************************************************************
NOTE:

*************************************************************************/

#include "nbiobsp_dataconvert.h"
#include "ui_nbiobsp_dataconvert.h"
#include "qmessagebox.h"
#include "qfiledialog.h"

NBioBSP_DataConvert::NBioBSP_DataConvert(QWidget *parent) :
    QDialog(parent),
    ui(new Ui::NBioBSP_DataConvert)
{
    ui->setupUi(this);

    colorTable.resize(256);

    for (int i = 0; i < 256; i++)
        colorTable[i] = qRgb(i,i,i);

    m_hNBioBSP = NULL;
    m_pTemplate = NULL;
    m_nLen = 0;
    memset(&m_DeviceInfo, 0, sizeof(NBioAPI_DEVICE_INFO_0));
    memset(&m_ExportData, 0, sizeof(NBioAPI_EXPORT_DATA));

    ui->rdExport->setChecked(true);
    ui->rdImport->setChecked(false);
    ui->comboDataType->setCurrentIndex(0);
    ui->editTemplateSize->setText("320");
    ui->editTemplateSize->setEnabled(false);

    InitNBSPSDK();
}

NBioBSP_DataConvert::~NBioBSP_DataConvert()
{
    delete ui;
    TerminateNBSPSDK();
}

void NBioBSP_DataConvert::changeEvent(QEvent *e)
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
// NBioBSP_DataConvert class: Capture CallBack function

NBioAPI_RETURN MyCaptureCallback(NBioAPI_WINDOW_CALLBACK_PARAM_PTR_0 pCallbackParam, NBioAPI_VOID_PTR pUserParam)
{
    NBioBSP_DataConvert* pWidget = (NBioBSP_DataConvert*) pUserParam;

    pWidget->DrawFingerImage(pCallbackParam->lpImageBuf);

    return NBioAPIERROR_NONE;
}


/////////////////////////////////////////////////////////////////
// NBioBSP_DataConvert class: proteted member functions

void NBioBSP_DataConvert::DisplayError(NBioAPI_RETURN nRet)
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

void NBioBSP_DataConvert::InitNBSPSDK()
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

    ui->labelStatus->setText("eNBSP SDK Initialize Success");
}

void NBioBSP_DataConvert::TerminateNBSPSDK()
{
    //Free FIR Handle.
    if (m_hNBioBSP)  {
        if (m_ExportData.FingerNum > 0)
            NBioAPI_FreeExportData(m_hNBioBSP, &m_ExportData);

        if (m_pTemplate)
            delete[] m_pTemplate;

        //NBioAPI Terminate
        NBioAPI_Terminate(m_hNBioBSP);
    }
}

MINCONV_DATA_TYPE NBioBSP_DataConvert::GetDataType()
{
    MINCONV_DATA_TYPE type;

    int nIndex = ui->comboDataType->currentIndex();

    //Select Data Type
    switch (nIndex)  {
        case 0:
        type = MINCONV_TYPE_FDP;
        break;

        case 1:
        type = MINCONV_TYPE_FDA;
        break;

        case 2:
        type = MINCONV_TYPE_OLD_FDA;
        break;

        case 3:
        type = MINCONV_TYPE_FDAC;
        break;

        case 4:
        type = MINCONV_TYPE_FIM10_HV;
        break;

        case 5:
        type = MINCONV_TYPE_FIM01_HV;
        break;

        case 6:
        type = MINCONV_TYPE_FIM01_HD;
        break;

        case 7:
        type = MINCONV_TYPE_FELICA;
        break;

        case 8:
        type = MINCONV_TYPE_EXTENSION;
        break;

        case 9:
        {
            bool bOk;

            int nDataSize = ui->editTemplateSize->text().toInt(&bOk);

            if (bOk == false)
                type = MINCONV_TYPE_MAX;
            else  {
                if ((nDataSize % 16) != 0 || nDataSize < 32)
                    type = MINCONV_TYPE_MAX;
                else
                    type = (MINCONV_DATA_TYPE)(MINCONV_TYPE_TEMPLATESIZE_32 + ((nDataSize - 32) / 16));
            }
        }
        break;

        case 10:
        type = MINCONV_TYPE_ANSI;
        break;

        case 11:
        type = MINCONV_TYPE_ISO;
        break;
    }

    return type;
}


/////////////////////////////////////////////////////////////////
// NBioBSP_DataConvert class: public member functions

void NBioBSP_DataConvert::DrawFingerImage(unsigned char* pImageBuf)
{
    QImage DrawImage = QImage(pImageBuf, m_DeviceInfo.ImageWidth, m_DeviceInfo.ImageHeight, QImage::Format_Indexed8);
    DrawImage.setColorTable(colorTable);
    QImage scalImage = DrawImage.scaled(200, 200, Qt::IgnoreAspectRatio);

    ui->labelFP->setPixmap(QPixmap::fromImage(scalImage, Qt::NoOpaqueDetection));
    ui->labelFP->repaint();
}


void NBioBSP_DataConvert::on_rdExport_toggled(bool checked)
{
    if (checked)  {
        ui->btExport->setEnabled(true);
        ui->btSave->setEnabled(false);
        ui->btImport->setEnabled(false);
        ui->btLoad->setEnabled(false);

        if (ui->comboDataType->currentIndex() == 9)  {
            ui->editTemplateSize->setEnabled(true);
            ui->editTemplateSize->setFocus();
        }
    }
}

void NBioBSP_DataConvert::on_rdImport_toggled(bool checked)
{
    if (checked)  {
        ui->btExport->setEnabled(false);
        ui->btSave->setEnabled(false);
        ui->btImport->setEnabled(false);
        ui->btLoad->setEnabled(true);

        if (ui->comboDataType->currentIndex() == 9)  {
            ui->editTemplateSize->setEnabled(true);
            ui->editTemplateSize->setFocus();
        }
    }
}

void NBioBSP_DataConvert::on_comboDataType_currentIndexChanged(int index)
{
    if (index == 9)  {
        ui->editTemplateSize->setEnabled(true);
        ui->editTemplateSize->setFocus();
    }
    else
        ui->editTemplateSize->setEnabled(false);
}

void NBioBSP_DataConvert::on_btExport_pressed()
{
    ui->btSave->setEnabled(false);

    //NBioAPI Open Device
    NBioAPI_RETURN nRet = NBioAPI_OpenDevice(m_hNBioBSP, NBioAPI_DEVICE_ID_AUTO);

    if (NBioAPIERROR_NONE == nRet)  {
        nRet = NBioAPI_GetDeviceInfo(m_hNBioBSP, NBioAPI_GetOpenedDeviceID(m_hNBioBSP), 0, &m_DeviceInfo);

        if (NBioAPIERROR_NONE != nRet)
            NBioAPI_CloseDevice(m_hNBioBSP, NBioAPI_DEVICE_ID_AUTO);
    }

    if (NBioAPIERROR_NONE == nRet)  {
        NBioAPI_FIR_HANDLE hCaptured;
        NBioAPI_WINDOW_OPTION winOption;

        memset(&winOption, 0, sizeof(NBioAPI_WINDOW_OPTION));
        winOption.Length = sizeof(NBioAPI_WINDOW_OPTION);
        winOption.CaptureCallBackInfo.CallBackType = 0;
        winOption.CaptureCallBackInfo.CallBackFunction = MyCaptureCallback;
        winOption.CaptureCallBackInfo.UserCallBackParam = this;

        //NBioAPI Capture.
        nRet = NBioAPI_Capture(m_hNBioBSP, NBioAPI_FIR_PURPOSE_VERIFY, &hCaptured, -1, NULL, &winOption);

        if (NBioAPIERROR_NONE == nRet)  {
            MINCONV_DATA_TYPE type = GetDataType();

            if (MINCONV_TYPE_MAX == type)
                QMessageBox::warning(this, "NBioBSP_DataConvert", "Variable length of template must be set to multiple of 16 and minimum 32.");
            else  {
                NBioAPI_INPUT_FIR inputFIR;	//FIR Information.

                if (m_ExportData.FingerNum > 0)
                    NBioAPI_FreeExportData(m_hNBioBSP, &m_ExportData);

                memset(&m_ExportData, 0, sizeof(NBioAPI_EXPORT_DATA));

                inputFIR.Form = NBioAPI_FIR_FORM_HANDLE;
                inputFIR.InputFIR.FIRinBSP = &hCaptured;

                //FIR Data Convert to FDX Data
                nRet = NBioAPI_NBioBSPToFDx(m_hNBioBSP, &inputFIR, &m_ExportData, type);

                if (NBioAPIERROR_NONE == nRet)  {
                    ui->btSave->setEnabled(true);
                    ui->labelStatus->setText("NBioAPI_NBioBSPToFDx success");
                }
                else
                    DisplayError(nRet);
            }

            //FIR Handle Free
            NBioAPI_FreeFIRHandle(m_hNBioBSP, hCaptured);
        }
        else
            DisplayError(nRet);

        // Close Device.
        NBioAPI_CloseDevice(m_hNBioBSP, NBioAPI_DEVICE_ID_AUTO);
    }
    else
        DisplayError(nRet);
}

void NBioBSP_DataConvert::on_btSave_pressed()
{
    if (m_ExportData.FingerNum > 0)  {
        QString szSaveFileName = QDir::currentPath() + "/SaveMin.min";
        QString szFilePath = QFileDialog::getSaveFileName(this, "Save template file", szSaveFileName, "template file(*.min)");

        if (!szFilePath.isEmpty())  {
            FILE* fp;
            QByteArray baFilePath = szFilePath.toLocal8Bit();

            fp = fopen(baFilePath.data(), "wb");

            if (fp)  {
                fwrite(m_ExportData.FingerData2[0].Template[0].Data, m_ExportData.FingerData2[0].Template[0].Length, 1, fp);
                fclose(fp);
                ui->labelStatus->setText("Success to save data");
            }
            else
                ui->labelStatus->setText("Failed to save data");
        }
    }
    else
        QMessageBox::warning(this, "NBioBSP_DataConvert", "Can not find export data!!");
}

void NBioBSP_DataConvert::on_btLoad_pressed()
{
    QString szFilePath = QFileDialog::getOpenFileName(this, "Load template file", QDir::currentPath(), "template file(*.min)");
    ui->btImport->setEnabled(false);

    if (!szFilePath.isEmpty())  {
        FILE* fp;
        QByteArray baFilePath = szFilePath.toLocal8Bit();

        fp = fopen(baFilePath.data(), "rb");

        if (fp)  {
            fseek(fp, 0L, SEEK_END);
            m_nLen = ftell(fp);
            fseek(fp, 0L, SEEK_SET);

            if (m_pTemplate)
                delete[] m_pTemplate;

            m_pTemplate = new NBioAPI_UINT8[m_nLen];

            fread(m_pTemplate, m_nLen, 1, fp);
            fclose(fp);

            ui->labelStatus->setText(QString("Load success! (size : %1bytes)").arg(m_nLen));
            ui->btImport->setEnabled(true);
        }
        else
            ui->labelStatus->setText("File open failed");
    }
}

void NBioBSP_DataConvert::on_btImport_pressed()
{
    if (m_pTemplate == NULL || m_nLen == 0)  {
        ui->labelStatus->setText("Load data file first.");
        return;
    }

    MINCONV_DATA_TYPE type = GetDataType();

    if (MINCONV_TYPE_MAX == type)
        QMessageBox::warning(this, "NBioBSP_DataConvert", "Variable length of template must be set to multiple of 16 and minimum 32.");
    else  {
        NBioAPI_FIR_HANDLE hProcessedFIR;

        //FDX data Convert FIR data
        NBioAPI_RETURN nRet = NBioAPI_FDxToNBioBSP(m_hNBioBSP, m_pTemplate, m_nLen, type, NBioAPI_FIR_PURPOSE_VERIFY, &hProcessedFIR);

        if (NBioAPIERROR_NONE == nRet)  {
            NBioAPI_INPUT_FIR inputFIR;
            NBioAPI_BOOL bResult;

            inputFIR.Form = NBioAPI_FIR_FORM_HANDLE;
            inputFIR.InputFIR.FIRinBSP = &hProcessedFIR;

            //Device Open.
            nRet = NBioAPI_OpenDevice(m_hNBioBSP, NBioAPI_DEVICE_ID_AUTO);

            if (NBioAPIERROR_NONE == nRet)  {
                nRet = NBioAPI_GetDeviceInfo(m_hNBioBSP, NBioAPI_GetOpenedDeviceID(m_hNBioBSP), 0, &m_DeviceInfo);

                if (NBioAPIERROR_NONE != nRet)
                    NBioAPI_CloseDevice(m_hNBioBSP, NBioAPI_DEVICE_ID_AUTO);
            }

            //NBioAPI Verify
            if (NBioAPIERROR_NONE == nRet)  {
                NBioAPI_WINDOW_OPTION winOption;

                memset(&winOption, 0, sizeof(NBioAPI_WINDOW_OPTION));
                winOption.Length = sizeof(NBioAPI_WINDOW_OPTION);
                winOption.CaptureCallBackInfo.CallBackType = 0;
                winOption.CaptureCallBackInfo.CallBackFunction = MyCaptureCallback;
                winOption.CaptureCallBackInfo.UserCallBackParam = this;

                nRet = NBioAPI_Verify(m_hNBioBSP, &inputFIR, &bResult, NULL, -1, NULL, &winOption);

                // Close Device
                NBioAPI_CloseDevice(m_hNBioBSP, NBioAPI_DEVICE_ID_AUTO);

                if (NBioAPIERROR_NONE == nRet)  {
                    if (NBioAPI_FALSE != bResult)
                        ui->labelStatus->setText("Convert data matching success");
                    else
                        ui->labelStatus->setText("Convert data matching fail");
                }
                else
                    DisplayError(nRet);
            }
            else
                DisplayError(nRet);

            //FIR Handle Free
            NBioAPI_FreeFIRHandle(m_hNBioBSP, hProcessedFIR);
        }
        else
            DisplayError(nRet);
    }
}
