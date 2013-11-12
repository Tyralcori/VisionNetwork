<?php /* Smarty version Smarty-3.1.13, created on 2013-11-12 12:04:18
         compiled from "application/views/ELEMENTS/overview.php" */ ?>
<?php /*%%SmartyHeaderCode:623597636527a08babc49b7-23400027%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0112d89c8e740822edb779cb5dd42e84bbc9e2f2' => 
    array (
      0 => 'application/views/ELEMENTS/overview.php',
      1 => 1384254257,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '623597636527a08babc49b7-23400027',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_527a08bac0cdd2_13599870',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_527a08bac0cdd2_13599870')) {function content_527a08bac0cdd2_13599870($_smarty_tpl) {?><div class="channelChooser">
    <form class="form-horizontal form-channel" action="/channel/join" method="POST" role="form">
        <label>Enter a channel</label>
        <div class="form-group">
            <div class="col-sm-10">
                <input type="channel" class="form-control" id="channelID" placeholder="frostjoke">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Join</button>
            </div>
        </div>
    </form>
</div><?php }} ?>