<?php

/* By Swed
    * description: pregreplace $output
    * usage: [+variable:preg_replace=`/regexp/||str_replace_to`+]
    * 
*/	

if (!empty($options)) {
 $options = str_replace($this->safetags[1],$this->safetags[2],$options);
 list($patterns, $replace) = explode("||",$options,2);
 return preg_replace($patterns, $replace, $output);
}
return $output;


?>
