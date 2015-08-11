<?php

$awardcsv = fopen("awards.csv", "r");
$contractcsv = fopen("contracts.csv", "r");




while (($data = fgetcsv($awardcsv, 0))) {

    $awards[] = $data;
}

while (($data = fgetcsv($contractcsv, 0))) {

    $contracts[] = $data;
}

$total = 0;
//var_dump($awards);

for ($i = 0; $i < count($contracts); $i++) {

    $result[$i] = null;
    for ($j = 0; $j < count($awards); $j++) {

        if ($i == 0 && $j == 0) {
            unset($awards[0][0]);
            $result[$i] = array_merge($contracts[$i], $awards[$j]);
            break;
        } else if ($contracts[$i][0] == $awards[$j][0]) {

            unset($awards[$j][0]);
            $result[$i] = array_merge($contracts[$i], $awards[$j]);
            if ($contracts[$i][1] == 'Current') {

                $total += $awards[$j][5];
            }
            break;
        }
    }

    if (is_null($result[$i]))
        $result[$i] = $contracts[$i];
}


$finalcsv = fopen('result.csv', 'w');

foreach ($result as $r) {

    fputcsv($finalcsv, $r);
}


echo "Total amount of current contact: " . $total;
?>
