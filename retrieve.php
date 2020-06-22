<?php

require 'vendor\autoload.php';

$client = new MongoDB\Client;
//selecting db
$RSS_ReaderDB = $client->RSS_ReaderDB;
//selecting channel collection
$channelCollection = $RSS_ReaderDB->channelCollection;

//retrieve channel details
$document = $channelCollection->find();

    // iterate document to assinge data to variables   
    foreach ($document as $doc) {
        $channel_link = $doc ["link"];
        $channel_title = $doc["title"];
        $channel_desc = $doc ["description"];
        $channel_date = $doc {"lastBuildDate"};
    }
//output
echo("<p><a href='" . $channel_link
  . "'>" . $channel_title . "</a>");
echo("<br>");
echo($channel_desc . "</p>");
echo("Last updated at: ");
echo(  $channel_date);

//selecting news collection
$newsCollection = $RSS_ReaderDB->newsCollection;

$item = $newsCollection->find();

// iterate document to assinge data to variables   
foreach ($item as $doc) {
    $item_link = $doc ["link"];
    $item_title = $doc["title"];
    $item_desc = $doc ["description"];
    $item_date = $doc {"lastBuildDate"};

    echo ("<p><a href='" . $item_link
  . "'>" ."<h3>". $item_title."</h3>" . "</a>");
  echo ("<br>");
  echo ($item_desc . "</p>");
  echo ("Published at: ". $item_date);
  echo ("<hr style=\"height:4px;border-width:0;color:gray;background-color:gray\">");
 
}


?>