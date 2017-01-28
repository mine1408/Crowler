<?php
/**
 * Created by IntelliJ IDEA.
 * User: Thomas
 * Date: 27/01/2017
 * Time: 00:37
 */
header('Content-Type: application/json');

$sites = $_POST['sites'];

$name = com_create_guid();

$wrote = file_put_contents('results/'.$name,json_encode($sites));


$response = new stdClass();

$response->file = $name;

echo json_encode($response);