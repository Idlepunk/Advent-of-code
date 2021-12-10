<?php
$input = explode("\n", file_get_contents("input"));

$horizontal = 0;
$depth = 0;
$aim = 0;
foreach ($input as $line) {
    $exploded = explode(" ", $line);
    $direction = $exploded[0];
    $amount = $exploded[1];
    if ($direction === "forward") {
        $horizontal += $amount;
        $depth += $aim * $amount;
    } else if ($direction === "up") {
        $aim -= $amount;
    } else if ($direction === "down") {
        $aim += $amount;
    }
}
$result = $horizontal * $depth;
echo $result;
