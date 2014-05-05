<!--right-col-->  
<div id="right-col">

    <!--rss subscriber-->  
    <div id="feed">
        <a href="<?php bloginfo('rss2_url'); ?>" class="rss">RSS</a>Subscribe to my feed now.
    </div><!--rss subscriber-end-->

    <!--search-->  

    	<?php include (TEMPLATEPATH . '/searchform.php'); ?>


	<?php include('about.php'); ?>

        <!--sidebar-->             
        <div id="sidebar"><h3>Sidebar</h3>
         	<?php include('sidebar-left.php'); ?>
    		<?php include('sidebar-right.php'); ?>                   
        </div><!--sidebar-end-->  
           
</div><!--right-col-end-->  


