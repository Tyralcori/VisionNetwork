<?php /* Smarty version Smarty-3.1.13, created on 2013-10-17 09:11:10
         compiled from "application/views/templates/default/ELEMENTS/landing/signUp.php" */ ?>
<?php /*%%SmartyHeaderCode:1644320808525f8d8ecfaa17-78602646%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3e028f4aeaa87ff7380eb38e0141467320a5ed16' => 
    array (
      0 => 'application/views/templates/default/ELEMENTS/landing/signUp.php',
      1 => 1381993828,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1644320808525f8d8ecfaa17-78602646',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_525f8d8ecff2c0_76510698',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_525f8d8ecff2c0_76510698')) {function content_525f8d8ecff2c0_76510698($_smarty_tpl) {?><div class="signUp">
    <!-- HEADER //-->
    <div class="signUpHeaderBackground">
        <h1 class="signUpContainerHeader">Neuer Account</h1>
        <div class="signUpContainerFront">
            <div class="loginFields">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <div class="col-lg-12">
                            <input type="text" class="form-control" id="inputEmail1" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-12">
                            <input type="password" class="form-control" id="inputPassword1" placeholder="Passwort">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-12">
                            <input type="password" class="form-control" id="inputPassword2" placeholder="Passwort wdhl.">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-12">
                            <input type="text" class="form-control" id="botsecret" placeholder="Botschutz: 4 + 3">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> Ich akzeptiere die AGBs
                                </label><br/>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-success landingButton">Registrieren</button>
                    </div>                   

                </form>
            </div>
        </div>
    </div>
    <!-- HEADER //-->
    <a href="#" class="signUpClose">[CLOSE]</a>
</div>  <?php }} ?>