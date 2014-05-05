<?php get_header(); ?>

	<!--content-->
	<div id="content">
    
		<!--left-col-->   
		<div id="left-col">

	<?php if (have_posts()) : ?>

		<h2 class="pagetitle">Search Results</h2>


		<?php while (have_posts()) : the_post(); ?>

			<div class="post">
			<div class="post-info">
			<?php echo get_avatar( get_the_author_id(), '85', ''); ?>
			<em><?php the_time('F jS, Y') ?></em>
			<span class="post-tag"><?php the_tags('', ' . ', ''); ?></span>
			</div>

			<div class="entry">
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
        	<?php ob_start(); the_excerpt(); echo ld_clean(ob_get_clean()); ?>
			<p class="metadata"><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?> . <a href="<?php the_permalink() ?>#more-<?php the_ID(); ?>">read more</a></p>
			</div>
			</div>

		<?php endwhile; ?>

		<div class="navigation">
        	<div class="alignleft"><?php next_posts_link('Previous Page') ?></div>
        	<div class="alignright"><?php previous_posts_link('Next Page') ?></div>
		</div>

	<?php else : ?>

		<h2 class="center">No posts found. Try a different search?</h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>



</div><!--left-col-end--> 


<?php get_sidebar(); ?>
</div><!--content-end-->

</div><!--wrapper-end-->
<?php get_footer(); ?>