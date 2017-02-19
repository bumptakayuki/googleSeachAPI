<?php

require './build/TwistOAuth.phar';

$consumer_key = 'pEhDjQWuIDHMWu7YXyrkepdEA';
$consumer_secret = 'OgrDJG7DoknpVQWcdax60FywwPqUgqqTuZm4FZ1ExSSKx0HUek';
$access_token = '181519252-EkiHOttWSXARHxKbllOxxt51w2dUGgqZ4Kg0bwQd';
$access_token_secret = 'dzUzMiG0EhjahNEE7it41usnVWj1KErbpv5tVFeMUEQUe';

$connection = new TwistOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>shashoku collection</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">

    <!-- 自分で独自に追加したスタイル -->
    <link href="../build/css/original.css" rel="stylesheet">


    <style>
        rect.bordered {
            stroke: #E6E6E6;
            stroke-width: 2px;
        }

        text.mono {
            font-size: 9pt;
            font-family: Consolas, courier;
            fill: #aaa;
        }

        text.axis-workweek {
            fill: #000;
        }

        text.axis-worktime {
            fill: #000;
        }

        svg {
            display: block;
            float: right;
        }

        d {
            display: block;
            float: right;
        }

        #spin-area {
            background-color: black;
        }
    </style>
    <script src="http://d3js.org/d3.v3.js"></script>

</head>

<body class="nav-md">

<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <div class="profile">
                        <div class="profile_pic">
                            <img src="images/IMG_1007.png" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>Takayuki Suzuki</h2>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <br/>

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <ul class="nav side-menu">
                            <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="index.html">Dashboard</a></li>
                                </ul>
                            </li>
                            <li><a><i class="fa fa-table"></i> ログ一覧 <span class="fa fa-chevron-down"></span></a>
                            </li>
                            <li><a><i class="fa fa-bar-chart-o"></i>分析<span class="fa fa-chevron-down"></span></a>
                            </li>
                            <li><a><i class="fa fa-clone"></i>ヘルプ<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="fixed_sidebar.html">クーポン承認方法</a></li>
                                    <li><a href="fixed_footer.html">Q&A</a></li>
                                    <li><a href="fixed_footer.html">お問い合わせ</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="Settings">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Logout">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav>

                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <!--<span class="header-logo-area"><img height="70" width="200" src="images/youTube.png"></span>-->
                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                               aria-expanded="false">
                                <img src="images/IMG_1007.png" alt="">Takayuki Suzuki
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li><a href="javascript:;"> Profile</a></li>
                                <li>
                                    <a href="javascript:;">
                                        <span class="badge bg-red pull-right">50%</span>
                                        <span>Settings</span>
                                    </a>
                                </li>
                                <li><a href="javascript:;">Help</a></li>
                                <li><a href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                            </ul>
                        </li>

                        <li role="presentation" class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown"
                               aria-expanded="false">
                                <i class="fa fa-envelope-o"></i>
                                <span class="badge bg-green">6</span>
                            </a>
                            <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                <li>
                                    <a>
                                        <span class="image"><img src="images/img.jpg" alt="Profile Image"/></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <span class="image"><img src="images/img.jpg" alt="Profile Image"/></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <span class="image"><img src="images/img.jpg" alt="Profile Image"/></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <span class="image"><img src="images/img.jpg" alt="Profile Image"/></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <div class="text-center">
                                        <a>
                                            <strong>See All Alerts</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->

        <div class="clearfix"></div>

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">

                <div class="title_left">
                    <h3>twitter解析 管理画面</h3>
                </div>
                <form action="twitterAnalyse.php" method="post">
                    検索ワード<input type="text" name="keyword"/>
                    <button type="submit" id="search" class="btn btn-primary">検索</button>
                </form>
<!--                キーワード:-->
<!--                <input type="text" style="width: 300px; display: inline " id="keyword" class="form-control">-->

                <!--<button type="button" class="btn btn-success getComment">実行</button>-->
                <div id="spin-area"></div>

                <!-- TODO -->
                <div id="main-area">

                    <?php

                    $keyword = $_POST['keyword'];

//                    var_dump($keyword);

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


                       echo '<div class="col-md-4 col-sm-6 col-xs-12">';
                        echo '<div class="x_panel fixed_height_320">';
                                echo '<div class="x_title">';
                       echo '<div class="thumb">' . '<img alt="" src="' . $icon_url . '">' . '</div>' . PHP_EOL;
                        echo '<span style="float: right">tweet情報</span>';
                                    echo '<div class="clearfix"></div>';
                                echo '</div>';
                                echo '<div class="x_content">';
                        echo '<div class="meta"><a target="_blank" href="' . $url . '">' . $updated . '</a>' . '<br>@' . $screen_name .'</div>' . PHP_EOL;
                        echo '<div class="tweet">' . $text . '</div>' . PHP_EOL;
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';


                    }
                    echo '<br>';
                    echo '<br>';
                    echo '<br>';
                    echo '<br>';
                    echo '<br>';
                    echo '<br>';


                    // jumanのコマンドを実行、EOSを除去し改行で区切
                    // jumanのコマンドを実行
//                    $outputs = shell_exec(sprintf('echo %s | /usr/local/bin/juman', escapeshellarg($concatText)));

                    var_dump($concatText);
                    die();
                    $outputs = array_reverse(preg_split("/EOS|\n/u", shell_exec(sprintf('echo %s | /usr/local/bin/juman', escapeshellarg($concatText)))));
                    echo '<pre style="clear: both">';
//                    foreach($outputs as $output){
//                        var_dump($output);
//                    }

                    foreach($outputs as $output){
                        var_dump($output);
                    }


                    echo '</pre>';
                    ?>

                    <div id="search-area">


                    </div>
                    <div id="comment-area" style="overflow: auto; height: 400px"></div>
                    <div class="clearfix"></div>
                    <div class='col-md-12 col-sm-12 col-xs-12'>
                        <div class='x_panel tile fixed_height_350 overflow_hidden'>
                            <div id='analytics-area'>
                                <!--<svg></svg>-->
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class='col-md-12 col-sm-12 col-xs-12'>
                        <div class='x_panel tile fixed_height_350 overflow_hidden'>
                        <div id="chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

    </div>
</div>
<!-- /page content -->

<!-- footer content -->
<footer>
    <div class="pull-right">
        Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->
</div>
</div>

<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="../vendors/nprogress/nprogress.js"></script>
<!-- bootstrap-progressbar -->
<script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>

<!-- Flot -->
<script src="../vendors/Flot/jquery.flot.js"></script>
<script src="../vendors/Flot/jquery.flot.pie.js"></script>
<script src="../vendors/Flot/jquery.flot.time.js"></script>
<script src="../vendors/Flot/jquery.flot.stack.js"></script>
<script src="../vendors/Flot/jquery.flot.resize.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>


<!-- Flot -->
<script src="../vendors/Flot/jquery.flot.js"></script>
<script src="../vendors/Flot/jquery.flot.pie.js"></script>
<script src="../vendors/Flot/jquery.flot.time.js"></script>
<script src="../vendors/Flot/jquery.flot.stack.js"></script>
<script src="../vendors/Flot/jquery.flot.resize.js"></script>
<!-- Flot plugins -->
<script src="../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
<script src="../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
<script src="../vendors/flot.curvedlines/curvedLines.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>

<script src="./js/d3.layout.cloud.js"></script>
<script src="./js/spin.min.js"></script>
<script src="./js/heatMap.js"></script>
<script src="./js/movieList.js"></script>


</body>
</html>


