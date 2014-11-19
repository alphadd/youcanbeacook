<?php

if ( post_password_required() ){
    return;
}
?>
<div id="comments">
    <h4 class="heading"><?php comments_number( __('0 Comment', 'flatize'), __('1 Comment', 'flatize'), __('% Comments', 'flatize') ); ?></h4>
    <?php if ( have_comments() ) { ?>
        <div class="pgl-commentlists">
    	    <ol class="commentlists list-unstyled">
    	        <?php wp_list_comments('callback=pgl_list_comments'); ?>
    	    </ol>
    	    <?php
    	    	// Are there comments to navigate through?
    	    if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
    	    ?>
    	    <footer class="navigation comment-navigation" role="navigation">
    	        <div class="previous"><?php previous_comments_link( __( '&larr; Older Comments', 'flatize' ) ); ?></div>
    	        <div class="next right"><?php next_comments_link( __( 'Newer Comments &rarr;', 'flatize' ) ); ?></div>
    	    </footer><!-- .comment-navigation -->
    	    <?php endif; // Check for comment navigation ?>

    	    <?php if ( ! comments_open() && get_comments_number() ) : ?>
    	        <p class="no-comments"><?php _e( 'Comments are closed.' , 'flatize' ); ?></p>
    	    <?php endif; ?>
        </div>
    <?php } ?>

	<?php
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $comment_args = array(
                        'title_reply'=> __('<h4 class="heading">'.__('Leave a Comment','flatize').'</h4>','flatize'),
                        'comment_field' => '<div class="form-group">
                                                <label class="field-label" for="comment">Comment:</label>
                                                <textarea rows="8" id="comment" class="form-control"  name="comment"'.$aria_req.'></textarea>
                                            </div>',
                        'fields' => apply_filters(
                        	'comment_form_default_fields',
                    		array(
                                'author' => '<div class="row"><div class="col-md-6"><div class="form-group">
                                            <label for="author">Name:</label>
                                            <input type="text" name="author" class="form-control" id="author" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $aria_req . ' />
                                            </div></div>',
                                'email' => '<div class="col-md-6"><div class="form-group">
                                            <label for="email">Email:</label>
                                            <input id="email" name="email" class="form-control" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" ' . $aria_req . ' />
                                            </div></div></div>',
                                'url' => '<div class="form-group">
                                            <label for="url">Website:</label>
                                            <input id="url" name="url" class="form-control" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '"  />
                                            </div>',
                            )),
                        'label_submit' => 'Post Comment',
						'comment_notes_before' => '<p class="h-info">'.__('Your email address will not be published.','flatize').'</p>',
						'comment_notes_after' => '',
                        );
    ?>
	<?php global $post; ?>
	<?php if('open' == $post->comment_status){ ?>
	<div class="commentform row">
    	<div class="col-sm-12">
			<?php pgl_comment_form($comment_args,'btn-primary btn-sm'); ?>
    	</div>
    </div><!-- end commentform -->
	<?php } ?>
</div><!-- end comments -->