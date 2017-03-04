function regEx(string) {
  var reg = /\s?\w+-?(\s?\w)+<\/h2/igm;
  var array = string.match(reg);  
    array.splice(0, 0, '<ul>');
    array.push('</ul>');
    array.forEach(function(item, i, array) {
      array[i] = item.replace(' ', '<li>').replace('</h2', '</li>');
    });  
  return array.join('\n');  
}
