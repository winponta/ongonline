#include <stdio.h>
#include <string.h>
#include "NBioAPI.h"
#include "NBioAPI_Export.h"
#include "NExportRawToISO_Api.h"

int main(void)
{
   printf("NExportRawToISO test start!!\n");

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
 
               nRet = NBioAPI_ExportRawToISOV1(&exportAuditData, &pISOBuf, &nISOBufLen, NBioAPI_FALSE, NEXPORT_COMPRESS_MOD_NONE);

               if (nRet == NBioAPIERROR_NONE)  {
                  NIMPORTRAWSET ImportRawSet;

                  nRet = NBioAPI_ImportISOToRaw(pISOBuf, nISOBufLen, &ImportRawSet);

                  if (nRet == NBioAPIERROR_NONE)  {
                     NBioAPI_SINT32 i;
                     NBioAPI_EXPORT_AUDIT_DATA importAuditData;
                     NBioAPI_FIR_HANDLE hImportAudit, hImportFIR;
                     
                     memset(&importAuditData, 0, sizeof(NBioAPI_EXPORT_AUDIT_DATA));
                     
                     importAuditData.Length = sizeof(NBioAPI_EXPORT_AUDIT_DATA);
                     importAuditData.FingerNum = ImportRawSet.nDataCount;
                     importAuditData.SamplesPerFinger = 1;
                     importAuditData.ImageWidth = ImportRawSet.pImportRawData[0].nImgWidth;
                     importAuditData.ImageHeight = ImportRawSet.pImportRawData[0].nImgHeight;
                     importAuditData.AuditData = new NBioAPI_AUDIT_DATA[importAuditData.FingerNum];
                     
                     for (i = 0; i < importAuditData.FingerNum; i++)  {
                        printf("DataLen: %d, FingerID: %d, Width: %d, Height: %d\n", ImportRawSet.pImportRawData[i].nDataLen,
                                                                                     ImportRawSet.pImportRawData[i].nFingerID,
                                                                                     ImportRawSet.pImportRawData[i].nImgWidth,
                                                                                     ImportRawSet.pImportRawData[i].nImgHeight);
                        
                        importAuditData.AuditData[i].Length = sizeof(NBioAPI_AUDIT_DATA);
                        importAuditData.AuditData[i].FingerID = ImportRawSet.pImportRawData[i].nFingerID;
                        importAuditData.AuditData[i].Image = new NBioAPI_IMAGE_DATA[1];
                        importAuditData.AuditData[i].Image[0].Length = sizeof(NBioAPI_IMAGE_DATA);
                        importAuditData.AuditData[i].Image[0].Data = ImportRawSet.pImportRawData[i].pRawData;
                     }
                     
                     nRet = NBioAPI_ImageToNBioBSP(hNBioBSP, &importAuditData, &hImportAudit);
                     
                     if (nRet == NBioAPIERROR_NONE)  {
                        inputFIR.Form = NBioAPI_FIR_FORM_HANDLE;
                        inputFIR.InputFIR.FIRinBSP = &hImportAudit;

                        nRet = NBioAPI_Process(hNBioBSP, &inputFIR, &hImportFIR);

                        if (nRet == NBioAPIERROR_NONE)  {
                           NBioAPI_BOOL bMatch;
                           NBioAPI_INPUT_FIR inputFIR2;
                           
                           inputFIR.Form = NBioAPI_FIR_FORM_HANDLE;
                           inputFIR.InputFIR.FIRinBSP = &hImportFIR;
                           
                           inputFIR2.Form = NBioAPI_FIR_FORM_HANDLE;
                           inputFIR2.InputFIR.FIRinBSP = &hFIR;
                           
                           nRet = NBioAPI_VerifyMatch(hNBioBSP, &inputFIR, &inputFIR2, &bMatch, NULL);

                           if (nRet == NBioAPIERROR_NONE)  {
                              if (bMatch)
                                 printf("Matching Success\n");
                              else
                                 printf("Matching Fail\n");
                           }
            
                           NBioAPI_FreeFIRHandle(hNBioBSP, hImportFIR);
                        }
                        
                        NBioAPI_FreeFIRHandle(hNBioBSP, hImportAudit);
                     }
 
                     for (i = 0; i < importAuditData.FingerNum; i++)
                        delete[] importAuditData.AuditData[i].Image;
                        
                     delete[] importAuditData.AuditData;
                     
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

   printf("NExportRawToISO test end!!");
}
