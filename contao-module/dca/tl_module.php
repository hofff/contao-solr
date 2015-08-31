<?php

$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'hofff_solr_live';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'hofff_solr_copy';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'hofff_solr_template';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'hofff_solr_showOnEmpty';

$GLOBALS['TL_DCA']['tl_module']['palettes']['hofff_solr_search']
	= '{title_legend},name,headline,type'
	. ';{hofff_solr_search_legend},hofff_solr_rememberQuery,hofff_solr_autocomplete,hofff_solr_filter'
	. ';{redirect_legend},hofff_solr_target,jumpTo,hofff_solr_live'
	. ';{hofff_solr_template_legend},hofff_solr_template'
	. ';{protected_legend:hide},protected'
	. ';{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['palettes']['hofff_solr_result']
	= '{title_legend},name,headline,type,hofff_solr_copy'
	. ';{hofff_solr_template_legend},hofff_solr_template,hofff_solr_documentTemplates'
	. ';{protected_legend:hide},protected'
	. ';{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['palettes']['hofff_solr_resulthofff_solr_nocopy']
	= '{title_legend},name,headline,type,hofff_solr_copy'
	. ';{hofff_solr_source_legend},hofff_solr_handler,hofff_solr_sources'
	. ';{hofff_solr_search_legend},hofff_solr_regex,hofff_solr_prep,hofff_solr_doctypes'
	. ';{hofff_solr_template_legend},hofff_solr_perPage,hofff_solr_maxPages,hofff_solr_template,hofff_solr_documentTemplates,hofff_solr_showOnEmpty'
	. ';{protected_legend:hide},protected'
	. ';{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['subpalettes']['hofff_solr_live']
	= 'hofff_solr_liveTarget';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['hofff_solr_template_mod_hofff_solr_result_grouped']
	= 'hofff_solr_grouping';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['hofff_solr_showOnEmpty']
	= 'bbit_mod_art_container,bbit_mod_art_id';


/*** COMMON FIELDS ***/

$GLOBALS['TL_DCA']['tl_module']['fields']['hofff_solr_template'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_template'],
	'exclude'		=> true,
	'inputType'		=> 'select',
	'options_callback'=> array('Hofff\\Contao\\Solr\\DCA\\ModuleDCA', 'optionsTemplates'),
	'eval'			=> array(
		'includeBlankOption'=> true,
		'chosen'		=> true,
		'submitOnChange'=> true,
	),
	'sql'			=> "varchar(255) NOT NULL default ''",
);


/*** SEARCH MODULE FIELDS ***/

$GLOBALS['TL_DCA']['tl_module']['fields']['hofff_solr_rememberQuery'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_rememberQuery'],
	'exclude'		=> true,
	'inputType'		=> 'checkbox',
	'default'		=> 1,
	'eval'			=> array(
		'tl_class'		=> 'clr w50 cbx',
	),
	'sql'			=> "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['hofff_solr_autocomplete'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_autocomplete'],
	'exclude'		=> true,
	'inputType'		=> 'checkbox',
	'default'		=> 1,
	'eval'			=> array(
		'tl_class'		=> 'w50 cbx',
	),
	'sql'			=> "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['hofff_solr_filter'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_filter'],
	'inputType'		=> 'multiColumnWizard',
	'eval'			=> array(
		'columnFields' => array(
			'label' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_filter_label'],
				'inputType'	=> 'text',
				'eval'		=> array(
					'readonly'	=> true,
					'style'		=> 'width: 100px;'
				)
			),
			'docType' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_filter_doctype'],
				'inputType'	=> 'text',
				'eval'		=> array(
					'readonly'	=> true,
					'style'		=> 'width: 200px;'
				)
			),
			'group' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_filter_group'],
				'inputType'	=> 'text',
				'eval'		=> array(
					'style'		=> 'width: 200px;'
				)
			),
			'available' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_filter_available'],
				'inputType'	=> 'checkbox',
				'eval'		=> array(
					'style'		=> 'width: 100px;'
				)
			),
		),
		'buttons'	=> array('delete' => false, 'copy' => false),
		'tl_class'	=> 'clr',
	),
	'sql'			=> "blob NULL",
	'load_callback' => array(
		array('Hofff\\Contao\\Solr\\DCA\\ModuleDCA', 'loadGroups'),
	),
	'save_callback' => array(
		array('Hofff\\Contao\\Solr\\DCA\\ModuleDCA', 'saveGroups'),
	),

);

$GLOBALS['TL_DCA']['tl_module']['fields']['hofff_solr_target'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_target'],
	'exclude'		=> true,
	'inputType'		=> 'select',
	'options_callback' => array('Hofff\\Contao\\Solr\\DCA\\ModuleDCA', 'optionsResultModules'),
	'eval'			=> array(
		'includeBlankOption'=> true,
		'chosen'		=> true,
	),
	'sql'			=> "int(10) unsigned NOT NULL default '0'",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['hofff_solr_live'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_live'],
	'exclude'		=> true,
	'inputType'		=> 'checkbox',
	'eval'			=> array(
		'submitOnChange'=> true,
		'tl_class'		=> 'clr w50 cbx m12',
	),
	'sql'			=> "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['hofff_solr_liveTarget'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_liveTarget'],
	'exclude'		=> true,
	'inputType'		=> 'select',
	'options_callback' => array('Hofff\\Contao\\Solr\\DCA\\ModuleDCA', 'optionsResultModules'),
	'eval'			=> array(
		'mandatory'		=> true,
		'chosen'		=> true,
		'tl_class'		=> 'w50',
	),
	'sql'			=> "int(10) unsigned NOT NULL default '0'",
);


/*** RESULT MODULE FIELDS ***/

$GLOBALS['TL_DCA']['tl_module']['fields']['hofff_solr_copy'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_copy'],
	'exclude'		=> true,
	'default'		=> 'hofff_solr_nocopy',
	'inputType'		=> 'select',
	'options_callback' => array('Hofff\\Contao\\Solr\\DCA\\ModuleDCA', 'optionsResultModules'),
	'hofff_solr_nocopyOption' => true,
	'eval'			=> array(
		'chosen'		=> true,
		'tl_class'		=> 'w50',
	),
	'sql'			=> "varchar(255) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['hofff_solr_handler'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_handler'],
	'exclude'		=> true,
	'inputType'		=> 'select',
	'options_callback' => array('Hofff\\Contao\\Solr\\DCA\\ModuleDCA', 'optionsHandlers'),
	'eval'			=> array(
		'mandatory'		=> true,
		'includeBlankOption'=> true,
// 		'submitOnChange'=> true,
		'chosen'		=> true,
		'tl_class'		=> 'w50',
	),
	'sql'			=> "int(10) unsigned NOT NULL default '0'",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['hofff_solr_sources'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_sources'],
	'exclude'		=> true,
	'inputType'		=> 'select',
	'options_callback' => array('Hofff\\Contao\\Solr\\DCA\\ModuleDCA', 'optionsSources'),
	'eval'			=> array(
		'mandatory'		=> true,
		'multiple'		=> true,
		'chosen'		=> true,
		'size'			=> 5,
// 		'tl_class'		=> 'clr',
		'style'			=> 'width: 100%',
	),
	'sql'			=> "blob NULL",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['hofff_solr_regex'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_regex'],
	'exclude'		=> true,
	'inputType'		=> 'text',
	'default'		=> '/\\b(?:[\\PZ]{3,}|[\\pN\\pS]+)\\b/i',
	'eval'			=> array(
		'decodeEntities'=> true,
		'tl_class'		=> 'clr long',
	),
	'sql'			=> "varchar(255) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['hofff_solr_prep'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_prep'],
	'exclude'		=> true,
	'inputType'		=> 'select',
	'options'		=> array('fuzzy', 'wildcard_all', 'wildcard_last', 'fuzzy_wildcard_last'),
	'reference'		=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_prepOptions'],
	'eval'			=> array(
		'includeBlankOption'=> true,
		'chosen'		=> true,
		'tl_class'		=> 'w50',
	),
	'sql'			=> "varchar(255) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['hofff_solr_doctypes'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_doctypes'],
	'exclude'		=> true,
	'inputType'		=> 'select',
	'options_callback' => array('Hofff\\Contao\\Solr\\DCA\\ModuleDCA', 'optionsDocumentTypes'),
	'eval'			=> array(
		'mandatory'		=> true,
		'multiple'		=> true,
		'chosen'		=> true,
		'size'			=> 5,
// 		'tl_class'		=> 'clr',
		'style'			=> 'width: 100%',
	),
	'sql'			=> "blob NULL",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['hofff_solr_perPage'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_perPage'],
	'exclude'		=> true,
	'inputType'		=> 'text',
	'default'		=> 10,
	'eval'			=> array(
		'mandatory'		=> true,
		'rgxp'			=> 'digit',
		'nospace'		=> true,
		'tl_class'		=> 'clr w50',
	),
	'sql'			=> "int(10) unsigned NOT NULL default '0'",
	'save_callback' => array(
		array('Hofff\\Contao\\Solr\\DCA\\ModuleDCA', 'savePositiveInteger'),
	),
);

$GLOBALS['TL_DCA']['tl_module']['fields']['hofff_solr_maxPages'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_maxPages'],
	'exclude'		=> true,
	'inputType'		=> 'text',
	'default'		=> 0,
	'eval'			=> array(
		'mandatory'		=> true,
		'rgxp'			=> 'digit',
		'nospace'		=> true,
		'tl_class'		=> 'w50',
	),
	'sql'			=> "int(10) unsigned NOT NULL default '0'",
	'save_callback' => array(
		array('Hofff\\Contao\\Solr\\DCA\\ModuleDCA', 'saveNonNegativeInteger'),
	),
);

$GLOBALS['TL_DCA']['tl_module']['fields']['hofff_solr_grouping'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_grouping'],
	'inputType'		=> 'multiColumnWizard',
	'eval'			=> array(
		'columnFields' => array(
			'label' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_grouping_label'],
				'inputType'	=> 'text',
				'eval'		=> array(
					'readonly'	=> true,
					'style'		=> 'width: 100px;'
				)
			),
			'docType' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_grouping_type'],
				'inputType'	=> 'text',
				'eval'		=> array(
					'readonly'	=> true,
					'style'		=> 'width: 200px;'
				)
			),
			'group' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_grouping_group'],
				'inputType'	=> 'text',
				'eval'		=> array(
					'style'		=> 'width: 200px;'
				)
			),
		),
		'buttons'	=> array('delete' => false, 'copy' => false),
		'tl_class'	=> 'clr',
	),
	'sql'			=> "blob NULL",
	'load_callback' => array(
		array('Hofff\\Contao\\Solr\\DCA\\ModuleDCA', 'loadGroups'),
	),
	'save_callback' => array(
		array('Hofff\\Contao\\Solr\\DCA\\ModuleDCA', 'saveGroups'),
	),
);

$GLOBALS['TL_DCA']['tl_module']['fields']['hofff_solr_documentTemplates'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_documentTemplates'],
	'inputType'		=> 'multiColumnWizard',
	'eval'			=> array(
		'columnFields' => array(
			'label' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_documentTemplates_label'],
				'inputType'	=> 'text',
				'eval'		=> array(
					'readonly'	=> true,
					'style'		=> 'width: 100px;'
				)
			),
			'doctype' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_documentTemplates_doctype'],
				'inputType'	=> 'text',
				'eval'		=> array(
					'readonly'	=> true,
					'style'		=> 'width: 200px;'
				)
			),
			'template' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_documentTemplates_template'],
				'inputType'	=> 'select',
				'options_callback' => array('Hofff\\Contao\\Solr\\DCA\\ModuleDCA', 'optionsDocumentTemplates'),
				'eval'		=> array(
					'includeBlankOption'=> true,
					'blankOptionLabel'=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_tpl_blank'],
					'chosen'	=> true,
					'style'		=> 'width: 200px;'
				)
			),
		),
		'buttons'	=> array('up' => false, 'down' => false, 'delete' => false, 'copy' => false),
	),
	'sql'			=> "blob NULL",
	'load_callback' => array(
		array('Hofff\\Contao\\Solr\\DCA\\ModuleDCA', 'loadDocumentTemplates'),
	),
	'save_callback' => array(
		array('Hofff\\Contao\\Solr\\DCA\\ModuleDCA', 'saveDocumentTemplates'),
	),
);

$GLOBALS['TL_DCA']['tl_module']['fields']['hofff_solr_showOnEmpty'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_showOnEmpty'],
	'exclude'		=> true,
	'inputType'		=> 'checkbox',
	'eval'			=> array(
		'submitOnChange'=> true,
		'tl_class'		=> 'clr w50',
	),
	'sql'			=> "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['hofff_solr_params'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_params'],
	'exclude'		=> true,
	'inputType'		=> 'multiColumnWizard',
	'eval'			=> array(
		'columnFields' => array(
			'name' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_params_name'],
				'inputType'	=> 'text',
				'eval'		=> array(
					'nospace'		=> true,
					'decodeEntities'=> true,
					'preserveTags'	=> true,
					'style'			=> 'width: 200px;'
				),
			),
			'value' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_params_value'],
				'inputType'	=> 'text',
				'eval'		=> array(
					'decodeEntities'=> true,
					'preserveTags'	=> true,
					'style'			=> 'width: 300px;',
				),
			),
			'add' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_params_add'],
				'inputType'	=> 'checkbox',
				'eval'		=> array(
				),
			),
		),
		// 		'tl_class'			=> 'clr'
	),
	'sql'			=> "blob NULL",
);
