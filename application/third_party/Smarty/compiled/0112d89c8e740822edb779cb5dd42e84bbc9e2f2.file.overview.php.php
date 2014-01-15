<?php /* Smarty version Smarty-3.1.13, created on 2014-01-15 15:41:24
         compiled from "application/views/ELEMENTS/overview.php" */ ?>
<?php /*%%SmartyHeaderCode:101005121052d69e14d323e7-97141238%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0112d89c8e740822edb779cb5dd42e84bbc9e2f2' => 
    array (
      0 => 'application/views/ELEMENTS/overview.php',
      1 => 1388745359,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '101005121052d69e14d323e7-97141238',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52d69e14d35768_30525282',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d69e14d35768_30525282')) {function content_52d69e14d35768_30525282($_smarty_tpl) {?><div class="channelChooser">
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