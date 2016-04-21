DIR_DEMO	= demo_build
DIR_EXPORT	= export_build
DIR_INSEARCH	= index_build
DIR_ROLLDEMO	= roll_build
DIR_UI		= ui_build
DIR_SOURCE	= ../src/

JAVA		= /usr/local/jre1.6.0_14/bin/java
JAVAC		= /usr/local/jdk1.6.0_14/bin/javac 
CLASSPATH_BUILD	= -classpath ../../../Lib/NBioBSPJNI.jar:../../../Lib/swing-layout-1.0.3.jar
CLASSPATH_RUN	= -classpath ../../../Lib/NBioBSPJNI.jar:../../../Lib/swing-layout-1.0.3.jar
JVMOPT		= -Xincgc -Xss100m -Xmn100m -Xms512m -Xmx512m -XX:PermSize=256m -XX:MaxPermSize=256m

clean:
	rm -rf *_build

demo:
	rm -rf $(DIR_DEMO) 
	mkdir $(DIR_DEMO) 
	$(JAVAC) -Xlint:deprecation $(CLASSPATH_BUILD) $(DIR_SOURCE)NBioAPI_JavaDemo.java -d $(DIR_DEMO) 
	$(JAVA) $(JVMOPT) $(CLASSPATH_RUN):./$(DIR_DEMO) NBioAPI_JavaDemo 

export:	
	rm -rf $(DIR_EXPORT)
	mkdir $(DIR_EXPORT)
	$(JAVAC) -Xlint:deprecation $(CLASSPATH_BUILD) $(DIR_SOURCE)NBioAPI_JavaExport.java -d $(DIR_EXPORT) 
	$(JAVA) $(JVMOPT) $(CLASSPATH_RUN):./$(DIR_EXPORT) NBioAPI_JavaExport 

index:
	rm -rf $(DIR_INSEARCH)
	mkdir $(DIR_INSEARCH)
	$(JAVAC) -Xlint:deprecation $(CLASSPATH_BUILD) $(DIR_SOURCE)NBioAPI_JavaIndexSearch.java -d $(DIR_INSEARCH) 
	$(JAVA) $(JVMOPT) $(CLASSPATH_RUN):./$(DIR_INSEARCH) NBioAPI_JavaIndexSearch 
	
roll:
	rm -rf $(DIR_ROLLDEMO)
	mkdir $(DIR_ROLLDEMO)
	$(JAVAC) -Xlint:deprecation $(CLASSPATH_BUILD) $(DIR_SOURCE)NBioAPI_JavaRollDemo.java -d $(DIR_ROLLDEMO) 
	$(JAVA) $(JVMOPT) $(CLASSPATH_RUN):./$(DIR_ROLLDEMO) NBioAPI_JavaRollDemo 

ui:
	rm -rf $(DIR_UI)
	mkdir $(DIR_UI)
	$(JAVAC) -Xlint:deprecation $(CLASSPATH_BUILD) $(DIR_SOURCE)NBioAPI_JavaUITest.java -d $(DIR_UI) 
	$(JAVA) $(JVMOPT) $(CLASSPATH_RUN):./$(DIR_UI) NBioAPI_JavaUITest 

