<?php
/*
Extension Name: Improved Sidepanel
Extension Url: http://lussumo.com/docs/
Description: Improved Sidepanel that is fully integrated with the existing Vanilla sidepanel. Based off of Mark O'Sullivan's Discussion Filters extension.
Version: 1.0
Author: Dan Haacke aka Crazyotaku
Author Url: http://oga.mmorpgnut.com/Vanilla.1.0.1/?Page=Home

Copyright 2003 - 2005 Mark O'Sullivan
This file is part of Vanilla.
Vanilla is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
Vanilla is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with Vanilla; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
The latest source code for Vanilla is available at www.lussumo.com
Contact Mark O'Sullivan at mark [at] lussumo [dot] com
*/

/* Cut & paste these language definitions into your conf/your_language.php file */
$Context->Dictionary['Header1'] = 'Header 1';
$Context->Dictionary['Header2'] = 'Header 2';
$Context->Dictionary['Header3'] = 'Header 3';
$Context->Dictionary['Link1'] = 'Example Link 1';
$Context->Dictionary['Link2'] = 'Example Link 2';
$Context->Dictionary['Link3'] = 'Example Link 3';
$Context->Dictionary['Link4'] = 'Example Link 4';
$Context->Dictionary['Link5'] = 'Example Link 5';
$Context->Dictionary['Link6'] = 'Example Link 6';

if(in_array($Context->SelfUrl, array("index.php", "categories.php", "discussions.php", "comments.php", "post.php", "account.php", "settings.php"))){
   
   $Header1 = $Context->GetDefinition("Header1");
   $Panel->AddList($Header1, 110);
    $Panel->AddListItem($Header1, $Context->GetDefinition("Link1"), GetUrl($Configuration, "Insert_Pagelink_Here.php", "", "", "", "", ""), "", "", 10);
	$Panel->AddListItem($Header1, $Context->GetDefinition("Link2"), GetUrl($Configuration, "Insert_Pagelink_Here.php", "", "", "", "", ""), "", "", 20);
   
   $Header2 = $Context->GetDefinition("Header2");
   $Panel->AddList($Header2, 120);
    $Panel->AddListItem($Header2, $Context->GetDefinition("Link3"), GetUrl($Configuration, "Insert_Pagelink_Here.php", "", "", "", "", ""), "", "", 30);
	$Panel->AddListItem($Header2, $Context->GetDefinition("Link4"), GetUrl($Configuration, "Insert_Pagelink_Here.php", "", "", "", "", ""), "", "", 40);
   
   $Header3 = $Context->GetDefinition("Header3");
   $Panel->AddList($Header3, 130);
    $Panel->AddListItem($Header3, $Context->GetDefinition("Link5"), GetUrl($Configuration, "Insert_Pagelink_Here.php", "", "", "", "", ""), "", "", 50);
	$Panel->AddListItem($Header3, $Context->GetDefinition("Link6"), GetUrl($Configuration, "Insert_Pagelink_Here.php", "", "", "", "", ""), "", "", 60);
}
?>