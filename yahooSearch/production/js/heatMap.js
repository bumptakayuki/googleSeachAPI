// DOMを全て読み込んだあとに実行される
$(function () {

    var opts = {
        lines: 13 // The number of lines to draw
        , length: 28 // The length of each line
        , width: 14 // The line thickness
        , radius: 42 // The radius of the inner circle
        , scale: 1 // Scales overall size of the spinner
        , corners: 1 // Corner roundness (0..1)
        , color: '#000' // #rgb or #rrggbb or array of colors
        , opacity: 0.25 // Opacity of the lines
        , rotate: 0 // The rotation offset
        , direction: 1 // 1: clockwise, -1: counterclockwise
        , speed: 1 // Rounds per second
        , trail: 60 // Afterglow percentage
        , fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
        , zIndex: 2e9 // The z-index (defaults to 2000000000)
        , className: 'spinner' // The CSS class to assign to the spinner
        , top: '50%' // Top position relative to parent
        , left: '50%' // Left position relative to parent
        , shadow: false // Whether to render a shadow
        , hwaccel: false // Whether to use hardware acceleration
        , position: 'absolute' // Element positioning
    }

    //描画先の親要素
    var spin_target = document.getElementById('spin-area');
    var spinner = new Spinner(opts);
    var spin_bg_div = $('<div id ="kintone-spin-bg" class="kintone-spinner"></div>');


    $(document).ajaxStart(
        function (){

            spinner.spin(spin_target);

            // スピナー用要素をbodyにappend
            $(document.body).append(spin_bg_div);


            $(spin_bg_div).css({
                'position': 'fixed',
                'top':'0px',
                'left':'0px',
                'z-index': '500',
                'width': '100%',
                'height': '200%',
                'background-color': '#000',
                'opacity': '0.5',
                'filter': 'alpha(opacity=50)',
                '-ms-filter': "alpha(opacity=50)",
                'display': 'block'
            });
        }
    );
    $(document).ajaxStop(
        function (){
            spinner.stop();

            $(spin_bg_div).css({
                'display': 'none'
            });

        }
    );


    $('.getComment').click(function () {

        heatmapChart({});

        var datasetpicker = d3.select("#dataset-picker").selectAll(".dataset-button")
            .data(datasets);

        datasetpicker.enter()
            .append("input")
            .attr("value", function(d){ return "Dataset " + d })
            .attr("type", "button")
            .attr("class", "dataset-button")
            .on("click", function(d) {
                heatmapChart(d);
            });
    });


    var heatmapChart = function(tsvFile) {

        d3.tsv(tsvFile,
            function(error, data) {

                var query = {
                    keyword:$('#keyword').val(),
                    method:'getComment'
                };

                // Ajax通信を開始する
                $.ajax({
                        url: 'http://ec2-52-88-160-219.us-west-2.compute.amazonaws.com/shashoku_collection_restaurant/shashoku_collection_restaurant/production/php/api.php',
                        type: 'post', // getかpostを指定(デフォルトは前者)
                        dataType: 'json', // 「json」を指定するとresponseがJSONとしてパースされたオブジェクトになる
                        data: { // 送信データを指定(getの場合は自動的にurlの後ろにクエリとして付加される)
                            query: query
                        }
                    })
                    // ・ステータスコードは正常で、dataTypeで定義したようにパース出来たとき
                    .done(function (response) {
                        console.log(response);

                        $('#result').val('成功');

                    })
                    // ・サーバからステータスコード400以上が返ってきたとき
                    // ・ステータスコードは正常だが、dataTypeで定義したようにパース出来なかったとき
                    // ・通信に失敗したとき
                    .fail(function (response) {
                        console.log(response);
                    });

                data =[{"day":1,"hour":1,"value":100},{"day":1,"hour":2,"value":200},{"day":1,"hour":3,"value":0},{"day":1,"hour":4,"value":0},{"day":1,"hour":5,"value":0},{"day":1,"hour":6,"value":2},{"day":1,"hour":7,"value":0},{"day":1,"hour":8,"value":9},{"day":1,"hour":9,"value":25},{"day":1,"hour":10,"value":0},{"day":1,"hour":11,"value":0},{"day":1,"hour":12,"value":0},{"day":1,"hour":13,"value":0},{"day":1,"hour":14,"value":66},{"day":1,"hour":15,"value":70},{"day":1,"hour":16,"value":55},{"day":1,"hour":17,"value":51},{"day":1,"hour":18,"value":55},{"day":1,"hour":19,"value":17},{"day":1,"hour":20,"value":20},{"day":1,"hour":21,"value":9},{"day":1,"hour":22,"value":4},{"day":1,"hour":23,"value":0},{"day":1,"hour":24,"value":12},{"day":2,"hour":1,"value":6},{"day":2,"hour":2,"value":2},{"day":2,"hour":3,"value":0},{"day":2,"hour":4,"value":0},{"day":2,"hour":5,"value":0},{"day":2,"hour":6,"value":2},{"day":2,"hour":7,"value":4},{"day":2,"hour":8,"value":11},{"day":2,"hour":9,"value":28},{"day":2,"hour":10,"value":49},{"day":2,"hour":11,"value":51},{"day":2,"hour":12,"value":47},{"day":2,"hour":13,"value":38},{"day":2,"hour":14,"value":65},{"day":2,"hour":15,"value":60},{"day":2,"hour":16,"value":50},{"day":2,"hour":17,"value":65},{"day":2,"hour":18,"value":50},{"day":2,"hour":19,"value":22},{"day":2,"hour":20,"value":11},{"day":2,"hour":21,"value":12},{"day":2,"hour":22,"value":9},{"day":2,"hour":23,"value":0},{"day":2,"hour":24,"value":13},{"day":3,"hour":1,"value":5},{"day":3,"hour":2,"value":8},{"day":3,"hour":3,"value":8},{"day":3,"hour":4,"value":0},{"day":3,"hour":5,"value":0},{"day":3,"hour":6,"value":2},{"day":3,"hour":7,"value":5},{"day":3,"hour":8,"value":12},{"day":3,"hour":9,"value":34},{"day":3,"hour":10,"value":43},{"day":3,"hour":11,"value":54},{"day":3,"hour":12,"value":44},{"day":3,"hour":13,"value":40},{"day":3,"hour":14,"value":48},{"day":3,"hour":15,"value":54},{"day":3,"hour":16,"value":59},{"day":3,"hour":17,"value":60},{"day":3,"hour":18,"value":51},{"day":3,"hour":19,"value":21},{"day":3,"hour":20,"value":16},{"day":3,"hour":21,"value":9},{"day":3,"hour":22,"value":5},{"day":3,"hour":23,"value":4},{"day":3,"hour":24,"value":7},{"day":4,"hour":1,"value":0},{"day":4,"hour":2,"value":0},{"day":4,"hour":3,"value":0},{"day":4,"hour":4,"value":0},{"day":4,"hour":5,"value":0},{"day":4,"hour":6,"value":2},{"day":4,"hour":7,"value":4},{"day":4,"hour":8,"value":13},{"day":4,"hour":9,"value":26},{"day":4,"hour":10,"value":58},{"day":4,"hour":11,"value":61},{"day":4,"hour":12,"value":59},{"day":4,"hour":13,"value":53},{"day":4,"hour":14,"value":54},{"day":4,"hour":15,"value":64},{"day":4,"hour":16,"value":55},{"day":4,"hour":17,"value":52},{"day":4,"hour":18,"value":53},{"day":4,"hour":19,"value":18},{"day":4,"hour":20,"value":3},{"day":4,"hour":21,"value":9},{"day":4,"hour":22,"value":12},{"day":4,"hour":23,"value":2},{"day":4,"hour":24,"value":8},{"day":5,"hour":1,"value":2},{"day":5,"hour":2,"value":0},{"day":5,"hour":3,"value":8},{"day":5,"hour":4,"value":2},{"day":5,"hour":5,"value":0},{"day":5,"hour":6,"value":2},{"day":5,"hour":7,"value":4},{"day":5,"hour":8,"value":14},{"day":5,"hour":9,"value":31},{"day":5,"hour":10,"value":48},{"day":5,"hour":11,"value":46},{"day":5,"hour":12,"value":50},{"day":5,"hour":13,"value":66},{"day":5,"hour":14,"value":54},{"day":5,"hour":15,"value":56},{"day":5,"hour":16,"value":67},{"day":5,"hour":17,"value":54},{"day":5,"hour":18,"value":23},{"day":5,"hour":19,"value":14},{"day":5,"hour":20,"value":6},{"day":5,"hour":21,"value":8},{"day":5,"hour":22,"value":7},{"day":5,"hour":23,"value":0},{"day":5,"hour":24,"value":8},{"day":6,"hour":1,"value":2},{"day":6,"hour":2,"value":0},{"day":6,"hour":3,"value":2},{"day":6,"hour":4,"value":0},{"day":6,"hour":5,"value":0},{"day":6,"hour":6,"value":0},{"day":6,"hour":7,"value":4},{"day":6,"hour":8,"value":8},{"day":6,"hour":9,"value":8},{"day":6,"hour":10,"value":6},{"day":6,"hour":11,"value":14},{"day":6,"hour":12,"value":12},{"day":6,"hour":13,"value":9},{"day":6,"hour":14,"value":14},{"day":6,"hour":15,"value":0},{"day":6,"hour":16,"value":4},{"day":6,"hour":17,"value":7},{"day":6,"hour":18,"value":6},{"day":6,"hour":19,"value":0},{"day":6,"hour":20,"value":0},{"day":6,"hour":21,"value":0},{"day":6,"hour":22,"value":0},{"day":6,"hour":23,"value":0},{"day":6,"hour":24,"value":0},{"day":7,"hour":1,"value":7},{"day":7,"hour":2,"value":6},{"day":7,"hour":3,"value":0},{"day":7,"hour":4,"value":0},{"day":7,"hour":5,"value":0},{"day":7,"hour":6,"value":0},{"day":7,"hour":7,"value":0},{"day":7,"hour":8,"value":0},{"day":7,"hour":9,"value":0},{"day":7,"hour":10,"value":0},{"day":7,"hour":11,"value":2},{"day":7,"hour":12,"value":2},{"day":7,"hour":13,"value":5},{"day":7,"hour":14,"value":6},{"day":7,"hour":15,"value":0},{"day":7,"hour":16,"value":4},{"day":7,"hour":17,"value":0},{"day":7,"hour":18,"value":2},{"day":7,"hour":19,"value":10},{"day":7,"hour":20,"value":7},{"day":7,"hour":21,"value":0},{"day":7,"hour":22,"value":19},{"day":7,"hour":23,"value":9},{"day":7,"hour":24,"value":4}];

                var colorScale = d3.scale.quantile()
                    .domain([0, buckets - 1, d3.max(data, function (d) { return d.value; })])
                    .range(colors);

                var cards = svg.selectAll(".hour")
                    .data(data, function(d) {return d.day+':'+d.hour;});

                cards.append("title");

                cards.enter().append("rect")
                    .attr("x", function(d) { return (d.hour - 1) * gridSize; })
                    .attr("y", function(d) { return (d.day - 1) * gridSize; })
                    .attr("rx", 4)
                    .attr("ry", 4)
                    .attr("class", "hour bordered")
                    .attr("width", gridSize)
                    .attr("height", gridSize)
                    .style("fill", colors[0]);

                cards.transition().duration(1000)
                    .style("fill", function(d) { return colorScale(d.value); });

                cards.select("title").text(function(d) { return d.value; });

                cards.exit().remove();

                var legend = svg.selectAll(".legend")
                    .data([0].concat(colorScale.quantiles()), function(d) { return d; });

                legend.enter().append("g")
                    .attr("class", "legend");

                legend.append("rect")
                    .attr("x", function(d, i) { return legendElementWidth * i; })
                    .attr("y", height)
                    .attr("width", legendElementWidth)
                    .attr("height", gridSize / 2)
                    .style("fill", function(d, i) { return colors[i]; });

                legend.append("text")
                    .attr("class", "mono")
                    .text(function(d) { return "≥ " + Math.round(d); })
                    .attr("x", function(d, i) { return legendElementWidth * i; })
                    .attr("y", height + gridSize);

                legend.exit().remove();

            });
    };


});