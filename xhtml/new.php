
<form method="POST">
    <div style="text-align: center; margin-top: 100">

        <input name="input" type="text"  size="25">
        <input name="submit" type="submit" value="Submit">
        <!--<input name="clear" type="submit" value="clear"> -->
    </div>
</form>
<?php

//$array;
//
//for($i=2;$i<100;$i++){
    $isPrime=true;
    $number = $_POST['input'];
if(isset($_POST['submit'])&& $number){


    for($j=2; $j<$number;$j++){

        if(($number % $j ==0) && ($number != $j)){
         $isPrime=false;
        }

    }

    ?>
<div style="text-align: center; margin-top: 40">
    <?php if($isPrime) :?>
    <img src="http://fc07.deviantart.net/fs18/f/2007/200/2/2/SD_movie_Optimus_Prime_by_VR_Eli.jpg"><br><br>

    <?php else : ?>
        The number entered is not a prime number
    <?php endif;?>
    </div>
<?
//   if($isPrime){
//       //$array[]= $i;
//       echo 'The number entered is a prime number';
//   }
//    else{
//        echo "$number is not a prime number";
//    }
}
//}
//    echo "<pre>";
//    print_r($array);
?>