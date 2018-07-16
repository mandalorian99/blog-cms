<?php 
/**
 * Provide auther with a simple text editor to write a article
 * Also used to edit article 
 */

 require_once('include/config.inc.php') ;
 require_once('cms_header.inc.php') ;

 /**
  * function to display text editor 
  */
 function displayEditor( $data ){
    $user_id = ( isset( $_SESSION['user_id'] ) )?$_SESSION['user_id'] :'' ; 
  //  echo $user_id ;
    //var_dump($_SESSION)   
?>
<section id="txt-editor" >
    <div class="txt-wrapper">
        <h2>Compose Article</h2>

        <form action="cms_transact_article.php" method="post">
            <p>
                <input type="hidden" name="user_id" value="<?php echo $user_id ; ?>" >
                <label for="article_title">Title</label>
                <input type="text" name="article_title" maxlength="255" >
            </p>
            <P>
                <label for="artical_txt">Text</label>
                 <textarea  rows="20" cols="60" name="article_txt" id="" cols="30" rows="10">Enter article</textarea>
            </P>

            <P>
                    <input type="submit" name="action" value="Submit New Article" >
                    <input type="submit" name="action" value="Edit New Article">
            </P>
            
            
        
        </form>
        <br/></br/>
    </div>
</section>

<?php }//end of function ?>

<?php 
    /**
     * displaying text editor 
     */
    displayEditor( array() ) ;
?>

<?php require_once('cms_footer.inc.php') ; ?>