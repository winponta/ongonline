// NExportRawToISO_TestDlg.h : header file
//

#if !defined(AFX_NEXPORTRAWTOISO_TESTDLG_H__B76F4110_BB22_4658_8B76_4C8A36A042AD__INCLUDED_)
#define AFX_NEXPORTRAWTOISO_TESTDLG_H__B76F4110_BB22_4658_8B76_4C8A36A042AD__INCLUDED_

#if _MSC_VER > 1000
#pragma once
#endif // _MSC_VER > 1000

/////////////////////////////////////////////////////////////////////////////
// CNExportRawToISO_TestDlg dialog

class CNExportRawToISO_TestDlg : public CDialog
{
// Construction
public:
	CNExportRawToISO_TestDlg(CWnd* pParent = NULL);	// standard constructor

// Dialog Data
	//{{AFX_DATA(CNExportRawToISO_TestDlg)
	enum { IDD = IDD_NEXPORTRAWTOISO_TEST_DIALOG };
		// NOTE: the ClassWizard will add data members here
	//}}AFX_DATA

	// ClassWizard generated virtual function overrides
	//{{AFX_VIRTUAL(CNExportRawToISO_TestDlg)
	protected:
	virtual void DoDataExchange(CDataExchange* pDX);	// DDX/DDV support
	//}}AFX_VIRTUAL

// Implementation
protected:
	HICON m_hIcon;

	// Generated message map functions
	//{{AFX_MSG(CNExportRawToISO_TestDlg)
	virtual BOOL OnInitDialog();
	afx_msg void OnSysCommand(UINT nID, LPARAM lParam);
	afx_msg void OnPaint();
	afx_msg HCURSOR OnQueryDragIcon();
	afx_msg void OnButton1();
	afx_msg void OnButton2();
	afx_msg void OnButton3();
	afx_msg void OnButton4();
	//}}AFX_MSG
	DECLARE_MESSAGE_MAP()
public:
   afx_msg void OnBnClickedButton5();
};

//{{AFX_INSERT_LOCATION}}
// Microsoft Visual C++ will insert additional declarations immediately before the previous line.

#endif // !defined(AFX_NEXPORTRAWTOISO_TESTDLG_H__B76F4110_BB22_4658_8B76_4C8A36A042AD__INCLUDED_)
