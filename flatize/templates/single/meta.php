<div class="blog-meta">
	<span class="author-link">By <?php the_author_posts_link(); ?></span>
	<span class="post-category"> in <?php the_category( ', ' ); ?></span>
	<span class="published"> 
		<i class="fa fa-clock-o"></i> 
		<?php the_time( 'M d, Y' ); ?>
	</span>
	<span class="comment-count">
		<i class="fa fa-comment-o"></i>
		<?php comments_popup_link(__(' 0 comment', 'flatize'), __(' 1 comment', 'flatize'), __(' % comments', 'flatize')); ?>
	</span>
</div>