#!/bin/sh
INSTALL_PATH="/usr/local/NITGEN/"
TARGET="eNBSP"
OBJECT="libNBioBSP.so"

echo "uninstalling NBioBSP......."

#remove shared object
if [ -f /lib/$OBJECT ]; then
	echo "remove shared object"
	rm -f /lib/$OBJECT
	rm -f /lib/NBioBSP.lic
fi

# remove installed directory
if [ -d $INSTALL_PATH$TARGET ]; then
	echo "uninstall NBioBSP"
	rm -rf $INSTALL_PATH$TARGET
fi
  
echo "NBioBSP un-installed successfully"
