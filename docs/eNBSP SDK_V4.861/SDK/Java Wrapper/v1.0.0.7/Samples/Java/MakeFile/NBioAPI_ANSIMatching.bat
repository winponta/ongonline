rmdir /s /q build_Ansi
mkdir build_Ansi
javac -Xlint:deprecation -classpath ..\..\..\Lib\NBioBSPJNI.jar;..\..\..\Lib\swing-layout-1.0.3.jar ..\src\NBioAPI_ANSIMatching.java -d .\build_Ansi
java -Xincgc -Xmn100m -Xms512m -Xmx512m -XX:PermSize=256m -XX:MaxPermSize=256m -classpath ./build_Ansi;../../../Lib/NBioBSPJNI.jar;../../../Lib/swing-layout-1.0.3.jar NBioAPI_ANSIMatching