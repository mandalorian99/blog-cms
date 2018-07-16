<?php 
/**
 * display the comment section below the article
 * data is driven by its respective class
 */


?>

<ul class="comment-section">

<li class="comment user-comment">
    <div class="info">
        <a href="#">Anie Silverston</a>
        <span>4 hours ago</span>
    </div>
    <a class="avatar" href="#">
        <img src="images/avatar_user_1.jpg" width="35" alt="Profile Avatar" title="Anie Silverston" />
    </a>
    <p>Suspendisse gravida sem?</p>
</li>

<li class="comment author-comment">
    <div class="info">
        <a href="#">Jack Smith</a>
        <span>3 hours ago</span>
    </div>
    <a class="avatar" href="#">
        <img src="images/avatar_author.jpg" width="35" alt="Profile Avatar" title="Jack Smith" />
    </a>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse gravida sem sit amet molestie portitor.</p>

</li>

<!-- More comments -->

<li class="write-new">

    <form action="#" method="post">
        <textarea placeholder="Write your comment here" name="comment"></textarea>
        <div>
            <img src="images/avatar_user_2.jpg" width="35" alt="Profile of Bradley Jones" title="Bradley Jones" />
            <button type="submit">Submit</button>
        </div>
    </form>

</li>

</ul>

<?php require_once('cms_header.inc.php') ;?>