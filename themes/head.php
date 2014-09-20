<?php
// Note: This file is included from the library/Framework/Framework.Control.Head.php class.
// Note:meta name="viewport" was added to make the website work responsively (for mobile views)

$HeadString = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="'.$this->Context->GetDefinition('XMLLang').'">
	<head>
	
							<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
							<link rel="shortcut icon" href="/vanilla/themes/vanilla/styles/NLE/images/favicon/favicon.ico">
							<link rel="apple-touch-icon" sizes="57x57" href="/vanilla/themes/vanilla/styles/NLE/images/favicon/apple-touch-icon-57x57.png">
							<link rel="apple-touch-icon" sizes="114x114" href="/vanilla/themes/vanilla/styles/NLE/images/favicon/apple-touch-icon-114x114.png">
							<link rel="apple-touch-icon" sizes="72x72" href="/vanilla/themes/vanilla/styles/NLE/images/favicon/apple-touch-icon-72x72.png">
							<link rel="apple-touch-icon" sizes="144x144" href="/vanilla/themes/vanilla/styles/NLE/images/favicon/apple-touch-icon-144x144.png">
							<link rel="apple-touch-icon" sizes="60x60" href="/vanilla/themes/vanilla/styles/NLE/images/favicon/apple-touch-icon-60x60.png">
							<link rel="apple-touch-icon" sizes="120x120" href="/vanilla/themes/vanilla/styles/NLE/images/favicon/apple-touch-icon-120x120.png">
							<link rel="apple-touch-icon" sizes="76x76" href="/vanilla/themes/vanilla/styles/NLE/images/favicon/apple-touch-icon-76x76.png">
							<link rel="apple-touch-icon" sizes="152x152" href="/vanilla/themes/vanilla/styles/NLE/images/favicon/apple-touch-icon-152x152.png">
							<link rel="apple-touch-icon" sizes="180x180" href="/vanilla/themes/vanilla/styles/NLE/images/favicon/apple-touch-icon-180x180.png">
							<meta name="apple-mobile-web-app-title" content="NLE Forums">
							<link rel="icon" type="image/png" href="/vanilla/themes/vanilla/styles/NLE/images/favicon/favicon-192x192.png" sizes="192x192">
							<link rel="icon" type="image/png" href="/vanilla/themes/vanilla/styles/NLE/images/favicon/favicon-160x160.png" sizes="160x160">
							<link rel="icon" type="image/png" href="/vanilla/themes/vanilla/styles/NLE/images/favicon/favicon-96x96.png" sizes="96x96">
							<link rel="icon" type="image/png" href="/vanilla/themes/vanilla/styles/NLE/images/favicon/favicon-16x16.png" sizes="16x16">
							<link rel="icon" type="image/png" href="/vanilla/themes/vanilla/styles/NLE/images/favicon/favicon-32x32.png" sizes="32x32">
							<meta name="msapplication-TileColor" content="#5b92fa">
							<meta name="msapplication-TileImage" content="/vanilla/themes/vanilla/styles/NLE/images/favicon/mstile-144x144.png">
							<meta name="msapplication-config" content="/vanilla/themes/vanilla/styles/NLE/images/favicon/browserconfig.xml">
							<meta name="application-name" content="NLE Forums">
		
		<title>'.$this->Context->Configuration['APPLICATION_TITLE'].' - '.$this->Context->PageTitle.'</title>
		<link rel="shortcut icon" href="'.$this->Context->StyleUrl.'favicon.ico" />';
		

		while (list($Name, $Content) = each($this->Meta)) {
			$HeadString .= '
			<meta name="'.$Name.'" content="'.$Content.'" />';
		}

		if (is_array($this->StyleSheets)) {
			while (list($Key, $StyleSheet) = each($this->StyleSheets)) {
				$HeadString .= '
				<link rel="stylesheet" type="text/css" href="'.$StyleSheet['Sheet'].'"'.($StyleSheet['Media'] == ''?'':' media="'.$StyleSheet['Media'].'"').' />';
			}
		}
		if (is_array($this->Scripts)) {
			$ScriptCount = count($this->Scripts);
			$i = 0;
			for ($i = 0; $i < $ScriptCount; $i++) {
				$HeadString .= '
				<script type="text/javascript" src="'.$this->Scripts[$i].'"></script>';
			}
		}

		if (is_array($this->Strings)) {
			$StringCount = count($this->Strings);
			$i = 0;
			for ($i = 0; $i < $StringCount; $i++) {
				$HeadString .= $this->Strings[$i];
			}
		}
$BodyId = "";
if ($this->BodyId != "") $BodyId = ' id="'.$this->BodyId.'"';
echo $HeadString . '</head>
	<body'.$BodyId.' '.$this->Context->BodyAttributes.'>
	<div id="SiteContainer">';
?>