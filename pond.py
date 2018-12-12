#!/usr/bin/python

# per weewx su PC
# https://github.com/weewx/weewx/wiki/add-sensor

# in weewx.conf

# [Engine]
#    [[Services]]
#        data_services = ..., user.pond.PondService


import syslog
import weewx
from weewx.engine import StdService
import csv

class PondService(StdService):
	def __init__(self, engine, config_dict):
		super(PondService, self).__init__(engine, config_dict)
		d = config_dict.get('PondService', {})
		self.filename = d.get('filename','/home/pi/bmp_data.txt')
		syslog.syslog(syslog.LOG_INFO, "pond: using %s" % self.filename)
		self.bind(weewx.NEW_ARCHIVE_RECORD, self.read_file)

	def read_file(self, event):
		try:
			with open (self.filename) as f:
				line = f.readline()
				values = line.split(',')
				inTemp = float(values[0])
        inTemp = inTemp*9/5+32 # C to Fahrenheit
				barometer = float(values[1])
        barometer = barometer*0.02952998751 # mBar to inHg
			syslog.syslog(syslog.LOG_DEBUG, "pond: found values of %s" % values)
			event.record['inTemp'] = inTemp
			event.record['barometer'] = barometer
		except Exception, e:
			syslog.syslog(syslog.LOG_ERR, "pond: cannot read value: %s" % e)
