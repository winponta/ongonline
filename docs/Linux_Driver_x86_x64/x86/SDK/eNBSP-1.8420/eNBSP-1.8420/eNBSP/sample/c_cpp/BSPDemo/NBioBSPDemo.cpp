/*
* File : NBioBSPDemo.cpp
* Author : Khan, Jake
* Description : NBioBSP sample for Linux
* Copyright(c): 2004, NITGEN Co., Ltd.
* History : 
*
*/

#include <stdio.h>
#include <stdlib.h>
#include "NBioBSPDemo.h"

int getDevice[20] = {0,};

void MyPaint(NBioBSPDemo_Widget* pWidget)
{
   QPixmap Epm, Vpm;
   Epm = pWidget->m_EnrollImage;
   Vpm = pWidget->m_VerifyImage;
   Epm.setOptimization(QPixmap::BestOptim);
   Vpm.setOptimization(QPixmap::BestOptim);
   
   QWMatrix Em;
   QWMatrix Vm;
   Em.scale((double)IMAGE_FRAME_WIDTH/(double)pWidget->m_DeviceInfo0.ImageWidth,
      (double)IMAGE_FRAME_HEIGHT/(double)pWidget->m_DeviceInfo0.ImageHeight);
   Vm.scale((double)IMAGE_FRAME_WIDTH/(double)pWidget->m_DeviceInfo0.ImageWidth,
      (double)IMAGE_FRAME_HEIGHT/(double)pWidget->m_DeviceInfo0.ImageHeight);
   
   QPixmap Erpm = Epm.xForm(Em);
   QPixmap Vrpm = Vpm.xForm(Vm);
   
   bitBlt(pWidget->m_frmENROLL1, 0, 0, &Erpm);
   bitBlt(pWidget->m_frmENROLL2, 0, 0, &Vrpm);
}

NBioAPI_RETURN MyCaptureCallback(NBioAPI_WINDOW_CALLBACK_PARAM_PTR_0 pCallbackParam, NBioAPI_VOID_PTR pUserParam)
{
   NBioBSPDemo_Widget* pWidget = (NBioBSPDemo_Widget*)pUserParam;
   if(pWidget->m_bEnroll)
      memcpy(pWidget->m_pEnrollBuffer, pCallbackParam->lpImageBuf, pWidget->m_DeviceInfo0.ImageWidth * pWidget->m_DeviceInfo0.ImageHeight);
   else
      memcpy(pWidget->m_pVerifyBuffer, pCallbackParam->lpImageBuf, pWidget->m_DeviceInfo0.ImageWidth * pWidget->m_DeviceInfo0.ImageHeight);

   MyPaint(pWidget);

   return NBioAPIERROR_NONE;
}

void NBioBSPDemo_Widget::closeEvent(QCloseEvent* e)
{
   QWidget::closeEvent(e);
   emit closed();
}

void NBioBSPDemo_Widget::paintEvent(QPaintEvent *)
{
   MyPaint(this);
}

void NBioBSPDemo_Widget::Dlg_GetInfo()
{
   if (m_hBSP == NBioAPI_INVALID_HANDLE) {
      statusBar()->message("Failed to init NBioBSP Module.");
      return;
   }


   NBioAPI_INIT_INFO_0 initInfo0;
   memset(&initInfo0, 0, sizeof(NBioAPI_INIT_INFO_0));
   
   NBioAPI_RETURN err = NBioAPI_GetInitInfo(m_hBSP, 0, &initInfo0);
   if (err == NBioAPIERROR_NONE) {
      statusBar()->message("Function success - [Get Info]");
   
      m_ImageQuality = initInfo0.VerifyImageQuality;
      m_DefaultTimeout = initInfo0.DefaultTimeout;
      m_SecurityLevel = initInfo0.SecurityLevel;
      cb_SECURITYLEVEL->setCurrentItem(m_SecurityLevel - 1);
   
      QString GetData;
   
      GetData.sprintf("%d",m_ImageQuality);
      le_VIQ->setText(GetData);
      GetData.sprintf("%ld",m_DefaultTimeout);
      le_DT->setText(GetData);
   
   } else {
      DisplayError(err);
   }
}

void NBioBSPDemo_Widget::Dlg_SetInfo()
{
   if (m_hBSP == NBioAPI_INVALID_HANDLE) {
      statusBar()->message("Failed to init NBioBSP Module.");
      return;
   }

   char val_VIQ[4];
   char val_DT[7];
   
   qstrcpy(val_VIQ, le_VIQ->text());
   qstrcpy(val_DT, le_DT->text());
   
   m_ImageQuality = atoi(val_VIQ);
   m_DefaultTimeout = atoi(val_DT);
  
   if (m_ImageQuality <= 0 || m_ImageQuality > 100 || m_DefaultTimeout < 0) {
      statusBar()->message("Function failed - [Set Info : Invalid param]");
   } else {
      NBioAPI_INIT_INFO_0 initInfo0;
      memset(&initInfo0, 0, sizeof(initInfo0));
   
      NBioAPI_RETURN err = NBioAPI_GetInitInfo(m_hBSP,0, &initInfo0);
      if (err == NBioAPIERROR_NONE) {
         initInfo0.StructureType = 0;
         initInfo0.VerifyImageQuality = m_ImageQuality;
         initInfo0.DefaultTimeout = m_DefaultTimeout;
         initInfo0.SecurityLevel = m_SecurityLevel;
   
         err = NBioAPI_SetInitInfo(m_hBSP,0, &initInfo0);
      }

      if (err == NBioAPIERROR_NONE)
         statusBar()->message("Function success - [Set Info]");
      else
         DisplayError(err);
   }	  
}

void NBioBSPDemo_Widget::Dlg_OpenDevice()
{
   if (m_hBSP == NBioAPI_INVALID_HANDLE) {
      statusBar()->message("Failed to init NBioBSP Module.");
      return;
   }
   
   NBioAPI_CloseDevice(m_hBSP, m_OpenedDeviceID);

   NBioAPI_RETURN err = NBioAPI_OpenDevice(m_hBSP, m_DeviceID);
   if (err == NBioAPIERROR_DEVICE_ALREADY_OPENED)
   {
      NBioAPI_CloseDevice(m_hBSP, m_DeviceID);
      err = NBioAPI_OpenDevice(m_hBSP, m_DeviceID);
   }	
   
   if (err == NBioAPIERROR_NONE) {
      memset(&m_DeviceInfo0, 0, sizeof(NBioAPI_DEVICE_INFO_0));
      m_DeviceInfo0.StructureType = 0;
      NBioAPI_GetDeviceInfo(m_hBSP, NBioAPI_DEVICE_ID_AUTO, 0, &m_DeviceInfo0);
      
      if (m_pEnrollBuffer)
         delete[] m_pEnrollBuffer;
      if (m_pVerifyBuffer)
         delete[] m_pVerifyBuffer;

      m_pEnrollBuffer = new unsigned char [m_DeviceInfo0.ImageWidth * m_DeviceInfo0.ImageHeight];
      m_pVerifyBuffer = new unsigned char [m_DeviceInfo0.ImageWidth * m_DeviceInfo0.ImageHeight];

      memset(m_pEnrollBuffer, 0xff, m_DeviceInfo0.ImageWidth * m_DeviceInfo0.ImageHeight);
      memset(m_pVerifyBuffer, 0xff, m_DeviceInfo0.ImageWidth * m_DeviceInfo0.ImageHeight);

      m_EnrollImage = QImage(m_pEnrollBuffer, 
         m_DeviceInfo0.ImageWidth,
         m_DeviceInfo0.ImageHeight,
         8, 
         0, 
         256, 
         QImage::LittleEndian);
      
      m_VerifyImage = QImage(m_pVerifyBuffer, 
         m_DeviceInfo0.ImageWidth,
         m_DeviceInfo0.ImageHeight,
         8, 
         0, 
         256, 
         QImage::LittleEndian);
      
      int i = 0;
      for (i = 0; i < 256; i++) {
         m_EnrollImage.setColor(i, qRgb(i, i, i));
         m_VerifyImage.setColor(i, qRgb(i, i, i));
      }

      statusBar()->message("Function success - [Open Device]");
   } else
      DisplayError(err);
}

void NBioBSPDemo_Widget::Dlg_Enroll()
{
   if (m_hBSP == NBioAPI_INVALID_HANDLE) {
      statusBar()->message("Failed to init NBioBSP Module.");
      return;
   }
   
   NBioAPI_RETURN err;
   NBioAPI_BOOL bResult = NBioAPI_FALSE;
   
   int nUserDataLen = strlen(le_USER->text()) + 1;
   char* chUserData = new char [nUserDataLen];
   memset(chUserData, 0, nUserDataLen);
   qstrcpy(chUserData, le_USER->text());
   
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

   if (m_hFIR != NBioAPI_INVALID_HANDLE) {
      NBioAPI_FreeFIRHandle(m_hBSP, m_hFIR);
      m_hFIR = NBioAPI_INVALID_HANDLE;
   }
   
   m_bEnroll = true;	

   err = NBioAPI_Capture(m_hBSP, NBioAPI_FIR_PURPOSE_VERIFY, &hCapturedFIR1, -1, NULL, &winOption);

   if (err == NBioAPIERROR_NONE) {
      err = NBioAPI_Capture(m_hBSP, NBioAPI_FIR_PURPOSE_VERIFY, &hCapturedFIR2, -1, NULL, &winOption);

      if (err == NBioAPIERROR_NONE) {
         inputCapture1.Form = NBioAPI_FIR_FORM_HANDLE;
         inputCapture1.InputFIR.FIRinBSP = &hCapturedFIR1;
         inputCapture2.Form = NBioAPI_FIR_FORM_HANDLE;
         inputCapture2.InputFIR.FIRinBSP = &hCapturedFIR2;
   
         err = NBioAPI_VerifyMatch(m_hBSP, &inputCapture1, &inputCapture2, &bResult, NULL);
         if (err == NBioAPIERROR_NONE) { // Verify Success
            if (bResult) {
               if (strlen(chUserData) > 0) {
                  NBioAPI_FIR_PAYLOAD payload;
                  memset(&payload, 0, sizeof(NBioAPI_FIR_PAYLOAD));

                  payload.Length = nUserDataLen;
                  payload.Data = new NBioAPI_UINT8[payload.Length];
                  memcpy(payload.Data, chUserData, payload.Length);
      
                  err =  NBioAPI_CreateTemplate(m_hBSP, &inputCapture1, NULL, &m_hFIR, &payload);
         
                  if (payload.Data)
                     delete[] payload.Data;

               } else {
                  err =  NBioAPI_CreateTemplate(m_hBSP, &inputCapture1, NULL, &m_hFIR, NULL);
               }

               if (err == NBioAPIERROR_NONE) {
                  // Get full fir from handle.
                  NBioAPI_FreeFIR(m_hBSP, &m_FullFIR);
                  NBioAPI_GetFIRFromHandle(m_hBSP, m_hFIR, &m_FullFIR);
         
                  // Get text fir from handle.
                  NBioAPI_FreeTextFIR(m_hBSP, &m_TextFIR);
                  NBioAPI_GetTextFIRFromHandle(m_hBSP, m_hFIR, &m_TextFIR, 0);
                  statusBar()->message("Enroll success");
               }
            } else {
               statusBar()->message("Failed to enroll.");
            }
         }
      }
   }

   if (err != NBioAPIERROR_NONE) {
      DisplayError(err);
   }

   // Free memory
   NBioAPI_FreeFIRHandle(m_hBSP, hCapturedFIR1);
   NBioAPI_FreeFIRHandle(m_hBSP, hCapturedFIR2);
   
   m_bEnroll = false;
}

void NBioBSPDemo_Widget::Dlg_Verify()
{
   if (m_hBSP == NBioAPI_INVALID_HANDLE) {
      statusBar()->message("Failed to init NBioBSP Module.");
      return;
   }
   
   if (m_hFIR == NBioAPI_INVALID_HANDLE) {
      statusBar()->message("Can not find enrolled fingerprint!");
      return;
   }

   NBioAPI_RETURN err;
   NBioAPI_INPUT_FIR storedFIR;
   NBioAPI_INPUT_FIR verifyFIR;
   
   switch (m_DataType)
   {
   case 0:  // Handle in BSP
      storedFIR.Form = NBioAPI_FIR_FORM_HANDLE;
      storedFIR.InputFIR.FIRinBSP = &m_hFIR;
      break;
   case 1:  // Full FIR
      storedFIR.Form = NBioAPI_FIR_FORM_FULLFIR;
      storedFIR.InputFIR.FIR = &m_FullFIR;
      break;
   case 4:  // Text FIR
      storedFIR.Form = NBioAPI_FIR_FORM_TEXTENCODE;
      storedFIR.InputFIR.FIR = &m_TextFIR;
      break;
   }
   
   NBioAPI_BOOL bResult = NBioAPI_FALSE;
   NBioAPI_FIR_HANDLE hVerifyFIR = NBioAPI_INVALID_HANDLE;
   NBioAPI_FIR_PAYLOAD payload;
   memset(&payload, 0, sizeof(NBioAPI_FIR_PAYLOAD));
   
   NBioAPI_WINDOW_OPTION winOption;
   memset(&winOption, 0, sizeof(NBioAPI_WINDOW_OPTION));
   winOption.Length = sizeof(NBioAPI_WINDOW_OPTION);
   winOption.CaptureCallBackInfo.CallBackType = 0;
   winOption.CaptureCallBackInfo.CallBackFunction = MyCaptureCallback;
   winOption.CaptureCallBackInfo.UserCallBackParam = this;
   
   err = NBioAPI_Capture(m_hBSP, NBioAPI_FIR_PURPOSE_VERIFY, &hVerifyFIR, -1, NULL, &winOption);
   if (err == NBioAPIERROR_NONE) {
      verifyFIR.Form = NBioAPI_FIR_FORM_HANDLE;
      verifyFIR.InputFIR.FIRinBSP = &hVerifyFIR;

      err = NBioAPI_VerifyMatch(m_hBSP, &verifyFIR, &storedFIR, &bResult, &payload);
   }

   if (err != NBioAPIERROR_NONE) {
      DisplayError(err);

   } else {
      if (bResult) { // Verify Success
         statusBar()->message("Verify success");
         if (payload.Length) {
            QString msg;
            msg.sprintf("Verify success! (User : %s)", payload.Data);
            QMessageBox::information(0, "NBioBSPDemo", msg, QMessageBox::Ok + QMessageBox::Default);
         
         }
      } else { // Verify failed
         statusBar()->message("Failed to verify.");
      }	
   }

   // Free memory
   NBioAPI_FreePayload(m_hBSP, &payload);
   NBioAPI_FreeFIRHandle(m_hBSP, hVerifyFIR);
}

void NBioBSPDemo_Widget::OnRadioHandle()
{
   m_DataType = 0;    
}

void NBioBSPDemo_Widget::OnRadioFullFIR()
{
   m_DataType = 1;    
}

void NBioBSPDemo_Widget::OnRadioTextFIR()
{
   m_DataType = 4;    
}

void NBioBSPDemo_Widget::OnComboDeviceList()
{
   m_DeviceList = cb_DEVICELIST->currentItem();
   if( m_DeviceList == 0 )
   {
      m_OpenedDeviceID = m_DeviceID;
      m_DeviceID = NBioAPI_DEVICE_ID_AUTO;
   }
   else
   {
      m_OpenedDeviceID = m_DeviceID;
      m_DeviceID = getDevice[m_DeviceList-1];
   }
}

void NBioBSPDemo_Widget::OnComboSecurityLevel()
{
   m_SecurityLevel = cb_SECURITYLEVEL->currentItem() + 1;
}

void NBioBSPDemo_Widget::DisplayError(NBioAPI_RETURN errCode)
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

void NBioBSPDemo_Widget::Initialize()
{
   static const char* SecurityLevel[] = { "Lowest",
                                          "Lower",
                                          "Low",
                                          "Below Normal",
                                          "Normal",
                                          "Above Normal",
                                          "High",
                                          "Higher",
                                          "Highest",
                                          0 };

   static const char* DeviceList[] = { "Auto_Detect", 0 };
   
   ////////////////////////////////////////////////////
   //For BSP Information
   ////////////////////////////////////////////////////
   // create a groupbox which layouts its childs in a columns  
   gbox_BSP = new QButtonGroup(0, QGroupBox::Vertical, "BSP Information", this);
   gbox_BSP->setGeometry(10,10,500,140);
   gbox_BSP->setLineWidth(1);
   
   le_VIQ = new QLineEdit(gbox_BSP);
   lbl_VIQ = new QLabel(le_VIQ, "Image Quality", gbox_BSP);
   lbl_VIQ->setGeometry(40, 30, 140, 20);
   le_VIQ->setGeometry(200,30,130,20);
   le_VIQ->setText("30");
   
   le_DT = new QLineEdit(gbox_BSP);
   lbl_DT = new QLabel(le_DT, "Default TimeOut", gbox_BSP);
   lbl_DT->setGeometry(40,60,140,20);
   le_DT->setGeometry(200,60,130,20);
   le_DT->setText("10000");
   
   lbl_SL = new QLabel("Security Level", gbox_BSP);
   lbl_SL->setGeometry(40,90,140,20);
   
   cb_SECURITYLEVEL = new QComboBox(FALSE, gbox_BSP);
   Q_CHECK_PTR(cb_SECURITYLEVEL);
   cb_SECURITYLEVEL->insertStrList(SecurityLevel, 9);
   cb_SECURITYLEVEL->setGeometry(200,90,130,20);
   connect(cb_SECURITYLEVEL, SIGNAL(activated(int)), this, SLOT(OnComboSecurityLevel()));
   cb_SECURITYLEVEL->setCurrentItem(4);
   m_SecurityLevel = 5;
   
   // insert PushButton
   pb_GET = new QPushButton("&Get", gbox_BSP, "Get");
   pb_GET->setGeometry(370, 30, 90, 25);
   connect(pb_GET, SIGNAL(clicked()), this, SLOT(Dlg_GetInfo()));	
   
   pb_SET = new QPushButton("&Set", gbox_BSP, "Set");
   pb_SET->setGeometry(370, 60, 90, 25);
   connect(pb_SET, SIGNAL(clicked()), this, SLOT(Dlg_SetInfo()));	
   
   ////////////////////////////////////////////////////
   //For Device functions
   ////////////////////////////////////////////////////
   // create a groupbox which layouts its childs in a columns 
   gbox_DEVICE = new QButtonGroup(0, QGroupBox::Vertical, "Device functions", this);
   gbox_DEVICE->setGeometry(10,160,500,70);
   gbox_DEVICE->setLineWidth(1);
   
   lbl_DEVICE = new QLabel("Device", gbox_DEVICE);
   lbl_DEVICE->setGeometry(40,30,140,20);
   

   cb_DEVICELIST = new QComboBox(FALSE, gbox_DEVICE);
   Q_CHECK_PTR(cb_DEVICELIST);

   cb_DEVICELIST->insertStrList(DeviceList, 1);
   
   cb_DEVICELIST->setGeometry(200,30,130,20);
   connect(cb_DEVICELIST, SIGNAL(activated(int)), this, SLOT(OnComboDeviceList()));
   cb_DEVICELIST->setCurrentItem(0);
   m_DeviceID = NBioAPI_DEVICE_ID_AUTO;
   m_OpenedDeviceID = NBioAPI_DEVICE_ID_AUTO;
   
   // insert PushButton
   pb_OPEN = new QPushButton("&Open", gbox_DEVICE, "Open");
   pb_OPEN->setGeometry(370, 30, 90, 25);
   connect(pb_OPEN, SIGNAL(clicked()), this, SLOT(Dlg_OpenDevice()));	
   
   ////////////////////////////////////////////////////
   //For Enroll
   ////////////////////////////////////////////////////
   // create a groupbox which layouts its childs in a columns
   gbox_ENROLL = new QButtonGroup(0, QGroupBox::Vertical, "Enroll", this);
   gbox_ENROLL->setGeometry(10,240,500,110);
   gbox_ENROLL->setLineWidth(1);
   
   // Create a nice frame to put around the OpenGL widget	
   m_frmENROLL1 = new QFrame(gbox_ENROLL, "EnrollImage1");
   m_frmENROLL1->setFrameStyle(QFrame::Sunken | QFrame::Panel);
   m_frmENROLL1->setLineWidth(1);
   m_frmENROLL1->setGeometry(30, 20, IMAGE_FRAME_WIDTH, IMAGE_FRAME_HEIGHT);
   m_frmENROLL1->unsetPalette();
   
   m_frmENROLL2 = new QFrame(gbox_ENROLL, "EnrollImage2");
   m_frmENROLL2->setFrameStyle(QFrame::Sunken | QFrame::Panel);
   m_frmENROLL2->setLineWidth(1);
   m_frmENROLL2->setGeometry(110, 20, IMAGE_FRAME_WIDTH, IMAGE_FRAME_HEIGHT); 
   m_frmENROLL2->unsetPalette();
   
   le_USER = new QLineEdit(gbox_ENROLL);
   lbl_USER = new QLabel(le_USER, "User", gbox_ENROLL);
   lbl_USER->setGeometry(190,30,40,20);
   le_USER->setGeometry(230,30,100,20);
   
   // insert PushButton
   pb_ENROLL = new QPushButton("&Enroll", gbox_ENROLL, "pbEnroll");
   pb_ENROLL->setGeometry(370, 30, 90, 25);
   connect(pb_ENROLL, SIGNAL(clicked()), this, SLOT(Dlg_Enroll()));	
   
   ////////////////////////////////////////////////////
   //For Verify
   ////////////////////////////////////////////////////
   // create a groupbox which layouts its childs in a columns 
   gbox_VERIFY = new QButtonGroup(0, QGroupBox::Vertical, "Verify", this);
   gbox_VERIFY->setGeometry(10,360,500,95);
   gbox_VERIFY->setLineWidth(1);
   
   lbl_DATATYPE = new QLabel("Data Type", gbox_VERIFY);
   lbl_DATATYPE->setGeometry(40,25,140,20);
   
   // insert PushButton
   pb_VERIFY = new QPushButton("&Verify", gbox_VERIFY, "pbVerify");
   pb_VERIFY->setGeometry(370, 30, 90, 25);
   connect(pb_VERIFY, SIGNAL(clicked()), this, SLOT(Dlg_Verify()));	
   
   // create a groupbox which layouts its childs in a columns  
   gbox_RADIO = new QButtonGroup(0, QGroupBox::Vertical, "", gbox_VERIFY);
   gbox_RADIO->setGeometry(160,10,180,80);
   gbox_RADIO->setLineWidth(0);
   
   // insert RadioButton
   rb_HBSP = new QRadioButton("Handle in BSP", gbox_RADIO, "rbHBSP");
   rb_HBSP->setGeometry(10, 10, 120, 20);
   connect(rb_HBSP, SIGNAL(clicked()), this, SLOT(OnRadioHandle()));
   rb_HBSP->setChecked(true);
   m_DataType = 0; 
   
   rb_FFIR = new QRadioButton("Full FIR", gbox_RADIO, "rbFFIR");
   rb_FFIR->setGeometry(10, 30, 120, 20);
   connect(rb_FFIR, SIGNAL(clicked()), this, SLOT(OnRadioFullFIR()));
   
   rb_TFIR = new QRadioButton("Text FIR", gbox_RADIO, "rbTFIR");
   rb_TFIR->setGeometry(10, 50, 120, 20);
   connect(rb_TFIR, SIGNAL(clicked()), this, SLOT(OnRadioTextFIR()));
}

void NBioBSPDemo_Widget::InitNBioBSPModule()
{
   // Init NBioBSP module
   NBioAPI_RETURN err;
   
   err = NBioAPI_Init(&m_hBSP);
   if (err == NBioAPIERROR_NONE) {
      NBioAPI_GetVersion(m_hBSP, &m_Version);
      statusBar()->message("NBioBSP Module Init success");
   } else 
      DisplayError(err);


   static const char* DeviceList[] = { "Auto_Detect", "FDU01", "FDU05", 0 };
   NBioAPI_UINT32 dev_cnt, j;
   NBioAPI_DEVICE_ID* dev_list;
   int i;

   err = NBioAPI_EnumerateDevice(m_hBSP, &dev_cnt, &dev_list);
    
   if (err == NBioAPIERROR_NONE)
   {
      if( dev_cnt == 0 )
      {
         statusBar()->message("Device not found");
      }
      else
      {
         for( i=0; i<dev_cnt; i++ )
         {
            j = dev_list[i] & 0xff;
            if( j == NBioAPI_DEVICE_NAME_FDU01 )
            {
               cb_DEVICELIST->insertStrList(&DeviceList[1], 1);
               getDevice[i] =  dev_list[i];
            }
            else if( j == NBioAPI_DEVICE_NAME_FDU05 )
            {
               cb_DEVICELIST->insertStrList(&DeviceList[2], 1);
               getDevice[i] =  dev_list[i];
            }
            else
            {
               continue;
            }
         }
      }
   }
   else
   {
      DisplayError(err);
   }

}

NBioBSPDemo_Widget::NBioBSPDemo_Widget(QWidget * parent, const char *name)/*:QWidget(parent, name)*/ 
:QMainWindow( parent, name )
{
   // Make the top-level layout; a vertical box to contain all widgets
   // and sub-layouts.
   
   setMinimumSize(520, 480);
   setMaximumSize(520, 480);

   m_hBSP = NBioAPI_INVALID_HANDLE;
   m_hFIR = NBioAPI_INVALID_HANDLE;
   memset(&m_FullFIR, 0, sizeof(NBioAPI_FIR));
   memset(&m_TextFIR, 0, sizeof(NBioAPI_FIR_TEXTENCODE));
   
   m_pEnrollBuffer = NULL;
   m_pVerifyBuffer = NULL;
   
   Initialize();
   InitNBioBSPModule();
}

NBioBSPDemo_Widget::~NBioBSPDemo_Widget()
{
   // All child widgets are deleted by Qt.  The top-level layout and all its
   // sub-layouts are deleted by Qt.
   if (m_pEnrollBuffer)
      delete[] m_pEnrollBuffer;
   if (m_pVerifyBuffer)
      delete[] m_pVerifyBuffer;

   // Terminate NBioBSP module
   if(m_hBSP != NBioAPI_INVALID_HANDLE) {
      NBioAPI_FreeFIR(m_hBSP, &m_FullFIR);
      NBioAPI_FreeTextFIR(m_hBSP, &m_TextFIR);
      NBioAPI_FreeFIRHandle(m_hBSP, m_hFIR);
      NBioAPI_CloseDevice(m_hBSP, m_DeviceID);
      NBioAPI_Terminate(m_hBSP);
   }
}


int main(int argc, char **argv)
{
   QApplication NBioBSPDemo(argc, argv);
   
   NBioBSPDemo_Widget Demo;
   Demo.resize(520, 480);
   NBioBSPDemo.setMainWidget(&Demo);

   char chTitle[40] = { 0x00, };
   sprintf(chTitle, "NBioBSPDemo Version : %d.%04d", Demo.m_Version.Major, Demo.m_Version.Minor);
   Demo.setCaption(chTitle);

   Demo.show();
   
   return NBioBSPDemo.exec();
}

