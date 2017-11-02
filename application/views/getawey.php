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

            <div class="col-sm-9">
                <div href="#" class="list-group-item active">
                    <h4 class="list-group-item-heading">Внимание!</h4>
                    </br>

                    <h4 class="list-group-item-heading">Введите дание для доступа к API turbosms</h4>
                    <form action="<?php echo base_url(); ?>getawey/add_turbosms" method="post">
                        <div class="input-group">

                            <input style="margin-bottom: 5px;" class="form-control" placeholder="Aльфа имя" type="text" name="alpha_name" value="<?php if(isset($name)) {echo strval($name); }?>">
                            <input class="form-control" placeholder="А здесь пароль" type="text" name="pass" value="<?php if(isset($pass)) {echo strval($pass); }?>">

                        </div>
                        <p></p>
                        <div class="input-group-btn open">
                            <button type="submit" class="btn btn-info">Сохранить</button>
                            <button type="button" id="of_getawey" class="btn btn-default" style="margin-left: 2%;">Отключить шлюз</button>
                        </div>
                    </form>



                </div>
                <div class="row">

                </div>
                <?php
                if(isset($cor) && $cor==0){
                    ?>
                    <div class="alert alert-danger"><strong>Внимание!</strong> Ключ не является корректным, пожалуйста измените его </div>
                    <?php
                }
                ?>

                <div class="panel panel-default">
                </div>

            </div>


        </div>



        <div class="row">
            <div class="col-sm-12">

            </div>
        </div>
<script>
    $(document).ready(function () {
        $("#of_getawey").click(function (e) {
            var a = 1;
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>" + "getawey/of_getawey",
                data: {a: a},
                dataType: "text",
                cache: false,
                success: function (res) {
                    location.reload();
                }
            })
        })
    })
</script>