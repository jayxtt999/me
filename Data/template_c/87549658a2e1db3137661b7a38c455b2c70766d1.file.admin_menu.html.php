<?php /* Smarty version Smarty-3.1.16, created on 2014-12-04 09:39:37
         compiled from "D:\wamp\www\me\Content\Templates\system\admin_menu.html" */ ?>
<?php /*%%SmartyHeaderCode:2172054800c6e22ac48-46706986%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '87549658a2e1db3137661b7a38c455b2c70766d1' => 
    array (
      0 => 'D:\\wamp\\www\\me\\Content\\Templates\\system\\admin_menu.html',
      1 => 1417685653,
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
    'curr' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54800c6e22f8e1_28842091')) {function content_54800c6e22f8e1_28842091($_smarty_tpl) {?><div class="page-sidebar nav-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <ul>
        <li>
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <div class="sidebar-toggler hidden-phone"></div>
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
        </li>
        <li>
            <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
            <form class="sidebar-search">
                <div class="input-box">
                    <a href="javascript:;" class="remove"></a>
                    <input type="text" placeholder="Search..." />
                    <input type="button" class="submit" value=" " />
                </div>
            </form>
            <!-- END RESPONSIVE QUICK SEARCH FORM -->
        </li>

        <li class="start active ">
            <a href="index.html">
                <i class="icon-home"></i>
                <span class="title">Dashboard</span>
                <span class="selected"></span>
            </a>
        </li>

        <?php  $_smarty_tpl->tpl_vars['curr'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['curr']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menuData']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['curr']->key => $_smarty_tpl->tpl_vars['curr']->value) {
$_smarty_tpl->tpl_vars['curr']->_loop = true;
?>


                <a href="javascript:;"></a>

                <li class="has-sub">
                    <a href="javascript:;">
                        <i class="<?php echo $_smarty_tpl->tpl_vars['curr']->value['ico'];?>
"></i>
                        <span class="title"><?php echo $_smarty_tpl->tpl_vars['curr']->value['name'];?>
</span>
                        <span class="arrow"></span>
                    </a>

                </li>





        <?php } ?>




        <li class="has-sub">
            <a href="javascript:;">
                <i class="icon-bookmark-empty"></i>
                <span class="title">UI Features</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub" style="display: none; ">
                <li><a href="ui_general.html">General</a></li>
                <li><a href="ui_buttons.html">Buttons</a></li>
                <li><a href="ui_tabs_accordions.html">Tabs &amp; Accordions</a></li>
                <li><a href="ui_sliders.html">Sliders</a></li>
                <li><a href="ui_tiles.html">Tiles</a></li>
                <li><a href="ui_typography.html">Typography</a></li>
                <li><a href="ui_tree.html">Tree View</a></li>
                <li><a href="ui_nestable.html">Nestable List</a></li>
            </ul>
        </li>




        <li class="has-sub ">
            <a href="javascript:;">
                <i class="icon-bookmark-empty"></i>
                <span class="title">UI Features</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub">
                <li ><a href="ui_general.html">General</a></li>
                <li ><a href="ui_buttons.html">Buttons</a></li>
                <li ><a href="ui_tabs_accordions.html">Tabs & Accordions</a></li>
                <li ><a href="ui_sliders.html">Sliders</a></li>
                <li ><a href="ui_tiles.html">Tiles</a></li>
                <li ><a href="ui_typography.html">Typography</a></li>
                <li ><a href="ui_tree.html">Tree View</a></li>
                <li ><a href="ui_nestable.html">Nestable List</a></li>
            </ul>
        </li>
        <li class="has-sub ">
            <a href="javascript:;">
                <i class="icon-table"></i>
                <span class="title">Form Stuff</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub">
                <li ><a href="form_layout.html">Form Layouts</a></li>
                <li ><a href="form_samples.html">Advance Form Samples</a></li>
                <li ><a href="form_component.html">Form Components</a></li>
                <li ><a href="form_wizard.html">Form Wizard</a></li>
                <li ><a href="form_validation.html">Form Validation</a></li>
                <li ><a href="form_fileupload.html">Multiple File Upload</a></li>
                <li ><a href="form_dropzone.html">Dropzone File Upload</a></li>
            </ul>
        </li>
        <li class="has-sub ">
            <a href="javascript:;">
                <i class="icon-th-list"></i>
                <span class="title">Data Tables</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub">
                <li ><a href="table_basic.html">Basic Tables</a></li>
                <li ><a href="table_managed.html">Managed Tables</a></li>
                <li ><a href="table_editable.html">Editable Tables</a></li>
            </ul>
        </li>
        <li class="has-sub ">
            <a href="javascript:;">
                <i class="icon-th-list"></i>
                <span class="title">Portlets</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub">
                <li ><a href="portlet_general.html">General Portlets</a></li>
                <li ><a href="portlet_draggable.html">Draggable Portlets</a></li>
            </ul>
        </li>
        <li class="has-sub ">
            <a href="javascript:;">
                <i class="icon-map-marker"></i>
                <span class="title">Maps</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub">
                <li ><a href="maps_google.html">Google Maps</a></li>
                <li ><a href="maps_vector.html">Vector Maps</a></li>
            </ul>
        </li>
        <li class="">
            <a href="charts.html">
                <i class="icon-bar-chart"></i>
                <span class="title">Visual Charts</span>
            </a>
        </li>
        <li class="">
            <a href="calendar.html">
                <i class="icon-calendar"></i>
                <span class="title">Calendar</span>
            </a>
        </li>
        <li class="">
            <a href="gallery.html">
                <i class="icon-camera"></i>
                <span class="title">Gallery</span>
            </a>
        </li>
        <li class="has-sub ">
            <a href="javascript:;">
                <i class="icon-briefcase"></i>
                <span class="title">Extra</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub">
                <li ><a href="extra_profile.html">User Profile</a></li>
                <li ><a href="extra_faq.html">FAQ</a></li>
                <li ><a href="extra_search.html">Search Results</a></li>
                <li ><a href="extra_invoice.html">Invoice</a></li>
                <li ><a href="extra_pricing_table.html">Pricing Tables</a></li>
                <li ><a href="extra_404.html">404 Page</a></li>
                <li ><a href="extra_500.html">500 Page</a></li>
                <li ><a href="extra_blank.html">Blank Page</a></li>
                <li ><a href="extra_full_width.html">Full Width Page</a></li>
            </ul>
        </li>
        <li class="">
            <a href="login.html">
                <i class="icon-user"></i>
                <span class="title">Login Page</span>
            </a>
        </li>
    </ul>
    <!-- END SIDEBAR MENU -->
</div><?php }} ?>
