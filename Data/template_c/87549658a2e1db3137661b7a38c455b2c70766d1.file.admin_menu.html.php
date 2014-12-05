<?php /* Smarty version Smarty-3.1.16, created on 2014-12-05 03:16:47
         compiled from "D:\wamp\www\me\Content\Templates\system\admin_menu.html" */ ?>
<?php /*%%SmartyHeaderCode:2172054800c6e22ac48-46706986%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '87549658a2e1db3137661b7a38c455b2c70766d1' => 
    array (
      0 => 'D:\\wamp\\www\\me\\Content\\Templates\\system\\admin_menu.html',
      1 => 1417749403,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2172054800c6e22ac48-46706986',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_54800c6e22f8e1_28842091',
  'variables' => 
  array (
    'menuData' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54800c6e22f8e1_28842091')) {function content_54800c6e22f8e1_28842091($_smarty_tpl) {?><div class="page-sidebar navbar-collapse collapse">
<!-- BEGIN SIDEBAR MENU -->
<ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
<!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
<li class="sidebar-toggler-wrapper">
    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
    <div class="sidebar-toggler">
    </div>
    <!-- END SIDEBAR TOGGLER BUTTON -->
</li>
<!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
<li class="sidebar-search-wrapper">
    <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
    <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
    <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
    <form class="sidebar-search " action="extra_search.html" method="POST">
        <a href="javascript:;" class="remove">
            <i class="icon-close"></i>
        </a>
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search...">
							<span class="input-group-btn">
							<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
							</span>
        </div>
    </form>
    <!-- END RESPONSIVE QUICK SEARCH FORM -->
</li>
<li class="start active open">
    <a href="javascript:;">
        <i class="icon-home"></i>
        <span class="title">Dashboard</span>
        <span class="selected"></span>
        <span class="arrow open"></span>
    </a>
    <ul class="sub-menu">
        <li class="active">
            <a href="index.html">
                <i class="icon-bar-chart"></i>
                Default Dashboard</a>
        </li>
        <li>
            <a href="index_2.html">
                <i class="icon-bulb"></i>
                New Dashboard #1</a>
        </li>
        <li>
            <a href="index_3.html">
                <i class="icon-graph"></i>
                New Dashboard #2</a>
        </li>
    </ul>
</li>

    <?php echo $_smarty_tpl->tpl_vars['menuData']->value;?>



<li class="last ">
    <a href="charts.html">
        <i class="icon-bar-chart"></i>
        <span class="title">Visual Charts</span>
    </a>
</li>
</ul>
<!-- END SIDEBAR MENU -->
</div><?php }} ?>
