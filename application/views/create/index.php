
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
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control site_input" placeholder="http://example.com" value="<?php echo $site_url; ?>">
                </div>
                <button type="button" class="btn btn-blue save_site">Отправить</button>
            </form>
        </div>
        <div class="list-group">

            <a href="#" class="list-group-item">
                <h4 class="list-group-item-heading">Тут буде йти заголовок </h4>
                <p class="list-group-item-text">Тут буде йти весь опис до бриджів, генерації ключі, перевірка сайту, скачачення бриджів і т.д все радужно і в картинках. Буде показуватись тільки користувач не підключений. Дана сторінка буде служати більше як інформативна. Коли все буде підключено на цій сторінці користувач буде бачити усі свої ордери за останні 3 дні.</p>
            </a>
            <div class="row">
                <div class="col-sm-3">

                    <img class="bridge" src="<?php echo base_url(); ?>assets/images/magento.png" >
                    <div class="tile-stats tile-white-cyan bridge_download" tabindex="magento"> Скачать для Magento
                    </div>
                </div>
                <div class="col-sm-3">

                    <img class="bridge" src="<?php echo base_url(); ?>assets/images/magento-2.png">
                    <div class="tile-stats tile-white-cyan bridge_download" tabindex="magento2"> Скачать для Magento 2
                    </div>
                </div>
                <div class="col-sm-3">

                    <img class="bridge" src="<?php echo base_url(); ?>assets/images/opencart.png">
                    <div class="tile-stats tile-white-cyan bridge_download" tabindex="opencart"> Скачать для OpenCart
                    </div>
                </div>
            </div>
            <div class="success_check"></div>
            <div class="btn-group" id="check_connection">
                <button type="button" class="btn btn-gold">Проверить соеденение</button>
                <button type="button" class="btn btn-gold dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="entypo-info"></i>
                </button>
            </div>

        </div>
<script>
    jQuery('#check_connection').click(function() {
        $.ajax({
            type: "POST",
            url: "http://notify.com.ua/create/index/check_bridge_request",
            data: {platform: 1},
            dataType: "text",
            cache: false,
            success: function (res) {
                if(res=='OK'){
                    jQuery('#check_connection').remove();
                    jQuery('.success_check').append('<button type="button" class="btn btn-green btn-icon">Соединение установлено<i class="entypo-check"></i></button>');

                }


            }
        })
    });
    jQuery('div[class="tile-stats tile-white-cyan bridge_download"]').click(function(e){
        var platform = jQuery(this).attr('tabindex');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "create/index/copy_file",
            data: {platform: platform},
            dataType: "text",
            cache: false,
            success: function (res) {
                e.preventDefault();  //stop the browser from following
                window.location.href = 'index/download_file';
            }
        })
    });
    jQuery('.save_site').click(function () {
        var site_url = jQuery('.site_input').val();
        if(site_url.length==0){
            jQuery('.site_input').css("border-color","coral");
        }
        if(isUrlValid(site_url)==false){
            var doule_url= "http://"+site_url;
            var lastValidation = isUrlValid(doule_url);
            update_site(doule_url)
        }else{
            update_site(site_url)
        }
        function update_site(site_url) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>" + "create/index/save_url",
                data: {site_url: site_url},
                dataType: "text",
                cache: false,
                success: function (res) {
                    console.log(res);
                }
            });
        }
        function isUrlValid(url) {
            return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
        }
    });



</script>

    <style>
        .bridge {
            display: block;
            margin-left: auto;
            margin-right: auto;
            max-height: 170px;
            width: auto;
        }
        .row {
            position: relative;
            left: 10%;
        }
        .tile-white-cyan{
            text-align: -webkit-center;
            font-size: 14px;
        }
    </style>