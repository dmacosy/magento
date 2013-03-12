<?php

class Cell
{
    private $_isLive;
    private $_hasPiece;
    private $_checker;
    private $_id;

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


        $this->_checker= new GamePiece($checker[0],$checker[1]);

    }
    public function getChecker(){

        return $this->_checker;
    }
    public function setId($id){

        $this->_id=$id;

    }
    public function getCell(){

        return $this->_id;
    }

}
