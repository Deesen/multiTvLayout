<?php

require_once(MODX_BASE_PATH . 'assets/tvs/multitv/includes/multiTvLayout.class.php');

$layoutKey = $output;
$layoutSettings = json_decode( $options, true );

$labelImage = isset( $layoutSettings['layoutsArr'][ $layoutKey ]['label'] ) ? strip_tags( $layoutSettings['layoutsArr'][ $layoutKey ]['label'], '<img>' ) : '';
$labelImage = multiTvLayout::mergeLanguagePlaceholders($labelImage);

$output  = '<div align="center">';
$output .= 		$labelImage;
$output .= 		'<br/>[ '. strtoupper($layoutKey) .' ]';
$output .= 		isset( $layoutSettings['layoutsArr'][ $layoutKey ]['desc'] ) ? '<br/><br/><i>'. $layoutSettings['layoutsArr'][ $layoutKey ]['desc'] .'</i>' : '';
$output .= '</div>';

return $output;

?>