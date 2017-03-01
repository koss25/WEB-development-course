function getMaxMul(arr) {
  var len = arr.length,
      res = 0,
      max = 0;

  for (var i = 0; i < len; i++) {
    res = arr[i] * arr[i+1];
    max = (max < res) ? res : max;
  }
  return max;
}

var arr = [30, 6, -8, -50, 7, 3];
