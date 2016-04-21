rmdir /s /q build_ISearch
mkdir build_ISearch
javac -Xlint:deprecation -classpath ..\..\..\Lib\NBioBSPJNI.jar;..\..\..\Lib\swing-layout-1.0.3.jar ..\src\NBioAPI_JavaIndexSearch.java -d .\build_ISearch
java -Xincgc -Xmn100m -Xms512m -Xmx512m -XX:PermSize=256m -XX:MaxPermSize=256m -classpath ./build_ISearch;../../../Lib/NBioBSPJNI.jar;../../../Lib/swing-layout-1.0.3.jar NBioAPI_JavaIndexSearch