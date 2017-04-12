function getTotalComWeight($array) {
  $ar1 = [];
  $ar2 = [];
  $totalW = [];
    foreach ($array as $key => $value) {
      $key % 2 === 0 ? array_push($ar1, $array[$key]) : array_push($ar2, $array[$key]);
    }
    array_push($totalW, array_sum($ar1), array_sum($ar2));
    return $totalW;
  } 
  
