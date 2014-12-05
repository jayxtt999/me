<?php /* Smarty version Smarty-3.1.16, created on 2014-12-04 07:25:34
         compiled from "D:\wamp\www\me\Content\Templates\system\admin_head.html" */ ?>
<?php /*%%SmartyHeaderCode:2655554800c6e21a7c7-28981690%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1501f1be4e9bed8586578ced020f8a5ed29e1718' => 
    array (
      0 => 'D:\\wamp\\www\\me\\Content\\Templates\\system\\admin_head.html',
      1 => 1417347510,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2655554800c6e21a7c7-28981690',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_54800c6e2205e3_26751459',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54800c6e2205e3_26751459')) {function content_54800c6e2205e3_26751459($_smarty_tpl) {?><div class="header navbar navbar-inverse navbar-fixed-top">
<!-- BEGIN TOP NAVIGATION BAR -->
<div class="navbar-inner">
<div class="container-fluid">
<!-- BEGIN LOGO -->
<a class="brand" href="index.html">
    <img src="/Content/Templates/system/assets/img/logo.png" alt="logo" />
</a>
<!-- END LOGO -->
<!-- BEGIN RESPONSIVE MENU TOGGLER -->
<a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
    <img src="/Content/Templates/system/assets/img/menu-toggler.png" alt="" />
</a>
<!-- END RESPONSIVE MENU TOGGLER -->
<!-- BEGIN TOP NAVIGATION MENU -->
<ul class="nav pull-right">
<!-- BEGIN NOTIFICATION DROPDOWN -->
<li class="dropdown" id="header_notification_bar">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="icon-warning-sign"></i>
        <span class="badge">6</span>
    </a>
    <ul class="dropdown-menu extended notification">
        <li>
            <p>You have 14 new notifications</p>
        </li>
        <li>
            <a href="javascript:;" onclick="App.onNotificationClick(1)">
                <span class="label label-success"><i class="icon-plus"></i></span>
                New user registered.
                <span class="time">Just now</span>
            </a>
        </li>
        <li>
            <a href="#">
                <span class="label label-important"><i class="icon-bolt"></i></span>
                Server #12 overloaded.
                <span class="time">15 mins</span>
            </a>
        </li>
        <li>
            <a href="#">
                <span class="label label-warning"><i class="icon-bell"></i></span>
                Server #2 not respoding.
                <span class="time">22 mins</span>
            </a>
        </li>
        <li>
            <a href="#">
                <span class="label label-info"><i class="icon-bullhorn"></i></span>
                Application error.
                <span class="time">40 mins</span>
            </a>
        </li>
        <li>
            <a href="#">
                <span class="label label-important"><i class="icon-bolt"></i></span>
                Database overloaded 68%.
                <span class="time">2 hrs</span>
            </a>
        </li>
        <li>
            <a href="#">
                <span class="label label-important"><i class="icon-bolt"></i></span>
                2 user IP blocked.
                <span class="time">5 hrs</span>
            </a>
        </li>
        <li class="external">
            <a href="#">See all notifications <i class="m-icon-swapright"></i></a>
        </li>
    </ul>
</li>
<!-- END NOTIFICATION DROPDOWN -->
<!-- BEGIN INBOX DROPDOWN -->
<li class="dropdown" id="header_inbox_bar">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="icon-envelope-alt"></i>
        <span class="badge">5</span>
    </a>
    <ul class="dropdown-menu extended inbox">
        <li>
            <p>You have 12 new messages</p>
        </li>
        <li>
            <a href="#">
                <span class="photo"><img src="/Content/Templates/system/assets/img/avatar2.jpg" alt="" /></span>
								<span class="subject">
								<span class="from">Lisa Wong</span>
								<span class="time">Just Now</span>
								</span>
								<span class="message">
								Vivamus sed auctor nibh congue nibh. auctor nibh
								auctor nibh...
								</span>
            </a>
        </li>
        <li>
            <a href="#">
                <span class="photo"><img src="/Content/Templates/system/assets/img/avatar3.jpg" alt="" /></span>
								<span class="subject">
								<span class="from">Richard Doe</span>
								<span class="time">16 mins</span>
								</span>
								<span class="message">
								Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh
								auctor nibh...
								</span>
            </a>
        </li>
        <li>
            <a href="#">
                <span class="photo"><img src="/Content/Templates/system/assets/img/avatar1.jpg" alt="" /></span>
								<span class="subject">
								<span class="from">Bob Nilson</span>
								<span class="time">2 hrs</span>
								</span>
								<span class="message">
								Vivamus sed nibh auctor nibh congue nibh. auctor nibh
								auctor nibh...
								</span>
            </a>
        </li>
        <li class="external">
            <a href="#">See all messages <i class="m-icon-swapright"></i></a>
        </li>
    </ul>
</li>
<!-- END INBOX DROPDOWN -->
<!-- BEGIN TODO DROPDOWN -->
<li class="dropdown" id="header_task_bar">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="icon-tasks"></i>
        <span class="badge">5</span>
    </a>
    <ul class="dropdown-menu extended tasks">
        <li>
            <p>You have 12 pending tasks</p>
        </li>
        <li>
            <a href="#">
								<span class="task">
								<span class="desc">New release v1.2</span>
								<span class="percent">30%</span>
								</span>
								<span class="progress progress-success ">
								<span style="width: 30%;" class="bar"></span>
								</span>
            </a>
        </li>
        <li>
            <a href="#">
								<span class="task">
								<span class="desc">Application deployment</span>
								<span class="percent">65%</span>
								</span>
								<span class="progress progress-danger progress-striped active">
								<span style="width: 65%;" class="bar"></span>
								</span>
            </a>
        </li>
        <li>
            <a href="#">
								<span class="task">
								<span class="desc">Mobile app release</span>
								<span class="percent">98%</span>
								</span>
								<span class="progress progress-success">
								<span style="width: 98%;" class="bar"></span>
								</span>
            </a>
        </li>
        <li>
            <a href="#">
								<span class="task">
								<span class="desc">Database migration</span>
								<span class="percent">10%</span>
								</span>
								<span class="progress progress-warning progress-striped">
								<span style="width: 10%;" class="bar"></span>
								</span>
            </a>
        </li>
        <li>
            <a href="#">
								<span class="task">
								<span class="desc">Web server upgrade</span>
								<span class="percent">58%</span>
								</span>
								<span class="progress progress-info">
								<span style="width: 58%;" class="bar"></span>
								</span>
            </a>
        </li>
        <li>
            <a href="#">
								<span class="task">
								<span class="desc">Mobile development</span>
								<span class="percent">85%</span>
								</span>
								<span class="progress progress-success">
								<span style="width: 85%;" class="bar"></span>
								</span>
            </a>
        </li>
        <li class="external">
            <a href="#">See all tasks <i class="m-icon-swapright"></i></a>
        </li>
    </ul>
</li>
<!-- END TODO DROPDOWN -->
<!-- BEGIN USER LOGIN DROPDOWN -->
<li class="dropdown user">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <img alt="" src="/Content/Templates/system/assets/img/avatar1_small.jpg" />
        <span class="username">Bob Nilson</span>
        <i class="icon-angle-down"></i>
    </a>
    <ul class="dropdown-menu">
        <li><a href="extra_profile.html"><i class="icon-user"></i> My Profile</a></li>
        <li><a href="calendar.html"><i class="icon-calendar"></i> My Calendar</a></li>
        <li><a href="#"><i class="icon-tasks"></i> My Tasks</a></li>
        <li class="divider"></li>
        <li><a href="login.html"><i class="icon-key"></i> Log Out</a></li>
    </ul>
</li>
<!-- END USER LOGIN DROPDOWN -->
</ul>
<!-- END TOP NAVIGATION MENU -->
</div>
</div>
<!-- END TOP NAVIGATION BAR -->
</div><?php }} ?>
