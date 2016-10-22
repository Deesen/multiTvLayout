<?php
$fieldTab = $output;
$placeholderStrings = trim( $options );

$contentArr = array();

$placeholdersArr = explode('|||', $placeholderStrings );
foreach( $placeholdersArr as $phString ) {
	$exp 		= explode('===', $phString);
	$ph  		= trim( $exp[ 0 ] );
	$content	= trim( $exp[ 1 ] );
	if( $ph && $content ) {
		$contentArr[ $ph ] = $content;
	};
};

$contentArr['container'] = 'container';


// INITIATE multiTvLayout
require_once(MODX_BASE_PATH . 'assets/tvs/multitv/includes/multiTvLayout.class.php');

$multiTvLayout = new multiTvLayout();
$multiTvLayout->setContentArr( $contentArr );
$multiTvLayout->setPreservePhs(true);

return $multiTvLayout->getHtmlOutput();

?>