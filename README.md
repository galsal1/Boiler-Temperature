# Boiler-Temperature
Server that measure the temperture of the boiler using raspberry-pi and AD/DA

##setup for the AD/DA board
###Open SPI Interface
1) Open the Raspberry Pi terminal, and enter the configuration interface with the following commands:<br />
   sudo raspi-config <br />
   Choose Interfacing Options -> SPI -> Yes to enable the SPI interface
![RPI_open_spi](https://github.com/galsal1/Boiler-Temperature/assets/127937643/5255206d-5892-4830-9e7b-d84ad0eec54e)

2) reboot Raspberry Pi with command: sudo reboot

3) Check /boot/config.txt, and you can see 'dtparam=spi=on' was written in.
![Raspberry_Pi_Guides_for_4 37_e-Paper](https://github.com/galsal1/Boiler-Temperature/assets/127937643/0c1a4e2b-d94a-4a75-b6a3-25482b84177b)
To make sure SPI is not occupied, it is recommended to close other drivers' coverage. You can use ls /dev/spi to check whether SPI is occupied. If the terminal outputs /dev/spidev0.1 and /dev/spidev0.1, SPI is not occupied.![Raspberry_Pi_Guides_for_4 37_e-Paper02](https://github.com/galsal1/Boiler-Temperature/assets/127937643/bcc2126c-b6db-4576-9a76-84b92ddce7e9)
