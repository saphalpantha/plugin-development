<?php

function myMessage($name) {
  echo "Hello " .$name;
}



$name = "saphal";
myMessage($name);
    


$numbers = array(4, 6, 2, 22, 11);
sort($numbers);



// sort dec

$cars = array("Volvo", "BMW", "Toyota");
rsort($cars);


// sorting in associated array


$age = array("Peter"=>"42", "Ben"=>"37", "Joe"=>"2");
asort($age);

foreach($age as $i){
    echo "<br> $i </br>";
}



// pass by ref

function add_five(&$value) {
  $value += 5;
}

$num = 2;
add_five($num);
echo $num;


?>