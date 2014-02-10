<?php /* Smarty version Smarty-3.1.13, created on 2014-02-07 18:43:36
         compiled from "application/views/ELEMENTS/login.php" */ ?>
<?php /*%%SmartyHeaderCode:60337016152d7a76b999ee1-78843600%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '685ee1a3aa344c396fca069b2f05466d7e6bbe34' => 
    array (
      0 => 'application/views/ELEMENTS/login.php',
      1 => 1389727512,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '60337016152d7a76b999ee1-78843600',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52d7a76ba72d73_79775365',
  'variables' => 
  array (
    'title' => 0,
    'user' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52d7a76ba72d73_79775365')) {function content_52d7a76ba72d73_79775365($_smarty_tpl) {?><div id="login">
    <div class="container">
        <div class="loginMask">
            <h1 class="text-center login-title">Sign in to continue to <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</h1>
            <div class="account-wall">        
                <form class="form-signin" action="/user/login" method="POST">
                    <?php if ($_smarty_tpl->tpl_vars['user']->value&&$_smarty_tpl->tpl_vars['user']->value['login']['message']&&$_smarty_tpl->tpl_vars['user']->value['login']['status']=='failure'){?>
                    <label><?php echo $_smarty_tpl->tpl_vars['user']->value['login']['message'];?>
</label>
                    <?php }?>
                    <input name="user" type="text" class="form-control" placeholder="Email or Username" required autofocus>
                    <input name="pass" type="password" class="form-control" placeholder="Password" required>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">
                        Sign in</button>
                    <!--
                    <label class="checkbox pull-left">
                        <input type="checkbox" value="remember-me">
                        Remember me
                    </label>
                    //-->
                    <a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>
                </form>
            </div>
            <a href="#newAccount" class="text-center new-account">Create an account </a>
        </div>
    </div>
</div><?php }} ?>