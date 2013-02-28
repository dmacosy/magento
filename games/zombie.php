<form method="POST">
    <div style="text-align: center; margin-top: 200">

        <input name="roll" type="submit" value="Roll the dice">
        <input name="reset" type="submit" value="Reset Game">
        <!--<input name="clear" type="submit" value="clear"> -->
    </div>
</form>

<div style="text-align: center; margin-top: 50">
    <?php



            function rollDie()
            {
                return rand ( 1, 6 );
            }
            function chooseDice()
            {
                return rand ( 1,13 );
            }
            function play(&$cd,&$rd){

                $x=0;


                if($cd <= 3){
                    echo "A hard die was chosen<br>";

                    switch($rd){
                        case 1;
                        case 2;
                        case 3;
                            echo "On the hard die you rolled shot.<br> You lose 1 health point<br><br> ";
                            $x+=2;
                            break;
                        case 4;
                            echo "On the hard die you rolled brain.<br> 1 point added to your total<br><br>";
                            $x+=5;
                            break;
                        default;
                            echo "On the hard die you rolled run. <br> No points added and no health taken away<br><br> ";
                    }
                }

                else if($cd >=4 && $cd <=7){
                    echo "A medium die was chosen<br>";

                    switch($rd){
                        case 1;
                        case 2;
                            echo "On the medium die you rolled shot.<br> You lose 1 health point<br><br> ";
                            $x+=2;
                            break;
                        case 3;
                        case 4;
                            echo "On the medium die rolled brain.<br> 1 point added to your total<br><br>";
                            $x+=5;
                            break;
                        default;
                            echo "On the medium die you rolled run. <br> No points added and no health taken away<br><br> ";

                    }
                }
                else{
                    echo "An easy die was chosen<br>";
                    switch($rd){
                        case 1;
                            echo "On the easy die you rolled shot.<br> You lose 1 health point<br><br> ";
                            $x+=2;
                            break;
                        case 2;
                        case 3;
                        case 4;
                            echo "On the easy die you rolled brain.<br> 1 point added to your total<br><br>";
                            $x+=5;
                            break;
                        default;
                            echo "On the easy die you rolled run. <br> No points added and no health taken away<br><br> ";

                    }

                }

                if($x==2){
                    return "health";
                }
                else if($x==5){
                    return "point";
                }
                else{
                    return "blank";
                }
            }



            session_start();

                $point=0;
                $health=0;

                if(isset($_POST['roll'])){

                    echo "<u>Die 1</u><br><br>";
                    $die1=chooseDice();
                    $roll1=rollDie();
                    $play1=play($die1,$roll1);

                    if($play1=="point"){
                        global $point;
                        $point++;

                    }
                    else if($play1=="health"){

                        global $health1;
                        $health++;

                    }



                    echo "<u>Die 2</u><br><br>";
                    $die2=chooseDice();
                    $roll2=rollDie();
                    $play2=play($die2,$roll2);

                    if($play2=="point"){
                        global $point;
                        $point++;
                    }
                    else if($play2=="health"){
                        global $health1;
                        $health++;

                    }


                    echo "<u>Die 3</u><br><br>";
                    $die3=chooseDice();
                    $roll3=rollDie();
                    $play3=play($die3,$roll3);

                    if($play3=="point"){
                        global $point;
                        $point++;
                    }
                    else if($play3=="health"){
                        global $health1;
                        $health++;
                    }


                    echo "You were shot $health times during this turn.<br>";
                    echo "Point value added during this turn.<br><br>";

                    $_SESSION['score'] = $_SESSION['score']+$point;
                    $_SESSION['healths'] = $_SESSION['healths']+$health;

        //                echo "Your total score is {$_SESSION['score']}!!<br>";
        //                echo "Your total health is {$_SESSION['healths']}!!<br>";
        //                var_dump($play1);
        //                var_dump($play2);
        //                var_dump($play3);


                    if($_SESSION['healths']>=3){
                            echo "<h3>Game over</h3>";
                            echo"<strong>You got shot 3 times</strong><br>";
                            echo "<strong> Your final point tally is {$_SESSION['score']}!!</strong><br>";
                            unset($_SESSION['score']);
                            unset($_SESSION['healths']);
                        }
                    else if( $_SESSION['healths']< 3 && $_SESSION['score']>=13 ){
                            echo "<h3>You win</h3>";
                            echo "<strong>Your final point tally is {$_SESSION['score']}!!</strong><br>";
                            echo "Your only got shot {$_SESSION['healths']} times !!<br>";
                            unset($_SESSION['score']);
                            unset($_SESSION['healths']);
                        }
                    else{

                        echo "<strong>Your total score is {$_SESSION['score']}!!</strong><br>";
                        echo "<strong>You got shot {$_SESSION['healths']} times!!</strong><br>";
                    }
                }
                else if(isset($_POST['reset'])){
                    unset($_SESSION['score']);
                    unset($_SESSION['healths']);

                }

    ?>
</div>