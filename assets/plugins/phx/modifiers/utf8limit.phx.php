<?php

/* 
    * description: returns the limited utf8 string
    * usage: [+string:utf8limit=`300`+] 
*/
$options = (int)$options?(int)$options:0;
if ($options) $output = mb_substr($output,0,$options,"utf-8");
return $output;

?>