<?php

global $theme_option;
?>
        	<footer id="pgl-footer" class="pgl-footer">
                <?php do_action( 'pgl_footer_layout_style' ); ?>
                <div class="footer-bottom container">
                    <div class="inner clearfix">
                        <div class="row">
                            <div class="col-sm-6 copyright">
                                <?php echo $theme_option['copyright_text']; ?>
                            </div>
                            <div class="col-sm-6 social">
                                <?php echo do_shortcode( '[pgl_social]' ); ?>
                            </div>
                        </div>
                    </div>
                </div>
        	</footer>
        </div><!--  End .wrapper-inner -->
    </div><!--  End .pgl-wrapper -->
    
    <?php do_action('pgl_after_wrapper'); ?>

	<?php wp_footer(); ?>
</body>
</html>