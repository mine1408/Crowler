<?php

/**
 * Created by IntelliJ IDEA.
 * User: hdelo
 * Date: 03/11/2016
 * Time: 09:59
 */
class Body
{
    public $h1;
    public $h2;
    public $h3;
    public $h4;
    public $strong;
    public $page;

    public function __construct($h1, $h2, $h3, $h4, $s, $p){
        $this->h1 = $h1;
        $this->h2 = $h2;
        $this->h3 = $h3;
        $this->h4 = $h4;
        $this->strong = $s;
        $this->page = $p;
    }
}