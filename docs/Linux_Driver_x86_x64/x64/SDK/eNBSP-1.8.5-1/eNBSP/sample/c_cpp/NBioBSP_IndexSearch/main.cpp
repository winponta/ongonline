#include <QtGui/QApplication>
#include "nbiobsp_indexsearch.h"

int main(int argc, char *argv[])
{
    QApplication a(argc, argv);
    NBioBSP_IndexSearch w;
    w.show();
    return a.exec();
}
