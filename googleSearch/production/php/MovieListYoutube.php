<?php

class MovieListYoutube
{
    public function getMovieList($query)
    {
        // 接続に必要な定義を設定
        $keyword = $query['keyword'];
        $content = http_build_query([]);
        $content_length = strlen($content);
        $options = array('http' => array(
            'method' => 'GET',
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
                . "Content-Length: $content_length",
            'content' => $content));

        // リクエストを送る
        $data = file_get_contents(
            'https://www.googleapis.com/youtube/v3/search?key=AIzaSyCCOgUAfRr-xzlH4Kw0fsJbJ3gPR_ipsCk&part=id,snippet&maxResults=10&q='.$keyword,
            false, stream_context_create($options));
        $resultList = json_decode($data);
        $data = [];
        $movieList = [];

        $count = 1;
        foreach ($resultList->items as $result) {

            $movieList[] = [
                'videoId' => $result->id->videoId,
                'title' => $result->snippet->title,
                'description' => $result->snippet->description,
                'thumbnails' => $result->snippet->thumbnails,
            ];
            $count++;
        }

        $data['totalCount'] = $resultList->pageInfo->totalResults;
        $data['perPage'] = $resultList->pageInfo->resultsPerPage;
        $data['movieList'] = $movieList;

        return $data;
    }
}