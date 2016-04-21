#ifndef NBIOBSP_DATACONVERT_H
#define NBIOBSP_DATACONVERT_H

#include <QDialog>
#include "../../../include/NBioAPI.h"
#include "../../../include/NBioAPI_Export.h"

namespace Ui {
    class NBioBSP_DataConvert;
}

class NBioBSP_DataConvert : public QDialog {
    Q_OBJECT
public:
    NBioBSP_DataConvert(QWidget *parent = 0);
    ~NBioBSP_DataConvert();

    void DrawFingerImage(unsigned char* pImageBuf);

protected:
    void changeEvent(QEvent *e);

protected:
    void DisplayError(NBioAPI_RETURN nRet);
    void InitNBSPSDK();
    void TerminateNBSPSDK();
    MINCONV_DATA_TYPE GetDataType();

private:
    Ui::NBioBSP_DataConvert*    ui;

    QVector<QRgb>               colorTable;
    NBioAPI_HANDLE              m_hNBioBSP;
    NBioAPI_DEVICE_INFO_0       m_DeviceInfo;
    NBioAPI_EXPORT_DATA         m_ExportData;
    NBioAPI_UINT8*              m_pTemplate;
    NBioAPI_UINT32              m_nLen;

private slots:
    void on_btImport_pressed();
    void on_btLoad_pressed();
    void on_btSave_pressed();
    void on_btExport_pressed();
    void on_comboDataType_currentIndexChanged(int index);
    void on_rdImport_toggled(bool checked);
    void on_rdExport_toggled(bool checked);
};

#endif // NBIOBSP_DATACONVERT_H
