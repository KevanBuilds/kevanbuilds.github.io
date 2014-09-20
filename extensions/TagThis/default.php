<?php
/*
Extension Name: TagThis
Extension Url: None
Description: Tag Discussions for per User, Discussion and Site Tag Clouds
Version: 1.08
Author: Andrew Miller (Spode)
Author Url: http://www.spodesabode.com
*/

//Permissions
$Context->SetDefinition('PERMISSION_CANTAGTHIS', 'Can tag own discussions.');
$Context->Configuration['PERMISSION_CANTAGTHIS'] = '0';

//Configuration defaults
if( !array_key_exists('TT_PANEL_POSITION', $Configuration)) {AddConfigurationSetting($Context, 'TT_PANEL_POSITION', '199');}
if( !array_key_exists('TT_CLOUD_LIMIT', $Configuration)) {AddConfigurationSetting($Context, 'TT_CLOUD_LIMIT', '150');}
if( !array_key_exists('TT_TITLE_TAG', $Configuration)) {AddConfigurationSetting($Context, 'TT_TITLE_TAG', '1');}
if( !array_key_exists('TT_MIN_FONT', $Configuration)) {AddConfigurationSetting($Context, 'TT_MIN_FONT', '50');}
if( !array_key_exists('TT_MAX_FONT', $Configuration)) {AddConfigurationSetting($Context, 'TT_MAX_FONT', '250');}

//Definitions
$Context->SetDefinition('DiscussionTags', 'Tags (Comma Separated)');
$Context->SetDefinition('TagCloud', 'Tag Cloud');
$Context->SetDefinition('TTSettings', 'TagThis Settings');
$Context->SetDefinition('Site', 'Site');

// Tag Path
$TagPath = dirname(__FILE__);

// Libraries
include($TagPath . '/library/Function.TagThis.php');

//Install TagThis
if 	(!array_key_exists('TAGTHIS', $Configuration))
	{
	//check to see if the tags table exists in the database
	$query = "SHOW TABLES LIKE '".$Configuration['DATABASE_TABLE_PREFIX']."Tags';";
	$result = $Context->Database->Execute($query,'','','An error occured checking for the existence of the BlogThis field.');
	$result = $Context->Database->GetRow($result);

	//Tags table doesn't exist!
	if 	(!$result)
		{
		$query = "CREATE TABLE `".$Configuration['DATABASE_TABLE_PREFIX']."Tags` (TagName VARCHAR(255) NOT NULL, DiscussionID INT NOT NULL);";
                $result = $Context->Database->Execute($query,'','','An error occured adding the Tags table to the database - does your database user have the correct priviliges?.');
		}

	//Add configurations
	AddConfigurationSetting($Context, 'TAGTHIS', '1');
	}

//define table columns
$DatabaseTables['Tags'] = 'Tags';
$DatabaseColumns['Tags']['TagName'] = 'TagName';
$DatabaseColumns['Tags']['DiscussionID'] = 'DiscussionID';

if 	(($Context->Session->User->Permission('PERMISSION_CHANGE_APPLICATION_SETTINGS')) && (ForceIncomingBool('AutomaticTags', '') == 1))
	{
	AutomaticTags();
	}

//If you have the permissions to adjust tags - add the delegates that cope with it.
if 	($Context->Session->User->Permission('PERMISSION_CANTAGTHIS'))
	{
	$Context->AddToDelegate("DiscussionForm", "DiscussionForm_PreCommentRender", "AddTagEntry");
	$Context->AddToDelegate("DiscussionForm", "PostSaveDiscussion", "SaveTags");
	}

//add tag cloud to user account
if 	($Context->SelfUrl == 'account.php')
	{
	$Head->AddStyleSheet('extensions/TagThis/theme/tagthis.css');
	AddUserTagCloud ((ForceIncomingString('u', $Context->Session->UserID)));
	}
//add tag cloud on a per discussion basis
elseif  ($Context->SelfUrl == 'comments.php')
	{
	$Head->AddStyleSheet('extensions/TagThis/theme/tagthis.css');
	AddDiscussionTagCloud ((ForceIncomingString('DiscussionID', '')));
	}
//every other page just display the site wide tag cloud
elseif  ($Context->SelfUrl == 'index.php' || $Context->SelfUrl == 'categories.php' || $Context->SelfUrl == 'extension.php' || $Context->SelfUrl == 'post.php' || $Context->SelfUrl == 'search.php' )
	{
	$Head->AddStyleSheet('extensions/TagThis/theme/tagthis.css');
	AddDiscussionsTagCloud ();
	}

//this is for the searching ability by tag
if 	($Context->SelfUrl == 'search.php' && (ForceIncomingString('Tag', "")))
	{
	$Context->AddToDelegate("DiscussionManager", "PostGetDiscussionBuilder", "SearchByTag");
	$Context->AddToDelegate("SearchForm", "PreSearchResultsRender", "SearchByTagInfo");
	}
?>
