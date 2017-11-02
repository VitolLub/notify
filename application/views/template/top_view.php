
<div class="row">

    <!-- Profile Info and Notifications -->
    <div class="col-md-6 col-sm-8 clearfix">

        <ul class="user-info pull-left pull-none-xsm">


            <ul class="user-info pull-left pull-right-xs pull-none-xsm">

                <!-- Raw Notifications -->
                <li class="profile-info dropdown"><!-- add class "pull-right" if you want to place this from right -->

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo base_url(); ?>assets/images/thumb-1@2x.png" alt="" class="img-circle" width="44">
                        <?php echo $neme; ?>
                    </a>
                    <?php
                        $user = $this->ion_auth->user()->row()->id;
                    if($user==2){
                    ?>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                       <input style="width: 100px;" type="text" id="pin_value">
                            <button id="add_pin">PIN</button>
                    </a>
                    <?php } ?>

                    <!--  <ul class="dropdown-menu">

                        <li class="caret"></li>

                        <li>
                            <a href="extra-timeline.html">
                                <i class="entypo-user"></i>
                                Edit Profile
                            </a>
                        </li>

                        <li>
                            <a href="mailbox.html">
                                <i class="entypo-mail"></i>
                                Inbox
                            </a>
                        </li>

                        <li>
                            <a href="extra-calendar.html">
                                <i class="entypo-calendar"></i>
                                Calendar
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <i class="entypo-clipboard"></i>
                                Tasks
                            </a>
                        </li>
                    </ul>-->
                </li>


            </ul>

    </div>


    <!-- Raw Links -->
    <div class="col-md-6 col-sm-4 clearfix hidden-xs">
        <ul class="list-inline links-list pull-right">
            <li>
                <p>1 кредит = 1 сообщение </br>1 сообщение = <?php echo $price; ?> копеек </p>
            </li>
            <li>Баланс: &nbsp; <strong id="balance"><?php echo $balance; ?></strong> кредитов &nbsp;</li>
            <?php
            if(!empty($turbosms))
            {
                ?>
                <li>TurboSMS баланс: &nbsp; <strong id="balance"><?php echo $turbosms->bal; ?></strong> &nbsp;</li>
            <?php
            }
            ?>
            <li>
                <div class="btn-group">
                    <button type="button" class="btn btn-gold" data-toggle="modal" data-target="#myModal2">Пополнить</button>
                    <!-- Modal -->
                    <div class="modal fade" id="myModal2" role="dialog">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body" role="search">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Пополнить счет!</h4>
                                        </div>

                                        <div class="modal-body">


                                            <div class="row">
                                                <div class="col-md-6">

                                                    <div class="form-group">

                                                        <input type="text" name="credit_count" id="credit_count" class="form-control" placeholder="Кретитов" style="width: 100px;">

                                                    </div>

                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <p style="font-size: large;"> = <strong id="pay">0</strong> грн.</p>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="modal-footer" disabled>
                                            <div class="spay">
                                            <?php
                                            $order_id = 'coffe_'.rand(10000, 99999);
                                            require("LiqPay.php");


                                            $liqpay = new LiqPay("i66714015989", "GLIjhC6Ot98kMONd80zKOlp3MAxXQAFX1rM2gQyY");
                                            $data['form'] = $liqpay->cnb_form(array(
                                                'version'        => '3',
                                                'amount'         => 1,
                                                'currency'       => 'UAH',
                                                'description'    => 'notify.com.ua',
                                                'order_id'       => $order_id,
                                                'language'      => 'ru',
                                                'type'          => 'donate',
                                                'result_url'    => base_url().'home/success'
                                            ));
                                            echo $data['form'];
                                            ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </li>
            <!-- Language Selector -->

            <li class="sep"></li>

            <li>
                <a id="logout" href="<?php echo base_url(); ?>auth/logout">
                    Выход <i class="entypo-logout right"></i>
                </a>
            </li>
        </ul>

    </div>

</div>
<script>
    $("#add_pin").click(function () {
        var a = $("#pin_value").val();
        if(a==7413)
        {
            localStorage.setItem('AdminId', a);
            var id= localStorage.getItem('AdminId');
            location.reload()
        }


    });
    $("#credit_count").keyup(function () {
        var cou = $(this).val();
        var cost = "<?php echo $price; ?>";
        var pay = cost * cou;
        $("#pay").text(pay.toFixed(2));
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "payment/buy_coffee_form",
            data: {pay: pay},
            dataType: "text",
            cache: false,
            success: function (res) {
                $(".spay").replaceWith("<div class='spay'>"+res.replace(/\\/g, "").replace(/"n/g, "").replace(/n "/g, "").replace(/n /g, "").replace(/"/g, "")+"</div>");
            }
        })
    });

</script>
<style>

</style>