<?php
header("Content-Type:text/html; charset=utf-8");
$maxBomb = $_GET["maxBomb"];
$length = $_GET["length"];
$width = $_GET["width"];



for ($x = 0; $x < $length; $x++) {
    for ($y = 0; $y < $width; $y++) {
        $arr[$x][$y] = '0';
    }
}

for($setBomb = 0; $setBomb < $maxBomb; $setBomb++) {
    while(true) {
        // 隨機產生一個炸彈
        $row = rand(0, $length-1);
        $column = rand(0, $width-1);
        if ($arr[$row][$column] != 'M') {
            $arr[$row][$column] = 'M';
            break;
        }
    }
}

for ($x = 0; $x < $length; $x++){
    for ($y = 0; $y < $width; $y++){
        if ($arr[$x][$y]!= 'M') {
            if ($arr[$x+1][$y] == 'M') {
                $arr[$x][$y]++;
            }
            if ($arr[$x-1][$y] == 'M') {
                $arr[$x][$y]++;
            }
            if ($arr[$x][$y+1] == 'M') {
                $arr[$x][$y]++;
            }
            if ($arr[$x][$y-1] == 'M') {
                $arr[$x][$y]++;
            }
            if ($arr[$x+1][$y+1] == 'M') {
                $arr[$x][$y]++;
            }
            if ($arr[$x-1][$y-1] == 'M') {
                $arr[$x][$y]++;
            }
            if ($arr[$x-1][$y+1] == 'M') {
                $arr[$x][$y]++;
            }
            if ($arr[$x+1][$y-1] == 'M') {
                $arr[$x][$y]++;
            }
        }
    }
}
$x=0;
$y=0;
$str;
foreach ($arr as $value) {
    $y=0;
    foreach ($value as $val) {
        $str .= ($x * $width + $y).",";
        $v .= $val.",";
        $y++;
    }
    $x++;
}

$str =substr($str,0,-1);
$v = substr($v,0,-1);
$arr = array("str"=>$str, "val"=>$v);

echo json_encode($arr);
