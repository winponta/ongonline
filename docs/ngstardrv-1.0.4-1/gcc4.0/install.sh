#!/bin/bash
KER_VER=`uname -r`
DRIVER_PATH="/lib/modules/$KER_VER/kernel/drivers/usb/misc/"
device="ngstar"
major=180

if [ -d $DRIVER_PATH ]; then
	# Do nothing
	echo
else
	echo Driver Path does not exist , will create
	mkdir $DRIVER_PATH
fi

if [ -f $DRIVER_PATH/ngstardrv.ko  ]; then
	echo $DRIVER_PATH"ngstardrv.ko already exists"
	echo run uninstaller  to uninstall drive 
	exit 1
fi

if [ -f ngstardrv.ko  -a  -f ngstardrv.h  ]; then
	drvkernel=`/sbin/modinfo ngstardrv.ko | grep vermagic | cut -f8 -d " "`
	# checking for kernel version with driver compiled version .
	if [ $drvkernel == $KER_VER ]; then
		#echo "copying ----- driver DUMMY  "
		cp -v ngstardrv.ko $DRIVER_PATH
	else
		echo your kernel version $KER_VER does not match with NITGEN USB Driver compiled kernel verion  $drvkernel
		echo you can compile NITGEN USB Fingkey Hamster driver source
		echo and  run this script or Get $KER_VER driver binary from vendor.
		exit 1
	fi
else
	echo "ngstardrv.ko or ngstardrv.h  file not found in current dir ....."
	exit 1;
fi

if [ -f /usr/include/linux/ngstardrv.h ]; then
	echo "ngstardrv.h already exists"
	exit 1
fi

cp -v ngstardrv.h /usr/include/linux/


if [ -f /lib/ngstarlib.so ]; then
	echo "ngstarlib.so already exists"
	exit 1
fi

if [ -f ngstarlib.so ]; then
	cp -v ngstarlib.so /lib/
else
	echo "ngstarlib.so not exist"
	exit 1
fi

if [ -f ngstardrv.conf ]; then
	cp -f ngstardrv.conf /etc/
else
	echo "ngstardrv.conf not exist"
	exit 1
fi

#remove stale node
rm -f /dev/${device}[0-7]

#create 8 nodes for the device
mknod /dev/${device}0 c $major 246
mknod /dev/${device}1 c $major 247
mknod /dev/${device}2 c $major 248
mknod /dev/${device}3 c $major 249
mknod /dev/${device}4 c $major 250
mknod /dev/${device}5 c $major 251
mknod /dev/${device}6 c $major 252
mknod /dev/${device}7 c $major 253

#move  to driver detination directory
cd $DRIVER_PATH

#install the driver module into kernel
/sbin/insmod ngstardrv.ko

echo "" 
echo "Please wait for creating a list of module dependencies."
/sbin/depmod -a $KER_VER
echo "" 

# start hotplugging
#echo "starting hotplugging ......"
#/bin/sh /etc/init.d/hotplug start
echo "NITGEN USB Fingkey Hamster II / II DX Driver sucessfully installed "
echo "Disconnect the Device and Plug it back "
