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
    public $nbLinks;
    public $capchaBalise;
    public $capcha;

    public function __construct ($keywords, $excludes, $cms,$nbLinks){
        $this->rootPage = 'http://www.google.fr/';
        $this->options = new Options($keywords, $excludes, $cms);
        $this->captchaBalise = "form[action='CaptchaRedirect']";
        $this->captcha = 'capcha.png';
        $this->nbLinks = $nbLinks;
    }

}