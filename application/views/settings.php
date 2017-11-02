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

            <form role="form" method="post" class="form-horizontal form-groups-bordered validate" action="<?php echo base_url(); ?>settings/save_settings" novalidate="novalidate">

                <div class="row">
                    <div class="col-md-12">

                        <div class="panel panel-primary" data-collapsed="0">

                            <div class="panel-heading">
                                <div class="panel-title">
                                    Общие настройки
                                </div>

                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                    <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                                </div>
                            </div>

                            <div class="panel-body">

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Имя</label>

                                    <div class="col-sm-5">
                                        <input name="u_name" type="text" class="form-control u_name" id="field-1" value="<?php echo $u_setting[0]->first_name; ?>" placeholder="Иван">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-2" class="col-sm-3 control-label">Фамилия</label>

                                    <div class="col-sm-5">
                                        <input name="u_surname" type="text" class="form-control u_surname" id="field-2" value="<?php echo $u_setting[0]->last_name; ?>" placeholder="Иванов">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-3" class="col-sm-3 control-label">Номер телефона</label>

                                    <div class="col-sm-5">
                                        <input type="text" class="form-control phone_number" name="phone_number" id="field-3" data-validate="required,url" value="<?php echo $u_setting[0]->phone; ?>" placeholder="+380989180000">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-4" class="col-sm-3 control-label">Email </label>

                                    <div class="col-sm-5">
                                        <input type="text" class="form-control email" name="email" id="field-4" data-validate="required,email" value="<?php echo $u_setting[0]->email; ?>" placeholder="john@doe.com">
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>



                <div class="row">
                    <div class="col-md-8">

                        <div class="panel panel-primary" data-collapsed="0">

                            <div class="panel-heading">
                                <div class="panel-title">
                                    Шаблоны сообщений
                                </div>

                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                    <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                                </div>

                            </div>

                            <div class="panel-body">
                                <div class="form-group">
                                    <?php
                                    if(empty($sending_type) || count($sending_type[0]['uid'])==0){
                                    ?>
                                        <label class="col-sm-5 control-label" id="sending_type">SMS и Viber</label>
                                    <?php } else{?>
                                        <label class="col-sm-5 control-label" id="sending_type">Только SMS</label>
                                    <?php } ?>
                                    <div class="make-switch has-switch">

                                        <?php
                                        if(empty($sending_type) || count($sending_type[0]['uid'])==0){
                                            ?>
                                            <div class="switch-off switch-animate" style="" id="on-off2" tabindex="1"><input type="checkbox" checked=""><span class="switch-left">ON</span><label>&nbsp;</label><span class="switch-right">OFF</span></div>

                                            <?php
                                        }else
                                        {
                                            ?>
                                            <div class="switch-off switch-animate switch-on" style="" id="on-off2" tabindex="0"><input type="checkbox" checked=""><span class="switch-left">ON</span><label>&nbsp;</label><span class="switch-right">OFF</span></div>

                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <label class="col-sm-5 control-label">Автоматическая рассылка</label>
                                    <div class="make-switch has-switch">

                                        <?php
                                        if(count($auto_sms)==0){
                                            ?>
                                            <div class="switch-off switch-animate" style="" id="on-off" tabindex="1"><input type="checkbox" checked=""><span class="switch-left">ON</span><label>&nbsp;</label><span class="switch-right">OFF</span></div>

                                            <?php
                                        }else
                                        {
                                           ?>
                                            <div class="switch-off switch-animate switch-on" style="" id="on-off" tabindex="0"><input type="checkbox" checked=""><span class="switch-left">ON</span><label>&nbsp;</label><span class="switch-right">OFF</span></div>

                                            <?php
                                        }
                                        ?>
                                        </div>
                                </div>


                                <label for="field-ta" class="control-label">Шаблон сообщения</label>
                                <div class="roq">
                                    <span> <label><i style="color: red">*</i>{ttn}</label> - номер накладно</span><br/>
                                    <span><label>{count}</label> - количество упаковок</span><br/>
                                    <span><label>{price}</label> - цена товара</span><br/>
                                </div>
                                <div class="form-group">

                                    <div class="col-sm-5">
                                        <textarea name="sms_template" id="text" class="form-control sms_template" id="field-ta" placeholder=""  style="margin: 0px -63.0938px 0px 0px; height: 200px; width: 460px;"><?php if(isset($sms_template)){ echo $sms_template; } else{?>Ваш заказ отправлен. ТТН: {ttn}<?php }?></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-5">

                                    <div class="tile-stats tile-primary">
                                        <div class="icon"><i class="entypo-suitcase"></i></div>

                                        <h3>Альфа имя</h3>
                                        <p id="sms_template"> Ваш заказ отправлен.  ТТН: 654545654545</p>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                </div>

                <div class="form-group default-padding">
                    <button type="button" id="save_sett" class="btn btn-success">Сохранить изменения</button>
                </div>

            </form>


        </div>



        <div class="row">
            <div class="col-sm-12">

            </div>
        </div>


<script>
    $("#on-off").click(function () {
        $(this).toggleClass("switch-on");
        var tab = $(this).attr('tabindex');
        if(tab==0){
            $(this).attr('tabindex',1);
            var tab2 = $(this).attr('tabindex');
        }else{
            $(this).attr('tabindex',0);
            var tab2 = $(this).attr('tabindex');
        }
        var a = tab2;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "settings/auto_sending",
            data: {a: a},
            dataType: "text",
            cache: false,
            success: function (res) {
            }
        })
    });
    $("#on-off2").click(function () {
        $(this).toggleClass("switch-on");
        var tab = $(this).attr('tabindex');
        if(tab==0){
            $(this).attr('tabindex',1);
            var tab2 = $(this).attr('tabindex');
            $("#sending_type").text("SMS и Viber");
        }else{
            $(this).attr('tabindex',0);
            var tab2 = $(this).attr('tabindex');
            $("#sending_type").text("Только SMS");
        }
        var a = tab2;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "settings/save_sending_type",
            data: {a: a},
            dataType: "text",
            cache: false,
            success: function (res) {
            }
        })
    });
    $('#save_sett').click(function() {
        var keyed = $('#text').val().replace(/\n/g, '<br/>');
        var ttn = keyed.indexOf("{ttn}");
        if(ttn==-1)
        {
            alert("Переменная {ttn} является обязательной");
        }
        else {

            var u_name = $('.u_name').val();
            var u_surname = $('.u_surname').val();
            var phone_number= $('.phone_number').val();
            var email = $('.email').val();
            var sms_template = $('.sms_template').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>" + "settings/save_settings",
                data: {u_name: u_name,u_surname:u_surname,phone_number:phone_number,email:email,sms_template:sms_template},
                dataType: "text",
                cache: false,
                success: function (res) {
                    location.reload();
                }
            })
        }


    });
</script>