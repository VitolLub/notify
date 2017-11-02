<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Neon Admin Panel" />
  <meta name="author" content="" />

  <link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">

  <title>Neon | Login</title>

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-icons/entypo/css/entypo.css">
  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/neon-core.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/neon-theme.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/neon-forms.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">

  <script src="<?php echo base_url(); ?>assets/js/jquery-1.11.3.min.js"></script>

  <!--[if lt IE 9]><script src="<?php echo base_url(); ?>assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->


</head>
<body class="page-body login-page login-form-fall">


<!-- This is needed when you send requests via Ajax -->
<script type="text/javascript">
  var baseurl = '';
</script>

<div class="login-container">

  <div class="login-header login-caret">

    <div class="login-content">

      <a href="http://notify.com.ua/index" class="logo">
        <img src="<?php echo base_url(); ?>assets/images/logo@2x.png" width="120" alt="" />
      </a>

      <p class="description" style="color: white;">Здарова друг, спасибо что посетил нас, облегчи себе жизнь!</p>

      <!-- progress bar indicator -->
      <div class="login-progressbar-indicator">
        <h3>43%</h3>
        <span>logging in...</span>
      </div>
    </div>

  </div>

  <div class="login-progressbar">
    <div></div>
  </div>

  <div class="login-form">

    <div class="login-content">

      <div class="form-login-error">
        <h3>Invalid login</h3>
        <p>Enter <strong>demo</strong>/<strong>demo</strong> as login and password.</p>
      </div>

<p style="color: white;"><?php echo lang('login_subheading');?></p>

<div id="infoMessage" style="color:white;"><?php echo $message;?></div>

<?php echo form_open("auth/login");?>
  <div class="form-group">
    <div class="input-group">
      <div class="input-group-addon">
        <i class="entypo-user"></i>
      </div>
      <?php echo form_input($identity,'','',$pl='Логин');?>
    </div>
  </div>
  <div class="form-group">
    <div class="input-group">
      <div class="input-group-addon">
        <i class="entypo-user"></i>
      </div>
      <?php echo form_input($password,'','',$pl='Пароль');?>
    </div>
  </div>

  <p style="color: white;">
    <?php echo lang('login_remember_label', 'remember');?>
    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
  </p>

      <div class="form-group" style="color: white;">
          <?php echo form_submit('submit','Логин' ,lang('login_submit_btn'));?>
      </div>

<?php echo form_close();?>
        <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
        </fb:login-button>
<div class="login-bottom-links">

  <a href="<?php echo base_url(); ?>auth/create_user" class="link">Регистрация</a>

  <br />


</div>


</div>

</div>

</div>

</div>


<!-- Bottom scripts (common) -->
<script src="<?php echo base_url(); ?>assets/js/gsap/TweenMax.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
<script src="<?php echo base_url(); ?>assets/js/joinable.js"></script>
<script src="<?php echo base_url(); ?>assets/js/resizeable.js"></script>
<script src="<?php echo base_url(); ?>assets/js/neon-api.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/neon-login.js"></script>


<!-- JavaScripts initializations and stuff -->
<script src="<?php echo base_url(); ?>assets/js/neon-custom.js"></script>


<!-- Demo Settings -->
<script src="<?php echo base_url(); ?>assets/js/neon-demo.js"></script>

</body>
</html>