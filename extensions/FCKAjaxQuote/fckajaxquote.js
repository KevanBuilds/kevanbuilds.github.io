// customize
var fck_ajax_qoute_format = 'Html';  // 'Html' or 'BBCode' 
var fck_ajax_qoute_errormessage = "I'm sorry, I can't quote that for you, Dave.";
//

var g_com_author, q_qoute, g_aq;

function fck_ajax_qoute(baseurl, com_id, com_author)
{
	
	var oEditor = FCKeditorAPI.GetInstance('Body') ;
	
	if(!oEditor) return true;
	
	g_com_author=com_author;
	var dm = new DataManager();
	
	if((g_aq=document.getElementById('FCKAjaxQuote_' + com_id))){
		g_aq.className = 'HideProgress';	
		q_qoute = g_aq.innerHTML;
		g_aq.innerHTML = '&nbsp;';
	}
	
	dm.RequestCompleteEvent = _fck_ajax_qoute;
	dm.RequestFailedEvent = _fck_ajax_qoute_failure;
	dm.LoadData(baseurl + 'extensions/FCKAjaxQuote/ajax.php?CommentID=' + com_id);

	return false;
}

function _fck_ajax_qoute(request)
{
	var oEditor = FCKeditorAPI.GetInstance('Body') ;
	
	if(g_aq){ 
		g_aq.className = '';	
		g_aq.innerHTML = q_qoute;
	}
	if(!request.responseText || request.responseText=='ERROR'){ _fck_ajax_qoute_failure(' - in'); return false;}
	
	oEditor.InsertHtml('<blockquote><cite> '+g_com_author+':</cite>'+ request.responseText+'</blockquote>');
	
	return false;
}

function _fck_ajax_qoute_failure(e){
	alert(fck_ajax_qoute_errormessage+e);
	return false;
}
