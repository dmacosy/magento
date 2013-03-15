<?php

class Cell
{
    private $_isLive;
    private $_hasPiece;
    private $_checker;


    public function __construct($isLive = false, $hasPiece = false, $checker = null){
        if(isset($checker)){
            $this->setChecker($checker);

        }
        $this->setLive($isLive);
        $this->setPiece($hasPiece);


    }
    public function setLive($isLive){

        $this->_isLive = $isLive;


    }

    public function setPiece($hasPiece){

        $this->_hasPiece = $hasPiece;
    }
    public function getLive(){

        return $this->_isLive;

    }
    public function getPiece(){

        return $this->_hasPiece;

    }
    public function setChecker($checker){

//todo implement singleton
        $this->_checker= new GamePiece($checker[0],$checker[1]);

    }
    public function &getChecker(){

        return $this->_checker;
    }

    public function makeNull(){

        $this->_checker = null;
        $this->_hasPiece = false;
    }
    public function takeChecker($checker){
        $this->_checker= clone $checker;

    }
    public function getColor(){

       return $this->_checker->get('color');
    }
    public function setKing(){

        $this->_checker->set('isKing',true);
    }
    public function getKing(){

        return $this->_checker->get('isKing');
    }

    //@todo implement below method
    public function team(){

    }
}