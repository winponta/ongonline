#!/bin/bash
KER_VER=`uname -r`
DRIVER_PATH="/lib/modules/$KER_VER/kernel/drivers/usb/misc/"
device="nitgen"
major=180

if [ -d $DRIVER_PATH ]; then
	# Do nothing
	echo
else
	echo Driver Path does not exist , will create
	mkdir $DRIVER_PATH
fi

if [ -f $DRIVER_PATH/VenusDrv.ko  ]; then
	echo $DRIVER_PATH"VenusDrv.ko already exists"
	echo run uninstaller  to uninstall drive 
	exit 1
fi

if [ -f VenusDrv.ko  -a  -f VenusDrv.h  ]; then
	drvkernel=`/sbin/modinfo VenusDrv.ko | grep vermagic | cut -f8 -d " "`
	# checking for kernel version with driver compiled version .
	if [ $drvkernel == $KER_VER ]; then
		#echo "copying ----- driver DUMMY  "
		cp -v VenusDrv.ko $DRIVER_PATH
	else
		echo your kernel version $KER_VER does not match with NITGEN USB Driver compiled kernel verion  $drvkernel
		echo you can compile NITGEN USB Fingkey Hamster driver source
		echo and  run this script or Get $KER_VER driver binary from vendor.
		exit 1
	fi
else
	echo "VenusDrv.ko or VenusDrv.h  file not found in current dir ....."
	exit 1;
fi

if [ -f /usr/include/linux/VenusDrv.h ]; then
	echo "VenusDrv.h already exists"
	exit 1
fi

cp -v VenusDrv.h /usr/include/linux/


if [ -f /lib/VenusLib.so ]; then
	echo "VenusLib.so already exists"
	exit 1
fi

if [ -f VenusLib.so ]; then
	cp -v VenusLib.so /lib/
else
	echo "VenusLib.so not exist"
	exit 1
fi

if [ -f VenusDrv.conf ]; then
	cp -f VenusDrv.conf /etc/
	chmod 666 /etc/VenusDrv.conf
else
	echo "VenusDrv.conf not exist"
	exit 1
fi

#remove stale node
rm -f /dev/${device}[0-7]
#create 8 nodes for the device
mknod /dev/${device}0 c $major 230
mknod /dev/${device}1 c $major 231
mknod /dev/${device}2 c $major 232
mknod /dev/${device}3 c $major 233
mknod /dev/${device}4 c $major 234
mknod /dev/${device}5 c $major 235
mknod /dev/${device}6 c $major 236
mknod /dev/${device}7 c $major 237

#move  to driver detination directory
cd $DRIVER_PATH
#install the driver module into kernel
/sbin/insmod VenusDrv.ko

echo ""
echo "Please wait for creating a list of module dependencies."
/sbin/depmod -a $KER_VER
echo ""

# start hotplugging
#echo "starting hotplugging ......"
#/bin/sh /etc/init.d/hotplug start
echo "NITGEN USB Fingkey Hamster Driver sucessfully installed "
echo "Disconnect the Device and Plug it back "

