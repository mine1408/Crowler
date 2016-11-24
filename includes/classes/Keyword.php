<?php

/**
 * Created by IntelliJ IDEA.
 * User: hdelo
 * Date: 03/11/2016
 * Time: 09:58
 */
class Keyword
{
    public $keywordName;
    public $body;
    public $header;

    public function __construct($k, $b, $h){
        $this->keywordName = $k;
        $this->body = $b;
        $this->header = $h;
    }
}