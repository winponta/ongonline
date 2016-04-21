/*
* File : NBioBSPRollDemo.h
* Author : Daniel
* Description : NBioBSP Roll sample for Linux
* Copyright(c): 2008, NITGEN Co., Ltd.
* History : 
*
*/

#include <stdio.h>
#include <stdlib.h>
#include "NBioBSPRollDemo.h"

void MyPaint(NBioBSPRollDemo_Widget* pWidget)
{
   QPixmap Spm;
   Spm = pWidget->m_RollImage;
   Spm.setOptimization(QPixmap::BestOptim);
   
   QWMatrix Sm;
   Sm.scale((double)IMAGE_FRAME_WIDTH/(double)pWidget->m_DeviceInfo0.ImageWidth,
      (double)IMAGE_FRAME_HEIGHT/(double)pWidget->m_DeviceInfo0.ImageHeight);
   
   QPixmap Srpm = Spm.xForm(Sm);
        
   bitBlt(pWidget->m_frmRoll, 0, 0, &Srpm);
}

NBioAPI_RETURN MyCaptureCallback(NBioAPI_WINDOW_CALLBACK_PARAM_PTR_0 pCallbackParam, NBioAPI_VOID_PTR pUserParam)
{
   NBioBSPRollDemo_Widget* pWidget = (NBioBSPRollDemo_Widget*)pUserParam;
   
   memcpy(pWidget->m_pRollImage, pCallbackParam->lpImageBuf, pWidget->m_DeviceInfo0.ImageWidth * pWidget->m_DeviceInfo0.ImageHeight);

   MyPaint(pWidget);

   return NBioAPIERROR_NONE;
}

void NBioBSPRollDemo_Widget::closeEvent(QCloseEvent* e)
{
   QWidget::closeEvent(e);

   if(m_pRollImage)
       delete[] m_pRollImage;
    
   // Terminate NBioBSP module
   if(m_hNBioBSP != NBioAPI_INVALID_HANDLE) {
      if (m_hCapturedFIR1)
         NBioAPI_FreeFIRHandle(m_hNBioBSP, m_hCapturedFIR1);

      if (m_hCapturedAudit1)
         NBioAPI_FreeFIRHandle(m_hNBioBSP, m_hCapturedAudit1);

      NBioAPI_CloseDevice(m_hNBioBSP, m_DeviceID);
      NBioAPI_Terminate(m_hNBioBSP);
   }

   emit closed();
}

void NBioBSPRollDemo_Widget::paintEvent(QPaintEvent *)
{
   MyPaint(this);
}

NBioBSPRollDemo_Widget::NBioBSPRollDemo_Widget(QWidget * parent, const char *name)
:QMainWindow( parent, name )
{
   setMinimumSize(560, 500);
   setMaximumSize(560, 500);
  
   m_hNBioBSP = NBioAPI_INVALID_HANDLE;
   m_hCapturedFIR1 = NBioAPI_INVALID_HANDLE;
   m_hCapturedAudit1 = NBioAPI_INVALID_HANDLE;
   m_pRollImage = NULL; 
   Initialize();
   InitNBioBSPModule();   
}
NBioBSPRollDemo_Widget::~NBioBSPRollDemo_Widget()
{
}

void NBioBSPRollDemo_Widget::Initialize()
{
   //Create a groupbox which layouts its childs in a columns
   // Device Function
   gbox_Device = new QButtonGroup(0, QGroupBox::Vertical, "Device Function", this); 
   gbox_Device->setGeometry(5,7,520,60);
   gbox_Device->setLineWidth(1);
  
   lbl_Device = new QLabel("Device List", this);
   //lbl_Device->setText("Device List");
   lbl_Device->setGeometry(15,40,80,10);
   
   cb_DEV_LIST = new QComboBox(FALSE, gbox_Device);
   Q_CHECK_PTR(cb_DEV_LIST);
   //cb_DEV_LIST->insertStrList(DeviceList, 1);
   cb_DEV_LIST->setGeometry(100,25,250,30);
   connect(cb_DEV_LIST, SIGNAL(activated(int)), this, SLOT(OnComboDeviceList()));
   //cb_DEV_LIST->setCurrentItem(0);
   m_DeviceID = NBioAPI_DEVICE_ID_AUTO;
   
   pb_OPEN = new QPushButton("&Open", gbox_Device, "Open");
   pb_OPEN->setGeometry(360, 25, 150, 30);
   connect(pb_OPEN, SIGNAL(clicked()), this, SLOT(OnBtnOpenDevice()));	
    
   ////////////////////////////////////////////////////////////////  
   // Capture Function   
   gbox_Capture = new QButtonGroup(0, QGroupBox::Vertical, "Capture Function", this); 
   gbox_Capture->setGeometry(5,90,490,355);
   gbox_Capture->setLineWidth(1);
   
   // Create a nice frame to put around the OpenGL widget	
   m_frmRoll = new QFrame(gbox_Capture, "CaptureFunction");
   m_frmRoll->setFrameStyle(QFrame::Sunken | QFrame::Panel);
   m_frmRoll->setLineWidth(1);
   m_frmRoll->setGeometry(5, 25, 300, 300);
   m_frmRoll->unsetPalette();
       
   ////////////////////////////////////////////////////////////////  
   // UI Setting   
   gbox_UISet = new QButtonGroup(0, QGroupBox::Vertical, "UI Setting", this); 
   gbox_UISet->setGeometry(310, 90, 565,140);
   gbox_UISet->setLineWidth(1);
   
   rb_DrawImageY = new QRadioButton("Yes,(Finger image drawing)", gbox_UISet, "rbDrawImageY");
   rb_DrawImageY->setGeometry(5, 20, 260, 20);
   connect(rb_DrawImageY, SIGNAL(clicked()), this, SLOT(OnRadioYes()));
   rb_DrawImageY->setChecked(true);
   m_ScanType = 1;
   
   rb_DrawImageN = new QRadioButton("No,(Finger image drawing)", gbox_UISet, "rbDrawImageY");
   rb_DrawImageN->setGeometry(5, 41, 260, 20);
   connect(rb_DrawImageN, SIGNAL(clicked()), this, SLOT(OnRadioNo()));
   
   gbox_UISet->setEnabled(false);  
   rb_DrawImageY->setEnabled(false);
   rb_DrawImageN->setEnabled(false);
   ////////////////////////////////////////////////////////////////  
   // Roll Capture 
   gbox_Type2 = new QButtonGroup(0, QGroupBox::Vertical, "Roll Capture", this); 
   gbox_Type2->setGeometry(310, 170, 510, 200);
   gbox_Type2->setLineWidth(1);
   
   pb_RollStart = new QPushButton("&Roll Live Capture Start", gbox_Type2, "ppRollStart");
   pb_RollStart->setGeometry(5, 20, 210, 30);
   connect(pb_RollStart, SIGNAL(clicked()), this, SLOT(OnBtnStart()));	
   pb_RollStart->setEnabled(false);
      
   ////////////////////////////////////////////////////////////////  
   // Match 
   gbox_Match = new QButtonGroup(0, QGroupBox::Vertical, "VerifyMatch", this); 
   gbox_Match->setGeometry(310,270,520,270);
   gbox_Match->setLineWidth(1);
   
   pb_RollMatch = new QPushButton("&Verify Match", gbox_Match, "VerifyMatch");
   pb_RollMatch->setGeometry(5, 20, 210, 30);
   connect(pb_RollMatch, SIGNAL(clicked()), this, SLOT(OnBtnVerifyMatch()));
   pb_RollMatch->setEnabled(false);
   
   pb_EXIT = new QPushButton("&Exit", gbox_Match, "VerifyMatch");
   pb_EXIT->setGeometry(5, 55, 210,30 );
   connect(pb_EXIT, SIGNAL(clicked()), this, SLOT(OnBtnExit()));
}

NBioAPI_RETURN NBioBSPRollDemo_Widget::DisplayDeviceList()
{
   NBioAPI_RETURN nRet = NBioAPI_EnumerateDeviceEx(m_hNBioBSP, &m_nDeviceCnt, &m_pDeviceList, &m_pDeviceInfoEx);
      
   if (nRet != NBioAPIERROR_NONE)  {
      DisplayError(nRet);
      return nRet;
   }

   if (m_nDeviceCnt == 0)  {
      statusBar()->message("Device not found");
      return nRet;
   }

   QString szDevice;

   szDevice = "Auto_Detect";

   cb_DEV_LIST->insertItem(szDevice);
   
   for (NBioAPI_UINT32 i = 0 ; i < m_nDeviceCnt; i++)  {
      szDevice.sprintf("%s (ID:%02d)[%s]", m_pDeviceInfoEx[i].Name, m_pDeviceInfoEx[i].Instance, m_pDeviceInfoEx[i].Description);
      cb_DEV_LIST->insertItem(szDevice);
   }

   cb_DEV_LIST->setCurrentItem(0);

   return nRet;
}

void NBioBSPRollDemo_Widget::InitNBioBSPModule()
{
   NBioAPI_RETURN nRet = NBioAPI_Init(&m_hNBioBSP);

   if (nRet == NBioAPIERROR_NONE)  {

      memset(&m_Version, 0, sizeof(NBioAPI_VERSION));

      nRet = NBioAPI_GetVersion(m_hNBioBSP, &m_Version);

      if (nRet == NBioAPIERROR_NONE)  {
      	QString szVer;        
        
        szVer.sprintf("NBioBSP Version : %d.%04d", m_Version.Major, m_Version.Minor);
        statusBar()->message(szVer);
      }

      DisplayDeviceList();
      m_DeviceID = NBioAPI_DEVICE_ID_AUTO;
      m_DeviceIDOld = NBioAPI_DEVICE_ID_AUTO;
   }
   else
      DisplayError(nRet);
}

void NBioBSPRollDemo_Widget::OnComboDeviceList()
{
   m_DeviceList = cb_DEV_LIST->currentItem();
   m_DeviceIDOld = m_DeviceID;

   if (m_DeviceList == 0)
      m_DeviceID = NBioAPI_DEVICE_ID_AUTO;
   else
   { 
      m_DeviceID = m_pDeviceInfoEx[m_DeviceList - 1].NameID | (m_pDeviceInfoEx[m_DeviceList - 1].Instance << 8); 
//      m_DeviceID = m_pDeviceInfoEx[m_DeviceList - 1].Instance;
   }
}

void NBioBSPRollDemo_Widget::OnBtnOpenDevice()
{
   if (m_hNBioBSP == NBioAPI_INVALID_HANDLE) {
      statusBar()->message("Failed to init NBioBSP Module.");
      return;
   }
   
   NBioAPI_CloseDevice(m_hNBioBSP, m_DeviceIDOld);

   NBioAPI_RETURN err = NBioAPI_OpenDevice(m_hNBioBSP, m_DeviceID);
   if (err == NBioAPIERROR_DEVICE_ALREADY_OPENED)
   {
      NBioAPI_CloseDevice(m_hNBioBSP, m_DeviceID);
      err = NBioAPI_OpenDevice(m_hNBioBSP, m_DeviceID);
   }	
   
   if (err == NBioAPIERROR_NONE) {
      memset(&m_DeviceInfo0, 0, sizeof(NBioAPI_DEVICE_INFO_0));
      m_DeviceInfo0.StructureType = 0;
      NBioAPI_GetDeviceInfo(m_hNBioBSP, NBioAPI_DEVICE_ID_AUTO, 0, &m_DeviceInfo0);
      
      if (m_pRollImage)
         delete[] m_pRollImage;

      m_pRollImage = new unsigned char [m_DeviceInfo0.ImageWidth * m_DeviceInfo0.ImageHeight];

      memset(m_pRollImage, 0xff, m_DeviceInfo0.ImageWidth * m_DeviceInfo0.ImageHeight);

      m_RollImage = QImage(m_pRollImage, 
         m_DeviceInfo0.ImageWidth,
         m_DeviceInfo0.ImageHeight,
         8, 
         0, 
         256, 
         QImage::LittleEndian);
            
      int i = 0;
      for (i = 0; i < 256; i++) {
         m_RollImage.setColor(i, qRgb(i, i, i));
      }

      pb_RollStart->setEnabled(true);
      pb_RollMatch->setEnabled(true);

      statusBar()->message("Function success - [Open Device]");
   } else
      DisplayError(err);
}

void NBioBSPRollDemo_Widget::OnRadioYes()
{
   m_ScanType = 1;
}

void NBioBSPRollDemo_Widget::OnRadioNo()
{
   m_ScanType = 0;
}

void NBioBSPRollDemo_Widget::OnBtnStart()
{
   NBioAPI_WINDOW_OPTION windowOption;
   memset(&windowOption, 0, sizeof(NBioAPI_WINDOW_OPTION));

   windowOption.Length = sizeof(NBioAPI_WINDOW_OPTION);

   if (m_ScanType == 1)  {
      //windowOption.FingerWnd = m_staticFP.GetSafeHwnd();
      windowOption.WindowStyle = NBioAPI_WINDOW_STYLE_INVISIBLE;
   }
   else  {
      windowOption.WindowStyle = NBioAPI_WINDOW_STYLE_INVISIBLE;
   }

   // If you want to receive the capturing information, you can set.
   windowOption.CaptureCallBackInfo.CallBackType = 0;
   windowOption.CaptureCallBackInfo.CallBackFunction = MyCaptureCallback;
   windowOption.CaptureCallBackInfo.UserCallBackParam = this;

   if (m_hCapturedFIR1)  {
      NBioAPI_FreeFIRHandle(m_hNBioBSP, m_hCapturedFIR1);
      m_hCapturedFIR1 = NBioAPI_INVALID_HANDLE;
   }

   if (m_hCapturedAudit1)  {
      NBioAPI_FreeFIRHandle(m_hNBioBSP, m_hCapturedAudit1);
      m_hCapturedAudit1 = NBioAPI_INVALID_HANDLE;
   }
   statusBar()->message("Run Roll Capture"); 

   // If windowOption Value is NULL, RollCapture same run "No, Finger image drawing" mode.
   NBioAPI_RETURN nRet = NBioAPI_RollCapture(m_hNBioBSP, NBioAPI_FIR_PURPOSE_VERIFY, 10000, &m_hCapturedFIR1, &m_hCapturedAudit1, &windowOption);

   if (nRet != NBioAPIERROR_NONE)  {
      DisplayError(nRet);
      statusBar()->message("Roll Capture Fail");
   }
   else  {
      statusBar()->message("Roll Capture Success"); 

      pb_RollMatch->setEnabled(true);

      // save raw image
      if (m_hCapturedAudit1)  {
         NBioAPI_EXPORT_AUDIT_DATA exportAudit;
         NBioAPI_INPUT_FIR inputFIR;

         inputFIR.Form = NBioAPI_FIR_FORM_HANDLE;
         inputFIR.InputFIR.FIRinBSP = &m_hCapturedAudit1;

         nRet = NBioAPI_NBioBSPToImage(m_hNBioBSP, &inputFIR, &exportAudit);

         if (nRet == NBioAPIERROR_NONE)  {
            char szFileName[MAX_PATH];
            FILE* fp;

            sprintf(szFileName, "RollCaptureRaw_%d_%d.raw", exportAudit.ImageWidth, exportAudit.ImageHeight);

            fp = fopen(szFileName, "wb");

            if (fp)  {
               fwrite(exportAudit.AuditData[0].Image[0].Data, 1, exportAudit.ImageWidth*exportAudit.ImageHeight, fp);
               fclose(fp);
            }

            NBioAPI_FreeExportAuditData(m_hNBioBSP, &exportAudit);
         }
      }
   }
}

void NBioBSPRollDemo_Widget::OnBtnVerifyMatch()
{
   NBioAPI_WINDOW_OPTION windowOption;
	
   memset(&windowOption, 0, sizeof(NBioAPI_WINDOW_OPTION));
	
   windowOption.Length = sizeof(NBioAPI_WINDOW_OPTION);
   windowOption.WindowStyle = NBioAPI_WINDOW_STYLE_INVISIBLE;

   // If you want to receive the capturing information, you can set.
   windowOption.CaptureCallBackInfo.CallBackType = 0;
   windowOption.CaptureCallBackInfo.CallBackFunction = MyCaptureCallback;
   windowOption.CaptureCallBackInfo.UserCallBackParam = this;
   
   NBioAPI_FIR_HANDLE hCapturedFIR;
	
   if (m_hCapturedFIR1)  {
     NBioAPI_RETURN nRet = NBioAPI_Capture(m_hNBioBSP, NBioAPI_FIR_PURPOSE_VERIFY, &hCapturedFIR, 10000, 0, &windowOption);

     if (nRet == NBioAPIERROR_NONE)  {
        NBioAPI_INPUT_FIR inputFIR1;
        NBioAPI_INPUT_FIR inputFIR2;

        inputFIR1.Form = NBioAPI_FIR_FORM_HANDLE;
        inputFIR1.InputFIR.FIRinBSP = &hCapturedFIR;

        inputFIR2.Form = NBioAPI_FIR_FORM_HANDLE;
        inputFIR2.InputFIR.FIRinBSP = &m_hCapturedFIR1;

        NBioAPI_BOOL bMatchRet = NBioAPI_FALSE;

        nRet = NBioAPI_VerifyMatch(m_hNBioBSP, &inputFIR1, &inputFIR2, &bMatchRet, NULL);

        if (nRet != NBioAPIERROR_NONE)
           DisplayError(nRet);
        else  {
           if (bMatchRet)
              QMessageBox::information(0, "NBioBSPRollDemo", "Matching Success!!", QMessageBox::Ok + QMessageBox::Default);
           else
              QMessageBox::information(0, "NBioBSPRollDemo", "Matching Fail!!", QMessageBox::Ok + QMessageBox::Default);            
        }
     }
     else  {
         DisplayError(nRet);
     }
   }
   else  {
      QMessageBox::information(0, "NBioBSPRollDemo", "Can not find captured fir data!!", QMessageBox::Ok + QMessageBox::Default);            
  }
}

void NBioBSPRollDemo_Widget::OnBtnExit()
{
   QApplication::exit(0);
   return;
}

void NBioBSPRollDemo_Widget::DisplayError(NBioAPI_RETURN errCode)
{
   QString error_msg;
   if (errCode == NBioAPIERROR_NONE)
      statusBar()->message("Function success");
   else
   {
      switch (errCode)
      {
      case 0x0000:
         error_msg = "NBioAPIERROR_NONE";
         break;
      case 0x0100:
         error_msg = "NBioAPIERROR_BASE_DEVICE";
         break;
      case 0x0200:
         error_msg = "NBioAPIERROR_BASE_UI";
         break;
         
      case 0x0001:
         error_msg = "NBioAPIERROR_INVALID_HANDLE";
         break;
      case 0x0002:
         error_msg = "NBioAPIERROR_INVALID_POINTER";
         break;
      case 0x0003:
         error_msg = "NBioAPIERROR_INVALID_TYPE";
         break;
      case 0x0004:
         error_msg = "NBioAPIERROR_FUNCTION_FAIL";
         break;
      case 0x0005:
         error_msg = "NBioAPIERROR_STRUCTTYPE_NOT_MATCHED";
         break;
      case 0x0006:
         error_msg = "NBioAPIERROR_ALREADY_PROCESSED";
         break;
      case 0x0007:
         error_msg = "NBioAPIERROR_EXTRACTION_OPEN_FAIL";
         break;
      case 0x0008:
         error_msg = "NBioAPIERROR_VERIFICATION_OPEN_FAIL";
         break;
      case 0x0009:
         error_msg = "NBioAPIERROR_DATA_PROCESS_FAIL";
         break;
      case 0x000a:
         error_msg = "NBioAPIERROR_MUST_BE_PROCESSED_DATA";
         break;
      case 0x000b:
         error_msg = "NBioAPIERROR_INTERNAL_CHECKSUM_FAIL";
         break;
      case 0x000c:
         error_msg = "NBioAPIERROR_ENCRYPTED_DATA_ERROR";
         break;
      case 0x000d:
         error_msg = "NBioAPIERROR_UNKNOWN_FORMAT";
         break;
      case 0x000e:
         error_msg = "NBioAPIERROR_UNKNOWN_VERSION";
         break;
      case 0x000f:
         error_msg = "NBioAPIERROR_VALIDITY_FAIL";
         break;
         
      case 0x0010:
         error_msg = "NBioAPIERROR_INIT_MAXFINGER";
         break;
      case 0x0011:
         error_msg = "NBioAPIERROR_INIT_SAMPLESPERFINGER";
         break;
      case 0x0012:
         error_msg = "NBioAPIERROR_INIT_ENROLLQUALITY";
         break;
      case 0x0013:
         error_msg = "NBioAPIERROR_INIT_VERIFYQUALITY";
         break;
      case 0x0014:
         error_msg = "NBioAPIERROR_INIT_IDENTIFYQUALITY";
         break;
      case 0x0015:
         error_msg = "NBioAPIERROR_INIT_SECURITYLEVEL";
         break;
         
      case 0x0101:
         error_msg = "NBioAPIERROR_DEVICE_OPEN_FAIL";
         break;
      case 0x0102:
         error_msg = "NBioAPIERROR_INVALID_DEVICE_ID";
         break;
      case 0x0103:
         error_msg = "NBioAPIERROR_WRONG_DEVICE_ID";
         break;
      case 0x0104:
         error_msg = "NBioAPIERROR_DEVICE_ALREADY_OPENED";
         break;
      case 0x0105:
         error_msg = "NBioAPIERROR_DEVICE_NOT_OPENED";
         break;
      case 0x0106:
         error_msg = "NBioAPIERROR_DEVICE_BRIGHTNESS";
         break;
      case 0x0107:
         error_msg = "NBioAPIERROR_DEVICE_CONTRAST";
         break;
      case 0x0108:
         error_msg = "NBioAPIERROR_DEVICE_GAIN";
         break;
         
      case 0x0201:
         error_msg = "NBioAPIERROR_USER_CANCEL";
         break;
      case 0x0202:
         error_msg = "NBioAPIERROR_USER_BACK";
         break;
      case 0x0203:
         error_msg = "NBioAPIERROR_CAPTURE_TIMEOUT";
         break;
      default:
         error_msg.sprintf("0x%04x", errCode);
         break;
      }
      error_msg.insert(0, "Error - ");
      statusBar()->message(error_msg);
   }
}

int main(int argc, char **argv)
{
   QApplication NBioBSPRollDemo(argc, argv);
   
   NBioBSPRollDemo_Widget Demo;
   Demo.resize(560, 500);
   NBioBSPRollDemo.setMainWidget(&Demo);
   
   char chTitle[60] = { 0x00, };
   sprintf(chTitle, "NBioBSPRollDemo Version : %d.%04d", Demo.m_Version.Major, Demo.m_Version.Minor);
   Demo.setCaption(chTitle);

   Demo.show();
   
   return NBioBSPRollDemo.exec();
}
