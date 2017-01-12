<?php
require_once '../simple_html_dom.php';
require_once './GoogleAnalysisKeyword.php';

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
    public function search($keyword,$area)
    {
        //文字化け対策
        mb_language('Japanese');

        //検索アドレスと件数の指定
        $urlStr = 'http://www.google.co.jp/search?num=7&ie=UTF-8&q=' . urlencode($keyword).'&uule='.$area;

        //URLからDOMを取得
        $html = file_get_html($urlStr);

        //検索結果のタイトル部分
        $searchList = $this->getResultList($html);

        $resultList['totalCount'] = $searchList['totalCount'];
        unset($searchList['totalCount']);
        $resultList['searchList'] = $searchList;
        $resultList['searchKeyword'] = $keyword;

        return $resultList;
    }

    /**
     * 結果リストを取得する
     *
     * @param $html
     * @return $titleList
     */
    private function getResultList($html)
    {
        $resultList = [];
        $i = 0;
        $resultCount = $html->find('div[id=resultStats]');
        $resultList['totalCount'] = mb_convert_encoding($resultCount[0]->outertext, "UTF-8", "SJIS");
//        $address = $html->find('div[id=footcnt]');
//        var_dump($address);
//        die();
        $linkObjs = $html->find('h3.r a');
        foreach ($linkObjs as $linkObj) {
            $result = [];
            $title = trim($linkObj->plaintext);
            $link = trim($linkObj->href);

            // if it is not a direct link but url reference found inside it, then extract
            if (!preg_match('/^https?/', $link) && preg_match('/q=(.+)&amp;sa=/U', $link, $matches) && preg_match('/^https?/', $matches[1])) {
                $link = $matches[1];
            } else if (!preg_match('/^https?/', $link)) { // skip if it is not a valid link
                continue;
            }

            $descr = $html->find('span.st', $i); // description is not a child element of H3 thereforce we use a counter and recheck.

            $result['title'] = mb_convert_encoding($title, "UTF-8", "SJIS");
            $result['url'] = urldecode($link);
            $result['description'] = mb_convert_encoding($descr->plaintext, "UTF-8", "SJIS");

            $resultChildList = $this->getChildResultList(urldecode($link));
            $result['childList'] = $resultChildList;
            $result['rank'] = $i + 1;

            $resultList[] = $result;

            $i++;
        }

        return $resultList;
    }

    /**
     * 結果リストを取得する
     *
     * @param $html
     * @return $titleList
     */
    public function getChildResultList($link)
    {
        $resultChildList = [];
        //URLからDOMを取得
        $html = file_get_html($link);

        if ($html) {
            $keywords = $html->find("meta[name=keywords]");

            $resultChildList['keywords'] = $keywords[0]->content;

            $description = $html->find("meta[name=description]");
            $resultChildList['description'] = $description[0]->content;

            $linka = array();
            $links = array();
            foreach ($html->find('a') as $el) {
                $linka[md5($el->href)]++;
                $links[md5($el->href)] = $el->href;
            }
            arsort($linka);

            $outLickCount = 1;
            $innerLickCount = 1;

            foreach ($linka as $k => $n) {
//                echo("<li>{$links[$k]} [{$n}リンク]</li>");
                if (preg_match('/^http[s]{0,1}:\/\//', $links[$k], $matches)) {

                    $link = $matches[1];

                    $outLickCount++;
                } else {
                    $innerLickCount++;
                }
            }
            $resultChildList['outLickCount'] = $outLickCount;
            $resultChildList['innerLickCount'] = $innerLickCount;

            $body = $html->find("body");
            $googleAnalysisKeyword = new GoogleAnalysisKeyword();
            if (!empty($body)) {
                $wordList = $googleAnalysisKeyword->analysisKeyword($body[0]->plaintext);
                $resultChildList['wordList'] = $wordList;
                $resultChildList['rank1'] = $wordList[1];
                $resultChildList['rank2'] = $wordList[0];
                $resultChildList['rank3'] = $wordList[2];

            }

        } else {
//            echo '失敗';
        }

        return $resultChildList;
    }
}

