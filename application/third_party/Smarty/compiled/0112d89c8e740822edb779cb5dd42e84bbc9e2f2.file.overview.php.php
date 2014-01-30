<?php /* Smarty version Smarty-3.1.13, created on 2014-01-30 08:45:30
         compiled from "application/views/ELEMENTS/overview.php" */ ?>
<?php /*%%SmartyHeaderCode:101005121052d69e14d323e7-97141238%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0112d89c8e740822edb779cb5dd42e84bbc9e2f2' => 
    array (
      0 => 'application/views/ELEMENTS/overview.php',
      1 => 1391067928,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '101005121052d69e14d323e7-97141238',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52d69e14d35768_30525282',
  'variables' => 
  array (
    'channel' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d69e14d35768_30525282')) {function content_52d69e14d35768_30525282($_smarty_tpl) {?><?php if (!empty($_smarty_tpl->tpl_vars['channel']->value['join']['state'])&&$_smarty_tpl->tpl_vars['channel']->value['join']['state']=='FULL'){?>
    <?php echo $_smarty_tpl->getSubTemplate ("CLIENT/full.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?>
<div class="channelChooser">
    <form class="form-horizontal form-channel" action="/channel/join" method="POST" role="form">
        <label>Enter a channel</label>
        <div class="form-group">
            <div class="col-sm-10">
                <input type="channel" name="channel" class="form-control" id="channelID" placeholder="Channelname..">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" name="join" class="btn btn-default">Join</button>
                <button type="button" class="btn btn-default" onClick="document.location.reload(true)">Channel overview</button>
            </div>
        </div>        
    </form>
</div><?php }} ?>