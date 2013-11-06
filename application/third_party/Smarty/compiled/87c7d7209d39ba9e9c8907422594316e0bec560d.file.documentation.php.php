<?php /* Smarty version Smarty-3.1.13, created on 2013-09-23 17:35:31
         compiled from "application\views\templates\darkSweet\ACTIONS\documentation.php" */ ?>
<?php /*%%SmartyHeaderCode:2764523d4413369a93-13284557%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '87c7d7209d39ba9e9c8907422594316e0bec560d' => 
    array (
      0 => 'application\\views\\templates\\darkSweet\\ACTIONS\\documentation.php',
      1 => 1379950529,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2764523d4413369a93-13284557',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_523d44133a1c18_09364130',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_523d44133a1c18_09364130')) {function content_523d44133a1c18_09364130($_smarty_tpl) {?><div class="bs-example bs-example-tabs">
    <ul id="myTab" class="nav nav-tabs">
        <li class="active"><a href="#home" data-toggle="tab">General</a></li>
        <li><a href="#profile" data-toggle="tab">Things to know</a></li>
        <li class="dropdown">
            <a href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown">Changelog <b class="caret"></b></a>
            <ul class="dropdown-menu" role="menu" aria-labelledby="myTabDrop1">
                <li><a href="#dropdown1" tabindex="-1" data-toggle="tab">Last major update</a></li>
                <li><a href="#dropdown2" tabindex="-1" data-toggle="tab">Last minor update</a></li>
            </ul>
        </li>
    </ul>
    <div id="myTabContent" class="tab-content dropper">
        <div class="tab-pane fade in active" id="home">
            <p>Currently there is no changelog. We're still developing on our first MAJOR! Relax.</p>
        </div>
        <div class="tab-pane fade" id="profile">
            <p>Soon!</p>
        </div>
        <div class="tab-pane fade" id="dropdown1">
            <p>Last major update changes:</p>
        </div>
        <div class="tab-pane fade" id="dropdown2">
            <p>Last minor update changes:</p>
        </div>
    </div>
</div><?php }} ?>