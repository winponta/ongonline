#include <QtGui/QApplication>
#include "nbiobsp_demo.h"

int main(int argc, char *argv[])
{
    QApplication a(argc, argv);
    NBioBSP_Demo w;
    w.show();
    return a.exec();
}
