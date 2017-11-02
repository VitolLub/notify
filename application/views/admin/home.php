<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>


<body class="page-body  page-left-in" data-url="http://neon.dev">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->

    <?php $this->load->view('admin/template/menu_view'); ?>

    <div class="main-content">

        <?php $this->load->view('admin/template/top_view'); ?>

        <hr />

        <?php

        $a = date('Y-m-d');
        $yesterday =  date( "Y-m-d", strtotime( $a." -2 day" ) );
        ?>


        <div class="col-md-10 col-sm-4 clearfix hidden-xs" style="margin-left: -25px;">
            <form action="<?php echo base_url(); ?>admin/home/index" method="post">
                <ul class="list-inline">
                    <li>Начальная дата:</li>
                    <li><input type="date" id="firstdate" name="firstdate" class="form-control" value="<?php if(isset($firstdate)){ echo date("Y-m-d", strtotime($firstdate));  }?>"></li>
                    <li class="sep">Конечная дата:</li>
                    <li><input type="date" id="lastdate" name="lastdate" class="form-control" value="<?php if(isset($lastdate)){ echo date("Y-m-d", strtotime($lastdate)); }?>"> </li>
                    <li><button type="submit" class="btn btn-info" id="saveDate">Загрузить</button></li>
                </ul>
            </form>
        </div>
        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        <script>
            chanel = 0;

            var dataArr = [];
            var dataArr2 = [];
            var perDate = [];
            $.ajax({
                type: "POST",
                url: "http://notify.com.ua/admin/home/get_admin_analitics",
                data: {chanel: 0},
                dataType: "text",
                cache: false,
                success: function (res) {
                    var a = JSON.parse(res);
                    for(var i=0;i<a.length;i++){
                        dataArr.push(parseInt(a[i]['totalCOunt']));
                    }
                    localStorage.setItem('titles', dataArr);
                }
            });
            $.ajax({
                type: "POST",
                url: "http://notify.com.ua/admin/home/get_admin_analitics",
                data: {chanel: 1},
                dataType: "text",
                cache: false,
                success: function (res2) {
                    var a = JSON.parse(res2);
                    for(var i=0;i<a.length;i++){
                        dataArr2.push(parseInt(a[i]['totalCOunt']));
                        perDate.push(a[i]['Date']);
                    }
                    localStorage.setItem('titles2', dataArr2);
                    localStorage.setItem('perDate', perDate);
                }
            });
            var aa = localStorage.getItem('titles2');
            function res() {
                var arr = localStorage.getItem('titles');
                var a = arr.split(",");

                var result = a.map(function (x) {
                    return parseInt(x, 10);
                });
                return result;
            }
            function res2() {
                var arr = localStorage.getItem('titles2');
                var a = arr.split(",");

                var result = a.map(function (x) {
                    return parseInt(x, 10);
                });
                return result;
            }
            function per() {

                var perDate = localStorage.getItem('perDate');
                var b = perDate.split(",");
                console.log(b);
                return b;

            }
            Highcharts.chart('container', {

                chart: {
                    type: 'area'
                },
                title: {
                    text: 'Загальні дані по відправленнях'
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    allowDecimals: false,
                    categories: per()
                },
                yAxis: {
                    title: {
                        text: ''
                    }
                },
                tooltip: {
                    pointFormat: '{series.name} produced <b>{point.y:,.0f}</b><br/>warheads in {point.x}'
                },
                plotOptions: {
                    area: {
                        marker: {
                            enabled: false,
                            symbol: 'circle',
                            radius: 2,
                            states: {
                                hover: {
                                    enabled: true
                                }
                            }
                        }
                    }
                },

                series: [{
                    name: 'Viber',
                    data: res2()
                }, {
                    name: 'SMS',
                    data: res()
                }]
            });
        </script>
        <div class="row">

            <div class="col-sm-12">

                <div class="row">

                    <div class="col-sm-12">

                        <?php

                        if(isset($total_rows)&&intval($total_rows)==0) {
                            ?>
                            <p>Ни одной записи по этой дате нету</p>
                            <?php
                        } else {?>
                            <div class="panel panel-default">

                            </div>

                            <?php
                        }
                        ?>
                    </div>

                </div>

                <div class="panel panel-default">
                </div>

            </div>


        </div>



        <div class="row">
            <div class="col-sm-12">

            </div>
        </div>

