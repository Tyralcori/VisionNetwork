<?php /* Smarty version Smarty-3.1.13, created on 2013-09-21 08:59:11
         compiled from "application\views\ACTIONS\pluginLoader.php" */ ?>
<?php /*%%SmartyHeaderCode:6233523d42697651c9-89756166%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3df340308dce27761842ca744f4e2a1dc179c391' => 
    array (
      0 => 'application\\views\\ACTIONS\\pluginLoader.php',
      1 => 1379746749,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6233523d42697651c9-89756166',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_523d426976bac7_72029506',
  'variables' => 
  array (
    'plugins' => 0,
    'plugin' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_523d426976bac7_72029506')) {function content_523d426976bac7_72029506($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['plugins']->value){?>
<?php  $_smarty_tpl->tpl_vars['plugin'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['plugin']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['plugins']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['plugin']->key => $_smarty_tpl->tpl_vars['plugin']->value){
$_smarty_tpl->tpl_vars['plugin']->_loop = true;
?>
    <?php  $_smarty_tpl->tpl_vars['template'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['template']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['plugin']->value['template']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['template']->key => $_smarty_tpl->tpl_vars['template']->value){
$_smarty_tpl->tpl_vars['template']->_loop = true;
?>
        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['template']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <?php } ?>
<?php } ?>
<?php }?><?php }} ?>