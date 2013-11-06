<?php /* Smarty version Smarty-3.1.13, created on 2013-09-21 08:53:29
         compiled from "application\views\index.php" */ ?>
<?php /*%%SmartyHeaderCode:5330523d4269659928-97011291%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c05e42aa64e69a0f1b4e16ca59dd9e931c32bd3f' => 
    array (
      0 => 'application\\views\\index.php',
      1 => 1379171226,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5330523d4269659928-97011291',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'template' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_523d42696b3948_87036069',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_523d42696b3948_87036069')) {function content_523d42696b3948_87036069($_smarty_tpl) {?><?php if (!$_smarty_tpl->tpl_vars['template']->value){?>
    <?php echo $_smarty_tpl->getSubTemplate ('HTML/head.php', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

         <div class="siteContent">
              <?php echo $_smarty_tpl->getSubTemplate ("ACTIONS/".((string)$_smarty_tpl->tpl_vars['page']->value).".php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

         </div>
    <?php echo $_smarty_tpl->getSubTemplate ('HTML/foot.php', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }else{ ?>
    
    
    <?php echo $_smarty_tpl->getSubTemplate ("templates/".((string)$_smarty_tpl->tpl_vars['template']->value)."/HTML/head.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

              
              <?php echo $_smarty_tpl->getSubTemplate ("templates/".((string)$_smarty_tpl->tpl_vars['template']->value)."/ACTIONS/".((string)$_smarty_tpl->tpl_vars['page']->value).".php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

              
              <?php echo $_smarty_tpl->getSubTemplate ("ACTIONS/pluginLoader.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    
    <?php echo $_smarty_tpl->getSubTemplate ("templates/".((string)$_smarty_tpl->tpl_vars['template']->value)."/HTML/foot.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?><?php }} ?>