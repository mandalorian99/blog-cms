<?php include_once('cms_header.inc.php') ; ?>

<section id="login-container">
    <div class="login">
        <h1>Member Login</h1>

        <form action="cms_transact_user.php" method="post">
            <p>
                <label for="username">Email Address</label> 
                <input type="text" name="email">
            </p>
            
            <p>
                <label for="password">Password</label> 
                <input type="password" name="password">
            </p>
            <p><input type="submit" name="action" value="Login"></p>
            
        </form>

        <p>Not a member yet? <a href="cms_user_account.php">Create a new account</a> </p>

        <p><a href="cms_user_account.php">Forgot your password?</a> </p>
    </div><!---end login-->
</section><!---end container--> 

<?php include_once('cms_footer.inc.php') ; ?>