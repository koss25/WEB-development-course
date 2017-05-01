function getEstateCost(array) {
  var sum = 0;
  for (var i = 0; i < array.length; i++) {
    for (var j = 0; j <= array[i].length; j++) {
      if (array[i][j] === 0 || array[i][j] === 'x') {
        array[i][j] = 'x';
          if (i+1 <= array.length-1)
            array[i+1][j] = 'x';
      } else {
        sum  += (typeof array[i][j] === 'number') ? array[i][j]: false ;
      }
    }
  }
 return sum;
}

matrix = [[0,1,2,2],
          [0,5,0,4],
          [0,0,3,3], 
          [2,0,3,3]];  // 20
      
