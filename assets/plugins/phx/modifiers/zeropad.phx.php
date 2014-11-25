<?php

/* Retrieved from http://wiki.modxcms.com/index.php/PHx/CustomModifiers
  * description: Zero-padding a string. Takes the number of total digits as the input.
  * example: This can be useful when you want to output some kind of ID numbers with fixed digits, or US zip codes: "00001", "00124", "90210"
  * usage: [+ditto_iteration:zeropad=`3`] [*zipcode:zeropad=`5`*]
  * default: No zero-padding.
  * added by: ryanlwh
*/

return sprintf("%0".$options."s",$output);

?>