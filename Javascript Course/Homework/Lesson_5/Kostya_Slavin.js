function arrayGrow(array) {
  if (array.length < 3) return 'add more elements to array';
  
  var newAr = [];
  
  for (var i = 0; i < array.length; i++) {
    if (array[i] > array[i+1]) {
      newAr.push(array[i]);
    }
  }
 return newAr.length == 1;    
}

console.log(arrayGrow([1,2,1,2])); // true
console.log(arrayGrow([-1,-2,3])); // true
console.log(arrayGrow([1,-2,5,56,46])); // false
console.log(arrayGrow([-3,16])); // add more elements to array
