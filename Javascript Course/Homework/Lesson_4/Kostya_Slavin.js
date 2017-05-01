function getDiffCount(arr) {   
  function sortArr(a,b) { return a - b }
  var newArr = arr.sort(sortArr),
       count = 0, 
        diff = 0;
  for (i = 0; i < newArr.length-1; i++) {
    diff = newArr[i+1] - newArr[i];
      if (diff === 1) continue;
        count += diff - 1;
  }
  return count;
}

var myArray = [6,2,3,8];
console.log(getDiffCount(myArray)); //3
var myArray = [6,'10',2,3,8];
console.log(getDiffCount(myArray)); //4
