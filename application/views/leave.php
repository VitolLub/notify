
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

        <?php

        $a = date('Y-m-d');
        $yesterday =  date( "Y-m-d", strtotime( $a." -2 day" ) );
        ?>


        <div class="col-md-10 col-sm-4 clearfix hidden-xs" style="margin-left: -25px;">
            <form action="<?php echo base_url(); ?>leave/index" method="post">
                <ul class="list-inline">
                    <li>Начальная дата:</li>
                    <li><input type="date" id="firstdate" name="firstdate" class="form-control" value="<?php echo $yesterday; ?>"></li>
                    <li class="sep">Конечная дата:</li>
                    <li><input type="date" id="lastdate" name="lastdate" class="form-control" value="<?php echo $a;?>"> </li>
                    <li><button type="submit" class="btn btn-info" id="saveDate">Загрузить</button></li>
                </ul>
            </form>
        </div>
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
                                <table class="table table-bordered table-responsive table-striped">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" name="check[]" id="checkall" tabindex="0"></th>
                                        <th>ID</th>
                                        <th>Получатель</th>
                                        <th>Номер телефона</th>
                                        <th>Цена заказа</th>
                                        <th>ТТН</th>
                                        <th>Количество</th>
                                        <th>Вес</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    <?php
                                    for ($i=0;$i<count($a);$i++) {

                                        if(intval($a)>0){
                                            ?>
                                            <tr>
                                                <td><input class="check" type="checkbox" name="check[]"
                                                           id="">
                                                </td>
                                                <td><?php echo $i + 1; ?></td>
                                                <td><strong><?php echo $res[$i]['CityRecipientDescription']; ?></strong><?php echo "<br/>"; echo $res[$i]['RecipientContactPerson']; ?></td>
                                                <td>+<?php echo $res[$i]['RecipientContactPhone']; ?></td>
                                                <td><?php echo $res[$i]['Cost']; ?></td>
                                                <td><?php echo $res[$i]['IntDocNumber']; ?></td>
                                                <td><?php echo $res[$i]['SeatsAmount']; ?></td>
                                                <td><?php echo $res[$i]['Weight']; ?> кг.</td>

                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>


                                    </tbody>
                                </table>
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

