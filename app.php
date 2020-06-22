<?php

require 'vendor\autoload.php';

$client = new MongoDB\Client;
//selecting db
$RSS_ReaderDB = $client->RSS_ReaderDB;




$xml=("https://www.news.lk/news?format=feed");


$xmlDoc = new DOMDocument();
$xmlDoc->load($xml);

//get elements from "<channel>"
$channel=$xmlDoc->getElementsByTagName('channel')->item(0);
$channel_title = $channel->getElementsByTagName('title')
->item(0)->childNodes->item(0)->nodeValue;
$channel_link = $channel->getElementsByTagName('link')
->item(0)->childNodes->item(0)->nodeValue;
$channel_desc = $channel->getElementsByTagName('description')
->item(0)->childNodes->item(0)->nodeValue;
$channel_date = $channel->getElementsByTagName('lastBuildDate')
->item(0)->childNodes->item(0)->nodeValue;

//selecting channel collection
$channel = $RSS_ReaderDB->channel;

//insert channel data to db
$insertOneResult = $channel->insertOne(
  [ 'title' => $channel_title, 'link' => $channel_link, 'description' => $channel_desc, 'lastBuildDate' => $channel_date ]
);






//output elements from "<channel>"
echo("<p><a href='" . $channel_link
  . "'>" . $channel_title . "</a>");
echo("<br>");
echo($channel_desc . "</p>");
echo("Last updated at: ");
echo(  $channel_date);

//get and output "<item>" elements
$x=$xmlDoc->getElementsByTagName('item');
for ($i=0; $i<=7; $i++) {
  $item_title=$x->item($i)->getElementsByTagName('title')
  ->item(0)->childNodes->item(0)->nodeValue;
  $item_link=$x->item($i)->getElementsByTagName('link')
  ->item(0)->childNodes->item(0)->nodeValue;
  $item_desc=$x->item($i)->getElementsByTagName('description')
  ->item(0)->childNodes->item(0)->nodeValue;
  $item_date=$x->item($i)->getElementsByTagName('pubDate')
  ->item(0)->childNodes->item(0)->nodeValue;
  
  echo ("<p><a href='" . $item_link
  . "'>" ."<h3>". $item_title."</h3>" . "</a>");
  echo ("<br>");
  echo ($item_desc . "</p>");
  echo ("Published at: ". $item_date);
  echo ("<hr style=\"height:4px;border-width:0;color:gray;background-color:gray\">");
 
 }

?>




