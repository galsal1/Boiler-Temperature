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
   Open the Raspberry Pi terminal and run the following command </br>
   wget http://www.airspayce.com/mikem/bcm2835/bcm2835-1.71.tar.gz </br>
   tar zxvf bcm2835-1.71.tar.gz </br>
   cd bcm2835-1.71/ </br>
   sudo ./configure && sudo make && sudo make check && sudo make install </br></br>
   ![image](https://github.com/galsal1/Boiler-Temperature/assets/127937643/21ddec5f-ece2-4549-83ba-f4689a613c5b)


2) **Install WiringPi libraries:** </br>
   Open the Raspberry Pi terminal and run the following command</br>
   cd</br>
   sudo apt-get install wiringpi</br>
   ![image](https://github.com/galsal1/Boiler-Temperature/assets/127937643/2109205f-d9b5-44a6-b4dd-d343e2b0b7b2) </br>
   #For Raspberry Pi systems after May 2019 (earlier than that can be executed without), an upgrade may be required:</br>
   wget https://project-downloads.drogon.net/wiringpi-latest.deb </br>
   sudo dpkg -i wiringpi-latest.deb </br>
   gpio -v </br>
   #Run gpio -v and version 2.52 will appear, if it doesn't it means there was an installation error</br>
   #Bullseye branch system using the following command:</br>
   git clone https://github.com/WiringPi/WiringPi</br>
   cd WiringPi</br>
   . /build</br>
   gpio -v</br>
   ![image](https://github.com/galsal1/Boiler-Temperature/assets/127937643/49dbd676-3ae3-40b5-b4f6-da3458c0e12b)</br>
   #Run gpio -v and version 2.70 will appear, if it doesn't it means there was an installation error

3) **python:**</br>
   Open the Raspberry Pi terminal and run the following command</br>
   sudo apt-get update </br>
   sudo apt-get install ttf-wqy-zenhei </br>
   sudo apt-get install python-pip </br>
   sudo pip install RPi.GPIO </br>
   sudo pip install spidev </br>
   ![image](https://github.com/galsal1/Boiler-Temperature/assets/127937643/a1d17f3e-fe7c-4c13-b110-30d42ebb0b64)

### Install Apache server
1) Before we install Apache to our Raspberry Pi, we must first ensure the package list is up to date by running the following two commands.</br>
sudo apt-get update </br>
sudo apt-get upgrade </br>
![image](https://github.com/galsal1/Boiler-Temperature/assets/127937643/ca03e343-1d36-4a02-8ffe-d9661ee356b1)</br>
2) To install apache2 on your Raspberry Pi, enter the following command into the terminal. </br>
sudo apt install apache2 -y </br>
![image](https://github.com/galsal1/Boiler-Temperature/assets/127937643/27126c8a-6483-4616-ac75-88786c6c8ccb)
3) To be able to make changes to the files within the /var/www/html without using root we need to setup some permissions.</br>
Firstly, we add the user pi (our user) to the www-data group, the default group for Apache2.</br>
Secondly, we give ownership to all the files and folders in the /var/www/html directory to the www-data group.</br>
![image](https://github.com/galsal1/Boiler-Temperature/assets/127937643/8cedcb32-04be-48de-8bfa-efc18ff1a720)

### Install PHP7
Open the Raspberry Pi terminal and run the following command</br>
```
sudo apt install php7.4 libapache2-mod-php7.4 php7.4-mbstring php7.4-mysql php7.4-curl php7.4-gd php7.4-zip -y
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
Depending on the version of the Raspbian Operating system you have installed, the network interfaces file will already have few lines of text. Regardless of the content, make sure the following lines of code are present. If not, add these lines to the existing code. </br>








   
