
// NBioNFIQ_TestDlg.h : header file
//

#pragma once


// CNBioNFIQ_TestDlg dialog
class CNBioNFIQ_TestDlg : public CDialog
{
// Construction
public:
	CNBioNFIQ_TestDlg(CWnd* pParent = NULL);	// standard constructor

// Dialog Data
	enum { IDD = IDD_NBIONFIQ_TEST_DIALOG };

	protected:
	virtual void DoDataExchange(CDataExchange* pDX);	// DDX/DDV support


// Implementation
protected:
	HICON m_hIcon;

	// Generated message map functions
	virtual BOOL OnInitDialog();
	afx_msg void OnPaint();
	afx_msg HCURSOR OnQueryDragIcon();
	DECLARE_MESSAGE_MAP()
public:
   afx_msg void OnBnClickedBtbsp();
   afx_msg void OnBnClickedBtraw();
};
