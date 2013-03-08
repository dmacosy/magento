<?php

    class GamePiece
    {
        protected $data=array();

        public function __construct($color,$id){

            $this->data['color'] = $color;
            $this->data['id']=$id;
            $this->data['isKing']=false;

        }
        public function set($key, $value){

            $this->data[$key] = $value;
        }
        public function get($key){

            return $this->data[$key];
        }
}
