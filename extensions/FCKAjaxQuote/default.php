<?php
/*
Extension Name: FCKAjaxQuote
Extension Url: http://lussumo.com/community/discussion/4661/fckeditor-ajax-quote/
Description: Based on <a href="http://lussumo.com/community/discussion/3853/ajaxquote/">AjaxQuote</a>, adds quote option to posts that works with FCKEditor by retriving original data from DB on the fly.
Version: 1.0
Author: Jeff Minard
Author Url: http://jrm.cc/
*/

if( in_array($Context->SelfUrl, array("comments.php")) ) {
	
	//customize:
	$Configuration["FCKAjaxQuote_LOGINREQUIRED"] = true;          	//if u are using Add Comments Extension set this to false
	$Context->Dictionary['Quote'] = 'quote';
	//

	if( $Configuration["FCKAjaxQuote_LOGINREQUIRED"]===false || $Context->Session->UserID > 0 ){
	
		$Head->AddScript('extensions/FCKAjaxQuote/fckajaxquote.js');
	
		function CommentGrid_AddFCKAjaxQuoteButton(&$CommentGrid){      
			$Comment = &$CommentGrid->DelegateParameters['Comment'];   
			$CommentList = &$CommentGrid->DelegateParameters["CommentList"];
			$CommentList .= '<a id="FCKAjaxQuote_'.$Comment->CommentID.'" href="#" onclick="fck_ajax_qoute(\''.$Comment->Context->Configuration['WEB_ROOT'].'\','.$Comment->CommentID.',\''.$Comment->AuthUsername.'\'); return false;">'. $CommentGrid->Context->GetDefinition("Quote").'</a>';
		}
		
		$Context->AddToDelegate("CommentGrid", "PostCommentOptionsRender", "CommentGrid_AddFCKAjaxQuoteButton");
		
	}

}

?>