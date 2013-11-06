<?php /* Smarty version Smarty-3.1.13, created on 2013-11-06 09:07:54
         compiled from "application/views/ELEMENTS/registerMask.php" */ ?>
<?php /*%%SmartyHeaderCode:16526233365279f85bc1d244-49604997%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '62851eaed87aa33961448e4263978cf554de7bcb' => 
    array (
      0 => 'application/views/ELEMENTS/registerMask.php',
      1 => 1383725273,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16526233365279f85bc1d244-49604997',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5279f85bc2d1a0_21410435',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5279f85bc2d1a0_21410435')) {function content_5279f85bc2d1a0_21410435($_smarty_tpl) {?><div class="container">
    <div class="loginMask">
    <h1 class="text-center login-title">Create a new account</h1>
    <div class="account-wall">
        <img class="profile-img" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120"
             alt="">
        <form class="form-signin">
            <input type="text" class="form-control" placeholder="Email" required autofocus>
            <br/>
            <input id="password" type="password" class="form-control" placeholder="Password" required>
            <input id="passwordConfirm" type="password" class="form-control" placeholder="Password (Confirm)" required>
            <br/>
            <button class="btn btn-lg btn-primary btn-block" type="submit">
                Sign in</button>
            <label class="checkbox pull-left">
                <input type="checkbox" value="remember-me">
                Remember me
            </label>
            <a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>
        </form>
    </div>
    <a href="#" class="text-center new-account">Already have an account</a>
    </div>
</div><?php }} ?>