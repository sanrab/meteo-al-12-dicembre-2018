#!/usr/bin/python
import serial
import time
ser=serial.Serial('/dev/ttyUSB1',9600)
while True:
    f=open('/home/pi/bmp_data.txt','w')
    data=ser.readline()
    f.write(data)
#    print data

time.sleep(10)
