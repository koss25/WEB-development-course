function drawStars($arr) {
  $maxLen = 0;
  foreach ($arr as $key => $value) {
    $maxLen = ($maxLen > strlen($value)) ? $maxLen : strlen($value);    
  }
    foreach ($arr as $key => $value) {
      if(strlen($value) < $maxLen && strlen($value) !== 0) {
        $elVal = str_repeat('*', $maxLen - strlen($value)+1);
        array_splice($arr, $key, 1, '*'.$value.$elVal);
      } elseif (strlen($value) == 0) {
        array_splice($arr, $key, 1, str_repeat('*', $maxLen+2));
      } else {
        array_splice($arr, $key, 1, '*'.$value.'*');
      }
    } 
    array_unshift($arr, str_repeat('*', $maxLen+2));
    array_push($arr, str_repeat('*', $maxLen+2));
  return $arr;
} 

echo "<pre>";
print_r(drawStars(['aseew', 'qwkiw', 'rrg', 'qw', '', 'u']));
echo "</pre>";
