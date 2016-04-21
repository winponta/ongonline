#!/bin/sh
KER_VER=`uname -r`
DRIVER_PATH="/lib/modules/$KER_VER/kernel/drivers/usb/misc/"
device="ngstar"
echo "uninstalling driver......."
#remove stale node
  rm -f /dev/${device}[0-7]

# uninstall driver from kernel space
 /sbin/rmmod ngstardrv.ko
  
#delete module from source
if [ -f $DRIVER_PATH/ngstardrv.ko ]; then
	rm -f $DRIVER_PATH/ngstardrv.ko
fi
#remove headerfile
if [ -f /usr/include/linux/ngstardrv.h ]; then
	rm -f /usr/include/linux/ngstardrv.h
fi
#remove user module
if [ -f /lib/ngstarlib.so ]; then
	rm -f /lib/ngstarlib.so
fi
#remove Device conf. file
if [ -f /etc/ngstardrv.conf ]; then
	rm -f /etc/ngstardrv.conf
fi

echo ""
echo "Please wait for creating a list of module dependencies."
/sbin/depmod -a $KER_VER
echo ""

echo "driver un-installed successfully"
