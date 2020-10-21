<?php
$initiateRepeat = 0;
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

$saveTo = input("Save To");


$delimeter = explode("\n", trim(file_get_contents($pathFile)));
$checkTotal = 1;
$amountList = count($delimeter);
$urlList = array();
foreach($delimeter as $formList) {
  if(empty($formList)) {
    continue;
  }
  $formList = trim($formList);
  list($ccnum) = explode("|", trim($formList));
  $bin = substr($ccnum, 0, 6);
  $get = file_get_contents("https://lookup.binlist.net/".$bin);
  $data = json_decode($get,1);
  $scheme = @$data['scheme'] ? strtoupper($data['scheme']) : "N/A";
  $brand = @$data['brand'] ? strtoupper($data['brand']) : "N/A";
  $type = @$data['type'] ? strtoupper($data['type']) : "N/A";
  $bank = @$data['bank']['name'] ? strtoupper($data['bank']['name']) : "N/A";
  $country = @$data['bank']['name'] ? strtoupper($data['country']['name']) : "N/A";
  file_put_contents($saveTo, $formList." [".$scheme." - ".$brand." - ".$type." - ".$bank." - ".$country."]\n", FILE_APPEND);
  echo  $formList." ".$scheme." - ".$brand." - ".$type." - ".$bank." - ".$country."\n";
}

function input($text) {
  echo $text.": ";
  $a = trim(fgets(STDIN));
  return $a;
}
