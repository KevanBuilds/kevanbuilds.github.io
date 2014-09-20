<?php
include('../../appg/settings.php');
include('../../appg/init_ajax.php');
//clean
$qwikpost = str_replace(array('\\','\\\\"','\\\\b','\\\\f','\\\\n','\\\\t','\\\\u'),array('\\\\','\\"','\\b','\\f','\\n','\\t','\\u'),ForceIncomingString('qwikpost', ''));

$mode = intval(ForceIncomingString('mode', ''));
function json_invalid($json){
    if(!json_decode($json)){
        if(function_exists('json_last_error')){
            switch(json_last_error())
            {
                case JSON_ERROR_DEPTH:
                    return ' - Maximum stack depth exceeded';
                break;
                case JSON_ERROR_CTRL_CHAR:
                    return ' - Unexpected control character found';
                break;
                case JSON_ERROR_SYNTAX:
                    return ' - Syntax error, malformed JSON';
                break;
                default:
                    return '- Json error';
            }
        }else{
            return '- Json error';
        }
    }
    
    //more to come if necessary
}

function qp_config($qp,$mode=null){
    $return = Array();
    global $Context;
    //if not admin
    if(!$Context->Session->User->Permission('PERMISSION_CHANGE_APPLICATION_SETTINGS')){
        $return['status'] = 'denied';
        return $return;
    }
    //if do data
    if(!$qp){
        $return['status'] = 'no data';
        return $return;
    }
    
    //if json invalid
    if($err = json_invalid($qp)){
        $return['status'] = 'invalid';
        $return['err'] = $err;
        return $return;
    }
    
    $qp = json_decode($qp,true);
    
    
    // make sure basic link is always last
    if(array_key_exists("http://",$qp["media"])){
        $htv = $qp["media"]["http://"];
        unset($qp["media"]["http://"]);
        $qp["media"]["http://"]=$htv;
    };
    
    //save to settings
    AddConfigurationSetting($Context,'QWIKPOST_MEDIA',rawurlencode(json_encode($qp["media"])));   
    AddConfigurationSetting($Context,'QWIKPOST_TYPE',rawurlencode(json_encode($qp["type"])));
 
    
    if($mode!==null) AddConfigurationSetting($Context,'QWIKPOST_MODE',(string) $mode);
    
    $return['status'] = 'success';
    return $return;
}
// send json response
// no content type due to opera 8 bug
// not as if it is checked, raw fragment
// none of that pointless malformed xml/xhtml
?>
<?php echo json_encode(qp_config($qwikpost,$mode));?>