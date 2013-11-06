<?php /* Smarty version Smarty-3.1.13, created on 2013-11-06 09:09:31
         compiled from "application/views/ELEMENTS/loginMask.php" */ ?>
<?php /*%%SmartyHeaderCode:13140112085279f6a1b0fea3-23433034%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e15823093cc86ff0a200c9e462d02f29701838de' => 
    array (
      0 => 'application/views/ELEMENTS/loginMask.php',
      1 => 1383725368,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13140112085279f6a1b0fea3-23433034',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5279f6a1b17d59_94403450',
  'variables' => 
  array (
    'title' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5279f6a1b17d59_94403450')) {function content_5279f6a1b17d59_94403450($_smarty_tpl) {?><div class="container">
    <div class="loginMask">
    <h1 class="text-center login-title">Sign in to continue to <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</h1>
    <div class="account-wall">
        <img class="profile-img" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120"
             alt="">
        <form class="form-signin">
            <input type="text" class="form-control" placeholder="Email" required autofocus>
            <input type="password" class="form-control" placeholder="Password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">
                Sign in</button>
            <label class="checkbox pull-left">
                <input type="checkbox" value="remember-me">
                Remember me
            </label>
            <a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>
        </form>
    </div>
    <a href="/user/newAccount" class="text-center new-account">Create an account </a>
    </div>
</div><?php }} ?>