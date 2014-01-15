<?php /* Smarty version Smarty-3.1.13, created on 2014-01-15 15:42:56
         compiled from "application/views/index.php" */ ?>
<?php /*%%SmartyHeaderCode:211942973752d69e149066d4-75234996%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '896cc2d4903f7cb099be53ed4a004da1f1b4ab34' => 
    array (
      0 => 'application/views/index.php',
      1 => 1389796976,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '211942973752d69e149066d4-75234996',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52d69e149700d0_20130836',
  'variables' => 
  array (
    'outerLink' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d69e149700d0_20130836')) {function content_52d69e149700d0_20130836($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("TEMPLATE/header.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <?php if (!empty($_smarty_tpl->tpl_vars['outerLink']->value)){?>
        <?php echo $_smarty_tpl->getSubTemplate ("CONTENT/outer.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <?php }else{ ?>
        <?php echo $_smarty_tpl->getSubTemplate ("CONTENT/".((string)$_smarty_tpl->tpl_vars['page']->value).".php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <?php }?>
<?php echo $_smarty_tpl->getSubTemplate ("TEMPLATE/footer.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>