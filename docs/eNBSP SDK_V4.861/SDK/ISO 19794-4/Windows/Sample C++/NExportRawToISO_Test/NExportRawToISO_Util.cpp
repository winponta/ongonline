#include <stdafx.h>
#include "NExportRawToISO_Util.h"

NBioAPI_RETURN MakeFIRFromRawSet(NBioAPI_HANDLE          hNBioBSP, 
                                 NIMPORTRAWSET_PTR       pRawData,
                                 NBioAPI_FIR_HANDLE_PTR  phProcessedFIR)
{
   if (pRawData == NULL || phProcessedFIR == NULL)
      return NBioAPIERROR_INVALID_POINTER;

   if (pRawData->nDataCount < 1)
      return NBioAPIERROR_FUNCTION_FAIL;

   NBioAPI_RETURN nRet;
   NBioAPI_SINT32 i, j, k;
   NBioAPI_UINT16 nWidth = pRawData->pImportRawData[0].nImgWidth;
   NBioAPI_UINT16 nHeight = pRawData->pImportRawData[0].nImgHeight;
   NBioAPI_UINT8 pSampleCnt[NBioAPI_FINGER_ID_MAX];
   NBioAPI_UINT8 nSampleCnt = 0;

   memset(pSampleCnt, 0, sizeof(NBioAPI_UINT8)*NBioAPI_FINGER_ID_MAX);

   // Image size check
   for (i = 0; i < pRawData->nDataCount; i++)  {
      if (nWidth != pRawData->pImportRawData[i].nImgWidth || nHeight != pRawData->pImportRawData[i].nImgHeight)
         return NBioAPIERROR_FUNCTION_FAIL;

      pSampleCnt[pRawData->pImportRawData[i].nFingerID]++;
   }

   // Sample per finger check
   for (i = 0; i < NBioAPI_FINGER_ID_MAX; i++)  {
      if (nSampleCnt == 0)
         nSampleCnt = pSampleCnt[i];
      else  {
         if (pSampleCnt[i] != 0 && nSampleCnt != pSampleCnt[i])
            return NBioAPIERROR_FUNCTION_FAIL;
      }
   }

   if (nSampleCnt < 1 || nSampleCnt > 2)
      return NBioAPIERROR_FUNCTION_FAIL;

   // Make NBioAPI_EXPORT_AUDIT_DATA
   NBioAPI_EXPORT_AUDIT_DATA exportAuditData;

   memset(&exportAuditData, 0, sizeof(NBioAPI_EXPORT_AUDIT_DATA));

   exportAuditData.Length = sizeof(NBioAPI_EXPORT_AUDIT_DATA);
   exportAuditData.FingerNum = pRawData->nDataCount / nSampleCnt;
   exportAuditData.SamplesPerFinger = nSampleCnt;
   exportAuditData.ImageWidth = nWidth;
   exportAuditData.ImageHeight = nHeight;
   exportAuditData.AuditData = new NBioAPI_AUDIT_DATA[exportAuditData.FingerNum];

   for (i = 0; i < exportAuditData.FingerNum; i++)  {
      exportAuditData.AuditData[i].Length = sizeof(NBioAPI_AUDIT_DATA);
      exportAuditData.AuditData[i].Image = new NBioAPI_IMAGE_DATA[exportAuditData.SamplesPerFinger];

      for (j = 0; j < NBioAPI_FINGER_ID_MAX; j++)  {
         if (pSampleCnt[j] != 0)  {
            exportAuditData.AuditData[i].FingerID = j;
            pSampleCnt[j] = 0;
            break;
         }
      }

      for (j = 0, k = 0; j < pRawData->nDataCount; j++)  {
         if (exportAuditData.AuditData[i].FingerID == pRawData->pImportRawData[j].nFingerID)  {
            exportAuditData.AuditData[i].Image[k].Length = sizeof(NBioAPI_IMAGE_DATA);
            exportAuditData.AuditData[i].Image[k++].Data = pRawData->pImportRawData[j].pRawData;
         }
      }
   }

   NBioAPI_FIR_HANDLE hAuditData = NULL;
   NBioAPI_INPUT_FIR inputFIR;

   // Make Image handle
   nRet = NBioAPI_ImageToNBioBSP(hNBioBSP, &exportAuditData, &hAuditData);

   if (nRet == NBioAPIERROR_NONE)  {
      inputFIR.Form = NBioAPI_FIR_FORM_HANDLE;
      inputFIR.InputFIR.FIRinBSP = &hAuditData;

      // Make FIR handle
      nRet = NBioAPI_Process(hNBioBSP, &inputFIR, phProcessedFIR);

      NBioAPI_FreeFIRHandle(hNBioBSP, hAuditData);
   }

   for (i = 0; i < exportAuditData.FingerNum; i++)
      delete[] exportAuditData.AuditData[i].Image;

   delete[] exportAuditData.AuditData;

   return nRet;
}

NBioAPI_UINT32 GetISO_2Length(NBioAPI_EXPORT_DATA_PTR pExportData)
{
   if (pExportData)  {
      NBioAPI_UINT32 nDataLen = sizeof(NBioAPI_UINT32) + sizeof(NBioAPI_UINT8) * 4;

      if (pExportData->FingerData)  {
         NBioAPI_UINT32 nTemplateDataLen = sizeof(NBioAPI_UINT8) * 400;
         NBioAPI_UINT32 nFingerDataLen = sizeof(NBioAPI_UINT8) + nTemplateDataLen * pExportData->SamplesPerFinger;

         nDataLen += nFingerDataLen * pExportData->FingerNum;
      }

      if (pExportData->FingerData2)  {
         NBioAPI_SINT32 i;
         NBioAPI_UINT32 nTemplateDataLen = 0, nFingerDataLen = 0;

         for (i = 0; i < pExportData->FingerNum; i++)  {
            nTemplateDataLen = pExportData->FingerData2[i].Template[0].Length + sizeof(NBioAPI_UINT32);

            if (pExportData->SamplesPerFinger > 1)
               nTemplateDataLen += pExportData->FingerData2[i].Template[1].Length + sizeof(NBioAPI_UINT32);

            nFingerDataLen += sizeof(NBioAPI_UINT8) + nTemplateDataLen;
         }

         nDataLen += nFingerDataLen;
      }

      return nDataLen + sizeof(NBioAPI_UINT8) * 2;
   }

   return 0;
}

NBioAPI_RETURN NBioAPI_ConvertISO_4ToISO_2(NBioAPI_HANDLE             hNBSP,
                                           NBioAPI_UINT8*             pISOBuf, 
                                           NBioAPI_UINT32             nISOBufLen, 
                                           NBioAPI_EXPORT_DATA_PTR    pExportData)
{
   if (pISOBuf == NULL || pExportData == NULL)
      return NBioAPIERROR_INVALID_POINTER;

   NIMPORTRAWSET ImportRawSet;

   NBioAPI_RETURN nRet = NBioAPI_ImportISOToRaw(pISOBuf, nISOBufLen, &ImportRawSet);

   if (nRet == NBioAPIERROR_NONE)  {
      NBioAPI_INPUT_FIR inputFIR;
      NBioAPI_FIR_HANDLE hProcessedFIR;

      nRet = MakeFIRFromRawSet(hNBSP, &ImportRawSet, &hProcessedFIR);

      if (nRet == NBioAPIERROR_NONE)  {
         inputFIR.Form = NBioAPI_FIR_FORM_HANDLE;
         inputFIR.InputFIR.FIRinBSP = &hProcessedFIR;

         // Make ISO 19794-2 Data
         nRet = NBioAPI_NBioBSPToFDx(hNBSP, &inputFIR, pExportData, MINCONV_TYPE_ISO);

         NBioAPI_FreeFIRHandle(hNBSP, hProcessedFIR);
      }

      NBioAPI_FreeImportRawSet(&ImportRawSet);
   }

   return nRet;
}

NBioAPI_RETURN NBioAPI_ConvertISO_4ToFIR(NBioAPI_HANDLE           hNBSP,
                                         NBioAPI_UINT8*           pISOBuf, 
                                         NBioAPI_UINT32           nISOBufLen, 
                                         NBioAPI_FIR_HANDLE_PTR   phFIR)
{
   if (pISOBuf == NULL || phFIR == NULL)
      return NBioAPIERROR_INVALID_POINTER;

   NIMPORTRAWSET ImportRawSet;

   NBioAPI_RETURN nRet = NBioAPI_ImportISOToRaw(pISOBuf, nISOBufLen, &ImportRawSet);

   if (nRet == NBioAPIERROR_NONE)  {
      nRet = MakeFIRFromRawSet(hNBSP, &ImportRawSet, phFIR);

      NBioAPI_FreeImportRawSet(&ImportRawSet);
   }

   return nRet;
}

NBioAPI_BOOL NBioAPI_ISO_2ToStream(NBioAPI_EXPORT_DATA_PTR pExportData, NBioAPI_UINT8** ppStreamBuf, NBioAPI_UINT32* pStreamLen)
{
   if (pExportData == NULL || ppStreamBuf == NULL || pStreamLen == NULL)
      return NBioAPIERROR_INVALID_POINTER;

   NBioAPI_UINT32 nDataLen;
   NBioAPI_UINT8* pStream;

   nDataLen = GetISO_2Length(pExportData);

   if (nDataLen > 0)  {
      pStream = new NBioAPI_UINT8[nDataLen];

      if (pStream)  {
         NBioAPI_UINT8* pStreamCopyPos;
         NBioAPI_SINT32 i, j;

         pStreamCopyPos = pStream;

         // Stream length
         memcpy(pStreamCopyPos, &nDataLen, sizeof(NBioAPI_UINT32));
         pStreamCopyPos += sizeof(NBioAPI_UINT32);

         // EncryptType
         memcpy(pStreamCopyPos, &pExportData->EncryptType, sizeof(NBioAPI_UINT8));
         pStreamCopyPos += sizeof(NBioAPI_UINT8);

         // FingerNum
         memcpy(pStreamCopyPos, &pExportData->FingerNum, sizeof(NBioAPI_UINT8));
         pStreamCopyPos += sizeof(NBioAPI_UINT8);

         // DefaultFingerID
         memcpy(pStreamCopyPos, &pExportData->DefaultFingerID, sizeof(NBioAPI_UINT8));
         pStreamCopyPos += sizeof(NBioAPI_UINT8);

         // SamplesPerFinger
         memcpy(pStreamCopyPos, &pExportData->SamplesPerFinger, sizeof(NBioAPI_UINT8));
         pStreamCopyPos += sizeof(NBioAPI_UINT8);

         if (pExportData->FingerData)  {
            // If FingerData exist set 1, not exist set 0
            *pStreamCopyPos = 1;
            pStreamCopyPos += sizeof(NBioAPI_UINT8);

            for (i = 0; i < pExportData->FingerNum; i++)  {
               // FingerID of FingerData
               memcpy(pStreamCopyPos, &pExportData->FingerData[i].FingerID, sizeof(NBioAPI_UINT8));
               pStreamCopyPos += sizeof(NBioAPI_UINT8);

               for (j = 0; j < pExportData->SamplesPerFinger; j++)  {
                  // Data of Template of FingerData
                  memcpy(pStreamCopyPos, pExportData->FingerData[i].Template[j].Data, sizeof(NBioAPI_UINT8) * 400);
                  pStreamCopyPos += sizeof(NBioAPI_UINT8) * 400;
               }
            }
         }
         else  {
            *pStreamCopyPos = 0;
            pStreamCopyPos += sizeof(NBioAPI_UINT8);
         }

         if (pExportData->FingerData2)  {
            // If FingerData2 exist set 1, not exist set 0
            *pStreamCopyPos = 1;
            pStreamCopyPos += sizeof(NBioAPI_UINT8);

            for (i = 0; i < pExportData->FingerNum; i++)  {
               // FingerID of FingerData2
               memcpy(pStreamCopyPos, &pExportData->FingerData2[i].FingerID, sizeof(NBioAPI_UINT8));
               pStreamCopyPos += sizeof(NBioAPI_UINT8);

               for (j = 0; j < pExportData->SamplesPerFinger; j++)  {
                  // Data length of Template of FingerData2
                  memcpy(pStreamCopyPos, &pExportData->FingerData2[i].Template[j].Length, sizeof(NBioAPI_UINT32));
                  pStreamCopyPos += sizeof(NBioAPI_UINT32);

                  // Data of Template of FingerData2
                  memcpy(pStreamCopyPos, 
                         pExportData->FingerData2[i].Template[j].Data, 
                         sizeof(NBioAPI_UINT8) * pExportData->FingerData2[i].Template[j].Length);
                  pStreamCopyPos += sizeof(NBioAPI_UINT8) * pExportData->FingerData2[i].Template[j].Length;
               }
            }
         }
         else  {
            *pStreamCopyPos = 0;
            pStreamCopyPos += sizeof(NBioAPI_UINT8);
         }

         *ppStreamBuf = pStream;
         *pStreamLen = nDataLen;

         return NBioAPI_TRUE;
      }
   }

   return NBioAPI_FALSE;
}

NBioAPI_BOOL NBioAPI_StreamToISO_2(NBioAPI_UINT8* pStreamBuf, NBioAPI_UINT32 nStreamLen, NBioAPI_EXPORT_DATA_PTR pExportData)
{
   if (pStreamBuf == NULL || pExportData == NULL)
      return NBioAPIERROR_INVALID_POINTER;

   // Length check
   NBioAPI_UINT32 nCheckLen = sizeof(NBioAPI_UINT32) + sizeof(NBioAPI_UINT8) * 6;
   NBioAPI_UINT32 nTempLen = 0;

   if (nStreamLen < nCheckLen)
      return NBioAPIERROR_FUNCTION_FAIL;

   memcpy(&nTempLen, pStreamBuf, sizeof(NBioAPI_UINT32));

   if (nStreamLen < nTempLen)
      return NBioAPIERROR_FUNCTION_FAIL;

   NBioAPI_BOOL bMakeOK = NBioAPI_TRUE;
   NBioAPI_UINT8* pStreamCopyPos = pStreamBuf + sizeof(NBioAPI_UINT32);
   NBioAPI_UINT8 ExistData;
   NBioAPI_SINT32 i, j;

   memset(pExportData, 0, sizeof(NBioAPI_EXPORT_DATA));

   pExportData->Length = sizeof(NBioAPI_EXPORT_DATA);

   // EncryptType
   memcpy(&pExportData->EncryptType, pStreamCopyPos, sizeof(NBioAPI_UINT8));
   pStreamCopyPos += sizeof(NBioAPI_UINT8);

   // FingerNum
   memcpy(&pExportData->FingerNum, pStreamCopyPos, sizeof(NBioAPI_UINT8));
   pStreamCopyPos += sizeof(NBioAPI_UINT8);

   // DefaultFingerID
   memcpy(&pExportData->DefaultFingerID, pStreamCopyPos, sizeof(NBioAPI_UINT8));
   pStreamCopyPos += sizeof(NBioAPI_UINT8);

   // SamplesPerFinger
   memcpy(&pExportData->SamplesPerFinger, pStreamCopyPos, sizeof(NBioAPI_UINT8));
   pStreamCopyPos += sizeof(NBioAPI_UINT8);

   // FingerData Check
   memcpy(&ExistData, pStreamCopyPos, sizeof(NBioAPI_UINT8));
   pStreamCopyPos += sizeof(NBioAPI_UINT8);

   if (ExistData == 1)  {
      pExportData->FingerData = new NBioAPI_FINGER_DATA[pExportData->FingerNum];

      if (pExportData->FingerData)  {
         for (i = 0; i < pExportData->FingerNum; i++)  {
            pExportData->FingerData[i].Length = sizeof(NBioAPI_FINGER_DATA);
            memcpy(&pExportData->FingerData[i].FingerID, pStreamCopyPos, sizeof(NBioAPI_UINT8));
            pStreamCopyPos += sizeof(NBioAPI_UINT8);

            pExportData->FingerData[i].Template = new NBioAPI_TEMPLATE_DATA[pExportData->SamplesPerFinger];

            if (pExportData->FingerData[i].Template)  {
               for (j = 0; j < pExportData->SamplesPerFinger; j++)  {
                  pExportData->FingerData[i].Template[j].Length = sizeof(NBioAPI_TEMPLATE_DATA);
                  memcpy(pExportData->FingerData[i].Template[j].Data, pStreamCopyPos, sizeof(NBioAPI_UINT8) * 400);
                  pStreamCopyPos += sizeof(NBioAPI_UINT8) * 400;
               }
            }
            else
               bMakeOK = NBioAPI_FALSE;
         }
      }
      else
         bMakeOK = NBioAPI_FALSE;
   }

   if (bMakeOK == NBioAPI_FALSE)  {
      NBioAPI_FreeISO_2_MakeFromStream(pExportData);
      return bMakeOK;
   }

   // FingerData2 Check
   memcpy(&ExistData, pStreamCopyPos, sizeof(NBioAPI_UINT8));
   pStreamCopyPos += sizeof(NBioAPI_UINT8);

   if (ExistData == 1)  {
      pExportData->FingerData2 = new NBioAPI_FINGER_DATA_2[pExportData->FingerNum];

      if (pExportData->FingerData2)  {
         for (i = 0; i < pExportData->FingerNum; i++)  {
            pExportData->FingerData2[i].Length = sizeof(NBioAPI_FINGER_DATA_2);
            memcpy(&pExportData->FingerData2[i].FingerID, pStreamCopyPos, sizeof(NBioAPI_UINT8));
            pStreamCopyPos += sizeof(NBioAPI_UINT8);

            pExportData->FingerData2[i].Template = new NBioAPI_TEMPLATE_DATA_2[pExportData->SamplesPerFinger];

            if (pExportData->FingerData2[i].Template)  {
               for (j = 0; j < pExportData->SamplesPerFinger; j++)  {
                  memcpy(&pExportData->FingerData2[i].Template[j].Length, pStreamCopyPos, sizeof(NBioAPI_UINT32));
                  pStreamCopyPos += sizeof(NBioAPI_UINT32);

                  pExportData->FingerData2[i].Template[j].Data = new NBioAPI_UINT8[pExportData->FingerData2[i].Template[j].Length];

                  if (pExportData->FingerData2[i].Template[j].Data)  {
                     memcpy(pExportData->FingerData2[i].Template[j].Data, 
                            pStreamCopyPos,
                            sizeof(NBioAPI_UINT8) * pExportData->FingerData2[i].Template[j].Length);
                     pStreamCopyPos += sizeof(NBioAPI_UINT8) * pExportData->FingerData2[i].Template[j].Length;
                  }
               }
            }
            else
               bMakeOK = NBioAPI_FALSE;
         }
      }
      else
         bMakeOK = NBioAPI_FALSE;
   }

   if (bMakeOK == NBioAPI_FALSE)  {
      NBioAPI_FreeISO_2_MakeFromStream(pExportData);
      return bMakeOK;
   }

   return NBioAPI_TRUE;
}

void NBioAPI_FreeISO_2_MakeFromBSP(NBioAPI_HANDLE hNBSP, NBioAPI_EXPORT_DATA_PTR pExportData)
{
   NBioAPI_FreeExportData(hNBSP, pExportData);
}

void NBioAPI_FreeISO_2_MakeFromStream(NBioAPI_EXPORT_DATA_PTR pExportData)
{
   if (pExportData)  {
      NBioAPI_SINT32 i, j;

      for (i = 0; i < pExportData->FingerNum; i++)  {
         if (pExportData->FingerData)  {
            if (pExportData->FingerData[i].Template)
               delete[] pExportData->FingerData[i].Template;
         }

         for (j = 0; j < pExportData->SamplesPerFinger; j++)  {
            if (pExportData->FingerData2)  {
               if (pExportData->FingerData2[i].Template)
                  if (pExportData->FingerData2[i].Template[j].Data)
                     delete[] pExportData->FingerData2[i].Template[j].Data;
            }
         }

         if (pExportData->FingerData2)
            if (pExportData->FingerData2[i].Template)
               delete[] pExportData->FingerData2[i].Template;
      }

      if (pExportData->FingerData)
         delete[] pExportData->FingerData;

      if (pExportData->FingerData2)
         delete[] pExportData->FingerData2;
   }
}

void NBioAPI_FreeISOFIRHandle(NBioAPI_HANDLE hNBSP, NBioAPI_FIR_HANDLE hFIR)
{
   NBioAPI_FreeFIRHandle(hNBSP, hFIR);
}

void NBioAPI_FreeStream(NBioAPI_UINT8* pStreamBuf)
{
   if (pStreamBuf)  {
      delete[] pStreamBuf;
      pStreamBuf = NBioAPI_NULL;
   }
}