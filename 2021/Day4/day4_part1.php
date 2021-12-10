<?php
$input = file_get_contents("input");
$input = str_replace("  ", " ", $input);
$input = str_replace(" ", ",", $input);

$drawNumbers = getDrawNumbers($input);
$boards = getBoards($input);


foreach ($drawNumbers as $drawNumber) {
    foreach ($boards as &$board) {
        $board = markNumberOnBoard($drawNumber, $board);
        if (checkBoardForWin($board)) {
            $score = calculateScore($board, $drawNumber);
            echo $score;
            die;
        }
    }
}

function calculateScore($board, $drawNumber) {
    $cellSum = 0;
    foreach ($board as $line) {
        foreach ($line as $cell) {
            if (!$cell["marked"]) {
                $cellSum += $cell["value"];
            }
        }
    }
    return $cellSum * $drawNumber;
}

function getBoards($input) {
    $boardStrings = explode("\n\n", $input);
    array_shift($boardStrings);
    $boards = [];
    foreach ($boardStrings as $boardString) {
        $csv = str_replace(",\n", "\n", $boardString);
        $csv = str_replace("\n,", "\n", $csv);
        $csv = ltrim($csv, ',');
        $lines = explode("\n", $csv);
        foreach ($lines as &$line) {
            $line = explode(",", $line);
        }
        $board = [];

        unset($line);
        foreach ($lines as $line) {
            $boardLine = [];
            foreach ($line as $cellValue) {
                $cell = [];
                $cell["value"] = $cellValue;
                $cell["marked"] = false;
                $boardLine[] = $cell;
            }
            $board[] = $boardLine;
        }
        $boards[] = $board;
    }
    return $boards;
}

function getDrawNumbers($input) {
    $drawNumbersString = strtok($input, "\n\n");
    return explode(",", $drawNumbersString);
}

function checkBoardForWin($board) {
    return checkForHorizontalWin($board) || checkForVerticalWin($board);
}

function checkForVerticalWin($board) {
    for ($x = 0; $x < count($board); $x++) {
        $line = $board[$x];
        $allMarked = true;
        for ($y = 0; $y < count($line); $y++) {
            if (!$board[$y][$x]["marked"]) {
                $allMarked = false;
            }
        }
        if ($allMarked) {
            return true;
        }
    }
}

function checkForHorizontalWin($board) {
    foreach ($board as $line) {
        $allMarked = true;
        foreach ($line as $cell) {
            if (!$cell["marked"]) {
                $allMarked = false;
            }
        }
        if ($allMarked) {
            return true;
        }
    }
    return false;
}

function markNumberOnBoard($drawNumber, $board) {
    foreach ($board as &$line) {
        foreach ($line as &$cell) {
            if ($cell["value"] === $drawNumber) {
                $cell["marked"] = true;
            }
        }
    }
    return $board;
}
