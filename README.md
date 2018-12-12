# meteo-al-12-dicembre-2018

sistemi di acquisizione dati meteo

(1) Raspberry Pi ZeroW (Raspbian) + Arduino Mega 2560 + Aurel RX 4MM5/F receiver + transmitter (XY-FS) module  [RFLink] + BMP180 I2C + LCD serial 4x20 + Domoticz

(2) Asus EB-1007 (Debian 9 Stretch) + RTL-SDR Nooelec (rtl-sdr, rtl_433) + weewx (weewx_sdr)
legge dati temperatura interna e pressione da BMP180 del sistema 1 da rete con domoticz_bmp_to_file.sh

modificato pond.py per conversione C --> Fahrenheit e mBar --> inHg per weewx

inTemp = inTemp*9/5+32

barometer = barometer*0.02952998751

modificato /etc/rc.local in modo che esegua
/home/sandro/domoticz_bmp_to_file.sh &

quindi weewx legge dati sensori con weewx-sdr + dati BMP180 di domoticz (raspi-meteo)
