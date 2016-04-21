// NExportRawToISO_Test.h : main header file for the NEXPORTRAWTOISO_TEST application
//

#if !defined(AFX_NEXPORTRAWTOISO_TEST_H__1DEAAE03_4406_4E6B_B8B1_631F0D4EC58A__INCLUDED_)
#define AFX_NEXPORTRAWTOISO_TEST_H__1DEAAE03_4406_4E6B_B8B1_631F0D4EC58A__INCLUDED_

#if _MSC_VER > 1000
#pragma once
#endif // _MSC_VER > 1000

#ifndef __AFXWIN_H__
	#error include 'stdafx.h' before including this file for PCH
#endif

#include "resource.h"		// main symbols

/////////////////////////////////////////////////////////////////////////////
// CNExportRawToISO_TestApp:
// See NExportRawToISO_Test.cpp for the implementation of this class
//

class CNExportRawToISO_TestApp : public CWinApp
{
public:
	CNExportRawToISO_TestApp();

// Overrides
	// ClassWizard generated virtual function overrides
	//{{AFX_VIRTUAL(CNExportRawToISO_TestApp)
	public:
	virtual BOOL InitInstance();
	//}}AFX_VIRTUAL

// Implementation

	//{{AFX_MSG(CNExportRawToISO_TestApp)
		// NOTE - the ClassWizard will add and remove member functions here.
		//    DO NOT EDIT what you see in these blocks of generated code !
	//}}AFX_MSG
	DECLARE_MESSAGE_MAP()
};


/////////////////////////////////////////////////////////////////////////////

//{{AFX_INSERT_LOCATION}}
// Microsoft Visual C++ will insert additional declarations immediately before the previous line.

#endif // !defined(AFX_NEXPORTRAWTOISO_TEST_H__1DEAAE03_4406_4E6B_B8B1_631F0D4EC58A__INCLUDED_)
