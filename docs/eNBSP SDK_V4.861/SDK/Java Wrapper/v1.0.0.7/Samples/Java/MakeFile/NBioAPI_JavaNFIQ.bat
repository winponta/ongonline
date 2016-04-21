rmdir /s /q build_NFIQ
mkdir build_NFIQ
javac -Xlint:deprecation -classpath ..\..\..\Lib\NBioBSPJNI.jar;..\..\..\Lib\swing-layout-1.0.3.jar ..\src\NBioNFIQTest.java -d .\build_NFIQ
java -Xincgc -Xmn100m -Xms512m -Xmx512m -XX:PermSize=256m -XX:MaxPermSize=256m -classpath ./build_NFIQ;../../../Lib/NBioBSPJNI.jar;../../../Lib/swing-layout-1.0.3.jar NBioNFIQTest