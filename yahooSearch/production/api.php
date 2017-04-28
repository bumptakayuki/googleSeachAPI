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
    $area = $query['area'];
    $searchCount = $query['searchCount'];

    $data = $googleSearch->search($keyword,$area,$searchCount);

} else if ($query['method'] === 'getComment') {
    $googleSearch = new GoogleSearch();
    $url = $query['url'];
    $data = $googleSearch->getChildResultList($url);

}

echo json_encode($data);