<?php

class Logic
{
    protected  $_id;
    protected  $_currentPos;
    protected  $_selected;

    function __construct(){

    }

    public function setPosition($ID){

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

    public function getPosition(){
        return $this->_id;
    }

    public function canMove($currentX,$currentY,$targetX,$targetY){
        $board = $_SESSION['board']->getBoard();

        if((($currentX+1==$targetX)||($currentX-1==$targetX)) && (($currentY+1==$targetY)||($currentY-1==$targetY))
            &&  ($board[$targetX][$targetY]->getPiece()==false) ){

            return true;

        }
        else if((($currentX+2==$targetX)||($currentX-2==$targetX)) && (($currentY+2==$targetY)||($currentY-2==$targetY))
            &&  ($board[$targetX][$targetY]->getPiece()==false)  ){


                if(($targetX<=$currentX)&&($targetY<=$currentY)){
                    $board[$currentX-1][$currentY-1]->makeNull();
                }
                else if(($targetX<=$currentX)&&($targetY>=$currentY)){
                    $board[$currentX-1][$currentY+1]->makeNull();
                }
                else if(($targetX>=$currentX)&&($targetY<=$currentY)){
                    $board[$currentX+1][$currentY-1]->makeNull();
                }
                else if(($targetX>=$currentX)&&($targetY>=$currentY)){
                    $board[$currentX+1][$currentY+1]->makeNull();
                }

                return true;

        }
        else{
            return false;
        }

    }
    public function selectedChecker($ID){

        $this->setPosition($ID);
        $str=explode(",", $this->getPosition());
        $currentX=(int)$str[0];

        $currentY=(int)$str[1];
        $this->_currentPos=array($currentX,$currentY);

    }

    public function CheckerMove($targetID){

        $this->setPosition($targetID);
        $targetPos=$this->getPosition();
        $str=explode(",", $targetPos);
        $targetX=(int)$str[0];
        $targetY=(int)$str[1];

        $currentX=$this->_currentPos[0];
        $currentY=$this->_currentPos[1];

        if($this->canMove($currentX,$currentY,$targetX,$targetY)){
            $board = $_SESSION['board']->getBoard();
            $s=$board[$targetX][$targetY];
            $t=$board[$currentX][$currentY];

            $s->takeChecker($t->getChecker());
            $board[$currentX][$currentY]->makeNull();
        }
    }

    /**
     * @todo needs to be implemented
     */

}
