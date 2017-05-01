function getGrowth($array) {
  $newAr = [];
  $j = 0;
  foreach ($array as $value) {
    if ($value !== -1 && $value < 200){
      array_push($newAr, $value);
    }
  }
  sort($newAr, SORT_NUMERIC);
  foreach ($array as $key => $value) {
    if ($value !== -1) {
      $array[$key] = $newAr[$j];
      $j += 1;
    }
  }
 return print_arr($array);
}

getGrowth([-1, 150, 190, -1, 185, 170, -1, -1, 160, 180]);
