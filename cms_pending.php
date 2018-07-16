<?php 
/**
 * This script display the status of articles 
 * List of all articles which are pending 
 * here admin/moderator can edit and publish article
 */

 include_once('cms_header.inc.php') ;
 include_once('class.inc/articleTransact.php') ;
 
 $list = new articleTransact() ;
 $row = $list->displayArticleList() ;
 //var_dump($row) ; 

 /**
  * looping through return array data to display data 
  */
 $tr = NULL ;
  foreach( $row as $entry ){
      extract($entry) ;
      $status = ($is_published == 0 )?'Not published' : ' Published ' ;
      $error = ( $is_published ==0 )?'style="color:red" ' : 'style="color:green"' ;
      $tr .='<tr>
               <td> <a href="cms_review.php?article_id='.$article_id.'" >'.$title.'</a></td> 
               <td>'.$user_id.'</td> 
               <td>'.date('F j Y', $submit_date).'</td> 
               <td '.$error.' >'.$status.'</td>
            </tr> ' ;
  }
?>

<section id="article_status_list">
    <div class="tbl_wrapper">
            <table id="customers">
                <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Submit date</th>
                        <th>Status</th>
                </tr>

                <?php echo $tr ; ?>
  
            </table><br/></br>

    </div>
</section>
<?php include_once('cms_footer.inc.php') ; ?>