<?php 
/**
 * This script responsible for displaying the content of article
 * It fetches content of aticle using articleID supplied through
 * Query string .
 * It also display the comment related to particular articalID
 */

 require_once('cms_header.inc.php');
 require_once('include/config.inc.php') ;
 require_once('class.inc/article.class.php') ;

 $articleID = $_GET['article_id'] ;
 $viewPost = new article() ;
 $data = $viewPost->output_story($articleID , FALSE) ;
 extract($data) ;
 //var_dump($data) ;

 /**
  * fetching article data  
  */

  $comment = new article() ;
  $cdata = $comment->showComment($articleID);
  //var_dump($cdata) ;

?>
    <section class="articleContainer">
        <div class="article_cover_img">
            <img src="assests/img/mycover.jpeg" alt="article cover pic">
        </div>

        <div class="content">
            <h1><?php echo $data['title'] ; ?></h1>
            <p><?php echo $data['article_text'] ;?></p>
        </div>
    </section>

<?php include_once('cms_comment.php') ;?>