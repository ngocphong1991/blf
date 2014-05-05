<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

	<!--content-->
	<div id="content">
    
		<!--left-col-->   
		<div id="left-col">
			<div class="post">


				<h2>Archives by Month:</h2>
				<ul>
				<?php wp_get_archives('type=monthly'); ?>
				</ul>

				<h2>Archives by Subject:</h2>
				<ul>
				<?php wp_list_categories('title_li='); ?>
				</ul>


		
        
        </div><!--post-end-->
	</div><!--left-col-end--> 
<?php get_sidebar(); ?>
</div><!--content-end-->

</div><!--wrapper-end-->
<?php get_footer(); ?>
