/*
* File : NBioBSPRollDemo.h
* Author : Daniel
* Description : NBioBSP Roll sample for Linux
* Copyright(c): 2008, NITGEN Co., Ltd.
* History : 
*
*/

#ifndef NBIOBSPROLLDEMO_H
#define NBIOBSPROLLDEMO_H


#include <qwidget.h>
#include <qmainwindow.h>
#include <qintdict.h>
#include <qcanvas.h>
#include <qthread.h>

#include <qapplication.h>
#include <qlabel.h>
#include <qcolor.h>
#include <qpushbutton.h>
#include <qlayout.h>
#include <qlineedit.h>
#include <qmultilineedit.h>
#include <qmenubar.h>
#include <qpopupmenu.h>
#include <qbuttongroup.h>
#include <qframe.h>
#include <qstatusbar.h>
#include <qmessagebox.h>
#include <qimage.h>
#include <qpainter.h>
#include <qcombobox.h>
#include <qradiobutton.h>
#include <string.h>
#include <pthread.h>
#include <sys/time.h>

#include "../../../include/NBioAPI.h"
#include "../../../include/NBioAPI_Export.h"

#define IMAGE_FRAME_WIDTH	    300
#define IMAGE_FRAME_HEIGHT	    300

class ButtonsGroups : public QWidget {
   Q_OBJECT
      
public:
   ButtonsGroups( QWidget *parent = 0, const char *name = 0 );
   
};

class NBioBSPRollDemo_Widget: public QMainWindow	//, public QWidget
{
   Q_OBJECT
public:
   void Initialize(void);
   void InitNBioBSPModule();
   void DisplayError(NBioAPI_RETURN errCode);
   NBioAPI_RETURN    DisplayDeviceList();

   NBioBSPRollDemo_Widget (QWidget *parent = 0, const char * name = 0);
   ~NBioBSPRollDemo_Widget();
   
public:
   QGroupBox		      *gbox_Device;
   QGroupBox		      *gbox_Capture;
   QGroupBox		      *gbox_UISet;
   QGroupBox		      *gbox_Type2;
   QGroupBox		      *gbox_Match;
   
   QLabel 		      *lbl_Device;
   
   QComboBox		      *cb_DEV_LIST;
   
   QPushButton		      *pb_OPEN;
   QPushButton		      *pb_RollStart; 
   QPushButton		      *pb_RollMatch;
   QPushButton		      *pb_EXIT;   
   
   QImage		      m_RollImage;
   QFrame		      *m_frmRoll;
   
   unsigned char	      *m_pRollImage;
   
   QRadioButton		      *rb_DrawImageY;
   QRadioButton		      *rb_DrawImageN;
   
   NBioAPI_HANDLE             m_hNBioBSP;

   NBioAPI_UINT32             m_nDeviceCnt;
   NBioAPI_DEVICE_ID*         m_pDeviceList;
   NBioAPI_DEVICE_INFO_EX_PTR m_pDeviceInfoEx;
   NBioAPI_DEVICE_ID          m_DeviceID;
   NBioAPI_DEVICE_ID	      m_DeviceIDOld;
   NBioAPI_DEVICE_INFO_0      m_DeviceInfo0;
   
   unsigned int		      m_DeviceList;
   unsigned int		      m_ScanType;

   NBioAPI_FIR_HANDLE         m_hCapturedFIR1;
   NBioAPI_FIR_HANDLE         m_hCapturedAudit1;

   // Version
   NBioAPI_VERSION			m_Version;
signals:
   void closed();
   void activated(int);
   
protected:
   void paintEvent(QPaintEvent *);
   void closeEvent(QCloseEvent *);
   
   
public slots:
   void OnComboDeviceList();
   void OnBtnOpenDevice();
   void OnRadioYes();
   void OnRadioNo();
   void OnBtnStart();
   void OnBtnVerifyMatch();
   void OnBtnExit();
};

#endif
