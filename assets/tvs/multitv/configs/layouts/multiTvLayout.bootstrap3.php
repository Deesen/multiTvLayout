<?php

// Activate Multilanguage
// @todo: Get from YAMS
// $this->setLanguageSuffixesArr(array('de','en'));

$rawTpl = array(
    'tpl' => '[+value+]',
    'tplEmpty' => ''
);

if($event == 'onMultiTvLayoutInit') {

    $typeTemplates = array(
        'head' => array(
            'tpl' => '
                <div class="[+row_head_class+]">
                    <h3>[+value+]</h3>
                </div>',
            'tplEmpty' => '',
        ),
        'image' => array(
            'tpl' => '<img class="img-responsive img-fullwidth" src="[+value+]" alt="" />',
            'tplEmpty' => '',
        ),
        'richtext' => array(
            'tpl' => '
                            <div class="text">
                                [+value+]
                            </div>',
            'tplEmpty' => '',
        ),

    );
};

/*
// NORMALLY NOT USEFUL AS GLOBAL DEFAULT - USE IT IN CUSTOM LAYOUTS
$itemTemplates = array(
        'head_1'=>array(
                'tpl'=>'
                                <div class="headline no-margin"><br>
                                        <h4>[+value+] ItemDefault</h4>
                                </div>',
                'tplEmpty'=>'',
        ),
);
*/

/*
Available variables

head_1
richtext_1
image_1
chunk_1

opt_image_1 = standard, bg100, parallax

link_image_1
link_moreinfos_1

icon_1
col_css_1

row_spacer_top
row_spacer_bottom
row_text_color
row_bg_color
row_head_class
 
*/

if($event == 'onBeforeParseContentArray') {
    // HANDLE SEPARATELY
    // Handle 100% width Background
    if ($this->contentArr['opt_image_1'] == 'bg100') {
        $this->itemTemplates['image_1'] = $rawTpl;
        $this->contentArr['bg_image_1'] = ' style="background:url(' . $this->contentArr['image_1'] . ') no-repeat center center;background-size:cover;"';
        $this->contentArr['image_1'] = '';
    } else {
        $this->contentArr['bg_image_1'] = '';
    }
    
    // HANDLE IN FOR-I LOOP
    for($i=1;$i<=4;$i++) {
        // Handle Heading CSS-Class
        if ($this->contentArr['row_head_class'] != 'heading' && !empty($this->contentArr['row_head_class'])) {
            if($this->contentArr['row_head_class'] == 'custom-heading') {
                $this->itemTemplates['head_' . $i] = array(
                    'tpl' => '
                                <div class="[+row_head_class+]">
                                    <h3>[+value+]</h3>
                                </div>
                                ' . $this->contentArr['richtext_' . $i],
                    'tplEmpty' => ''
                );
                $this->contentArr['richtext_' . $i] = '';
            }
            if($this->contentArr['row_head_class'] == 'custom-heading02') {
                $this->itemTemplates['head_' . $i] = array(
                    'tpl' => '
                                <div class="[+row_head_class+]">
                                    <h3>[+value+]</h3>
                                    '. $this->contentArr['richtext_' . $i] .'
                                </div>
                                ',
                    'tplEmpty' => ''
                );
                $this->contentArr['richtext_' . $i] = '';
            }
        }
        
        // Handle link_moreinfos
        if($this->contentArr['link_moreinfos_'.$i] != '') {
            if(is_numeric($this->contentArr['link_moreinfos_'.$i])) {
                $link = '[~'.$this->contentArr['link_moreinfos_'.$i].'~]';
                $target = '';
            } else {
                $link = $this->contentArr['link_moreinfos_'.$i];
                $target = ' target="_blank"';
            }
            
            $this->contentArr['link_moreinfos_'.$i] = '<a class="moreinfos" href="'.$link.'"'.$target.'>Mehr Informationen</a>';
        }

        // Handle link_download
        if($this->contentArr['link_download_'.$i] != '') {

            $fileExtension = 'link';
            
            if(is_numeric($this->contentArr['link_download_'.$i])) {
                $link = '[~'.$this->contentArr['link_download_'.$i].'~]';
            } else {
                $link = $this->contentArr['link_download_'.$i];

                $lastDotPos = strrpos($link, '.');
                if ( $lastDotPos ) $fileExtension = strtolower(substr($link, $lastDotPos+1));
            }
            $target = ' target="_blank"';
            
            switch($fileExtension) {
                case 'pdf':
                    $icon = 'fa-file-pdf-o';
                    break;
                default:
                    $icon = 'fa-external-link';
            }
                
            $this->contentArr['link_download_'.$i] = '<a class="download '.$fileExtension.'" href="'.$link.'"'.$target.'><span>Download <i class="fa '.$icon.'"></i></span></a>';
        }
        
        // Handle col_css
        if($this->contentArr['col_css_'.$i] != '') {
            $this->contentArr['col_css_'.$i] = ' '.trim($this->contentArr['col_css_'.$i]);
        }
        
        // Duplicate images for lightbox-use etc (without <img>)
        $this->contentArr['raw_image_'.$i] = $this->contentArr['image_'.$i];
        
    };
};

if($event == 'onParseRowTemplate') {
    // HANDLE SEPARATELY
    
    // HANDLE IN FOR-I LOOP
    for($i=1;$i<=4;$i++) {
        // Handle link_image
        if(!isset($skipRenderLinkImage)) {
            
            // Handle linked Images
            if($this->contentArr['link_image_'.$i] != '' && $this->contentArr['image_'.$i] != '') {
                if(is_numeric($this->contentArr['link_image_'.$i])) {
                    $link = '[~'.$this->contentArr['link_image_'.$i].'~]';
                    $target = '';
                } else {
                    $link = $this->contentArr['link_image_'.$i];
                    $target = ' target="_blank"';
                }
                $this->contentArr['image_'.$i] = '<a class="img-link" href="'.$link.'"'.$target.'>'.$this->contentArr['image_'.$i].'</a>';
            }
            
            // Handle Lightboxes    
            else if ($this->contentArr['opt_image_'.$i] == 'lightbox' && $this->contentArr['image_'.$i] != '') {
                $this->contentArr['image_'.$i] = '<a class="triggerZoom" href="'.$this->contentArr['raw_image_'.$i].'">'.$this->contentArr['image_'.$i].'</a>';
            }
            
        }
    }
};

?>