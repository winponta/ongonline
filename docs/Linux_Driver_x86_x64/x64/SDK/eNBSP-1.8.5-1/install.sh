#!/bin/sh
INSTALL_PATH="/usr/local/NITGEN/"
TARGET="eNBSP"
OBJECT="libNBioBSP.so"

if [ -d $INSTALL_PATH ]; then
	# Do nothing
	echo  
else
	echo "Install Path does not exist , will create"
	mkdir $INSTALL_PATH
fi

if [ -d $INSTALL_PATH$TARGET  ]; then
	echo "NBioBSP already exists"
	echo "run uninstaller to uninstall NBioBSP"
	exit 1
else
	echo "NBioBSP install..."
	cp -rf $TARGET $INSTALL_PATH
fi

if [ -f /lib/$OBJECT ]; then
	echo $OBJECT "already exists"
	echo "Overwrite object file."
	rm -f /lib/$OBJECT
	cd $INSTALL_PATH$TARGET/bin/
	cp -f $OBJECT /lib/
else
	echo "copy object file."
	cd $INSTALL_PATH$TARGET/bin/
	cp -f $OBJECT /lib/
fi

echo "NBioBSP successfully installed "
