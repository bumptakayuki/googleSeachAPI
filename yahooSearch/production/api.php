<?php
require_once('./GoogleSearch.php');

header('Content-Type: application/json');

$query = $_POST['query'];
$data = [];

if ($query['method'] === 'search') {

    $googleSearch = new GoogleSearch();
    $keyword = $query['keyword'];
    $page = $query['page'];

    $data = $googleSearch->search($keyword,$page);

} else if ($query['method'] === 'bulkSearch') {

    $googleSearch = new GoogleSearch();
    $keyword = $query['keyword'];
    $page = $query['page'];

    $data = $googleSearch->search($keyword,$page);

}

echo json_encode($data);