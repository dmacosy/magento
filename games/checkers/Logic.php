<?php

class Logic
{
    protected  $_id;
    protected  $_currentPos;
    protected  $_selected;
    protected  $_isSelected;

    function __construct(){
        $_isSelected= false;

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
//                    else if(!is_object($cell->getChecker()) && strlen($ID)>2){

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
            else if((($currentX+2==$targetX)||($currentX-2==$targetX)) && (($currentY+2==$targetY)||($currentY-2==$targetY))
                &&  ($board[$targetX][$targetY]->getPiece()==false)  ){


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
                    else{

                        return false;
                    }


                    return true;

            }

//            else if((($currentX+4==$targetX)||($currentX-4==$targetX)) || (($currentY+4==$targetY)||($currentY-4==$targetY))
//                &&  ($board[$targetX][$targetY]->getPiece()==false)  ){
//
////                echo $currentX+2 ;
////                echo $currentY-2 ;
//
//                if((($currentY==$targetY)||($currentY==$targetY))){
//                    $board[$currentX+2] ;
//                    echo $currentY-2 ;
//                    if($board[$currentX+2][$currentY-2]->getPiece()==false &&
//                        $board[$currentX+1][$currentY-1]->getPiece()==true &&
//                        $board[$currentX+3][$currentY-1]->getPiece()==true){
//
//                        $board[$currentX+1][$currentY-1]->makeNull();
//                        $board[$currentX+3][$currentY-1]->makeNull();
//
//                    }
//                    else if(($board[$currentX+2][$currentY+2]->getPiece()==false) &&
//                        ($board[$currentX+1][$currentY+1]->getPiece()==true)  &&
//                        ($board[$currentX+3][$currentY+1]->getPiece()==true)){
//
//                        echo $currentX+2 ;
//                        echo $currentY-2 ;
//                        $board[$currentX+1][$currentY+1]->makeNull();
//                        $board[$currentX+3][$currentY+1]->makeNull();
//
//
//                    }
//                    else{
//
//                        return false;
//                    }
//                    return true;
//                }
//
//            }

            else{
                return false;
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
        $board = &$_SESSION['board']->getBoard();
        $this->setPosition($targetID);
        $targetPos=$this->getPosition();
        $str=explode(",", $targetPos);
        $targetX=(int)$str[0];
        $targetY=(int)$str[1];

        $currentX=$this->_currentPos[0];
        $currentY=$this->_currentPos[1];

//        if($targetX== 0 && $board[$currentX][$currentY]->getColor()== "red" ){
//
//            $board[$currentX][$currentY]->setKing();
//        }
//        else if($targetX== 7 && $board[$currentX][$currentY]->getColor()== "black" ){
//
//            $board[$currentX][$currentY]->setKing();
//        }

        if($this->canMove($currentX,$currentY,$targetX,$targetY,$color)){
            $board = $_SESSION['board']->getBoard();
            $s=$board[$targetX][$targetY];
            $t=$board[$currentX][$currentY];

            $s->takeChecker($t->getChecker());
            $board[$currentX][$currentY]->makeNull();
            $this->_isSelected=false;

            //@todo multijump

            $_SESSION['board']->switchTurn();
        }

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

    public function multiJump($currentX,$currentY,$targetX,$targetY){
        $board = $_SESSION['board']->getBoard();

       if((($currentY+4==$targetY)||($currentY-4==$targetY))){
            if($board[$currentX+2][$currentY-2]->getPiece()==false &&
               $board[$currentX+1][$currentY-1]->getPiece()==true  &&
               $board[$currentX+3][$currentY-1]->getPiece()==true){

                $board[$currentX+1][$currentY-1]->makeNull();
                $board[$currentX+3][$currentY-1]->makeNull();

            }
            else if($board[$currentX+2][$currentY+2]->getPiece()==false &&
                    $board[$currentX+1][$currentY+1]->getPiece()==true  &&
                    $board[$currentX+3][$currentY-1]->getPiece()==true){

                    $board[$currentX+1][$currentY+1]->makeNull();
                    $board[$currentX+3][$currentY+1]->makeNull();


            }
           else{

               return false;
           }
          return true;
       }
       else{
           return false;
       }

}




    /**
     * @todo needs to be implemented
     */

}
