<form method="POST">
    <div style="text-align: center; margin-top: 200">

        <input name="roll" type="submit" value="Roll the die">
        <!--<input name="clear" type="submit" value="clear"> -->
    </div>
</form>

<div style="text-align: center; margin-top: 50; ">
    <?php
        function rollDie()
        {
            return rand ( 1, 6 );
        }

        session_start();

        if(isset($_POST['roll'])){
           $roll=rollDie();
            echo "You rolled $roll<br>";

            if($roll==1){
                echo "Game over<br>";
                echo "Your final score is {$_SESSION['score']}!!";
                unset($_SESSION['score']);
            }
            else{
                $_SESSION['score'] = $_SESSION['score']+$roll;
                echo "Your score is {$_SESSION['score']}!!";
            }
        }
    ?>
</div>
