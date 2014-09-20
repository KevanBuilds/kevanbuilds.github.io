<?php
/*
Extension Name: QwikPost
Extension Url: http://lussumo.com/addons
Description: Makes the default text formatter media savvy, by autolinking just the way you like it! You can easily edit or add more media/types using the json based tree view settings. You can also choose to make the magic happen on the sever side, client side or either (as appropriate).  
Version: 1.2.2
Author: \x00
Author Url: http://lussumo.com/addons/
*/

//rendering modes 0='server', 1='client', 2='either' (default)
if (!isset($Configuration['QWIKPOST_MODE']))
	    AddConfigurationSetting($Context,'QWIKPOST_MODE','2');
        

// compatibility with Text-only mode will obey
if(!$Context->Session->User->Preference("HtmlOn")) return;

//get the extensions path and extensions folder
$ext_path_qp = $Configuration["EXTENSIONS_PATH"];
$ext_dir_qp=substr(strrchr(dirname(__FILE__),DIRECTORY_SEPARATOR),1);

//vanilla base
$base_qp = $Configuration["BASE_URL"];
$base_qp = substr($base_qp,-1)=='/'?substr($base_qp,0,-1):$base_qp;

//get extensions folder
$xtf_qp = substr(strrchr(substr($ext_path_qp,0,-1),'/'),1);

//get extensions URL
$xt_qp =$base_qp.'/'.$xtf_qp;


$gotjs_qp = @$_SESSION['gotjs'];
$qp_mode = $Configuration['QWIKPOST_MODE'];

//transfer media to settings
if (!isset($Configuration['QWIKPOST_MEDIA']))
	    AddConfigurationSetting($Context,'QWIKPOST_MEDIA',rawurlencode(@file_get_contents($ext_path_qp.'/'.$ext_dir_qp.'/config/qpmedia.json')));
        
//transfer type to settings
if (!isset($Configuration['QWIKPOST_TYPE']))
	    AddConfigurationSetting($Context,'QWIKPOST_TYPE',rawurlencode(@file_get_contents($ext_path_qp.'/'.$ext_dir_qp.'/config/qptype.json')));

//get media and type
$qp_media = rawurldecode($Configuration['QWIKPOST_MEDIA']);
$qp_type = rawurldecode($Configuration['QWIKPOST_TYPE']);
//QwikText Configuration in settings

if($Context->SelfUrl == 'settings.php' 
    && $Context->Session->User->Permission('PERMISSION_CHANGE_APPLICATION_SETTINGS')) {

    //Class to render Configuration page (not postback control as just a springboard for ajax config)
    class QwikPostConfig extends Control {
        function QwikPostConfig(&$Context) {
	        $this->Name = 'QwikPostConfig';
            $this->Control($Context);
        }
        
        function Render() {
            global $ext_path_qp, $ext_dir_qp, $qp_config;
            
                $this->CallDelegate('PreRender');
                if($qp_config){
                    include($ext_path_qp.'/'.$ext_dir_qp.'/pages/qpfrm.html.php');
                }else{
                    //load error page if config files not loaded
                    include($ext_path_qp.'/'.$ext_dir_qp.'/pages/qperr.html.php');
                }
                $this->CallDelegate('PostRender');
            
        }

    }
    
    //My turn?
    //Note PostBackAction=no_action is required so Vanilla knows not to load default page. 
    if(ForceIncomingString('qwikpost','')== 'config' && ForceIncomingString('PostBackAction','')=='no_action'){
        $qp_config=false;
        if($qp_media && $qp_type){
            $qp_config=true;  
            
            $Head->AddString("<script type=\"text/javascript\">qpExt = '".$xt_qp.'/'.$ext_dir_qp."/';</script>");

            $Head->AddScript($xtf_qp .'/'.$ext_dir_qp.'/script/JSONeditor.js');
            $Head->AddScript($xtf_qp .'/'.$ext_dir_qp.'/script/qwikpost.js');
            
            require_once($ext_path_qp.'/'.$ext_dir_qp.'/script/inline.php');
            //script to init treeview editor
            $Head->AddString($inline_script);
        }
        //Add and render the control
        $QwikPostConfig=$Context->ObjectFactory->CreateControl($Context, 'QwikPostConfig');
        $Page->AddRenderControl($QwikPostConfig, $Configuration["CONTROL_POSITION_BODY_ITEM"]);
    }
    //Menu Item
    $Panel->AddList('Extension Options');
	$Panel->AddListItem('Extension Options', $Context->GetDefinition('QwikPost'), GetUrl($Context->Configuration, 'settings.php', '', '', '', '', 'qwikpost=config&PostBackAction=no_action'));
}

// submissions
if (in_array($Context->SelfUrl, array("comments.php", "post.php"))) {
    $prev=stripos($_SERVER['PHP_SELF'], '/ajax.php')!==false;
    //'client' mode or 'either' mode where client has javascript and is not a preview they can handle it...
    if($qp_mode==1 || ($qp_mode==2 && $gotjs_qp && !$prev)){
        if(!$qp_media || !$qp_type) return;
            
        // Check the Low-Cal Vanilla is installed
        if (!empty($Configuration['LOWCALVANILLA_TOOLS_PATH'])) {
            // Include Low-Cal Vanilla tools.
            // Important: Use require_once or include_once to not load it again if it is already done.
            require_once($Configuration['LOWCALVANILLA_TOOLS_PATH']);
            // Add your script
            LowCalVanilla_AddScript($Context, $Head, $xtf_qp .'/'.$ext_dir_qp.'/script/qpscan.js');

        } else {
            $Head->AddScript($xtf_qp .'/'.$ext_dir_qp.'/script/qpscan.js');
        }
        
        
        //init client side qwikpost scan and parse
        $Head->AddString("<script type=\"text/javascript\"><!--\n qwikpost.load({\"media\":".$qp_media.",\"type\":".$qp_type."},'".$base_qp."','".$xt_qp.'/'.$ext_dir_qp."'); DomReady.ready(function(){qwikpost.scan();})\n--></script>");
    }else{        
        //if 'either' mode send little ping that browser has javascript on
        if($qp_mode==2) $Head->AddString('<script type="text/javascript">var j = new Image();j.src="'.$xt_qp.'/'.$ext_dir_qp.'/gotjs.php";</script>');
        $qp_media = @json_decode($qp_media);
        $qp_type = @json_decode($qp_type,true);
    }
        //string formatter class
       class QwikPostFormatter extends StringFormatter {
           var $peekaboo = '<input type="hidden" name="qwikpost">';
          function Parse ($String, $Object, $FormatPurpose) {
           // if gotjs just add hidden tag
           global $gotjs_qp, $prev, $qp_mode, $qp_media, $qp_type;

            //links exits?
            if ($FormatPurpose == FORMAT_STRING_FOR_DISPLAY){
                if($qp_mode==1 || ($qp_mode==2 && $gotjs_qp && !$prev))
                    return ltrim(str_replace(array(' http://','<br />http://'),array(' '.$this->peekaboo .'http://','<br />'.$this->peekaboo.'http://'), ' '.$String));
              if (stripos($String, 'http://') !== false)
                    $String= $this->QwikPost($String);
            }
            return $String;
          }
          
          
          function insert_matches($x,$y){
            if(gettype($x)!=='string') return $x;
            $a=0;
                while(($a=strpos($x,"$",$a))!==false && is_numeric(substr($x,$a+1,1)) && ($a==0 || substr($x,$a-1,1)!='\\')){
                    if(!($b=$y[substr($x,$a+1,1)])){$a+=2;continue;}
                    $c=substr($x,0,$a).$b;
                    $d=substr($x,$a+2);
                    $a=strlen($c);            
                    $x=$c.$d;
                }
            return $x;
          }
          
         function insert_params($x,$y){
            $a=0;
            while(($a=strpos($x,"#{",$a))!==false && ($b=strpos($x,"}",$a))!==false && ($a==0 || substr($x,$a-1,1)!='\\')){
                if(!($c=$y[substr($x,$a+2,$b-$a-2)])){$a=$b;continue;}
                $d=substr($x,0,$a).$c;
                $e=substr($x,$b+1);
                $a=strlen($d);
                $x=$d.$e;        
            }
            return $x;
        } 
        
          function QwikPost($text) {
           global $ext_path_qp, $ext_dir_qp, $base_qp, $xt_qp, $qp_media, $qp_type;
           // return if json invalid or not read
           if(!$qp_media || !$qp_type) return $text;
            $text = str_replace("\n","<br />", $text);
            $textlines = explode("<br />", $text);
            foreach($textlines As $textline){
                $textwords = explode(" ",$textline);
                foreach($textwords As $textword){
                    if(strpos($textword, 'http://') !== 0){$tl_temp=array();$tw_temp[]= $textword; continue;}//no link 
                        foreach($qp_media As $qp_mediaK => $qp_mediaV){
                            $tl_temp=array();
                            $found=false;
                            $mK = explode('|', $qp_mediaK); // multiple keys delimited by pipe
                            foreach($mK As $kv){
                                if(strpos($textword,$kv)===false) continue;
                                $me = '/'.str_replace('/','\\/',$qp_mediaV->id).'/i';
                                $matches = Array();
                                if(!preg_match($me,$textword,$matches)) continue;
                                $params = Array();
                                foreach($qp_mediaV->params As $mp => $mpv) 
                                    $params[$mp] = $this->insert_matches(str_replace(array('#{vanilla}','#{qwikpost}'),array($base_qp,$xt_qp.'/'.$ext_dir_qp),$mpv),$matches); //replace with special web linkage
                                //temp faster than setting the original value
                                $tw_temp[] = "<!--qp-->\n".$this->insert_params($qp_type[$qp_mediaV->params->type],$params)."\n<!--qp-->";
                                $found=true;
                            }
                            if($found) break;
                        }
                    
                 }
                if (isset($tw_temp)) $tl_temp[]= implode(" ", $tw_temp); 
            }
            if(isset($tl_temp)) $text = implode("<br />", $tl_temp);
            $text = str_replace("\n","<br />", $text);
            return $text;
          }
       }
       
    $QwikPostFormatter = $Context->ObjectFactory->NewObject($Context, "QwikPostFormatter");
    $Context->StringManipulator->Formatters[$Configuration["DEFAULT_FORMAT_TYPE"]]->AddChildFormatter($QwikPostFormatter);
}
?>