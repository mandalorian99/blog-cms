<?php 
/**
 * Admin page for administrator .Administrtor can view and edit the user account
 * delete user and change user access level 
 */

 include_once('cms_header.inc.php') ;
 require_once('include/cms_auth.inc.php') ;
 require_once('class.inc/userTransact.class.php');

 $member = new Member() ;
 $row =  $member->getMembers(0,10 , 'access_level') ;

 $list1 ='' ;
 $list2 ='' ;
 $list3 ='' ;

 foreach($row as $member){

     if(  $member['access_level']==1)
         $list1 .= '<li><a href="cms_user_account.php?user_id='.$member['user_id'].' "> '.$member['name'].' </a></li>' ;
    else if($member['access_level']==2)
         $list2 .= '<li><a href="cms_user_account.php?user_id='.$member['user_id'].' "> '.$member['name'].' </a></li>' ;
    else{
        $list3 .= '<li><a href="cms_user_account.php?user_id='.$member['user_id'].' "> '.$member['name'].' </a></li>' ;
        if( empty($list3) )
        echo '<em>There is no administrator</em>';
    }
        
 }
?>


<section id="user-admin">
    <h1>User administrator</h1>
    <div class="user-list">
        <h3>User</h3>
            <ul>
                <?php echo $list1 ;?>
            </ul
    </div><!---end user list-->

    <div class="moderator-list">
        <h3>Moderator</h3>
             <ul>
                <?php echo  $list2;?>
            </ul

    </div><!---end of moderator list-->

    <div class="admin-list">
        <h3>Adminstrator</h3>
            <ul>
                <?php echo $list3 ;?>
            </ul

    </div><!---end of adminlist-->
</section><!---end section-->

<?php include_once('cms_footer.inc.php') ; ?>