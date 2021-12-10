<?php
$input = explode("\n", file_get_contents("input"));

$oxygen = bitFilter($input);
$oxygenDecimal = bindec($oxygen);

$CO2 = bitFilter($input, true);
$CO2Decimal = bindec($CO2);

$lifeSupportRating = $oxygenDecimal * $CO2Decimal;
echo $lifeSupportRating;

function bitFilter($input, $co2Mode = false) {
    $zeros = [];
    $ones = [];
    $length = strlen($input[0]);
    for ($i = 0; $i < $length; $i++) {
        foreach ($input as $item) {
            if ($item[$i] === "0") {
                $zeros[] = $item;
            } else {
                $ones[] = $item;
            }
        }
        if (count($ones) === count($zeros)) {
            $input = $co2Mode ? $zeros : $ones;
        } else if ($co2Mode) {
            $input = $ones < $zeros ? $ones : $zeros;
        } else {
            $input = $ones > $zeros ? $ones : $zeros;
        }

        if (count($input) === 1) {
            return $input[0];
        }
        $ones = [];
        $zeros = [];
    }
}
