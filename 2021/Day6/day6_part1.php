<?php
$input = file_get_contents("input");
$fishArray = explode(",", $input);

foreach ($fishArray as &$fish) {
    $fish = (int) $fish;
}

$fishAges = [0,0,0,0,0,0,0,0,0];
foreach ($fishArray as $fishLife) {
    $fishAges[$fishLife]++;
}

$maxDays = 256;
for ($i = 1; $i <= $maxDays; $i++) {
    $newFishSpawn = $fishAges[0];
    array_shift($fishAges);
    $fishAges[] = $newFishSpawn;
    $fishAges[6] += $newFishSpawn;
}

$count = array_sum($fishAges);
echo $count;