
// NBioNFIQ_TestDlg.cpp : implementation file
//

#include "stdafx.h"
#include "NBioNFIQ_Test.h"
#include "NBioNFIQ_TestDlg.h"
#include "../../Inc/NBioAPI_NFIQ.h"
#include "../../Inc/NBioAPI.h"
#include "../../Inc/NBioAPI_Export.h"


#ifdef _DEBUG
#define new DEBUG_NEW
#endif


// CNBioNFIQ_TestDlg dialog

#ifdef _WIN64
#pragma comment(lib, "../../Lib/x64/NBioBSP.lib")
#pragma comment(lib, "../../Lib/x64/NBioNFIQ.lib")
#else
#pragma comment(lib, "../../Lib/NBioBSP.lib")
#pragma comment(lib, "../../Lib/NBioNFIQ.lib")
#endif // _WIN64


CNBioNFIQ_TestDlg::CNBioNFIQ_TestDlg(CWnd* pParent /*=NULL*/)
	: CDialog(CNBioNFIQ_TestDlg::IDD, pParent)
{
	m_hIcon = AfxGetApp()->LoadIcon(IDR_MAINFRAME);
}

void CNBioNFIQ_TestDlg::DoDataExchange(CDataExchange* pDX)
{
	CDialog::DoDataExchange(pDX);
}

BEGIN_MESSAGE_MAP(CNBioNFIQ_TestDlg, CDialog)
	ON_WM_PAINT()
	ON_WM_QUERYDRAGICON()
	//}}AFX_MSG_MAP
   ON_BN_CLICKED(IDC_BTBSP, &CNBioNFIQ_TestDlg::OnBnClickedBtbsp)
   ON_BN_CLICKED(IDC_BTRAW, &CNBioNFIQ_TestDlg::OnBnClickedBtraw)
END_MESSAGE_MAP()


// CNBioNFIQ_TestDlg message handlers

BOOL CNBioNFIQ_TestDlg::OnInitDialog()
{
	CDialog::OnInitDialog();

	// Set the icon for this dialog.  The framework does this automatically
	//  when the application's main window is not a dialog
	SetIcon(m_hIcon, TRUE);			// Set big icon
	SetIcon(m_hIcon, FALSE);		// Set small icon

	// TODO: Add extra initialization here

	return TRUE;  // return TRUE  unless you set the focus to a control
}

// If you add a minimize button to your dialog, you will need the code below
//  to draw the icon.  For MFC applications using the document/view model,
//  this is automatically done for you by the framework.

void CNBioNFIQ_TestDlg::OnPaint()
{
	if (IsIconic())
	{
		CPaintDC dc(this); // device context for painting

		SendMessage(WM_ICONERASEBKGND, reinterpret_cast<WPARAM>(dc.GetSafeHdc()), 0);

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

// The system calls this function to obtain the cursor to display while the user drags
//  the minimized window.
HCURSOR CNBioNFIQ_TestDlg::OnQueryDragIcon()
{
	return static_cast<HCURSOR>(m_hIcon);
}


void CNBioNFIQ_TestDlg::OnBnClickedBtbsp()
{
   NBioAPI_HANDLE hNBioBSP;

   NBioAPI_RETURN nRet = NBioAPI_Init(&hNBioBSP);

   if (nRet == NBioAPIERROR_NONE)  {
      nRet = NBioAPI_OpenDevice(hNBioBSP, NBioAPI_DEVICE_ID_AUTO);

      if (nRet == NBioAPIERROR_NONE)  {
         NBioAPI_FIR_HANDLE hEnrollFIR, hEnrollAuditFIR;

         nRet = NBioAPI_Enroll(hNBioBSP, NULL, &hEnrollFIR, NULL, -1, &hEnrollAuditFIR, NULL);

         if (nRet == NBioAPIERROR_NONE)  {
            NBioAPI_INPUT_FIR inputFIR;
            NBioAPI_EXPORT_AUDIT_DATA exportAudit;

            inputFIR.Form = NBioAPI_FIR_FORM_HANDLE;
            inputFIR.InputFIR.FIRinBSP = &hEnrollAuditFIR;

            nRet = NBioAPI_NBioBSPToImage(hNBioBSP, &inputFIR, &exportAudit);

            NBioAPI_FreeFIRHandle(hNBioBSP, hEnrollFIR);
            NBioAPI_FreeFIRHandle(hNBioBSP, hEnrollAuditFIR);

            if (nRet == NBioAPIERROR_NONE)  {
               NBioAPI_QUALITY_INFO_0 Q0;

               nRet = NBioAPI_GetNFIQInfo(&exportAudit, &Q0);

               NBioAPI_FreeExportAuditData(hNBioBSP, &exportAudit);

               if (nRet == NBioAPIERROR_NONE)  {
                  CString szMsg, szTemp;

                  for (NBioAPI_FINGER_ID n = NBioAPI_FINGER_ID_UNKNOWN; n < NBioAPI_FINGER_ID_MAX; n++)  {
                     szTemp.Format(_T("FingerID: %d, NFIQ Value: %d, %d\n"), n, Q0.Quality[n][0], Q0.Quality[n][1]);
                     szMsg += szTemp;
                  }

                  AfxMessageBox(szMsg);
               }
            }
         }

         NBioAPI_CloseDevice(hNBioBSP, NBioAPI_DEVICE_ID_AUTO);
      }

      NBioAPI_Terminate(hNBioBSP);
   }

   if (nRet != NBioAPIERROR_NONE)  {
      CString szErr;

      szErr.Format(_T("Error: %d"), nRet);
      AfxMessageBox(szErr);
   }
}

void CNBioNFIQ_TestDlg::OnBnClickedBtraw()
{
   NBioAPI_HANDLE hNBioBSP;

   NBioAPI_RETURN nRet = NBioAPI_Init(&hNBioBSP);

   if (nRet == NBioAPIERROR_NONE)  {
      nRet = NBioAPI_OpenDevice(hNBioBSP, NBioAPI_DEVICE_ID_AUTO);

      if (nRet == NBioAPIERROR_NONE)  {
         NBioAPI_FIR_HANDLE hCaptureFIR, hCaptureAuditFIR;

         nRet = NBioAPI_Capture(hNBioBSP, NBioAPI_FIR_PURPOSE_AUDIT, &hCaptureFIR, -1, &hCaptureAuditFIR, NULL);

         if (nRet == NBioAPIERROR_NONE)  {
            NBioAPI_INPUT_FIR inputFIR;
            NBioAPI_EXPORT_AUDIT_DATA exportAudit;

            inputFIR.Form = NBioAPI_FIR_FORM_HANDLE;
            inputFIR.InputFIR.FIRinBSP = &hCaptureAuditFIR;

            nRet = NBioAPI_NBioBSPToImage(hNBioBSP, &inputFIR, &exportAudit);

            NBioAPI_FreeFIRHandle(hNBioBSP, hCaptureFIR);
            NBioAPI_FreeFIRHandle(hNBioBSP, hCaptureAuditFIR);

            if (nRet == NBioAPIERROR_NONE)  {
               int nNFIQV;

               nRet = NBioAPI_GetNFIQInfoFromRaw(exportAudit.AuditData[0].Image[0].Data, exportAudit.ImageWidth, exportAudit.ImageHeight, &nNFIQV);

               NBioAPI_FreeExportAuditData(hNBioBSP, &exportAudit);

               if (nRet == NBioAPIERROR_NONE)  {
                  CString szMsg;

                  szMsg.Format(_T("NFIQ Value: %d"), nNFIQV);

                  AfxMessageBox(szMsg);
               }
            }
         }

         NBioAPI_CloseDevice(hNBioBSP, NBioAPI_DEVICE_ID_AUTO);
      }

      NBioAPI_Terminate(hNBioBSP);
   }

   if (nRet != NBioAPIERROR_NONE)  {
      CString szErr;

      szErr.Format(_T("Error: %d"), nRet);
      AfxMessageBox(szErr);
   }
}
