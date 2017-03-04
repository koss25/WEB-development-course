<<<<<<< HEAD
function checkPalindrom(string) {
=======
function checkPalindrom(string) {	
>>>>>>> b593efd439f85490b42125954a739dfac00b7d2e
	if (string[0] === undefined || string[0] === ' ') return 'Data is empty';
	
	var string = string.split(''),
				 len = string.length,
			lastEl = len - 1,
					 i = 0;

	for (; i < len; i++) {
		if (i <= lastEl-i) {
			if (string[i] !== string[lastEl-i]) return false;
		}
<<<<<<< HEAD
	}
=======
	}	
>>>>>>> b593efd439f85490b42125954a739dfac00b7d2e
	return true;
}

console.log(checkPalindrom('aabaa'));   //true
console.log(checkPalindrom('abcabc'));  //false
console.log(checkPalindrom('1234321')); //true
console.log(checkPalindrom(' '));       //Data is empty
console.log(checkPalindrom(''));        //Data is empty
