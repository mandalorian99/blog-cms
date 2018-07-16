<?php 
include('cms_header.inc.php') ;
include_once('class.inc/article.class.php') ;

/*$show = new article() ;
$entry = $show->output_story() ;
extract($entry) ;*/

$loop = new article() ;
$data = $loop->loop() ;

//var_dump($data) ;
//die();
/**
 * Loop through cms_article table to fetch articleId and pass it to 
 * articleTransact class where it fetch article data and return here
 */
 
 foreach( $data as $entry ){
    $articleData = $loop->output_story( $entry['article_id'] , TRUE ) ;
   // var_dump($articleData) ;
    //die() ;
    extract($articleData) ;
    ?>
    <section class="articleBox">
            <div class="featureImg">
                <img alt="feature image" src="assests/img/test.png" width=320 height=200> 
            </div>
            <div class="articles">
                 <h2><?php echo $title ; ?></h2>
                 <p> By : <em><?php echo $name ; ?></em> | <em><?php echo date('F j Y',$publish_date) ; ?></em> </p>
                 <p><?php echo $article_text ; ?></p>
            </div>
        </section>
    <?php
 }//EOL
?>

        
        
<?php include('cms_footer.inc.php') ; ?>

