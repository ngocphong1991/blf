<?php get_header(); ?>

	<!--content-->
	<div id="content">
    
		<!--left-col-->   
		<div id="left-col">

		<?php if (have_posts()) : ?>

 	  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<h2 class="pagetitle"><strong><?php single_cat_title(); ?></strong></h2>
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h2 class="pagetitle"><strong><?php single_tag_title(); ?></strong></h2>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2 class="pagetitle">Archive for <strong><?php the_time('F jS, Y'); ?></strong></h2>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2 class="pagetitle">Archive for <strong><?php the_time('F, Y'); ?></strong></h2>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2 class="pagetitle">Archive for <strong><?php the_time('Y'); ?></strong></h2>
 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2 class="pagetitle">Blog Archives</h2>
 	  <?php } ?>

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
        

        

        
		<div class="navigation">
        	<div class="alignleft"><?php next_posts_link('Previous Page') ?></div>
        	<div class="alignright"><?php previous_posts_link('Next Page') ?></div>
		</div>
        
        </div><!--post-end-->
		<?php endwhile; ?>



	<?php else : ?>

		<h2 class="center">Not Found</h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>

	</div>
    
<?php get_sidebar(); ?>
</div><!--content-end-->

</div><!--wrapper-end-->

<?php get_footer(); ?>
