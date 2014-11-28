#PHx modifier

An collection of PHx Modifiers for MODX Evolution


#Installation:
Copy the files into `assets/plugins/phx/modifiers` (if the PHx Plugin is 
installed) or insert them as snippet named 'phx:filename' (without '') 
in the MODx backend.


#Content:

##Standart package

Modifier | Description
-------- | -----------
**7bit** | returns the 7bit representation of a string. Example: ``[+string:7bit+]``
**bbcode** | parse bb code (also escapes all html and MODx tags characters). Example: ``[+variable:bbcode+]`` 
**get** | Returns the GET parameter which has been posted as a query string. Example: ``[*phx:get=`paramname`*]``
**ifnotempty** | The opposite of the native PHX "**isempty**" function. Returns the option value ONLY if the input value is empty (excluding whitespace), Example ``[+string:ifnotempty=`String to return if not empty`+]`` 
**nohttp** | Removes the http:// from a URL, to create a display-friendly web address. Example: ``[+string:nohttp+]``
**parent** | Get specified document field from parent document. This one is changed from standard - it get parent even if it inactive . Example: ``[+phx=`[*id*]`:parent=`field`+]``
**post** | Same as **get** for POST requests
**tidyword** |  Get the Word infested input


##Modifiers retrieved from [wiki.modxcms.com](http://wiki.modxcms.com/index.php/PHx/CustomModifiers)

Modifier | Description
-------- | -----------
**docfield** | Returns a document field (defaults to **pagetitle**). Example: ``[+phx=`[*id*]`:docfield=`field`+]``.
**zeropad** | Zero-padding a string. Takes the number of total digits as the input. Example: ``[+ditto_iteration:zeropad=`3`+] [*zipcode:zeropad=`5`*]``

##Other modifiers:

Modifier | Description
-------- | -----------
**dateformat** | Return an formatted date. Example: from timestamp: ``[+createdon:dateformat=`%H:%M %d.%m.%Y`+]``, from date string in other format ``[+tv_var:dateformat=`%H:%M %d.%m.%Y|%d-%m-%Y %H:%M:%S`+]``
**default** | Return an default text if variable is empty. Example ``[*variable:default=`Default text`*]``
**doclevel** | Returns the doclevel of a given docid. Example: ``[+docid:doclevel+]``
**element** | Get an element of multivalue. Example: first element: ``[*tv_var:element*]``, same, but delimited by "::" ``[*tv_var:element=`0::`*]``, get second, delimited by "||" ``[*tv_var:element=`1||`*]``, get thidr, delimited by comma ``[*tv_var:element=`2,`*]``, get from an resource ``[+phx:input=`1`:docfield=`tv_var`:element=`0::`+]``
**firstitem** | returns the first item in list delimeted by comma. Example: ``[+string:firstitem+]`` 
**in** | Check  value is in array delimited by one of: ";,".Example: ``[+variable:in=`1,2,3;4;5`:then=`This is in`+]``
**isnotnumeric** | Check the string is not numeric. Example: ``[+string:isnotnumeric:then=`Is not numeric`:else=`Is numeric`+]``
**isnumeric** | Check the string is numeric. Example: ``[+string:numeric:then=`Is Numeric`:else=`Is not numeric`+]``
**jsonencode** | Returns the JSON representation of the string with or not stripouterquotes (set option 0 or 1). Example: ``[+string:jsonencode=`0`+]``
**num_format** | format a numeric value. ``[+variable:num_format=`decimals|dec_point|thousands_sep`+]``
**pregreplace** | Replace in string by regular expression. Example: ``[+variable:preg_replace=`/regexp/||str_replace_to`+]``
**specialchar** | Returns the htmlspecialchars of a string. Example: ``[+string:specialchar+]`` 
**striptags** | Remove html tags from text. Example: ``[+text:striptags+]``
**switch** | Switch for PHx. Example: ``[+string:switch=`xx:{{Chunk}}|yy:[*DocVar*]|default:[+TemplateVar+]+]``
**substr** | Returns a substring of a string. Example: ``[+string:substr=`0,-3`+]``
**switchc** | Switch chunks for PHx. PHx has one big problem with (visible) chunks at the beginning of the parsing process. They would be evaluated regardless of beeing shown. Example: ``[+string:switchc=`xx:chunkname|yy:chunkname|default:chunkname+]``
**trim** | Trims a string. Stripped characters could be specified in the options of the modifier. Example: ``[+string:trim=` `+]``
**utf8limit** | Returns the limited utf8 string. Example: `` [+string:utf8limit=`300`+] ``

For more understanding see in the code of each modifier file.
