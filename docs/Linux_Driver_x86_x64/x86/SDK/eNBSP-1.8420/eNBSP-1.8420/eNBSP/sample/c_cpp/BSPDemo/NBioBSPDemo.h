/*
* File : NBioBSPDemo.h
* Author : Khan, Jake
* Description : NBioBSP sample for Linux
* Copyright(c): 2004, NITGEN Co., Ltd.
* History : 
*
*/

#ifndef NBIOBSPDEMO_H
#define NBIOBSPDEMO_H

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

#define IMAGE_FRAME_WIDTH	    65
#define IMAGE_FRAME_HEIGHT	    75

class ButtonsGroups : public QWidget {
   Q_OBJECT
      
public:
   ButtonsGroups( QWidget *parent = 0, const char *name = 0 );
   
};

class NBioBSPDemo_Widget: public QMainWindow	//, public QWidget
{
   Q_OBJECT
public:
   void    DisplayDeviceList(void);
   void    DisplayError(NBioAPI_RETURN errCode);
   void    Initialize(void);
   void    thread_function();
   void    InitNBioBSPModule();
   
   static void *start_capture(void* arg);
   NBioBSPDemo_Widget (QWidget * parent = 0, const char *name = 0);
   ~NBioBSPDemo_Widget ();
   
public:
   QGroupBox *gbox_BSP;
   QGroupBox *gbox_DEVICE;
   QGroupBox *gbox_ENROLL;
   QGroupBox *gbox_VERIFY;
   QGroupBox *gbox_RADIO;
   
   QLabel *lbl_VIQ;
   QLabel *lbl_DT;
   QLabel *lbl_SL;
   QLabel *lbl_DEVICE;
   QLabel *lbl_USER;
   QLabel *lbl_DATATYPE;
   
   QPushButton *pb_GET;
   QPushButton *pb_SET;
   QPushButton *pb_OPEN;
   QPushButton *pb_ENROLL;
   QPushButton *pb_VERIFY;
   
   QLineEdit *le_VIQ;
   QLineEdit *le_DT;
   QLineEdit *le_USER;
   
   QComboBox *cb_SECURITYLEVEL;
   QComboBox *cb_DEVICELIST;
   
   QRadioButton *rb_HBSP;
   QRadioButton *rb_FFIR;
   QRadioButton *rb_TFIR;
   QRadioButton *rb_BSTREAM;
   QRadioButton *rb_TSTREAM;

   QImage m_EnrollImage;
   QImage m_VerifyImage;
   QFrame *m_frmENROLL1;
   QFrame *m_frmENROLL2;

   
   NBioAPI_DEVICE_ID       m_DeviceID;
   NBioAPI_DEVICE_ID       m_OpenedDeviceID;
   NBioAPI_DEVICE_INFO_0   m_DeviceInfo0;
   unsigned int            m_DataType;  // 0: Handle, 1: Stream
   /*unsigned*/ long	         m_DefaultTimeout;
   unsigned int	         m_ImageQuality;
   unsigned int            m_SecurityLevel;
   unsigned int            m_DeviceList;

   unsigned char*          m_pEnrollBuffer;
   unsigned char*          m_pVerifyBuffer;

   // Handle for NBioBSP
   NBioAPI_HANDLE			   m_hBSP;
   NBioAPI_FIR_HANDLE		m_hFIR;
   NBioAPI_FIR				   m_FullFIR;
   NBioAPI_FIR_TEXTENCODE	m_TextFIR;

   // Version
   NBioAPI_VERSION			m_Version;

   bool                    m_bEnroll;
   
signals:
   void closed();
   void activated(int);
   
protected:
   void paintEvent(QPaintEvent *);
   void closeEvent(QCloseEvent *);
   
public slots:
   void Dlg_Enroll();
   void Dlg_GetInfo();
   void Dlg_OpenDevice();
   void Dlg_SetInfo();
   void Dlg_Verify();
   void OnRadioFullFIR();
   void OnRadioHandle();
   void OnRadioTextFIR();
   void OnComboDeviceList();
   void OnComboSecurityLevel();
   
};

#endif
