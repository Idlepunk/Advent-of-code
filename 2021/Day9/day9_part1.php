<?php
$input = file_get_contents("input");
$input = explode("\n", $input);

$grid = [];
foreach ($input as $line) {
    $chars = str_split($line);
    $grid[] = array_map('intval', $chars);
}

$xMax = count($grid);
$yMax = count($grid[0]);
$riskLevel = 0;
for ($x = 0; $x < $xMax; $x++) for ($y = 0; $y < $yMax; $y++) {
    $depth = $grid[$x][$y];

    $up = $grid[$x-1][$y] ?? INF;
    $down = $grid[$x+1][$y] ?? INF;
    $left = $grid[$x][$y-1] ?? INF;
    $right = $grid[$x][$y+1] ?? INF;
    if ($up > $depth && $down > $depth && $left > $depth && $right > $depth) {
        $riskLevel += $depth + 1;
    }
}
echo $riskLevel;