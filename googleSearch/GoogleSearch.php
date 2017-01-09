<?php

// 開始ログ
echo "start... \r\n";

// 為替データ取得処理を呼び出す。
getRate();

// 終了ログ
echo "...end \r\n";

/**
 * 為替データ取得
 **/
function getRate(){

    // phpQueryをロードする
    require_once("phpQuery-onefile.php");	// ・・・①

    // htmlを取得する
//    $html = file_get_contents("http://www.x-rates.com/table/?from=USD&amount=1");	// ・・・②
//検索キーワードの指定
    $keyword = 'ザク　３倍';

//検索アドレスと件数の指定
    $urlStr = 'http://www.google.co.jp/search?num=10&q=' . urlencode($keyword);
    $html = file_get_html($urlStr);

    // dom解析用のオブジェクトを生成する
    $doc = phpQuery::newDocument($html);	// ・・・③

    //要素取得
//    echo $doc["title"]->text();
    var_dump($doc);
    die();
    // domを解析し、必要なデータを取得する。
    echo $doc[".OutputHeader"]->text() ."\r\n";	// ・・・④

    foreach($doc["tbody"][".rtRates"]->find("a") as $tmp){	// ・・・⑤

        $a = pq($tmp);	// ・・・⑥

        // 属性を取得する。
        $attr = $a->attr("href");	// ・・・⑦

        // 不要文字列の削除
        $fromto =  str_replace("&to=",",",str_replace("/graph/?from=","",$attr));
        $val = $a->text() ."\r\n";

        // 結果をCSV形式でコンソール出力する
        echo $fromto.",".$val;

    }

}