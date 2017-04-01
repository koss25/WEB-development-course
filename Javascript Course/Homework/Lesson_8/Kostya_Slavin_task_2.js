function checkLuckyTicket(number) {
  var str = number.toString(10);
  
  function getSum(array) {
    return array.reduce(function(sum, current) {
      return sum + Number(current);
    }, 0);
  }
  
  if (str.length % 2 !== 0 || number < 10 || number > Math.pow(10,6)) {
    return 'Ticket number is incorrect';
  } else {
      var sum1 = str.substr(0,str.length / 2).split('');
      var sum2 = str.substr(str.length / 2, str.length-1).split('');
      return (getSum(sum1) === getSum(sum2)) ? true: false;
  }
}
               
console.log(checkLuckyTicket(1230));    
