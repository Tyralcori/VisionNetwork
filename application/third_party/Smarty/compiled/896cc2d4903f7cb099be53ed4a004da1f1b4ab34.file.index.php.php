<?php /* Smarty version Smarty-3.1.13, created on 2014-01-03 11:15:55
         compiled from "application/views/index.php" */ ?>
<?php /*%%SmartyHeaderCode:1665550969525cdef60a3004-04721395%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '896cc2d4903f7cb099be53ed4a004da1f1b4ab34' => 
    array (
      0 => 'application/views/index.php',
      1 => 1388740428,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1665550969525cdef60a3004-04721395',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_525cdef615b567_04512363',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_525cdef615b567_04512363')) {function content_525cdef615b567_04512363($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("TEMPLATE/header.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <?php echo $_smarty_tpl->getSubTemplate ("CONTENT/".((string)$_smarty_tpl->tpl_vars['page']->value).".php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("TEMPLATE/footer.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>