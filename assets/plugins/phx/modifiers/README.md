PHx modifier
================================================================================

A small collection of PHx Modifiers for MODX Evolution


Installation:
================================================================================
Copy the files into `assets/plugins/phx/modifiers` (if the PHx Plugin is 
installed) or insert them as snippet named 'phx:filename' (without '.phx.php') 
in the MODx backend.


Usage:
================================================================================

Modifier | Description
-------- | -----------
docfield | Returns a document field (defaults to pagetitle) of a given docid.
doclevel | Returns the doclevel of a given docid.
isnumeric | **(conditional)** Will be set to true if the string is numeric.
isnotnumeric | **(conditional)** Will be set to true if the string is not numeric.
jsonencode | Returns the JSON representation of the string. Outer quotes could be removed by option.
num_format | number format a string.
pregreplace | preg_replace a string.
striptags | Strip html tags.
dateformat | Format date from unix or reformated date string.
substr | Returns a substring of a string.
switch | Switch for PHx. The internal select modifier of PHx does not provide a default option.
switchc | Switch chunks for PHx. PHx could only surpress the output of the chunk/snippet call. With this modifier chunks for not valid values are even not evaluated. The internal select modifier of PHx does not provide a default option.
trim | Trims a string. Stripped characters could be specified in the options of the modifier

A sample usage string and extended description (if nessesary) could be found in the first lines of the code of each modifier file.

Conditional modifier have to be used with then/else.