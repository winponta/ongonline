#!/bin/sh
KER_VER=`uname -r`
DRIVER_PATH="/lib/modules/$KER_VER/kernel/drivers/usb/misc/"
device="nitgen"
echo "uninstalling driver......."
#remove stale node
  rm -f /dev/${device}[0-7]

# uninstall driver from kernel space
 /sbin/rmmod VenusDrv.ko
  
#delete module from source
if [ -f $DRIVER_PATH/VenusDrv.ko ]; then
	rm -f $DRIVER_PATH/VenusDrv.ko
fi
#remove headerfile
if [ -f /usr/include/linux/VenusDrv.h ]; then
	rm -f /usr/include/linux/VenusDrv.h
fi
#remove user module
if [ -f /lib/VenusLib.so ]; then
	rm -f /lib/VenusLib.so
fi
#remove Device conf. file
if [ -f /etc/VenusDrv.conf ]; then
	rm -f /etc/VenusDrv.conf
fi

echo ""
echo "Please wait for creating a list of module dependencies."
/sbin/depmod -a $KER_VER
echo ""

echo "driver un-installed successfully"

