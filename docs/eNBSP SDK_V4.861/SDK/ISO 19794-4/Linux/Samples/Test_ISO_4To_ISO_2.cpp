#include <stdio.h>
#include <string.h>
#include "NBioAPI.h"
#include "NBioAPI_Export.h"
#include "NBioAPI_ImgConvISO.h"
#include "NExportRawToISO_Util.h"

NBioAPI_RETURN MakeISO_19794_4Data(NBioAPI_HANDLE hNBioBSP, NBioAPI_UINT8** ppISOBuf, NBioAPI_UINT32* pnISOBufLen)
{
   NBioAPI_RETURN nRet = NBioAPI_OpenDevice(hNBioBSP, NBioAPI_DEVICE_ID_AUTO);

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
            nRet = NBioAPI_ExportRawToISOV1(&exportAuditData, ppISOBuf, pnISOBufLen, NBioAPI_FALSE, NEXPORT_COMPRESS_MOD_NONE);
            NBioAPI_FreeExportAuditData(hNBioBSP, &exportAuditData);
         }
         
         NBioAPI_FreeFIRHandle(hNBioBSP, hFIR);
         NBioAPI_FreeFIRHandle(hNBioBSP, hAudit); 
      }

      NBioAPI_CloseDevice(hNBioBSP, NBioAPI_DEVICE_ID_AUTO);
   }

   return nRet;
}

int main(void)
{
   printf("NExportRawToISO test ISO 19794-4 ==> ISO 19794-2 start!!\n");

   NBioAPI_HANDLE hNBioBSP;
   NBioAPI_RETURN nRet = NBioAPI_Init(&hNBioBSP);

   if (nRet == NBioAPIERROR_NONE)  {
      NBioAPI_UINT8* pISO_4Data;
      NBioAPI_UINT32 nISO_4DataLen;

      nRet = MakeISO_19794_4Data(hNBioBSP, &pISO_4Data, &nISO_4DataLen);

      if (nRet == NBioAPIERROR_NONE)  {
         NBioAPI_EXPORT_DATA exportISO_2Data;

         printf("ISO 19794-4 data convert to ISO19794-2 data\n");

         nRet = NBioAPI_ConvertISO_4ToISO_2(hNBioBSP, pISO_4Data, nISO_4DataLen, &exportISO_2Data);         

         if (nRet == NBioAPIERROR_NONE)  {
            NBioAPI_UINT8* pISO_2Stream;
            NBioAPI_UINT32 nISO_2StreamLen;

            printf("ISO 19794-2 data convert to the binary stream\n");

            NBioAPI_BOOL bRet = NBioAPI_ISO_2ToStream(&exportISO_2Data, &pISO_2Stream, &nISO_2StreamLen); 

            if (bRet == NBioAPI_TRUE)  {
               NBioAPI_EXPORT_DATA exportFromStream;

               printf("ISO 19794-2 stream data convert to the NBioAPI_EXPORT_DATA structure\n");

               bRet = NBioAPI_StreamToISO_2(pISO_2Stream, nISO_2StreamLen, &exportFromStream); 
            
               if (bRet == NBioAPI_TRUE)  {
                  NBioAPI_FIR_HANDLE hProcessedFIR;

                  printf("VerifyMatch Test Start\n");

                  nRet = NBioAPI_ImportDataToNBioBSP(hNBioBSP, &exportFromStream, NBioAPI_FIR_PURPOSE_VERIFY, &hProcessedFIR);

                  if (nRet == NBioAPIERROR_NONE)  {
                     NBioAPI_FIR_HANDLE hCapturedFIR;

                     NBioAPI_OpenDevice(hNBioBSP, NBioAPI_DEVICE_ID_AUTO); 
                     nRet = NBioAPI_Capture(hNBioBSP, NBioAPI_FIR_PURPOSE_VERIFY, &hCapturedFIR, 3000, NULL, NULL);
                     NBioAPI_CloseDevice(hNBioBSP, NBioAPI_DEVICE_ID_AUTO);

                     if (nRet == NBioAPIERROR_NONE)  {
                        NBioAPI_INPUT_FIR inputFIR1, inputFIR2;
                        NBioAPI_BOOL bMatched;

                        inputFIR1.Form = inputFIR2.Form = NBioAPI_FIR_FORM_HANDLE;
                        inputFIR1.InputFIR.FIRinBSP = &hCapturedFIR;
                        inputFIR2.InputFIR.FIRinBSP = &hProcessedFIR;

                        nRet = NBioAPI_VerifyMatch(hNBioBSP, &inputFIR1, &inputFIR2, &bMatched, NULL);

                        if (nRet == NBioAPIERROR_NONE)  {
                           printf("============================================================================\n");
                           if (bMatched == NBioAPI_TRUE)
                              printf("Match Success!!\n");
                           else
                              printf("Match Fail!!\n");
                           printf("============================================================================\n");
                        } 
                        else
                           printf("VerifyMatch API Error: %04X\n", nRet);

                        NBioAPI_FreeFIRHandle(hNBioBSP, hCapturedFIR);
                     }
                     else
                        printf("Capture API Error: %04X\n", nRet);
                  }
                  else
                     printf("Import API Error: %04X\n", nRet);

                  NBioAPI_FreeISO_2_MakeFromStream(&exportFromStream);
               }
               else
                  printf("Can not make structure\n");
 
               NBioAPI_FreeStream(pISO_2Stream);
            }
            else
               printf("Can not make stream data\n");

            NBioAPI_FreeISO_2_MakeFromBSP(hNBioBSP, &exportISO_2Data);
         }
         else
            printf("Can not convert data, Error: %04X\n", nRet);

         NBioAPI_FreeExportISOData(pISO_4Data);
      }
      else
          printf("Can not create ISO 19794-4 data, Error: %04X\n", nRet);

      NBioAPI_Terminate(hNBioBSP);
   }

   printf("NExportRawToISO test ISO 19794-4 ==> ISO 19794-2 end!!\n");
}
