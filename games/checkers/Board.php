<?php
include 'GamePiece.php';

    class Board
    {   protected $board;
        protected $_logic;

        function __construct(){

            $this->board=array();
            $this->setup();
            $this->_logic= new Logic();
        }

        function setup(){
            $count=0;
            for($row=0; $row<8; $row++){
                for($col=0; $col<8; $col++){
                    if($row%2==$col%2){
                        if($row<3){
                            $this->board[$row][$col]=new Cell(true,true,array("black",$count));
                            $count++;
                        }
                        else if($row>4){
                            $this->board[$row][$col]=new Cell(true,true,array("red",$count));
                            $count++;
                        }
                        else{
                            $this->board[$row][$col]=new Cell(true,false);
                        }
                    }
                    else {
                        $this->board[$row][$col] = new Cell();
                    }

                }

            }
        }

        function &getBoard(){

            return $this->board;
        }
        function &getLogic(){

            return $this->_logic;
        }
    }