<?php

/* By Swed
 * description: Get an element of multivalue
 * usage: [+variable:element=`<number><delimiter>`+]
 *   <number> - integer, default 0
 *   <delimiter> - any string (not number), default ||
 * Examples:
 *  [*tv_var:element*]
 *  [*tv_var:element=`0::`*]
 *  [*tv_var:element=`1||`*]
 *  [*tv_var:element=`2,`*]
 *  [+phx:input=`1`:docfield=`tv_var`:element=`0::`+]
*/

$m=array();
if (!empty($options)) preg_match("/^(\d+)(.*)$/",$options,$m);
$id = !empty($m[1])?$m[1]:0;
$delimiter = !empty($m[2])?$m[2]:'||';
$a = explode($delimiter,$output);
return !empty($a[$id])?$a[$id]:"";


?>