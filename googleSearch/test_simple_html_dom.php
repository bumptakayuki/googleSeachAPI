
<form action="test_simple_html_dom.php" method="post">
    検索ワード<input type="text" name="keyword"/>
    <button type="submit" id="search" class="btn btn-primary">検索</button>
    <button type="submit" id="search" class="btn btn-success">CSVダウンロード</button>
</form>
<?php

$keyword = $_POST['keyword'];

//手順①にてダウンロードしたphpファイルを指定
require_once './simple_html_dom.php';

//文字化け対策
mb_language('Japanese');

//検索キーワードの指定
//$keyword = '鈴木　議員';

//検索アドレスと件数の指定
$urlStr = 'http://www.google.co.jp/search?num=10&q=' . urlencode($keyword);

//URLからDOMを取得
$html = file_get_html($urlStr);

//検索結果のタイトル部分の抜き出しと表示
$titleList = [];
foreach ($html->find('div[class=g] h3[class=r] a') as $e) {
    $title = preg_replace('/<a href=(.+?)>/', '', mb_convert_encoding($e->outertext, "UTF-8", "SJIS"));
    $title = preg_replace('/<b>|<\/b>|<\/a>|<h3 class="r">/', '', $title);
    $title = preg_replace('/<\/h3>/', '<br />', $title);

    $titleList[]=$title;
}

for($i = 0; $i < count($titleList); $i++){
    if(preg_match('/画像検索結果/',$titleList[$i], $matches, PREG_OFFSET_CAPTURE)){
        unset($titleList[$i]);
        //indexを詰める
        $titleList = array_values($titleList);
    }
}

$urlList = [];

foreach ($html->find('div[class=g] div[class=s] cite') as $e) {
    $url = preg_replace('/<cite>/', '', mb_convert_encoding($e->outertext, "UTF-8", "SJIS"));
    $urlList[] = $url;
}

$descriptionList = [];

foreach ($html->find('div[class=g] div[class=s] span[class=st]') as $e) {
    $description = mb_convert_encoding($e->outertext, "UTF-8", "SJIS");
    $descriptionList[] = $description;
}

$totalCount = 1;

for($i = 0; $i < count($titleList); $i++){
    echo '(' . $totalCount . ') ' . $titleList[$i].'<br>';;
    echo  $descriptionList[$i].'<br>';
    echo  $urlList[$i].'<br>';

    $totalCount++;
}
?>