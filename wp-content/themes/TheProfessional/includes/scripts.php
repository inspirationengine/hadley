<?php global $shortname; ?>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/jquery.cycle.all.min.js"></script> 
	<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/jquery.easing.1.3.js"></script>	
	<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/superfish.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/jquery.lavalamp.1.3.3-min.js"></script>	
	<script type="text/javascript">
	//<![CDATA[
		jQuery.noConflict();
	
		jQuery('ul.nav').superfish({ 
			delay:       200,                            // one second delay on mouseout 
			animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation 
			speed:       'fast',                          // faster animation speed 
			autoArrows:  true,                           // disable generation of arrow mark-up 
			dropShadows: false                            // disable drop shadows 
		});
		
		jQuery('ul.nav > li > a.sf-with-ul').parent('li').addClass('sf-ul');
		
		
		<!---- lavalamp ---->
		jQuery('ul.nav ul > li').addClass('noLava');
			
		var startLink = 0;
		
		jQuery('ul.nav > li.current-cat-parent, ul.nav > li.current-cat, ul.nav > li.current-page-ancestor, ul.nav > li.current_page_parent, ul.nav > li.current_page_item').each(function(){
			startLink = jQuery(this).prevAll().length;
		});
		
		jQuery('ul.nav').lavaLamp({ startItem: startLink });
		if ( startLink !=0 ) jQuery('ul.nav > li.backLava').animate({left:'+=2'},0);
		
		
		et_search_bar();
		et_cycle_integration();
		
				
		jQuery('#controllers-main a').hover(function(){
			jQuery(this).find('span.tooltip').animate({ opacity: 'show', left: '-222px' }, 300);
		},function(){
			jQuery(this).find('span.tooltip').animate({ opacity: 'hide', left: '-232px' }, 300);
		}); 
		
		
		function et_cycle_integration(){
			var $featured = jQuery('#featured'),
				$featured_content = jQuery('#slides'),
				$controller = jQuery('#controllers'),
				$controller2 = jQuery('#controllers2'),
				$slider_control_tab = $controller.find('a');
				$slider_control_tab2 = $controller2.find('a.switch');
		
			if ($featured_content.length) {
				$controller.css("opacity","0").find('a img').css("opacity","0.7").end().find('a.active img').css("opacity","1");
				
				$featured_content.cycle({
					fx: '<?php echo esc_js(get_option($shortname.'_slider_effect')); ?>',
					timeout: 0,
					speed: 700,
					cleartypeNoBg: true
				});
				
			};
			
			var pause_scroll = false;
			
			jQuery('#slides, #controllers').hover(function(){
				$controller.stop().animate({opacity: 1, top: "30px"},500);
				<?php if (get_option($shortname.'_pause_hover') == 'on') { ?>
					pause_scroll = true;
				<?php }; ?>
			}).mouseleave(function(){
				$controller.stop().animate({opacity: 0, top: "15px"},500);
				<?php if (get_option($shortname.'_pause_hover') == 'on') { ?>
					pause_scroll = false;
				<?php }; ?>
			});
			
			$slider_control_tab.hover(function(){
				jQuery(this).find('img').stop().animate({opacity: 1},300);
			}).mouseleave(function(){
				if (!jQuery(this).hasClass("active")) jQuery(this).find('img').stop().animate({opacity: 0.7},300);
			});
			
			
			var ordernum;				
			
			function gonext(this_element){
				ordernum = this_element.attr("rel");

				//console.log("Cur: ", this_element, ordernum);
				var $control_el2 = jQuery('a.switch[rel="' + ordernum + '"]',$controller2);
				$controller2.find("a.active").removeClass('active');
				$control_el2.addClass('active');
				
				
				$controller.find("a.active img").stop().animate({opacity: 0.7},300).parent('a').removeClass('active');
				
				this_element.addClass('active').find('img').stop().animate({opacity: 1},300);
				
				
				$featured_content.cycle(ordernum-1);
				
				if (typeof interval != 'undefined') {
					clearInterval(interval);
					auto_rotate();
				};
			}
			
			$slider_control_tab.click(function(){
				gonext(jQuery(this));
				return false;
			});
			
			 $slider_control_tab2.click(function(){
			    var rel = jQuery(this).attr("rel");
			    var $controlel = jQuery('a[rel="' + rel + '"]',$controller);
			    //console.log("g", rel, $controlel);
			    
        		    gonext($controlel);
        		    return false;
    			});

			
			
			var $nextArrow = jQuery('a#right-arrow'),
				$nextArrow2 = jQuery('a#right-arrow2'),
				$prevArrow = jQuery('a#left-arrow'),
				$prevArrow2 = jQuery('a#left-arrow2');
			
			var nextMethod = function(){
				var activeSlide = $controller.find('a.active').attr("rel"),
					$nextSlide = $controller.find('a:eq('+ activeSlide +')');
				
				if ($nextSlide.length) gonext($nextSlide)
				else gonext($controller.find('a:eq(0)'));
				
				return false;
			};
			
			var prevMethod = function(){
				var activeSlide = $controller.find('a.active').attr("rel")-2,
					$nextSlide = $controller.find('a:eq('+ activeSlide +')');
								
				if ($nextSlide.length && activeSlide != -1) { gonext($nextSlide); }
				else {
					var slidesNum = $slider_control_tab.length - 1;
					gonext($controller.find('a:eq('+ slidesNum +')'));
				};
				
				return false;
			};
			
			$nextArrow.click(nextMethod);
			$nextArrow2.click(nextMethod);
			
			$prevArrow.click(prevMethod);
			$prevArrow2.click(prevMethod);
			
						
			<?php if (get_option($shortname.'_slider_auto') == 'on') { ?>
				auto_rotate();
			<?php }; ?>
			
			function auto_rotate(){
				interval = setInterval(function() {
					if (!pause_scroll) $nextArrow.click();
				}, <?php echo esc_js(get_option($shortname.'_slider_autospeed')); ?>);
			};
				
		};
		
		
		<!---- Search Bar Improvements ---->
		function et_search_bar(){
			var $searchform = jQuery('#menu div#search-form'),
				$searchinput = $searchform.find("input#searchinput"),
				searchvalue = $searchinput.val();
				
			$searchinput.focus(function(){
				if (jQuery(this).val() === searchvalue) jQuery(this).val("");
			}).blur(function(){
				if (jQuery(this).val() === "") jQuery(this).val(searchvalue);
			});
		};
		
		<?php if (get_option($shortname.'_disable_toptier') == 'on') echo('jQuery("ul.nav > li > ul").prev("a").attr("href","#");'); ?>
		
	//]]>	
	</script>