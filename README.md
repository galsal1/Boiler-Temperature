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

   
   
