#include <QtGui/QApplication>
#include "nbiobsp_rolltest.h"

int main(int argc, char *argv[])
{
    QApplication a(argc, argv);
    NBioBSP_RollTest w;
    w.show();
    return a.exec();
}
