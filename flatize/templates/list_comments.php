<?php

$GLOBALS['comment'] = $comment;
$add_below = '';

?>
<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">

	<div class="the-comment">
		<div class="avatar">
			<?php echo get_avatar($comment, 54); ?>
		</div>

		<div class="comment-box">

			<div class="comment-author meta">
				<strong><?php echo get_comment_author_link() ?></strong>
				<br>
				<small>
					<i class="fa fa-clock-o"></i>
					<?php printf(__('%1$s at %2$s', 'flatize'), get_comment_date(),  get_comment_time()) ?>
				</small>
			</div>

			<div class="comment-text">
				<?php if ($comment->comment_approved == '0') : ?>
				<em><?php echo __('Your comment is awaiting moderation.', 'flatize') ?></em>
				<br />
				<?php endif; ?>
				<?php comment_text() ?>
			</div>
			
			<div class="comment-action">
				<small>
					<?php edit_comment_link(__('<i class="fa fa-pencil"></i> Edit', 'flatize'),'  ','') ?>
					<?php comment_reply_link(array_merge( $args, array( 'reply_text' => __('<i class="fa fa-reply"></i> Reply', 'flatize'), 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</small>
			</div>

		</div>

	</div>