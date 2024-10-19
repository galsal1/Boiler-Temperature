/* usbreset -- send a USB port reset to a USB device */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <fcntl.h>
#include <errno.h>
#include <sys/ioctl.h>

#include <linux/usbdevice_fs.h>

void unbind_usb(const char *port){
    const char *unbind_path = "/sys/bus/usb/drivers/usb/unbind";
    FILE *unbind_file = fopen(unbind_path,"w");

    if (unbind_file == NULL) {
        perror("Error opening unbind file");
        exit(EXIT_FAILURE);
    }

    if(fprintf(unbind_file,"%s",port)<0){
        perror("Error writing to unbind file");
        fclose(unbind_file);
        exit(EXIT_FAILURE);
    }
    fclose(unbind_file);
    printf("Unbound USB device at port: %s\n",port);
}

void rebind_usb(const char *port){
    const char *bind_path = "/sys/bus/usb/drivers/usb/bind";
    FILE *bind_file = fopen(bind_path,"w");

    if (bind_file == NULL) {
        perror("Error opening bind file");
        exit(EXIT_FAILURE);
    }

    if(fprintf(bind_file,"%s",port)<0){
        perror("Error writing to bind file");
        fclose(bind_file);
        exit(EXIT_FAILURE);
    }
    fclose(bind_file);
    printf("bound USB device at port: %s\n",port);
}

int main(int argc, char **argv)
{
    printf("start check connecting to ip...\n");
    sleep(30);
    char *ip_address = "192.168.1.1";
    char command[100];
    snprintf(command,sizeof(command),"ping -c 1 %s",ip_address);
    int res = system(command);
    if(res==0){
        return 0;
    }
    for(int i=0;i<5;i++){
        const char *usb_port = "1-1";
        unbind_usb(usb_port);
        sleep(5);
        rebind_usb(usb_port);
        sleep(30);
        snprintf(command,sizeof(command),"ping -c 1 %s",ip_address);
        res = system(command);
        if(res==0){
            break;
        }
    }
    return 0;
}