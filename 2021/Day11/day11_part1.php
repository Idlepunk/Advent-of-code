<?php
$input = file_get_contents("input");
$input = explode("\n", $input);

function makeGrid(array $input) {
    $grid = [];
    foreach ($input as $line) {
        $chars = str_split($line);
        $gridLine = [];
        foreach ($chars as $char) {
            $gridLine[] = [
                "energy" => (int)$char,
                "flashed" => false
            ];
        }
        $grid[] = $gridLine;
    }
    return $grid;
}

function doStep(array &$grid) {
    $maxX = count($grid);
    $maxY = count($grid[0]);

    for ($x = 0; $x < $maxX; $x++) for ($y = 0; $y < $maxY; $y++) {
        $grid[$x][$y]["energy"] += 1;
    }

    $flashing = true;
    while ($flashing) {
        $flashing = false;
        for ($x = 0; $x < $maxX; $x++) for ($y = 0; $y < $maxY; $y++) {
            $squid = &$grid[$x][$y];
            if ($squid["energy"] > 9 && !$squid["flashed"]) {
                flashSquid($x, $y, $grid);
                $squid["flashed"] = true;
                $flashing = true;
            }
        }
    }
}

function flashSquid(int $x, int $y, array &$grid) {
    flashCell($x - 1, $y, $grid);
    flashCell($x + 1, $y, $grid);

    flashCell($x, $y - 1, $grid);
    flashCell($x, $y + 1, $grid);

    flashCell($x - 1, $y - 1, $grid);
    flashCell($x + 1, $y + 1, $grid);

    flashCell($x - 1, $y + 1, $grid);
    flashCell($x + 1, $y - 1, $grid);
}

function flashCell($x, $y, &$grid) {
    if (isset($grid[$x][$y])) {
        $grid[$x][$y]["energy"] += 1;
    }
}

function resetFlashes(array &$grid) {
    $flashes = 0;
    foreach ($grid as &$line) foreach ($line as &$squid) {
        if ($squid["flashed"]) {
            $flashes++;
            $squid["energy"] = 0;
        }
        $squid["flashed"] = false;
    }
    return $flashes;
}

$grid = makeGrid($input);
$maxSteps = 100;
$flashes = 0;

for ($i = 0; $i < $maxSteps; $i++) {
    doStep($grid);
    $flashes += resetFlashes($grid);
}

echo $flashes;