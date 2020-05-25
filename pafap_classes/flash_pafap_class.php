<?php
define('REGEX_URL','/.(swf|fla)$/i');
class pafap_flash
{
  private $_url;

  public function __construct($url)
  {
    $this->_url = $url;
  }
  public function getFlashUrl()
  {
    return $this->_url;
  }
  public function parseFlashUrl($url)
  {
    return preg_match(REGEX_URL, $url);
  }

  public function isValidSwf($fl)
  {
    return preg_match('REGEX_URL', $fl);
  }

  public function makeFlash($url)
  {
    $link = $url;
    return $this->EmbedFlash($link);
  }

  public function EmbedFlash($url, $width = '300', $height = '200')
  {
    return "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='{$width}' height='{$height}'>
                <param name='movie' value='{$url}' />
                <param name='allowfullscreen' value='true' />
                <param name='scale' value='noScale' />
                <param name='salign' value='lt' />
                <param name='allowscriptaccess' value='always' />
                <param name='flashvars' value='path=deuter' />
                <embed width='{$width}' height='{$height}' src='{$url}' flashvars='path=deuter' allowfullscreen='true' allowscriptaccess='always' scale='noScale' salign='lt'></embed>
            </object>";
  }
}

?>
