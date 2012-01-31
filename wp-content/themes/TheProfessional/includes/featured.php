<div id="featured">	
	<?php global $ids;
	$ids = array();
	$arr = array();
	$i=1;
	
	$width = 943;
	$height = 345;
	$width_small = 48;
	$height_small = 48;
			
	$featured_cat = get_option('professional_feat_cat'); 
	$featured_num = get_option('professional_featured_num'); 
		
	if (get_option('professional_use_pages') == 'false') query_posts("showposts=$featured_num&cat=".get_catId($featured_cat));
	else {
		global $pages_number;
		
		if (get_option('professional_feat_pages') <> '') $featured_num = count(get_option('professional_feat_pages'));
		else $featured_num = $pages_number;
				
		query_posts(array('post_type' => 'page',
						'orderby' => 'menu_order',
						'order' => 'ASC',
						'post__in' => (array) get_option('professional_feat_pages'),
						'showposts' => (int) $featured_num));
	};
			
	while (have_posts()) : the_post();
		global $post;	
		$arr[$i]["title"] = truncate_title(25,false);
		$arr[$i]["fulltitle"] = truncate_title(250,false);
		
		$arr[$i]["excerpt"] = truncate_post(420,false);
		$arr[$i]["excerpt_small"] = truncate_post(130,false);
		
		$arr[$i]["permalink"] = get_permalink();
				
		$arr[$i]["thumbnail"] = get_thumbnail($width,$height,'',$arr[$i]["fulltitle"],$arr[$i]["fulltitle"]);
		$arr[$i]["thumb"] = $arr[$i]["thumbnail"]["thumb"];
		
		$arr[$i]["thumbnail_small"] = get_thumbnail($width_small,$height_small,'',$arr[$i]["fulltitle"],$arr[$i]["fulltitle"]);
		$arr[$i]["thumb_small"] = $arr[$i]["thumbnail_small"]["thumb"];
		
		$arr[$i]["use_timthumb"] = $arr[$i]["thumbnail"]["use_timthumb"];

		$i++;
		$ids[] = $post->ID;
	endwhile; wp_reset_query();	?>
		
	<div id="slides">
		<?php for ($i = 1; $i <= $featured_num; $i++) { ?>
			<div class="slide">
				<?php print_thumbnail($arr[$i]["thumb"], $arr[$i]["use_timthumb"], $arr[$i]["fulltitle"] ,$width, $height); ?>
				<div class="overlay"></div>
				<div class="description">
					<h2 class="title"><a href="<?php echo esc_url($arr[$i]["permalink"]); ?>"><?php echo esc_html($arr[$i]["title"]); ?></a></h2>
					<hr />
					<p><?php echo($arr[$i]["excerpt"]); ?></p>
					<a href="<?php echo esc_url($arr[$i]["permalink"]); ?>" class="readmore"><span><?php esc_html_e('read more','Professional'); ?></span></a>
				</div> <!-- end .description -->	
			</div> <!-- end .slide -->
		<?php }; ?>
	</div> <!-- end #slides-->
	
	<div id="controllers">
		<div id="controllers-top"></div>
	
		<div id="controllers-main">
			<?php for ($i = 1; $i <= $featured_num; $i++) { ?>
				<a href="#"<?php if($i == 1) echo(' class="active"'); if($i == $featured_num) echo(' class="last"'); ?> rel="<?php echo($i); ?>">
					<?php print_thumbnail($arr[$i]["thumb_small"], $arr[$i]["use_timthumb"], $arr[$i]["fulltitle"] ,$width_small, $height_small); ?>
					<span class="overlay"></span>
					<span class="tooltip">
						<span class="heading"><?php echo esc_html($arr[$i]["fulltitle"]); ?></span>
						<span class="excerpt"><?php echo($arr[$i]["excerpt_small"]); ?></span> 
						<span class="left-arrow"></span>
					</span> <!-- .tooltip -->
				</a>
			<?php }; ?>
		</div>
		
	</div> <!-- end #controllers -->
	
	<a href="#" id="left-arrow"><?php esc_html_e('Previous','Professional'); ?></a>
	<a href="#" id="right-arrow"><?php esc_html_e('Next','Professional'); ?></a>
	
</div> <!-- end #featured -->