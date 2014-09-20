<?php

include("../../appg/settings.php");
include("../../conf/settings.php");
include("../../appg/init_ajax.php");

if( !$CommentID = ForceIncomingInt('CommentID', 0) ) {
	echo 'No comment ID provided';
} else {
	
	$UserID = $Context->Session->UserID;
	
	$cm = $Context->ObjectFactory->NewContextObject($Context, 'CommentManager');
	
	if( !$Comment = $cm->GetCommentById($CommentID, $UserID) ) {
		echo 'Comment is non-existant';
	} else {
		if(
			(
				$Comment->WhisperUserID > 0 &&
				$Comment->AuthUserID != $UserID && 
				$Comment->WhisperUserID != $UserID &&
				!$Context->Session->User->Permission('PERMISSION_VIEW_ALL_WHISPERS')
			) 
			||
			(
				$Comment->DiscussionWhisperUserID > 0 &&
				$Comment->AuthUserID != $UserID && 
				$Comment->DiscussionWhisperUserID != $UserID &&
				!$Context->Session->User->Permission('PERMISSION_VIEW_ALL_WHISPERS')
			) 
		) {
			echo 'Comment fetch denied';
		} else {
			echo $Comment->Body;
		}
	}
	
}

$Context->Unload();

?>