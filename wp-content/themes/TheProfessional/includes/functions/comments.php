<?php if ( ! function_exists( 'et_custom_comments_display' ) ) :
function et_custom_comments_display($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
   <div id="comment-<?php comment_ID(); ?>" class="comment-body clearfix">
		<div class="avatar">
			<?php echo get_avatar($comment,$size='57'); ?>
			<span class="overlay"></span>
		</div>
		
		<div class="comment-wrap">
			
			<div class="comment-author vcard">
				<?php printf('<span class="fn">%s</span>', get_comment_author_link()) ?> <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php echo(get_comment_date()) ?></a><?php edit_comment_link(esc_html__('(Edit)','Professional'),'  ','') ?></div>
			</div>
			
			<?php if ($comment->comment_approved == '0') : ?>
				<em class="moderation"><?php esc_html_e('Your comment is awaiting moderation.','Professional') ?></em>
				<br />
			<?php endif; ?>
			
		    <div class="comment-content"><?php comment_text() ?></div> <!-- end comment-content-->
		    <?php 
			$et_comment_reply_link = get_comment_reply_link( array_merge( $args, array('reply_text' => esc_attr__('reply','TheProfessional'),'depth' => $depth, 'max_depth' => $args['max_depth'])) );
			if ( $et_comment_reply_link ) echo '<div class="reply-container">' . $et_comment_reply_link . '</div>';
		?>
		</div> <!-- end comment-wrap-->  
	</div> <!-- end comment-body-->
<?php }
endif; ?>