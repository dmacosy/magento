<?php
include 'GamePiece.php';

    class Board
    {   private $board;

        private $env=array();

        function __construct(){

            $this->board;
            //$this->setStatus();
            $this->setup();
            //var_dump($this->board);


        }

//        function setStatus(){
//
//            for($row=0; $row<8; $row++){
//                for($col=0; $col<8; $col++){
//                    if($row%2==$col%2){
//                        $this->board[$row][$col]="LIVE";
//                    }
//                    else{
//                        $this->board[$row][$col]="UNUSED";
//                    }
//
//                }
//
//            }
//
//        }
        function setup(){
            $count=0;


            for($row=0; $row<8; $row++){
                for($col=0; $col<8; $col++){
                    if($row%2==$col%2){
                        if($row<3){
                            $count++;
                            $this->board[$row][$col]=new GamePiece("black",$count);
                        }
                        else if($row>4){
                            $count++;
                            $this->board[$row][$col]=new GamePiece("red",$count);;
                        }
                        else {
                            $this->board[$row][$col]="LIVE";
                        }

                    }
                    else{
                        $this->board[$row][$col]="UNUSED";
                    }
                }

            }
        }
//        function cell(){
//
//        }
        function getBoard(){

            return $this->board;
        }




    }