<div class="sidebar-menu">

    <div class="sidebar-menu-inner">

        <header class="logo-env">

            <!-- logo -->
            <div class="logo">
                <a href="<?php echo base_url(); ?>/home/index">
                    <img src="<?php echo base_url(); ?>assets/images/logo@2x.png" width="120" alt="" />
                </a>
            </div>

            <!-- logo collapse icon -->
            <div class="sidebar-collapse">
                <a href="#" class="sidebar-collapse-icon"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
                    <i class="entypo-menu"></i>
                </a>
            </div>


            <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
            <div class="sidebar-mobile-menu visible-xs">
                <a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
                    <i class="entypo-menu"></i>
                </a>
            </div>

        </header>

        <div class="sidebar-user-info">

            <div class="sui-hover inline-links animate-in"><!-- You can remove "inline-links" class to make links appear vertically, class "animate-in" will make A elements animateable when click on user profile -->
                <a href="#">
                    <i class="entypo-pencil"></i>
                    New Page
                </a>

                <a href="mailbox.html">
                    <i class="entypo-mail"></i>
                    Inbox
                </a>

                <a href="extra-lockscreen.html">
                    <i class="entypo-lock"></i>
                    Log Off
                </a>

                <span class="close-sui-popup">&times;</span><!-- this is mandatory -->				</div>
        </div>


        <ul id="main-menu" class="main-menu">
            <!-- add class "multiple-expanded" to allow multiple submenus to open -->
            <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
            <li class="active has-sub">
                <a href="<?php echo base_url(); ?>backend/home">
                    <i class="entypo-gauge"></i>
                    <span class="title">Загальні дані</span>
                </a>
            </li>
            <li class="has-sub">
                <a href="<?php echo base_url(); ?>selected">
                    <i class="entypo-direction"></i>
                    <span class="title">Оплати</span>
                </a>
            </li>
        </ul>

    </div>

</div>