<?php

global $theme_option;
?>

<?php get_header(); ?>

<section class="page_not_found">
	<div class="container text-center clearfix">
		<div class="icon-404">
			<i class="fa fa-frown-o"></i>
		</div>
		<h1>404</h1>	
		<div class="col-sm-6 col-sm-offset-3">
			<?php echo $theme_option['404_text'];  ?>
			<?php get_search_form(); ?>
			<div class="button-return">
				<a href="<?php echo home_url(); ?>" class="btn btn-default"><?php echo __('Return to the previous page','flatize'); ?></a>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>