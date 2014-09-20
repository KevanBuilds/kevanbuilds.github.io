<?php
include('../../appg/settings.php');
include('../../appg/init_ajax.php');
$_SESSION['gotjs'] = 1;
header( "Content-type: image/gif");
header( "Expires: Wed, 11 Nov 1998 11:11:11 GMT");
header( "Cache-Control: no-cache");
header( "Cache-Control: must-revalidate");
echo base64_decode("R0lGODlhAQABAIAAAAAAAAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==");
?>
