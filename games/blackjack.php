<?php

session_start();

$stand=false;
function createDeck(){
    for($i=1; $i<=4; $i++){
        $k=0;
            switch($i){
                case 1;
                    global $k;
                    $k="C";
                    break;
                case 2;
                    global $k;
                    $k="D";
                    break;
                case 3;
                    global $k;
                    $k="H";
                    break;
                default;
                    global $k;
                    $k="S";

            }
        //var_dump($k);

            for($j=1; $j<=13; $j++){
                if($j==1){
                    global $k;
                    $_SESSION['deck'][]=$k."-A";
                }
                else if($j>=2 && $j<=10){
                    global $k;
                    $_SESSION['deck'][]=$k."-$j";
                }
                else if($j==11){
                    global $k;
                    $_SESSION['deck'][]=$k."-J";
                }
                else if($j==12){
                    global $k;
                    $_SESSION['deck'][]=$k."-Q";
                }
                else{
                    global $k;
                    $_SESSION['deck'][]=$k."-K";
                }
            }

        }
}

    function faceValue($x){

        if(strlen($x)<= 3){

            if(substr($x,-1)=="J"){
                return("Jack");
            }
            else if(substr($x,-1)=="Q"){
                return("Queen");
            }
            else if(substr($x,-1)=="K"){
                return("King");
            }
            else if(substr($x,-1)=="A"){
                return("Ace");
            }
            else {
                return(substr($x,-1));
            }

        }
        else {
            return("10");

        }

    }

    function cardValue($x,$score){

//        if(strlen($x)<= 3){

            if(substr($x,-1)=="J"){
                return(10);
            }
            else if(substr($x,-1)=="Q"){
                return(10);
            }
            else if(substr($x,-1)=="K"){
                return(10);
            }
            else if(substr($x,-1)=="A"){

                    if ($score >= 11)
                    {
                       return 1;
                    }
                    else
                        return 11;


            }
            else {
                return((int)substr($x,2));
            }

//        }
//        else {
//            return(10);
//
//
//        }

    }


    function suit($x){

        if(strlen($x)<= 3){
            switch(substr($x,-3, 1)){

                case "C";
                    return("Clubs");
                case "D";
                    return("Diamonds");
                case "H";
                    return("Hearts");
                default;
                    return("Spades");
            }
        }

        else{
            switch(substr($x,-4, 1)){
                case "C";
                    return("Clubs");
                case "D";
                    return("Diamonds");
                case "H";
                    return("Hearts");
                default;
                    return("Spades");
            }

        }
    }

    function dealCard($who){

         $random= rand(0,count($_SESSION['deck'])-1);
         $_SESSION['score'][$who] += cardValue($_SESSION['deck'][$random],$_SESSION['score'][$who]);
         $_SESSION[$who][]=$_SESSION['deck'][$random];


         unset($_SESSION['deck'][$random]);
         $_SESSION['deck'] = array_values($_SESSION['deck']);

//         $random2= rand(0,count($_SESSION['deck'])-1);
//         $_SESSION['Player'][]=$_SESSION['deck'][$random2];
//         unset($_SESSION['deck'][$random2]);
        }

    function firstDeal(){
        dealCard("Dealer");
        dealCard("Player");
        dealCard("Dealer");
        dealCard("Player");
    }

    function displayGame($who){
           $s="<h3><u>$who</u></h3>";
        if($who == "Player"|| playerWon() || dealerWon() || tie())
           $s.= '<strong>'.$_SESSION['score'][$who]."</strong><br />";

        for($i=0;$i<count($_SESSION[$who]);$i++){

            if(dealerWon() || playerWon() || $i !=0 && $who=="Dealer" || $who=="Player")
            $s.=faceValue($_SESSION[$who][$i])." of ".suit($_SESSION[$who][$i])."<br />";

        }
        return $s;
    }
    function show(){
        $s="";
        if(tie()){
            $s.='<h2>Tie</h2><br />
            <img src="https://twimg0-a.akamaihd.net/profile_images/508365551/bluetieSINGLE.png" width="225" height="175"><br ><br />
            <input name="reset" type="submit" value="Reset Game">';
        }
        elseif(playerWon()){
            $s.='<h2>Winner</h2><br />
            <img src="http://www.winnersauzen.nl/files/3313/3249/7177/Winner-logo-Adobe-RGB.jpg" width="225" height="175"><br ><br />
            <input name="reset" type="submit" value="Reset Game">';
        }
        elseif(dealerWon()){
            $s.='<h2>You Lost</h2><br />
            <img src="http://katerawlings.com/wp-content/uploads/2010/02/loser.jpg" width="225" height="175"><br /><br />
            <input name="reset" type="submit" value="Reset Game">';
        }
        elseif(dealerWon()&& $_SESSION['score']['Player']>21){
            $s.='<h2>You Lost</h2><br />
            <img src="http://katerawlings.com/wp-content/uploads/2010/02/loser.jpg" width="225" height="175"><br /><br />
            <input name="reset" type="submit" value="Reset Game">';
        }
        else{
            $s.='<input name="hit" type="submit" value="Hit">
                 <input name="stand" type="submit" value="Stand">
                 <input name="reset" type="submit" value="Reset Game">';
        }


        $s.=displayGame("Dealer");
        $s.=displayGame("Player");
        return $s;

    }
    function isStanding(){
        global $stand;
        return ($stand);
    }
    function setStand($x){
        global $stand;
        $stand=$x;
        
        
    }
    function canHit($who)
    {
        if ($_SESSION['score'][$who] < 21 ||$_SESSION['score'][$who] !=0)
            return true;
        else
            return false;
    }
    function playerWon()
    {

        if ($_SESSION['score']['Player'] == 21 ||$_SESSION['score']['Player'] < 21 && $_SESSION['score']['Player'] >
            $_SESSION['score']['Dealer'] && isStanding() ||$_SESSION['score']['Player'] < 21 && $_SESSION['score']['Dealer'] > 21){
            return true;
        }
        else{
            return false;
        }
    }

    function dealerWon()
    {
        if ($_SESSION['score']['Dealer'] == 21 ||$_SESSION['score']['Dealer'] < 21 && $_SESSION['score']['Dealer'] >
            $_SESSION['score']['Player'] && isStanding() || $_SESSION['score']['Dealer'] < 21 && $_SESSION['score']['Player'] > 21){
            return true;
        }
        else{
            return false;
        }

    }
    function tie(){
        if($_SESSION['score']['Player']==$_SESSION['score']['Dealer']&& isStanding()){
            return true;
        }
        else{
            return false;
        }

    }
    function dealerTurn(){
        while(canHit("Dealer") && $_SESSION['score']['Dealer']< $_SESSION['score']['Player']){

            dealCard("Dealer");


        }
    }

//    if(!isset($_SESSION['firstRun'])){
//       $_SESSION['firstRun']=false;
//
//    }
    if(isset($_POST['start'])){
        createDeck();
        firstDeal();


    }
    elseif(isset($_POST['reset'])){
        setStand(false);
        unset($_SESSION['deck']);
        unset($_SESSION['Player']);
        unset($_SESSION['Dealer']);
        unset($_SESSION['score']);
        unset($_SESSION['firstRun']);
    }
    elseif(isset($_POST['hit'])){
        dealCard("Player");

    }
    elseif(isset($_POST['stand'])){
        setStand(true);
        dealerTurn();

}


    ?>

    <form method="POST">

        <div style="text-align: center; margin-top: 75; ">

            <?php if(!isset($_SESSION['firstRun'])): ?>
                <input name="start" type="submit" value="Start">
                <?php $_SESSION['firstRun']=false; ?>
            <?php endif; ?>

            <?php echo show();

            ?>
        </div>

    </form>