========================
ABOUT ACRONYMS EXTENSION
========================

This extension replaces instances of defined acronyms comments with the full HTML
acronym tag, e.g. <acronym title="Hypertext Markup Language">HTML</acronym>.


===================================
EXTENSION INSTALLATION INSTRUCTIONS
===================================

In order for Vanilla to recognize an extension, it must be contained within it's
own directory within the extensions directory. So, once you have downloaded and
unzipped the extension files, you can then place the folder containing the
default.php file into your installation of Vanilla. The path to your extension's
default.php file should look like this:

/path/to/vanilla/extensions/Acronyms/default.php

Once this is complete, you can enable the extension through the "Manage
Extensions" form on the settings tab in Vanilla.


=====================
CONFIGURATION AND USE
=====================

The file "acronyms.txt" in the extension's folder contains a sampling of acronyms
that this extension will use.

Adding Acronyms: You can add your own acronyms by going to the extension's Extension
Options in Settings and adding a new acronym => title pair on a new line in the
Acronym List field.

Removing Words and Phrases: You can remove acronyms by going to the extension's
Extension Options in Settings and deleting the acronym => title pair in the
Word List field.
*** REMEMBER TO NOT LEAVE SPACES BETWEEN LINES. ***


=====================
VERSION HISTORY
=====================

0.1 : Initial Release.