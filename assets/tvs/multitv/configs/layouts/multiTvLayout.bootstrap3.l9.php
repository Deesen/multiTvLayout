<?php

$typeTemplates['head'] = $rawTpl;
$typeTemplates['image'] = $rawTpl;

$skipRenderLinkImage = true;

$template = '
            <div class="custom-bkg bkg-[+row_bg_color+] rt-[+row_text_color+]" [+image_1_bg+]>
                <div class="spacer-[+row_spacer_top+]"></div>
                <div class="[+container+]">
                     <div class="row">
                                        <div class="col-md-4 col-sm-4[+col_css_1+]">
                                            <div class="service-feature-box">
                                                <div class="service-media">
                                                    <img src="[+image_1+]" alt="[+img_alt_1+]"/>
                                                    <a href="[~[+link_image_1+]~]" class="read-more02"><span>weitere Infos <i class="fa fa-chevron-right"></i></span>[+chunk_1+]</a>
                                                </div>
                                                <div class="service-body">
                                                    <div class="custom-heading">
                                                        <h4>[+head_1+]</h4>
                                                    </div>
                                                    [+richtext_1+]
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4[+col_css_2+]">
                                            <div class="service-feature-box">
                                                <div class="service-media">
                                                    <img src="[+image_2+]" alt="[+img_alt_2+]"/>
                                                    <a href="[~[+link_image_2+]~]" class="read-more02"><span>weitere Infos <i class="fa fa-chevron-right"></i></span></a>
                                                </div>
                                                <div class="service-body">
                                                    <div class="custom-heading">
                                                        <h4>[+head_2+]</h4>
                                                    </div>
                                                    [+richtext_2+]
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4[+col_css_3+]">
                                            <div class="service-feature-box">
                                                <div class="service-media">
                                                    <img src="[+image_3+]" alt="[+img_alt_3+]"/>
                                                    <a href="[~[+link_image_3+]~]" class="read-more02"><span>weitere Infos <i class="fa fa-chevron-right"></i></span></a>
                                                </div>
                                                <div class="service-body">
                                                    <div class="custom-heading">
                                                        <h4>[+head_3+]</h4>
                                                    </div>
                                                    [+richtext_3+]
                                                </div>
                                            </div>
                                        </div>
                     </div>
                </div>
                <div class="spacer-[+row_spacer_bottom+]"></div>
            </div>
    ';

?>