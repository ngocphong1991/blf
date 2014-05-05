<?php get_header(); ?>

	<!--content-->
	<div id="content">
    
		<!--left-col-->   
		<div id="left-col">

	<?php include('featured-post.php'); ?>

	<!--post-->
	<?php query_posts($query_string.'&cat=-3&&order=DESC'); 

	while (have_posts()) : the_post(); ?>

	<div class="post" id="post-<?php the_ID(); ?>">
		<div class="post-info">
		<?php echo get_avatar( get_the_author_id(), '85', ''); ?>
		<em><?php the_time('F jS, Y') ?></em>
		<span class="post-tag"><?php the_tags('', ' . ', ''); ?></span>
		</div>

		<div class="entry">
        <div class="cat">Categorized under: <?php the_category(', '); ?></div>
		<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
		<?php the_content(''); ?>
        
		</div>
        
		<p class="metadata"><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?> . <a href="<?php the_permalink() ?>#more-<?php the_ID(); ?>">read more</a></p>
        
 
 
	</div><!--post-end-->
	<?php endwhile; ?>
        <div class="navigation">
        	<div class="alignleft"><?php posts_nav_link('','','&laquo; Previous Entries') ?></div>
        	<div class="alignright"><?php posts_nav_link('','Next Entries &raquo;','') ?></div>
        </div> 



    
</div><!--left-col-end--> 


<?php get_sidebar(); ?>
</div><!--content-end-->

</div><!--wrapper-end-->
<?php get_footer(); ?>
