<?php
$input = explode("\n", file_get_contents("input"));

$increased = 0;
for ($i = 3; $i < count($input); $i++) {
    $sum = $input[$i] + $input[$i-1] + $input[$i-2];
    $prevSum = $input[$i-1] + $input[$i-2] + $input[$i-3];
    if ($sum > $prevSum) {
        $increased++;
    }
}
echo $increased;