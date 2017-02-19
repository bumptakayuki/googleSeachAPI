<?php
require_once '../simple_html_dom.php';

/**
 * Google検索を行うクラス
 *
 */
class GoogleSearch
{
    /**
     * 検索を実行する
     *
     * @param $keyword
     * @return $resultList
     */
    public function search($keyword)
    {
        //文字化け対策
        mb_language('Japanese');

        //検索アドレスと件数の指定
        $urlStr = 'http://www.google.co.jp/search?num=20&ie=UTF-8&q=' . urlencode($keyword);

        //URLからDOMを取得
        $html = file_get_html($urlStr);

        //検索結果のタイトル部分
        $resultList = $this->getTitle($html);

        //検索結果のURL部分
//        $urlList =$this->getUrl($html);
//
//        //検索結果の説明部分
//        $descriptionList = $this->getDescription($html);
//
//        $resultList = [];
//        $resultList['titleList'] = $titleList;
//        $resultList['urlList'] = $urlList;
//        $resultList['descriptionList'] = $descriptionList;

        return $resultList;
    }

    /**
     * タイトルを取得する
     *
     * @param $html
     * @return $titleList
     */
    private function getTitle($html)
    {
        $titleList = [];
        $resultList = [];
        $i=0;
        $resultCount =$html->find('div[id=resultStats]');
        foreach($resultCount as $result){
            echo('<h4><検索結果件数>'.mb_convert_encoding($result->outertext, "UTF-8", "SJIS").'</h4>');
        }

        $linkObjs = $html->find('h3.r a');
        foreach ($linkObjs as $linkObj) {
            $title = trim($linkObj->plaintext);
            $link  = trim($linkObj->href);

            // if it is not a direct link but url reference found inside it, then extract
            if (!preg_match('/^https?/', $link) && preg_match('/q=(.+)&amp;sa=/U', $link, $matches) && preg_match('/^https?/', $matches[1])) {
                $link = $matches[1];
            } else if (!preg_match('/^https?/', $link)) { // skip if it is not a valid link
                continue;
            }

            $descr = $html->find('span.st',$i); // description is not a child element of H3 thereforce we use a counter and recheck.
            $i++;
            $resultList['titleList'][] = mb_convert_encoding($title, "UTF-8", "SJIS");
            $resultList['urlList'][] = urldecode($link);
            $resultList['descriptionList'][] = mb_convert_encoding($descr->plaintext, "UTF-8", "SJIS");
        }

//
//        foreach ($html->find('div[class=g] h3[class=r] a') as $e) {
////            $url = $e->href;
//            $url = $e->{'data-href'};
//            $e->getAttribute("data-href");
////            var_dump( $e->getAttribute("data-href"));
//            $urlList[] = $url;
//            $title = preg_replace('/<a href=(.+?)>/', '', mb_convert_encoding($e->outertext, "UTF-8", "SJIS"));
//            $title = preg_replace('/<b>|<\/b>|<\/a>|<h3 class="r">/', '', $title);
//            $title = preg_replace('/<\/h3>/', '<br />', $title);
//
//            $titleList[] = $title;
//        }
//        for ($i = 0; $i < count($titleList); $i++) {
//            if (preg_match('/画像検索結果/', $titleList[$i], $matches, PREG_OFFSET_CAPTURE)) {
//                unset($titleList[$i]);
//                //indexを詰める
//                $titleList = array_values($titleList);
//            }
//        }
        return $resultList;
    }

    /**
     * 説明を取得する
     *
     * @param $html
     * @return $descriptionList
     */
    private function getDescription($html)
    {
        $descriptionList = [];
        foreach ($html->find('div[class=g] div[class=s] span[class=st]') as $e) {
            $description = mb_convert_encoding($e->outertext, "UTF-8", "SJIS");
            $descriptionList[] = $description;
        }
        return $descriptionList;
    }

    /**
     * URLを取得する
     *
     * @param $html
     * @return $urlList
     */
    private function getUrl($html)
    {
        $urlList = [];
        foreach ($html->find('div[class=g] div[class=s] cite') as $e) {
            $url = preg_replace('/<cite>/', '', mb_convert_encoding($e->outertext, "UTF-8", "SJIS"));
            $urlList[] = $url;
        }
        return $urlList;
    }
}

