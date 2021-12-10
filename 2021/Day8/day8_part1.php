<?php
$input = file_get_contents("input");
$input = explode("\n", $input);

$map = [];
foreach ($input as $item) {
    $split = explode(" | ", $item);
    $signals = explode(" ",$split[0]);
    $values = explode(" ", $split[1]);
    $map[] = ["signals" => $signals, "values" => $values];
}

$valueDigits = [
    1 => 2,
    4 => 4,
    7 => 3,
    8 => 7
];

$count = 0;
foreach ($map as $item) {
    foreach ($item["values"] as $value) {
        $length = strlen($value);
        $search = array_search($length, $valueDigits);
        if ($search !== false) {
            $count++;
        }
    }
}
echo $count;