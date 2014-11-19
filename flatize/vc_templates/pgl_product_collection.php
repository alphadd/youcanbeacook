<?php

extract(shortcode_atts(array(
    'title' => '',
    'image' => '',
    'link' => '#',
    'el_class' => '',
), $atts));

$img_id = preg_replace('/[^\d]/', '', $image);
$img = wpb_getImageBySize(array( 'attach_id' => $img_id, 'thumb_size' => 'full', 'class' => 'img-responsive' ));

?>

<div class="collection-item">
    <a href="<?php echo $link; ?>">
        <?php echo $img['thumbnail']; ?>
    </a>
    <div class="collection-description">
        <?php if($title!=''){ ?>
        <h3><?php echo $title; ?></h3>
        <?php } ?>
        <a href="<?php echo $link; ?>">Read More</a>
    </div>
</div>