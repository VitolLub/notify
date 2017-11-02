
<body class="page-body  page-left-in" data-url="http://neon.dev">
<style type="text/css">
    #textarea_phone_con {
        position: absolute;
        right: 106px;
        padding: 10px;
    }
</style>
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

            <div class="col-sm-12">

                <div class="row">

                    <div class="col-sm-12">


                            <div class="col-md-10">

                                <div class="panel minimal minimal-gray">

                                    <div class="panel-heading">
                                        <div class="panel-options" style="padding-right: 76%!important;">

                                            <ul class="nav nav-tabs">
                                                <li id="mailes" class="active"><a href="#profile-1" data-toggle="tab">Рассылка</a></li>
                                                <li id="selected"><a href="#profile-2" data-toggle="tab">Избранные (<?php echo count($select);?>) </a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="panel-body">

                                        <div class="tab-content">
                                            <div class="tab-pane active" id="profile-1">
                                                <span style="margin-left: 15px;">{ttn} - номер накладной(необязательный параметр)</span>
                                                <p></p>
                                                <div class="form-group">
                                                    <div class="col-sm-10">
                                                        <button type="button" class="btn btn-blue btn-sm" id="template" tabindex="1">Шаблон #1 </button>
                                                        <button type="button" class="btn btn-white btn-sm" id="template" tabindex="2">Шаблон #2</button>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div id="template1">
                                                        <div class="col-sm-4">
                                                            <span>Пример шаблона для <strong>смс</strong></span>
                                                            <textarea style="resize: none;height: 150px;" name="sms_template" id="text1" tabindex="1" class="form-control sms_template" id="field-ta" placeholder="«Срібний Вік»! До 8 березня знижки на першу прикрасу -30%. zolotoyvek.ua"  style="margin: 0px -63.0938px 0px 0px; height: 200px; width: 460px;"></textarea>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <span>Пример шаблона для <strong>viber</strong> </span>
                                                            <textarea style="resize: none;height: 150px;" name="sms_template" id="text2" tabindex="2" class="form-control sms_template" id="field-ta" placeholder="«Срібний Вік»! До 8 березня знижки на першу прикрасу -30%, на другу -50%, на третю -70%! Акція діє з 01.03.2017 до 12.03.2017 "  style="margin: 0px -63.0938px 0px 0px; height: 200px; width: 460px;"></textarea>
                                                        </div>
                                                    </div>
                                                    <div style="display: none;" id="template2">
                                                        <div class="col-sm-4" >
                                                            <span>Пример шаблона для <strong>смс</strong></span>
                                                            <textarea style="resize: none;height: 150px;" name="sms_template" id="text3" class="form-control sms_template" id="field-ta" placeholder="«Срібний Вік»! До 8 березня знижки на першу прикрасу -30%. zolotoyvek.ua"  style="margin: 0px -63.0938px 0px 0px; height: 200px; width: 460px;"></textarea>
                                                        </div>
                                                        <div class="col-sm-4" id="template2_viber">
                                                            <span>Пример шаблона для <strong>Viber:</strong> </span>
                                                            <br>
                                                            <span>Адрес перехода</span>
                                                            <input class="form-control" value="" placeholder="http://www.zolotoyvek.ua" type="text" id="site_aress">
                                                            <span>Название кнопки</span>
                                                            <input class="form-control" value="" placeholder="Перейти до акції" type="text" id="button_name">
                                                            <span>Адрес изображения</span>
                                                            <input id="img_adress" class="form-control" value="" placeholder="http://www.zolotoyvek.ua/media/banner/image/cache/937x264-frame-255-255-255-zoom/9/3/937_264.jpg" type="text">
                                                            <span>Текст сообщения</span>
                                                            <textarea style="resize: none;height: 150px;" name="sms_template" id="text4" class="form-control sms_template" id="field-ta" placeholder="«Срібний Вік»! До 8 березня знижки на першу прикрасу -30%, на другу -50%, на третю -70%! Акція діє з 01.03.2017 до 12.03.2017 "  style="margin: 0px -63.0938px 0px 0px; height: 200px; width: 460px;"></textarea>

                                                        </div>
                                                    </div>

                                                     <div class="col-sm-4">
                                                        <input id="selected_users" class="1" type="radio" name="group1" value="Избранные" checked> Использовать Избранные (<?php echo count($select);?>)<br>
                                                        <input id="excel_sel" class="2" type="radio" name="group1" value="Butter"> Загрузить Exсel документ<br>
                                                        <input id="text_area" class="3" type="radio" name="group1" value="Butter"> Текстовое поле<br>
                                                        <div id="dvImportSegments" class="fileupload ">
                                                            <fieldset>
                                                                <h4>Загрузить Excel  документ как показано в <a target="_blank"  href="https://drive.google.com/uc?export=download&id=0B3DZ6HvlPoJFQlJmalB2N2dxUlU" style="color: red;" class="download_example" download="example.xlsx">примере</a></h4>
                                                                <input type="file" id="files" name="files" accept=".xlsx"/>
                                                            </fieldset>
                                                            <p class="bs-example" id="phone_con" style="display: none">
                                                                <button type="button" class="btn btn-green btn-icon">
                                                                    Телефоны
                                                                    <i class="phone_con">0</i>
                                                                </button>
                                                            </p>
                                                        </div>
                                                        <div id="text_area_section" class=" ">
                                                            <span>Данные должны быть указаны через запятую</span>
                                                            <textarea id="phone_area_section" style="height: 226px;width: 250px;resize: none;" placeholder="38098000000,38098000000,38097225400000"></textarea>
                                                            <p class="bs-example">
                                                                <button id="load_phone" type="button" class="btn btn-green btn-icon">
                                                                    Загрузить
                                                                </button>
                                                            </p>
                                                            <p class="bs-example" id="textarea_phone_con" style="display: none">
                                                                <button type="button" class="btn btn-green btn-icon">
                                                                    Телефонов
                                                                    <i class="textarea_phone_con">0</i>
                                                                </button>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="col-sm-6">
                                                        <br>
                                                        <span><strong>Пример для смс:</strong></span>
                                                        <div class="form-group">
                                                            <div id="template_sample">
                                                                <div>
                                                                    <span id="template_text3">«Срібний Вік»! До 8 березня знижки на першу прикрасу -30%. zolotoyvek.ua</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5" style="margin-left: -8%;">
                                                    <br>
                                                    <span><strong>Пример для Viber:</strong></span>
                                                    <div class="form-group">
                                                        <div id="template_sample">
                                                            <div class="col-sm-8">
                                                                <span id="template_text">«Срібний Вік»! До 8 березня знижки на першу прикрасу -30%, на другу -50%, на третю -70%! Акція діє з 01.03.2017 до 12.03.2017 </span>
                                                                <img id="template_img" style="width: 100%;height: auto;" src="http://www.zolotoyvek.ua/media/banner/image/cache/937x264-frame-255-255-255-zoom/9/3/937_264.jpg">
                                                                <a id="template_button" target="_blank" style="margin-top:5px;width: 100%;" class="btn btn-blue btn-lg" href="http://www.zolotoyvek.ua">Перейти до акції</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="tab-pane" id="profile-2">
                                                <div class="panel panel-default">
                                                    <table class="table table-bordered table-responsive table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th style="width: 40px;"><input type="checkbox" name="check[]" id="checkall" tabindex="0"></th>
                                                            <th style="width: 80px;">ID</th>
                                                            <th>Номер телефона</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>

                                                        <?php
                                                        for($i=0;$i<count($select);$i++) {
                                                            ?>
                                                            <tr>
                                                                <td><input class="check" type="checkbox" name="check[]"
                                                                           id="<?php echo $select[$i]->ref; ?>">
                                                                </td>
                                                                <td><?php echo $i + 1; ?></td>
                                                                <td>+<?php echo $select[$i]->phone; ?></td>

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
                            <button type="button" class="btn btn-blue btn-lg" id="send-btn" style="position: fixed; right: 5px;bottom: 5px;">
                                Удалить из списка избранных <i id="select_count"></i>
                                <i class="entypo-trash"></i>
                            </button>
                            <button type="button" class="btn btn-green btn-lg" id="add_to_select" style="position: fixed; right: 210px;bottom: 5px; margin-right: 64px;">
                               Добавить в избрание
                                <i class="entypo-plus"></i>
                            </button>
                            <button type="button" class="btn btn-blue btn-lg" id="direction-btn" style="position: fixed; right: 5px;bottom: 5px;">
                                Запустить рассылка <i id="select_count"></i>
                                <i class="entypo-direction"></i>
                            </button>

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
        <div class="modal fade" id="modal-5" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-body">
                        Данные успешно удалени!
                        <button type="button" class="btn btn-info" data-dismiss="modal" id="contin2" >Хорошо</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-6" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-body">
                        Вы уверени что хотиде начать рассылка?
                        <button type="button" class="btn btn-info" data-dismiss="modal" id="contin3" >Продолжить</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-7" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-body">
                        Рассылка прошла успешно! Обработано (<?php echo count($select);?>) записей
                        <button type="button" class="btn btn-info" data-dismiss="modal" id="contin4" >Хорошо</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-8" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-body">
                        Рассылка прошла успешно!
                        <button type="button" class="btn btn-info" data-dismiss="modal" id="contin5" >Хорошо</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-9" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-body">
                        <textarea id="add_to_selected_textarea" class="form-control col-xs-12" rows="7" style="resize: none;" placeholder="3809528357,380988952145"></textarea>
                        <button type="button" class="btn btn-info" data-dismiss="modal" id="contin6" style="margin-top: 15px;">Загрузить</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="loader"> Идет рассылка сообщений!</div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.7.7/xlsx.core.min.js"></script>
        <script>
            function handleFile(e) {
                //Get the files from Upload control
                var files = e.target.files;
                var i, f;
                //Loop through files
                for (i = 0, f = files[i]; i != files.length; ++i) {
                    var reader = new FileReader();
                    var name = f.name;
                    reader.onload = function (e) {
                        var data = e.target.result;

                        var result;
                        var workbook = XLSX.read(data, { type: 'binary' });

                        var sheet_name_list = workbook.SheetNames;
                        sheet_name_list.forEach(function (y) { /* iterate through sheets */
                            //Convert the cell value to Json
                            var roa = XLSX.utils.sheet_to_json(workbook.Sheets[y]);
                            if(roa.length>0){
                                localStorage.setItem('phone_arr',JSON.stringify(roa));
                                $("#phone_con").removeAttr('style');
                                $(".phone_con").html(roa.length);
                                console.log(roa);
                            }
                        });
                    };
                    reader.readAsArrayBuffer(f);
                }
            }

            //Change event to dropdownlist
            $(document).ready(function(){
                $('#files').change(handleFile);
            });
        </script>

        <script>
            localStorage.setItem('selected', 1);
            $( "#site_aress" ).keyup(function() {
                var href = $(this).val();
                $("#template_button").attr("href", href);
            });
            $("#button_name").keyup(function() {
                var nameComp = $(this).val();
                $("#template_button").text(nameComp);
            });
            $("#img_adress").keyup(function() {
                var img_adress = $(this).val();
                $("#template_img").attr("src", img_adress);
            });
            $("#text4").keyup(function() {
                var text4 = $(this).val();
                $("#template_text").text(text4);
            });
            $("#text3").keyup(function() {
                var text3 = $(this).val();
                $("#template_text3").text(text3);
            });
            $("#text1").keyup(function() {
                var text1 = $(this).val();
                $("#template_text3").text(text1);
            });
            $("#text2").keyup(function() {
                var text2 = $(this).val();
                $("#template_text").text(text2);
            });

            $("#template_img").hide();
            $("#template_button").hide();
            $(document).ready(function(){
                $('button[id="template"]').click(function () {
                    var templType = $(this).attr('tabindex');
                    if(templType==1){
                        $('button[tabindex="2"]').removeClass("btn btn-blue btn-sm");
                        $('button[tabindex="2"]').addClass("btn btn-white btn-sm");
                        $(this).removeClass("btn btn-white btn-sm");
                        $(this).addClass("btn btn-blue btn-sm");
                        $("#template2").css('display','none');
                        $("#template1").removeAttr('style');
                        $("#template_img").hide();
                        $("#template_button").hide();
                        localStorage.setItem('selected', 1);
                    }
                    else{
                        $(this).removeClass("btn btn-white btn-sm");
                        $(this).addClass("btn btn-blue btn-sm");
                        $('button[tabindex="1"]').removeClass("btn btn-blue btn-sm");
                        $('button[tabindex="1"]').addClass("btn btn-white btn-sm");
                        $("#template1").css('display','none');
                        $("#template2").removeAttr('style');
                        $("#template_img").show();
                        $("#template_button").show();
                        localStorage.setItem('selected', 2);
                    }
                });
                $("#add_to_select").click(function () {
                    jQuery('#modal-9').modal('show', {backdrop: 'static'});
                    $("#contin6").click(function () {
                        var numbers = $('textarea#add_to_selected_textarea').val();
                        var res = numbers.split(",");
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>" + "selected/add_to_selected",
                            data: {res:res},
                            dataType: "text",
                            cache: false,
                            success: function (res) {
                                location.reload();
                            }
                        })
                    });
                });
                $("#text_area_section").hide();
                $("#add_to_select").hide();
                $("#load_phone").click(function () {
                    var numbers = $('textarea#phone_area_section').val();
                    var res = numbers.split(",");
                    if(res.length>1)
                    {
                        $("#textarea_phone_con").removeAttr('style');
                        $(".textarea_phone_con").html(res.length);
                    }
                });
                $("#text_area").click(function () {
                    $("#dvImportSegments").hide();
                    $("#text_area_section").show();
                });
                $("#dvImportSegments").hide();
                $("#excel_sel").click(function () {
                    $("#dvImportSegments").show();
                    $("#text_area_section").hide();
                });
                $("#selected_users").click(function () {
                    $("#dvImportSegments").hide();
                    $("#text_area_section").hide();
                });
                $('.loader').hide();
                $('textarea[id="text"]').keyup(function () {
                    var a =100-$(this).val().length;
                    $("#char_count").text(a);
                    if(a<=0)
                    {
                        alert("Максимальное количество символов!");
                        $(this).val($(this).val().substring(0, 100));
                        $("#char_count").text(100-$(this).val().length);
                    }
                });
                $("#direction-btn").click(function (e) {
                    var selected = localStorage.getItem('selected');
                    //alert(selected);
                    if(selected==1){
                        var smsText = $('textarea[id="text1"]').val();
                        var viberText = $('textarea[id="text2"]').val();

                    }
                    else {
                        var smsText = $('textarea[id="text3"]').val();
                        var viberText = $('textarea[id="text4"]').val();
                        var site_aress = $('#site_aress').val();
                        var button_name = $('#button_name').val();
                        var img_adress = $('#img_adress').val();
                    }
                    //alert(viberText);
                    //alert(smsText);
                    e.preventDefault();
                    if(viberText.length==0 || smsText.length==0){
                        alert("Пожалуйста, заполните шаблон сообщения!");
                    }
                    else{

                        jQuery('#modal-6').modal('show', {backdrop: 'static'});
                        $("#contin3").click(function () {
                            $('.loader').show();
                            var start = $("input:radio:checked").attr('class');
                            //alert(smsText);
                            //alert(viberText);
                            if(start==1){
                                if(selected==1){
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url(); ?>" + "selected/send_sms",
                                        data: {start: start,smsText:smsText,viberText:viberText,selected:selected},
                                        dataType: "text",
                                        cache: false,
                                        success: function (res) {
                                            $('.loader').hide();
                                            jQuery('#modal-7').modal('show', {backdrop: 'static'});
                                            $("#contin4").click(function () {
                                                location.reload();
                                            });
                                        }
                                    })
                                }
                                else {
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url(); ?>" + "selected/send_sms",
                                        data: {start: start,smsText:smsText,viberText:viberText,selected:selected,img_adress:img_adress,button_name:button_name,site_aress:site_aress},
                                        dataType: "text",
                                        cache: false,
                                        success: function (res) {
                                            $('.loader').hide();
                                            jQuery('#modal-7').modal('show', {backdrop: 'static'});
                                            $("#contin4").click(function () {
                                                location.reload();
                                            });
                                        }
                                    })
                                }

                            }
                            if(start==2) {
                                var roa = localStorage.getItem('phone_arr');
                                roa = JSON.parse(roa);
                                if(selected==1) {
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url(); ?>" + "selected/send_sms_excel",
                                        data: {start: start, smsText:smsText,viberText:viberText,selected:selected, roa: roa},
                                        dataType: "text",
                                        cache: false,
                                        success: function (res) {
                                            $('.loader').hide();
                                            jQuery('#modal-8').modal('show', {backdrop: 'static'});
                                            $("#contin5").click(function () {
                                                location.reload();
                                            });
                                        }
                                    })
                                }
                                else{
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url(); ?>" + "selected/send_sms_excel",
                                        data: {start: start, smsText:smsText,viberText:viberText,selected:selected,img_adress:img_adress,button_name:button_name,site_aress:site_aress, roa: roa},
                                        dataType: "text",
                                        cache: false,
                                        success: function (res) {
                                            $('.loader').hide();
                                            jQuery('#modal-8').modal('show', {backdrop: 'static'});
                                            $("#contin5").click(function () {
                                                location.reload();
                                            });
                                        }
                                    })
                                }
                            }
                            else{
                                var numbers = $('textarea#phone_area_section').val();
                                var res = numbers.split(",");
                                if(selected==1) {
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url(); ?>" + "selected/send_phone_area_section",
                                        data: {res: res, smsText:smsText,viberText:viberText,selected:selected},
                                        dataType: "text",
                                        cache: false,
                                        success: function (res) {
                                            $('.loader').hide();
                                            jQuery('#modal-8').modal('show', {backdrop: 'static'});
                                            $("#contin5").click(function () {
                                                location.reload();
                                            });
                                        }
                                    })
                                }else {
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url(); ?>" + "selected/send_phone_area_section",
                                        data: {start: start,res:res, smsText:smsText,viberText:viberText,selected:selected,img_adress:img_adress,button_name:button_name,site_aress:site_aress},
                                        dataType: "text",
                                        cache: false,
                                        success: function (res) {
                                            $('.loader').hide();
                                            jQuery('#modal-8').modal('show', {backdrop: 'static'});
                                            $("#contin5").click(function () {
                                                location.reload();
                                            });
                                        }
                                    })
                                }
                            }

                        });
                    }
                });
                $("#send-btn").hide();
                $("#send-btn").click(function (e) {
                    e.preventDefault();
                    var checkedArray =[];
                    $("input:checkbox").each(function(){
                        var $this = $(this);
                        if($this.is(":checked")) {
                            checkedArray.push($this.attr("id"));
                        }
                    });
                    //alert(checkedArray.length);
                    if(checkedArray.length>0){
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>" + "selected/remove_star",
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
                $('#checkall').change(function() {
                    var checkboxes = $(this).closest('table').find(':checkbox');
                    if($(this).is(':checked')) {
                        checkboxes.prop('checked', true);
                    } else {
                        checkboxes.prop('checked', false);
                    }
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
                $('input[class="check"]').click(function (e) {
                    var numberOfChecked = $('input:checkbox:checked').length;
                    var totalCheckboxes = $('input:checkbox').length;
                    var numberNotChecked = totalCheckboxes - numberOfChecked;
                    $("#select_count").html(numberOfChecked);
                });
                $("#selected").on('click',function (e) {
                    e.preventDefault();
                    $("#direction-btn").hide();
                    $("#send-btn").show();
                    $("#add_to_select").show();
                });
                $("#mailes").on('click',function (e) {
                    e.preventDefault();
                    $("#send-btn").hide();
                    $("#add_to_select").hide();
                    $("#direction-btn").show();
                });


            })
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
            #load_phone{
                margin: 3px -50px;
                position:relative;
                top:50%;
                left:73%;
            }
            #textarea_phone_con{
                margin: 3px -50px;
                position:relative;
                top: -55px;
                left:85%;
            }
            input.form-control{
                margin-bottom: 5px;
            }
        </style>