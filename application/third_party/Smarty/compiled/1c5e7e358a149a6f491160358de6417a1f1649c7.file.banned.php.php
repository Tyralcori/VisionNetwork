<?php /* Smarty version Smarty-3.1.13, created on 2014-01-30 08:47:26
         compiled from "application/views/ELEMENTS/banned.php" */ ?>
<?php /*%%SmartyHeaderCode:68284229152ea038ec89e67-62942292%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1c5e7e358a149a6f491160358de6417a1f1649c7' => 
    array (
      0 => 'application/views/ELEMENTS/banned.php',
      1 => 1388744132,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '68284229152ea038ec89e67-62942292',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'userSession' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52ea038ed11898_06766299',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52ea038ed11898_06766299')) {function content_52ea038ed11898_06766299($_smarty_tpl) {?>You are banned.
<?php if ($_smarty_tpl->tpl_vars['userSession']->value['bannedReason']){?>
<br/>Ban reason: <?php echo $_smarty_tpl->tpl_vars['userSession']->value['bannedReason'];?>

<?php }?>
<?php if ($_smarty_tpl->tpl_vars['userSession']->value['bannedUntil']){?>
<br/>Banned until: <?php echo $_smarty_tpl->tpl_vars['userSession']->value['bannedUntil'];?>

<?php }?><?php }} ?>