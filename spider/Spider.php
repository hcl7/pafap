<?
class spider
{
	var $minlength=3;
	var $minoc=2;
function getUrl($url)
{
	$handle = fopen($url, "r");
	if($handle)
	{
		$contents = '';
		while (!feof($handle)) {$contents .= fread($handle, 8192);}
		return $contents;
	}
	else return false;
}
//parse tags function (extracting title,description , keywords of the page)
function _parseTags($page) 
{
	//$page=strtolower($page);

    $title = $description = $keywords = '';
    if (preg_match('/<title>(.*)<\/title>/i',$page,$ar)) $title = $ar[1];
    if (preg_match('/<meta name="description" content="(.*)"/i',$page,$ar)) $description = $ar[1];
	else
	{
		$description=$this->ExtractString(strtolower($page),'<meta http-equiv="description" content="','"');
	}
	if (preg_match('/<meta name="keywords" content="(.*)"/i',$page,$ar)) $keywords = $ar[1];
	else
	{
		$keywords=$this->ExtractString(strtolower($page),'<meta http-equiv="keywords" content="','"');
	}
	
    $res = array(
		 'title'=>$title,
		 'description'=>$description,
		 'keywords'=>$keywords,
		 );
    return $res;
} // _parseTags
function getText($text)
{
    $text = preg_replace('/</',' <',$text);
    $text = preg_replace('/>/','> ',$text);
	$text = preg_replace("/(\<script)(.*?)(script>)/si", " ", "$text");
	$text = preg_replace("/(\<a)(.*?)(a>)/si", " ", "$text");
	$text = strip_tags($text);
	$text = str_replace("<!--", "&lt;!--", $text);
	$text = preg_replace("/(\<)(.*?)(--\>)/mi", "".nl2br("\\2")."", $text);
	while($text != strip_tags($text)) {$text = strip_tags($text);}
	$text=ereg_replace('&nbsp;'," ",$text);
	$text = ereg_replace("[^[:alpha:].,]", " ", $text);
	return $text;
}
function getNrWords($text)
{

	$text = ereg_replace("[^[:alpha:]]", " ", $text);
	while(strpos($text,'  ')!==false) $text = ereg_replace("  ", " ", $text);
	$text=$string=strtolower($text);
	$text=explode(" ",$text);
	return count($text);
}
function getValues($url)
{
	$res=array();
	$page=$this->getUrl($url);
	$res['url']=$url;
	$res['html']=$page;
	$res['meta_tags']=$this->_parseTags($page);
	$res['size']=strlen($page);
	$res['text']=$this->getText($page);
	$res['no_words']=$this->getNrWords($res['text']);
	$res['no_distinct_words']=$this->getNrDistinctWords($res['text']);
	$text=$res['text'];
	$handle = fopen("stop_words.txt", "r");
	while (!feof($handle)) 
	{
  		$buffer = fgets($handle, 4096);
		$buffer=" ".trim($buffer)." ";
   		if(strlen(trim($buffer))>0) $text = ereg_replace(strtolower($buffer)," ",strtolower($text));
	}
	fclose($handle);
	//getting 1 word
	$nrWords=$this->getNrWords($text);
	
	$res['keywords']['1']=$this->getCounts($text);
	$res['keywords']['2']=$this->getCounts_2($text);
	$res['keywords']['3']=$this->getCounts_3($text);
	
	return $res;
	
}
function getNrDistinctWords($text)
{
	$text = ereg_replace("[^[:alpha:]]", " ", $text);
	while(strpos($text,'  ')!==false) $text = ereg_replace("  ", " ", $text);
	$text=$string=strtolower($text);
	$text=explode(" ",$text);
	$keywords=array();
	$text=array_unique($text);
	return count($text);
	
}
function getCounts($text)
{

	$text = ereg_replace("[^[:alpha:]]", " ", $text);
	while(strpos($text,'  ')!==false) $text = ereg_replace("  ", " ", $text);
	$text=$string=strtolower($text);
	$text=explode(" ",$text);
	$keywords=array();
	$text=array_unique($text);
	$nr_words=$this->nr_cuvinte($string);
	foreach($text as $t=>$k)
	{
		$nr_finds=$this->nr_gasiri($k,$string);	
		//here we will need to put min of the appearencies and min length
		if($nr_finds>=$this->minoc && strlen($k)>=$this->minlength) $keywords[$k]=$nr_finds;	
	}
	arsort($keywords);
	return $keywords;
}
function getCounts_2($text)
{
	$text = ereg_replace("[^[:alnum:]]", " ", $text);
	while(strpos($text,'  ')!==false) $text = ereg_replace("  ", " ", $text);
	$text=$string=strtolower($text);
	$text=explode(" ",$text);
	$new_text=array();
	$i=0;
	foreach($text as $k=>$t)
	{
		if(strlen(trim($t))>0) $new_text[$i]=trim($t);
		$i++;
	}
	$text=$new_text;
	$keywords=array();
	//making array with 2 words
	while (list($key, $val) = each($text)) 
	{
		$tmp=$val;
		list($key, $val) = each($text);
		$tmp=$tmp." ".$val;
		$nr_finds=$this->nr_gasiri($tmp,$string);
		if($nr_finds>=$this->minoc && strlen($tmp)>=2*$this->minlength) $keywords[$tmp]=$nr_finds;	
	}
	arsort($keywords);
	return $keywords;
}
function getCounts_3($text)
{
	$text = ereg_replace("[^[:alnum:]]", " ", $text);
	while(strpos($text,'  ')!==false) $text = ereg_replace("  ", " ", $text);
	$text=$string=strtolower($text);
	$text=explode(" ",$text);
	$new_text=array();
	$i=0;
	foreach($text as $k=>$t)
	{
		if(strlen(trim($t))>0) $new_text[$i]=trim($t);
		$i++;
	}
	$text=$new_text;
	
	$keywords=array();
	//making array with 3 words
	while (list($key, $val) = each($text)) 
	{
		$tmp=$val;
		list($key, $val) = each($text);
		$tmp=$tmp." ".$val;
		list($key, $val) = each($text);
		$tmp=$tmp." ".$val;
		$nr_finds=$this->nr_gasiri($tmp,$string);
		if($nr_finds>=$this->minoc && strlen($tmp)>=3*$this->minlength) $keywords[$tmp]=$nr_finds;	
	}
	arsort($keywords);
	return $keywords;
}
function nr_cuvinte($str)
{
	$tmp=0;
	$tok = strtok ($str," ");
    while ($tok) {
	$tmp++;
    $tok = strtok (" ");
	}
	return $tmp;
}
function nr_gasiri($key,$string)
{
	$q=0;
	$nr=0;
	$key=strtolower($key);
	$string=strtolower($string);
	while($q==0)
	{

		$pos = strpos($string,$key);
  		if ($pos===false) $q=1;
		else 
		{
			$string = substr ($string,$pos+strlen($key));
			$nr++;
		}
	}
	return $nr;
}
function ExtractString($str, $start, $end)
{
   $str_low = strtolower($str);
   $pos_start = strpos($str_low, $start);
   $pos_end = strpos($str_low, $end, ($pos_start + strlen($start)));
   if ( ($pos_start !== false) && ($pos_end !== false) )
   {
       $pos1 = $pos_start + strlen($start);
       $pos2 = $pos_end - $pos1;
       return substr($str, $pos1, $pos2);
   }
}
}
?>
