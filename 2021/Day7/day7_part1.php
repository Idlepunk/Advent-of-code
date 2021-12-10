<?php
$input = file_get_contents("input");
$positions = array_map('intval', explode(',', $input));

$minPosition = 0;
$maxPosition = max($positions);

$fuelCosts = [];
for ($i = $minPosition; $i <= $maxPosition; $i++) {
    $fuelCost = 0;
    foreach ($positions as $position) {
        $distance = abs($i - $position);
        $fuelCost += $distance;
    }
    $fuelCosts[$i] = $fuelCost;
}

$leastFuel = min($fuelCosts);
echo $leastFuel;