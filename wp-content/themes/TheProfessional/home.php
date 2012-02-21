<?php get_header(); ?>
	
	<div id="sidebar-homepage" class="sidebar">
		<div class="content-top"></div>
		<div class="content clearfix">
		    <?php dynamic_sidebar( 'home_page' ); ?>
		</div>
		<div id="content-bottom"<?php if (get_option('professional_blog_style') == 'on') echo(' class="bottom-alt"'); ?>></div>
	</div>
	
	<div id="content-top"<?php if (get_option('professional_blog_style') == 'on') echo(' class="top-alt"'); ?>></div>
	<div id="content" class="clearfix<?php if (get_option('professional_blog_style') == 'on') echo(' content-alt'); ?>">
		<?php if (get_option('professional_blog_style') == 'false') { ?>

			<?php for ($i = 1; $i <= 3; $i++) { ?>
				<?php query_posts('page_id=' . get_pageId(html_entity_decode(get_option('professional_service_'.$i)))); while (have_posts()) : the_post(); ?>
					<div class="service">
						<?php $icon = '';
						$icon = get_post_meta($post->ID, 'Icon', true);
						$tagline = '';
						$tagline = get_post_meta($post->ID, 'Tagline', true); ?>
						
						<?php if ($icon <> '') { ?>
							<img class="service-icon" alt="" src="<?php echo esc_url($icon); ?>"/>
						<?php }; ?>
						
						<h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						
						<?php if ($tagline <> '') { ?>
							<span class="tagline"><?php echo esc_html($tagline); ?></span>
						<?php }; ?>
						
						<div class="hr"></div>
						<?php global $more;   
						$more = 0;
						the_content(""); ?>
						<a href="<?php the_permalink(); ?>" class="readmore"><span><?php esc_html_e('read more','Professional'); ?></span></a>
					</div> <!-- end .service -->
				<?php endwhile; wp_reset_query(); ?>
			<?php }; ?>
			
		<?php } else { ?>
			<div id="content-area">
				<?php get_template_part('includes/entry','home'); ?>
			</div> <!-- end #content-area -->
			
			<?php get_sidebar(); ?>
			
		<?php }; ?>
		
	</div> <!-- end #content-->
	<div id="content-bottom"<?php if (get_option('professional_blog_style') == 'on') echo(' class="bottom-alt"'); ?>></div>
				
<?php get_footer(); ?>			