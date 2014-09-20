<?php

/*
Extension Name: Markdown
Extension Url: http://www.michelf.com/projects/php-markdown/
Description: A text-to-HTML conversion tool for discussion comments. 
Version: 1.1.2
Author: Michel Fortin (PHP Version), John Gruber (Original Markdown)
Author Url: http://www.michelf.com/
*/

include_once('markdown.php');

$Context->Dictionary["Markdown"] = "Markdown";

// Create a simple interface for the markdown plugin
class MarkdownFormatter extends StringFormatter {
	function Parse($String, $Object, $FormatPurpose) {
		if ($FormatPurpose == FORMAT_STRING_FOR_DISPLAY) {
			$String = $this->ProtectString($String);
			return Markdown($String);
		} else {
			return $String;
		}
	}
	function ProtectString ($String) {
		//$String = str_replace("<", "&lt;", $String);
		// $String = str_replace(">", "&gt;", $String);
		$String = explode("\n", $String);
		for ($i = 0; $i < count($String); $i++)
			{
			//print_r ($String[$i]);
			//print preg_match('/^(\s{4,}|\t)/', $String[$i]);
			if (!preg_match('/^( {4}|\t)/', $String[$i]))
				$String[$i] = preg_replace('#<(?!http://)(?!\w+\@\w+(\.\w+)*(\.\w{2,4})+>)#i', '&lt;', $String[$i]);
			}
		$String = implode("\n", $String);
		//print $String;
		return $String;
	}
}

// Instantiate the markdown object and add it to the string manipulation methods
$MarkdownFormatter = $Context->ObjectFactory->NewObject($Context, "MarkdownFormatter");
$Context->StringManipulator->AddManipulator("Markdown", $MarkdownFormatter);



?>
