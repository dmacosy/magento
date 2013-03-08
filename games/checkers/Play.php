<?php



include 'Board.php';
var_dump("hello");
$_SESSION['board']= new Board();

var_dump($_SESSION['board']);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <body>
        <form method ="get" action="" >
            <div style="text-align: center; margin: 25px 500px 0px 500px;  ">
                <table style= "padding:30px ;  margin:auto;background-color:white"border="4">
                    <?php echo display(); ?>
                </table>
            </div>
        </form>
    </body>
</html>
<?php

    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', 1);

//if(!isset($_SESSION['board'])){

//}

//*********************************************************************************************************************
//*********************************************************************************************************************
//*********************************************************************************************************************

    function display(){

        $row=-1;
        $col=-1;
        $s="";

        $count=-1;
        $count2=-1;
        foreach($_SESSION['board']->getBoard() as $board){

            global $row, $col, $s;
            $row++;
            $col=-1;
            $s.='<tr >';

            foreach($board as $cell){
                $col++;



                //var_dump($cell);
                if(is_object($cell) && $cell->get("color") =="black"){
                    $id=$cell->get("id");
                    //$cell= new GamePiece(false,"black",$count);
                    $s.='<td style= "background-color:#696969;padding:15px">
                            <input style="background-color:#696969; padding:5px" type = "image" src= "pieces/blackPiece.jpg"
                            Name = "'.$id.'" VALUE =" " width="55" height="55"/>
                        </td>';


                }

                else if(is_object($cell) && $cell->get("color") =="red"){
                    $id=$cell->get("id");
                    //$cell= new GamePiece(false,"red",$count);
                    $s.='<td style= "background-color:#696969;padding:15px">
                            <input style="background-color:#696969; padding:5px" type = "image" src= "pieces/redPiece.jpg"
                            Name = "'.$id.'" VALUE =" " width="55" height="55"/>
                        </td>';
//                    die(var_dump($s));
                }
                else if($cell=="LIVE"){
                    $s.='<td style= "background-color:#696969;padding:15px"><input style="background-color:#696969;
                                     padding:15px" type = "Submit" Name = "show" VALUE = "      "width="55" height="55" /></td>';
                }
                else{
                        $s.='<td style= "background-color:black;padding:15px"></td>';
                    }
                if($col==7){

                    $s.='</tr>';
                    //die(var_dump($s));
                }
            }
        }
        return $s;
    }



