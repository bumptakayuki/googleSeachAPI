<?php
require_once('./GoogleSearch.php');

header('Content-Type: application/json');

$query = $_POST['query'];
$data = [];

if ($query['method'] === 'getMovieList') {

    $googleSearch = new GoogleSearch();
    $keyword = $query['keyword'];
    $data = $googleSearch->search($keyword);

} else if ($query['method'] === 'getComment') {
    $googleSearch = new GoogleSearch();
    $url = $query['url'];
    $data = $googleSearch->getChildResultList($url);

}

echo json_encode($data);