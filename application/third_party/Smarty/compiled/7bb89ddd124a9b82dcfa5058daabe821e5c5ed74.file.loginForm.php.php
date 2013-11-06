<?php /* Smarty version Smarty-3.1.13, created on 2013-10-18 12:22:55
         compiled from "application/views/templates/default/ELEMENTS/landing/loginForm.php" */ ?>
<?php /*%%SmartyHeaderCode:1052373513525f8d8ed03e98-93799333%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7bb89ddd124a9b82dcfa5058daabe821e5c5ed74' => 
    array (
      0 => 'application/views/templates/default/ELEMENTS/landing/loginForm.php',
      1 => 1382091752,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1052373513525f8d8ed03e98-93799333',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_525f8d8ed07ec2_36527141',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_525f8d8ed07ec2_36527141')) {function content_525f8d8ed07ec2_36527141($_smarty_tpl) {?><div class="loginContainerFront">
            <div class="loginFields">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <div class="col-lg-10">
                            <input type="email" class="form-control" id="inputEmail1" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-10">
                            <input type="password" class="form-control" id="inputPassword1" placeholder="Passwort">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> Speichern
                                </label><br/>
                                <a href="#" class="passwordLost">Passwort vergessen?</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success landingButton">Login</button>
                        <button type="submit" class="btn btn-primary landingButton">Neuer Account</button>
                    </div>
                </form>
            </div>

            <!-- FOOTER //-->
            <div class="footer">
                Forum | Hilfe | Datenschutz | Impressum
                <br/>Jobs | Entwickler | Mobil | AGB
                <br/>RedSheep Studios &copy; 2013
            </div>
            <!-- FOOTER //-->

        </div>  <?php }} ?>