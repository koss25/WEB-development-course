function arrayGrow(array) {
  if (array.length < 3) return 'add more elements to array';  
    for (var i = 0; i < array.length; i++) {
      if (array[0] >= array[1] || array[i] >= array[i+1] && array[i+1] !== array[i-1] && array[i+1] > 0) {
        array.splice(i,1);
          for (var j = 0; j < array.length; j++) {
            if (array[j] >= array[j+1]) {
              return false;
            }
          }
       }
      if (array[i+1] == array[i-1] && array[i] == array[i+2]) return false;
    }
  return true;
}
console.log(arrayGrow([2,3,-4,5])); // true
console.log(arrayGrow([1, 2, 3, 4, 3, 6])); //true
console.log(arrayGrow([0, 0, 1, 2, 3, 6])); //true
console.log(arrayGrow([0, -2, 5, 6])); //true
console.log(arrayGrow([1, 2, 3, 4, 99, 5, 6,7])); //true
console.log(arrayGrow([1, 2, 3, 2])); //true
console.log(arrayGrow([1, 3, 2])); //true
console.log(arrayGrow([10, 1, 2, 3, 4, 5])); //true

console.log(arrayGrow([1, 3, 2, 1])); //false
console.log(arrayGrow([1, 1, 1, 2, 3])); //false
console.log(arrayGrow([1, 2, 1, 2])); //false
console.log(arrayGrow([0, 1, 1, 1, 2, 3, 4, 6])); //false
