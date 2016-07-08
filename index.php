<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$basic_stat = 'https://etherchain.org/api/basic_stats';
$eth = 'http://coinmarketcap-nexuist.rhcloud.com/api/eth';

$ch = curl_init($basic_stat);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$data = curl_exec($ch);
$stat_decode = json_decode($data,true);

$ch = curl_init($eth);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$eth_data = curl_exec($ch);
$eth_decode = json_decode($eth_data,true);
curl_close($ch);

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
$data = json_encode($record);
$file = fopen("eth_stat.json","wa+");
fwrite($file,$data);
fclose($file);

?>
