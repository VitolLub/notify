<link href="<?php echo base_url(); ?>lending/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>lending/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

<!-- Plugin CSS -->
<link href="<?php echo base_url(); ?>lending/vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

<!-- Theme CSS -->
<link href="<?php echo base_url(); ?>lending/css/creative.min.css" rel="stylesheet">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand page-scroll" href="#page-top">Notify.com.ua</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a class="page-scroll" href="#about">О нас</a>
                </li>
                <li>
                    <a class="page-scroll" href="#services">Сервисы</a>
                </li>
                <li>
                    <a class="page-scroll" href="#portfolio">Преимущества</a>
                </li>
                <li>
                    <a class="page-scroll" href="#contact">Контакты</a>
                </li>
                <li>
                    <a class="page-scroll" href="<?php echo "http://" . $_SERVER['SERVER_NAME']; ?>/auth/login">Войти</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>

<header>
    <div class="header-content">
        <div class="header-content-inner">
            <h1 id="homeHeading">Умный выбор</h1>
            <hr>
            <p>Notify.com.ua поможет Вам улучшить уровень вашего сервиса!</p>
            <a href="<?php echo "http://" . $_SERVER['SERVER_NAME']; ?>/auth/login" class="btn btn-primary btn-xl page-scroll">Узнать больше!</a>
        </div>
    </div>
</header>

<section class="bg-primary" id="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center">
                <h2 class="section-heading">Мы сделали то что вам нужно</h2>
                <hr class="light">
                <p class="text-faded">Notify.com.ua даст вам возможность синхронизироваться с Новой Почтой, уведомлять клиентов о состоянии доставки и создавать накладные не выходя из дома!</p>
                <a href="<?php echo "http://" . $_SERVER['SERVER_NAME']; ?>/auth/create_user" class="page-scroll btn btn-default btn-xl sr-button">Создать акаунт!</a>
            </div>
        </div>
    </div>
</section>

<section id="services">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Наши сервисы</h2>
                <hr class="primary">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-diamond text-primary sr-icons"></i>
                    <h3>Синхронизация</h3>
                    <p class="text-muted">Возможность синхронизировать ваш профиль з Новой Почтой</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-paper-plane text-primary sr-icons"></i>
                    <h3>Рассылки</h3>
                    <p class="text-muted">Сообщать своим клиентам о новом товаре используя Viber или SMS!</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-newspaper-o text-primary sr-icons"></i>
                    <h3>Накладые</h3>
                    <p class="text-muted">Создавать накладные теперь стало еще проще.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-heart text-primary sr-icons"></i>
                    <h3>С любовью</h3>
                    <p class="text-muted">Мы относимся к каждому клиенту с любовью!</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="no-padding" id="portfolio">
    <div class="container-fluid">
        <div class="row no-gutter popup-gallery">
            <div class="col-lg-4 col-sm-6">
                <a href="<?php echo base_url(); ?>lending/img/portfolio/fullsize/1.png" class="portfolio-box">
                    <img src="<?php echo base_url(); ?>lending/img/portfolio/thumbnails/1.png" class="img-responsive" alt="">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-category text-faded">
                                Category
                            </div>
                            <div class="project-name">
                                Project Name
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a href="<?php echo base_url(); ?>lending/img/portfolio/fullsize/2.jpg" class="portfolio-box">
                    <img src="<?php echo base_url(); ?>lending/img/portfolio/thumbnails/2.jpg" class="img-responsive" alt="">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-category text-faded">
                                Category
                            </div>
                            <div class="project-name">
                                Project Name
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a href="<?php echo base_url(); ?>lending/img/portfolio/fullsize/3.jpg" class="portfolio-box">
                    <img src="<?php echo base_url(); ?>lending/img/portfolio/thumbnails/3.jpg" class="img-responsive" alt="">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-category text-faded">
                                Category
                            </div>
                            <div class="project-name">
                                Project Name
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a href="<?php echo base_url(); ?>lending/img/portfolio/fullsize/4.jpg" class="portfolio-box">
                    <img src="<?php echo base_url(); ?>lending/img/portfolio/thumbnails/4.jpg" class="img-responsive" alt="">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-category text-faded">
                                Category
                            </div>
                            <div class="project-name">
                                Project Name
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a href="<?php echo base_url(); ?>lending/img/portfolio/fullsize/5.jpg" class="portfolio-box">
                    <img src="<?php echo base_url(); ?>lending/img/portfolio/thumbnails/5.jpg" class="img-responsive" alt="">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-category text-faded">
                                Category
                            </div>
                            <div class="project-name">
                                Project Name
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a href="<?php echo base_url(); ?>lending/img/portfolio/fullsize/6.jpg" class="portfolio-box">
                    <img src="<?php echo base_url(); ?>lending/img/portfolio/thumbnails/6.jpg" class="img-responsive" alt="">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-category text-faded">
                                Category
                            </div>
                            <div class="project-name">
                                Project Name
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
<?php

$client_id = '286737575101143'; // Client ID
$client_secret = '80ecf12e9a6debb6f8cab1a6d3f066ae'; // Client secret
$redirect_uri = 'http://notify.com.ua/index'; // Redirect URIs

if (isset($_GET['code'])) {
    $result = false;

    $params = array(
        'client_id'     => $client_id,
        'redirect_uri'  => $redirect_uri,
        'client_secret' => $client_secret,
        'code'          => $_GET['code']
    );
    $url = 'https://graph.facebook.com/oauth/access_token';

    $tokenInfo = null;
    $baseUrl = $url . '?' . http_build_query($params);
    // parse_str(file_get_contents($url . '?' . http_build_query($params)), $tokenInfo);
    $curlSession = curl_init();
    curl_setopt($curlSession, CURLOPT_URL, $baseUrl);
    curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

    $jsonData = json_decode(curl_exec($curlSession));
    curl_close($curlSession);
    if (isset($jsonData->access_token)) {
        $params = array('access_token' => $jsonData->access_token);
        $userInfo = 'https://graph.facebook.com/me' . '?fields=id,name,email,age_range,birthday,cover,gender,first_name,last_name&' . urldecode(http_build_query($params));
        $curlSession2 = curl_init();
        curl_setopt($curlSession2, CURLOPT_URL, $userInfo);
        curl_setopt($curlSession2, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curlSession2, CURLOPT_RETURNTRANSFER, true);

        $jsonData2 = json_decode(curl_exec($curlSession2));
        curl_close($curlSession2);
        if (isset($jsonData2->id)) {
            $this->pages_model->check_user($jsonData2);
            $userInfo = $jsonData2;
            $result = true;
        }
    }
}
?>



<?php

$client_id = '1004178165981-o8mg7cio1gm5mm7l8adqt378m0puhi8g.apps.googleusercontent.com'; // Client ID
$client_secret = 'xQ_veTBdAJNzdHP4B8ceOt6C'; // Client secret
$redirect_uri = 'http://notify.com.ua/index'; // Redirect URI


if (isset($_GET['code'])) {
    $result = false;

    $params = array(
        'client_id'     => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri'  => $redirect_uri,
        'grant_type'    => 'authorization_code',
        'code'          => $_GET['code']
    );

    $url = 'https://accounts.google.com/o/oauth2/token';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($curl);
    curl_close($curl);
    $tokenInfo = json_decode($result, true);

    if (isset($tokenInfo['access_token'])) {
        $params['access_token'] = $tokenInfo['access_token'];

        $userInfo = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo' . '?' . urldecode(http_build_query($params))), true);
        if (isset($userInfo['id'])) {
            $this->pages_model->check_google_user($userInfo);
            $userInfo = $userInfo;
            $result = true;
        }
    }
}
?>
<aside class="bg-dark">
    <div class="container text-center">
        <div class="call-to-action">
            <h2>Создай аккаунт, это бесплатно!</h2>
            <a href="<?php echo "http://" . $_SERVER['SERVER_NAME']; ?>/auth/create_user" class="btn btn-default btn-xl sr-button">Регистрация!</a>
        </div>
    </div>
</aside>

<section id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center">
                <h2 class="section-heading">Будь на связи!</h2>
                <hr class="primary">
                <p>Заинтересовал наш сервис? Это великолепно! Позвоните нам или отправьте нам письмо, и мы свяжемся с вами как можно скорее!</p>
            </div>
            <div class="col-lg-4 col-lg-offset-2 text-center">
                <i class="fa fa-phone fa-3x sr-contact"></i>
                <p>+380989184652</p>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fa fa-envelope-o fa-3x sr-contact"></i>
                <p><a href="mailto:your-email@your-domain.com">info@notify.com.ua</a></p>
            </div>
        </div>
    </div>
</section>

<!-- jQuery -->
<script src="<?php echo base_url(); ?>lending/vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url(); ?>lending/vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Plugin JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="<?php echo base_url(); ?>lending/vendor/scrollreveal/scrollreveal.min.js"></script>
<script src="<?php echo base_url(); ?>lending/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

<!-- Theme JavaScript -->
<script src="<?php echo base_url(); ?>lending/js/creative.min.js"></script>
<!-- Start of Async Drift Code -->
<script>
    !function() {
        var t;
        if (t = window.driftt = window.drift = window.driftt || [], !t.init) return t.invoked ? void (window.console && console.error && console.error("Drift snippet included twice.")) : (t.invoked = !0,
            t.methods = [ "identify", "config", "track", "reset", "debug", "show", "ping", "page", "hide", "off", "on" ],
            t.factory = function(e) {
                return function() {
                    var n;
                    return n = Array.prototype.slice.call(arguments), n.unshift(e), t.push(n), t;
                };
            }, t.methods.forEach(function(e) {
            t[e] = t.factory(e);
        }), t.load = function(t) {
            var e, n, o, i;
            e = 3e5, i = Math.ceil(new Date() / e) * e, o = document.createElement("script"),
                o.type = "text/javascript", o.async = !0, o.crossorigin = "anonymous", o.src = "https://js.driftt.com/include/" + i + "/" + t + ".js",
                n = document.getElementsByTagName("script")[0], n.parentNode.insertBefore(o, n);
        });
    }();
    drift.SNIPPET_VERSION = '0.3.1';
    drift.load('bzckf6ec8zh2');
</script>
<!-- End of Async Drift Code -->