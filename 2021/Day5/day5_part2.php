<?php
$input = file_get_contents("input");

$ventCoordinates = getVentCoordinatesFromInput($input);
$grid = buildGrid();
$grid = populateGridWithVents($grid, $ventCoordinates);
$points = calculateNumberOfOverlappingVents($grid);
echo $points;

function getVentCoordinatesFromInput($input) {
    $lines = explode("\n", $input);
    $positions = [];
    foreach ($lines as $line) {
        $posLines = explode(" -> ", $line);
        $start = explode(",", $posLines[0]);
        $coordinate["start"]["x"] = (int)$start[0];
        $coordinate["start"]["y"] = (int)$start[1];
        $end = explode(",", $posLines[1]);
        $coordinate["end"]["x"] = (int)$end[0];
        $coordinate["end"]["y"] = (int)$end[1];
        $positions[] = $coordinate;
    }
    return $positions;
}

function buildGrid() {
    $width = 1000;
    $height = 1000;
    $grid = [];
    for ($x = 0; $x < $width; $x++) {
        for ($y = 0; $y < $height; $y++) {
            $grid[$x][$y] = 0;
        }
    }
    return $grid;
}

function populateGridWithVents(array $grid, $vents) {
    foreach ($vents as $vent) {
        $start = $vent["start"];
        $end = $vent["end"];

        if ($start["x"] === $end["x"]) {
            if ($start["y"] > $end["y"]) {
                for ($y = $end["y"]; $y <= $start["y"]; $y++) {
                    addVentToCoordinate($grid, $start["x"], $y);
                }
            } else {
                for ($y = $start["y"]; $y <= $end["y"]; $y++) {
                    addVentToCoordinate($grid, $start["x"], $y);
                }
            }
        } else if ($start["y"] === $end["y"]) {
            if ($start["x"] > $end["x"]) {
                for ($x = $end["x"]; $x <= $start["x"]; $x++) {
                    addVentToCoordinate($grid, $x, $start["y"]);
                }
            } else {
                for ($x = $start["x"]; $x <= $end["x"]; $x++) {
                    addVentToCoordinate($grid, $x, $start["y"]);
                }
            }
        } else {
            $xMax = max($start["x"], $end["x"]);
            $yMax = max($start["y"], $end["y"]);
            $xMin = min($start["x"], $end["x"]);
            $yMin = min($start["y"], $end["y"]);

            $x = $start["x"];
            $y = $start["y"];
            while ($x <= $xMax && $y <= $yMax && $x >= $xMin && $y >= $yMin) {
                addVentToCoordinate($grid, $x, $y);
                if ($start["x"] > $end["x"]) {
                    $x--;
                } else {
                    $x++;
                }

                if ($start["y"] > $end["y"]) {
                    $y--;
                } else {
                    $y++;
                }
            }
        }
    }
    return $grid;
}

function addVentToCoordinate(array &$grid, $x, $y) {
    $grid[$x][$y]++;
}


function calculateNumberOfOverlappingVents(array $grid) {
    $points = 0;
    foreach ($grid as $x) {
        foreach ($x as $y) {
            if ($y >= 2) {
                $points++;
            }
        }
    }
    return $points;
}