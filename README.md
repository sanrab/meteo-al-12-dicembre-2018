# meteo-al-12-dicembre-2018
sistemi di acquisizione dati meteo

(1) Raspberry Pi ZeroW (Raspbian) + Arduino Mega 2560 + Aurel RX 4MM5/F receiver + transmitter (XY-FS) module  [RFLink] + BMP180 I2C + LCD serial 4x20 + Domoticz

(2) Asus EB-1007 (Debian 9 Stretch) + RTL-SDR Nooelec (rtl-sdr, rtl_433) + weewx (weewx_sdr)
legge dati temperatura interna e pressione da BMP180 del sistema 1 da rete con:

#!/bin/bash

file='/home/sandro/bmp_data.txt'

while true
do
	curl -s 'http://raspi-meteo.local:8080/json.htm?type=devices&rid=1' | jq .result[0].Temp | sed 's/\"//g' | awk '{ printf $1"," } ' | cat > $file
	curl -s 'http://raspi-meteo.local:8080/json.htm?type=devices&rid=1' | jq .result[0].Barometer | sed 's/\"//g' | awk '{ print $1 }' | cat  >> $file
	sleep 10
done

modificato pond.py per conversione C --> Fahrenheit e mBar --> inHg per weewx

inTemp = inTemp*9/5+32

barometer = barometer*0.02952998751

modificato /etc/rc.local in modo che esegua
/home/sandro/domoticz_bmp_to_file.sh &
