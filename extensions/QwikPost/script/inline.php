<?php
$inline_script=<<<EOT
<script type="text/javascript">
<!--
DomReady.ready(function(){
    JSONeditor.start("tree","jform",{"media":$qp_media,"type":$qp_type},false, qpExt, $qp_mode)
    Opera=(navigator.userAgent.toLowerCase().indexOf("opera")!=-1)
    Safari=(navigator.userAgent.toLowerCase().indexOf("safari")!=-1)
    Explorer=(document.all && (!(Opera || Safari)))
    Explorer7=(Explorer && (navigator.userAgent.indexOf("MSIE 7.0")>=0))
        
    if(Explorer7 && location.href.indexOf("file:")!=0){prompt("This is just to get input boxes started in IE7 - who deems them unsecure.","I like input boxes...")}
});
-->
</script>
EOT;
?>