#pragma once

#include "NBioAPI.h"
#include "NBioAPI_Export.h"
#include "NBioAPI_ImgConvISO.h"

NBioAPI_RETURN NBioAPI_ConvertISO_4ToISO_2(NBioAPI_HANDLE             hNBSP,
                                           NBioAPI_UINT8*             pISOBuf, 
                                           NBioAPI_UINT32             nISOBufLen, 
                                           NBioAPI_EXPORT_DATA_PTR    pExportData);
NBioAPI_RETURN NBioAPI_ConvertISO_4ToFIR(NBioAPI_HANDLE           hNBSP,
                                         NBioAPI_UINT8*           pISOBuf, 
                                         NBioAPI_UINT32           nISOBufLen, 
                                         NBioAPI_FIR_HANDLE_PTR   phFIR);

NBioAPI_BOOL NBioAPI_ISO_2ToStream(NBioAPI_EXPORT_DATA_PTR pExportData, NBioAPI_UINT8** ppStreamBuf, NBioAPI_UINT32* pStreamLen);
NBioAPI_BOOL NBioAPI_StreamToISO_2(NBioAPI_UINT8* pStreamBuf, NBioAPI_UINT32 nStreamLen, NBioAPI_EXPORT_DATA_PTR pExportData);

void NBioAPI_FreeISO_2_MakeFromBSP(NBioAPI_HANDLE hNBSP, NBioAPI_EXPORT_DATA_PTR pExportData);
void NBioAPI_FreeISO_2_MakeFromStream(NBioAPI_EXPORT_DATA_PTR pExportData);
void NBioAPI_FreeISOFIRHandle(NBioAPI_HANDLE hNBSP, NBioAPI_FIR_HANDLE hFIR);
void NBioAPI_FreeStream(NBioAPI_UINT8* pStreamBuf);