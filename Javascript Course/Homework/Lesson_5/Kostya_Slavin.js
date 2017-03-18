function arrayGrow(array) {
  if (array.length < 3) return 'add more elements to array';  
    for (var i = 0; i < array.length; i++) {
      if (array[i] > array[i+1]) {      
        array.splice(i,1);
          for (var j = 0; j < array.length; j++) {
            if (array[j] >= array[j+1]) {
              return false;
            }
          }
       }
    }
 return true;
}

console.log(arrayGrow([1,2,1,2])); // false
console.log(arrayGrow([-1,-2,3])); // true
console.log(arrayGrow([1,-2,5,56,46])); // false
console.log(arrayGrow([-3,16])); // add more elements to array
