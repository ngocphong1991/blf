<?php
/*
Template Name: Links
*/
?>


<?php get_header(); ?>

	<!--content-->
	<div id="content">
    
		<!--left-col-->   
		<div id="left-col">
			<div class="post">
                <ul class="links">
                <?php wp_list_bookmarks(); ?>
                </ul>


		
        
        </div><!--post-end-->
	</div><!--left-col-end--> 
<?php get_sidebar(); ?>
</div><!--content-end-->

</div><!--wrapper-end-->
<?php get_footer(); ?>