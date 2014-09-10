<?php

/*
  * description: Return an formatted date
  * usage:[+variable:dateformat=`<Format To>[|Format From]`+]
  *  for timestamp
  *   [+createdon:dateformat=`%H:%M %d.%m.%Y`+]
  *  for reformat date string from other format
  *   [+tv_var:dateformat=`%H:%M %d.%m.%Y|%d-%m-%Y %H:%M:%S`+]
  *  added by: MrSwed
*/

$debug="";
if (empty($options)) $options = "%H:%M %d.%m.%Y";
$options = explode("|",$options);
if (!is_numeric($output)) {
 if (empty($options[1])) $options[1] = "%d-%m-%Y %H:%M:%S";
 $parsed = strptime($output,$options[1]);
 $output = mktime($parsed['tm_hour'],$parsed['tm_min'],$parsed['tm_sec'],$parsed['tm_mon']+1,$parsed['tm_mday'],$parsed['tm_year']+1900);
}
return strftime($options[0],$output);

?>