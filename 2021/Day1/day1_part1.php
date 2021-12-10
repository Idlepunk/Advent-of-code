<?php
$input = explode("\n", file_get_contents("input"));

$increased = 0;
for ($i = 1; $i < count($input); $i++) {
    if ($input[$i] > $input[$i-1]) {
        $increased++;
    }
}
echo $increased;