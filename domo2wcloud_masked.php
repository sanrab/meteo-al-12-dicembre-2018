#!/usr/bin/php


<?php

/*
upload domoticz weather data to weathercloud.net
sanrab, 19 dec 2018
*/

$server_url = "http://api.weathercloud.net/v01/set";
$wcloud_id = "XXXXXXX";
$wcloud_key = "XXXXXXX";
$login_url = "$server_url/wid/$wcloud_id/key/$wcloud_key";
$domo_ip_port = "http://domoticz_ip:domoticz_port";
$temp_file = "data.json";


$json_string = file_get_contents("$domo_ip_port/json.htm?type=devices&used=true&filter=all&favorite=1");
$parsed_json = json_decode($json_string, true);
$data = fopen ($temp_file, "w");
fwrite ($data, print_R($parsed_json, TRUE));
fclose ($data);

//	parse variables

$parsed_json = json_decode($json_string, true);
$parsed_json = $parsed_json['result'][0];
$temp_ext = $parsed_json['Temp'];
$parsed_json = json_decode($json_string, true);
$parsed_json = $parsed_json['result'][0];
$hum = $parsed_json['Humidity'];
$parsed_json = json_decode($json_string, true);
$parsed_json = $parsed_json['result'][2];
$bar = $parsed_json['Barometer'];
$parsed_json = json_decode($json_string, true);
$parsed_json = $parsed_json['result'][2];
$temp_int = $parsed_json['Temp'];
$parsed_json = json_decode($json_string, true);
$parsed_json = $parsed_json['result'][1];
$rain = $parsed_json['Rain'];
$parsed_json = json_decode($json_string, true);
$parsed_json = $parsed_json['result'][3];
$speed = $parsed_json['Speed'];
$parsed_json = json_decode($json_string, true);
$parsed_json = $parsed_json['result'][3];
$dir = $parsed_json['Direction'];

$temp_ext=$temp_ext*10;
$bar=$bar*10;
$temp_int=$temp_int*10;
$rain=$rain*10;
$speed=$speed*10;

$ver="0.1";
$type="4c60f6455101";
$part_preamble="$server_url/wid/$wcloud_id/key/$wcloud_key/ver/$ver/type/$type";
$part_data="/temp/$temp_ext/tempin/$temp_int/hum/$hum/bar/$bar/rain/$rain/wspd/$speed/wdir/$dir";

$url_upload = $part_preamble.$part_data;
// echo $url_upload."\n";

$ch=curl_init($url_upload);

curl_exec($ch);
curl_close($ch);

?>

