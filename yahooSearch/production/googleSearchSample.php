<?php
// 初期値設定
$search_query = "アダルト";
$api_key = "AIzaSyCCOgUAfRr-xzlH4Kw0fsJbJ3gPR_ipsCk";
$cx = "012050330613866307440:1qxsyovull4";

// 検索用URL
$tmp_url = "https://www.googleapis.com/customsearch/v1?";

// 検索パラメタ発行
$params_list = array('q'=>$search_query,'key'=>$api_key,'cx'=>$cx,'alt'=>'json','start'=>'1');

// リクエストパラメータ作成
$req_param = http_build_query($params_list);

// リクエスト本体作成
$request = $tmp_url.$req_param.'&hl=ja';

// jsonデータ取得
$json = file_get_contents($request,true);
$json_d = json_decode($json,true);

// urlを取得
for ($i=0; $i<10; $i++){
    $title = $json_d["items"][$i]["title"];
    echo "$title\n";
    $snippet = $json_d["items"][$i]["snippet"];
    echo "$snippet\n";
    $link = $json_d["items"][$i]["link"];
    echo "$link\n";
}
?>
