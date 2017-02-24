function getCentury(){
	var year = prompt('Введите год от 1 до 2017');
	return (!isNaN(parseFloat(year)) && isFinite(year)) ? 
		( year < 1 || year > 2017) ? 'Год указан неправильно' : 
			Math.ceil(year / 100) : 'Неверный формат данных';
}
