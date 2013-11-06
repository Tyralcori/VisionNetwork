<?php /* Smarty version Smarty-3.1.13, created on 2013-09-23 18:13:26
         compiled from "application\libraries\plugins\fancybox\views\overlay.php" */ ?>
<?php /*%%SmartyHeaderCode:9711523d43df3e7fc1-05130219%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8c9c3304932498c33003be0ed167dc6c8d4d39ed' => 
    array (
      0 => 'application\\libraries\\plugins\\fancybox\\views\\overlay.php',
      1 => 1379952804,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9711523d43df3e7fc1-05130219',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_523d43df424e45_09249158',
  'variables' => 
  array (
    'assetsPLUGINSURL' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_523d43df424e45_09249158')) {function content_523d43df424e45_09249158($_smarty_tpl) {?><!-- CSS FANCY //-->
<link href="http://<?php echo $_smarty_tpl->tpl_vars['assetsPLUGINSURL']->value;?>
/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />
<!-- JS FANCY // -->
<script type="text/javascript" src="http://<?php echo $_smarty_tpl->tpl_vars['assetsPLUGINSURL']->value;?>
/fancybox/source/jquery.fancybox.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $.fancybox.open([
            {
                content: '<div id="lightbox">Hi and welcome on redsheepstudios.com! This site needs some work and is in progress. Please be patient and enjoy your stay.</div>',
            },
        ], {
            padding: 30,
            maxWidth: 800,
            minWidth: 800,
            minHeight: 110
        });
    });
</script><?php }} ?>