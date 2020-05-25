<?php
define('REGEX_URL','/youtube.com|youtu.be|watch?.*?v=/i');
class pafap_youtube
{
  private $_id;
  private $_url;

  public function __construct($url)
  {
    $this->_url = $url;
    $this->_id = $this->uTubeId($url);
  }
  public function getYoutubeUrl()
  {
    return $this->_url;
  }
  public function getYoutubeID()
  {
    return $this->_id;
  }
  public function parseYoutubeUrl($url)
  {
    return preg_match(REGEX_URL, $url);
  }
  public function uTubeId($url)
  {
    $url = preg_replace('((http://)?(www.)?(youtube.com|youtu.be)(/v/|/watch\?v=|/)([a-zA-Z0-9_-]*)(.*))',"$5",$url);
    return (preg_match('(([a-zA-Z0-9_-]*){11,18})',$url) ? $url : '');
  }
  public function makeYoutube($url)
  {
    $link = $url;
    $parse = parse_url($url);
    if (isset($parse['scheme']) && isset($parse['host']))
    {
      if ($parse['host'] == 'youtu.be')
      {
        $parse['host'] = 'www.youtube.com';
        $parse['path'] = '/v'. $parse['path'];
        $link = $parse['scheme']. '://'. $parse['host']. $parse['path'];
      }
      elseif ($parse['host'] == 'youtube.com' || $parse['host'] == 'www.youtube.com' && $parse['path'] == '/watch')
      {
        $parse['path'] = '/v/'. $this->getYoutubeID();
        $link = $parse['scheme']. '://'. $parse['host']. $parse['path'];
      }
    }
    return $this->EmbedVideo($link);
  }
  public function EmbedVideo($url, $width = '80%', $height = 'auto')
  {
    return "<object width='{$width}' height='{$height}'><param name='movie' value='{$url}' value='transparent'></param><embed src='{$url}' allowfullscreen='true' type='application/x-shockwave-flash' wmode='transparent' width='{$width}' height='{$height}'></embed></object>";
  }
}

?>
