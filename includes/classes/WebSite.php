<?php

/**
 * Created by IntelliJ IDEA.
 * User: hdelo
 * Date: 03/11/2016
 * Time: 09:55
 */
class WebSite
{
    public $link;
    public $rank;
    public $keywords;

    public function __construct($l, $r, $ks){
        $this->link = $l;
        $this->rank = $r;
        $this->keywords = $ks;
    }
}