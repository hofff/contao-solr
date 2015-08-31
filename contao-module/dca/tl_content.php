<?php

$GLOBALS['TL_DCA']['tl_content']['fields']['hofff_solr_params'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_content']['hofff_solr_params'],
	'exclude'		=> true,
	'inputType'		=> 'multiColumnWizard',
	'eval'			=> array(
		'columnFields' => array(
			'name' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_content']['hofff_solr_params_name'],
				'inputType'	=> 'text',
				'eval'		=> array(
					'nospace'		=> true,
					'decodeEntities'=> true,
					'preserveTags'	=> true,
					'style'			=> 'width: 200px;'
				),
			),
			'value' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_content']['hofff_solr_params_value'],
				'inputType'	=> 'text',
				'eval'		=> array(
					'decodeEntities'=> true,
					'preserveTags'	=> true,
					'style'			=> 'width: 300px;',
				),
			),
			'add' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_content']['hofff_solr_params_add'],
				'inputType'	=> 'checkbox',
				'eval'		=> array(
				),
			),
		),
		// 		'tl_class'			=> 'clr'
	),
	'sql'			=> "blob NULL",
);
