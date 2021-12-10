<?php
$input = explode("\n", file_get_contents("input"));

$bits = [[],[],[],[],[]];
foreach ($input as $line) {
    $chars = str_split($line);
    for ($i = 0; $i < count($chars); $i++) {
        $j = (int) $chars[$i];
        if (!isset($bits[$i][$j])) {
            $bits[$i][$j] = 0;
        }
        $bits[$i][$j]++;
    }
}

$gammaRate = "";
$epsilonRate = "";
foreach ($bits as $bit) {
    $gamma = $bit[0] > $bit[1] ? "0" : "1";
    $gammaRate .= $gamma;
    $epsilonRate .= decbin(bindec(~(int)$gamma));
}

$gammaRateDecimal = bindec($gammaRate);
$epsilonRateDecimal = bindec($epsilonRate);
$powerConsumption = $gammaRateDecimal * $epsilonRateDecimal;

echo $powerConsumption;