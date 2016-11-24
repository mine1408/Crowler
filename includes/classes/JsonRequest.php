<?php

/**
 * Created by IntelliJ IDEA.
 * User: hdelo
 * Date: 17/11/2016
 * Time: 16:19
 */

class Options{
    public $keywords;
    public $escapes;
    public $cms;

    public function __construct($keywords, $escapes, $cms){
        $this->keywords = $keywords;
        $this->escapes = $escapes;
        $this->cms = $cms;
    }
}

class JsonRequest
{

    public $rootPage;
    public $options;
    public $nbLink;
    public $capchaBalise;
    public $capcha;

    public function __construct ($keywords, $excludes, $cms){
        $this->rootPage = 'http://www.google.fr/';
        $this->options = new Options($keywords, $excludes, $cms);
        $this->capchaBalise = 'form[action="CaptchaRedirect"]';
        $this->capcha = 'capcha.png';
    }

}