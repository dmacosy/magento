<?php

    class GamePiece
    {
        protected $data=array();

        function __construct($color,$id){

            $this->data['color'] = $color;
            $this->data['id']=$id;
            $this->data['isKing']=false;

        }
        function set($key, $value){

            $this->data[$key] = $value;
        }
        function get($key){

            return $this->data[$key];
        }
}
