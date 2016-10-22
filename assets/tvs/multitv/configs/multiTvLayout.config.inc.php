<?php
/*
 * multiTvLayout Config-file
 *
 * Dynamically modifies the configuration for multiTv to display custom HTML-templates, and display them
 * structured the same inside manager as in frontend. Create Bootstrap-Grids with rows/columns using MultiTv.
 * 
 * Placeholders:
 * 
 *   [+template-placeholders+]
 *   [%language-placeholders%]
 *
 * Custom Language-Files can be created in languages/multiTvLayout/custom
 * 
 **/

require_once(MTV_BASE_PATH.'includes/multiTvLayout.class.php');

// INJECT NESSECARY CSS-FILES INTO MANAGER
if(IN_MANAGER_MODE=="true" && !defined('MODX_API_MODE') || MODX_API_MODE != true) {
    $tvpath = '../' . $this->options['tvUrl'];
    echo '	<link rel="stylesheet" type="text/css" href="' . $tvpath . 'css/multiTvLayout.css" />';
    echo '	<link rel="stylesheet" type="text/css" href="' . $tvpath . 'css/bootstrap_modx.css" />';
}

// PREPARE LAYOUT-ELEMENTS-STRING
$previewPath = '/assets/tvs/multitv/configs/layouts/';  // HOLDS PREVIEW-IMAGES AND ROW-TEMPLATES
$layoutId = 'bootstrap3'; // KEY ADDED TO TEMPLATE-FILES, I.E. multiTvLayout.bootstrap3.l1.php

// AVAILABLE ROW-LAYOUTS AND PREVIEW-IMAGES, USING <br/><br/> FOR ALIGNING BUTTONS INTO ROWS
// [%language-placeholders%] allowed
$layoutSettings = array(
    'previewPath' => $previewPath,
    'layoutsArr' => array(
        'l1' => array('label'  => '<img src="' . $previewPath . 'l1-oneCol.png" style="display:inline;" />', 'desc' => ''),
        'l2' => array('label'  => '<img src="' . $previewPath . 'l2-twoCol.png" />',        'desc' => ''),
        'l3' => array('label'  => '<img src="' . $previewPath . 'l3-threeCol.png" />',      'desc' => ''),
        'l9' => array('label'  => '<img src="' . $previewPath . 'l9-twoColIconText.png" /><br/><br/>', 'desc' => '2 Columns with Icons'),
        'l5' => array('label'  => '<img src="' . $previewPath . 'l5-oneThree.png" />',      'desc' => ''),
        'l6' => array('label'  => '<img src="' . $previewPath . 'l6-threeOne.png" />',      'desc' => ''),
        'l7' => array('label'  => '<img src="' . $previewPath . 'l7-oneThirdTwo.png" />',   'desc' => ''),
        'l8' => array('label'  => '<img src="' . $previewPath . 'l8-twoThirdOne.png" /><br/><br/>', 'desc' => ''),
        'l4' => array('label'  => '<img src="' . $previewPath . 'l4-fourCol.png" />',       'desc' => ''),
        'l10' => array('label' => '<img src="' . $previewPath . 'l10-fourColLightbox.png" />', 'desc' => '4 Columns feat. Lightboxes'),
        'l11' => array('label' => '<img src="' . $previewPath . 'l11-fullWidth.png" />',    'desc' => 'Full Viewport-Width'),
        'l12' => array('label' => '<img src="' . $previewPath . 'l12-parallax.png" />',     'desc' => 'Parallax-Image'),
    )
);

// PREPARE ELEMENTS-STRING
$layoutElements = multiTvLayout::renderSettingsFieldsElements( $layoutSettings );

//////////////////////////////////////////////////////////////////////////////// MULTI-TV START
// YOUR MULTI-TV SETTINGS
// [%language-placeholders%] allowed
$settings['display'] = 'datatable';
$settings['fields'] = array(
    // TAB "Inhalte"
    'layoutKey' => array(
        'caption' => '[%row_layout%]',
        'type' => 'option',
        'elements' => $layoutElements,
        'default' => 'l1'
    ),
    'head_1' => array(
        'section'=>'[%block%] 1',
        'caption' => '<b>[ 1 ]</b> [%headline%]',
        'type' => 'text'
    ),
    'richtext_1' => array(
        'caption' => '<b>[ 1 ]</b> [%richtext%]',
        'type' => 'richtext'
    ),
    'image_1' => array(
        'caption' => '<b>[ 1 ]</b> [%image%]',
        'type' => 'image'
    ),
    'head_2' => array(
	    'section'=>'[%block%] 2',
        'caption' => '<b>[ 2 ]</b> [%headline%]',
        'type' => 'text'
    ),
    'richtext_2' => array(
        'caption' => '<b>[ 2 ]</b> [%richtext%]',
        'type' => 'richtext'
    ),
    'image_2' => array(
        'caption' => '<b>[ 2 ]</b> [%image%]',
        'type' => 'image'
    ),
    'head_3' => array(
	    'section'=>'[%block%] 3',
        'caption' => '<b>[ 3 ]</b> [%headline%]',
        'type' => 'text'
    ),
    'richtext_3' => array(
        'caption' => '<b>[ 3 ]</b> [%richtext%]',
        'type' => 'richtext'
    ),
    'image_3' => array(
        'caption' => '<b>[ 3 ]</b> [%image%]',
        'type' => 'image'
    ),
    'head_4' => array(
	    'section'=>'[%block%] 4',
        'caption' => '<b>[ 4 ]</b> [%headline%]',
        'type' => 'text'
    ),
    'richtext_4' => array(
        'caption' => '<b>[ 4 ]</b> [%richtext%]',
        'type' => 'richtext'
    ),
    'image_4' => array(
        'caption' => '<b>[ 4 ]</b> [%image%]',
        'type' => 'image'
    ),

    // TAB "Bild-Optionen"
    'opt_image_1' => array(
        'caption' => '<b>[ 1 ]</b> [%image_type%]',
        'type' => 'option',
        'elements' => 'Standard==standard||Lightbox==lightbox||100% [%background%]==bg100',
        'default' => 'standard'
    ),
    'opt_image_2' => array(
        'caption' => '<b>[ 2 ]</b> [%image_type%]',
        'type' => 'option',
        'elements' => 'Standard==standard||Lightbox==lightbox',
        'default' => 'standard'
    ),
    'opt_image_3' => array(
        'caption' => '<b>[ 3 ]</b> [%image_type%]',
        'type' => 'option',
        'elements' => 'Standard==standard||Lightbox==lightbox',
        'default' => 'standard'
    ),
    'opt_image_4' => array(
        'caption' => '<b>[ 4 ]</b> [%image_type%]',
        'type' => 'option',
        'elements' => 'Standard==standard||Lightbox==lightbox',
        'default' => 'standard'
    ),

    // TAB "Links"
    'link_image_1' => array(
        'caption' => '<b>[ 1 ]</b> [%image_link%]',
        'type' => 'text'
    ),
    'link_image_2' => array(
        'caption' => '<b>[ 2 ]</b> [%image_link%]',
        'type' => 'text'
    ),
    'link_image_3' => array(
        'caption' => '<b>[ 3 ]</b> [%image_link%]',
        'type' => 'text'
    ),
    'link_image_4' => array(
        'caption' => '<b>[ 4 ]</b> [%image_link%]',
        'type' => 'text'
    ),
    'link_moreinfos_1' => array(
        'caption' => '<b>[ 1 ]</b> [%button_read_more%]',
        'type' => 'text'
    ),
    'link_moreinfos_2' => array(
        'caption' => '<b>[ 2 ]</b> [%button_read_more%]',
        'type' => 'text'
    ),
    'link_moreinfos_3' => array(
        'caption' => '<b>[ 3 ]</b> [%button_read_more%]',
        'type' => 'text'
    ),
    'link_moreinfos_4' => array(
        'caption' => '<b>[ 4 ]</b> [%button_read_more%]',
        'type' => 'text'
    ),
    'link_download_1' => array(
        'caption' => '<b>[ 1 ]</b> [%button_download%]',
        'type' => 'text'
    ),
    'link_download_2' => array(
        'caption' => '<b>[ 2 ]</b> [%button_download%]',
        'type' => 'text'
    ),
    'link_download_3' => array(
        'caption' => '<b>[ 3 ]</b> [%button_download%]',
        'type' => 'text'
    ),
    'link_download_4' => array(
        'caption' => '<b>[ 4 ]</b> [%button_download%]',
        'type' => 'text'
    ),

    // TAB "SEO"
    'img_alt_1' => array(
        'caption' => '<b>[ 1 ]</b> [%image_attr_alt%]',
        'type' => 'text'
    ),
    'img_alt_2' => array(
        'caption' => '<b>[ 2 ]</b> [%image_attr_alt%]',
        'type' => 'text'
    ),
    'img_alt_3' => array(
        'caption' => '<b>[ 3 ]</b> [%image_attr_alt%]',
        'type' => 'text'
    ),
    'img_alt_4' => array(
        'caption' => '<b>[ 4 ]</b> [%image_attr_alt%]',
        'type' => 'text'
    ),
    
    // TAB "Spalten"
    'chunk_1' => array(
        'caption' => '<b>[ 1 ]</b> Chunk',
        'type' => 'text'
    ),
    'chunk_2' => array(
        'caption' => '<b>[ 2 ]</b> Chunk',
        'type' => 'text'
    ),
    'chunk_3' => array(
        'caption' => '<b>[ 3 ]</b> Chunk',
        'type' => 'text'
    ),
    'chunk_4' => array(
        'caption' => '<b>[ 4 ]</b> Chunk',
        'type' => 'text'
    ),
    'icon_1' => array(
        'caption' => '<b>[ 1 ]</b> [%icon%]',
        'type' => 'text'
    ),
    'icon_2' => array(
        'caption' => '<b>[ 2 ]</b> [%icon%]',
        'type' => 'text'
    ),
    'icon_3' => array(
        'caption' => '<b>[ 3 ]</b> [%icon%]',
        'type' => 'text'
    ),
    'icon_4' => array(
        'caption' => '<b>[ 4 ]</b> [%icon%]',
        'type' => 'text'
    ),
    'col_css_1' => array(
        'caption' => '<b>[ 1 ]</b> [%column_css_class%]',
        'type' => 'text'
    ),
    'col_css_2' => array(
        'caption' => '<b>[ 2 ]</b> [%column_css_class%]',
        'type' => 'text'
    ),
    'col_css_3' => array(
        'caption' => '<b>[ 3 ]</b> [%column_css_class%]',
        'type' => 'text'
    ),
    'col_css_4' => array(
        'caption' => '<b>[ 4 ]</b> [%column_css_class%]',
        'type' => 'text'
    ),
    
    // TAB "Reihen-Optionen"
    'row_spacer_top' => array(
        'caption' => '[%spacer_top%]',
        'type' => 'option',
        'elements' => '0px||25px||50px||75px||100px',
        'default'=>'0px'
    ),
    'row_spacer_bottom' => array(
        'caption' => '[%spacer_bottom%]',
        'type' => 'option',
        'elements' => '0px||25px||50px||75px||100px',
        'default'=>'0px'
    ),
    'row_head_class' => array(
        'caption' => '[%headline_class%]',
        'type' => 'option',
        'elements' => '[%dark%]==heading||Style 1==custom-heading||Style 2==custom-heading02||[%dark%]==photo-heading',
        'default'=>'heading'
    ),
    'row_text_color' => array(
        'caption' => '[%text_class%]',
        'type' => 'option',
        'elements' => '[%dark%]==dark||[%bright%]==bright',
        'default'=>'dark'
    ),
    'row_bg_color' => array(
        'caption' => '[%background_class%]',
        'type' => 'option',
        'elements' => '[%bright%]==white||[%semi%]==grey||[%dark%]==dark',
        'default'=>'white'
    ),
    
	// AVAILABLE MULTITV-TYPES
    /*
    'file' => array(
            'caption' => 'File',
            'type' => 'file'
    ),
    'image' => array(
            'caption' => 'Image',
            'type' => 'image'
    ),
    'thumb' => array(
            'caption' => 'Thumbnail',
            'type' => 'thumb',
            'thumbof' => 'image'
    ),
    'textarea' => array(
            'caption' => 'Textarea',
            'type' => 'textarea'
    ),
    'date' => array(
            'caption' => 'Date',
            'type' => 'date'
    ),
    'dropdown' => array(
            'caption' => 'Dropdown',
            'type' => 'dropdown',
            'elements' => '@SELECT pagetitle, id FROM [+PREFIX+]site_content WHERE parent = 0 ORDER BY menuindex ASC'
    ),
    'listbox' => array(
            'caption' => 'Listbox',
            'type' => 'listbox',
            'elements' => '1||2||3||4||5'
    ),
    'listbox-multiple' => array(
            'caption' => 'Listbox (multiple)',
            'type' => 'listbox-multiple',
            'elements' => 'Orange||Apple||Strawberry'
    ),
    'checkbox' => array(
            'caption' => 'Checkbox',
            'type' => 'checkbox',
            'elements' => 'Yes==1||No==0'
    ),
    */
);

// MULTIPLE ARRAYS SET MULTIPLE FIELD-TABS FOR [+fieldTab+]
$settings['form'] = array(
    array(
        'caption' => '[%content%]',
        'value' => 'general',
        'content' => array(
            'layoutKey' => array(),
            'head_1' => array(),
            'image_1' => array(),
            'richtext_1' => array(),
            'head_2' => array(),
            'image_2' => array(),
            'richtext_2' => array(),
            'head_3' => array(),
            'image_3' => array(),
            'richtext_3' => array(),
            'head_4' => array(),
            'image_4' => array(),
            'richtext_4' => array(),
        )
    ),
    array(
        'caption' => '[%links%]',
        'value' => 'row_options',
        'content' => array(
            'link_image_1' => array(),
            'link_image_2' => array(),
            'link_image_3' => array(),
            'link_image_4' => array(),
            'link_moreinfos_1' => array(),
            'link_moreinfos_2' => array(),
            'link_moreinfos_3' => array(),
            'link_moreinfos_4' => array(),
            'link_download_1' => array(),
            'link_download_2' => array(),
            'link_download_3' => array(),
            'link_download_4' => array(),
        )
    ),
    array(
        'caption' => '[%images%]',
        'value' => 'image_options',
        'content' => array(
            'opt_image_1' => array(),
            'opt_image_2' => array(),
            'opt_image_3' => array(),
            'opt_image_4' => array(),
        )
    ),
    array(
        'caption' => '[%seo%]',
        'value' => 'seo',
        'content' => array(
            'img_alt_1' => array(),
            'img_alt_2' => array(),
            'img_alt_3' => array(),
            'img_alt_4' => array(),
        )
    ),    
    array(
        'caption' => '[%columns%]',
        'value' => 'col_options',
        'content' => array(
            'chunk_1' => array(),
            'chunk_2' => array(),
            'chunk_3' => array(),
            'chunk_4' => array(),
            'icon_1'=>array(),
            'icon_2'=>array(),
            'icon_3'=>array(),
            'icon_4'=>array(),
            'col_css_1'=>array(),
            'col_css_2'=>array(),
            'col_css_3'=>array(),
            'col_css_4'=>array(),
        )
    ),
    array(
        'caption' => '[%row%]',
        'value' => 'row_options',
        'content' => array(
            'row_spacer_top' => array(),
            'row_spacer_bottom' => array(),
            'row_head_class' => array(),
            'row_text_color' => array(),
            'row_bg_color' => array(),
        )
    ),
);

// MODIFY FIELD-KEYS FOR YAMS
// @todo: check for yams and add langSuffix dynamically
// $multiLanguageTypesArr = array('head','richtext');
// $languageSuffixArr = array('de','en');

// DISABLE MULTILANGUAGE-CONTENT 
$multiLanguageTypesArr = array();
$languageSuffixArr = array();

$settings = multiTvLayout::renderSettingsFieldsMultilingual( $multiLanguageTypesArr, $languageSuffixArr, $settings );

// LAYOUT datatable INSIDE MANAGER
$settingsColumnsContentsRender = multiTvLayout::renderSettingsColumnsContentsRender( $layoutId, $settings['fields'] );

// LAYOUT datatable
$settings['columns'] = array(
    array(
        'caption' => '[%row_layout%]',
        'fieldname' => 'layoutKey',
        'render' => '[+layoutKey:multiTvRenderDatatableRowLayoutImg=`' . json_encode($layoutSettings) . '`+]',
        'width' => '64',
        // 'render' => '[+fieldTab:multiTvRenderDatatableRow=``+]'
        // 'fieldname' => 'head_1',
        //'render' => '[+fieldTab:select=`text=<table><tr><td>[+title1_1+][+content1_1:notags:limit+]</td></tr></table>&twocol=<table><tr><td>[+title2_1+][+content2_1:notags:limit+]</td><td>[+title2_2+][+content2_2:notags:limit+]</td></tr></table>`+]'
    ),
	array(
		'caption' => '[%content%]',
		'fieldname' => 'contents',
		'render' => '[+fieldTab:multiTvRenderDatatableRowFromPhs=`'. $settingsColumnsContentsRender .'`+]'
    )
);

// TRANSLATE TABLE-HEAD
$settings = multiTvLayout::renderSettingsColumnsCaptions( $settings );

$settings['configuration'] = array(
    'enablePaste' => true,
    'enableClear' => true,
    'radioTabs' => false,
    'csvseparator' => ';',
    // 'editBoxWidth' => '1000px'	// NOT USED FOR DATATABLE
);