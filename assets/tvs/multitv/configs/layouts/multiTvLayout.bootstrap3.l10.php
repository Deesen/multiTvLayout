<?php
        $typeTemplates = array(
            'head'=>array(
                'tpl'=>'<h5>[+value+]</h5>',
                'tplEmpty'=>'',
            ),
            'image'=>array(
                'tpl'=>'[+value+]',
                'tplEmpty'=>'',
            ),


        );

    $template = '
        <div class="[+container+]">
            <div class="row">
                <div class="col-md-3">
                        <div class="picture"><a href="[+image_1+]" rel="image" title="[+phx:input=`[+head_1+]`:striptags+]"><img class="u-max-full-width" src="[[phpthumb? &input=`[+image_1+]` &options=`w=280,h=180,far=C,zc=1`]]" alt="[+img_alt_1+]" /><div class="image-overlay-zoom"></div></a></div>
                    <div class="item-description">
                                            [+head_1+]
                                            [+richtext_1+]
                                            [+chunk_1+]
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="picture"><a href="[+image_2+]" rel="image" title="[+phx:input=`[+head_2+]`:striptags+]"><img class="u-max-full-width" src="[[phpthumb? &input=`[+image_2+]` &options=`w=280,h=180,far=C,zc=1`]]" alt="[+img_alt_2+]" /><div class="image-overlay-zoom"></div></a></div>
                    <div class="item-description">
                                            [+head_2+]
                                            [+richtext_2+]
                                            [+chunk_2+]
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="picture"><a href="[+image_3+]" rel="image" title="[+phx:input=`[+head_3+]`:striptags+]"><img class="u-max-full-width" src="[[phpthumb? &input=`[+image_3+]` &options=`w=280,h=180,far=C,zc=1`]]" alt="[+img_alt_3+]" /><div class="image-overlay-zoom"></div></a></div>
                    <div class="item-description">
                                            [+head_3+]
                                            [+richtext_3+]
                                            [+chunk_3+]
                                        </div>
                </div>
                <div class="col-md-3">
                    <div class="picture"><a href="[+image_4+]" rel="image" title="[+phx:input=`[+head_4+]`:striptags+]"><img class="u-max-full-width" src="[[phpthumb? &input=`[+image_4+]` &options=`w=280,h=180,far=C,zc=1`]]" alt="[+img_alt_4+]" /><div class="image-overlay-zoom"></div></a></div>
                    <div class="item-description">
                                            [+head_4+]
                                            [+richtext_4+]
                                            [+chunk_4+]
                                        </div>
                </div>
            </div>
            [+bottomSpacer+]
        </div>
    ';

?>