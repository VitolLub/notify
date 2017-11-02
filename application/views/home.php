
<body class="page-body  page-left-in" data-url="http://neon.dev">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->

    <?php $this->load->view('template/menu_view');
    $user = $this->ion_auth->user()->row()->id;
    ?>

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
            <form action="<?php echo base_url(); ?>home/index" method="post">
                <ul class="list-inline">

                    <div class="col-md-2">
                        <select class="form-control" id="sel1" name="count_list">
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option selected="selected" value="100">100</option>
                            <option value="500">500</option>
                        </select>
                    </div>

                    <li>Начальная дата:</li>
                    <li><input type="date" id="firstdate" name="firstdate" class="form-control" value="<?php if(isset($firstdate)){ echo date("Y-m-d", strtotime($firstdate));  }?>"></li>
                    <li class="sep">Конечная дата:</li>
                    <li><input type="date" id="lastdate" name="lastdate" class="form-control" value="<?php if(isset($lastdate)){ echo date("Y-m-d", strtotime($lastdate)); }?>"> </li>
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
                                    <th>Врема создания накладной</th>
                                    <th>Время доставки</th>
                                    <th>Barcodes</th>
                                </tr>
                                </thead>

                                <tbody>

                                <?php
                                if($number==false){
                                    $number=0;
                                }
                                $to = $per_page+intval($number);
                                if(intval($total_rows)<intval($to)){
                                    $to=$total_rows;
                                }
                                for ($i=$number;$i<$to;$i++) {
                                    if(isset($date[$i]['IntDocNumber'])) {
                                        if($date[$i]['Cost']!=='200.00')
                                        {
                                            $this->pages_model->save_in_not_sended($user,$date[$i]['IntDocNumber'],$date[$i]['CityRecipientDescription'],$date[$i]['RecipientContactPerson'],$date[$i]['DateTime'],$date[$i]['Cost'],$date[$i]['RecipientContactPhone']);
                                        }
                                        ?>
                                        <tr>
                                            <td><input class="check" type="checkbox" name="check[]"
                                                       id="<?php echo $date[$i]['IntDocNumber'] . "|" . $date[$i]['RecipientContactPhone'] . "#" . $date[$i]['DateTime']."??" . $date[$i]['SeatsAmount']."//" . $date[$i]['Cost']; ?>" region="<?php echo $date[$i]['CityRecipientDescription']; ?>" uname="<?php echo $date[$i]['RecipientContactPerson']; ?>">
                                            </td>
                                            <td><?php echo $i + 1; ?></td>
                                            <td><strong><?php echo $date[$i]['CityRecipientDescription']; ?></strong><?php echo "<br/>"; echo $date[$i]['RecipientContactPerson']; ?></td>
                                            <td>+<?php echo $date[$i]['RecipientContactPhone']; ?></td>
                                            <td><?php echo $date[$i]['Cost']; ?></td>
                                            <td><?php echo $date[$i]['IntDocNumber']; ?></td>
                                            <td><?php echo $date[$i]['SeatsAmount']; ?></td>
                                            <td><?php echo $date[$i]['Weight']; ?> кг.</td>
                                            <td><?php echo $date[$i]['DateTime']; ?></td>
                                            <td><?php echo $date[$i]['EstimatedDeliveryDate']; ?></td>
                                            <td><?php echo $date[$i]['InfoRegClientBarcodes']; ?></td>
                                            
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>


                                </tbody>
                            </table>
                        </div>
                        <!--<button type="button" class="btn btn-green btn-lg" id="send_to_sended" style="margin-right: 35%;position: fixed; right: 5px;bottom: 5px;">
                            Добавить в отправление
                            <i class="entypo-star"></i>
                        </button>-->
                        <button type="button" class="btn btn-green btn-lg" id="send_str" style="margin-right: 18%;position: fixed; right: 5px;bottom: 5px;">
                                Сохранить в избрание
                                <i class="entypo-star"></i>
                            </button>
                        <button type="button" class="btn btn-blue btn-lg" id="send-btn" style="position: fixed; right: 5px;bottom: 5px;">
                            Отправить отмеченные <i id="select_count"></i>
                            <i class="entypo-mail"></i>
                        </button>

                        <?php
                        }
                        ?>
                    </div>

                </div>
                <ul class="pagination">
                    <?php
                    for($m=0;$m<$num_links;$m++){
                        if($m==0){
                    ?>
                    <li><a id="pagination" href="<?php echo $base_url.'/'.'0'.'?firstdate='.date("d.m.Y", strtotime($firstdate)).'&lastdate='.date("d.m.Y", strtotime($lastdate)).'&count_list='.$per_page;?>" data-ci-pagination-page="<?php echo $m+1;?>"><?php echo $m+1;?></a></li>
                    <?php } else{
                            $page = $per_page*$m;
                            ?>
                            <li><a id="pagination"  href="<?php echo $base_url.'/'.$page.'?firstdate='.date("d.m.Y", strtotime($firstdate)).'&lastdate='.date("d.m.Y", strtotime($lastdate)).'&count_list='.$per_page;?>" data-ci-pagination-page="<?php echo $m+1;?>"><?php echo $m+1;?></a></li>
                    <?php
                        }
                    }
                    ?>
                </ul>

                <div class="panel panel-default">
                </div>

            </div>


        </div>



        <div class="row">
            <div class="col-sm-12">

            </div>
        </div>
        <!-- Modal 4 (Confirm)-->
        <div class="modal fade" id="modal-4" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-body">
                        Сообщения успешно отправлены!
                        <button type="button" class="btn btn-info" data-dismiss="modal" id="contin" style="margin-left: 50%;">Хорошо</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-5" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-body">
                        Данные успешно добавлены в избранные!
                        <button type="button" class="btn btn-info" data-dismiss="modal" id="contin2" >Хорошо</button>
                    </div>
                </div>
            </div>
        </div>
<script>

    $(document).ready(function(){
        $('#send_to_sended').click(function () {
            var checkedList =[];
            $("input:checkbox").each(function(){
                var $this = $(this);
                if($this.is(":checked")) {
                    var a = $this.attr("id");
                    var strPos = a.indexOf("|");
                    var ref = a.substring(0, strPos);
                    checkedList.push(ref);
                }
            });
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>" + "home/save_to_sended",
                data: {checkedList: checkedList},
                dataType: "text",
                cache: false,
                success: function (res) {
                    location.reload();
                }
            })
        });
        $("#send_to_notsended").click(function () {
            var checkedList =[];
            var region = [];
            var uname = [];
            $("input:checkbox").each(function(){
                var $this = $(this);
                if($this.is(":checked")) {
                    var aa = $this.attr("region");
                    if(aa!==undefined){
                        var a = $this.attr("id");
                        var strPos = a.indexOf("|");
                        var ref = a.substring(0, strPos);
                        checkedList.push(ref);
                        region.push($this.attr("region"));
                        uname.push($this.attr("uname"));
                    }

                }
            });
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>" + "home/save_to_notsended",
                data: {checkedList: checkedList,uname: uname,region: region},
                dataType: "text",
                cache: false,
                success: function (res) {
                    location.reload();
                }
            })
        });
        var id2 = localStorage.getItem('AdminId');
        if(id2){
            $('#send_to_notsended').css('display', 'block');
            $('#send_to_sended').css('display', 'block');
        }
        else{
            $('#send_to_notsended').css('display', 'none');
            $('#send_to_sended').css('display', 'none');
        }
        $("#send_str").click(function (e) {
            e.preventDefault();
            var checkedArray =[];
            $("input:checkbox").each(function(){
                var $this = $(this);
                if($this.is(":checked")) {
                    checkedArray.push($this.attr("id"));
                }
            });
            if(checkedArray.length>0){
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>" + "home/save_star",
                    data: {checkedArray: checkedArray},
                    dataType: "text",
                    cache: false,
                    success: function (res) {
                        function func() {
                            jQuery('#modal-5').modal('show', {backdrop: 'static'});
                            $("#contin2").click(function () {
                                location.reload();
                            });
                        }
                        setTimeout(func, 1000);

                    }
                })
            }

        });

        var pages = '<?php echo $per_page; ?>';
        if(pages==20){
            $("#sel1 option[value='20']").attr("selected", "selected");
        }
        if(pages==50){
            $("#sel1 option[value='50']").attr("selected", "selected");
        }
        if(pages==100){
            $("#sel1 option[value='100']").attr("selected", "selected");
        }
        if(pages==500){
            $("#sel1 option[value='500']").attr("selected", "selected");
        }
        $('input[id="checkall"]').on('click',function () {

            var tabindex = $(this).attr('tabindex');
            if(tabindex==0){
                $(this).attr('tabindex',1);
                var totalCheckboxes = $('input:checkbox').length;
                $("#select_count").html(totalCheckboxes-1);
            }
            else{
                $(this).attr('tabindex',0);
                $("#select_count").html(0);
            }
        });
        $('input[class="check"]').click(function (e) {
            var numberOfChecked = $('input:checkbox:checked').length;
            var totalCheckboxes = $('input:checkbox').length;
            var numberNotChecked = totalCheckboxes - numberOfChecked;
            $("#select_count").html(numberOfChecked);
        });
        $("#send-btn").click(function (e) {
            e.preventDefault();
            var checkedList=[];
            var region = [];
            var uname = [];
            var bal = $("#balance").text();
            if(parseInt(bal)>0){
                $("input:checkbox").each(function(){
                    var $this = $(this);
                    if($this.is(":checked")) {
                        checkedList.push($this.attr("id"));
                        region.push($this.attr("region"));
                        uname.push($this.attr("uname"));
                    }
                });
                if(checkedList.length>0) {

                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>" + "home/send_sms",
                        data: {checkedList: checkedList,region: region,uname: uname},
                        dataType: "text",
                        cache: false,
                        success: function (res) {
                            function func() {
                                jQuery('#modal-4').modal('show', {backdrop: 'static'});
                                $("#contin").click(function () {
                                    location.reload();
                                });
                            }

                            setTimeout(func, 1000);

                        }
                    })
                }
                else {
                    alert("Пожалуйста, выберите получателя")
                }
            }
            else {
                alert("Пожалуйста, пополните свой счет!");
            }

        });
        $('#checkall').change(function() {
            var checkboxes = $(this).closest('table').find(':checkbox');
            if($(this).is(':checked')) {
                checkboxes.prop('checked', true);
            } else {
                checkboxes.prop('checked', false);
            }
        });
        var number = '<?php echo $number;?>';
        if(number==0)
        {
            $('.pagination').children().first().addClass("active");
        }
        else {
            var page = number/20;
            $('.pagination').find( "li:eq("+page+")" ).addClass("active");
        }



    })
</script>