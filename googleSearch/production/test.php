<?php

require './build/TwistOAuth.phar';

$consumer_key = 'pEhDjQWuIDHMWu7YXyrkepdEA';
$consumer_secret = 'OgrDJG7DoknpVQWcdax60FywwPqUgqqTuZm4FZ1ExSSKx0HUek';
$access_token = '181519252-EkiHOttWSXARHxKbllOxxt51w2dUGgqZ4Kg0bwQd';
$access_token_secret = 'dzUzMiG0EhjahNEE7it41usnVWj1KErbpv5tVFeMUEQUe';

$connection = new TwistOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);

?>

<form action="test.php" method="post">
検索ワード<input type="text" name="keyword"/>
    <input type="submit">
</form>

<?php

$keyword = $_POST['keyword'];

// キーワードによるツイート検索
$tweets_params = ['q' => $keyword ,'count' => '100'];
$tweets = $connection->get('search/tweets', $tweets_params)->statuses;

// ハッシュタグによるツイート検索
$hash_params = ['q' => '#地震' ,'count' => '10', 'lang'=>'ja'];
$hash = $connection->get('search/tweets', $hash_params)->statuses;

$concatText = '';

foreach ($tweets as $value) {
    $text = htmlspecialchars($value->text, ENT_QUOTES, 'UTF-8', false);
    // 検索キーワードをマーキング
    $keywords = preg_split('/,|\sOR\s/', $tweets_params['q']); //配列化
    foreach ($keywords as $key) {
        $text = str_ireplace($key, '<span class="keyword">'.$key.'</span>', $text);
    }
    // ツイート表示のHTML生成
    disp_tweet($value, $text);
    $concatText .= $text;
}
$file = 'test.txt';
// ファイルをオープンして既存のコンテンツを取得します
$current = file_get_contents($file);
// 新しい人物をファイルに追加します
$current .= $concatText;
// 結果をファイルに書き出します
file_put_contents($file, $current);

function disp_tweet($value, $text){
    $icon_url = $value->user->profile_image_url;
    $screen_name = $value->user->screen_name;
    $updated = date('Y/m/d H:i', strtotime($value->created_at));
    $tweet_id = $value->id_str;
    $url = 'https://twitter.com/' . $screen_name . '/status/' . $tweet_id;

    echo '<div class="tweetbox">' . PHP_EOL;
    echo '<div class="thumb">' . '<img alt="" src="' . $icon_url . '">' . '</div>' . PHP_EOL;
    echo '<div class="meta"><a target="_blank" href="' . $url . '">' . $updated . '</a>' . '<br>@' . $screen_name .'</div>' . PHP_EOL;
    echo '<div class="tweet">' . $text . '</div>' . PHP_EOL;
    echo '</div>' . PHP_EOL;
}

// jumanのコマンドを実行、EOSを除去し改行で区切
// jumanのコマンドを実行
$output = shell_exec(sprintf('echo %s | /usr/local/bin/juman', escapeshellarg($concatText)));


var_dump($output);
?>