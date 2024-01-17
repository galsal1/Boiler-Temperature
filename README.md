# Boiler-Temperature
Server that measure the temperture of the boiler using raspberry-pi and AD/DA

## setup for the AD/DA board
### Open SPI Interface
1) Open the Raspberry Pi terminal, and enter the configuration interface with the following commands:<br />
   sudo raspi-config <br />
   Choose Interfacing Options -> SPI -> Yes to enable the SPI interface
![RPI_open_spi](https://github.com/galsal1/Boiler-Temperature/assets/127937643/5255206d-5892-4830-9e7b-d84ad0eec54e)

2) reboot Raspberry Pi with command: sudo reboot

3) Check /boot/config.txt, and you can see 'dtparam=spi=on' was written in.
![Raspberry_Pi_Guides_for_4 37_e-Paper](https://github.com/galsal1/Boiler-Temperature/assets/127937643/0c1a4e2b-d94a-4a75-b6a3-25482b84177b)<br />
To make sure SPI is not occupied, it is recommended to close other drivers' coverage. You can use ls /dev/spi to check whether SPI is occupied. If the terminal outputs /dev/spidev0.1 and /dev/spidev0.1, SPI is not occupied.<br />
![Raspberry_Pi_Guides_for_4 37_e-Paper02](https://github.com/galsal1/Boiler-Temperature/assets/127937643/bcc2126c-b6db-4576-9a76-84b92ddce7e9)
 
### Install Libraries
1) **Install BCM2835 libraries:** </br>
   Open the Raspberry Pi terminal and run the following command
   ```
   wget http://www.airspayce.com/mikem/bcm2835/bcm2835-1.71.tar.gz
   tar zxvf bcm2835-1.71.tar.gz
   cd bcm2835-1.71/
   sudo ./configure && sudo make && sudo make check && sudo make install
   ```
   </br>
   
3) **Install WiringPi libraries:** </br>
   Open the Raspberry Pi terminal and run the following command</br>
   ```
   cd
   sudo apt-get install wiringpi
   ```
   #For Raspberry Pi systems after May 2019 (earlier than that can be executed without), an upgrade may be required:</br>
   ```
   wget https://project-downloads.drogon.net/wiringpi-latest.deb
   sudo dpkg -i wiringpi-latest.deb
   gpio -v
   ```
   #Run gpio -v and version 2.52 will appear, if it doesn't it means there was an installation error</br>
   #Bullseye branch system using the following command:
   ```
   git clone https://github.com/WiringPi/WiringPi
   cd WiringPi
   . /build
   gpio -v
   ```
   #Run gpio -v and version 2.70 will appear, if it doesn't it means there was an installation error </br>

3) **python:**</br>
   Open the Raspberry Pi terminal and run the following command</br>
   ```
   sudo apt-get update
   sudo apt-get install ttf-wqy-zenhei
   sudo apt-get install python-pip
   sudo pip install RPi.GPIO
   sudo pip install spidev
   ```

### Install Apache server
1) Before we install Apache to our Raspberry Pi, we must first ensure the package list is up to date by running the following two commands.</br>
```
sudo apt-get update
sudo apt-get upgrade
```
2) To install apache2 on your Raspberry Pi, enter the following command into the terminal. </br>
```
sudo apt install apache2 -y
```
3) To be able to make changes to the files within the /var/www/html without using root we need to setup some permissions.</br>
Firstly, we add the user pi (our user) to the www-data group, the default group for Apache2.</br>
Secondly, we give ownership to all the files and folders in the /var/www/html directory to the www-data group.</br>
Open the Raspberry Pi terminal and run the following command</br>
```
sudo usermod -a -G www-data pi
sudo chown -R -f www-data:www-data /var/www/html
```

### Install PHP7
Open the Raspberry Pi terminal and run the following command</br>
```
sudo apt install php7.4 libapache2-mod-php7.4 php7.4-mbstring php7.4-mysql php7.4-curl php7.4-gd php7.4-zip -y
sudo apt-get install php7.4-sqlite
```

## Now we ready for setup the server
### Copy file from this Git
copy all the file from this git and paste them into /var/www/html folder </br>
remove index.html file from this folder</br>
after this step the folder should look like this (only the black rectangle)</br>
![image](https://github.com/galsal1/Boiler-Temperature/assets/127937643/6b759432-91e7-468c-b726-0c418b2fd863)

### Main.py start running on boot
Now open the Raspberry Pi terminal and write</br>
```
sudo nano /etc/rc.local
```
add to this file this line at the end of the file
```
sudo python /var/www/html/Main.py
```
and after that reboot Raspberry-pi

</br></br>
# WiFi connect with dongle to Raspberry-pi without WiFi
## Connect the Hardware and check for USB WiFi Dongle Hardware
type the following command in the terminal and hit enter  </br>
```
dmesg | more
```
Hit space bar multiple times to jump to next page of the list. If you scroll down, you can see few lines related to the WiFi Dongle, something similar to the following.</br>
![image](https://github.com/galsal1/Boiler-Temperature/assets/127937643/e5255dbb-e183-40f2-aa8c-05180de2372e)</br>
This means that the Raspbian OS has detected the USB WiFi Dongle. But the Dongle doesn’t work yet as we need to configure it.</br>

## Edit the Network Interfaces File
We need to edit the network interfaces file that is located at /etc/network/interfaces. This file sets up the WiFi Dongle we are going to use. In order to open the network interfaces file, type the following command and hit enter.</br>

```
sudo nano /etc/network/interfaces
```
Depending on the version of the Raspbian Operating system you have installed, the network interfaces file will already have few lines of text. Regardless of the content, make sure the following lines of code are present. If not, add these lines to the existing code.
```
auto lo

iface lo inet loopback

iface eth0 inet manual

auto wlan0

allow-hotplug wlan0

iface wlan0 inet manual

wpa-roam /etc/wpa_supplicant/wpa_supplicant.conf
```
Your updated code should look something like this.</br>
![screen1](https://github.com/galsal1/Boiler-Temperature/assets/127937643/fa6fc81c-5aa0-4776-94a2-90b82d5117d8)</br>
Press CTRL+X to exit the editor. It will ask you whether to save changes to the file or not. Type y and hit enter. You will go back to the terminal. We are done with editing the Network Interfaces File.

## Edit the WPA Supplicant File
The WPA or WiFi Protected Access Supplicant file consists of the details regarding the WiFi network like the name, password, security, type etc.</br></br>

We need to edit this file and add the details of your personal WiFi network. In order to open the WPA Supplicant File, type the following command and hit enter.
```
sudo nano /etc/wpa_supplicant/wpa_supplicant.conf
```
Add the following lines of code to the existing code (if any). Make necessary changes to the following code as per your WiFi network details.
```
network={

ssid=”Name of WiFi Network”

psk=”Password of the WiFi Network”

proto=RSN

key_mgmt=WPA-PSK

pairwise=CCMP TKIP

group=CCMP TKIP

id_str=”Name of WiFi Network”

}
```
The edited file will look something like this.</br>
![image](https://github.com/galsal1/Boiler-Temperature/assets/127937643/56be7fb8-568c-41f7-bfa2-2de63b0184be)</br>
Replace Name of WiFi Network with the actual name of your WiFi Network. In our case, it is home1. Similarly, enter the password of the WiFi network corresponding to psk.</br></br>

In order to exit and save the file with the same name, press CTRL+X and then Y and finally hit enter.

## Reboot the Raspberry Pi
If you are done with the above steps, you can reboot the Raspberry Pi. In the Putty Terminal, just the following command.
```
sudo reboot
```
To test the WiFi connection, we can use different commands. First, you can use the following command to get details of all the network connections.</br>
![screen1](https://github.com/galsal1/Boiler-Temperature/assets/127937643/7dd46ccd-2d71-4d85-99f1-18ea2af26bad)</br></br>

another way is to ping to google or another site
```
sudo ping www.google.com
```

## Troubleshooting
If you are facing any trouble connecting to WiFi using the USB WiFi Dongle check for the following. These might be the problem (but not limited to these).</br>

1) **Power:** WiFi Adapters might require more power and if your power supply cannot provide enough power to it, it might not function properly.
2) **Compatibility:** Check for the list of compatible external WiFi adapters and buy one.
3) **USB Adapter:** Check if the Dongle is perfectly fitted in to the USB Port.
4) **WiFi Network:** Check if your WiFi network is up and running.
5) **Network Interfaces and WPA Supplicant Files:** Make sure that you have entered the correct commands in the corresponding files.
6) **Power Down and Reboot:** Power down the Raspberry Pi and reboot again.

</br></br>
<sup>the installation instructions of the Wifi dongle is taken from electronicshub site</sup>








   
