<?php
include ('../pafap_classes/init.php');
include ('../pafap_classes/mysql_pafap_class.php');
include ('../pafap_classes/chat_pafap_class.php');

session_start();

global $dbh;
$dbh = mysql_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PASS);
mysql_selectdb(MYSQL_NAME,$dbh);

if ($_GET['action'] == "chatheartbeat") { chatHeartbeat(); }
if ($_GET['action'] == "sendchat") { sendChat(); }
if ($_GET['action'] == "closechat") { closeChat(); }
if ($_GET['action'] == "startchatsession") { startChatSession(); }

if (!isset($_SESSION['chatHistory'])) {
	$_SESSION['chatHistory'] = array();
}

if (!isset($_SESSION['openChatBoxes'])) {
	$_SESSION['openChatBoxes'] = array();
}

function chatHeartbeat() {
  $cht = new pafap_chat();
  $sql = "SELECT * FROM pafap_chat WHERE (pafap_chat.toName = '".$cht->getUserName($_SESSION['uid'])."' AND recd = 0) ORDER BY id ASC";
  $query = mysql_query($sql);
  $items = '';
  $chatBoxes = array();
  while ($chat = mysql_fetch_array($query)) {
  	if (!isset($_SESSION['openChatBoxes'][$chat['fromName']]) && isset($_SESSION['chatHistory'][$chat['fromName']])) {
  	$items = $_SESSION['chatHistory'][$chat['fromName']];
  }
  $fromName = $cht->getUserName($chat['fromName']);
  $chat['message'] = filterMS($chat['message']);
  $items .= <<<EOD
  	   {
  		"s": "0",
  		"f": "{$chat['fromName']}",
  		"m": "{$chat['message']}"
	   },
EOD;

  if (!isset($_SESSION['chatHistory'][$chat['fromName']])) {
  	$_SESSION['chatHistory'][$chat['fromName']] = '';
  }

  $_SESSION['chatHistory'][$chat['fromName']] .= <<<EOD
  	   {
  		"s": "0",
  		"f": "{$chat['fromName']}",
  		"m": "{$chat['message']}"
       },
EOD;

	unset($_SESSION['tsChatBoxes'][$chat['fromName']]);
	$_SESSION['openChatBoxes'][$chat['fromName']] = $chat['sent'];
  }

if (!empty($_SESSION['openChatBoxes'])) {
	foreach ($_SESSION['openChatBoxes'] as $chatbox => $time) {
		if (!isset($_SESSION['tsChatBoxes'][$chatbox])) {
			$now = time()-strtotime($time);
			$time = date('g:iA M dS', strtotime($time));

			$message = "Sent at $time";
			if ($now > 60) {
				$items .= <<<EOD
{
"s": "2",
"f": "$chatbox",
"m": "{$message}"
},
EOD;

	if (!isset($_SESSION['chatHistory'][$chatbox])) {
		$_SESSION['chatHistory'][$chatbox] = '';
	}

	$_SESSION['chatHistory'][$chatbox] .= <<<EOD
		{
"s": "2",
"f": "$chatbox",
"m": "{$message}"
},
EOD;
			$_SESSION['tsChatBoxes'][$chatbox] = 1;
		}
		}
	}
}

	$sql = "UPDATE pafap_chat SET recd = 1 WHERE pafap_chat.toName = '".$cht->getUserName($_SESSION['uid'])."' AND recd = 0";
	$query = mysql_query($sql);

	if ($items != '') {
		$items = substr($items, 0, -1);
	}
header('Content-type: application/json');
?>
{
		"items": [
			<?php echo $items; ?>
        ]
}

<?php
  exit(0);
}

function chatBoxSession($chatbox) {
  $items = '';
  if (isset($_SESSION['chatHistory'][$chatbox])) {
  	$items = $_SESSION['chatHistory'][$chatbox];
  }
  return $items;
}

function startChatSession() {
  $items = '';
  if (!empty($_SESSION['openChatBoxes'])) {
  	foreach ($_SESSION['openChatBoxes'] as $chatbox => $void) {
      $items .= chatBoxSession($chatbox);
	}
  }
  if ($items != '') {
  	$items = substr($items, 0, -1);
  }
  $cht = new pafap_chat();

header('Content-type: application/json');
?>
{
		"username": "<?php echo "Me";?>",
		"items": [
			<?php echo $items;?>
        ]
}

<?php
  exit(0);
}

function sendChat() {
  $cht = new pafap_chat();
  $from = $cht->getUserName($_SESSION['uid']);
  $to = $_POST['to'];
  $message = $_POST['message'];
  $_SESSION['openChatBoxes'][$_POST['to']] = date('Y-m-d H:i:s', time());
  $messagesan = filterMS($message);
  if (!isset($_SESSION['chatHistory'][$_POST['to']])) {
    $_SESSION['chatHistory'][$_POST['to']] = '';
  }
  $_SESSION['chatHistory'][$_POST['to']] .= <<<EOD
  	   {
  		"s": "1",
  		"f": "{$to}",
  		"m": "{$messagesan}"
	   },
EOD;
  unset($_SESSION['tsChatBoxes'][$_POST['to']]);
  $sql = "INSERT INTO pafap_chat (pafap_chat.fromName,pafap_chat.toName,message,sent) VALUES ('".sd($from)."', '".sd($to)."', '".sd($message)."', NOW())";
  $query = mysql_query($sql);
  echo "1";
  exit(0);
}

function closeChat() {
  unset($_SESSION['openChatBoxes'][$_POST['chatbox']]);
  echo "1";
  exit(0);
}

function filterMS($text) {
	$text = htmlspecialchars($text, ENT_QUOTES);
	$text = str_replace("\n\r","\n",$text);
	$text = str_replace("\r\n","\n",$text);
	$text = str_replace("\n","<br>",$text);
	return $text;
}
function sd($data)
{
  return mysql_real_escape_string($data);
}
?>