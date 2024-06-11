<?php


    $name = "This is String";

    $age = 20;

    $value = 20.555;
    
    $isVoter =  true; // RETURN 0 OR 1

    echo " $name "." $age "." $value "." $isVoter ";




    echo strpos("Hello world!", "world");


    // arrays



    $cars = array(1,2,3,4,5,6);

    // array with diff datatype
    $myArray = array("Volvo", 12, ["apple", "banana"]);


    foreach($myArray as $i){
        if(gettype($i) != "array"){
            echo "<br>$i<br>";
        }
        else{
            foreach($i as $j){
                echo "<br> -$j</br>";
            }
        }
    }

    // assoticative array


    $temp = array("brand" => "Ford", "model"=>"Mustang","year"=>1964);

   // echo $temp["model"]; // accesign using indx;


    
    
    foreach($temp as $x => $y){
        echo " - $x  = $y ";
    }

    $temp2 = [1,2,3,4];

    $temp2[] = 5;
    
    echo "after adding $temp2[4] in temp 2";


 
    // inserting in associated aray
    
    $temp["price"] = 200;



    

  array_push($temp2, 6,7,8);

  // insert multiple into associated array

  $temp += ["color" => "red", "year" => 1964];



  

    // deletion in array


    
    array_splice($temp2, 1, 2);
  

    echo "<br><br>after deleting elements from temp2";

      
    foreach($temp2 as $i){
            echo "<br>$i<br>";
    }



    // removing from associated array

    unset($temp['color']);


      
    echo "<br><br>after deleting elements from temp2";
    foreach($temp as $i => $j){
            echo "<br>$i = $j<br>";
    }









    



















    


    
    



    




?>