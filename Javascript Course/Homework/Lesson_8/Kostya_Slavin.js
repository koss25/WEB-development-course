function getDuplSymbols(str1, str2) {
  var str1 = str1.toLowerCase();
  var str2 = str2.toLowerCase();
  var count = 0;
  
  for (var i = 0; i < str1.length; i++) {
    if (str2.indexOf(str1[i]) > -1) {
      str2 = str2.replace(str1[i], '');
      count++;
    }
  }
 return count;
}

console.log(getDuplSymbols('aabcc','adcaa'));
