<?php
require_once '../simple_html_dom.php';
require_once './GoogleAnalysisKeyword.php';
require_once "./phpQuery-onefile.php";

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
    public function search($keyword, $page)
    {

        ini_set('memory_limit', '512M');

        $resultList = [];

        //文字化け対策
        mb_language('Japanese');

        //検索アドレスと件数の指定
        $urlStr = 'http://chiebukuro.search.yahoo.co.jp/search?p=' . $keyword;


        $content = http_build_query([]);
        $content_length = strlen($content);

        $doc = phpQuery::newDocumentFile('http://chiebukuro.search.yahoo.co.jp/search?p=' . $keyword.'&b='.$page);

//        $page = 10;
//        $hrefList = [];
//        for ($i = 0; $i <= 2; $i++) {
//            $tempPage = $page * $i +1;
//            $href = 'http://chiebukuro.search.yahoo.co.jp/search?p=' . $keyword.'&b=' . $tempPage;
//            $hrefList[$i] = $href;
//        }


        $questionList = [];
//        foreach ($hrefList as $page => $href) {
//            $doc = phpQuery::newDocumentFile($href);

            foreach ($doc[".KSsin"] as $val) {
                // 連続実行すると怒られちゃうのでとりあえず5秒待機
                sleep(1);
                $href = pq($val)->find('a')->attr('href');
                $hrefList[] = $href;
                // pq()メソッドでオブジェクトとして再設定しつつさらに下ってhrefを取得
            }


            //検索にひっかかった、URLの数だけ繰り返す
            foreach ($hrefList as $href) {

                $doc = phpQuery::newDocumentFile($href);

                $questionText = $doc['.mdPstd.mdPstdQstn.sttsRslvd.clrfx']->find('p')->text();
                if (empty($questionText)) {
                    continue;
                }
                $excludeList = ['シェア', 'ツイート', 'はてブ', '知恵コレ', '違反報告'];

                foreach ($excludeList as $exclude) {
                    $questionText = preg_replace('/' . $exclude . '/', '', $questionText);
                }

                $questionText = preg_replace("/( |　)/", "", $questionText);
                // 改行、タブをスペースへ
                $questionText = preg_replace('/[\n\r\t]/', '', $questionText);
                // 複数スペースを一つへ
                $questionText = preg_replace('/\s(?=\s)/', '', $questionText);

                $questionList[] = $questionText;
            }
//            if($page == 5){
//                break;
//            }
//        }
        $resultList['questionList'] = $questionList;
        $resultList['searchKeyword'] = $keyword;

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

            $linka = [];
            $links = [];

            $linkList = [];

            foreach ($html->find('a') as $el) {
                $linka[md5($el->href)]++;
                $links[md5($el->href)] = $el->href;
                $linkList[] = $el->href;
            }
            arsort($linka);

            $outLickCount = 1;
            $innerLickCount = 1;

            foreach ($linka as $k => $n) {
//                echo("<li>{$links[$k]} [{$n}リンク]</li>");
                if (preg_match('/^http[s]{0,1}:\/\//', $links[$k], $matches)) {

                    $link = $matches[1];


//                    die();

                    $outLickCount++;
                } else {
                    $innerLickCount++;
                }
            }
            $resultChildList['outLickCount'] = $outLickCount;
            $resultChildList['innerLickCount'] = $innerLickCount;
            $resultChildList['linkList'] = $linkList;

            $body = $html->find("body");
            $googleAnalysisKeyword = new GoogleAnalysisKeyword();
            if (!empty($body)) {
                $wordList = $googleAnalysisKeyword->analysisKeyword($body[0]->plaintext);
                $resultChildList['wordLength'] = strlen($body[0]->plaintext);
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

