$(function () {

    var data;

    function handleFileSelect(evt) {
        var file = evt.target.files[0];

        Papa.parse(file, {
            header: true,
            dynamicTyping: true,
            complete: function(results) {

                var keywordList = [];
                _.each(results.data, function(obj) {
                    keywordList.push(obj.keyword);
                 });

                window.keywordList = keywordList;

                // テンプレートを定義
                var compiled = _.template(
                    "<table id='datatable' class='table table-striped table-bordered dataTable no-footer'>"
                    + "<thead>"
                    + "<tr role='row' bgColor='gray' style='color: white'>"
                    + "<th>No.</th><th>検索キーワード</th>"
                    + "</tr>"
                    + "</thead>"
                    + "<% _.each(data, function(obj,i) { %>"
                    + "<tr>"
                    + " <td width='140'><%= i+1 %> </td>"
                    + " <td width='140'><%= obj.keyword %> </td>"
                    + "</tr>"
                    + "<% }); %>"
                    + "<table>"
                );

                $("#keyword-list").html(compiled({data: results.data}));
            }
        });
    }

    $(document).ready(function(){
        $("#csv-file").change(handleFileSelect);
    });


    $('#download').click(function () {

            var bom = new Uint8Array([0xEF, 0xBB, 0xBF]);

            // (2) CSV データの用意
            var csv_data =
                window.resultList
                    .map(function (l) {
                return l.join(',')
            }).join('\r\n');

            var blob = new Blob([bom, csv_data], {"type": "text/csv"});

            if (window.navigator.msSaveBlob) {
                window.navigator.msSaveBlob(blob, "test.csv");

                // msSaveOrOpenBlobの場合はファイルを保存せずに開ける
                window.navigator.msSaveOrOpenBlob(blob, "test.csv");
            } else {
                document.getElementById("download").href = window.URL.createObjectURL(blob);
            }
    });

    $('#format-download').click(function () {

        var bom = new Uint8Array([0xEF, 0xBB, 0xBF]);

        // (2) CSV データの用意
        var csv_data =
            [
                ['No','keyword'],
                ['1','日本'],
                ['2','中国'],
                ['3','テレビ'],
                ['4','美容'],
                ['5','エステ'],
                ['6','脱毛'],
                ['7','サロン'],
                ['8','映画'],
                ['9','祭り'],
                ['10','観光']
            ]
                .map(function (l) {
                    return l.join(',')
                }).join('\r\n');

        var blob = new Blob([bom, csv_data], {"type": "text/csv"});

        if (window.navigator.msSaveBlob) {
            window.navigator.msSaveBlob(blob, "keyword_format.csv");

            // msSaveOrOpenBlobの場合はファイルを保存せずに開ける
            window.navigator.msSaveOrOpenBlob(blob, "keyword_format.csv");
        } else {
            document.getElementById("format-download").href = window.URL.createObjectURL(blob);
        }
    });


    $('#search').click(function () {

        var query = {
            keyword: $('#keyword').val(),
            area: $('#area').val(),
            searchCount: $('#searchCount').val(),
            method: 'search'
        };
        window.resultList=[];
        executeSearch(query);
    });

    $('#bulk-search').click(function () {


        window.resultList=[];

        var query = {
            //keyword: $('#keyword').val(),
            area: $('#area').val(),
            searchCount: $('#searchCount').val(),
            method: 'bulkSearch'
        };

        _.each(window.keywordList, function(keyword) {
            query.keyword=keyword;
            executeSearch(query);
        });

    });

    var createKeyword = function (csvFile, response) {

        d3.csv(csvFile,
            function (data) {
                $("#analytics-area").append(
                    "<div class='x_title'>"
                    + "<h1>コメント出現可視化</h1>"
                    + "<div class='clearfix'></div>"
                    + "</div>");
                d3.select("#analytics-area").append("svg");
                data = response['wordList'];
                console.log(data);
                var data = Object.keys(data).map(function (key) {
                    return data[key]
                });


                var h = 800;
                var w = 1000;
                data = data.splice(0, 1200); //処理wordを1200件に絞る

                var random = d3.random.irwinHall(2)

                var countMax = d3.max(data, function (d) {
                    return d.count
                });
                var sizeScale = d3.scale.linear().domain([0, countMax]).range([10, 100])
                var colorScale = d3.scale.category20();

                var words = data.map(function (d) {
                    return {
                        text: d.word,
                        size: sizeScale(d.count) //頻出カウントを文字サイズに反映
                    };
                });

                d3.layout.cloud().size([w, h])
                    .words(words)
                    .rotate(function () {
                        return Math.round(1 - random()) * 90;
                    }) //ランダムに文字を90度回転
                    .font("Impact")
                    .fontSize(function (d) {
                        return d.size;
                    })
                    .on("end", draw) //描画関数の読み込み
                    .start();

                //wordcloud 描画
                function draw(words) {
                    d3.select("svg")
                        .attr({
                            "width": w,
                            "height": h
                        })
                        .append("g")
                        .attr("transform", "translate(500,400)")
                        .selectAll("text")
                        .data(words)
                        .enter()
                        .append("text")
                        .style({
                            "font-family": "Impact",
                            "font-size": function (d) {
                                return d.size + "px";
                            },
                            "fill": function (d, i) {
                                return colorScale(i);
                            }
                        })
                        .attr({
                            "text-anchor": "middle",
                            "transform": function (d) {
                                return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
                            }
                        })
                        .text(function (d) {
                            return d.text;
                        });
                }

            });
    }

    var executeSearch = function (query) {

        $.ajax({
                url: '/googleSeachAPI/googleSearch/production/api.php',
                type: 'post', // getかpostを指定(デフォルトは前者)
                dataType: 'json', // 「json」を指定するとresponseがJSONとしてパースされたオブジェクトになる
                data: { // 送信データを指定(getの場合は自動的にurlの後ろにクエリとして付加される)
                    query: query
                }
            })
            // ・ステータスコードは正常で、dataTypeで定義したようにパース出来たとき
            .done(function (response) {

                window.resultList.push(['検索キーワード','順位','見出し','URL']);
                _.each(response.searchList, function (elm, i) {
                    window.resultList.push([response.searchKeyword,elm.rank, elm.title, elm.url]);
                });

                $('#chart').empty();
                $('#comment-area').empty();
                $("#analytics-area").empty();

                // テンプレートを定義
                var compiled = _.template(
                    "<div class='row tile_count'><div class='col-md-6 col-sm-6 col-xs-6 tile_stats_count'> <span class='count_top'><i class='fa fa-user'></i> Total Count</span> "
                    + "<div class='count'><%= response.totalCount %></div>"
                    + "<span class='count_bottom'> </div> <div class='col-md-2 col-sm-4 col-xs-6 tile_stats_count'>"
                    + "<span class='count_bottom'></div>"
                    + "<div class='clearfix'></div>"

                    + "<table id='datatable' class='table table-striped table-bordered dataTable no-footer'>"
                    + "<thead>"
                    + "<tr role='row' bgColor='gray' style='color: white'>"
                    + "<th>検索キーワード</th><th>順位</th><th>タイトル</th><th>説明</th><th>URL</th>"
                    + "</tr>"
                    + "</thead>"
                    + "<% _.each(response.searchList, function(searchResult) { %>"
                    + "<tr>"
                    + " <td width='140'><%= response.searchKeyword %> </td>"
                    + " <td><%= searchResult.rank %> </td>"
                    + " <td><%= searchResult.title %> </td>"
                    + " <td><%= searchResult.description %> </td>"
                    + " <td><%= searchResult.url %> </td>"
                    + "</tr>"
                    + "<% }); %>"
                    + "<table>"
                );

                $("#search-area").append(compiled({response: response}));


                $('.getComment').click(function (data) {
                    getComment($(data.currentTarget).val());
                });

            })
            // ・サーバからステータスコード400以上が返ってきたとき
            // ・ステータスコードは正常だが、dataTypeで定義したようにパース出来なかったとき
            // ・通信に失敗したとき
            .fail(function (response) {
                console.log(response);
            });
    }

    var getComment = function (url) {

        d3.tsv(url,
            function (error, data) {

                console.log(url);
                var query = {
                    url: url,
                    method: 'getComment'
                };

                // Ajax通信を開始する
                $.ajax({
                        url: '/googleSeachAPI/googleSearch/production/api.php',
                        type: 'post', // getかpostを指定(デフォルトは前者)
                        dataType: 'json', // 「json」を指定するとresponseがJSONとしてパースされたオブジェクトになる
                        data: { // 送信データを指定(getの場合は自動的にurlの後ろにクエリとして付加される)
                            query: query
                        }
                    })
                    // ・ステータスコードは正常で、dataTypeで定義したようにパース出来たとき
                    .done(function (response) {
                        console.log(response);

                        //$('#chart').empty();
                        $('#comment-area').empty();
                        $('#search-area').empty();

                        // テンプレートを定義
                        var compiled = _.template(
                            "<h1><%= response.keywords %></h1>"
                            + "<table id='datatable' class='table table-striped table-bordered dataTable no-footer'>"
                            + "<thead>"
                            + "<tr role='row'>"
                            + "<th>タイトル</th><th>ディスクリプション</th><th>内部リンク数</th><th>外部リンク数</th><th>キーワード１位</th><th>キーワード１位(出現回数)</th><th>キーワード２位</th><th>キーワード２位(出現回数)</th><th>キーワード３位</th><th>キーワード３位(出現回数)</th>"
                            + "</tr>"
                            + "</thead>"
                            + "<tr>"

                                //+ "<% if(!_.isEmpty(response.title)){ %>"
                            + " <td><%= response.keywords %> </td>"
                                //+ "<% } %>"

                                //+ "<% if(!_.isEmpty(response.description)){ %>"
                            + " <td><%= response.description %> </td>"
                                //+ "<% } %>"

                                //+ "<% if(!_.isEmpty(response.innerLickCount)){ %>"
                            + " <td><%= response.innerLickCount %> </td>"
                                //+ "<% } %>"

                                //+ "<% if(!_.isEmpty(response.outLickCount)){ %>"
                            + " <td><%= response.outLickCount %> </td>"
                                //+ "<% } %>"
                            + " <td><%= response.rank1.word %> </td>"
                            + " <td><%= response.rank1.count %> </td>"
                            + " <td><%= response.rank2.word %> </td>"
                            + " <td><%= response.rank2.count %> </td>"
                            + " <td><%= response.rank3.word %> </td>"
                            + " <td><%= response.rank3.count %> </td>"
                            + "</tr>"
                            + "<table>"
                        );
                        $("#comment-area").html(compiled({response: response}));

                        createKeyword('test.csv', response);
                    })
                    .fail(function (response) {
                        alert('コメントがありません。');
                    });


            });
    };

});