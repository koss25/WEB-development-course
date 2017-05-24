<?php

session_start();

$img = imagecreatetruecolor(85, 32);

$red = imagecolorallocate($img, 255, 0, 0);
$pink = imagecolorallocate($img, 200, 0, 150);
$blue =  imagecolorallocate($img, 144, 169, 224);

function randomStr($length) {
  $chars = "ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz23456789";
  srand((double)microtime()*1000000);
  $str = "";
  $i = 0;
    while($i <= $length) {
      $num = rand() % 33;
      $tmp = substr($chars, $num, 1);
      $str = $str . $tmp;
      $i++;
    }
  return $str;
}

$colorAr1 = imagecolorallocate($img, rand(0,255), rand(0,255), rand(0,255));
$colorAr2 = imagecolorallocate($img, rand(0,255), rand(0,255), rand(0,255));
$colorAr3 = imagecolorallocate($img, rand(0,255), rand(0,255), rand(0,255));

for($i = 1; $i <= rand(1,5); $i++) {
  $color = (rand(1,2) == 1) ? $red : $pink;
  imageline($img, rand(5,70), rand(2,20), rand(5,75)+5, rand(5,20)+5, $color);
}

imagefill($img, 0, 0, $blue);
$string1 = randomStr(rand(1,2));
$string2 = randomStr(rand(1,2));
$string3 = randomStr(rand(1,2));
$string = $string1.$string2.$string3;
$_SESSION['string'] = $string;



imagettftext($img, 11, rand(5,30), 5, 25, $colorAr1, "roboto.ttf", $string1);
imagettftext($img, 11, rand(-5,-35), 25, 10, $colorAr2, "times.ttf", $string2);
imagettftext($img, 11, rand(-5,-35), 50, 15, $colorAr3, "times.ttf", $string3);

header("Content-type: image/png");
imagepng($img);
imagedestroy($img);


