<?php

/* By Swed
    * description: See if the output string is in one of the option delimited by one of: ;, (like 'is' ).
    * usage: [+variable:in=`1,2,3;4;5`+]
    * 
*/	

if (!empty($options)) {
 $options = str_replace($this->safetags[1],$this->safetags[2],$options);
 $optionsAr = preg_split("/[,;]+/",$options,-1,PREG_SPLIT_NO_EMPTY);
 $condition[] = intval(in_array($output,$optionsAr));
}
?>