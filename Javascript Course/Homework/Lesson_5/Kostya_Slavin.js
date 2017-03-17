function arrayGrow(array) {

  function randomInt(min, max) {
    var rand = min + Math.random() * (max + 1 - min);
    rand = Math.floor(rand);
    return rand;
   }
   
   var rand = randomInt(0, array.length-1);
   console.log('deleted element index = '+ rand);
   
   array.splice(rand,1);
   console.log('Array after delete ' + array);
   
   for (var i = 0; i < array.length; i++) {
     if (array[i] > array[i+1]) 
       return false;
   }
  return true;
 }
  
console.log(arrayGrow([1,-2,5,56,46]));
console.log(arrayGrow([1,3,2,1]));
console.log(arrayGrow([1,3,2,16]));
console.log(arrayGrow([-3,-1,16]));
