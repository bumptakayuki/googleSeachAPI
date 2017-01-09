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
                    <h3>Google解析 管理画面</h3>
                </div>
                <form action="inputGoogleSearch.php" method="post">
                    検索ワード<input type="text" name="keyword"/>
                    <input type="hidden" name="type" value="search"/>
                    <button type="submit" id="search" class="btn btn-primary">検索</button>
                </form>
                <form action="inputGoogleSearch.php" method="post">
                    検索ワード<input type="text" name="keyword"/>
                    <input type="hidden" name="type" value="csv"/>
                    <button type="submit" id="search" class="btn btn-success">CSVダウンロード</button>
                </form>

                <!--                キーワード:-->
                <!--                <input type="text" style="width: 300px; display: inline " id="keyword" class="form-control">-->

                <!--<button type="button" class="btn btn-success getComment">実行</button>-->

                <div id="main-area">

                    <?php
                    require_once(dirname(__FILE__) . '/GoogleSearch.php');

                    if ($_POST['type'] == 'search') {
                        $googleSearch = new GoogleSearch();
                        $keyword = $_POST['keyword'];
                        $resultList = $googleSearch->search($keyword);

                        echo '<div id="spin-area"></div>';
                        echo '<div class="row top_tiles">';
                        echo '<div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">';
                        echo '<div class="tile-stats">';
                        echo '<div class="icon"><i class="fa fa-caret-square-o-right"></i></div>';
                        echo '<div class="count">'.$resultList['totalCount'].'</div>';
                        echo '<h3>検索結果件数</h3>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';

                        //検索結果の出力
                        $totalCount = 1;
                        for ($i = 0; $i < count($resultList['titleList']); $i++) {
                            echo '<h3>(' . $totalCount . ') ' . $resultList['titleList'][$i] . '</h3>';

                            echo '<p>' . $resultList['descriptionList'][$i] . '</p>';
                            echo '<a href="' . $resultList['urlList'][$i] . '">' . $resultList['urlList'][$i]. '</a>';

                            echo '<table border="1" class="table table-striped">';
                            echo '<thead class="thead-inverse">';
                            echo '<tr bgcolor="#deefff"><th>キーワード</th><th>ディスクリプション</th><th>外部リンク</th><th>内部リンク</th></tr>';
                            echo '</thead>';
                            echo '<tbody>';
                            echo '<tr>';
                            echo '<td>' .$resultList['childList'][$i]['keywords']. '</td>';
                            echo '<td>' .$resultList['childList'][$i]['description']. '</td>';
                            echo '<td>' .$resultList['childList'][$i]['outLickCount']. '</td>';
                            echo '<td>' .$resultList['childList'][$i]['innerLickCount']. '</td>';
                            echo '</tr>';
                            echo '</tbody>';
                            echo '</table>';
                            $totalCount++;
                        }

                    } elseif ($_POST['type'] == 'csv') {
                        $googleSearch = new GoogleSearch();
                        $keyword = $_POST['keyword'];
                        $resultList = $googleSearch->search($keyword);

                        try {

                            //CSV形式で情報をファイルに出力のための準備
                            $csvFileName = time() . rand() . '.csv';
                            $res = fopen($csvFileName, 'w');
                            if ($res === FALSE) {
                                throw new Exception('ファイルの書き込みに失敗しました。');
                            }

                            // データ一覧。この部分を引数とか動的に渡すようにしましょう
                            $dataList = [
                                ['タイトル', '説明', 'URL']
                            ];
                            for ($i = 0; $i < count($resultList['titleList']); $i++) {
                                $dataList[] = [
                                    $resultList['titleList'][$i],
                                    $resultList['descriptionList'][$i],
                                    $resultList['urlList'][$i]
                                ];
                            }

                            // ループしながら出力
                            foreach ($dataList as $dataInfo) {

                                // 文字コード変換。エクセルで開けるようにする
                                mb_convert_variables('SJIS', 'UTF-8', $dataInfo);

                                // ファイルに書き出しをする
                                fputcsv($res, $dataInfo);
                            }

                            // ハンドル閉じる
                            fclose($res);

                            // ダウンロード開始
                            header('Content-Type: application/octet-stream');

                            // ここで渡されるファイルがダウンロード時のファイル名になる
                            header('Content-Disposition: attachment; filename=sampaleCsv.csv');
                            header('Content-Transfer-Encoding: binary');
                            header('Content-Length: ' . filesize($csvFileName));
                            readfile($csvFileName);


                        } catch (Exception $e) {

                            // 例外処理をここに書きます
                            echo $e->getMessage();

                        }

                    }
                    ?>

                    <div id="search-area">


                    </div>
                    <div id="comment-area" style="overflow: auto; height: 400px"></div>

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


