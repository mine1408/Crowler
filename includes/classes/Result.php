<?php

/**
 * Created by IntelliJ IDEA.
 * User: hdelo
 * Date: 03/11/2016
 * Time: 09:59
 */
class Result
{
    public $keywords;
    public $websites;

    public function __construct($ks, $wss){
        $this->keywords = $ks;
        $this->websites = $wss;
    }
}