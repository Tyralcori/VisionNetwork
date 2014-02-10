<?php /* Smarty version Smarty-3.1.13, created on 2014-01-30 08:48:48
         compiled from "application/views/CONTENT/default.php" */ ?>
<?php /*%%SmartyHeaderCode:77276137052d69e14c87850-02721996%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aa32f142f7ffc63aa3b0c83bdebbc021ed256ff4' => 
    array (
      0 => 'application/views/CONTENT/default.php',
      1 => 1391068119,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '77276137052d69e14c87850-02721996',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52d69e14d2bf08_86354878',
  'variables' => 
  array (
    'userSession' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d69e14d2bf08_86354878')) {function content_52d69e14d2bf08_86354878($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['userSession']->value&&isset($_smarty_tpl->tpl_vars['userSession']->value['email'])){?>
    <?php if (isset($_smarty_tpl->tpl_vars['userSession']->value['banned'])&&$_smarty_tpl->tpl_vars['userSession']->value['banned']){?>
        <?php echo $_smarty_tpl->getSubTemplate ("ELEMENTS/banned.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <?php }else{ ?>
        <?php echo $_smarty_tpl->getSubTemplate ("ELEMENTS/overview.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <?php }?>
<?php }else{ ?>
    <?php echo $_smarty_tpl->getSubTemplate ("ELEMENTS/singlePage.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?><?php }} ?>