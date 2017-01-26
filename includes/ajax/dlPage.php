<?php
/**
 * Created by IntelliJ IDEA.
 * User: Thomas
 * Date: 12/01/2017
 * Time: 15:08
 */
header('Content-Type: application/json');


include "../classes/simple_html_dom.php";



$url = getUrl($_POST['url']);
$index = $_POST['index'];

$response = new stdClass();

if(!empty($url)){
    $dom = file_get_contents($url);

    $html = new simple_html_dom($dom);

    /*
     * Nous renvoie des balises dans le inner text !
    $tags = ['h1','h2','h3','strong','title','meta[name=description]','meta[name=keywords]'];

    foreach ($tags as $tag){
        $response->$tag = array();
        foreach ($html->find($tag) as $item){
            array_push($response->$tag,$item->innerText());
        }
    }*/

    foreach ($html->find('script') as $script) $script->outertext = "";
    foreach ($html->find('img') as $img) $img->outertext = "";

    $file = $index.'.html';

    $wrote = file_put_contents('../tempFiles/'.$file,$html);

    $response->url = $url;
    $response->file = $file;
    if(!$wrote){
        http_response_code(500);
        $response->message = 'INTERNAL_SERVER_ERROR';
    }else{
        $response->message = 'PAGE_CORRECTLY_SAVED';
    }
    echo json_encode($response);    
}


function getUrl($url)
{
        $url = substr($url, 0, strpos($url, "&"));
        if (startWith($url, "/url?url=")) {
            $url = substr($url, strlen("/url?url="), strlen($url));
        } else if (startWith($url, "http://www.google.fr/url?url=")) {
            $url = substr($url, strlen("http://www.google.fr/url?url="), strlen($url));
        } else if (startWith($url, "http://www.google.com/url?url=")) {
            $url = substr($url, strlen("http://www.google.com/url?url="), strlen($url));
        } else if (startWith($url, "/search")) {
            return '';
        }
    return $url;
}

function startWith($str, $searched)
{
    $length = strlen($searched);
    return (substr($str, 0, $length) === $searched);
}