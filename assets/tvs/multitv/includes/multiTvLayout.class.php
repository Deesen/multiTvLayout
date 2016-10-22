<?php
/*
 * multiTvLayout v0.3
 * Updated: 22.10.2016
 * 
 * */

class multiTvLayout
{
    public $contentArr = array();                // HOLDS ARRAY OF PLACEHOLDER-CONTENT INCL $layoutKey
    public $layoutId = NULL;                     // HOLDS ID LIKE "skeleton2", "bootstrap" TO DETERMINE LAYOUT-FILES multiTvLayout.skeleton2.l1
    public $layoutKey = NULL;                    // HOLDS KEY LIKE l1
    public $templatePlaceholders = array();      // HOLDS ARRAY OF ALL EXISTING PLACEHOLDERS
    public $typeTemplates = array();             // HOLDS ARRAY OF DEFAULT ITEM-TEMPLATES PER TYPE
    public $itemTemplates = array();             // HOLDS ARRAY OF CUSTOM TEMPLATES FOR SPECIFIC ITEMS
    public $relevantItemTypes = array();         // HOLDS ARRAY OF ALL RELEVANT TYPES WHERE VALUES WILL BE MODIFIED DYNAMICALLY
    public $typePerItemArr = array();            // HOLDS ARRAY OF ITEM-KEY<->TYPE
    public $itemsPerType = array();              // HOLDS ARRAY OF TOTAL COUNT PER TYPE
    public $headTitlesOnly = false;              // SETS TO true IF ONLY head_1, head_2 ETC IS GIVEN
    public $preservePhs = false;                 // SETS TO true RESULTS IN NO EXECUTION OF PHs FOR DISPLAY IN MANAGER
    public $langSuffixesArr = array();           // HOLDS LANGUAGE-CODES OF YAMS

    static $language = NULL;                     // HOLDS TRANSLATIONS FOR PLACEHOLDER [%head%]

    function __construct()
    {
        $this->relevantItemTypes = array('head', 'richtext', 'image', 'chunk');
    }

    public function setContentArr($contentArr)
    {
        $this->layoutId = $contentArr['layoutId'];
        $this->layoutKey = $contentArr['layoutKey'];
        $this->contentArr = $contentArr;
    }

    public function getHtmlOutput()
    {
        global $modx;

        // RESET VARS
        $template = NULL;
        $tplConfig = NULL;
        $this->itemTemplates = array();
        $this->typeTemplates = array();

        // LAYOUT - DEFAULTS
        $event = 'onMultiTvLayoutInit'; // TRIGGER onMultiTvLayoutInit-EVENT
        require(MODX_BASE_PATH . 'assets/tvs/multitv/configs/layouts/multiTvLayout.' . $this->layoutId . '.php');
        if (isset($typeTemplates)) { $this->typeTemplates = $typeTemplates; };
        if (isset($itemTemplates)) { $this->itemTemplates = $itemTemplates; };

        // LOAD CUSTOM LAYOUT
        require(MODX_BASE_PATH . 'assets/tvs/multitv/configs/layouts/multiTvLayout.' . $this->layoutId . '.' . $this->layoutKey . '.php');        // DEFINES $template AND LETS OVERWRITE DEFAULTS
        if (isset($typeTemplates)) { $this->typeTemplates = array_merge($this->typeTemplates, $typeTemplates); };
        if (isset($itemTemplates)) { $this->itemTemplates = array_merge($this->itemTemplates, $itemTemplates); };

        // TRIGGER onBeforeParseContentArray-EVENT FROM MAIN-CONFIG
        $event = 'onBeforeParseContentArray';
        require(MODX_BASE_PATH . 'assets/tvs/multitv/configs/layouts/multiTvLayout.' . $this->layoutId . '.php');
        
        // MODIFY CONTENT-ARRAY - REMOVE CHUNKS IN IN_MANAGER PARSING FOR EXAMPLE
        $this->determineContentArrayTypes($tplConfig);
        $this->modifyContentArrayValues($tplConfig);
        $this->renderContentArrayHtml($tplConfig);

        // TRIGGER onParseRowTemplate-EVENT FROM MAIN-CONFIG
        $event = 'onParseRowTemplate';
        require(MODX_BASE_PATH . 'assets/tvs/multitv/configs/layouts/multiTvLayout.' . $this->layoutId . '.php');
         
        // NOW REPLACE PLACEHOLDERS WITH MODIFIED CONTENT-ARRAY OR REMOVE THEM TO LEAVE NO [+tags+] LEFT IN HTML-OUTPUT
        $template = $modx->parseText($template, $this->contentArr);
        
        // BUILD ARRAY CONTAINING ALL PLACEHOLDERS EXISTING IN TEMPLATE
        $placeholders = $modx->getTagsFromContent($template);
        if(isset($placeholders[0])) {
            foreach ($placeholders[0] as $i => $ph) {
                $value = isset($this->contentArr[$placeholders[1][$i]]) ? $this->contentArr[$placeholders[1][$i]] : '';
                $template = str_replace($placeholders[0][$i], $value, $template);
            };
        };

        return $template;
    }

    public function determineContentArrayTypes($tplConfig)
    {
        // RESET VARS
        $this->typePerItemArr = array();
        $this->itemsPerType = array();

        // BUILD FIELD<->TYPE-ARRAY
        foreach ($this->contentArr as $key => $value) {
            $exp = explode('_', $key);
            $type = $exp[0];
            $index = isset($exp[1]) ? $exp[1] : 'x';
            if (in_array($type, $this->relevantItemTypes) && is_numeric($index)) { // Removed "&& !isset($exp[2])" for multilanguage..?
                $this->typePerItemArr[$key] = $type;

                // COUNT TYPES
                if ($value != '') {
                    if (!isset($this->itemsPerType[$type])) {
                        $this->itemsPerType[$type] = 0;
                    };
                    $this->itemsPerType[$type]++;
                };
            };
        };

    }

    public function modifyContentArrayValues($tplConfig)
    {
        global $modx;

        // MODIFY CONTENT-ARRAY / PLACEHOLDER-VALUES
        foreach ($this->typePerItemArr as $key => $itemType) {

            $value = $this->contentArr[$key];

            switch ($itemType) {
                case 'image':
                    $value = !empty($value) ? '/' . ltrim($value, '/') : '';        // REMOVE ALL BEGINNING SLASHES AND PROVIDE SINGLE SLASH AT BEGINNING
                    break;
                case 'chunk':
                    if (IN_PARSER_MODE != 'true') {    // SWITCH OUTPUT TO AVOID EXECUTION OF SNIPPETS WITHIN MANAGER
                        $value = !empty($value) ? '[ Chunk: <i>' . $value . '</i> ]' : '';
                    } else {
                        $value = !empty($value) && !is_numeric($value) ? $modx->getChunk($value) : $value;
                    }
                    break;
            };

            $this->contentArr[$key] = $value;
        };
    }

    public function renderContentArrayHtml($tplConfig)
    {
	    $langId = 'de';
	    if( class_exists( 'YAMS' )) {
		    $yams 		= YAMS::GetInstance();
		    $langId 	= $yams->GetCurrentLangId();
	    };

	    if (isset($this->langSuffixesArr[0])) {
		    $defaultLang = $this->langSuffixesArr[0];
		    $actualLang = (IN_PARSER_MODE != 'true') ? $defaultLang : $langId;	// GET YAMS-LANGCODE
	    };
	    
        foreach ($this->contentArr as $key => $value) {
	        // TRANSLATE head_1_de BACK TO head_1 = ADD head_1 TO CONTENT-ARRAY
	        if( isset( $actualLang ) && substr($key, -3) == '_'.$actualLang ) {
		        $newTemplateKey = substr($key, 0, -3);
		        $this->contentArr[ $newTemplateKey ] = $this->renderItemTpl($key, $value);
	        } else {
		        $this->contentArr[ $key ]            = $this->renderItemTpl($key, $value);
	        };
        };
    }

    public function renderItemTpl($key, $value)
    {
        $itemType = $this->typePerItemArr[$key];
            
        // DETERMINE TEMPLATE
        if (isset($this->itemTemplates[$key])) {
            $template = $this->itemTemplates[$key];
        } else if (isset($this->typeTemplates[$itemType])) {
            $template = $this->typeTemplates[$itemType];
        };

        // DETERMINE tpl / tplEmpty
        if ($value == '' && isset($template['tplEmpty'])) {
            return $template['tplEmpty'];
        } else if (isset($template['tpl'])) {
            
            $tpl = $template['tpl'];
            $tpl = str_replace('[+value+]', $value, $tpl);
            
            /*
            $this->setPlaceholder('value', $value);
            foreach ($this->templatePlaceholders[$this->layoutKey][1] as $key => $ph) {
                if(!isset($this->contentArr[$ph])) continue;
                $tpl = str_replace($this->templatePlaceholders[$this->layoutKey][0][$key], $this->contentArr[$ph], $tpl);
            };
            */
            return $tpl;
        };

        return $value;
    }

	public static function renderSettingsFieldsElements( $layoutSettings )
	{
		$layoutElements = '';
		foreach( $layoutSettings['layoutsArr'] as $value=>$itemArr ) {
			$label = self::mergeLanguagePlaceholders($itemArr['label']);
			$layoutElements .=  !empty($layoutElements) ? '||' : '';
			$layoutElements .= strtoupper($value).'&nbsp;'.$label.'=='.$value;
		};
		return $layoutElements;
	}

	// return String: layoutId===xxxyyy|||layoutKey===[+layoutKey+]|||
	public static function renderSettingsColumnsContentsRender( $layoutId, $fieldsArr )
	{
		$setting = 'layoutId==='. $layoutId .'|||';
		foreach( $fieldsArr as $key=>$fieldArr ) {
			// FORMAT:
			$setting .=  '|||'. $key .'===[+'. $key .'+]';
		};
		return $setting;
	}

	public static function renderSettingsColumnsCaptions( $settings )
	{
		foreach($settings['columns'] as $key=>$colArray) {
			$settings['columns'][$key]['caption'] = isset($colArray['caption']) ? self::mergeLanguagePlaceholders($colArray['caption']) : ''; 
		}
		return $settings;
	}

	public static function renderSettingsFieldsMultilingual( $multiLanguageTypesArr, $languageSuffixArr, $settings )
	{
		$multilingualFields = array();

		// ADD _de TO FIELDS-KEYS
		$newSettingsFields = array();
		foreach( $settings['fields'] as $key=>$fieldArr ) {
			if( self::fieldKeyInTypeArray( $key, $multiLanguageTypesArr ) ) {
				$firstLang = true;
				foreach( $languageSuffixArr as $langKey ) {
					$newFieldArr = $fieldArr;
					// ADD "SECTION" - A CUSTOM MULTITVLAYOUT-PARAM
					$section = ( $firstLang == true && isset( $newFieldArr['section'] )) ? '<hr class="mtvl-section" /><div class="mtvl-sectionheader">'. $newFieldArr['section'] .'</div>' : '';
					$newFieldArr['caption'] = self::mergeLanguagePlaceholders( $section . $newFieldArr['caption'] ) . ' ['. $langKey .']';
					if(isset($newFieldArr['elements'])) self::mergeLanguagePlaceholders( $newFieldArr['elements'] );
					$newSettingsFields[$key.'_'.$langKey] = $newFieldArr;
					$firstLang = false;
				};
				$multilingualFields[ $key ] = true;
			} else {
				$newFieldArr = $fieldArr;
				// ADD "SECTION" - A CUSTOM MULTITVLAYOUT-PARAM
				$section = isset( $newFieldArr['section'] ) ? '<hr class="mtvl-section" /><div class="mtvl-sectionheader">'. $newFieldArr['section'] .'</div>' : '';
				$newFieldArr['caption'] = self::mergeLanguagePlaceholders( $section . $newFieldArr['caption'] );
				if(isset($newFieldArr['elements'])) {
					$newFieldArr['elements'] = self::mergeLanguagePlaceholders( $newFieldArr['elements'] );
				}
				$newSettingsFields[ $key ] = $newFieldArr;
			};
		};
		$settings['fields'] = $newSettingsFields;

		// ADD _de TO FORM-KEYS
		foreach( $settings['form'] as $key=>$fieldsArr ) {
			$newContentArr = array();
			foreach( $fieldsArr['content'] as $formKey=>$empty ) {
				if (isset($multilingualFields[$formKey])) {
					foreach( $languageSuffixArr as $langKey ) {
						$newContentArr[ $formKey.'_'.$langKey ] = array();
					};
				} else {
					$newContentArr[ $formKey ] = array();
				};
			};
			$settings['form'][ $key ]['content'] = $newContentArr;
			$settings['form'][ $key ]['caption'] = self::mergeLanguagePlaceholders($settings['form'][ $key ]['caption']);
		};

		return $settings;
	}

	public static function fieldKeyInTypeArray( $key, $multiLanguageTypesArr )
	{
		foreach( $multiLanguageTypesArr as $type ) {
			if( strpos( $key, $type ) === 0 ) { return true; };
		};

		return false;
	}

    public function setPlaceholder($ph, $val)
    {
        if(!in_array($ph, $this->templatePlaceholders[$this->layoutKey][1])) {
            $this->templatePlaceholders[$this->layoutKey][0][] = '[+' . $ph . '+]';
            $this->templatePlaceholders[$this->layoutKey][1][] = $ph;
        };
        $this->contentArr[$ph] = $val;
    }

    public function setPreservePhs($state=true) {
        $this->preservePhs = $state;
    }

    // Helper to avoid Placeholder-/Snippet-Execution for Frontend-Editors
    public function protectModxPlaceholders($output)
    {
        return str_replace(
            array('[*', '*]', '[(', ')]', '{{', '}}', '[[', ']]', '[!', '!]', '[+', '+]', '[~', '~]'),
            array('&#91;*', '*&#93;', '&#91;(', ')&#93;', '&#123;&#123;', '&#125;&#125;', '&#91;&#91;', '&#93;&#93;', '&#91;!', '!&#93;', '&#91;+', '+&#93;', '&#91;~', '~&#93;'),
            $output
        );
    }
    public function unprotectModxPlaceholders($output)
    {
        return str_replace(
            array('&#91;*', '*&#93;', '&#91;(', ')&#93;', '&#123;&#123;', '&#125;&#125;', '&#91;&#91;', '&#93;&#93;', '&#91;!', '!&#93;', '&#91;+', '+&#93;', '&#91;~', '~&#93;'),
            array('[*', '*]', '[(', ')]', '{{', '}}', '[[', ']]', '[!', '!]', '[+', '+]', '[~', '~]'),
            $output
        );
    }
	public function setLanguageSuffixesArr( $langSuffixesArr )
	{
	  $this->langSuffixesArr = $langSuffixesArr;
	}
	
	static public function mergeLanguagePlaceholders($input)
	{
		global $modx;
		
		if(is_null(self::$language)) self::initLanguage();
		
		$placeholders = $modx->getTagsFromContent($input, '[%', '%]');
		if(isset($placeholders[0])) {
			foreach ($placeholders[0] as $i => $ph) {
				$value = isset(self::$language[$placeholders[1][$i]]) ? self::$language[$placeholders[1][$i]] : '%'.$placeholders[1][$i].'%';
				$input = str_replace($placeholders[0][$i], $value, $input);
			};
		};
		
		return $input;
	}
	static public function initLanguage()
	{
		global $modx;

		$code = isset($modx->config['manager_language']) ? $modx->config['manager_language'] : 'english';
		$language = array();
		include_once(MTV_BASE_PATH.'languages/multiTvLayout/english.language.inc.php');
		if(file_exists(MTV_BASE_PATH.'languages/multiTvLayout/custom/english.language.inc.php'))
			include_once(MTV_BASE_PATH.'languages/multiTvLayout/custom/english.language.inc.php');
		
		if($code != 'english') {
			include_once(MTV_BASE_PATH.'languages/multiTvLayout/'.$code.'.language.inc.php');
			if(file_exists(MTV_BASE_PATH.'languages/multiTvLayout/custom/'.$code.'.language.inc.php'))
				include_once(MTV_BASE_PATH.'languages/multiTvLayout/custom/'.$code.'.language.inc.php');
		}
		
		self::$language = $language;
	}
}