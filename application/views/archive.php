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
                                        <li id="primary" class="active"><a href="#profile-1" data-toggle="tab">Архив получателей</a></li>
                                        <li id="sended_users"><a href="#profile-2" data-toggle="tab">Архив наложек </a></li>
                                        <li id="not_sended_users"><a href="#profile-3" data-toggle="tab">Наложенные платежи</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="panel-body">

                                <div class="tab-content">
                                    <div class="tab-pane active" id="profile-1">
                                        <?php
                                        //print_r($arh_d);
                                        for($i=0;$i<count($archiv);$i++)
                                        {
                                            //echo $archiv[$i]->u_date;
                                            ?>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: white;">
                                                    <h4 class="panel-title" tabindex="<?php echo $i;?>" id="arhive_date">
                                                        <a data-toggle="collapse" data-parent="#accordion-test-<?php echo $i;?>" href="#collapseTwo-<?php echo $i;?>" class="collapsed">
                                                            <?php echo $archiv[$i]; ?>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseTwo-<?php echo $i;?>" class="panel-collapse collapse">
                                                    <table class="table table-bordered table-hover table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">Город/Получатель</th>
                                                            <th>ТТН</th>
                                                            <th width="40%">Номер телефона</th>
                                                            <th class="text-center" width="25%">Количество</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="arh_date" class="<?php echo $i;?>">
                                                        </tbody>
                                                    </table>
                                                    <div class="loader"></div>
                                                </div>

                                            </div>
                                            <?php

                                        }
                                        ?>

                                </div>
                                    <div class="tab-pane" id="profile-2">
                                        <?php
                                        //print_r($arh_d);
                                        for($i=0;$i<count($listDate);$i++)
                                        {
                                            //echo $archiv[$i]->u_date;
                                            ?>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: white;">
                                                    <h4 class="panel-title" tabindex="<?php echo $i;?>" id="sended_date">
                                                        <a data-toggle="collapse" data-parent="#accordion-sended-<?php echo $i;?>" href="#collapseSended-<?php echo $i;?>" class="collapsed">
                                                            <?php echo $listDate[$i]; ?>
                                                        </a>
                                                        <a id="download" href="<?php echo base_url(); ?>archive/download?date=<?php echo $listDate[$i]; ?>" style="color: red;">Скачать архив</a>

                                                    </h4>
                                                </div>
                                                <div id="collapseSended-<?php echo $i;?>" class="panel-collapse collapse">
                                                    <table class="table table-bordered table-hover table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">Получатель</th>
                                                            <th>ТТН</th>
                                                            <th>Дата</th>
                                                            <th>Цена</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="arh_date2 <?php echo $i;?>" class="0">

                                                        </tbody>
                                                    </table>
                                                    <div class="loader"></div>
                                                </div>
                                            </div>
                                            <?php

                                        }
                                        ?>
                                    </div>
                                    <div class="tab-pane" id="profile-3">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th style="width: 40px;"><input type="checkbox" name="check[]" id="checkall" tabindex="0"></th>
                                                <th>#</th>
                                                <th>TTH</th>
                                                <th>Имя</th>
                                                <th>Дата</th>
                                                <th>Номер телефона</th>
                                                <th>Состояние</th>
                                            </tr>
                                            </thead>

                                            <tbody class="3">

                                            </tbody>
                                        </table>
                                        <div class="loader"></div>
                                    </div>
                            </div>

                        </div>
                </div>


        </div>
        <button type="button" class="btn btn-green btn-lg" id="send_to_sended" style="position: fixed; right: 5px;bottom: 5px;">
            Добавить в отправление
            <i class="entypo-star"></i>
        </button>
        <div class="row">
            <div class="col-sm-12">

            </div>
        </div>




<script>
    var hash = window.location.hash;
    /*if(hash.length>0){
        $('#sended_users').addClass('active');
        $('#primary').removeClass('active');
    }*/
    $('#saveDate').click(function () {
        var firstdate = $("#firstdate").val();
        var lastdate = $("#lastdate").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "archive/get_to_sended",
            data: {firstdate:firstdate,lastdate:lastdate},
            dataType: "text",
            cache: false,
            success: function (res) {
                $('tbody[class=2]').children().remove();
                var json = res;
                console.log(json);
                var arr = jQuery.parseJSON(json);
                for(var i=0;i<arr[0].length;i++){
                    var id = arr[0][i];
                    var p = i+1;
                    var users = arr[1][i];
                    $('tbody[class=2]').append('<tr><td><input class="check" type="checkbox" name="check[]"></td><td>'+p+'</td><td>'+users+'</td><td>'+id+'</td></tr>');
                }
            }
        })

    });
    $('#saveDate2').click(function () {
        var firstdate2 = $("#firstdate2").val();
        var lastdate2 = $("#lastdate2").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "archive/get_to_notsended",
            data: {firstdate2:firstdate2,lastdate2:lastdate2},
            dataType: "text",
            cache: false,
            success: function (res) {
                $('tbody[class=3]').children().remove();
                var json = res;
                console.log(json);
                var arr = jQuery.parseJSON(json);
                for(var i=0;i<arr[0].length;i++){
                    var id = arr[0][i];
                    var p = i+1;
                    var users = arr[1][i];
                    $('tbody[class=3]').append('<tr><td><input class="check" type="checkbox" name="check[]"></td><td>'+p+'</td><td>'+users+'</td><td>'+id+'</td></tr>');
                }
            }
        })

    });
    window.location.hash = '';
    $('#send_to_sended').hide();
    $('#send_to_sended').click(function () {
        var checkedList =[];
        var region =[];
        var uname =[];
        var phone = [];
        var price = [];
        $("input:checkbox").each(function(){
            var $this = $(this);
            if($this.is(":checked")) {
                var aa = $this.attr("uname");
                if(aa!==undefined){
                    var a = $this.attr("tabindex");
                    checkedList.push($this.attr("tabindex"));
                    uname.push($this.attr("uname"));
                    phone.push($this.attr("phone"));
                    price.push($this.attr("price"));

                }

            }
        });
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "archive/save_to_sended",
            data: {checkedList: checkedList,uname:uname,phone:phone,price:price},
            dataType: "text",
            cache: false,
            success: function (res) {
                location.reload();
            }
        })
    });
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
    $('#checkall').change(function() {
        var checkboxes = $(this).closest('table').find(':checkbox');
        if($(this).is(':checked')) {
            checkboxes.prop('checked', true);
        } else {
            checkboxes.prop('checked', false);
        }
    });

    $("#not_sended_users").click(function () {
        $('#send_to_sended').show();
        var a = 'a';
        var ss = $('tbody[class=3]').children().length;
        if(ss==0){
            $('.loader').show();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>" + "archive/get_to_notsended",
                data: {a: a},
                dataType: "text",
                cache: false,
                success: function (res) {
                    var json = res;
                    var arr = jQuery.parseJSON(json);
                    for(var i=0;i<arr[0].length;i++){
                        var id = arr[0][i];
                        var p = i+1;
                        var users = arr[1][i];
                        var phone = arr[2][i];
                        var price = arr[3][i];
                        var u_date = arr[4][i];
                        $('tbody[class=3]').append('<tr><td><input class="check" type="checkbox" name="check[]" id="select" phone="'+phone+'" price="'+price+'" tabindex="' + users + '" uname="' +id+ '"></td><td>'+p+'</td><td>'+users+'</td><td>'+id+'</td><td>'+u_date+'</td><td>'+phone+'</td><td id="stat'+p+'"></td></tr>');

                    }
                    $('.loader').hide();
                    var ll = $('tbody[class=3]').children('tr').length;
                    for(var bb=0;bb<=ll;bb++){
                        var users = arr[1][bb];
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>" + "archive/get_delivery_stat",
                            data: {users: users},
                            dataType: "text",
                            cache: false,
                            success: function (res2) {
                                var ss = res2;
                                }
                        });
                        console.log(ss);
                        if(ss=='0'){
                            $("td#stat"+bb).text("Оплачено").css("color", "red");
                        }
                        if(ss=='2'){
                            $("td#stat"+bb).text("Сегодня отправлено");
                        }
                        if(ss=='1') {
                            $("td#stat"+bb).text("Не Оплачено").css("color", "green");
                        }


                    }
                }
            })
        }
    });
    var id2 = localStorage.getItem('AdminId');
    if(id2!==null){
        $("#sended_users").css('display', 'block');
        $("#not_sended_users").css('display','block');
    }else {
        $("#sended_users").css('display', 'none');
        $("#not_sended_users").css('display','none');
    }
    $('h4[id="arhive_date"]').on('click',function (e) {
        $('.loader').hide();
        var s =$(this).attr('tabindex');
        console.log(s);
        var ss = 0;
        ss = $("."+s).children().length;
        console.log(ss);
        if(ss==0){
            $('.loader').show();
            var a = $(this).children().html();
            var date = a.trim();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>" + "archive/get_arhive_date",
                data: {date: date},
                dataType: "text",
                cache: false,
                success: function (res) {
                    console.log(res);
                    var obj = jQuery.parseJSON(res);
                    var aa = $.each( obj, function( key, value ) {
                        var city = value['data'][0]['CityRecipientDescription'];
                        var name = value['data'][0]['RecipientContactPerson'];
                        var ttn = value['data'][0]['IntDocNumber'];
                        var phone = value['data'][0]['RecipientContactPhone'];
                        var count = value['data'][0]['SeatsAmount'];
                        $('tbody[class="'+s+'"]').append('<tr><td class="text-center middle-align"><strong>'+city+'</strong><br/>'+name+'</td><td class="middle-align">'+ttn+'</td><td class="middle-align">'+phone+'</td><td class="text-center middle-align">'+count+'</td></tr>');
                        $('.loader').hide();
                    });
                }
            })
        }

    });
    $('h4[id="sended_date"]').on('click', function (e) {

        $('.loader').hide();
        var s = $(this).attr('tabindex');
        var ss = 0;
        ss = $("." + s).children().length;
        if (ss == 0) {
            $('.loader').show();
            var a = $(this).children().html();
            var date = a.trim();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>" + "archive/get_to_sended",
                data: {date: date},
                dataType: "text",
                cache: false,
                success: function (res) {
                    var obj = jQuery.parseJSON(res);
                    console.log(obj);
                    var b =0;
                    var sum = 0;
                    for(var i=0;i<obj['list'].length;i++){
                        var uname = obj['list'][b]['uname'];
                        var users = obj['list'][b]['users'];
                        var u_date = obj['list'][b]['u_date'];
                        var cost = obj['list'][b]['cost'];
                        sum+=parseInt(cost);
                        b++;
                        $('tbody[id="arh_date2 '+s+'"]').append('<tr><td class="text-center middle-align">'+uname+'</td><td class="middle-align">'+users+'</td><td class="middle-align">'+u_date+'</td><td class="middle-align">'+cost+'</td></tr></tr>');
                        /*}
                        if(parseInt(take)==0){
                            $('tbody[id="arh_date2 '+s+'"]').append('<tr><td class="text-center middle-align">'+uname+'</td><td class="middle-align">'+users+'</td><td class="middle-align">'+u_date+'</td><td class="middle-align">'+cost+'</td><td class="middle-align">'+cretome+'</td><td class="middle-align"><span id="" class="badge badge-success" style="color: #00a651">0</span></td></tr></tr>');
                        }*/

                        $('.loader').hide();
                    }
                    $('tbody[id="arh_date2 '+s+'"]').append('<tr><td></td><td></td><td></td><td style="color: red;">'+sum+'</td></tr>');


                }
            });
        }

    });

</script>
<script>


</script>
<style>
    .loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 1;
        background: url('<?php echo base_url(); ?>assets/images/loader-1.gif') 50% 50% no-repeat rgb(249,249,249);
    }
</style>