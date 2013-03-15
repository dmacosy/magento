<?php

class Logic
{
    protected  $_id;
    protected  $_currentPos;
    protected  $_selected;
    protected  $_isSelected;
    protected  $_canJump;

    function __construct(){
        $this->_isSelected= false;
        $this->_canJump= false;

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
                    else if(strpos($ID,'-') !== false){
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

    public function canMove($currentX,$currentY,$targetX,$targetY,$color ){
        $board = $_SESSION['board']->getBoard();
        if ((($targetX >= 0) && ($targetX <= 7) && ($targetY >= 0) && ($targetY <= 7))
        &&(($currentX >= 0) && ($currentX <= 7) && ($currentY >= 0) && ($currentY <= 7))){
            if(($currentX< $targetX)&& $color=="red"&& $board[$currentX][$currentY]->getKing()==false){
                return false;
            }
            else if(($currentX> $targetX)&& $color=="black"&& $board[$currentX][$currentY]->getKing()==false){
                return false;
            }
            else{

                if((($currentX+1==$targetX)||($currentX-1==$targetX)) && (($currentY+1==$targetY)||($currentY-1==$targetY))
                    &&  ($board[$targetX][$targetY]->getPiece()==false) ){

                    return true;

                }
                else{
                    return false;
                }
            }

        }
    }

    public function ifJump($currentX,$currentY,$targetX,$targetY,$color ){
        $board = $_SESSION['board']->getBoard();
        if ((($targetX >= 0) && ($targetX <= 7) && ($targetY >= 0) && ($targetY <= 7))
            &&(($currentX >= 0) && ($currentX <= 7) && ($currentY >= 0) && ($currentY <= 7))){
            if(($currentX< $targetX)&& $color=="red"&& $board[$currentX][$currentY]->getKing()==false){
                return false;
            }
            else if(($currentX> $targetX)&& $color=="black"&& $board[$currentX][$currentY]->getKing()==false){
                return false;
            }
            else{

                if((($currentX+2==$targetX)||($currentX-2==$targetX)) && (($currentY+2==$targetY)||($currentY-2==$targetY))
                    &&  ($board[$targetX][$targetY]->getPiece()==false)  ){

                    $this->_canJump= true;
                    return true;

                }
                else{
                    return false;
                }
            }
        }
    }
    public function selectedChecker($ID){

        $board = &$_SESSION['board']->getBoard();

        $this->setPosition($ID);
        $str=explode(",", $this->getPosition());
        $currentX=(int)$str[0];
        $currentY=(int)$str[1];

        if($board[$currentX][$currentY]->getColor()== $_SESSION['board']->getTurn()){
            $this->_currentPos=array($currentX,$currentY);
            $this->_selected=clone $board[$this->_currentPos[0]][$this->_currentPos[1]];
            $this->_isSelected= true;
        }
    }
    public function isSelected(){

        return $this->_isSelected;
    }
    public function getSelectedChecker(){

        return $this->_selected;
    }


    public function CheckerMove($targetID,$color){

        $this->setPosition($targetID);
        $targetPos=$this->getPosition();
        $str=explode(",", $targetPos);
        $targetX=(int)$str[0];
        $targetY=(int)$str[1];

        $currentX=$this->_currentPos[0];
        $currentY=$this->_currentPos[1];


        if($this->canMove($currentX,$currentY,$targetX,$targetY,$color)||$this->ifJump($currentX,$currentY,$targetX,$targetY,$color )){
            $board = $_SESSION['board']->getBoard();
            if($targetX== 0 && $board[$currentX][$currentY]->getColor()== "red" ){

                $board[$currentX][$currentY]->setKing();
            }
            else if($targetX== 7 && $board[$currentX][$currentY]->getColor()== "black" ){

                $board[$currentX][$currentY]->setKing();
            }


        if($this->_canJump== true){
           $this->makeJump($currentX,$currentY,$targetX,$targetY);

        }
            $this->remove($currentX,$currentY,$targetX,$targetY);
            $_SESSION['board']->switchTurn();

        }

    }
    public function remove($currentX,$currentY,$targetX,$targetY){
        $board = $_SESSION['board']->getBoard();
        $s=$board[$targetX][$targetY];
        $t=$board[$currentX][$currentY];

        $s->takeChecker($t->getChecker());
        $board[$currentX][$currentY]->makeNull();
        $s->setPiece(true);
        $this->_isSelected=false;



    }



    public function makeJump($currentX,$currentY,$targetX,$targetY){
        $board = $_SESSION['board']->getBoard();

        if((($targetX<=$currentX)&&($targetY<=$currentY)) &&
            ($board[$currentX-1][$currentY-1]->getColor() !=
                $board[$currentX][$currentY]->getColor())){

            $board[$currentX-1][$currentY-1]->makeNull();
        }
        else if((($targetX<=$currentX)&&($targetY>=$currentY)) &&
            ($board[$currentX-1][$currentY+1]->getColor() !=
                $board[$currentX][$currentY]->getColor())){

            $board[$currentX-1][$currentY+1]->makeNull();
        }

        else if((($targetX>=$currentX)&&($targetY<=$currentY)) &&
            ($board[$currentX+1][$currentY-1]->getColor() !=
                $board[$currentX][$currentY]->getColor())){

            $board[$currentX+1][$currentY-1]->makeNull();
        }
        else if((($targetX>=$currentX)&&($targetY>=$currentY)) &&
            ($board[$currentX+1][$currentY+1]->getColor() !=
                $board[$currentX][$currentY]->getColor())){

            $board[$currentX+1][$currentY+1]->makeNull();
        }
        $this->_canJump=false;


    }

    public function isEmpty($cell){

        $str=explode("-", $cell);
        $x=(int)$str[0];
        $y=(int)$str[1];
        $board = &$_SESSION['board']->getBoard();
        if ($board[$x][$y]->getPiece()){
            return false;
        }
        return true;
    }


    /**
     * @todo needs to be implemented
     */

}
