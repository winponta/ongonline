all:
	g++ -o TestISOMatch Test_ISO_Match.cpp -ldl -L. -lNBioBSP -lNExportRawToISO
	g++ -c NExportRawToISO_Util.cpp
	g++ -o Test_ISO2 Test_ISO_4To_ISO_2.cpp NExportRawToISO_Util.o -ldl -lNBioBSP -lNExportRawToISO

    
clean:
	rm -rf *.o
	rm -f Test_ISO2 
