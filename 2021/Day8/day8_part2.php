<?php
$input = file_get_contents("input");
$input = explode("\n", $input);

$map = [];
foreach ($input as $item) {
    $split = explode(" | ", $item);
    $signals = explode(" ", $split[0]);
    $values = explode(" ", $split[1]);
    $map[] = ["signals" => $signals, "values" => $values];
}

$valueDigits = [
    1 => 2,
    4 => 4,
    7 => 3,
    8 => 7
];

$total = 0;
foreach ($map as $item) {
    $confirmedSignals = [0 => null, 1 => null, 2 => null, 3 => null, 4 => null, 5 => null, 6 => null, 7 => null, 8 => null, 9 => null];

    # Add unique length signals.
    foreach ($item["signals"] as $signal) {
        $length = strlen($signal);
        $search = array_search($length, $valueDigits);
        if ($search !== false) {
            $confirmedSignals[$search] = $signal;
        }
    }

    # Add 5 length signals
    foreach ($item["signals"] as $signal) {
        $length = strlen($signal);
        $signalChars = str_split($signal);

        if ($length === 5) {
            if (getCommonArmCount($signalChars, $confirmedSignals, 1) === 2) {
                # 3 shares 2 common arms with 1
                $confirmedSignals[3] = $signal;
            } else if (getCommonArmCount($signalChars, $confirmedSignals, 4) === 2) {
                # 2 shares 2 common arms with 4
                $confirmedSignals[2] = $signal;
            } else if (getCommonArmCount($signalChars, $confirmedSignals, 4) === 3) {
                # 5 shares 3 common arms with 4
                $confirmedSignals[5] = $signal;
            }
        } else if ($length === 6) {
            if (getCommonArmCount($signalChars, $confirmedSignals, 1) === 1) {
                # 1 shares 1 common arms with 6
                $confirmedSignals[6] = $signal;
            } else if (getCommonArmCount($signalChars, $confirmedSignals, 4) === 3) {
                # 0 shares 3 common arms with 4
                $confirmedSignals[0] = $signal;
            } else {
                $confirmedSignals[9] = $signal;
            }
        }
    }

    foreach ($confirmedSignals as &$confirmedSignal) {
        $confirmedSignal = sortStringAlphabetically($confirmedSignal);
    }

    $number = "";
    foreach ($item["values"] as $value) {
        $valueChars = str_split($value);
        $sortedValue = sortStringAlphabetically($value);
        $actualValue = array_search($sortedValue, $confirmedSignals);
        $number .= (string)$actualValue;
    }

    $total += (int)$number;

}

echo $total;

function sortStringAlphabetically($string) {
    $stringParts = str_split($string);
    sort($stringParts);
    return implode($stringParts);
}

function getCommonArmCount($signalChars, $confirmedSignals, $number) {
    return count(array_intersect($signalChars, (array)str_split($confirmedSignals[$number])));
}