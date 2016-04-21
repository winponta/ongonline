rmdir /s /q build_Wsq
mkdir build_Wsq
javac -Xlint:deprecation -classpath ..\..\..\Lib\NBioBSPJNI.jar;..\..\..\Lib\swing-layout-1.0.3.jar ..\src\NBioAPI_WSQDemo.java -d .\build_Wsq
java -Xincgc -Xmn100m -Xms512m -Xmx512m -XX:PermSize=256m -XX:MaxPermSize=256m -classpath ./build_Wsq;../../../Lib/NBioBSPJNI.jar;../../../Lib/swing-layout-1.0.3.jar NBioAPI_WSQDemo