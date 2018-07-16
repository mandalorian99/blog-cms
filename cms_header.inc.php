<?php 
#starting session 
session_start() ;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assests/css/style.css" />
    <title>comic site blog</title>
</head>
<body>
    <div id="wrapper">
        <h1>Comic book appericiatoin blog</h1>

        <?php 
            if( isset($_SESSION['user_name']) )
            echo'<p>you are currently login as: <em>'.$_SESSION['user_name'].' </em></p>' ;
            else
            echo'<p>you are not login</p>';
        ?>
        <form action="#" method="post">
            <label for="search">search: </label>
            <input type="search" name="search" >
            <input type="submit" name="submit" value="search">
        </form>
        
        <nav class="topNav">
            <ul>

            <?php 
                /**
                 * displaying menu according to access_level 
                 * access_level = 1,2,3 
                 */
                
                 if( !isset( $_SESSION['loginFlag'] ) and isset( $_SESSION['loginFlag'] ) != 1 ){
                     echo' <li><a href="cms_index.php">Artilce</a></li>' ;
                     echo' <li><a href="cms_index.php">Login</a></li>' ;
                 }else{
                    echo' <li><a href="cms_index.php">Artilce</a></li>' ;
                    echo '<li><a href="cms_compose.php">Compose</a></li>' ;

                    if( isset( $_SESSION['user_id'] ) and $_SESSION['user_access_level']>1 )
                        echo '<li><a href="cms_pending.php">Review</a></li> ' ;    
                    
                    
                    if( isset( $_SESSION['user_id'] ) and $_SESSION['user_access_level']==3 )                        
                        echo '<li><a href="cms_admin.php">Admin</a></li> ' ;    
                    
                   
                    echo '<li><a href="cms_cpanel.php">Control Panel</a></li> ' ;
                    echo '<li><a href="logout.php">Logout</a></li> ' ;
    
                 }
            ?>
               
            </ul>
        </nav>
