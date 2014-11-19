<?php

global $post;
?>
<ul class="social-networks list-unstyled">
	<li class="facebook">
		<a data-toggle="tooltip" data-original-title="Facebook" href="javascript:void(0);" onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p&#91;title&#93;=<?php the_title(); ?>&amp;p&#91;url&#93;=<?php echo esc_url(get_permalink( )); ?>')" target="_blank">
			<i class="fa fa-facebook"></i>
		</a>
	</li>
	<li class="twitter">
		<a data-toggle="tooltip" data-original-title="Twitter" onClick="window.open('http://twitter.com/home?status=<?php echo esc_url( get_the_title() ); ?><?php echo esc_url(get_the_permalink()); ?>')" href="javascript:void(0);" target="_blank">
			<i class="fa fa-twitter"></i>
		</a>
	</li>
	<li class="linkedin">
		<a data-toggle="tooltip" data-original-title="LinkedIn" href="javascript:void(0);" onClick="window.open('http://linkedin.com/shareArticle?mini=true&amp;url=<?php esc_url(get_the_permalink()); ?>&amp;title=<?php echo esc_url( get_the_title() ); ?>')" target="_blank">
			<i class="fa fa-linkedin"></i>
		</a>
	</li>
	<li class="tumblr">
		<a data-toggle="tooltip" data-original-title="Tumblr" href="javascript:void(0);" onClick="window.open('http://www.tumblr.com/share/link?url=<?php echo esc_url(get_permalink()); ?>&amp;name=<?php echo esc_url($post->post_title); ?>&amp;description=<?php echo esc_url(get_the_excerpt()); ?>')" target="_blank">
			<i class="fa fa-tumblr"></i>
		</a>
	</li>
	<li class="google">
		<a data-toggle="tooltip" data-original-title="Google +1" href="javascript:void(0);" onclick="javascript:window.open('https://plus.google.com/share?url=<?php the_permalink(); ?>',
'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank">
			<i class="fa fa-google-plus"></i>
		</a>
	</li>
	<li class="pinterest">
		<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
		<a data-toggle="tooltip" href="javascript:void(0);" data-original-title="Pinterest" onClick="window.open('http://pinterest.com/pin/create/button/?url=<?php echo esc_url(get_permalink()); ?>&amp;description=<?php echo esc_url($post->post_title); ?>&amp;media=<?php echo esc_url($full_image[0]); ?>')" target="_blank">
			<i class="fa fa-pinterest"></i>
		</a>
	</li>
	<li class="email">
		<a data-toggle="tooltip" data-original-title="Email" onclick="javascript:window.location='mailto:?subject=<?php the_title(); ?>&amp;body=<?php the_permalink(); ?>'" href="javascript:void(0);">
			<i class="fa fa-envelope"></i>
		</a>
	</li>
</ul>