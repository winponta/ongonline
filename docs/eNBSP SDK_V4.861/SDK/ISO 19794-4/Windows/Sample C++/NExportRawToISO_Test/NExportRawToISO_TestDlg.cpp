// NExportRawToISO_TestDlg.cpp : implementation file
//

#include "stdafx.h"
#include "NExportRawToISO_Test.h"
#include "NExportRawToISO_TestDlg.h"
#include "NBioAPI.h"
#include "NBioAPI_Export.h"
#include "NBioAPI_ImgConvISO.h"
#include "NExportRawToISO_Util.h"

#ifdef _DEBUG
#define new DEBUG_NEW
#undef THIS_FILE
static char THIS_FILE[] = __FILE__;
#endif

/////////////////////////////////////////////////////////////////////////////
// CAboutDlg dialog used for App About

class CAboutDlg : public CDialog
{
public:
	CAboutDlg();

// Dialog Data
	//{{AFX_DATA(CAboutDlg)
	enum { IDD = IDD_ABOUTBOX };
	//}}AFX_DATA

	// ClassWizard generated virtual function overrides
	//{{AFX_VIRTUAL(CAboutDlg)
	protected:
	virtual void DoDataExchange(CDataExchange* pDX);    // DDX/DDV support
	//}}AFX_VIRTUAL

// Implementation
protected:
	//{{AFX_MSG(CAboutDlg)
	//}}AFX_MSG
	DECLARE_MESSAGE_MAP()
};

CAboutDlg::CAboutDlg() : CDialog(CAboutDlg::IDD)
{
	//{{AFX_DATA_INIT(CAboutDlg)
	//}}AFX_DATA_INIT
}

void CAboutDlg::DoDataExchange(CDataExchange* pDX)
{
	CDialog::DoDataExchange(pDX);
	//{{AFX_DATA_MAP(CAboutDlg)
	//}}AFX_DATA_MAP
}

BEGIN_MESSAGE_MAP(CAboutDlg, CDialog)
	//{{AFX_MSG_MAP(CAboutDlg)
		// No message handlers
	//}}AFX_MSG_MAP
END_MESSAGE_MAP()

/////////////////////////////////////////////////////////////////////////////
// CNExportRawToISO_TestDlg dialog

CNExportRawToISO_TestDlg::CNExportRawToISO_TestDlg(CWnd* pParent /*=NULL*/)
	: CDialog(CNExportRawToISO_TestDlg::IDD, pParent)
{
	//{{AFX_DATA_INIT(CNExportRawToISO_TestDlg)
		// NOTE: the ClassWizard will add member initialization here
	//}}AFX_DATA_INIT
	// Note that LoadIcon does not require a subsequent DestroyIcon in Win32
	m_hIcon = AfxGetApp()->LoadIcon(IDR_MAINFRAME);
}

void CNExportRawToISO_TestDlg::DoDataExchange(CDataExchange* pDX)
{
	CDialog::DoDataExchange(pDX);
	//{{AFX_DATA_MAP(CNExportRawToISO_TestDlg)
		// NOTE: the ClassWizard will add DDX and DDV calls here
	//}}AFX_DATA_MAP
}

BEGIN_MESSAGE_MAP(CNExportRawToISO_TestDlg, CDialog)
	//{{AFX_MSG_MAP(CNExportRawToISO_TestDlg)
	ON_WM_SYSCOMMAND()
	ON_WM_PAINT()
	ON_WM_QUERYDRAGICON()
	ON_BN_CLICKED(IDC_BUTTON1, OnButton1)
	ON_BN_CLICKED(IDC_BUTTON2, OnButton2)
	ON_BN_CLICKED(IDC_BUTTON3, OnButton3)
	ON_BN_CLICKED(IDC_BUTTON4, OnButton4)
	//}}AFX_MSG_MAP
   ON_BN_CLICKED(IDC_BUTTON5, &CNExportRawToISO_TestDlg::OnBnClickedButton5)
END_MESSAGE_MAP()

/////////////////////////////////////////////////////////////////////////////
// CNExportRawToISO_TestDlg message handlers

BOOL CNExportRawToISO_TestDlg::OnInitDialog()
{
	CDialog::OnInitDialog();

	// Add "About..." menu item to system menu.

	// IDM_ABOUTBOX must be in the system command range.
	ASSERT((IDM_ABOUTBOX & 0xFFF0) == IDM_ABOUTBOX);
	ASSERT(IDM_ABOUTBOX < 0xF000);

	CMenu* pSysMenu = GetSystemMenu(FALSE);
	if (pSysMenu != NULL)
	{
		CString strAboutMenu;
		strAboutMenu.LoadString(IDS_ABOUTBOX);
		if (!strAboutMenu.IsEmpty())
		{
			pSysMenu->AppendMenu(MF_SEPARATOR);
			pSysMenu->AppendMenu(MF_STRING, IDM_ABOUTBOX, strAboutMenu);
		}
	}

	// Set the icon for this dialog.  The framework does this automatically
	//  when the application's main window is not a dialog
	SetIcon(m_hIcon, TRUE);			// Set big icon
	SetIcon(m_hIcon, FALSE);		// Set small icon
	
	// TODO: Add extra initialization here
	
	return TRUE;  // return TRUE  unless you set the focus to a control
}

void CNExportRawToISO_TestDlg::OnSysCommand(UINT nID, LPARAM lParam)
{
	if ((nID & 0xFFF0) == IDM_ABOUTBOX)
	{
		CAboutDlg dlgAbout;
		dlgAbout.DoModal();
	}
	else
	{
		CDialog::OnSysCommand(nID, lParam);
	}
}

// If you add a minimize button to your dialog, you will need the code below
//  to draw the icon.  For MFC applications using the document/view model,
//  this is automatically done for you by the framework.

void CNExportRawToISO_TestDlg::OnPaint() 
{
	if (IsIconic())
	{
		CPaintDC dc(this); // device context for painting

		SendMessage(WM_ICONERASEBKGND, (WPARAM) dc.GetSafeHdc(), 0);

		// Center icon in client rectangle
		int cxIcon = GetSystemMetrics(SM_CXICON);
		int cyIcon = GetSystemMetrics(SM_CYICON);
		CRect rect;
		GetClientRect(&rect);
		int x = (rect.Width() - cxIcon + 1) / 2;
		int y = (rect.Height() - cyIcon + 1) / 2;

		// Draw the icon
		dc.DrawIcon(x, y, m_hIcon);
	}
	else
	{
		CDialog::OnPaint();
	}
}

// The system calls this to obtain the cursor to display while the user drags
//  the minimized window.
HCURSOR CNExportRawToISO_TestDlg::OnQueryDragIcon()
{
	return (HCURSOR) m_hIcon;
}

void CNExportRawToISO_TestDlg::OnButton1() 
{
	NBioAPI_HANDLE hNBioBSP;

   NBioAPI_RETURN nRet = NBioAPI_Init(&hNBioBSP);

   if (nRet == NBioAPIERROR_NONE)  {
      nRet = NBioAPI_OpenDevice(hNBioBSP, NBioAPI_DEVICE_ID_AUTO);

      if (nRet == NBioAPIERROR_NONE)  {
         NBioAPI_FIR_HANDLE hFIR, hAudit;

         nRet = NBioAPI_Enroll(hNBioBSP, NULL, &hFIR, NULL, 3000, &hAudit, NULL);

         if (nRet == NBioAPIERROR_NONE)  {
            NBioAPI_INPUT_FIR inputFIR;
            NBioAPI_EXPORT_AUDIT_DATA exportAuditData;

            inputFIR.Form = NBioAPI_FIR_FORM_HANDLE;
            inputFIR.InputFIR.FIRinBSP = &hAudit;

            nRet = NBioAPI_NBioBSPToImage(hNBioBSP, &inputFIR, &exportAuditData);

            if (nRet == NBioAPIERROR_NONE)  {
               NBioAPI_UINT8* pISOBuf;
               NBioAPI_UINT32 nISOBufLen;

               nRet = NBioAPI_ExportRawToISOV1(&exportAuditData, &pISOBuf, &nISOBufLen, FALSE, NEXPORT_COMPRESS_MOD_NONE);

               if (nRet == NBioAPIERROR_NONE)  {
                  NIMPORTRAWSET ImportRawSet;

                  nRet = NBioAPI_ImportISOToRaw(pISOBuf, nISOBufLen, &ImportRawSet);

                  if (nRet == NBioAPIERROR_NONE)  {
                     CString szMsg, szTemp;

                     for (int i = 0; i < ImportRawSet.nDataCount; i++)  {
                        szTemp.Format("DataLen: %d, FingerID: %d, Width: %d, Height: %d", ImportRawSet.pImportRawData[i].nDataLen, 
                                                                                          ImportRawSet.pImportRawData[i].nFingerID, 
                                                                                          ImportRawSet.pImportRawData[i].nImgWidth, 
                                                                                          ImportRawSet.pImportRawData[i].nImgHeight);
                        szMsg += szTemp;
                        szMsg += "\n";
                     }

                     AfxMessageBox(szMsg);

                     NBioAPI_FreeImportRawSet(&ImportRawSet);
                  }

                  NBioAPI_FreeExportISOData(pISOBuf);
               }
               
               NBioAPI_FreeExportAuditData(hNBioBSP, &exportAuditData);
            }

            NBioAPI_FreeFIRHandle(hNBioBSP, hFIR);
            NBioAPI_FreeFIRHandle(hNBioBSP, hAudit);
         }

         NBioAPI_CloseDevice(hNBioBSP, NBioAPI_DEVICE_ID_AUTO);
      }

      NBioAPI_Terminate(hNBioBSP);
   }
}

void CNExportRawToISO_TestDlg::OnButton2() 
{
   NBioAPI_HANDLE hNBioBSP;
   
   NBioAPI_RETURN nRet = NBioAPI_Init(&hNBioBSP);
   
   if (nRet == NBioAPIERROR_NONE)  {
      nRet = NBioAPI_OpenDevice(hNBioBSP, NBioAPI_DEVICE_ID_AUTO);
      
      if (nRet == NBioAPIERROR_NONE)  {
         NBioAPI_FIR_HANDLE hFIR, hAudit;
         
         nRet = NBioAPI_Enroll(hNBioBSP, NULL, &hFIR, NULL, 3000, &hAudit, NULL);
         
         if (nRet == NBioAPIERROR_NONE)  {
            NBioAPI_INPUT_FIR inputFIR;
            NBioAPI_EXPORT_AUDIT_DATA exportAuditData;
            
            inputFIR.Form = NBioAPI_FIR_FORM_HANDLE;
            inputFIR.InputFIR.FIRinBSP = &hAudit;
            
            nRet = NBioAPI_NBioBSPToImage(hNBioBSP, &inputFIR, &exportAuditData);
            
            if (nRet == NBioAPIERROR_NONE)  {
               NBioAPI_UINT8* pISOBuf;
               NBioAPI_UINT32 nISOBufLen;
               
               nRet = NBioAPI_ExportRawToISOV1(&exportAuditData, &pISOBuf, &nISOBufLen, FALSE, NEXPORT_COMPRESS_MOD_WSQ);
               
               if (nRet == NBioAPIERROR_NONE)  {
                  NIMPORTRAWSET ImportRawSet;
                  
                  nRet = NBioAPI_ImportISOToRaw(pISOBuf, nISOBufLen, &ImportRawSet);
                  
                  if (nRet == NBioAPIERROR_NONE)  {
                     CString szMsg, szTemp;
                     
                     for (int i = 0; i < ImportRawSet.nDataCount; i++)  {
                        szTemp.Format("DataLen: %d, FingerID: %d, Width: %d, Height: %d", ImportRawSet.pImportRawData[i].nDataLen, 
                                                                                          ImportRawSet.pImportRawData[i].nFingerID, 
                                                                                          ImportRawSet.pImportRawData[i].nImgWidth, 
                                                                                          ImportRawSet.pImportRawData[i].nImgHeight);
                        szMsg += szTemp;
                        szMsg += "\n";
                     }
                     
                     AfxMessageBox(szMsg);
                     
                     NBioAPI_FreeImportRawSet(&ImportRawSet);
                  }
                  
                  NBioAPI_FreeExportISOData(pISOBuf);
               }
               
               NBioAPI_FreeExportAuditData(hNBioBSP, &exportAuditData);
            }
            
            NBioAPI_FreeFIRHandle(hNBioBSP, hFIR);
            NBioAPI_FreeFIRHandle(hNBioBSP, hAudit);
         }
         
         NBioAPI_CloseDevice(hNBioBSP, NBioAPI_DEVICE_ID_AUTO);
      }
      
      NBioAPI_Terminate(hNBioBSP);
   }
}

void CNExportRawToISO_TestDlg::OnButton3() 
{
   NBioAPI_HANDLE hNBioBSP;
   
   NBioAPI_RETURN nRet = NBioAPI_Init(&hNBioBSP);
   
   if (nRet == NBioAPIERROR_NONE)  {
      nRet = NBioAPI_OpenDevice(hNBioBSP, NBioAPI_DEVICE_ID_AUTO);
      
      if (nRet == NBioAPIERROR_NONE)  {
         NBioAPI_FIR_HANDLE hFIR, hAudit;
         
         nRet = NBioAPI_Capture(hNBioBSP, NBioAPI_FIR_PURPOSE_VERIFY, &hFIR, 3000, &hAudit, NULL);
         
         if (nRet == NBioAPIERROR_NONE)  {
            NBioAPI_INPUT_FIR inputFIR;
            NBioAPI_EXPORT_AUDIT_DATA exportAuditData;
            
            inputFIR.Form = NBioAPI_FIR_FORM_HANDLE;
            inputFIR.InputFIR.FIRinBSP = &hAudit;
            
            nRet = NBioAPI_NBioBSPToImage(hNBioBSP, &inputFIR, &exportAuditData);
            
            if (nRet == NBioAPIERROR_NONE)  {
               NBioAPI_UINT8* pISOBuf;
               NBioAPI_UINT32 nISOBufLen;
               
               nRet = NBioAPI_ExportRawToISOV2(exportAuditData.AuditData[0].FingerID, exportAuditData.ImageWidth, exportAuditData.ImageHeight, 
                                               exportAuditData.AuditData[0].Image[0].Data, &pISOBuf, &nISOBufLen, FALSE, NEXPORT_COMPRESS_MOD_NONE);
               
               if (nRet == NBioAPIERROR_NONE)  {
                  NIMPORTRAWSET ImportRawSet;
                  
                  nRet = NBioAPI_ImportISOToRaw(pISOBuf, nISOBufLen, &ImportRawSet);
                  
                  if (nRet == NBioAPIERROR_NONE)  {
                     CString szMsg, szTemp;
                     
                     for (int i = 0; i < ImportRawSet.nDataCount; i++)  {
                        szTemp.Format("DataLen: %d, FingerID: %d, Width: %d, Height: %d", ImportRawSet.pImportRawData[i].nDataLen, 
                                                                                          ImportRawSet.pImportRawData[i].nFingerID, 
                                                                                          ImportRawSet.pImportRawData[i].nImgWidth, 
                                                                                          ImportRawSet.pImportRawData[i].nImgHeight);
                        szMsg += szTemp;
                        szMsg += "\n";
                     }
                     
                     AfxMessageBox(szMsg);
                     
                     NBioAPI_FreeImportRawSet(&ImportRawSet);
                  }
                  
                  NBioAPI_FreeExportISOData(pISOBuf);
               }
               
               NBioAPI_FreeExportAuditData(hNBioBSP, &exportAuditData);
            }
            
            NBioAPI_FreeFIRHandle(hNBioBSP, hFIR);
            NBioAPI_FreeFIRHandle(hNBioBSP, hAudit);
         }
         
         NBioAPI_CloseDevice(hNBioBSP, NBioAPI_DEVICE_ID_AUTO);
      }
      
      NBioAPI_Terminate(hNBioBSP);
   }
}

void CNExportRawToISO_TestDlg::OnButton4() 
{
   NBioAPI_HANDLE hNBioBSP;
   
   NBioAPI_RETURN nRet = NBioAPI_Init(&hNBioBSP);
   
   if (nRet == NBioAPIERROR_NONE)  {
      nRet = NBioAPI_OpenDevice(hNBioBSP, NBioAPI_DEVICE_ID_AUTO);
      
      if (nRet == NBioAPIERROR_NONE)  {
         NBioAPI_FIR_HANDLE hFIR, hAudit;
         
         nRet = NBioAPI_Capture(hNBioBSP, NBioAPI_FIR_PURPOSE_VERIFY, &hFIR, 3000, &hAudit, NULL);
         
         if (nRet == NBioAPIERROR_NONE)  {
            NBioAPI_INPUT_FIR inputFIR;
            NBioAPI_EXPORT_AUDIT_DATA exportAuditData;
            
            inputFIR.Form = NBioAPI_FIR_FORM_HANDLE;
            inputFIR.InputFIR.FIRinBSP = &hAudit;
            
            nRet = NBioAPI_NBioBSPToImage(hNBioBSP, &inputFIR, &exportAuditData);
            
            if (nRet == NBioAPIERROR_NONE)  {
               NBioAPI_UINT8* pISOBuf;
               NBioAPI_UINT32 nISOBufLen;
               
               nRet = NBioAPI_ExportRawToISOV2(exportAuditData.AuditData[0].FingerID, exportAuditData.ImageWidth, exportAuditData.ImageHeight, 
                                               exportAuditData.AuditData[0].Image[0].Data, &pISOBuf, &nISOBufLen, FALSE, NEXPORT_COMPRESS_MOD_WSQ);
               
               if (nRet == NBioAPIERROR_NONE)  {
                  NIMPORTRAWSET ImportRawSet;
                  
                  nRet = NBioAPI_ImportISOToRaw(pISOBuf, nISOBufLen, &ImportRawSet);
                  
                  if (nRet == NBioAPIERROR_NONE)  {
                     CString szMsg, szTemp;
                     
                     for (int i = 0; i < ImportRawSet.nDataCount; i++)  {
                        szTemp.Format("DataLen: %d, FingerID: %d, Width: %d, Height: %d", ImportRawSet.pImportRawData[i].nDataLen, 
                                                                                          ImportRawSet.pImportRawData[i].nFingerID, 
                                                                                          ImportRawSet.pImportRawData[i].nImgWidth, 
                                                                                          ImportRawSet.pImportRawData[i].nImgHeight);
                        szMsg += szTemp;
                        szMsg += "\n";
                     }
                     
                     AfxMessageBox(szMsg);
                     
                     NBioAPI_FreeImportRawSet(&ImportRawSet);
                  }
                  
                  NBioAPI_FreeExportISOData(pISOBuf);
               }
               
               NBioAPI_FreeExportAuditData(hNBioBSP, &exportAuditData);
            }
            
            NBioAPI_FreeFIRHandle(hNBioBSP, hFIR);
            NBioAPI_FreeFIRHandle(hNBioBSP, hAudit);
         }
         
         NBioAPI_CloseDevice(hNBioBSP, NBioAPI_DEVICE_ID_AUTO);
      }
      
      NBioAPI_Terminate(hNBioBSP);
   }
}

NBioAPI_RETURN MakeISO_4Data(NBioAPI_HANDLE hNBioBSP, NBioAPI_UINT8** ppISOBuf, NBioAPI_UINT32* pnISOBufLen)
{
   NBioAPI_RETURN nRet = NBioAPI_OpenDevice(hNBioBSP, NBioAPI_DEVICE_ID_AUTO);

   if (nRet == NBioAPIERROR_NONE)  {
      NBioAPI_FIR_HANDLE hFIR, hAudit;

      nRet = NBioAPI_Enroll(hNBioBSP, NULL, &hFIR, NULL, 3000, &hAudit, NULL);

      if (nRet == NBioAPIERROR_NONE)  {
         NBioAPI_INPUT_FIR inputFIR;
         NBioAPI_EXPORT_AUDIT_DATA exportAuditData;

         inputFIR.Form = NBioAPI_FIR_FORM_HANDLE;
         inputFIR.InputFIR.FIRinBSP = &hAudit;

         nRet = NBioAPI_NBioBSPToImage(hNBioBSP, &inputFIR, &exportAuditData);

         if (nRet == NBioAPIERROR_NONE)  {
            nRet = NBioAPI_ExportRawToISOV1(&exportAuditData, ppISOBuf, pnISOBufLen, FALSE, NEXPORT_COMPRESS_MOD_NONE);

            NBioAPI_FreeExportAuditData(hNBioBSP, &exportAuditData);
         }

         NBioAPI_FreeFIRHandle(hNBioBSP, hFIR);
         NBioAPI_FreeFIRHandle(hNBioBSP, hAudit);
      }

      NBioAPI_CloseDevice(hNBioBSP, NBioAPI_DEVICE_ID_AUTO);
   }

   return nRet;
}

void CNExportRawToISO_TestDlg::OnBnClickedButton5()
{
   NBioAPI_HANDLE hNBioBSP;

   NBioAPI_RETURN nRet = NBioAPI_Init(&hNBioBSP);

   if (nRet == NBioAPIERROR_NONE)  {
      NBioAPI_UINT8* pISOBuf;
      NBioAPI_UINT32 nISOBufLen;

      nRet = MakeISO_4Data(hNBioBSP, &pISOBuf, &nISOBufLen);

      if (nRet == NBioAPIERROR_NONE)  {
         NBioAPI_EXPORT_DATA exportData;

         nRet = NBioAPI_ConvertISO_4ToISO_2(hNBioBSP, pISOBuf, nISOBufLen, &exportData);

         if (nRet == NBioAPIERROR_NONE)  {
            NBioAPI_UINT8* pStreamBuf;
            NBioAPI_UINT32 nStreamLen;

            if (NBioAPI_ISO_2ToStream(&exportData, &pStreamBuf, &nStreamLen))  {
               NBioAPI_EXPORT_DATA exportFromStream;

               if (NBioAPI_StreamToISO_2(pStreamBuf, nStreamLen, &exportFromStream))  {
                  NBioAPI_FIR_HANDLE hProcessedFIR;

                  nRet = NBioAPI_ImportDataToNBioBSP(hNBioBSP, &exportFromStream, NBioAPI_FIR_PURPOSE_VERIFY, &hProcessedFIR);

                  if (nRet == NBioAPIERROR_NONE)  {
                     NBioAPI_INPUT_FIR inputFIR;
                     NBioAPI_BOOL bMatched;

                     inputFIR.Form = NBioAPI_FIR_FORM_HANDLE;
                     inputFIR.InputFIR.FIRinBSP = &hProcessedFIR;

                     NBioAPI_OpenDevice(hNBioBSP, NBioAPI_DEVICE_ID_AUTO);
                     nRet = NBioAPI_Verify(hNBioBSP, &inputFIR, &bMatched, NBioAPI_NULL, -1, NULL, NULL);
                     NBioAPI_CloseDevice(hNBioBSP, NBioAPI_DEVICE_ID_AUTO);

                     if (nRet == NBioAPIERROR_NONE)  {
                        if (bMatched)  {
                           AfxMessageBox("Match Success!!");
                        }
                        else  {
                           AfxMessageBox("Match Fail!!");
                        }
                     }
                  }

                  NBioAPI_FreeISO_2_MakeFromStream(&exportFromStream);
               }

               NBioAPI_FreeStream(pStreamBuf);
            }

            NBioAPI_FreeISO_2_MakeFromBSP(hNBioBSP, &exportData);
         }

         NBioAPI_FreeExportISOData(pISOBuf);
      }

      NBioAPI_Terminate(hNBioBSP);
   }
}
