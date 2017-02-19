<?php
require_once('./CommentYoutube.php');
require_once('./MovieListYoutube.php');
require_once('./AnalysisKeyword.php');


header('Content-Type: application/json');

$query = $_POST['query'];
$data = [];

if ($query['method'] === 'getMovieList') {

    $movieListYoutube = new MovieListYoutube();
    $data = $movieListYoutube->getMovieList($query);


} else if ($query['method'] === 'getComment') {
    // youtubeのコメント情報を取得する
    $commentYoutube = new CommentYoutube();
    $data = $commentYoutube->getComment($query);
    $analysisKeyword = new AnalysisKeyword();
    $data = $analysisKeyword->analysisKeyword($data);
}

echo json_encode($data);