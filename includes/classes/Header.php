<?php

/**
 * Created by IntelliJ IDEA.
 * User: hdelo
 * Date: 03/11/2016
 * Time: 09:59
 */
class Header
{
    public $title = 0.0;
    public $meta = 0.0;

    public function __construct($t,$m){
        $this->title = $t;
        $this->meta = $m;
    }
}