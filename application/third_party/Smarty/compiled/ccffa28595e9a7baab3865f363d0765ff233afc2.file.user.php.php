<?php /* Smarty version Smarty-3.1.13, created on 2014-01-03 11:18:33
         compiled from "application/views/CONTENT/user.php" */ ?>
<?php /*%%SmartyHeaderCode:15166026855279fa4e21dc89-56986768%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ccffa28595e9a7baab3865f363d0765ff233afc2' => 
    array (
      0 => 'application/views/CONTENT/user.php',
      1 => 1388740428,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15166026855279fa4e21dc89-56986768',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5279fa4e2668b0_78371494',
  'variables' => 
  array (
    'subpage' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5279fa4e2668b0_78371494')) {function content_5279fa4e2668b0_78371494($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['subpage']->value=='norender'){?>
    <?php echo $_smarty_tpl->getSubTemplate ("ELEMENTS/login.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }elseif($_smarty_tpl->tpl_vars['subpage']->value){?>
    <?php echo $_smarty_tpl->getSubTemplate ("ELEMENTS/".((string)$_smarty_tpl->tpl_vars['subpage']->value).".php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?><?php }} ?>