#pragma once

#include "NBioAPI_Basic.h"
#include "NBioAPI_Type.h"
#include "NBioAPI_Error.h"
#include "NBioAPI_ExportType.h"


#ifdef __cplusplus
extern "C" {
#endif

NBioAPI_RETURN NBioAPI NBioAPI_GetNFIQInfo(const NBioAPI_EXPORT_AUDIT_DATA_PTR   pExportAuditData,
                                           NBioAPI_QUALITY_INFO_PTR_0            pQualityInfo);

NBioAPI_RETURN NBioAPI NBioAPI_GetNFIQInfoFromRaw(const NBioAPI_UINT8* pRawImage,
                                                  const NBioAPI_SINT32 nImgWidth,
                                                  const NBioAPI_SINT32 nImgHeight,
                                                  NBioAPI_SINT32* pNFIQ);

#ifdef __cplusplus
}
#endif