<?php

class CommentYoutube
{
    public function getComment($query)
    {
        // リクエストの設定情報を取得
        $options = $this->getRequestInfo();

        // 各情報を取得
        $resultList = [];
        $videoId = $query['videoId'];
        $resultList = $this->getCommentList($resultList, $videoId, $options);
        $resultList = $this->getVideoDetail($resultList, $videoId, $options);
        $resultList = $this->analysisComment($resultList, $options);
        $resultList = $this->judgeDateComment($resultList, $options);

        return $resultList;
    }


    /**
     * リクエストの設定内容を取得する
     */
    private function getRequestInfo()
    {
        $content = http_build_query([]);
        $content_length = strlen($content);
        $options = array('http' => array(
            'method' => 'GET',
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
                . "Content-Length: $content_length",
            'content' => $content));

        return $options;
    }

    /**
     * コメントの情報を取得する
     *
     * @param $data
     * @param $videoId
     * @param $options
     */
    private function getCommentList($data, $videoId, $options)
    {
        $resultParentList = [];
        $commentData = file_get_contents(
            'https://www.googleapis.com/youtube/v3/commentThreads?key=AIzaSyCCOgUAfRr-xzlH4Kw0fsJbJ3gPR_ipsCk&textFormat=plainText&part=snippet&maxResults=100&videoId=' . $videoId,
            false, stream_context_create($options));
        $resultList = json_decode($commentData);
        $resultParentList[] = $resultList;
        // １件以上あった場合
        if (count($resultList) > 0) {
            while (!empty($resultList->nextPageToken)) {
                $nextToken = $resultList->nextPageToken;
                $commentData = file_get_contents(
                    'https://www.googleapis.com/youtube/v3/commentThreads?key=AIzaSyCCOgUAfRr-xzlH4Kw0fsJbJ3gPR_ipsCk&textFormat=plainText&part=snippet&maxResults=100&videoId='
                    . $videoId . '&pageToken=' . $nextToken,
                    false, stream_context_create($options));

                $resultList = json_decode($commentData);
                // １件以上あった場合
                if (count($resultList) > 0) {

                    $resultParentList[] = $resultList;
                } else {
                    break;
                }
            }
        }


        $commentList = [];

        $count = 1;
        foreach ($resultParentList as $resultList) {

            foreach ($resultList->items as $result) {

                $date = $result->snippet->topLevelComment->snippet->publishedAt;
//            $date = new DateTime($date);
                $commentList[] = [
                    'commentId' => $count,
                    'date' => $date,
                    'authorDisplayName' => $result->snippet->topLevelComment->snippet->authorDisplayName,
                    'textDisplay' => $result->snippet->topLevelComment->snippet->textDisplay,
                    'likeCount' => $result->snippet->topLevelComment->snippet->likeCount,
                    'canRate' => $result->snippet->topLevelComment->snippet->canRate,
                    'viewerRating' => $result->snippet->topLevelComment->snippet->viewerRating,
                ];

                $count++;
            }
        }
        $data['commentList'] = $commentList;

        return $data;
    }

    /**
     * 動画単体の情報を取得する
     *
     * @param $data
     * @param $videoId
     * @param $options
     */
    private function getVideoDetail($data, $videoId, $options)
    {
        $videoDetail = file_get_contents(
            'https://www.googleapis.com/youtube/v3/videos?key=AIzaSyCCOgUAfRr-xzlH4Kw0fsJbJ3gPR_ipsCk&part=snippet,contentDetails,statistics,status&id=' . $videoId,
            false, stream_context_create($options));
        $resultList = json_decode($videoDetail);

        $data['title'] = $resultList->items[0]->snippet->title;
        $data['description'] = $resultList->items[0]->snippet->description;
        $data['thumbnails'] = $resultList->items[0]->snippet->thumbnails;

        return $data;
    }

    /**
     * コメントの解析情報を取得する
     *
     */
    private function analysisComment($data, $options)
    {
//        $txt='';
//        foreach($data['commentList'] as $comment){
//            $txt= $comment['textDisplay'];
//        }
//        $analysisComment = file_get_contents(
//            'https://watson-api-explorer.mybluemix.net/tone-analyzer/api/v3/tone?version=2016-05-19&text=' . $txt,
//            false, stream_context_create($options));
//
//        $resultList = json_decode($analysisComment);
//        $data['analysisComment'] = $resultList;

        $command = 'ruby http://ec2-52-88-160-219.us-west-2.compute.amazonaws.com/shashoku_collection_restaurant/shashoku_collection_restaurant/production/ruby/negapoji/test_negapoji.rb aaaa';
        exec ($command, $output);

//        die($output);
//        var_dump($output);
        $data['analysisComment'] = $output;
        return $data;

    }

    /**
     * コメントの解析情報を取得する
     *
     */
    private function judgeDateComment($data, $options)
    {
        $commentDateTimeList = [];

        foreach ($data['commentList'] as $commentList) {

            $commentDate = [];
            $date = preg_split("/T/", $commentList['date']);
            $commentDate['date'] = date('w', strtotime($date[0]));
            $time = preg_split("/:/", $date[1]);

            if (substr($time[0], 0, 1) == '0') {
                $time[0] = ltrim($time[0], '0');
                if ($time[0] == 0) {
                    $time[0] = 24;
                }
            }
            $commentDate['hour'] = $time[0];
//            $commentDate['value'] = 11;

            $commentDateTimeList[] = $commentDate;
        }

        $resultList = [];
        for ($i = 1; $i <= 7; $i++) {
            $resultDate['day'] = $i;

            for ($j = 1; $j <= 24; $j++) {
                $resultDate['hour'] = $j;
                $resultDate['value'] = 0;
                $resultList[] = $resultDate;
            }
        }

        $count = 0;
        foreach ($resultList as $result) {
            foreach ($commentDateTimeList as $commentDateTime) {
                if ($result['day'] == $commentDateTime['date']
                    && $result['hour'] == $commentDateTime['hour']
                ) {
                    $result['value']++;
                    $resultList[$count] = $result;
                }
            }
            $count++;
        }
        $data['commentDateTimeList'] = $resultList;
        return $data;
    }
}