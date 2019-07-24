<?php
function string_sanitize($s) {
    $result = preg_replace("/['\"\"'#]+/", "", $s); //remove useless punctuations
    $result = preg_replace("/http[s]*:\/\/t.co\/[a-z0-9A-Z]*/", "", $result); //remove t.co links to images and wensites
    $result = preg_replace("/@[a-z0-9A-Z]*/", "", $result); //remove mentions
    $result = preg_replace("/[ ]{2,}/", "", $result); //remove extra spaces
    $result = preg_replace("/[\r\n]{2,}/", "", $result); //remove extra line breaks
    return $result;
}
require_once 'twitteroauth/autoload.php'; 
use Abraham\TwitterOAuth\TwitterOAuth;

define('CONSUMER_KEY', 'CIIXyY3gpNhRw7OJE1CpKgMvq');
define('CONSUMER_SECRET', 'xFUZkICzoaNBicJgGvxyXZCk9CRMJRwNNlKYbAtVXoX50CHpac');

$toa = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

$q=$_POST['queryt'];
$type=$_POST['typ'];


$sql= new mysqli("localhost","DBUSER","PASSWORD","DATABASE");
if($sql->connect_error)
    die("Coudn't connect");
$del="delete from twitter;";
if(!($sql->query($del)))
  echo $sql->error;

if($type==="hashtag"){
  $query = array(
    "q" => "#$q -filter:retweets",
    "count" => "100",
    "result_type" => "recent",
    "lang" => "en",
  

   );
 
   $results = $toa->get('search/tweets', $query);

   foreach ($results->statuses as  $key=>$result) {
    $tweet=string_sanitize($result->text);
     $qp="insert into twitter values('$tweet','$q');";
     if(!($sql->query($qp)))
        echo $sql->error."<br/>";
   }
}

if($type==="username"){
  $query = array(
    "screen_name" => "$q",
    "count" => "500",
    "result_type" => "recent",
    "lang" => "en"
   );
 
   $results = $toa->get('statuses/user_timeline', $query);

   foreach ($results as $key=>$result) {
     $tweet=string_sanitize($result->text);
     $qp="insert into twitter values('$tweet','$q');";
     if(!($sql->query($qp)))
        {
          echo $sql->error."<br/>"; exit();
        }
   }
}
$sql->close();

header("location:index.php?upload=true");

?>
