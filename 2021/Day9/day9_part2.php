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
$lowPoints = [];
for ($x = 0; $x < $xMax; $x++) for ($y = 0; $y < $yMax; $y++) {
    $depth = $grid[$x][$y];

    $up = $grid[$x-1][$y] ?? INF;
    $down = $grid[$x+1][$y] ?? INF;
    $left = $grid[$x][$y-1] ?? INF;
    $right = $grid[$x][$y+1] ?? INF;
    if ($up > $depth && $down > $depth && $left > $depth && $right > $depth) {
        $lowPoints[$x.$y] = ["x" => $x, "y" => $y, "basin" => []];
    }
}

for ($x = 0; $x < $xMax; $x++) for ($y = 0; $y < $yMax; $y++) {
    $depth = $grid[$x][$y];
    if ($depth === 9) {
        continue;
    }

    if (isset($lowPoints[$x.$y])) {
        $lowPoints[$x.$y]["basin"][] = ["x" => $x, "y" => $y];
        continue;
    }

    $xx = $x;
    $yy = $y;
    $lowPointFound = false;

    $path = [];
    while (!$lowPointFound) {
        $up = $grid[$xx-1][$yy] ?? INF;
        $down = $grid[$xx+1][$yy] ?? INF;
        $left = $grid[$xx][$yy-1] ?? INF;
        $right = $grid[$xx][$yy+1] ?? INF;

        $directions = ["up" => $up, "down" => $down, "left" => $left, "right" => $right];

        $lowest = array_keys($directions, min($directions));
        $direction = $lowest[0];

        if (count($lowest) > 1) {
            foreach ($lowest as $dir) {
                $xxx = $xx;
                $yyy = $yy;
                if ($direction === "up") {
                    $xxx--;
                } else if ($direction === "down") {
                    $xxx++;
                } else if ($direction === "left") {
                    $yyy--;
                } else if ($direction === "right") {
                    $yyy++;
                }
                if (isset($path[$xxx . $yyy])) {
                    continue;
                }
                $direction = $dir;
                break;
            }
        }

        if ($direction === "up") {
            $xx--;
        } else if ($direction === "down") {
            $xx++;
        } else if ($direction === "left") {
            $yy--;
        } else if ($direction === "right") {
            $yy++;
        }

        $path[] = $xx . $yy;

        if (isset($lowPoints[$xx.$yy])) {
            $lowPoints[$xx.$yy]["basin"][] = ["x" => $x, "y" => $y];
            $lowPointFound = true;
        }
    }

}

$basins = [];
foreach ($lowPoints as $lowPoint) {
    $basins[] = count($lowPoint["basin"]);
}

rsort($basins);
$score = $basins[0] * $basins[1] * $basins[2];
echo $score;