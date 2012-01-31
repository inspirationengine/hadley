<?php get_header(); ?>
	
	<div id="content-top" class="top-alt"></div>
	<div id="content" class="clearfix content-alt">
		<div id="content-area">
			<?php get_template_part('includes/breadcrumbs'); ?>
				
			<?php get_template_part('includes/entry'); ?>
		</div> <!-- end #content-area -->
		
		<?php get_sidebar(); ?>
		
	</div> <!-- end #content -->
	<div id="content-bottom" class="bottom-alt"></div>
				
<?php get_footer(); ?>