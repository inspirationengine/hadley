<?php 
/*
Template Name: Sitemap Page
*/
?>
<?php 
$et_ptemplate_settings = array();
$et_ptemplate_settings = maybe_unserialize( get_post_meta($post->ID,'et_ptemplate_settings',true) );

$fullwidth = isset( $et_ptemplate_settings['et_fullwidthpage'] ) ? (bool) $et_ptemplate_settings['et_fullwidthpage'] : false;
?>

<?php get_header(); ?>
	<?php if (get_option('professional_integration_single_top') <> '' && get_option('professional_integrate_singletop_enable') == 'on') echo(get_option('professional_integration_single_top')); ?>	
	
	<div id="content-top"<?php if (!$fullwidth) echo ' class="top-alt"'; ?>></div> 
	<div id="content" class="clearfix<?php if (!$fullwidth) echo(' content-alt'); ?>">
		<div id="content-area">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php get_template_part('includes/breadcrumbs'); ?>

			<?php if (get_option('professional_integration_single_top') <> '' && get_option('professional_integrate_singletop_enable') == 'on') echo(get_option('professional_integration_single_top')); ?>
								
			<div class="entry clearfix post">
				<h1 class="title"><?php the_title(); ?></h1>
				
				<?php if (get_option('professional_page_thumbnails') == 'on') { ?>
				
					<?php $thumb = '';
					$width = 184;
					$height = 184;
					$classtext = '';
					$titletext = get_the_title();
					
					$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
					$thumb = $thumbnail["thumb"]; ?>
					
					<?php if($thumb <> '') { ?>
						<div class="thumb alignleft">
							<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
							<span class="overlay"></span>
						</div> <!-- end .thumb -->
					<?php }; ?>
						
				<?php }; ?>
				
				<?php the_content(); ?>
				<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','Professional').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				
				<div id="sitemap">
					<div class="sitemap-col">
						<h2><?php esc_html_e('Pages','Professional'); ?></h2>
						<ul id="sitemap-pages"><?php wp_list_pages('title_li='); ?></ul>
					</div> <!-- end .sitemap-col -->
					
					<div class="sitemap-col">
						<h2><?php esc_html_e('Categories','Professional'); ?></h2>
						<ul id="sitemap-categories"><?php wp_list_categories('title_li='); ?></ul>
					</div> <!-- end .sitemap-col -->
					
					<div class="sitemap-col">
						<h2><?php esc_html_e('Tags','Professional'); ?></h2>
						<ul id="sitemap-tags">
							<?php $tags = get_tags();
							if ($tags) {
								foreach ($tags as $tag) {
									echo '<li><a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '">' . esc_html( $tag->name ) . '</a></li> ';
								}
							} ?>
						</ul>
					</div> <!-- end .sitemap-col -->
										
					<div class="sitemap-col<?php echo ' last'; ?>">
						<h2><?php esc_html_e('Authors','Professional'); ?></h2>
						<ul id="sitemap-authors" ><?php wp_list_authors('show_fullname=1&optioncount=1&exclude_admin=0'); ?></ul>
					</div> <!-- end .sitemap-col -->
				</div> <!-- end #sitemap -->
				
				<div class="clear"></div>
				
				<?php edit_post_link(esc_html__('Edit this page','Professional')); ?>
				
			</div> <!-- end .entry -->
                
            <?php if (get_option('professional_integration_single_bottom') <> '' && get_option('professional_integrate_singlebottom_enable') == 'on') echo(get_option('professional_integration_single_bottom')); ?>
		<?php endwhile; endif; ?>
		</div> <!-- end #content-area -->
		
		<?php if (!$fullwidth) get_sidebar(); ?>
		
	</div> <!-- end #content -->
	<div id="content-bottom"<?php if (!$fullwidth) echo ' class="bottom-alt"'; ?>></div>
	
<?php get_footer(); ?>