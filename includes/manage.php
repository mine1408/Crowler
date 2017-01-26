<?php
/**
 * Created by IntelliJ IDEA.
 * User: hdelo
 * Date: 03/11/2016
 * Time: 09:55
 */

function getColors(){
    return ["#009688","#35a79c","#54b2a9","#65c3ba","#83d0c9"];
};

function getBalises(){
    return ["title", "meta", "h1", "h2", "h3", "h4", "strong", "page"];
};

//Not used
/*function createSVGPath ($keyword)
{
    return ("M45.015625," .
        ((100 - $keyword->header->title )* 2) . ",120.31197227293472," .
        ((100 - $keyword->header->meta) * 2) . ",195.60831954586945," .
        ((100 - $keyword->body->h1) * 2) . ",271.11095818119577," .
        ((100 - $keyword->body->h2) * 2) . ",346.4073054541305," .
        ((100 - $keyword->body->h3) * 2) . ",421.7036527270652," .
        ((100 - $keyword->body->h4) * 2) . ",496.9997260914879," .
        ((100 - $keyword->body->strong) * 2) . ",572.2957984557052," .
        ((100 - $keyword->body->page) * 2) . ""
    );
};*/

function computeBarChart($balises, $keywords){

    $wtf = 0;
    foreach ($balises as $balise) {
        $field = "";
        if ($wtf > 0)
            $field = $field . ",";
        $baliseString = (string)$balise;
        $field = $field . "{y:\"" . $baliseString . "\"";
        $i = 0;
        foreach ($keywords as $keyword) {
            if (property_exists("Header", $baliseString)) {
                $field = $field . ",\"" . $i . "\":" . $keyword->header->{$baliseString};
            } else if (property_exists("Body", $baliseString)) {
                $field = $field . ",\"" . $i . "\":" . $keyword->body->{$baliseString};
            } else
                continue;
            $i++;
        }
        $field = $field . "}";
        $wtf++;
        echo($field);
    }
};

function computeLineChart($balises, $keywords){

    $wtf = 0;
    foreach ($balises as $balise) {
        $field = "";
        if ($wtf > 0)
            $field = $field . ",";
        $baliseString = (string)$balise;
        $field = $field . "{y:\"" . $baliseString . "\"";
        $i = 0;
        foreach ($keywords as $keyword) {
            if (property_exists("Header", $baliseString)) {
                $field = $field . ",\"" . $i . "\":" . $keyword->header->{$baliseString};
            } else if (property_exists("Body", $baliseString)) {
                $field = $field . ",\"" . $i . "\":" . $keyword->body->{$baliseString};
            } else
                continue;
            $i++;
        }
        $field = $field . "}";
        $wtf++;
        echo($field);
    }
};


function buildStringFromArray ($array){
    $i = 0;
    foreach ($array as $a) {
        if ($i > 0)
            echo(",");

        echo("\"" . $a . "\"");

        $i++;
    }
};
function buildStringFromMultipleArray ($array){
    $i = 0;
    foreach ($array as $a) {
        if ($i > 0)
            echo(",");

        echo("\"" . $a[0] . "\"");

        $i++;
    }
};
function buildStringFromKeywords ($keywords){
    $i = 0;
    foreach ($keywords as $k) {
        if ($i > 0)
            echo(",");

        echo("\"" . $k->keywordName . "\"");

        $i++;
    }
};

function constructDataSet($website, $balises){
    $dataSet = "";
    $i = 0;
    foreach ($website->keywords as $keyword) {
        if($i > 0)
            $dataSet = $dataSet.",";
        $dataSet = $dataSet."[\"".$keyword->keywordName."\"";
        $j = 0;
        foreach ($balises as $balise) {

            $baliseString = (string)$balise;

            if (property_exists("Body", $baliseString)) {
                $dataSet = $dataSet.",".$keyword->body->{$baliseString};
            } else
                continue;
            $j++;
        }
        $i++;

        $dataSet = $dataSet."]";
    }
    echo($dataSet);
};


function launchSearcher($keywordString){
    echo($keywordString);
    $keywords = explode($keywordString, ",");
    echo($keywords);
    $requestObject = new JsonRequest($keywords, [], "");
    $jsonRequestObject = json_encode($requestObject);
    echo($jsonRequestObject);
}
