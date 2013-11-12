<?php /* Smarty version Smarty-3.1.13, created on 2013-11-08 09:39:08
         compiled from "application/views/ELEMENTS/banned.php" */ ?>
<?php /*%%SmartyHeaderCode:1900478775527a1bab161ac0-56856475%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1c5e7e358a149a6f491160358de6417a1f1649c7' => 
    array (
      0 => 'application/views/ELEMENTS/banned.php',
      1 => 1383899947,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1900478775527a1bab161ac0-56856475',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_527a1bab1a9d20_19953596',
  'variables' => 
  array (
    'userSession' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_527a1bab1a9d20_19953596')) {function content_527a1bab1a9d20_19953596($_smarty_tpl) {?>You are banned.
<?php if ($_smarty_tpl->tpl_vars['userSession']->value['bannedReason']){?>
<br/>Ban reason: <?php echo $_smarty_tpl->tpl_vars['userSession']->value['bannedReason'];?>

<?php }?>
<?php if ($_smarty_tpl->tpl_vars['userSession']->value['bannedUntil']){?>
<br/>Banned until: <?php echo $_smarty_tpl->tpl_vars['userSession']->value['bannedUntil'];?>

<?php }?><?php }} ?>