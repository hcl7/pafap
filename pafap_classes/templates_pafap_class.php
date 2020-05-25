<script type="text/javascript" src="../pafap/scripts/template_function.js"></script>
<?php
include ('youtube_pafap_class.php');
class pafap_templates
{

  public function show_cpr($site)
  {
  	print "Copyright &#169 ".date("Y")." $site ";
  }

  public function show_message($message, $class)
  {
    if ($message != '')
    {
      echo "<br>";
      echo "<div class='{$class}'>";
      foreach($message as $key=>$value)
      echo $value."<br>
      </div>";
    }
  }

  public function _show($class, $data)
  {
    echo "<div class='{$class}'>{$data}</div>";
  }
  public function _showWithId($id, $data)
  {
    echo "<div id='{$id}'>{$data}</div>";
  }

  public function showUserProfile($userimage, $defaultimage, $hw)
  {
    echo ($userimage != '')? "<img itemprop='image' src='{$userimage}' width='{$hw}' alt='' />" : "<img src='{$defaultimage}' width='{$hw}' alt='' />";
  }

  public function showWall($wid, $img, $wall, $wallclass, $imgclass)
  {
    echo "<li><div class='recordIdeasPin'></div><div class='{$imgclass}'>{$img}</div><div id='wall_delete'><a href='javascript:void();' rel='{$wid}' title='delete' class='dwall'></a></div>
          <div class='{$wallclass}'>{$this->checkstr($wall)}</div></li>";
  }

  public function showRecWall($wid, $img, $wall, $wallclass, $imgclass)
  {
    echo "<li><div class='recordIdeasPin'></div><div class='{$imgclass}'>{$img}</div><div id='wall_delete'><a href='javascript:void();' rel='{$wid}' title='delete' class='drwall'></a></div>
          <div class='{$wallclass}'>{$this->checkstr($wall)}</div></li>";
  }

  public function showComments($img, $comment, $commentclass, $imgclass)
  {
    echo "<div id='comment_box'><div class='{$imgclass}'>$img</div>
          <div class='{$commentclass}'>{$this->checkstr($comment)}</div></div>";
  }

  public function showUserImage($userimage, $defaultimage, $hw)
  {
     return ($userimage != '')? "<img itemprop='image' src='../pafap/{$userimage}' height='{$hw}' width='{$hw}' alt='' />" : "<img src='{$defaultimage}' height='{$hw}' width='{$hw}' alt='' />";
  }

  public function showRecProfile($userimage, $defaultimage, $height, $width)
  {
     echo ($userimage != '')? "<div style='width='100%'; border: 1px solid #F7F7F7;'><img itemprop='image' src='../{$userimage}' height='{$height}' width='{$width}' alt='' />" : "<img src='{$defaultimage}' height='{$height}' width='{$width}' alt='' /></div>";
  }

  public function showLeftMenu($row, $value)
  {
     echo "<li class='selected' value='{$this->sd($value)}'><a href='?cid={$this->sd($value)}'>".$row."</a></li>";
  }

  public function sd($data)
  {
    return mysql_real_escape_string($data);
  }

  public function commentInput($userimage, $defaultimage, $hw, $rel, $cid, $agree)
  {
    echo "<form id='frmcomment'>
            <div class='input_box'>
                <div id='status_{$rel}' style='width:97%;overflow:hidden;'></div>
                <p id='commentlink'>
                    <a class='agree' rel='{$rel}' href='javascript:void();'>Agree</a>&nbsp;
                    <a class='comment' id='comment' rel='{$rel}' href='javascript:void();'>Comment</a>
                    <span>$agree <i style='color:grey;'><img itemprop='image' src='../pafap/images/agree.PNG' width='21' height='21' /> for this subject</i></span>
                </p>
                <div id='textcomment'>
                    <img itemprop='image' src='../pafap/{$userimage}' height='{$hw}' width='{$hw}' alt='' />
                    <textarea class='commenttextarea' id='{$rel}' rel='{$rel}'></textarea>
                    <a href='javascript:void();' class='post button green' name='pcomment' rel='{$rel}'><span class='label'>Post Comment</span></a>
                </div>
                <input type='hidden' name='postcomment' id='postcomment' value='' />
                <input type='hidden' name='cwid' id='cwid' value='' />
            </div>
          </form>";

  }

  public function commentRecordInput($userimage, $defaultimage, $hw, $rel, $cid, $agree)
  {
    echo "<form id='frmrecordcomment'>
            <div class='input_box'>
                <div id='status_{$rel}' style='width:97%;overflow:hidden;'></div>
                <p id='commentlink'>
                    <a class='ragree' rel='{$rel}' href='javascript:void();'>Agree</a>&nbsp;
                    <a class='comment' id='comment' rel='{$rel}' href='javascript:void();'>Comment</a>
                    <span>$agree <i style='color:grey;'><img itemprop='image' src='../images/agree.PNG' width='21' height='21' /> for this subject</i></span>
                </p>
                <div id='textcomment'>
                    <img itemprop='image' src='../{$userimage}' height='{$hw}' width='{$hw}' alt='' />
                    <textarea class='commenttextarea' id='{$rel}' rel='{$rel}'></textarea>
                    <a href='javascript:void();' class='postrecord button green' name='pcomment' rel='{$rel}'><span class='label'>Post Comment</span></a>
                </div>
                <input type='hidden' name='postrecordcomment' id='postrecordcomment' value='' />
                <input type='hidden' name='crwid' id='crwid' value='' />
            </div>
          </form>";

  }

  public function showUserAlbum($dir, $files)
  {
    $hst = $_SERVER["SERVER_NAME"];
    echo "<div id='vlightbox'>";
    foreach ($files as $key=>$file)
    {
      if (!is_null($file))
      {
      echo "<a title='{$file[1]}' id='vlight_{$file[0]}' href='$dir$file[1]' class='vlightbox' rel='{$file[0]}'><img itemprop='image' alt='{$file[1]}' src='$dir$file[1]' /></a>
            <ul id='nav'>
   	          <li id='ddl_{$file[0]}'><a href='javascript:void();'><div id='pafap_down'></div></a>
                <ul class='sub'>
                    <li><a title='profile' class='img_prof' rel='{$file[1]}' href='javascript:void();'><div id='pafap_prf'></div></a></li>
                    <li><a title='asWall' class='img_wall' rel='http://$hst/users/ImagesPool/{$file[1]}' href='javascript:void();'><div id='pafap_wll'></div></a></li>
                    <li><a title='delete' class='delete' rel='{$file[0]}' href='javascript:void();'><div id='pafap_del'></div></a></li>
                </ul>
   	          </li>
            </ul>";
      }
    }
    echo "<input type='hidden' name='imgselected' id='imgselected' value='' />";
    echo "</div>";
  }

  public function showbinder($data)
  {
    foreach($data as $key=>$value)
    {
      echo "<option rel='".$key."' value='".$value."'>".$value."</option><br>";
    }
  }

  public function parseURL($url)
  {
    $pattern = '/watch?.*?v=/i';
    return preg_match($pattern, $url);
  }

  public function EmbedVideo($url, $width = '80%', $height = 'auto')
  {
    return "<object width='{$width}' height='{$height}'><param name='movie' value='{$url}' value='transparent'></param><embed src='{$url}' allowfullscreen='true' type='application/x-shockwave-flash' wmode='transparent' width='{$width}' height='{$height}'></embed></object>";
  }

  public function isValidURL($url)
  {
    return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
  }

  public function isValidImg($img)
  {
    return preg_match('/.(jpg|gif|png)$/i', $img);
  }

  public function checkstr($str)
  {
    $tmpArray = explode(' ', $str);
    $arr = array();
    foreach($tmpArray as $word)
    {
      $word = trim($word);
      if(!$this->isValidURL($word)){
        $arr[] = $word;
      }
      elseif($this->isValidImg($word)){
        $arr[] = "<img itemprop='image' src='{$word}' width='100%' />";
      }
      elseif ($this->isValidURL($word)){
        $arr[] = "<a href='{$word}'>$word</a>";
      }
      $y = new pafap_youtube($word);
      if ($this->isValidURL($word) && $y->parseYoutubeUrl($word)){
        $arr[] = "<a href='http://www.clipconverter.cc/' title='Download this youtube video'><img src='../images/download.png' alt='download' /></a><br />". $y->makeYoutube($word);
      }
    }
    return implode(' ', $arr);
  }

  public function simBinder($uid, $img, $name, $role)
  {
    if ($uid != '')
    {
      echo "<li style='list-style-type:none;'>";
            if ($role == 'public'){
              echo "<div class='simbox'>
              <div class='sim_img'><a href='#' class='simInfo' rel='$uid'><img itemprop='image' src='{$img}' width='48px' height='48px' alt='' /></a></div>
              <div class='sim_name'><span itemprop='name'>$name</span></div>
              <div id='simbtn'><a href='javascript:void();' class='addFollow button' rel='$uid'><span class='icon icon9'></span><span class='label'>Follow</span></a></div>
            </div>";
            }
            else {
              echo "<div class='simbox'>
              <div class='sim_img'><a href='#' class='simInfo' rel='$uid'><img itemprop='image' src='{$img}' width='48px' height='48px' alt='' /></a></div>
              <div class='sim_name'>$name</div>
              <div id='simbtn'><a href='javascript:void();' class='addFriend button' rel='$uid'><span class='icon icon3'></span><span class='label'>As Friend</span></a></div>
              </div>";
            }
            echo "</li>";
    }
  }

  public function inviBinder($uid, $img, $name)
  {
    echo "<li style='list-style-type:none;'>
            <div class='simbox' id='inv_{$uid}'>
                <div class='sim_img'><img itemprop='image' src='../{$img}' width='48px' height='48px' alt='' /></div>
                <div class='sim_name'>$name</div>
                <div id='invi_buttons'>
                  <div style='font-size:10px; float: right'><a href='javascript:void();' class='friendCancel button right' rel='$uid'><span class='label red'>Cancel</span></a></div>
                  <div style='font-size:10px; float: right'><a href='javascript:void();' class='friendConfirm button left' rel='$uid'><span class='label green'>Confirm</a></div>
                </div>
            </div>
          </li>";
  }

  public function friendsBinder($uid, $img, $name)
  {
    echo "<li style='list-style-type:none;'>
            <div class='frbox' id='frnds_{$uid}'>
                <div class='fr_img'><a href='javascript:void();' class='info_fr' rel='{$uid}'><img itemprop='image' src='../{$img}' width='48px' height='48px' alt='' /></a></div>
                <div class='fr_name'><span itemprop='name'>$name</span></div>
                <div id='friends_delete'><a href='javascript:void();' rel='{$uid}' title='delete' class='dfrnds button'><span class='icon icon58'></span></a></div>
            </div>
          </li>";
  }

  public function imgCommentsBinder($iid, $name, $img, $notes)
  {
    echo "<div class='imgcommbox'>
            <div class='usr_img'><img itemprop='image' src='../{$img}' width='48px' height='48px' alt='' /></div><strong style='color:#35619d;'>$name</strong>
            <div class='img_notes'>{$this->checkstr($notes)}</div>
          </div>";
  }

  public function bindingByClass($id, $img, $notes, $class, $input='')
  {
    echo "<li class='{$class['box']}'>
            <div class='{$class['img']}'><a href='javascript:void();' class='info_search' rel='{$id}'><img itemprop='image' src='../{$img}' width='48px' height='48px' alt='' /></a></div>
            <div class='{$class['notes']}' style='font-family: sans-serif;'>{$this->checkstr($notes)}</div>
            <div style='float: right;'>";
            if ($input == 'public'){
              echo "<a href='javascript:void();' class='searchFollow button' rel='{$id}'><span class='icon icon9'></span><span class='label'>Follow</span></a></div>";
            }
            else echo "<a href='javascript:void();' class='searchAddFriend button' rel='{$id}'><span class='icon icon3'></span><span class='label'>As Friend</span></a></div>";
          "</li>";
  }

  public function msBinder($mid, $from, $name, $notes, $img, $date)
  {
    echo "<div id='msdelID_{$mid}' class='ms_box'>
            <p id='msHideShow'>
               <a href='javascript:void();' id='msHS'><img itemprop='image' src='../{$img}' height='48px' width='48px' alt='' /></a><br />
               <div style='color: #35619d;'>$name $date</div>
            </p>
            <div id='textMessage'>
              <div id='messageText'>$notes
                <div id='msDelete'><a href='javascript:void();' title='Delete' rel='{$mid}' class='msdel'></a></div>
                <div id='msReplay'><a href='javascript:void();' title='Replay' id='msrpl' class='msrep'></a></div>
                <div id='textReplay'><textarea class='msTextAreaReplay' id='msrepl_{$from}'></textarea>
                   <div style='float: left;'><a href='javascript:void();' rel='{$from}' class='msPostReplay button green'><span class='label'>Replay Message</span></a></div>
                </div>
              </div>
            </div>
            <div id='replaystatus_{$from}'></div>
          </div>";
  }

  public function msComposeBox()
  {
    echo "<div class='Compose_box'>
            <p id='sendHideShow' style='height: 36px;'>
               <a href='javascript:void();' id='newMS' class='textlink button'><span class='icon icon68'></span><span class='label'>New Message</span></a>
            </p>
            <div id='textCompose'>
              <div id='msTextAreaBox'>
                To:<br /><input type='text' name='txtto' id='txtto' class='pafap_search' /><br />
                Message:<textarea name='msTextArea' id='msTextArea' class='msTextAreaCompose'></textarea><br />
                <div><a href='javascript:void();' class='msPost button green'><span class='label'>Send Message</span></a></div>
              </div>
            </div>
          </div>";
  }

  public function bind2SelectFriends($uid, $img, $name)
  {
    echo "<li style='width: 47%;'>
            <div class='fr_img'><a href='javascript:void();' class='frSelected' frn='{$name}' fid='{$uid}'><img itemprop='image' src='../{$img}' width='48px' height='48px' alt='' /></a></div>
            <span class='pafapitem_text'>$name</span>
            <input type='hidden' name='frlID' id='frlID' value='' />
          </li>";
  }

  public function bindChatFriends($uid, $img, $name)
  {
    echo "<li><div><a href='javascript:chatWith(\"$name\");' rel='{$uid}'><img src='../{$img}' width='26px' height='26px' alt='' />&nbsp;$name</a></div></li>";
  }

  public function showAgree($img, $name, $notes, $agreeclass, $imgclass)
  {
    echo "<div id='comment_box'><div class='{$imgclass}'>$img</div>
          <div class='{$agreeclass}'><b style='color:#35619d;'>$name </b>{$notes}</div></div>";
  }

  public function catbinder($pid, $cid, $ctname)
  {
     echo "<div id='cat_{$ctname}'>
               <div class='cat_name'>$ctname</div>
               <div id='delete_categories'><a href='javascript:void();' rel='$pid' id='$cid' catg='$ctname' title='Delete category' class='catdelete'></a></div>
           </div>";
  }

  public function mailAdmin($iid, $fn, $ln, $mail)
  {
     echo "<div id='madmn_{$iid}'>
               <div>$fn</div>
               <div>$ln</div>
               <div id='emailink'><a href='javascript:void();' rel='$iid' mail='$mail' title='Send Email' class='mailadmn'>$mail</a></div>
           </div>";
  }
  
}

?>
