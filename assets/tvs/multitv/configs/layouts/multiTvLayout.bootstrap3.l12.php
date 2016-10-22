<?php

        $itemTemplates = array(
            'head_1' => array(
                'tpl' => '[+value+]',
                'tplEmpty' => '',
            ),
            'richtext_1' => array(
                'tpl' => '[+value+]',
                'tplEmpty' => '',
            ),
            'image_1' => array(
                'tpl' => '[+value+]',
                'tplEmpty' => '',
            ),
        );
    

    $template = '
        <div class="parallax parallax-1 section-title-container scroll-0" data-stellar-background-ratio="1.4" style="background:url(\'[+image_1+]\') no-repeat center center; background-size: cover;">
            <div class="[+container+]">        
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title">
                            <h3>[+head_1+]</h3>
                            <h1>[+richtext_1+]</h1>
                        </div><!-- .section-title end -->
                    </div><!-- .col-md-12 end -->
                </div><!-- .row end -->
            </div><!-- .container end -->
        </div><!-- .page-content.parallax end -->
        <div class="spacer3"></div>';
        
?>