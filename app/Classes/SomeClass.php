<?php

namespace PushAuth\Classes;

class SomeClass

{

    private $to;

    private $l;

    private static $instance;



    public function to($to) {
        $this->to = $to;

        return $this;
    }

    public function d(){
        return $this->l;
    }


    public function send() {
        $this->l=date('mm');


       // return self

        //return ob;
    }



}