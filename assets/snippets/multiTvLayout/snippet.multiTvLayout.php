<?php
/**
 * multiTvLayout
 *
 * This snippet renders the HTML-output of a multiTvLayout-TV 
 *
 * @category      snippet
 * @version       0.3
 * @license       http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal      @properties
 * @documentation https://github.com/Deesen/multiTvLayout
 * @reportissues  https://github.com/Deesen/multiTvLayout
 * @author        Deesen
 * @lastupdate    22/10/2016
 *                
 * Default call:
 *
	[[multiTvLayout?
		&tvName=`multiTvLayout`
		&id=`[*id*}`
		&layoutId=`bootstrap3`
		&container=`container`
		&noContent=`No content given`
	]]               
 * 
 * layoutId = key for row-templates like multiTvLayout.bootstrap3.l1.php
 * container = special placeholder for outer-wrapper class (Bootstraps container / container-fluid)             
 */

if( !isset( $id )) { return 'Param id not set'; };
if( !isset( $tvName )) { return 'Param tvName not set'; };
if( !isset( $layoutId )) { return 'Param layoutId not set'; };
$container = isset( $container ) ? $container : 'container';
$noContent = isset( $noContent ) ? $noContent : 'No content given';
	
$templateVars = $modx->getTemplateVarOutput(true, $id, true); // CHECK PUBLISHED FIRST

if( empty( $templateVars ) && $_SESSION['mgrRole'] == '1') {
	$templateVars = $modx->getTemplateVarOutput(true, $id, false); // CHECK UNPUBLISHED FOR DEVELOPMENT
};

if( isset($templateVars[$tvName]) && !empty( $templateVars[$tvName] )) {
	
	$multiTvArr = json_decode( $templateVars[$tvName], true);
	
	if( !empty( $multiTvArr['fieldValue'] )) {
		
		// INITIATE multiTvLayout
		require_once(MODX_BASE_PATH . 'assets/tvs/multitv/includes/multiTvLayout.class.php');
		$multiTvLayout = new multiTvLayout();
		$output = '';
		
		foreach( $multiTvArr['fieldValue'] as $contentArr ) {
			
			$contentArr['layoutId'] = $layoutId;
			$contentArr['container'] = $container;
			
			$multiTvLayout->setContentArr( $contentArr );
			$output .= $multiTvLayout->getHtmlOutput();
			
		};
		
		return $output;
	}
};

return $noContent;
?>