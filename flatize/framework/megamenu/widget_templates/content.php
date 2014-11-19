<?php


$add_class = (esc_attr($atts['class'])=='')?'':' '.esc_attr( $atts['class'] );

?>

<div class="content <?php echo $add_class; ?>">
    <?php echo stripslashes($atts['content']); ?>
</div>