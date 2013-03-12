<?php

class Logic
{
    private $_id;

    /**
     * Current cell container
     * @var Cell
     */


    function __construct(){

        //$this->currentPos($ID);

    }




    public function setCurrentPos($ID){

        $currentX="";
        $currentY="";

        if(isset($_SESSION['board'])){
            $row=-1;
            foreach($_SESSION['board']->getBoard()as $board){
                $col=-1;
                $row++;
                foreach($board as $cell){
                    $col++;
                    if(is_object($cell->getChecker()) && $cell->getChecker()->get('id')==$ID){

                        $currentX=(int)$row;
                        $currentY=(int)$col;

                    }
                    else if(!is_object($cell->getChecker()) && strlen($ID)>2){

                        $str=explode("-", $ID);

                        $currentX=(int)$str[0];
                        $currentY=(int)$str[1];
                    }


                }
            }
        }

        $this->_id= $currentX.','.$currentY;
    }

    public function getCurrentPos(){
        return $this->_id;
    }

    public function canMove($currentX,$currentY,$targetX,$targetY){
        $board = $_SESSION['board']->getBoard();

        if((($currentX+1==$targetX)||($currentX-1==$targetX)) && (($currentY+1==$targetY)||($currentY-1==$targetY))
            &&  ($board[$targetX][$targetY]->getPiece()==false) ){

            return true;

        }
        else{
            return false;
        }

    }

    /**
     * @todo needs to be implemented
     */
    public function CheckerMove(){

    }


}
