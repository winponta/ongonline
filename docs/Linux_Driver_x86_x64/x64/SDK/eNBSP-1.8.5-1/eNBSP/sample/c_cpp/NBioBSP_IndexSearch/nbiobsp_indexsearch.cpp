/************************************************************************
** COPYRIGHT (C) 2011 NITGEN&COMPANY
**
** THIS WORK CONTAINS TRADE SECRET AND PROPRIETARY INFORMATION WHICH IS
** THE PROPERTY OF NITGEN&COMPANY
**
** PROJECT NAME: eNBSP SDK
**
** FILE NAME: NBioBSP_IndexSearch.cpp
**
** PURPOSE: IndexSearch test
**
** FUNCTIONS:
**
** AUTHOR: chul
**
** VERSION:
**
** LAST MODIFIED: [2011-3-17 15:51 by chul]
**
*************************************************************************/
/*************************************************************************
NOTE:

*************************************************************************/

#include "nbiobsp_indexsearch.h"
#include "ui_nbiobsp_indexsearch.h"
#include "qmessagebox.h"
#include "qfiledialog.h"
#include "qdatetime.h"

NBioBSP_IndexSearch::NBioBSP_IndexSearch(QWidget *parent) :
    QDialog(parent),
    ui(new Ui::NBioBSP_IndexSearch)
{
    ui->setupUi(this);

    m_hNBioBSP = NBioAPI_INVALID_HANDLE;

    pRegModel = new QStandardItemModel(0, 3, this);
    pRegModel->setHeaderData(0, Qt::Horizontal, "User ID");
    pRegModel->setHeaderData(1, Qt::Horizontal, "FP ID");
    pRegModel->setHeaderData(2, Qt::Horizontal, "Sample No.");
    ui->tableReg->setModel(pRegModel);
    ui->tableReg->horizontalHeader()->setStretchLastSection(true);

    pSearchModel = new QStandardItemModel(0, 4, this);
    pSearchModel->setHeaderData(0, Qt::Horizontal, "User ID");
    pSearchModel->setHeaderData(1, Qt::Horizontal, "FP ID");
    pSearchModel->setHeaderData(2, Qt::Horizontal, "Sample No.");
    pSearchModel->setHeaderData(3, Qt::Horizontal, "Confidence");
    ui->tableSearch->setModel(pSearchModel);
    ui->tableSearch->horizontalHeader()->setStretchLastSection(true);

    m_nUserID = 1;
    ui->editUserID->setText(QString("%1").arg(m_nUserID));

    NBSPSDKInit();
}

NBioBSP_IndexSearch::~NBioBSP_IndexSearch()
{
    delete ui;

    NBSPDSKTerminate();
}

void NBioBSP_IndexSearch::changeEvent(QEvent *e)
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
// NBioBSP_DataConvert class: Global CallBack Functions

NBioAPI_RETURN MyIndexSearchCallBack(NBioAPI_INDEXSEARCH_CALLBACK_PARAM_PTR_0 pCallbackParam0, NBioAPI_VOID_PTR pUserParam)
{
    NBioBSP_IndexSearch* pDlg = (NBioBSP_IndexSearch*) pUserParam;

    return pDlg->MyCallBackFun(pCallbackParam0);
}

/////////////////////////////////////////////////////////////////
// NBioBSP_DataConvert class: public member functions

NBioAPI_RETURN NBioBSP_IndexSearch::MyCallBackFun(NBioAPI_INDEXSEARCH_CALLBACK_PARAM_PTR_0 pCallbackParam0)
{
    ui->labelCallback->setText(QString("%1) ID:%2 / Finger#:%3 / Sample#:%4").arg(pCallbackParam0->ProgressPos + 1).arg(pCallbackParam0->FpInfo.ID).arg(pCallbackParam0->FpInfo.FingerID).arg(pCallbackParam0->FpInfo.SampleNumber));
    ui->pgbarSearch->setValue(pCallbackParam0->ProgressPos + 1);

    QApplication::processEvents();

    if (m_bStopFlag)
        return NBioAPI_INDEXSEARCH_CALLBACK_STOP;

    return NBioAPI_INDEXSEARCH_CALLBACK_OK;
}

/////////////////////////////////////////////////////////////////
// NBioBSP_DataConvert class: proteted member functions

NBioAPI_RETURN NBioBSP_IndexSearch::NBSPSDKInit()
{
    // Get Initial return values.
    NBioAPI_RETURN nRet = NBioAPI_Init(&m_hNBioBSP);

    if (NBioAPIERROR_NONE == nRet)  {
        //InitIndex Search Engine.
        nRet = NBioAPI_InitIndexSearchEngine(m_hNBioBSP);

        if (NBioAPIERROR_NONE != nRet)  {
            QString szError;

            szError.sprintf("NBioAPI_InitIndexSearchEngine error: %04X", nRet);
            QMessageBox::warning(this, "NBioBSP_IndexSearch", szError);
        }
        else  {
            NBioAPI_VERSION ver;

            // Get NBioAPI Version.
            nRet = NBioAPI_GetVersion(m_hNBioBSP, &ver);

            if (NBioAPIERROR_NONE == nRet)  {
                QString szMsg;

                szMsg.sprintf("NBioBSP_IndexSearch eNBSP SDK Version : v%d.%04d", ver.Major, ver.Minor);
                setWindowTitle(szMsg);
            }

            ui->labelStatus->setText("eNBSP SDK Initialize Success");
            ui->btReg->setEnabled(true);
            ui->btLoadFIR->setEnabled(true);
            ui->btLoadMIN->setEnabled(true);
            ui->btLoadDB->setEnabled(true);
            ui->btSaveDB->setEnabled(true);
            ui->btClearDB->setEnabled(true);
            ui->btRmDB->setEnabled(true);
            ui->btIdentify->setEnabled(true);
        }
    }
    else  {
        QString szError;

        szError.sprintf("NBioAPI_Init error: %04X", nRet);
        QMessageBox::warning(this, "NBioBSP_IndexSearch", szError);
    }

    return nRet;
}

void NBioBSP_IndexSearch::NBSPDSKTerminate()
{
    //NBSPDSK Terminate.
    if (m_hNBioBSP)  {
        NBioAPI_ClearIndexSearchDB(m_hNBioBSP);
        NBioAPI_TerminateIndexSearchEngine(m_hNBioBSP);
        NBioAPI_Terminate(m_hNBioBSP);
    }
}

void NBioBSP_IndexSearch::UpdateTotalCount()
{
    NBioAPI_UINT32 nDataCnt = 0;

    NBioAPI_RETURN nRet = NBioAPI_GetDataCountFromIndexSearchDB(m_hNBioBSP, &nDataCnt);

    if (NBioAPIERROR_NONE == nRet)
        ui->labelTotalCnt->setText(QString("Total data Count: %1").arg(nDataCnt));
    else  {
        QString szError;

        szError.sprintf("NBioAPI_GetDataCountFromIndexSearchDB error: %04X", nRet);
        ui->labelStatus->setText(szError);
    }
}

/////////////////////////////////////////////////////////////////
// NBioBSP_DataConvert class: slots functions

void NBioBSP_IndexSearch::on_btReg_pressed()
{
    bool bOK;

    m_nUserID = ui->editUserID->text().toInt(&bOK);

    if (!bOK)  {
        QMessageBox::warning(this, "NBioBSP_IndexSearch", "Invalid User ID");
        ui->editUserID->setFocus();
        return ;
    }

    // Open Device.
    NBioAPI_RETURN nRet = NBioAPI_OpenDevice(m_hNBioBSP, NBioAPI_DEVICE_ID_AUTO);

    if (NBioAPIERROR_NONE != nRet)  {
        QString szError;

        szError.sprintf("NBioAPI_OpenDevice error: %04X", nRet);
        ui->labelStatus->setText(szError);
        return ;
    }

    NBioAPI_FIR_HANDLE hFIR;

    // NBioAPI Enroll.
    nRet = NBioAPI_Capture(m_hNBioBSP, NBioAPI_FIR_PURPOSE_VERIFY, &hFIR, -1, NULL, NULL);

    if (NBioAPIERROR_NONE == nRet)  {
        NBioAPI_INPUT_FIR inputFIR;                         // Fir Data.
        NBioAPI_INDEXSEARCH_SAMPLE_INFO infoSample;         // Sample Finger Sample Information.

        inputFIR.Form = NBioAPI_FIR_FORM_HANDLE;
        inputFIR.InputFIR.FIRinBSP = &hFIR;

        // Search FIRDB about Template Information.
        nRet = NBioAPI_AddFIRToIndexSearchDB(m_hNBioBSP, &inputFIR, m_nUserID, &infoSample);

        if (NBioAPIERROR_NONE != nRet)  {
            QString szError;

            szError.sprintf("NBioAPI_AddFIRToIndexSearchDB error: %04X", nRet);
            ui->labelStatus->setText(szError);
        }
        else  {
            int nIndex = pRegModel->rowCount();

            pRegModel->insertRow(nIndex, QModelIndex());
            pRegModel->setData(pRegModel->index(nIndex, 0, QModelIndex()), infoSample.ID);
            pRegModel->setData(pRegModel->index(nIndex, 1, QModelIndex()), 0);
            pRegModel->setData(pRegModel->index(nIndex, 2, QModelIndex()), 0);

            ui->labelStatus->setText("Successfully added to DB!");
        }

        //Free FIR Handle.
        NBioAPI_FreeFIRHandle(m_hNBioBSP, hFIR);
    }
    else  {
        QString szError;

        szError.sprintf("NBioAPI_Capture error: %04X", nRet);
        ui->labelStatus->setText(szError);
    }

    //Close Device.
    NBioAPI_CloseDevice(m_hNBioBSP, NBioAPI_DEVICE_ID_AUTO);

    if (NBioAPIERROR_NONE == nRet)  {
        m_nUserID++;
        ui->editUserID->setText(QString("%1").arg(m_nUserID));
    }

    UpdateTotalCount();
}

void NBioBSP_IndexSearch::on_btLoadFIR_pressed()
{
    QString szDir = QFileDialog::getExistingDirectory(this, "Select FIR data Directory", QDir::currentPath());

    if (szDir.isEmpty())
        return ;

    QDir dirFind = QDir(szDir);
    QStringList slFindFiles;

    slFindFiles = dirFind.entryList(QStringList("*.FIR"), QDir::Files | QDir::NoSymLinks);

    if (slFindFiles.size() > 0)  {
        NBioAPI_RETURN nRet = NBioAPIERROR_NONE;
        NBioAPI_FIR_TEXTENCODE hTextFIR;
        QString szFilePath;
        QByteArray baFilePath;
        FILE* fp;
        NBioAPI_UINT32 dwLen, nUserID;
        NBioAPI_INPUT_FIR inputFIR;
        NBioAPI_INDEXSEARCH_SAMPLE_INFO infoSample;

        memset(&hTextFIR, 0, sizeof(NBioAPI_FIR_TEXTENCODE));
        hTextFIR.IsWideChar = FALSE;

        inputFIR.Form = NBioAPI_FIR_FORM_TEXTENCODE;
        inputFIR.InputFIR.TextFIR = &hTextFIR;

        ui->pgBarLoad->setRange(0, slFindFiles.size());
        ui->pgBarLoad->setValue(0);

        for (int i = 0; i < slFindFiles.size(); i++)  {
            szFilePath = dirFind.absoluteFilePath(slFindFiles[i]);
            baFilePath = szFilePath.toLocal8Bit();
            QStringList fiedls = slFindFiles[i].split('.');

            nUserID = QString(fiedls.value(0)).toUInt();

            fp = fopen(baFilePath.data(), "rb");

            if (fp)  {
                fread(&dwLen, 1, sizeof(NBioAPI_UINT32), fp);
                hTextFIR.TextFIR = new NBioAPI_CHAR[dwLen];
                fread(hTextFIR.TextFIR, dwLen, 1, fp);
                fclose(fp);

                nRet = NBioAPI_AddFIRToIndexSearchDB(m_hNBioBSP, &inputFIR, nUserID, &infoSample);

                if (NBioAPIERROR_NONE != nRet)  {
                   QString szError;

                   szError.sprintf("NBioAPI_AddFIRToIndexSearchDB error: %04X", nRet);
                   QMessageBox::warning(this, "NBioBSP_IndexSearch", szError);

                   if (hTextFIR.TextFIR)
                      delete[] hTextFIR.TextFIR;

                   break;
                }

                for (int f = 0; f < 11; f++)  {
                    if (infoSample.SampleCount[f] != 0)  {
                        for (int s = 0; s < infoSample.SampleCount[f]; s++)  {
                            int nIndex = pRegModel->rowCount();

                            pRegModel->insertRow(nIndex, QModelIndex());
                            pRegModel->setData(pRegModel->index(nIndex, 0, QModelIndex()), infoSample.ID);
                            pRegModel->setData(pRegModel->index(nIndex, 1, QModelIndex()), f);
                            pRegModel->setData(pRegModel->index(nIndex, 2, QModelIndex()), s);
                        }
                    }
                }

                if (hTextFIR.TextFIR)
                    delete[] hTextFIR.TextFIR;

                ui->pgBarLoad->setValue(i + 1);

                QApplication::processEvents();
            }
        }

        if (NBioAPIERROR_NONE == nRet)
           ui->labelStatus->setText(QString("Successfully added to DB! (Count: %1)").arg(slFindFiles.size()));
    }

    UpdateTotalCount();
}

void NBioBSP_IndexSearch::on_btLoadMIN_pressed()
{
    // Min data name rull: samplenumber_UserID_FingerID.min
    QString szDir = QFileDialog::getExistingDirectory(this, "Select MIN data Directory", QDir::currentPath());

    if (szDir.isEmpty())
        return ;

    QDir dirFind = QDir(szDir);
    QStringList slFindFiles;

    slFindFiles = dirFind.entryList(QStringList("*.min"), QDir::Files | QDir::NoSymLinks);

    if (slFindFiles.size() > 0)  {
        NBioAPI_RETURN nRet = NBioAPIERROR_NONE;
        QString szFilePath;
        QByteArray baFilePath;
        FILE* fp;
        NBioAPI_FIR_HANDLE hExportedFIR;
        NBioAPI_EXPORT_DATA exportData;
        NBioAPI_INPUT_FIR inputFIR;
        NBioAPI_INDEXSEARCH_SAMPLE_INFO infoSample;
        NBioAPI_UINT32 nUserID;

        inputFIR.Form = NBioAPI_FIR_FORM_HANDLE;
        inputFIR.InputFIR.FIRinBSP = &hExportedFIR;

        memset(&exportData, 0, sizeof(NBioAPI_EXPORT_DATA));

        exportData.Length = sizeof(NBioAPI_EXPORT_DATA);
        exportData.EncryptType = MINCONV_TYPE_OLD_FDA;
        exportData.FingerNum = 1;
        exportData.DefaultFingerID = NBioAPI_FINGER_ID_UNKNOWN;
        exportData.SamplesPerFinger = 1;
        exportData.FingerData2 = new NBioAPI_FINGER_DATA_2 [1];
        exportData.FingerData2[0].Length = sizeof(NBioAPI_FINGER_DATA_2);
        exportData.FingerData2[0].FingerID = 1;
        exportData.FingerData2[0].Template = new NBioAPI_TEMPLATE_DATA_2 [1];
        exportData.FingerData2[0].Template[0].Length = 400;
        exportData.FingerData2[0].Template[0].Data = new NBioAPI_UINT8 [400];

        ui->pgBarLoad->setRange(0, slFindFiles.size());
        ui->pgBarLoad->setValue(0);

        for (int i = 0; i < slFindFiles.size(); i++)  {
            szFilePath = dirFind.absoluteFilePath(slFindFiles[i]);
            baFilePath = szFilePath.toLocal8Bit();
            QStringList fiedls = slFindFiles[i].split('.');
            QStringList fiedls2 = QString(fiedls.value(0)).split('_');

            nUserID = QString(fiedls2.value(1)).toUInt();
            exportData.FingerData2[0].FingerID = (NBioAPI_UINT8) QString(fiedls2.value(2)).toUShort();

            fp = fopen(baFilePath.data(), "rb");

            if (fp)  {
                fread(exportData.FingerData2[0].Template[0].Data, 400, 1, fp);
                fclose(fp);

                nRet = NBioAPI_ImportDataToNBioBSP(m_hNBioBSP, &exportData, NBioAPI_FIR_PURPOSE_VERIFY, &hExportedFIR);

                if (NBioAPIERROR_NONE != nRet)  {
                    QString szError;

                    szError.sprintf("NBioAPI_ImportDataToNBioBSP error: %04X", nRet);
                    QMessageBox::warning(this, "NBioBSP_IndexSearch", szError);

                    break;
                }

                nRet = NBioAPI_AddFIRToIndexSearchDB(m_hNBioBSP, &inputFIR, nUserID, &infoSample);

                NBioAPI_FreeFIRHandle(m_hNBioBSP, hExportedFIR);

                if (NBioAPIERROR_NONE != nRet)  {
                   QString szError;

                   szError.sprintf("NBioAPI_AddFIRToIndexSearchDB error: %04X", nRet);
                   QMessageBox::warning(this, "NBioBSP_IndexSearch", szError);

                   break;
                }

                for (int f = 0; f < 11; f++)  {
                    if (infoSample.SampleCount[f] != 0)  {
                        for (int s = 0; s < infoSample.SampleCount[f]; s++)  {
                            int nIndex = pRegModel->rowCount();

                            pRegModel->insertRow(nIndex, QModelIndex());
                            pRegModel->setData(pRegModel->index(nIndex, 0, QModelIndex()), infoSample.ID);
                            pRegModel->setData(pRegModel->index(nIndex, 1, QModelIndex()), f);
                            pRegModel->setData(pRegModel->index(nIndex, 2, QModelIndex()), s);
                        }
                    }
                }

                ui->pgBarLoad->setValue(i + 1);

                QApplication::processEvents();
            }
        }

        //ExportData Free
        delete[] exportData.FingerData2[0].Template[0].Data;
        delete[] exportData.FingerData2[0].Template;
        delete[] exportData.FingerData2;

        if (NBioAPIERROR_NONE == nRet)
           ui->labelStatus->setText(QString("Successfully added to DB! (Count: %1)").arg(slFindFiles.size()));
    }

    UpdateTotalCount();
}

void NBioBSP_IndexSearch::on_btIdentify_pressed()
{
    NBioAPI_UINT32 nDataCount = 0;

    //NBioAPI Search DB Count.
    NBioAPI_GetDataCountFromIndexSearchDB(m_hNBioBSP, &nDataCount);

    ui->pgbarSearch->setRange(0, nDataCount);
    ui->pgbarSearch->setValue(0);

    m_bStopFlag = false;

    NBioAPI_RETURN nRet = NBioAPI_OpenDevice(m_hNBioBSP, NBioAPI_DEVICE_ID_AUTO);

    if (NBioAPIERROR_NONE != nRet)  {
        QString szError;

        szError.sprintf("NBioAPI_OpenDevice error: %04X", nRet);
        ui->labelStatus->setText(szError);
    }
    else  {
        NBioAPI_FIR_HANDLE hFIR;

        //NBioAPI Capture
        nRet = NBioAPI_Capture(m_hNBioBSP, NBioAPI_FIR_PURPOSE_IDENTIFY, &hFIR, NBioAPI_USE_DEFAULT_TIMEOUT, NULL, NULL);

        if (NBioAPIERROR_NONE == nRet)  {
            NBioAPI_INPUT_FIR inputFIR;

            inputFIR.Form = NBioAPI_FIR_FORM_HANDLE;
            inputFIR.InputFIR.FIRinBSP = &hFIR;

            NBioAPI_INDEXSEARCH_FP_INFO infoFp;
            NBioAPI_INDEXSEARCH_CALLBACK_INFO_0 callbackInfo0;

            callbackInfo0.CallBackType = 0;
            callbackInfo0.CallBackFunction = MyIndexSearchCallBack;
            callbackInfo0.UserCallBackParam = this;

            //Search DB
            QTime t;

            ui->btStop->setEnabled(true);
            pSearchModel->removeRows(0, pSearchModel->rowCount(QModelIndex()), QModelIndex());

            t.start();
            nRet = NBioAPI_IdentifyDataFromIndexSearchDB(m_hNBioBSP, &inputFIR, 5, &infoFp, &callbackInfo0);
            int nElapsed = t.elapsed();

            ui->btStop->setEnabled(false);

            ui->labelSearchTime->setText(QString("%1.%2 sec").arg(nElapsed / 1000).arg(nElapsed % 1000));

            if (NBioAPIERROR_NONE != nRet)  {
                if (NBioAPIERROR_INDEXSEARCH_IDENTIFY_STOP != nRet)
                    QMessageBox::warning(this, "NBioBSP_IndexSearch", "Failed to identify fingerprint data from DB!");
            }
            else  {
                int nIndex = 0;

                pSearchModel->insertRow(nIndex, QModelIndex());
                pSearchModel->setData(pSearchModel->index(nIndex, 0, QModelIndex()), infoFp.ID);
                pSearchModel->setData(pSearchModel->index(nIndex, 1, QModelIndex()), infoFp.FingerID);
                pSearchModel->setData(pSearchModel->index(nIndex, 2, QModelIndex()), infoFp.SampleNumber);
                pSearchModel->setData(pSearchModel->index(nIndex, 3, QModelIndex()), "-");
            }
        }

        NBioAPI_FreeFIRHandle(m_hNBioBSP, hFIR);
        NBioAPI_CloseDevice(m_hNBioBSP, NBioAPI_DEVICE_ID_AUTO);
    }

    if (ui->pgbarSearch->maximum() == 0)
        ui->pgbarSearch->setRange(0, 100);
}

void NBioBSP_IndexSearch::on_btStop_pressed()
{
    m_bStopFlag = true;
}

void NBioBSP_IndexSearch::on_btLoadDB_pressed()
{
    if (pRegModel->rowCount(QModelIndex()) > 0)  {
        int bt = QMessageBox::information(this, "NBioBSP_IndexSearch", "If you load database from file, existing memory database will be cleared!\nAre you sure you want to load database?", QMessageBox::No, QMessageBox::Yes);

        if (bt == QMessageBox::No)
            return ;
    }

    QString szFilePath = QFileDialog::getOpenFileName(this, "Load IndexSearch DB", QDir::currentPath(), "IndexSearch DB(*.ISDB)");

    if (!szFilePath.isEmpty())  {
        on_btClearDB_pressed();
        QByteArray baFilePath = szFilePath.toLocal8Bit();

        NBioAPI_RETURN nRet = NBioAPI_LoadIndexSearchDBFromFile(m_hNBioBSP, baFilePath.data());

        if (NBioAPIERROR_NONE == nRet)  {
            if (szFilePath.endsWith(".ISDB"))
                szFilePath.replace(QString("ISDB"), QString("FID"));
            else
                szFilePath += ".FID";

            QFile fFID(szFilePath);

            if (fFID.open(QIODevice::ReadOnly | QIODevice::Text))  {
                char szBuf[512];
                int nIndex = 0;
                QStringList szDatas;

                while (fFID.readLine(szBuf, sizeof(szBuf)) != -1)  {
                    szDatas = QString(szBuf).split('\t');

                    pRegModel->insertRow(nIndex, QModelIndex());
                    pRegModel->setData(pRegModel->index(nIndex, 0, QModelIndex()), szDatas[0]);
                    pRegModel->setData(pRegModel->index(nIndex, 1, QModelIndex()), szDatas[1]);
                    pRegModel->setData(pRegModel->index(nIndex, 2, QModelIndex()), szDatas[2]);
                }

                fFID.close();
            }

            ui->labelStatus->setText("Successfully loaded to file!");
        }
        else  {
            QString szError;

            szError.sprintf("NBioAPI_LoadIndexSearchDBFromFile error: %04X", nRet);
            ui->labelStatus->setText(szError);
        }

        UpdateTotalCount();
    }
}

void NBioBSP_IndexSearch::on_btSaveDB_pressed()
{
    QString szSaveFileName = QDir::currentPath() + "/IndexSearch.ISDB";
    QString szFilePath = QFileDialog::getSaveFileName(this, "Save IndexSearch DB", szSaveFileName, "IndexSearch DB(*.ISDB)");

    if (!szFilePath.isEmpty())  {
        QByteArray baFilePath = szFilePath.toLocal8Bit();

        NBioAPI_RETURN nRet = NBioAPI_SaveIndexSearchDBToFile(m_hNBioBSP, baFilePath.data());

        if (NBioAPIERROR_NONE == nRet)  {
            if (szFilePath.endsWith(".ISDB"))
                szFilePath.replace(QString("ISDB"), QString("FID"));
            else
                szFilePath += ".FID";

            QFile fFID(szFilePath);
            int nCnt = pRegModel->rowCount(QModelIndex());
            QString szMsg;
            QStandardItem* pItem1, *pItem2, *pItem3;

            if (fFID.open(QIODevice::WriteOnly | QIODevice::Text))  {
                for (int i = 0; i < nCnt; i++)  {
                    pItem1 = pRegModel->item(i, 0);
                    pItem2 = pRegModel->item(i, 1);
                    pItem3 = pRegModel->item(i, 2);

                    szMsg = QString("%1\t%2\t%3\n").arg(pItem1->text()).arg(pItem2->text()).arg(pItem3->text());
                    fFID.write(szMsg.toLocal8Bit());
                }

                fFID.close();
            }

            ui->labelStatus->setText("Successfully saved to file!");
        }
        else  {
            QString szError;

            szError.sprintf("NBioAPI_SaveIndexSearchDBToFile error: %04X", nRet);
            ui->labelStatus->setText(szError);
        }
    }
}

void NBioBSP_IndexSearch::on_btRmDB_pressed()
{
    QModelIndexList selectedRows = ui->tableReg->selectionModel()->selectedRows();
    NBioAPI_INDEXSEARCH_FP_INFO infoFP;
    QStandardItem* pItem;
    NBioAPI_RETURN nRet = NBioAPIERROR_NONE;

    for (int i = selectedRows.size() - 1; i >= 0; i--)  {
        pItem = pRegModel->item(selectedRows[i].row(), 0);
        infoFP.ID = pItem->text().toUInt();
        pItem = pRegModel->item(selectedRows[i].row(), 1);
        infoFP.FingerID = (NBioAPI_UINT8) pItem->text().toUShort();
        pItem = pRegModel->item(selectedRows[i].row(), 2);
        infoFP.SampleNumber = (NBioAPI_UINT8) pItem->text().toUShort();

        nRet = NBioAPI_RemoveDataFromIndexSearchDB(m_hNBioBSP, &infoFP);

        if (NBioAPIERROR_NONE == nRet)
            pRegModel->removeRow(selectedRows[i].row(), QModelIndex());
        else  {
            QString szError;

            szError.sprintf("NBioAPI_RemoveDataFromIndexSearchDB error: %04X", nRet);
            ui->labelStatus->setText(szError);
            break;
        }
    }

    if (NBioAPIERROR_NONE == nRet)
        ui->labelStatus->setText(QString("Remove data from DB [Count: %1]").arg(selectedRows.size()));

    UpdateTotalCount();
}

void NBioBSP_IndexSearch::on_btClearDB_pressed()
{
    //DataBase Clear.
    NBioAPI_RETURN nRet = NBioAPI_ClearIndexSearchDB(m_hNBioBSP);

    if (NBioAPIERROR_NONE == nRet)  {
        //User ListBox Item All Clear.
        pRegModel->removeRows(0, pRegModel->rowCount(QModelIndex()), QModelIndex());
        UpdateTotalCount();
    }
    else  {
        QString szError;

        szError.sprintf("NBioAPI_ClearIndexSearchDB error: %04X", nRet);
        ui->labelStatus->setText(szError);
    }
}
