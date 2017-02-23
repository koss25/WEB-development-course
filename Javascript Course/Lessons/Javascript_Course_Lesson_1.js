// Javascript Course. Lesson 1

//Особенности синтаксиса

//правильная запись
function HelloWorld() {
  var answer = 'Hello';
  return { 
  answer: 'Hello'}
}
console.log("HelloWorld(): ", HelloWorld());

//неправильная запись
function HelloWorld1() {
  var answer = 'Hello';
  return 
  { answer: 'Hello'}
}
console.log("HelloWorld1(): ", HelloWorld());


1 == 1; //true
'foo' == 'foo'; //true 
[1,2,3] == [1,2,3]; //false
new Array(3) == ",,"; //true
new Array(3).toString(); //",,"
new Array(3) === ",,"; //false


// Числа
0.1+0.2 == 0.3; // false
1 == 1.0 // true

// Ошибочные числа
// 1/0 = Infinity
// -1/0 = -Infinity
// NaN
// NaN != NaN
// isNaN(...) 


// Некоторые удобные функции
Number(10); //10
Number('42.23');    // 42.23
Number('71oshi');   // NaN
parseInt('18'); // 18
parseInt('19kdjas'); //19
parseInt('74.54'); // 74
parseFloat('74.54'); //74.54


parseInt("ff");     // NaN
parseInt("ff","16"); //255
parseInt("0x10"); //16
parseInt("0x10","10"); // 0

// Преобразования (метод объекта number)
var y = 43.81327;
y.toFixed(); //'44'
y.toFixed(1); //'43.8'

// Объект Math
Math.floor(43.81327); //43
Math.ceil(43.81327); // 44
Math.max(10, 20); // 20
// Math.random()
// Math.round()
// Math.sign() // ECMAScript 6
// https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Math/sign#Browser_compatibility
// Math.sin()
// Math.cos()
// Math.sqrt()

// Округление 
3.257582347 | 0; // 3
~~3.257582347; // 3


// Строки
var string1 = "本語";
var string2 = 'terrible';
string2.length; // 8 - получение длины строки
console.log("string2.length: ", string2.length);

// Использование символов юникода
var uni = "\u1552"; // "ᕒ"
"\u1552".length; // 1 - поскольку это 1 символ


// Экранирование запрещенных символов с помощью \

var str4 = 'it\'s my life';

// Строки vs. символы
"abcdef".charAt(2);
"abcdef".charAt(200); // “”
"abcdef".charAt(-1); // “”

// Конкатенация
"abcdef".charAt(0) + "abcdef".charAt(2) + "abcdef".charAt(4); // “ace”
12 + " or " + "20";
12+"or"+"20"; //“12or20”
"12" / 2 + 1; // 7
"day" * 2; //NaN

"Blink " + 182; // “Blink 182”
"Blink " + 181 + 1; // “Blink 1811”
"Blink " + (181 + 1); // “Blink 182”



// Сравнение строк
"a" < "b"; // true
"a" > "b"; // true
"abcd" < "abcd"; // false
"abcd" < "abdc"; // true


// Операторы
//if
//for
//while
//switch
//break
//тернарный оператор


// Объекты
//Функция – объект, массив – объект, объект – объект

var obj = {}; // Создание объекта
var person = {
    firstName : "Alex",
    "age" : 25,
    "" : "weird"
    
 };


// Доступ к свойтвам объектов 
person.name; // “Alex”
person["name"]; // "Alex"
person[""];


// Вложенность
var person = {
    name : "Alex",
    wife : {
        name : "Eve",
        age :29 
    },
    age :25 
};
person["name"]; // “Alex”
person.wife.name;


// Обновление свойств
person.height = 178;
person.height; // undefined


// Прототипы
var Megahuman = Object.create(person);
Megahuman.name;
Megahuman.name = "John";
Megahuman.name;

// Object.prototype

// Удаление свойства
delete Megahuman.name;
Megahuman.name;



// Функция

// name
// length 
// prototype

function myFuncName (x, y, z) {
    //...
};

// Создание функции с помощью литералов
var average = function (x, y) { 
 return (x+y)/2; 
};
average(10,20);

// this
function getIt() {
    return this.x;
}

var obj1 = {getvalue: getIt, x: 1};
var obj2 = {get: getIt, x: 2} ;

obj1.x;
obj1.getvalue(); //1
obj2.get(); //2


// Функция как свойство объекта
var obj = {
    base : 13,
    average : function (x, y) { 
        return (this.base+x+y)/3;
    }
};

// Функция вне объекта

// arguments
function myFuncName (x, y, z) { };
myFuncName (1,2,3,4,5,6,7,8);

var average = function () { 
    var i = 0; 
    var sum = 0;
    for(i=0; i < arguments.length; i++) {
        sum = sum + arguments[i];
    }
    return sum/arguments.length;
};
average(12, 20, 10, 20);


//Область видимости

// Variable hoisting - поднятие переменных
var a = 10;
(function() {
    console.log(a);
})();


var a = 10;
(function() {
    console.log(a); // undefined
    var a = 11;
})();

var a = 10;
(function() {
    var a;
    console.log(a);
    a = 11;
})();


// Замыкания (closures)
var getAnswer = (function() {
    var answer = 42;
    return function inner(){ 
        return answer; 
    }; 
}())
getAnswer(); // 42

// создание новых функций на лету в уже запущенной программе
function greeting(name) {
 var text = "Hello " + name;
 var greet = function() { console.log(text)}
 return greet;
}
var a1 = greeting('John');

a1(); // Hello John


// Наследование

// Конструктор

function Human(name) { 
 this.name = name; 
} 

var alex = new Human();


// Чтобы избежать случайный вывод конструктора без слова 'new' можно сделать следующее:
function Human(name) { 
   if(! (this instanceof Human) ) {
     return new Human(name);
     this.name = name;
   }
}





