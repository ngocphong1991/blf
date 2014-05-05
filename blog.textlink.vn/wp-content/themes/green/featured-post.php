
<?php query_posts('cat=3&showposts=1'); ?>

<?php while (have_posts()) : the_post(); $fimg = get_post_meta($post->ID, "thumb", TRUE); ?>
    
<!--featured-post-->
<div id="featured-post">
<h3>Featured Post</h3>
<div class="featured">    
<div class="cat">Categorized under: <?php the_category(', '); ?></div>       
<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
        
<span id="f-date"><?php the_time('F jS, Y') ?> . by <?php the_author() ?> . <a href="#"><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></a></span>

<p><img src="<?php echo $fimg; ?>" width="140px" height="100px" alt="<?php the_title(); ?>" /><?php the_content('') ?></p>
        
<small><?php the_tags('', ' . ', ''); ?></small>               	
        
</div>
        
<a href="<?php the_permalink() ?>" id="readmore">read more</a>
    
</div><!--featured-post-end-->
    
<?php endwhile; ?>