#include <QtGui/QApplication>
#include "nbiobsp_dataconvert.h"

int main(int argc, char *argv[])
{
    QApplication a(argc, argv);
    NBioBSP_DataConvert w;
    w.show();
    return a.exec();
}
