<?php 
extract(shortcode_atts(array(
    'title' => '',
    'custom_links' => '',
    'images' => '',
    'el_class' => '',
), $atts));

//var_dump($atts);
$custom_links = explode( ',', $custom_links);
$images = explode( ',', $images);

if(count($images)>0){
?>
	<ul class="list-inline brands">
	<?php 
		$delay = 0;
		foreach ($images as $key => $image) {
			$img = wpb_getImageBySize(array( 'attach_id' => $image, 'thumb_size' => 'full' ));
			$link_start = $link_end = '';
			if ( isset( $custom_links[$key] ) && $custom_links[$key] != '' ) {
		        $link_start = '<a href="'.$custom_links[$key].'">';
		        $link_end = '</a>';
		    }
		    echo '<li class="wow bounceIn" data-wow-duration="1s" data-wow-delay="'.$delay.'ms">'.$link_start.$img['thumbnail'].$link_end.'</li>';
		    $delay+=300;
		} 
	?>
	</ul>
<?php
}
