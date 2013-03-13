<?php
    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', 1);


    include 'Board.php';
    include 'Cell.php';
    include 'Logic.php';
    session_start();
//    $_SESSION['board']= new Board();



    echo "<pre>";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <body>
        <form method ="get" action="" >
            <div style="text-align: center;   ">
                <input type = "Submit" Name = "Submit" VALUE = "New Game" /><br><br>
                <table style= "padding:5px ; margin:auto; background-color:white"border="4">
                    <?php

                        if(!isset($_SESSION['board'])){
                            $_SESSION['board']= new Board();
                        }
                        else if(isset($_GET["checker"])){
                            $_SESSION['board']->getLogic()->selectedChecker($_GET["checker"]);
                        }
                        else if(isset($_GET["show"])){
                            echo '<div style="text-align: center;   ">';

                            if($_SESSION['board']->getLogic()->isEmpty($_GET["show"]) && $_SESSION['board']->getLogic()->isSelected()){

                                $_SESSION['board']->getLogic()->CheckerMove($_GET["show"],$_SESSION['board']->getLogic()->getSelectedChecker()->getColor());
                            }




                        }
                        else if(isset($_GET['Submit'])){
                            unset($_SESSION['board']);
                            $_SESSION['board']= new Board();
                        }
                    echo display();


                    ?>
                </table>
            </div>
        </form>
    </body>
</html>
<?php



//*********************************************************************************************************************
//*********************************************************************************************************************
//*********************************************************************************************************************

    function display(){
        global $r, $col, $s, $id;
        $s="";
        $r=-1;

        foreach($_SESSION['board']->getBoard() as $row){

            $r++;
            $col=-1;
            $s.='<tr >';

            foreach($row as $cell){


                $col++;
                if((is_object($cell->getChecker()))){

                    $id=$cell->getChecker()->get('id');

                    if($cell->getChecker()->get('color') == "black" && $cell->getChecker()->get('isKing') == true){

                        $s.='<td style= "background-color:#696969">
                                <input style="background-color:#696969;color:f10707;  width:65px; height:65px;position:center;
                                              background-image:url(pieces/blackKingPiece.jpg)" type = "submit"
                                              name = "checker" value ="'.$id.'"/>
                            </td>';

                    }
                    else if($cell->getChecker()->get('color') =="red" && $cell->getChecker()->get('isKing') == true){

                        $s.='<td style= "background-color:#696969">
                                <input style="background-color:#696969;color:black;  width:65px; height:65px;position:center;
                                              background-image:url(pieces/redKingPiece.jpg)" type = "submit"
                                              name = "checker" value ="'.$id.'"/>
                            </td>';
                    }
                    else if($cell->getChecker()->get('color') == "black"){

                        $s.='<td style= "background-color:#696969">
                                <input style="background-color:#696969;color:black;  width:65px; height:65px;position:center;
                                              background-image:url(pieces/blackPiece.jpg)" type = "submit"
                                              name = "checker" value ="'.$id.'"/>
                            </td>';

                    }
                    else if($cell->getChecker()->get('color') =="red"){

                        $s.='<td style= "background-color:#696969">
                                <input style="background-color:#696969;color:f10707; width:65px; height:65px;position:center;
                                              background-image:url(pieces/redPiece.jpg)" type = "submit"
                                              name = "checker" value ="'.$id.'"/>
                            </td>';
                    }

                }
                else if($cell->getLive()==true ){

                    $s.='<td style= "background-color:#696969">
                            <input style="background-color:#696969; width:65px; height:65px;color:#696969;
                                          padding:15px" type = "Submit" Name = "show" VALUE = "'.$r."-".$col.'"  />
                         </td>';
                }
                else{

                    $s.= '<td style= "background-color:#000000;padding:10px"></td>';
                }

                if($col==Board::COL){

                    $s.='</tr>';

                }
            }
        }
        return $s;

    }