<?php /* Smarty version Smarty-3.1.13, created on 2014-01-16 10:33:31
         compiled from "application/views/ELEMENTS/newAccount.php" */ ?>
<?php /*%%SmartyHeaderCode:9907119852d7a76ba779b2-50145540%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'df67e7ffecf4287a09659a17c888ed9f379aa830' => 
    array (
      0 => 'application/views/ELEMENTS/newAccount.php',
      1 => 1388753650,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9907119852d7a76ba779b2-50145540',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'user' => 0,
    'messageType' => 0,
    'message' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52d7a76bb23871_33908918',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d7a76bb23871_33908918')) {function content_52d7a76bb23871_33908918($_smarty_tpl) {?><div id="newAccount">
    <div class="container">
        <div class="loginMask">
            <h1 class="text-center signup-title">Create a new account - it's free!</h1>
            <div class="account-wall">
                <form class="form-signin" action="/user/newAccount" method="POST">
                    <?php if (!empty($_smarty_tpl->tpl_vars['user']->value['newAccount'])&&$_smarty_tpl->tpl_vars['user']->value['newAccount']['registration']){?>
                    <?php  $_smarty_tpl->tpl_vars['messageType'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['messageType']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['user']->value['newAccount']['registration']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['messageType']->key => $_smarty_tpl->tpl_vars['messageType']->value){
$_smarty_tpl->tpl_vars['messageType']->_loop = true;
?>
                    <?php  $_smarty_tpl->tpl_vars['message'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['message']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['messageType']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['message']->key => $_smarty_tpl->tpl_vars['message']->value){
$_smarty_tpl->tpl_vars['message']->_loop = true;
?>
                    <label><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</label>
                    <?php } ?>
                    <?php } ?>
                    <?php }?>
                    <input name="email" type="text" class="form-control" placeholder="Email" required autofocus>
                    <input name="pass" id="password" type="password" class="form-control" placeholder="Password" required>
                    <br/>            
                    <input name="user" type="text" class="form-control" placeholder="Username" required>
                    <input name="passConfirm" id="passwordConfirm" type="password" class="form-control" placeholder="Password (Confirm)" required>
                    <!--
                    <label class="checkbox pull-left">
                        <input name="agb" type="checkbox" value="agb">
                        Accept <a href="#">AGB</a>
                    </label>
                    //-->
                    <button class="btn btn-lg btn-primary btn-block" type="submit">
                        Sign up for free</button>
                    <label class="checkbox pull-left">
                        <input type="checkbox" value="remember-me">
                        Remember me
                    </label>
                    <a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>
                </form>
            </div>
            <a href="#login" class="text-center new-account">Already have an account</a>
        </div>
    </div>
</div><?php }} ?>