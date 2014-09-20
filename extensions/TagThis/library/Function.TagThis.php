<?php

//Used for adding tags prior to using TagThis
function AutomaticTags()
	{
	global $Context;
	$query = "SELECT DiscussionID,Name FROM `".$Context->Configuration['DATABASE_TABLE_PREFIX']."Discussion`;";
	$resource = $Context->Database->Execute($query,'','','An error occured selecting all discussions.');

	$result = $Context->Database->GetRow($resource);

	while ($result)
		{
		$DiscussionID = $result['DiscussionID'];
		$originaltags = GetDiscussionTags($result['DiscussionID']);
		$tags = GetTitleTags($result['Name']);

		if (is_array($originaltags)) {$tags = array_merge($originaltags, $tags);}

		$tags = array_unique($tags);

		echo "<p>DiscussionID #".$DiscussionID." : ".implode(" ",$tags)."</p>";

		//first delete the old tags
		$query = "DELETE FROM `".$Context->Configuration['DATABASE_TABLE_PREFIX']."Tags` WHERE DiscussionID = '".$DiscussionID."';";
		$result = $Context->Database->Execute($query,'','','An error occured removing tags for this discussions.');

		//now add the new ones
		foreach ($tags as &$tag)
			{
			$tag = trim(strtolower($tag));
			if 	($tag > "")
				{
				$query = "INSERT INTO `".$Context->Configuration['DATABASE_TABLE_PREFIX']."Tags` (`TagName`, `DiscussionID`) VALUES ('".FormatStringForDatabaseInput($tag)."', '".$DiscussionID."');";
				$result = $Context->Database->Execute($query,'','','An error occured adding tags for this discussions.');				
				}
			}

		$result = $Context->Database->GetRow($resource);
		}
	}


//removes common words from discussion titles
function GetTitleTags($title)
	{

	//removes anything that's not alphanumeric
	$title = ereg_replace("[^A-Za-z0-9 ]", "", $title);

	//Found both these lists - one has a lot less than the other, but might be less harsh
//	$commonWords = array('able', 'about', 'after', 'again', 'all', 'also', 'and', 'any', 'are', 'bad', 'been', 'before', 'being', 'between', 'but', 'came', 'can', 'cause', 'change', 'come', 'could', 'did', 'differ', 'different', 'does', 'don', 'down', 'each', 'end', 'even', 'every', 'far', 'few', 'for', 'form', 'found', 'four', 'from', 'get', 'good', 'great', 'had', 'has', 'have', 'her', 'here', 'him', 'his', 'how', 'into', 'its', 'just', 'keep', 'let', 'many', 'may', 'might', 'more', 'most', 'much', 'must', 'near', 'need', 'never', 'new', 'next', 'not', 'now', 'off', 'one', 'only', 'other', 'our', 'out', 'over', 'part', 'put', 'said', 'same', 'say', 'seem', 'set', 'should', 'side', 'some', 'still', 'such', 'take', 'than', 'that', 'the', 'their', 'them', 'then', 'there', 'these', 'they', 'thing', 'this', 'three', 'through', 'too', 'two', 'upon', 'use', 'very', 'was', 'way', 'went', 'were', 'what', 'when', 'where', 'which', 'while', 'who', 'will', 'with', 'would', 'you', 'your', );
	$commonWords = array('a','able','about','above','abroad','according','accordingly','across','actually','adj','after','afterwards','again','against','ago','ahead','aint','all','allow','allows','almost','alone','along','alongside','already','also','although','always','am','amid','amidst','among','amongst','an','and','another','any','anybody','anyhow','anyone','anything','anyway','anyways','anywhere','apart','appear','appreciate','appropriate','are','arent','around','as','as','aside','ask','asking','associated','at','available','away','awfully','b','back','backward','backwards','be','became','because','become','becomes','becoming','been','before','beforehand','begin','behind','being','believe','below','beside','besides','best','better','between','beyond','both','brief','but','by','c','came','can','cannot','cant','cant','caption','cause','causes','certain','certainly','changes','clearly','cmon','co','co.','com','come','comes','concerning','consequently','consider','considering','contain','containing','contains','corresponding','could','couldnt','course','cs','currently','d','dare','darent','definitely','described','despite','did','didnt','different','directly','do','does','doesnt','doing','done','dont','down','downwards','during','e','each','edu','eg','eight','eighty','either','else','elsewhere','end','ending','enough','entirely','especially','et','etc','even','ever','evermore','every','everybody','everyone','everything','everywhere','ex','exactly','example','except','f','fairly','far','farther','few','fewer','fifth','first','five','followed','following','follows','for','forever','former','formerly','forth','forward','found','four','from','further','furthermore','g','get','gets','getting','given','gives','go','goes','going','gone','got','gotten','greetings','h','had','hadnt','half','happens','hardly','has','hasnt','have','havent','having','he','hed','hell','hello','help','hence','her','here','hereafter','hereby','herein','heres','hereupon','hers','herself','hes','hi','him','himself','his','hither','hopefully','how','howbeit','however','hundred','i','id','ie','if','ignored','ill','im','immediate','in','inasmuch','inc','inc.','indeed','indicate','indicated','indicates','inner','inside','insofar','instead','into','inward','is','isnt','it','itd','itll','its','its','itself','ive','j','just','k','keep','keeps','kept','know','known','knows','l','last','lately','later','latter','latterly','least','less','lest','let','lets','like','liked','likely','likewise','little','look','looking','looks','low','lower','ltd','m','made','mainly','make','makes','many','may','maybe','maynt','me','mean','meantime','meanwhile','merely','might','mightnt','mine','minus','miss','more','moreover','most','mostly','mr','mrs','much','must','mustnt','my','myself','n','name','namely','nd','near','nearly','necessary','need','neednt','needs','neither','never','neverf','neverless','nevertheless','new','next','nine','ninety','no','nobody','non','none','nonetheless','noone','no-one','nor','normally','not','nothing','notwithstanding','novel','now','nowhere','o','obviously','of','off','often','oh','ok','okay','old','on','once','one','ones','ones','only','onto','opposite','or','other','others','otherwise','ought','oughtnt','our','ours','ourselves','out','outside','over','overall','own','p','particular','particularly','past','per','perhaps','placed','please','plus','possible','presumably','probably','provided','provides','q','que','quite','qv','r','rather','rd','re','really','reasonably','recent','recently','regarding','regardless','regards','relatively','respectively','right','round','s','said','same','saw','say','saying','says','second','secondly','see','seeing','seem','seemed','seeming','seems','seen','self','selves','sensible','sent','serious','seriously','seven','several','shall','shant','she','shed','shell','shes','should','shouldnt','since','six','so','some','somebody','someday','somehow','someone','something','sometime','sometimes','somewhat','somewhere','soon','sorry','specified','specify','specifying','still','sub','such','sup','sure','t','take','taken','taking','tell','tends','th','than','thank','thanks','thanx','that','thatll','thats','thats','thatve','the','their','theirs','them','themselves','then','thence','there','thereafter','thereby','thered','therefore','therein','therell','therere','theres','theres','thereupon','thereve','these','they','theyd','theyll','theyre','theyve','thing','things','think','third','thirty','this','thorough','thoroughly','those','though','three','through','throughout','thru','thus','till','to','together','too','took','toward','towards','tried','tries','truly','try','trying','ts','twice','two','u','un','under','underneath','undoing','unfortunately','unless','unlike','unlikely','until','unto','up','upon','upwards','us','use','used','useful','uses','using','usually','v','value','various','versus','very','via','viz','vs','w','want','wants','was','wasnt','way','we','wed','welcome','well','well','went','were','were','werent','weve','what','whatever','whatll','whats','whatve','when','whence','whenever','where','whereafter','whereas','whereby','wherein','wheres','whereupon','wherever','whether','which','whichever','while','whilst','whither','who','whod','whoever','whole','wholl','whom','whomever','whos','whose','why','will','willing','wish','with','within','without','wonder','wont','would','wouldnt','x','y','yes','yet','you','youd','youll','your','youre','yours','yourself','yourselves','youve','z','zero');

	$tags = explode(" ", $title);

	//only return tags that aren't common
	foreach ($tags as $tag)
		{
		if (!in_array(strtolower($tag), $commonWords))
			{
			$newtags[] = strtolower($tag);			
			}		
		}

	return $newtags;

	}


//for searching by tag

function SearchByTag(&$DiscussionManager)
	{
	if 	($Tag = ForceIncomingString('Tag', ""))
		{
		$DiscussionManager->DelegateParameters['SqlBuilder']->AddJoin('Tags', 'tag', 'DiscussionID', 't', 'DiscussionID', 'left join', "");
		$DiscussionManager->DelegateParameters['SqlBuilder']->AddWhere('tag', 'TagName', '', FormatStringForDatabaseInput(urldecode($Tag)), '=');
		}
	}

function SearchByTagInfo(&$SearchForm)
	{
	$SearchForm->PageDetails = substr($SearchForm->PageDetails,0, strlen($SearchForm->PageDetails)-16).' tag "'.ForceIncomingString('Tag', "").'"</strong></p>';
	}

//tagging

function SaveTags(&$DiscussionForm)
	{
	global $Context;

	//This means it's a fresh discussion, so we want the title tags
 	if (($DiscussionForm->DelegateParameters['SaveDiscussion']->FirstCommentID == 0) && ($Context->Configuration['TT_TITLE_TAG']))
		{
		$titletags = GetTitleTags($DiscussionForm->DelegateParameters['ResultDiscussion']->Name);
		}

	//only save the tags if saving the discussions was successful
	if ($DiscussionForm->DelegateParameters['ResultDiscussion'])
		{
		//first delete the old tags
		$query = "DELETE FROM `".$Context->Configuration['DATABASE_TABLE_PREFIX']."Tags` WHERE DiscussionID = '".$DiscussionForm->DelegateParameters['ResultDiscussion']->DiscussionID."';";
		$result = $Context->Database->Execute($query,'','','An error occured removing tags for this discussions.');

		//now add the new ones

		$tags = explode(",", (ForceIncomingString('Tags', '')));
		$tags2 = explode(" ", (str_replace(",","",ForceIncomingString('Tags', ''))));

		//have they done it by command or space?
		if (count($tags2) > count($tags)) {$tags = $tags2;}
		
		//add title tags if there are any.
		if (isset($titletags))
			{
			$tags = array_merge ($tags, $titletags);
			}

		$tags = array_unique($tags);

		//no tags entered - hopefully solve a persons issue.
		if 	(!isset($tags))
			{
			return;
			}

		foreach ($tags as &$tag)
			{
			$tag = trim(strtolower($tag));
			if 	($tag > "")
				{
				$query = "INSERT INTO `".$Context->Configuration['DATABASE_TABLE_PREFIX']."Tags` (`TagName`, `DiscussionID`) VALUES ('".FormatStringForDatabaseInput($tag)."', '".$DiscussionForm->DelegateParameters['ResultDiscussion']->DiscussionID."');";
				$result = $Context->Database->Execute($query,'','','An error occured adding tags for this discussions.');				
				}
			}

		}
	}

function GetDiscussionTags($DiscussionID)
	{
	global $Context;
	
	$query = "SELECT TagName FROM `".$Context->Configuration['DATABASE_TABLE_PREFIX']."Tags` as t LEFT JOIN `".$Context->Configuration['DATABASE_TABLE_PREFIX']."Discussion` as d ON t.DiscussionID = d.DiscussionID WHERE t.DiscussionID = '".$DiscussionID."' AND Active = 1;";
	$result = $Context->Database->Execute($query,'','','An error occured getting tags for this discussions.');

	$taglist = "";
	while 	(@$row = $Context->Database->GetRow($result))
		{
		$taglist.= $row['TagName'] . ", ";
		}
	$taglist = substr($taglist, 0, count($taglist)-3);
	return $taglist;
	}

function AddUserTagCloud($UserID)
	{
	global $Context;
	global $Configuration;

	//get discussions this user has started
	$query = "SELECT DiscussionID FROM `".$Context->Configuration['DATABASE_TABLE_PREFIX']."Discussion` WHERE AuthUserID = '".$UserID."';";
	$result = $Context->Database->Execute($query,'','','An error occured getting discussions starts by this user.');

	while 	(@$row = $Context->Database->GetRow($result))
		{
		$Discussions[$row['DiscussionID']] = 1;		
		}
	
	//if BlogThis is in use, select discussions where he has a comment blogged in it to get the tags from that discussion
	if 	(array_key_exists('BLOGTHIS', $Configuration))
		{
		$query = "SELECT DiscussionID FROM `".$Context->Configuration['DATABASE_TABLE_PREFIX']."Comment` WHERE AuthUserID = '".$UserID."' AND BlogThis = 1;";
		$result = $Context->Database->Execute($query,'','','An error occured getting discussions blogged by this user.');

		while 	(@$row = $Context->Database->GetRow($result))
			{
			$Discussions[$row['DiscussionID']] = 1;		
			}
		}

	//if there are no tags, display a site wide tag cloud
	if 	(!isset($Discussions))
		{
		AddDiscussionsTagCloud ();
		return;
		}

	//now go through each discussion and get the tags
	foreach ($Discussions as $DiscussionID => $Value)
		{
		$query = "SELECT TagName FROM `".$Context->Configuration['DATABASE_TABLE_PREFIX']."Tags` as t LEFT JOIN `".$Context->Configuration['DATABASE_TABLE_PREFIX']."Discussion` as d ON t.DiscussionID = d.DiscussionID WHERE t.DiscussionID = '".$DiscussionID."' AND Active = 1;";
		$tagresult = $Context->Database->Execute($query,'','','An error occured getting tags for this discussions.');

		while 	(@$tagrow = $Context->Database->GetRow($tagresult))
			{
			if 	(isset($tags[$tagrow['TagName']]))
				{
				$tags[$tagrow['TagName']]++;
				}
			else
				{
				$tags[$tagrow['TagName']] = 1;
				}
			}
		}

	//if there are no tags, display a site wide tag cloud
	if 	(!isset($tags))
		{
		AddDiscussionsTagCloud ();
		return;
		}

	AddTagPanel($tags, $Context->GetDefinition('User'));
	
	}

function AddDiscussionsTagCloud()
	{
	global $Context;
	global $Configuration;

	$query = "SELECT TagName FROM `".$Context->Configuration['DATABASE_TABLE_PREFIX']."Tags` as t LEFT JOIN `".$Context->Configuration['DATABASE_TABLE_PREFIX']."Discussion` as d ON t.DiscussionID = d.DiscussionID WHERE Active = 1;";
	$tagresult = $Context->Database->Execute($query,'','','An error occured getting all tags for this forum.');

	while 	(@$tagrow = $Context->Database->GetRow($tagresult))
		{
		if 	(isset($tags[$tagrow['TagName']]))
			{
			$tags[$tagrow['TagName']]++;
			}
		else
			{
			$tags[$tagrow['TagName']] = 1;
			}
		}

	if (!isset($tags)) {return;}

	AddTagPanel($tags, $Context->GetDefinition('Site'));
	}

//for a single discussion
function AddDiscussionTagCloud($DiscussionID)
	{
	global $Context;
	global $Configuration;

	$query = "SELECT t.DiscussionID, TagName FROM `".$Context->Configuration['DATABASE_TABLE_PREFIX']."Tags` as t LEFT JOIN `".$Context->Configuration['DATABASE_TABLE_PREFIX']."Discussion` as d ON t.DiscussionID = d.DiscussionID WHERE Active = 1;";
	$tagresult = $Context->Database->Execute($query,'','','An error occured getting all tags for this forum.');

	while 	(@$tagrow = $Context->Database->GetRow($tagresult))
		{
		if 	(isset($tags[$tagrow['TagName']]))
			{
			$tags[$tagrow['TagName']]++;
			}
		else
			{
			$tags[$tagrow['TagName']] = 1;
			}
		//Is this a tag for this discussion?
		if 	($tagrow['DiscussionID'] == $DiscussionID)
			{
			$tags2[$tagrow['TagName']] = 1;
			}
		}

	//if there are no tags, display a site wide tag cloud
	if 	(!isset($tags2))
		{
		AddDiscussionsTagCloud ();
		return;
		}

	//go through the tags from this discussion and add the weight from the overall

	foreach ($tags2 as $key => &$value)
		{
		$value = $tags[$key];
		}

	AddTagPanel($tags2, "Discussion");
	}


function AddTagPanel($tags, $tagtype)
	{
	global $Context;
	global $Panel;

	if 	(isset($tags))
		{
		$tagcloud = GetTagCloud($tags);

		$ListName = $Context->GetDefinition('TagCloud');

		if	($tagtype)
			{
			$ListName = $tagtype." ".$ListName;
			}	

		$Panel->AddString("<h2>".$ListName."</h2><div id=\"TagCloud\">".$tagcloud."</div>", $Context->Configuration['TT_PANEL_POSITION']);
		}
	}

function GetTagCloud($tags)
	{
	global $Configuration;

	//sorts by value to get the highest value
	arsort($tags);
	$maxnumber = each ($tags);
	$maxnumber = $maxnumber['value'];

	if ($Configuration['TT_CLOUD_LIMIT'] > 0)
		{
		$tags = array_slice($tags, 0, $Configuration['TT_CLOUD_LIMIT'], true); 		
		}

	//sort alphabetically
	ksort ($tags);

	$output = "";

	foreach ($tags as $tag => $amount)
		{
		$fontsize = (($Configuration['TT_MAX_FONT'] - $Configuration['TT_MIN_FONT']) * ($amount / $maxnumber)) + $Configuration['TT_MIN_FONT'];
	
		//it looked strange having everything really big if they were the only tags for that topic
		if	($maxnumber == "1")
			{
			$fontsize = "100";
			}

		$output .= '<span style="font-size:'.ceil($fontsize).'%"><a href="'.GetUrl($Configuration, 'search.php', '', '', '', '',  'PostBackAction=Search&Type=Topics&Tag='.urlencode($tag)).'" class="TagLink">'.$tag . "</a></span> ";		
		}

	$output = substr($output,0,strlen($output)-1);
	return $output;
	}

function AddTagEntry(&$DiscussionForm)
	{
	global $Context;

	$tags = GetDiscussionTags($DiscussionForm->DiscussionID);

	echo '<li>
		<label for="txtTags">'.$Context->GetDefinition('DiscussionTags').'</label>
		<input id="txtTags" type="text" name="Tags" class="DiscussionBox" value="'.$tags.'" />
	</li>';

	}
?>
