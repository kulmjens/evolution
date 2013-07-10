<?php

/* Retrieved from http://wiki.modxcms.com/index.php/PHx/CustomModifiers
description: get specified field from document (id)
usage: [+docid:docfield=`field`+]
defaults to pagetitle
added by: bwente
*/

$field = (strlen($options)>0) ? $options : 'pagetitle';
$docfield = $modx->getTemplateVarOutput(array($field), $output, 1);
return $docfield[$field];
?>