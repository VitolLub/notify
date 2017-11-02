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
                    <h4 class="list-group-item-heading">Внимание</h4>
                    </br>
                    <p class="list-group-item-text">Введите ключ API Новой Почты</p>
                    </br>
                    <h4 class="list-group-item-heading">Как получить ключ доступа?</h4>
                    <p class="list-group-item-text">
                        1. Перейти на сайт <a href="https://novaposhta.ua/" style="color: #cc2424;" target="_blank">Новая Почта</a></br>
                        2. Авторизоваться</br>
                        3. <a href="https://my.novaposhta.ua/settings/index#apikeys" style="color: #cc2424;" target="_blank">Сгенерировать ключ</a></br></p>
                    <p></p>
                    <form action="<?php echo base_url(); ?>key/addkey" method="post">
                        <div class="input-group">
                            <input type="text" name="key" class="form-control" placeholder="Ваш клюк доступа здесь" value="<?php if(isset($key)) {echo strval($key); }?>">
                            <div class="input-group-btn open">
                                <button type="submit" class="btn btn-info">Сохранить</button>
                            </div>
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
