<?php
	if ( is_home() ){
		global $ids;
		if (get_option('professional_duplicate') == 'false') {
			$args=array(
				   'showposts'=> (int) get_option('professional_homepage_posts'),
				   'post__not_in' => $ids,
				   'paged'=>$paged,
				   'category__not_in' => (array) get_option('professional_exlcats_recent'),
			);
		} else {
			$args=array(
			   'showposts'=> (int) get_option('professional_homepage_posts'),
			   'paged'=>$paged,
			   'category__not_in' => (array) get_option('professional_exlcats_recent'),
			);
		};
		query_posts($args);
	}
?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php $thumb = '';
	$width = 184;
	$height = 184;
	$classtext = '';
	$titletext = get_the_title();

	$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
	$thumb = $thumbnail["thumb"]; ?>

	<div class="entry clearfix">
		<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php get_template_part('includes/postinfo'); ?>
		
		<?php if ($thumb <> '' && get_option('professional_thumbnails_index') == 'on') { ?>
			<div class="thumb alignleft">
				<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
				<a href="<?php the_permalink(); ?>"><span class="overlay"></span></a>
			</div> <!-- end .thumb -->
		<?php }; ?>
		<?php if (get_option('professional_blog_style') == 'false') { ?>
			<p><?php truncate_post(550);?></p>
		<a href="<?php the_permalink(); ?>" class="readmore"><span><?php esc_html_e('read more','Professional'); ?></span></a>
		<?php } else { ?>
			<?php the_content(''); ?>
		<?php }; ?>
	</div> <!-- end .entry -->
<?php endwhile; ?>
	<div class="hr-separator"></div>
	<div class="entry page-nav clearfix">
		<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
		else { ?>
			 <?php get_template_part('includes/navigation'); ?>
		<?php } ?>
	</div> <!-- end .entry -->
<?php else : ?>
	<?php get_template_part('includes/no-results'); ?>
<?php endif; if ( is_home() ) wp_reset_query(); ?>