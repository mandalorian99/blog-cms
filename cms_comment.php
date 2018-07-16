<br/><br/>
<div class="commentWrapper">
    <p><h2>We love to here from you </h2></p>
		<ul id="comment-section">

			<!---li class="comment user-comment">

                <div class="info">
                    <a href="#">Anie Silverston</a>
                    <span>4 hours ago</span>
                </div>

                <a class="avatar" href="#">
                    <img src="assests/img/avatar_user_1.jpg" width="35" alt="Profile Avatar" title="Anie Silverston" />
                </a>

                <p>Suspendisse gravida sem?</p>

			</li-->

			<!---li class="comment author-comment">

                <div class="info">
                    <a href="#">Jack Smith</a>
                    <span>3 hours ago</span>
                </div>

                <a class="avatar" href="#">
                    <img src="assests/img/avatar_author.jpg" width="35" alt="Profile Avatar" title="Jack Smith" />
                </a>

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse gravida sem sit amet molestie portitor.</p>

			</li-->

            <?php 
                /**
                 * Parse incoming comment data send by article class comment function
                 */
                $counter = 1 ;
                 foreach( $cdata as $entry ){
                     extract($entry) ;
                     ?>
                        <li class="comment <?php echo ( $counter%2 ==0 )?'author-comment':'user-comment' ?>">

                                <div class="info">
                                    <a href="#"><?php echo $name ; ?></a>
                                    <span>3 hours ago</span>
                                </div>

                                <a class="avatar" href="#">
                                    <img src="assests/img/avatar_author.jpg" width="35" alt="Profile Avatar" title="Jack Smith" />
                                </a>

                                <p><?php echo $comment_text ; ?></p>

			            </li>

                     <?php
                     $counter++ ;
                 }//EOL
            ?>

			
            <li class="write-new" style="list-style:none;"> 

                <form action="cms_transact_article.php" method="post">

                    <textarea placeholder="Write your comment here" name="comment_text" value=""></textarea>
                    <input type="hidden" name="article_id" value="<?php echo $article_id ;?>">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ;?>">

                    <div>
                        <img src="assests/img/avatar_user_2.jpg" width="35" alt="Profile of Bradley Jones" title="Bradley Jones" />
                        <button type="submit" name="action" value="Add comment">Submit</button>
                    </div>

                    
                </form>
                

            </li>

		</ul>
</div><br/><br/>


<?php include_once('cms_footer.inc.php') ?>
      
	