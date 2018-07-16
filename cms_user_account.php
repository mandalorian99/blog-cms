<?php 
include_once('cms_header.inc.php') ;
include_once('class.inc/userTransact.class.php') ;

$user_id = ( isset( $_GET['user_id'] ) and ctype_digit( $_GET['user_id'] ) )? $_GET['user_id']:'' ;
//echo '<h2>user id is :'.$user_id.'</h2>';

#creating a Member class object to call getMember function to fetch indiviual data of user
if( !empty($user_id) ){
    $member = new Member() ;
    $row = $member->getMember($user_id) ;
    //var_dump($row) ;
    extract( $row ) ;
    //echo'accesslevel:'.$access_level;    
}
?>

<section id="login-container">
    <div class="login">
        <?php 
            if( !empty($user_id)  ){
                echo '<h1>Modify Account</h1>';
            }else{
                echo '<h1>Create Account</h1>';
            }
        ?>

        <form action="cms_transact_user.php" method="post">
            <p>
                <label for="username">Full Name   </label> 
                <input type="text" name="username" value="<?php echo ( isset( $name) )? $name :'' ; ?>" >
            </p>
            <p>
                <label for="email">Email Address</label> 
                <input type="text" name="email" value="<?php echo ( isset( $email) )? $email :'' ; ?>">
            </p>
            
            <?php 
                if(!empty( $user_id )){
                    ?>
                    <p>
                        <label for="access_leve">Access level 1:</label>
                        <input type="radio" name="access_level" value="1" <?php echo ($access_level == 1)?'checked="checked"':''; ?> >

                       <br/> <label for="access_leve">Access level 2:</label>
                        <input type="radio" name="access_level" value="2" <?php echo ($access_level == 2)?'checked="checked"':''; ?> >

                        <br/><label for="access_leve">Access level 3:</label>
                        <input type="radio" name="access_level" value="3" <?php echo ($access_level == 3)?'checked="checked"':''; ?> >

                        <input type="hidden" name="user_id" value="<?php echo ( isset( $user_id) )? $user_id :'' ; ?>" >
                    </p>
                    <?php
                }else{
                    ?>
                     <p>
                         <label for="password">your Password</label> 
                         <input type="password" name="password" value="" >
                     </p>               

          <?php }  ?>   

            <p><input type="submit" name="action" value="<?php echo (!empty($user_id) )?'Modify Account':'Create Account' ?>"></p>
        </form>

        <p><a href="cms_login.php">Already have account? login here</a> </p>
    </div><!---end login-->
</section><!---end container--> 

<?php include_once('cms_footer.inc.php') ; ?>
