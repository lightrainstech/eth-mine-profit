<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$basic_stat = 'https://etherchain.org/api/basic_stats';
$eth = 'http://coinmarketcap-nexuist.rhcloud.com/api/eth';
$stat_decode = make_http_call($basic_stat);
$eth_decode = make_http_call($eth);

$blocks = $stat_decode['data']['blocks'];
$difficulty = array();
$blockTime = array();

foreach ($blocks as $key => $value) {
  $blockTime[] = $value['blockTime'];
  $difficulty[] = $value['difficulty'];
}
$blockTimeAvg = array_sum($blockTime)/count($blocks);
$difficultyAvg = array_sum($difficulty)/count($blocks);

$record = array (
  'blockTime'  => $blockTimeAvg,
  'difficulty' => $difficultyAvg,
  'priceUsd' =>   $eth_decode['price']['usd'],
  'lastupdate' => time()
);
$data = 'ethereumStats = ' . json_encode($record) . ";";
$file = fopen("eth_stat.json","wa+");
fwrite($file,$data);
fclose($file);

function make_http_call($url) {
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_TIMEOUT, 5);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $data = curl_exec($ch);
  return $stat_decode = json_decode($data,true);
}
?>
