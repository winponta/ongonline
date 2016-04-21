/* NITGEN USB Fingkey Hamster (hfdu04) driver  - 1.0
 * Copyright(C) 2004, NITGEN CO., Ltd.
 * History: 
 *	29/10/2004 : first release  
 * 10/10/2009 : Added FDU06 device
 */

#ifndef __LINUX_HFDU04__
#define __LINUX_HFDU04__

#include <asm/ioctl.h>
#include <asm/types.h>

#define _BULK_DATA_LEN 64
typedef struct
{
        unsigned char data[_BULK_DATA_LEN];
        unsigned int size;
        unsigned int pipe;
}bulk_transfer_t,*pbulk_transfer_t;
/* I/O Control macros */

#define EZUSB_BULK_WRITE  	            _IOW('E',0x01,bulk_transfer_t )
#define EZUSB_BULK_READ  	            _IOR('E',0x02,bulk_transfer_t )
#define EZUSB_RESET_PIPE  	            _IO('E',0x03)
#define EZUSB_GET_DEVICE_DESCRIPTOR 	0x04  
#define SET_SENSOR_OPTION 			      0x05
#define GET_SENSOR_OPTION 			      0x06
#define SET_LATENT 				         0x07
#define SET_LED_CTL				         0x08
#define GET_ID					            0x09
#define GET_VALUE				            0x10
#define SET_VALUE				            0x11

// Added by khan, 2009.10.10
#define FDU06_GET_TOUCH_STATUS         0x12
#define FDU06_GET_SENSOR_SETTING       0x13
#define FDU06_SET_SENSOR_SETTING       0x14
#define FDU06_START_CONT_IMAGE_DATA    0x15
#define FDU06_IR_START_CONT_IMAGE_DATA 0x16
#define FDU06_STOP_CONT_IMAGE_DATA     0x17

#endif /*  __LINUX_hfdu04__ */ 
