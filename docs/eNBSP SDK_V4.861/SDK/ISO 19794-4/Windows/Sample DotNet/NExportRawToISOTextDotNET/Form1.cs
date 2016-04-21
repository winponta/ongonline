using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;

using NITGEN.SDK.NBioBSP;
using NITGEN.SDK.NBioBSPISO4;

namespace NExportRawToISOTextDotNET
{
   public partial class Form1 : Form
   {
      NBioAPI m_NBioAPI;
      NBioAPI.Export m_Export;


      public Form1()
      {
         InitializeComponent();

         m_NBioAPI = new NBioAPI();
         m_Export = new NBioAPI.Export(m_NBioAPI);

         NBioAPI.Type.VERSION ver;

         m_NBioAPI.GetVersion(out ver);

         this.Text = "NExportRawToISO Test[eNBioBS SDK Ver: " + ver.Major + "." + ver.Minor + "]";
      }

      private void ISOV1_Click(object sender, EventArgs e)
      {
         string szTemp;

         listRet.Items.Clear();
         listRet.Items.Add("OpenDevice start...");

         uint nRet = m_NBioAPI.OpenDevice(NBioAPI.Type.DEVICE_ID.AUTO);

         if (nRet == NBioAPI.Error.NONE)
         {
            NBioAPI.Type.HFIR hFIR, hAuditFIR;

            hAuditFIR = new NBioAPI.Type.HFIR();

            listRet.Items.Add("Enroll start...");

            m_NBioAPI.Enroll(null, out hFIR, null, NBioAPI.Type.TIMEOUT.DEFAULT, hAuditFIR, null);

            if (nRet == NBioAPI.Error.NONE)
            {
               NBioAPI.Export.EXPORT_AUDIT_DATA exportData;

               listRet.Items.Add("NBioBSPToImage start...");

               nRet = m_Export.NBioBSPToImage(hAuditFIR, out exportData);

               if (nRet == NBioAPI.Error.NONE)
               {
                  byte[] ISOBuf;

                  listRet.Items.Add("ExportRawToISOV1 start...");

                  nRet = NBioBSPISO4.ExportRawToISOV1(exportData, false, NBioBSPISO4.COMPRESS_MOD.NONE, out ISOBuf);

                  if (nRet == NBioAPI.Error.NONE)
                  {
                     NBioBSPISO4.NIMPORTRAWSET ImportRawSet;

                     listRet.Items.Add("ImportISOToRaw start...");

                     nRet = NBioBSPISO4.ImportISOToRaw(ISOBuf, out ImportRawSet);

                     if (nRet == NBioAPI.Error.NONE)
                     {
                        listRet.Items.Add("Test result");

                        for (byte i = 0; i < ImportRawSet.nDataCount; i++)
                        {
                           szTemp = "DataLen: " + ImportRawSet.ImportRawData[i].RawData.Length;
                           listRet.Items.Add(szTemp);

                           szTemp = "FingerID: " + ImportRawSet.ImportRawData[i].nFingerID;
                           listRet.Items.Add(szTemp);

                           szTemp = "Image Width: " + ImportRawSet.ImportRawData[i].nImgWidth;
                           listRet.Items.Add(szTemp);

                           szTemp = "Image Height: " + ImportRawSet.ImportRawData[i].nImgHeight;
                           listRet.Items.Add(szTemp);
                        }
                     }
                     else
                     {
                        szTemp = "ImportISOToRaw Error: " + nRet;
                        listRet.Items.Add(szTemp);
                     }
                  }
                  else
                  {
                     szTemp = "ExportRawToISOV1 Error: " + nRet;
                     listRet.Items.Add(szTemp);
                  }
               }
               else
               {
                  szTemp = "NBioBSPToImage Error: " + nRet;
                  listRet.Items.Add(szTemp);
               }

               hFIR.Dispose();
               hAuditFIR.Dispose();
            }
            else
            {
               szTemp = "Enroll Error: " + nRet;
               listRet.Items.Add(szTemp);
            }

            m_NBioAPI.CloseDevice(NBioAPI.Type.DEVICE_ID.AUTO);
         }
         else
         {
            szTemp = "CloseDevice Error: " + nRet;
            listRet.Items.Add(szTemp);
         }
      }

      private void ISOV1WSQ_Click(object sender, EventArgs e)
      {
         string szTemp;

         listRet.Items.Clear();
         listRet.Items.Add("OpenDevice start...");

         uint nRet = m_NBioAPI.OpenDevice(NBioAPI.Type.DEVICE_ID.AUTO);

         if (nRet == NBioAPI.Error.NONE)
         {
            NBioAPI.Type.HFIR hFIR, hAuditFIR;

            hAuditFIR = new NBioAPI.Type.HFIR();

            listRet.Items.Add("Enroll start...");

            m_NBioAPI.Enroll(null, out hFIR, null, NBioAPI.Type.TIMEOUT.DEFAULT, hAuditFIR, null);

            if (nRet == NBioAPI.Error.NONE)
            {
               NBioAPI.Export.EXPORT_AUDIT_DATA exportData;

               listRet.Items.Add("NBioBSPToImage start...");

               nRet = m_Export.NBioBSPToImage(hAuditFIR, out exportData);

               if (nRet == NBioAPI.Error.NONE)
               {
                  byte[] ISOBuf;

                  listRet.Items.Add("ExportRawToISOV1 start...");

                  nRet = NBioBSPISO4.ExportRawToISOV1(exportData, false, NBioBSPISO4.COMPRESS_MOD.WSQ, out ISOBuf);

                  if (nRet == NBioAPI.Error.NONE)
                  {
                     NBioBSPISO4.NIMPORTRAWSET ImportRawSet;

                     listRet.Items.Add("ImportISOToRaw start...");

                     nRet = NBioBSPISO4.ImportISOToRaw(ISOBuf, out ImportRawSet);

                     if (nRet == NBioAPI.Error.NONE)
                     {
                        listRet.Items.Add("Test result");

                        for (byte i = 0; i < ImportRawSet.nDataCount; i++)
                        {
                           szTemp = "DataLen: " + ImportRawSet.ImportRawData[i].RawData.Length;
                           listRet.Items.Add(szTemp);

                           szTemp = "FingerID: " + ImportRawSet.ImportRawData[i].nFingerID;
                           listRet.Items.Add(szTemp);

                           szTemp = "Image Width: " + ImportRawSet.ImportRawData[i].nImgWidth;
                           listRet.Items.Add(szTemp);

                           szTemp = "Image Height: " + ImportRawSet.ImportRawData[i].nImgHeight;
                           listRet.Items.Add(szTemp);
                        }
                     }
                     else
                     {
                        szTemp = "ImportISOToRaw Error: " + nRet;
                        listRet.Items.Add(szTemp);
                     }
                  }
                  else
                  {
                     szTemp = "ExportRawToISOV1 Error: " + nRet;
                     listRet.Items.Add(szTemp);
                  }
               }
               else
               {
                  szTemp = "NBioBSPToImage Error: " + nRet;
                  listRet.Items.Add(szTemp);
               }

               hFIR.Dispose();
               hAuditFIR.Dispose();
            }
            else
            {
               szTemp = "Enroll Error: " + nRet;
               listRet.Items.Add(szTemp);
            }

            m_NBioAPI.CloseDevice(NBioAPI.Type.DEVICE_ID.AUTO);
         }
         else
         {
            szTemp = "CloseDevice Error: " + nRet;
            listRet.Items.Add(szTemp);
         }
      }

      private void ISOV2_Click(object sender, EventArgs e)
      {
         string szTemp;

         listRet.Items.Clear();
         listRet.Items.Add("OpenDevice start...");

         uint nRet = m_NBioAPI.OpenDevice(NBioAPI.Type.DEVICE_ID.AUTO);

         if (nRet == NBioAPI.Error.NONE)
         {
            NBioAPI.Type.HFIR hFIR, hAuditFIR;

            hAuditFIR = new NBioAPI.Type.HFIR();

            listRet.Items.Add("Enroll start...");

            m_NBioAPI.Capture(NBioAPI.Type.FIR_PURPOSE.VERIFY, out hFIR, NBioAPI.Type.TIMEOUT.DEFAULT, hAuditFIR, null);

            if (nRet == NBioAPI.Error.NONE)
            {
               NBioAPI.Export.EXPORT_AUDIT_DATA exportData;

               listRet.Items.Add("NBioBSPToImage start...");

               nRet = m_Export.NBioBSPToImage(hAuditFIR, out exportData);

               if (nRet == NBioAPI.Error.NONE)
               {
                  byte[] ISOBuf;

                  listRet.Items.Add("ExportRawToISOV2 start...");

                  nRet = NBioBSPISO4.ExportRawToISOV2((byte)NBioAPI.Type.FINGER_ID.LEFT_INDEX, (ushort)exportData.ImageWidth, (ushort)exportData.ImageHeight,
                                                      exportData.AuditData[0].Image[0].Data, false, NBioBSPISO4.COMPRESS_MOD.NONE, out ISOBuf);

                  if (nRet == NBioAPI.Error.NONE)
                  {
                     NBioBSPISO4.NIMPORTRAWSET ImportRawSet;

                     listRet.Items.Add("ImportISOToRaw start...");

                     nRet = NBioBSPISO4.ImportISOToRaw(ISOBuf, out ImportRawSet);

                     if (nRet == NBioAPI.Error.NONE)
                     {
                        listRet.Items.Add("Test result");

                        for (byte i = 0; i < ImportRawSet.nDataCount; i++)
                        {
                           szTemp = "DataLen: " + ImportRawSet.ImportRawData[i].RawData.Length;
                           listRet.Items.Add(szTemp);

                           szTemp = "FingerID: " + ImportRawSet.ImportRawData[i].nFingerID;
                           listRet.Items.Add(szTemp);

                           szTemp = "Image Width: " + ImportRawSet.ImportRawData[i].nImgWidth;
                           listRet.Items.Add(szTemp);

                           szTemp = "Image Height: " + ImportRawSet.ImportRawData[i].nImgHeight;
                           listRet.Items.Add(szTemp);
                        }
                     }
                     else
                     {
                        szTemp = "ImportISOToRaw Error: " + nRet;
                        listRet.Items.Add(szTemp);
                     }
                  }
                  else
                  {
                     szTemp = "ExportRawToISOV2 Error: " + nRet;
                     listRet.Items.Add(szTemp);
                  }
               }
               else
               {
                  szTemp = "NBioBSPToImage Error: " + nRet;
                  listRet.Items.Add(szTemp);
               }

               hFIR.Dispose();
               hAuditFIR.Dispose();
            }
            else
            {
               szTemp = "Capture Error: " + nRet;
               listRet.Items.Add(szTemp);
            }

            m_NBioAPI.CloseDevice(NBioAPI.Type.DEVICE_ID.AUTO);
         }
         else
         {
            szTemp = "CloseDevice Error: " + nRet;
            listRet.Items.Add(szTemp);
         }
      }

      private void ISOV2WSQ_Click(object sender, EventArgs e)
      {
         string szTemp;

         listRet.Items.Clear();
         listRet.Items.Add("OpenDevice start...");

         uint nRet = m_NBioAPI.OpenDevice(NBioAPI.Type.DEVICE_ID.AUTO);

         if (nRet == NBioAPI.Error.NONE)
         {
            NBioAPI.Type.HFIR hFIR, hAuditFIR;

            hAuditFIR = new NBioAPI.Type.HFIR();

            listRet.Items.Add("Enroll start...");

            m_NBioAPI.Capture(NBioAPI.Type.FIR_PURPOSE.VERIFY, out hFIR, NBioAPI.Type.TIMEOUT.DEFAULT, hAuditFIR, null);

            if (nRet == NBioAPI.Error.NONE)
            {
               NBioAPI.Export.EXPORT_AUDIT_DATA exportData;

               listRet.Items.Add("NBioBSPToImage start...");

               nRet = m_Export.NBioBSPToImage(hAuditFIR, out exportData);

               if (nRet == NBioAPI.Error.NONE)
               {
                  byte[] ISOBuf;

                  listRet.Items.Add("ExportRawToISOV2 start...");

                  nRet = NBioBSPISO4.ExportRawToISOV2((byte)NBioAPI.Type.FINGER_ID.LEFT_INDEX, (ushort)exportData.ImageWidth, (ushort)exportData.ImageHeight,
                                                      exportData.AuditData[0].Image[0].Data, false, NBioBSPISO4.COMPRESS_MOD.WSQ, out ISOBuf);

                  if (nRet == NBioAPI.Error.NONE)
                  {
                     NBioBSPISO4.NIMPORTRAWSET ImportRawSet;

                     listRet.Items.Add("ImportISOToRaw start...");

                     nRet = NBioBSPISO4.ImportISOToRaw(ISOBuf, out ImportRawSet);

                     if (nRet == NBioAPI.Error.NONE)
                     {
                        listRet.Items.Add("Test result");

                        for (byte i = 0; i < ImportRawSet.nDataCount; i++)
                        {
                           szTemp = "DataLen: " + ImportRawSet.ImportRawData[i].RawData.Length;
                           listRet.Items.Add(szTemp);

                           szTemp = "FingerID: " + ImportRawSet.ImportRawData[i].nFingerID;
                           listRet.Items.Add(szTemp);

                           szTemp = "Image Width: " + ImportRawSet.ImportRawData[i].nImgWidth;
                           listRet.Items.Add(szTemp);

                           szTemp = "Image Height: " + ImportRawSet.ImportRawData[i].nImgHeight;
                           listRet.Items.Add(szTemp);
                        }
                     }
                     else
                     {
                        szTemp = "ImportISOToRaw Error: " + nRet;
                        listRet.Items.Add(szTemp);
                     }
                  }
                  else
                  {
                     szTemp = "ExportRawToISOV2 Error: " + nRet;
                     listRet.Items.Add(szTemp);
                  }
               }
               else
               {
                  szTemp = "NBioBSPToImage Error: " + nRet;
                  listRet.Items.Add(szTemp);
               }

               hFIR.Dispose();
               hAuditFIR.Dispose();
            }
            else
            {
               szTemp = "Capture Error: " + nRet;
               listRet.Items.Add(szTemp);
            }

            m_NBioAPI.CloseDevice(NBioAPI.Type.DEVICE_ID.AUTO);
         }
         else
         {
            szTemp = "CloseDevice Error: " + nRet;
            listRet.Items.Add(szTemp);
         }
      }

      private uint MakeISO4Data(out byte[] ISOBuf)
      {
         string szTemp;

         listRet.Items.Add("ISO 19794-4 Data creation start...");
         listRet.Items.Add("OpenDevice start...");

         ISOBuf = null;

         uint nRet = m_NBioAPI.OpenDevice(NBioAPI.Type.DEVICE_ID.AUTO);

         if (nRet == NBioAPI.Error.NONE)
         {
            NBioAPI.Type.HFIR hFIR, hAuditData;

            hAuditData = new NBioAPI.Type.HFIR();

            nRet = m_NBioAPI.Enroll(null, out hFIR, null, NBioAPI.Type.TIMEOUT.DEFAULT, hAuditData, null);

            if (nRet == NBioAPI.Error.NONE)
            {
               NBioAPI.Export.EXPORT_AUDIT_DATA exportAuditData;

               nRet = m_Export.NBioBSPToImage(hAuditData, out exportAuditData);

               if (nRet == NBioAPI.Error.NONE)
               {
                  nRet = NBioBSPISO4.ExportRawToISOV1(exportAuditData, false, NBioBSPISO4.COMPRESS_MOD.NONE, out ISOBuf);

                  if (nRet == NBioAPI.Error.NONE)
                  {
                     szTemp = "ISO 19794-4 Data Len: " + ISOBuf.Length;
                     listRet.Items.Add(szTemp);
                  }
                  else
                  {
                     szTemp = "ExportRawToISOV1 Error: " + nRet;
                     listRet.Items.Add(szTemp);
                  }
               }
               else
               {
                  szTemp = "NBioBSPToImage Error: " + nRet;
                  listRet.Items.Add(szTemp);
               }

               hFIR.Dispose();
               hAuditData.Dispose();
            }
            else
            {
               szTemp = "Enroll Error: " + nRet;
               listRet.Items.Add(szTemp);
            }

            m_NBioAPI.CloseDevice(NBioAPI.Type.DEVICE_ID.AUTO);
         }
         else
         {
            szTemp = "OpenDevice Error: " + nRet;
            listRet.Items.Add(szTemp);
         }

         return nRet;
      }

      private uint MakeFIRFromRawSet(NBioBSPISO4.NIMPORTRAWSET RawSet, out NBioAPI.Type.HFIR hProcessedFIR)
      {
         hProcessedFIR = null;

         if (RawSet.nDataCount < 1)
            return NBioAPI.Error.FUNCTION_FAIL;

         uint nRet;
         int i, j, k;
         ushort nWidth = RawSet.ImportRawData[0].nImgWidth;
         ushort nHeight = RawSet.ImportRawData[0].nImgHeight;
         const int FINGER_ID_MAX = 11;
         byte[] arSampleCnt = new byte[FINGER_ID_MAX];
         byte nSampleCnt = 0;
         string szTemp;

         listRet.Items.Add("NITGEN FIR creation start...");

         for (i = 0; i < FINGER_ID_MAX; i++)
            arSampleCnt[i] = 0;

         // Image size check
         for (i = 0; i < RawSet.nDataCount; i++)
         {
            if (nWidth != RawSet.ImportRawData[i].nImgWidth || nHeight != RawSet.ImportRawData[i].nImgHeight)
               return NBioAPI.Error.FUNCTION_FAIL;

            arSampleCnt[RawSet.ImportRawData[i].nFingerID]++;
         }

         // Sample per finger check
         for (i = 0; i < FINGER_ID_MAX; i++)
         {
            if (nSampleCnt == 0)
               nSampleCnt = arSampleCnt[i];
            else
            {
               if (arSampleCnt[i] != 0 && nSampleCnt != arSampleCnt[i])
                  return NBioAPI.Error.FUNCTION_FAIL;
            }
         }

         if (nSampleCnt < 1 || nSampleCnt > 2)
            return NBioAPI.Error.FUNCTION_FAIL;

         // Make NBioAPI_EXPORT_AUDIT_DATA
         NBioAPI.Export.EXPORT_AUDIT_DATA exportAuditData;

         exportAuditData = new NBioAPI.Export.EXPORT_AUDIT_DATA();

         exportAuditData.FingerNum = (byte)(RawSet.nDataCount / nSampleCnt);
         exportAuditData.SamplesPerFinger = nSampleCnt;
         exportAuditData.ImageWidth = nWidth;
         exportAuditData.ImageHeight = nHeight;
         exportAuditData.AuditData = new NBioAPI.Export.AUDIT_DATA[exportAuditData.FingerNum];

         for (i = 0; i < exportAuditData.FingerNum; i++)
         {
            exportAuditData.AuditData[i].Image = new NBioAPI.Export.IMAGE_DATA[exportAuditData.SamplesPerFinger];

            for (j = 0; j < FINGER_ID_MAX; j++)
            {
               if (arSampleCnt[j] != 0)
               {
                  exportAuditData.AuditData[i].FingerID = (byte)j;
                  arSampleCnt[j] = 0;
                  break;
               }
            }

            for (j = 0, k = 0; j < RawSet.nDataCount; j++)
            {
               if (exportAuditData.AuditData[i].FingerID == RawSet.ImportRawData[j].nFingerID)
               {
                  exportAuditData.AuditData[i].Image[k].Data = new byte[RawSet.ImportRawData[j].RawData.Length];
                  exportAuditData.AuditData[i].Image[k++].Data = RawSet.ImportRawData[j].RawData;
               }
            }
         }

         // Make Image handle
         NBioAPI.Type.HFIR hAuditFIR;

         nRet = m_Export.ImageToNBioBSP(exportAuditData, out hAuditFIR);

         if (nRet == NBioAPI.Error.NONE)
         {
            // Make FIR handle
            nRet = m_NBioAPI.Process(hAuditFIR, out hProcessedFIR);

            if (nRet != NBioAPI.Error.NONE)
            {
               szTemp = "Process Error: " + nRet;
               listRet.Items.Add(szTemp);
            }

            hAuditFIR.Dispose();
         }
         else
         {
            szTemp = "ImageToNBioBSP Error: " + nRet;
            listRet.Items.Add(szTemp);
         }

         return nRet;
      }

      private uint ConvertISO4ToISO2(byte[] ISOBuf, out NBioAPI.Export.EXPORT_DATA exportData)
      {
         NBioBSPISO4.NIMPORTRAWSET ImportRawSet;
         string szTemp;

         listRet.Items.Add("ISO 19794-2 data creation start...");

         exportData = new NBioAPI.Export.EXPORT_DATA();

         uint nRet = NBioBSPISO4.ImportISOToRaw(ISOBuf, out ImportRawSet);

         if (nRet == NBioAPI.Error.NONE)
         {
            NBioAPI.Type.HFIR hProcessedFIR;

            nRet = MakeFIRFromRawSet(ImportRawSet, out hProcessedFIR);

            if (nRet == NBioAPI.Error.NONE)
            {
               // Make ISO 19794-2 Data
               nRet = m_Export.NBioBSPToFDx(hProcessedFIR, out exportData, NBioAPI.Type.MINCONV_DATA_TYPE.MINCONV_TYPE_ISO);

               if (nRet != NBioAPI.Error.NONE)
               {
                  szTemp = "NBioBSPToFDx Error: " + nRet;
                  listRet.Items.Add(szTemp);
               }

               hProcessedFIR.Dispose();
            }
         }
         else
         {
            szTemp = "ImportISOToRaw Error: " + nRet;
            listRet.Items.Add(szTemp);
         }

         return nRet;
      }

      private void ISO2Check_Click(object sender, EventArgs e)
      {
         byte[] ISOBuf;

         listRet.Items.Clear();

         listRet.Items.Add("ISO 19794-4 data check start...");

         uint nRet = MakeISO4Data(out ISOBuf);

         if (nRet == NBioAPI.Error.NONE)
         {
            NBioAPI.Export.EXPORT_DATA exportData;

            nRet = ConvertISO4ToISO2(ISOBuf, out exportData);

            if (nRet == NBioAPI.Error.NONE)
            {
               NBioAPI.Type.HFIR hProcessedFIR;

               nRet = m_Export.ImportDataToNBioBSP(exportData, NBioAPI.Type.FIR_PURPOSE.VERIFY, out hProcessedFIR);

               if (nRet == NBioAPI.Error.NONE)
               {
                  bool bRet;

                  listRet.Items.Add("Match start...");

                  m_NBioAPI.OpenDevice(NBioAPI.Type.DEVICE_ID.AUTO);
                  nRet = m_NBioAPI.Verify(hProcessedFIR, out bRet, null);
                  m_NBioAPI.CloseDevice(NBioAPI.Type.DEVICE_ID.AUTO);

                  if (nRet == NBioAPI.Error.NONE)
                  {
                     if (bRet)
                        MessageBox.Show("Match Success!!");
                     else
                        MessageBox.Show("Match Fail!!");
                  }

                  hProcessedFIR.Dispose();
               }
            }
         }
      }
   }
}
