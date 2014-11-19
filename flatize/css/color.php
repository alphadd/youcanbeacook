<?php

global $theme_option;

//return;
$main_color = $theme_option['style_main_color'];
if($main_color=='custom'){
  $main_color = $theme_option['style_main_custom'];
}

$color_hover = pgl_adjustColorLightenDarken( $main_color,20 );

$main_font = (isset($theme_option['font-main'])) ? $theme_option['font-main']['font-family'] : '';
$main_font_weight = (isset($theme_option['font-main'])) ? $theme_option['font-main']['font-weight'] : '400';

$heading_font = (isset($theme_option['font-heading'])) ? $theme_option['font-heading']['font-family'] : '';
$heading_font_weight = (isset($theme_option['font-heading'])) ? $theme_option['font-heading']['font-weight'] : '400';

?>


<?php // Custom Font 
  if($main_font ){
?>
body,#pgl-mainnav .megamenu a, #pgl-mainnav .megamenu span,.pgl-sidebar ul li a{
  font-family: <?php echo $main_font; ?>;
  font-weight: <?php echo $main_font_weight; ?>
}
<?php } ?>

<?php 
  if($heading_font ){
?>
h1,h2,h3,h4,h5,h6,.product-block .name,.woocommerce .price,#pgl-footer .widget .widget-title{
  font-family: <?php echo $heading_font; ?>;
  font-weight: <?php echo $heading_font_weight; ?>
}
<?php } ?>

.btn:hover,.btn:focus,.btn-primary,.btn-white:hover,.btn-white:focus,.post-image,.post-meta a,.bag-new,.product-thumb-info-content .item-cat a:hover,.product-thumb-info-content .item-cat a:focus,.scroll-to-top,.btn-custom,.btn-custom.disabled,
.btn-custom[disabled],
fieldset[disabled] .btn-custom,
.btn-custom.disabled:hover,
.btn-custom[disabled]:hover,
fieldset[disabled] .btn-custom:hover,
.btn-custom.disabled:focus,
.btn-custom[disabled]:focus,
fieldset[disabled] .btn-custom:focus,
.btn-custom.disabled:active,
.btn-custom[disabled]:active,
fieldset[disabled] .btn-custom:active,
.btn-custom.disabled.active,
.btn-custom[disabled].active,
fieldset[disabled] .btn-custom.active,.wp-ads li,.shoppingcart .badge,.search-wrapper .form-submit:hover,.pgl-sidebar .widget_calendar caption,#pgl-mainbody .tparrows:hover,#pgl-mainbody .tp-bullets.simplebullets.round > .bullet.selected,
#pgl-mainbody .tp-bullets.simplebullets.round > .bullet:hover,.nav-tabs.tab-widget li.active a,.widget_price_filter .price_slider_wrapper .ui-slider .ui-slider-range,.post-thumb a.post-img-1:hover,.product-block .button-item a.button.loading,
.product-block .button-item a.button:hover,.woocommerce-page .display li a.active .fa,.woocommerce-page a.button.alt,
.woocommerce-page input.button.alt,
.woocommerce-page a.button,.product-quickview .woocommerce .btn-cart:hover,#pgl-off-canvas .navbar-nav > li > a:hover,#pgl-off-canvas .navbar-nav > li.active > a,.topbar-menu > ul > li:hover > a,#pgl-header .cart-header .fa:hover{
	background-color: <?php echo $main_color; ?>;
}

.btn.btn-primary:hover{
  background-color:#333;
  border-color:#333;
}


/* Color */
a:hover,a:focus,.post-meta a,.price,.product-thumb-info-content .item-cat a:hover,.product-thumb-info-content .item-cat a:focus,.tagcloud a:hover,.tagcloud a:focus,.login-wrapper a:hover,.login-wrapper a:focus,.banner-element h2 a:hover,.product-slide .owl-controls .owl-buttons .owl-prev:hover,.product-slide .owl-controls .owl-buttons .owl-next:hover,.product-slide .owl-controls .owl-buttons .owl-prev:focus,.product-slide .owl-controls .owl-buttons .owl-next:focus,address.contact a:hover,.menu-topbar .dropdown-menu ul > li a:hover,.menu-topbar .dropdown-menu ul > li.active a,.shoppingcart p.total .amount,.shoppingcart .name a:hover,#pgl-header .contact-header span,.post-container .entry-title a:hover,.pgl-sidebar ul.product-categories li:hover > a,.pgl-sidebar ul.product-categories li:hover > span.count,.pgl-sidebar ul.product-categories li.current-cat-parent > a,.pgl-sidebar ul.product-categories li.current-cat ul li:hover,.pgl-sidebar ul.product-categories li.cat-parent ul li:hover,.pgl-sidebar ul.product-categories li.current-cat,.pgl-sidebar ul.product-categories li.current-cat > a,.pgl-sidebar ul li a:hover,#pgl-footer .footer-top a:hover,#pgl-footer .widget .tagcloud a:hover,#pgl-footer .footer-bottom a,#pgl-footer .footer-bottom .social-networks li a:hover,.pgl_search:hover .fa,.grid-posts .title a:hover,.item-product-widget .product-meta .title a:hover,.item-product-widget .product-meta .category a:hover,.blog-meta a,.commentlists .the-comment .comment-box .comment-action a:hover,.product-meta .amount,.product-block .name a:hover,.product-block .price,.woocommerce-tabs .nav-tabs > li.active a,#single-product div.summary .woocommerce-review-link:hover,#single-product div.summary .price,.shop_table td.product-subtotal,#pgl-off-canvas .navbar-nav li.active > a,#pgl-off-canvas .navbar-nav > li a:hover,#pgl-mainnav .megamenu .woocommerce .product-meta .title a:hover,#pgl-mainnav .dropdown-menu .product-block .name a:hover,.panel-heading a:hover,.shop_table .order-total .amount{
	color: <?php echo $main_color; ?>;
}

#pgl-mainnav .megamenu > li.active > a,#pgl-mainnav .megamenu > li:hover > a,#pgl-mainnav .pgl-col .pgl-col-inner ul li a:focus, #pgl-mainnav .pgl-col .pgl-col-inner ul li a:hover,#pgl-mainnav .pgl-col .pgl-col-inner ul li.active a{
	color: <?php echo $main_color; ?>!important;
}

/* Border */
.btn:hover,.btn:focus,.btn-primary,.btn-white:hover,.btn-white:focus,.tagcloud a:hover,.tagcloud a:focus,.product-slide .owl-controls .owl-buttons .owl-prev:hover,
.product-slide .owl-controls .owl-buttons .owl-next:hover,
.product-slide .owl-controls .owl-buttons .owl-prev:focus,
.product-slide .owl-controls .owl-buttons .owl-next:focus,.btn-custom,.btn-custom:hover,
.btn-custom:focus,
.btn-custom:active,
.btn-custom.active,
.open .dropdown-toggle.btn-custom,.btn-custom.disabled,
.btn-custom[disabled],
fieldset[disabled] .btn-custom,
.btn-custom.disabled:hover,
.btn-custom[disabled]:hover,
fieldset[disabled] .btn-custom:hover,
.btn-custom.disabled:focus,
.btn-custom[disabled]:focus,
fieldset[disabled] .btn-custom:focus,
.btn-custom.disabled:active,
.btn-custom[disabled]:active,
fieldset[disabled] .btn-custom:active,
.btn-custom.disabled.active,
.btn-custom[disabled].active,
fieldset[disabled] .btn-custom.active,#pgl-footer .widget .tagcloud a:hover,.woocommerce-page .display li a.active .fa,
.product-quickview .woocommerce .btn-cart:hover {
	border-color: <?php echo $main_color; ?>;
}

.newsletter-subscribe-form .subscribe:hover:after{
	border-left-color: <?php echo $main_color; ?>;
}

.nav-tabs.tab-widget li.active a:after{
	border-top-color: <?php echo $main_color; ?>;
}

.woocommerce-tabs .nav-tabs > li.active a{
	border-right-color:<?php echo $main_color; ?>;
}

.blog-container .blog-title a:hover,.blog-meta a:hover,{
	color:<?php  echo $color_hover; ?>;
}

@-moz-keyframes bounce_fountainG {
  0% {
    -moz-transform: scale(1);
    background-color: <?php echo $main_color; ?>;
  }
  100% {
    -moz-transform: scale(0.3);
    background-color: transparent;
  }
}
@-webkit-keyframes bounce_fountainG {
  0% {
    -webkit-transform: scale(1);
    background-color: <?php echo $main_color; ?>;
  }
  100% {
    -webkit-transform: scale(0.3);
    background-color: transparent;
  }
}
@-ms-keyframes bounce_fountainG {
  0% {
    -ms-transform: scale(1);
    background-color: <?php echo $main_color; ?>;
  }
  100% {
    -ms-transform: scale(0.3);
    background-color: transparent;
  }
}
@-o-keyframes bounce_fountainG {
  0% {
    -o-transform: scale(1);
    background-color: <?php echo $main_color; ?>;
  }
  100% {
    -o-transform: scale(0.3);
    background-color: transparent;
  }
}
@keyframes bounce_fountainG {
  0% {
    transform: scale(1);
    background-color: <?php echo $main_color; ?>;
  }
  100% {
    transform: scale(0.3);
    background-color: transparent;
  }
}

