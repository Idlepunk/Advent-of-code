<?php
$input = explode("\n", file_get_contents("input"));

$horizontal = 0;
$depth = 0;
foreach ($input as $line) {
    $exploded = explode(" ", $line);
    $direction = $exploded[0];
    $distance = $exploded[1];
    if ($direction === "forward") {
        $horizontal += $distance;
    } else if ($direction === "up") {
        $depth -= $distance;
    } else if ($direction === "down") {
        $depth += $distance;
    }
}
$result = $horizontal * $depth;
echo $result;
