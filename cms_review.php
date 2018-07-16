<?php 
/**
 * This script uses to review article 
 * supplied by article ID 
 * user can edit article , publish article and delete article 
 */

 include_once('class.inc/articleTransact.php') ;
 include_once('cms_header.inc.php') ; 
 $article_id = $_GET['article_id'] ;

 $reviewArticle = new articleTransact() ;
 $row = $reviewArticle->getArticle($article_id) ;
 extract($row) ; 
?>

<section id="review">
        <div class="review_wrapper">
        
        <h1  style="text-align:center;">Article Review</h1>
             <form action="cms_transact_article.php" method="post">

                    <input type="text" name="article_title" value="<?php echo $title ;?>" style="font-size:30px;" size="75">
                    <p><em><?php echo'By: '.$name.' | submit on: '.date('F j Y',$submit_date )  ?></em></p>

                     <strong><?php echo ($is_published==0)?'<p style="background-color:red ; color:white;font-size:18px;">Article not published</p>':'<p style="background-color:green ; color:white;font-size:18px;">Article is published</p>' ; ?></strong>

                    <textarea name="article_text" rows="50" cols="150" style="background-color:#FFFF99"><?php echo $article_text ;?></textarea>

                    <p>
                     <input type="submit" name="action" value="Edit">
                    
                       <?php 
                        if( isset($_SESSION['user_access_level']) and $_SESSION['user_access_level'] >1 ){
                            if($is_published==1){
                                echo'<input type="submit" name="action" value="Retract" >' ;
                            }else{
                                echo'<input type="submit" name="action" value="Publish" >' ;
                                echo'<input type="submit" name="action" value="Delete" >' ;
                            }
                            
                        }
                    ?>
                    <input type="hidden" name="user_id" value="<?php echo $user_id ; ?>">
                    <input type="hidden" name="article_id" value="<?php echo $article_id ; ?>"></p>
              </form>
        </div>
</section>

<?php include_once('cms_footer.inc.php') ; ?>