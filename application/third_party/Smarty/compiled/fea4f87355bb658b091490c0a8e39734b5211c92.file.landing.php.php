<?php /* Smarty version Smarty-3.1.13, created on 2013-10-17 09:11:10
         compiled from "application/views/templates/default/ACTIONS/landing.php" */ ?>
<?php /*%%SmartyHeaderCode:907794731525ce32e86eb11-12825117%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fea4f87355bb658b091490c0a8e39734b5211c92' => 
    array (
      0 => 'application/views/templates/default/ACTIONS/landing.php',
      1 => 1381993864,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '907794731525ce32e86eb11-12825117',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_525ce32e8b6207_39969070',
  'variables' => 
  array (
    'server_name' => 0,
    'template' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_525ce32e8b6207_39969070')) {function content_525ce32e8b6207_39969070($_smarty_tpl) {?><!-- LANGUAGE //-->
<?php echo $_smarty_tpl->getSubTemplate ("templates/".((string)$_smarty_tpl->tpl_vars['template']->value)."/ELEMENTS/landing/language.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<!-- LANGUAGE //-->

<!-- SIGN UP //-->
<?php echo $_smarty_tpl->getSubTemplate ("templates/".((string)$_smarty_tpl->tpl_vars['template']->value)."/ELEMENTS/landing/signUp.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<!-- SIGN UP //-->

<div class="landingWrapper">
    <!-- LOGIN //-->
    <div class="loginContainerBackground">
        <!-- HEADER //-->
        <div class="loginHeaderBackground">
            <h1 class="loginContainerHeader">Manager Tycoon</h1>
        </div>
        <!-- HEADER //-->

        <!-- FORM //-->
        <?php echo $_smarty_tpl->getSubTemplate ("templates/".((string)$_smarty_tpl->tpl_vars['template']->value)."/ELEMENTS/landing/loginForm.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

        <!-- FORM //-->
    </div>
    <!-- LOGIN //-->


    <!-- BOARD //-->
    <a href="#">
        <img src="http://<?php echo $_smarty_tpl->tpl_vars['server_name']->value;?>
/assets/templates/<?php echo $_smarty_tpl->tpl_vars['template']->value;?>
/img/board.png" class="imgBoard">
    </a>
    <!-- BOARD //-->
</div><?php }} ?>