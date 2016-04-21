
// NBioNFIQ_Test.h : main header file for the PROJECT_NAME application
//

#pragma once

#ifndef __AFXWIN_H__
	#error "include 'stdafx.h' before including this file for PCH"
#endif

#include "resource.h"		// main symbols


// CNBioNFIQ_TestApp:
// See NBioNFIQ_Test.cpp for the implementation of this class
//

class CNBioNFIQ_TestApp : public CWinAppEx
{
public:
	CNBioNFIQ_TestApp();

// Overrides
	public:
	virtual BOOL InitInstance();

// Implementation

	DECLARE_MESSAGE_MAP()
};

extern CNBioNFIQ_TestApp theApp;