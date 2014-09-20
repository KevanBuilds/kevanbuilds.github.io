===================================
EXTENSION INSTALLATION INSTRUCTIONS
===================================
Initial release of Tinymce extension.


Install:
--------
Before installing make sure you have disabled all other editors, like Dojo and FCKeditor etc.

In order for Vanilla to recognize an extension, it must be contained within it's own directory within the extensions directory. So, once you have downloaded and unzipped the extension files, you can then place the folder containing the default.php file into your installation of Vanilla.

The path to your extension's default.php file should look like this:

1) /path/to/vanilla/extensions/Tinymce/default.php
2) Download Tinymce from (http://tinymce.moxiecode.com/download.php)
3) unzip it in /path/to/vanilla/js/tinymce/ so that the path to tiny_mce.js should look like this: /path/to/vanilla/js/tinymce/jscripts/tiny_mce/tiny_mce.js

Tinymce comes with lot of files that you don't need. All you need is the Jscripts folder. You can delete the docs and examples directory

if u are using Add Comments Extension set this to false in default.php
$Configuration["TINYMCE_LOGINREQUIRED"] = true;          	
Once this is complete, you can enable the extension through the "Manage Extensions" form on the settings tab in Vanilla. don't forget to disable other WYSIWYG editors like dojo and FCKeditor


Languages:
----------
Read this Wiki on how to add language support
http://wiki.moxiecode.com/index.php/TinyMCE:LanguagePack

Speed Loading:
--------------
TinyMCE Compressor gzips all javascript files in TinyMCE to a single streamable file.
This makes the overall download sice 75% smaller and the number of requests will also be reduced.
The overall initialization time for TinyMCE will be reduced dramatically if you use this script.

Here is a step by step list on how to install the GZip compressor.
   1. Download Tinymce Compressor from http://tinymce.moxiecode.com/download.php
   2. Copy the tiny_mce_gzip.js and tiny_mce_gzip.php to the tiny_mce directory. The same directory that contains the tiny_mce.js file.
   3. There is no #3 :P. It should work now. check the source code and see if a tiny_mce_gzip.js is added as a script.