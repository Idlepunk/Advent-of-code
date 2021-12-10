<?php
$input = file_get_contents("input");
$input = explode("\n", $input);

$chunkStarters = ["(" => ")", "[" => "]", "{" => "}", "<" => ">"];
$chunkClosers = [")", "]", "}", ">"];

$scores = [")" => 3, "]" => 57, "}" => 1197, ">" => 25137];
$score = 0;
global $chunkStarters;

$validLines = [];
foreach ($input as $line) {
    $chars = str_split($line);
    $stack = [];
    $expectedStack = [];
    $lineValid = true;
    foreach ($chars as $char) {
        if (in_array($char, array_keys($chunkStarters))) {
            $stack[] = $char;
            $expectedStack[] = $chunkStarters[$char];
        } else {
            if ($char === end($expectedStack)) {
                array_pop($expectedStack);
            } else {
                $score += $scores[$char];
                $lineValid = false;
                break;
            }
        }
    }
    if ($lineValid) {
        $validLines[] = $line;
    }
}

$values = [")" => 1, "]" => 2, "}" => 3, ">" => 4];
$totalScore = 0;
$scores = [];
foreach ($validLines as $line) {
    $chars = str_split($line);
    $stack = [];
    $expectedStack = [];
    foreach ($chars as $char) {
        if (in_array($char, array_keys($chunkStarters))) {
            $stack[] = $char;
            $expectedStack[] = $chunkStarters[$char];
        } else {
            if ($char === end($expectedStack)) {
                array_pop($expectedStack);
            } else {
                break;
            }
        }
    }
    $score = 0;
    $expectedStack = array_reverse($expectedStack);
    foreach ($expectedStack as $item) {
        $score = $score * 5;
        $score += $values[$item];
    }
    $scores[] = $score;
}

sort($scores);
$pos = count($scores) / 2 - .5;
echo $scores[$pos];