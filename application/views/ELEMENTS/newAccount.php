<div id="newAccount">
    <div class="container">
        <div class="loginMask">
            <h1 class="text-center signup-title">Create a new account - it's free!</h1>
            <div class="account-wall">
                <form class="form-signin" action="/user/newAccount" method="POST">
                    {if !empty($user.newAccount) AND $user.newAccount.registration}
                    {foreach name=key item=messageType from=$user.newAccount.registration}
                    {foreach name=key item=message from=$messageType}
                    <label>{$message}</label>
                    {/foreach}
                    {/foreach}
                    {/if}
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
</div>