<div id="login">
    <div class="container">
        <div class="loginMask">
            <h1 class="text-center login-title">Sign in to continue to {$title}</h1>
            <div class="account-wall">        
                <form class="form-signin" action="/user/login" method="POST">
                    {if $user AND $user.login.message AND $user.login.status eq 'failure'}
                    <label>{$user.login.message}</label>
                    {/if}
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
</div>