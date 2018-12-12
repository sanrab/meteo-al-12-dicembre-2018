#!/bin/bash

file='/home/sandro/bmp_data.txt'

while true
do
	curl -s 'http://raspi-meteo.local:8080/json.htm?type=devices&rid=1' | jq .result[0].Temp | sed 's/\"//g' | awk '{ printf $1"," } ' | cat > $file
	curl -s 'http://raspi-meteo.local:8080/json.htm?type=devices&rid=1' | jq .result[0].Barometer | sed 's/\"//g' | awk '{ print $1 }' | cat  >> $file
	sleep 10
done
