<?php
/**
 * Created by IntelliJ IDEA.
 * User: Thomas
 * Date: 01/12/2016
 * Time: 16:12
 */
include "../classes/JsonRequest.php";

$query = $_POST["input"];

$casperConf = new JsonRequest(explode(",",$query),"","",50);

$fp = fopen("../../casper/conf.json","w");
$writed = fwrite($fp,json_encode($casperConf));
fclose($fp);

if($writed){
    $res = [];
    exec("casperjs C:/wamp64/www/Crowler/casper/index.js",$res);
    var_dump($res);
}