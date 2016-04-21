#ifndef NBIOBSP_INDEXSEARCH_H
#define NBIOBSP_INDEXSEARCH_H

#include <QDialog>
#include "../../../include/NBioAPI.h"
#include "../../../include/NBioAPI_Export.h"
#include "../../../include/NBioAPI_IndexSearch.h"
#include "qstandarditemmodel.h"

class QAbstractItemModel;

namespace Ui {
    class NBioBSP_IndexSearch;
}

class NBioBSP_IndexSearch : public QDialog {
    Q_OBJECT
public:
    NBioBSP_IndexSearch(QWidget *parent = 0);
    ~NBioBSP_IndexSearch();

    NBioAPI_RETURN MyCallBackFun(NBioAPI_INDEXSEARCH_CALLBACK_PARAM_PTR_0 pCallbackParam0);

protected:
    void changeEvent(QEvent *e);

protected:
    NBioAPI_RETURN NBSPSDKInit();
    void NBSPDSKTerminate();
    void UpdateTotalCount();

private:
    Ui::NBioBSP_IndexSearch*    ui;

    QStandardItemModel*         pRegModel;
    QStandardItemModel*         pSearchModel;
    NBioAPI_HANDLE              m_hNBioBSP;
    NBioAPI_UINT32              m_nUserID;
    bool                        m_bStopFlag;

private slots:
    void on_btClearDB_pressed();
    void on_btRmDB_pressed();
    void on_btSaveDB_pressed();
    void on_btLoadDB_pressed();
    void on_btStop_pressed();
    void on_btIdentify_pressed();
    void on_btLoadMIN_pressed();
    void on_btLoadFIR_pressed();
    void on_btReg_pressed();
};

#endif // NBIOBSP_INDEXSEARCH_H
