<?php
include 'GamePiece.php';

    class Board
    {   protected $board;
        protected $_logic;
        protected $_turn;

        const ROW=8;
        const COL=8;

        public function __construct(){

            if ((self::COL % 2 !== 0) && (self::ROW % 2 !== 0)){
                die("CURSE U");
            }
            $this->board=array();
            $this->setup();
            $this->_logic= new Logic();

            $this->_turn="black";
        }

        public function setup(){
            $count=0;

            for($row=0; $row<self::ROW; $row++){
                for($col=0; $col<self::COL; $col++){
                    if($row%2==$col%2){
                        if($row<self::ROW/2-1){
                            $this->board[$row][$col]=new Cell(true,true,array("black",$count));
                            $count++;
                        }
                        else if( $row>self::ROW/2){
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

        //@todo implement singleton
        public function &getBoard(){

            return $this->board;
        }
        public function &getLogic(){

            return $this->_logic;
        }
        public function switchTurn(){
            $this->_turn = $this->_turn === "black" ? "red" : "black";
        }
        public function getTurn(){

            return $this->_turn;

        }
    }