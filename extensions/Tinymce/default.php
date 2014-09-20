<?php
/*
Extension Name: Tinymce
Extension Url: http://tinymce.moxiecode.com/download.php
Description: Add a WYSIWYG editor to the comment form
Version: 1.4.1
Author: MySchizoBuddy (Vanilla extension) and Dinoboff;
Author Url: myschizobuddy at gmail.com

*/

define('TINYMCE_PATH', dirname(__FILE__) . '/');
require(TINYMCE_PATH . 'settings.php');

if (!function_exists('kses')) require(TINYMCE_PATH . 'kses.php');
$EnableGzip = 0;
//Check if Gzip compressor is installed
if (file_exists('js/tinymce/jscripts/tiny_mce/tiny_mce_gzip.js')) $EnableGzip = 1;

// Check to see if user is allowed to comment
$Configuration["TINYMCE_LOGINREQUIRED"] = false;          	//if u are using Add Comments Extension set this to false
if( $Configuration["TINYMCE_LOGINREQUIRED"]===false or $Context->Session->UserID > 0 ){

	//If user is allowed to comment then add TinyMCE javasript
	if ( in_array($Context->SelfUrl, array("post.php", "comments.php")) ) {
		if ($EnableGzip) {
                    $Head->AddScript('js/tinymce/jscripts/tiny_mce/tiny_mce_gzip.js');
                    $Head->AddString('<script type="text/javascript">
                                    tinyMCE_GZ.init({
                                    plugins : "preview,contextmenu,emotions,xhtmlxtras,paste,autosave,contextmenu,advlink",
                                    themes : "advanced",
                                    languages : "en",
                                    disk_cache : true,
                                    debug : false
                                    });
                                    </script>');    
                }
                else
                    $Head->AddScript('js/tinymce/jscripts/tiny_mce/tiny_mce.js');
                    
		$Head->AddString('<script language="javascript" type="text/javascript">
				tinyMCE.init({
				mode : "exact",
				elements : "CommentBox,abshosturls",
				theme : "advanced",
                languages : "en",
				plugins : "preview,contextmenu,emotions,xhtmlxtras,paste,autosave,contextmenu,advlink",
                theme_advanced_buttons1_add_before : "newdocument,separator",
				theme_advanced_buttons1 : "code,preview,separator,undo,redo,separator,bold,italic,underline,strikethrough,separator,removeformat,cleanup,seperator,cut,copy,paste,pasteword,separator,bullist,numlist,separator,link,unlink,separator,image,emotions",
				theme_advanced_buttons2_add_before: "",
                theme_advanced_buttons2 : "sub,sup,separator,charmap,cite,acronym,separator,forecolor,formatselect,fontsizeselect,fontselect",
                theme_advanced_buttons3 :"",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_path_location : "bottom",
				relative_urls : false,
				remove_script_host : false,
				valid_elements : ""
				+"a[accesskey|class|href|tabindex|title|target],"
				+"abbr[class|title],"
				+"acronym[class|title],"
				+"address[class|title],"
				+"big[class|title],"
				+"blockquote[cite|class|title],"
				+"br[class|title],"
				+"button[accesskey|class|name|tabindex|title|type|value],"
				+"cite[class|lang|title],"
				+"code[class|title],"
				+"dd[class|title],"
				+"dfn[class|lang|title],"
				+"div[align<center?left?right|class],"
				+"dl[class|compact<compact|lang|title],"
				+"dt[class|lang|title],"
				+"em/i[class|title],"
				+"fieldset[class|lang|title],"
				+"font[class|color|dir<ltr?rtl|face|size|title],"
				+"h1[align<center?left?right|class|title],"
				+"h2[align<center?left?right|class|title],"
				+"h3[align<center?left?right|class|title],"
				+"h4[align<center?left?right|class|title],"
				+"h5[align<center?left?right|class|title],"
				+"h6[align<center?left?right|class|title],"
				+"hr[align<center?left?right|class|noshade|size|title|width],"
				+"img[align<bottom?left?middle?right?top|alt|height|src|title|width],"
				+"legend[accesskey|align<center?left?right|class|lang|title],"
				+"li[class|title|type],"
				+"ol[class|compact<compact|start|title|type],"
				+"p[align<center?left?right|class|title],"
				+"pre/listing/plaintext/xmp[class|title|width],"
				+"q[cite|class|title],"
				+"s[class|title],"
				+"small[class|title],"
				+"span[align<center?left?right|class|title],"
				+"strike[class|title],"
				+"strong/b[class|title],"
				+"sub[class|title],"
				+"sup[class|title],"
				+"u[class|title],"
				+"ul[class|compact<compact|title|type],"
				+"var[class|title]",
				theme_advanced_blockformats : "p,h2,h3,h4,code,blockquote,cite", 
				extended_valid_elements : "a[name|href|target|title],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
				theme_advanced_resizing : true,
				theme_advanced_resize_horizontal : false,
                apply_source_formatting : true,
                entity_encoding : "raw",
				inline_styles : false,
                height : "480",
                browsers : "msie,gecko,opera",
                gecko_spellcheck : true,
				content_css : "'. $Context->Configuration['WEB_ROOT'].'extensions/Tinymce/preview.css' .'",
				plugin_preview_width : "600",
				plugin_preview_height : "400",
				plugin_preview_pageurl:"'. $Context->Configuration['WEB_ROOT'].'extensions/Tinymce/preview.html' .'"
				});
		</script>');
		$Head->AddString('
			<script type="text/javascript">
				window.onload = function() {
					document.getElementById("CommentBoxController").style.display = "none";
				}
			</script>');
	}
}

//add Kses formater

class TinymceFormatter extends StringFormatter {
	var $allowed_tags;
	var $allowed_protocols;

	function TinymceFormatter($tags, $protocols) {
		$this->allowed_tags = $tags;
		$this->allowed_protocols = $protocols;
	}

	function Parse($String, $Object, $FormatPurpose) {
		if ($FormatPurpose == FORMAT_STRING_FOR_DISPLAY) {
			return kses($String, $this->allowed_tags, $this->allowed_protocols);
		}
		return $String;
	}
}

if ( $Context->Session->UserID > 0 && $Context->Session->User->Permission('PERMISSION_HTML_ALLOWED') ) {
	//Make Tinymce formatter the only formatter available to post a new comment or to edit an old one
	$Context->Configuration['DEFAULT_FORMAT_TYPE'] = 'Tinymce';
	$Context->Session->User->DefaultFormatType = 'Tinymce';
	$Context->Session->User->Preferences['ShowFormatSelector'] = 0;
}
$TinymceFormatter = $Context->ObjectFactory->NewObject($Context, "TinymceFormatter", $Tinymce_allowed_tags, $Tinymce_allowed_protocols);
$Context->StringManipulator->AddManipulator("Tinymce", $TinymceFormatter);
?>