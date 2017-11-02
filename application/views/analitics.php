<body class="page-body  page-left-in" data-url="http://neon.dev">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->

    <?php $this->load->view('template/menu_view'); ?>

    <div class="main-content">
        <?php
        $data=array();
        $data['balance'] = $balance->user_balance;
        $data['price'] = $price->price;
        $data['neme'] = $user_name->first_name." ".$user_name->last_name;
        ?>
        <?php $this->load->view('template/top_view',$data); ?>

        <hr />




        <div class="row">


            <div class="col-md-12">

                <div class="panel-group joined" id="accordion-test-2">

                    <div class="panel minimal minimal-gray">

                        <div class="">
                            <div>

                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#profile-1" data-toggle="tab">Аналитика отправленних сообщений</a></li>
                                    <li id="selected"><a href="#profile-2" data-toggle="tab">Отчёт о доставке </a></li>

                                </ul>
                            </div>
                        </div>
                        <?

                         ?>
                        <form action="<?php echo base_url(); ?>analitics/index" method="post">
                            <ul class="list-inline">
                                <li>Начальная дата:</li>
                                <li><input type="date" id="firstdate" name="firstdate" class="form-control" value="<?php if(isset($firstdate)){ echo date("Y-m-d", strtotime($firstdate));  }else{ $firstDay = date("Y-m-d");
                                       echo $lastDay =  date("Y-m-d", strtotime($firstDay." -7 day" ) ); }?>"></li>
                                <li class="sep">Конечная дата:</li>
                                <li><input type="date" id="lastdate" name="lastdate" class="form-control" value="<?php if(isset($lastdate)){ echo date("Y-m-d", strtotime($lastdate)); } else{ echo $firstDay;}?>"> </li>
                                <li><button type="submit" class="btn btn-info" id="saveDate">Загрузить</button></li>
                            </ul>
                        </form>
                        <div class="panel-body">

                            <div class="tab-content">
                                <div class="tab-pane active" id="profile-1">
                                    <canvas id="myChart" width="400" height="400" style="max-height: 800px!important;max-width: 1000px!important;"></canvas>

                                </div>
                                <div class="tab-pane active" id="profile-2">
                                    <div class="panel panel-default">
                                        <table class="table table-bordered table-responsive table-striped">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Номер телефона</th>
                                                <th>Дата</th>
                                                <th>Канал</th>
                                            </tr>
                                            </thead>

                                            <tbody>

                                            <?php
                                            for ($i=0;$i<count($res_analit);$i++) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $i+1; ?></td>
                                                    <td><?php echo $res_analit[$i]->phone; ?></td>
                                                    <td><?php echo $res_analit[$i]->u_date; ?></td>
                                                    <td><?php if($res_analit[$i]->chanel==0){ echo "SMS"; }else{ echo "Viber"; } ?></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-sm-12">

                    </div>
                </div>
                <?php
                $a = json_encode($analitiscs);
                $b = json_encode($andate);
                ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.js"></script>
                <script>
                    var ctx = document.getElementById("myChart");
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: <?php echo $b; ?>,
                            datasets: [{
                                label: '# of Votes',
                                data: <?php echo $a; ?>,

                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero:true
                                    }
                                }]
                            }
                        }
                    });
                </script>