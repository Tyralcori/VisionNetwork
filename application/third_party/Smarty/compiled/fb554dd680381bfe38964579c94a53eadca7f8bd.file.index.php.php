<?php /* Smarty version Smarty-3.1.13, created on 2013-10-17 09:46:26
         compiled from "application/views/templates/default/ACTIONS/index.php" */ ?>
<?php /*%%SmartyHeaderCode:1533112140525ce07fe8d433-96871088%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fb554dd680381bfe38964579c94a53eadca7f8bd' => 
    array (
      0 => 'application/views/templates/default/ACTIONS/index.php',
      1 => 1381995907,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1533112140525ce07fe8d433-96871088',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_525ce07fe8dfd1_70323046',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_525ce07fe8dfd1_70323046')) {function content_525ce07fe8dfd1_70323046($_smarty_tpl) {?><div class="ingameBody">
    <div class="ingameFrame">
        <!-- HEADER //-->
        <div class="ingameHeaderBackground">
            <div class="ingameHeaderFront">Manager Tycoon</div>
        </div>
        <!-- HEADER //-->

        <!-- ACTION VIEW //-->
        <div class="elementView">
            <?php echo $_smarty_tpl->getSubTemplate ("templates/".((string)$_smarty_tpl->tpl_vars['template']->value)."/SITEELEMENTS/".((string)$_smarty_tpl->tpl_vars['subpage']->value).".php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

        </div>
        <!-- ACTION VIEW //-->

        <!-- NAVIGATION BOTTOM //-->
        <?php echo $_smarty_tpl->getSubTemplate ("templates/".((string)$_smarty_tpl->tpl_vars['template']->value)."/ELEMENTS/ingame/navigationBottom.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

        <!-- NAVIGATION BOTTOM //-->
    </div>
</div><?php }} ?>