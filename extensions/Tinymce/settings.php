<?php

$Context->SetDefinition('Tinymce', '(X)HTML');

//Secure xhtml tags and attribue. Might need to add some control on the value
$Tinymce_allowed_tags = array(	'a' => array('accesskey' => 1, 'class' => 1, 'href' => array('maxlen' => 100), 'tabindex' => 1, 'title' => 1, 'target'  => 1), 
									'abbr' => array('class' => 1 , 'title' => 1), 
									'acronym' => array('class' => 1 , 'title' => 1), 
									'address' => array('class' => 1, 'title' => 1), 
									'b' => array('class' => 1, 'title' => 1), 
									'big' => array('class' => 1, 'title' => 1), 
									'blockquote' => array('cite' => 1, 'class' => 1, 'title' => 1), 
									'br' => array('class' => 1, 'title' => 1), 
									'cite' => array('class' => 1, 'lang' => 1, 'title' => 1), 
									'code' => array('class' => 1, 'title' => 1), 
									'dd' => array('class' => 1, 'title' => 1), 
									'dfn' => array('class' => 1, 'lang' => 1, 'title' => 1), 
									'div' => array('align' => 1, 'class' => 1 , 'title' => 1), 
									'dl' => array('class' => 1, 'compact' => array('valueless' => 'y'), 'lang' => 1, 'title' => 1), 
									'dt' => array('class' => 1, 'lang' => 1, 'title' => 1), 
									'em' => array('class' => 1, 'title' => 1),
									'embed' => array('id' => 1,'width' => 1, 'height' => 1, 'src' => 1, 'type' => 1, 'wmode' => 1), 
									'fieldset' => array('class' => 1, 'lang' => 1, 'title' => 1), 
									'font' => array('class' => 1, 'color' => 1, 'face' => 1, 'title' => 1, 'size' => 1), 
                                                                        'h1' => array('align' => 1, 'class' => 1, 'title' => 1), 
									'h2' => array('align' => 1, 'class' => 1, 'title' => 1), 
									'h3' => array('align' => 1, 'class' => 1, 'title' => 1), 
									'h4' => array('align' => 1, 'class' => 1, 'title' => 1), 
									'h5' => array('align' => 1, 'class' => 1, 'title' => 1), 
									'h6' => array('align' => 1, 'class' => 1, 'title' => 1), 
									'hr' => array('align' => 1, 'class' => 1, 'title' => 1, 'size' => 1, 'width' => 1), 
									'i' => array('class' => 1, 'title' => 1), 
									'img' => array('align' => 1, 'alt' => 1, 'height' => 1, 'src' => 1, 'title' => 1, 'width'), 
									'legend' => array('accesskey' => 1, 'align' => 1, 'class' => 1, 'lang' => 1, 'title' => 1), 
									'li' => array('class' => 1, 'title' => 1, 'type' => 1), 
									'ol' => array('class' => 1, 'compact' => array('valueless' => 'y'), 'start' => 1, 'title' => 1, 'type' => 1), 
								//	'object' => array('width' => 1, 'height' => 1),
									'p' => array('align' => 1, 'class' => 1, 'title' => 1),
								//	'param' => array('name' => 1, 'value' => 1),
									'pre' => array('class' => 1, 'title' => 1), 
									'q' => array('cite' => 1, 'class' => 1, 'title' => 1), 
									's' => array('class' => 1, 'title' => 1), 
									'small' => array('class' => 1, 'title' => 1), 
									'span' => array('align' => 1, 'class' => 1, 'title' => 1), 
									'strike' => array('class' => 1, 'title' => 1), 
									'strong' => array('class' => 1, 'title' => 1), 
									'sub' => array('class' => 1, 'title' => 1), 
									'sup' => array('class' => 1, 'title' => 1), 
									'u' => array('class' => 1, 'title' => 1), 
									'ul' => array('class' => 1, 'compact' => array('valueless' => 'y'), 'title' => 1, 'type' => 1), 
									'var' => array('class' => 1, 'title' => 1)
									);

$Tinymce_allowed_protocols = array('http',
									'https',
									'ftp',
									'news',
									'feed',
									'mailto'
									);

?>