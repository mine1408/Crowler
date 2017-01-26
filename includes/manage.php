<?php
/**
 * Created by IntelliJ IDEA.
 * User: hdelo
 * Date: 03/11/2016
 * Time: 09:55
 */

function getColors(){
    return [
        ["rgba(0,201,182, 0.8)","rgba(0,201,182, 0.0)"],
        ["rgba(0,227,205, 0.8)","rgba(0,227,205, 0.0)"],
        ["rgba(0,176,159, 0.8)","rgba(0,176,159, 0.0)"],
        ["rgba(0,150,136, 0.8)","rgba(0,150,136, 0.0)"],
        ["rgba(0,125,113, 0.8)","rgba(0,125,113, 0.0 )"],
        ["rgba(0,74,67, 0.8)","rgba(0,74,67, 0.0)"],
        ["rgba(0,99,90, 0.8)","rgba(0,99,90, 0.0)"]
    ];
};

function getBalises(){
    return ["title", "meta", "h1", "h2", "h3", "h4", "strong", "page"];
};

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
