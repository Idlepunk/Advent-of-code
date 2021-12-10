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
    foreach ($chars as $char) {
        if (in_array($char, array_keys($chunkStarters))) {
            $stack[] = $char;
            $expectedStack[] = $chunkStarters[$char];
        } else {
            if ($char === end($expectedStack)) {
                array_pop($expectedStack);
            } else {
                $score += $scores[$char];
                break;
            }
        }
    }
    $validLines[] = $line;
}

echo $score;