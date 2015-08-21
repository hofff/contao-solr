<?php

$GLOBALS['TL_DCA']['tl_hofff_solr_index'] = array(

	'config' => array(
		'dataContainer'		=> 'Table',
		'ctable'			=> array('tl_hofff_solr_index_handler'),
		'switchToEdit'		=> true,
		'enableVersioning'	=> true,
// 		'onload_callback'	=> array(
// 			array('', ''),
// 		),
// 		'onsubmit_callback'	=> array(
// 			array('', ''),
// 		),
		'sql' => array(
			'keys' => array(
				'id' => 'primary',
			),
		),
	),

	'list' => array(
		'sorting' => array(
			'mode'			=> 1,
			'fields'		=> array('label'),
			'flag'			=> 1,
			'panelLayout'	=> 'filter;search,limit',
		),
		'label' => array(
			'fields'		=> array('label', 'endpoint', 'core'),
			'format'		=> '%s - %s/%s',
		),
		'global_operations' => array(
// 			'all' => array(
// 				'label'			=> &$GLOBALS['TL_LANG']['MSC']['all'],
// 				'href'			=> 'act=select',
// 				'class'			=> 'header_edit_all',
// 				'attributes'	=> 'onclick="Backend.getScrollOffset()" accesskey="e"',
// 			),
		),
		'operations' => array(
			'index' => array(
				'label'				=> &$GLOBALS['TL_LANG']['tl_hofff_solr_index']['index'],
				'href'				=> 'key=index',
				'icon'				=> 'edit.gif',
			),
			'unindex' => array(
				'label'				=> &$GLOBALS['TL_LANG']['tl_hofff_solr_index']['unindex'],
				'href'				=> 'key=unindex',
				'icon'				=> 'edit.gif',
			),
			'status' => array(
				'label'				=> &$GLOBALS['TL_LANG']['tl_hofff_solr_index']['status'],
				'href'				=> 'key=status',
				'icon'				=> 'edit.gif',
			),
			'edit' => array(
				'label'				=> &$GLOBALS['TL_LANG']['tl_hofff_solr_index']['edit'],
				'href'				=> 'table=tl_hofff_solr_index_handler',
				'icon'				=> 'edit.gif',
			),
			'editheader' => array(
				'label'				=> &$GLOBALS['TL_LANG']['tl_hofff_solr_index']['editheader'],
				'href'				=> 'act=edit',
				'icon'				=> 'header.gif',
			),
// 			'copy' => array(
// 				'label'				=> &$GLOBALS['TL_LANG']['tl_hofff_solr_index']['copy'],
// 				'href'				=> 'act=copy',
// 				'icon'				=> 'copy.gif',
// 			),
			'delete' => array(
				'label'				=> &$GLOBALS['TL_LANG']['tl_hofff_solr_index']['delete'],
				'href'				=> 'act=delete',
				'icon'				=> 'delete.gif',
				'attributes'		=> 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
			),
			'show' => array(
				'label'				=> &$GLOBALS['TL_LANG']['tl_hofff_solr_index']['show'],
				'href'				=> 'act=show',
				'icon'				=> 'show.gif',
			),
		),
	),

	'palettes' => array(
		'__selector__'	=> array(),
		'default'		=> '{general_legend},label,endpoint,core;{source_legend},sources',
	),

	'subpalettes' => array(
	),

	'fields' => array(
		'id' => array(
			'sql'		=> "int(10) unsigned NOT NULL auto_increment",
		),
		'tstamp' => array(
			'label'		=> &$GLOBALS['TL_LANG']['MSC']['tstamp'],
			'sql'		=> "int(10) unsigned NOT NULL default '0'",
		),
		'label' => array(
			'label'		=> &$GLOBALS['TL_LANG']['tl_hofff_solr_index']['label'],
			'exclude'	=> true,
			'search'	=> true,
			'inputType'	=> 'text',
			'eval'		=> array(
				'mandatory'		=> true,
				'maxlength'		=> 255,
				'decodeEntities'=> true,
				'tl_class'		=> 'clr long',
			),
			'sql'		=> "varchar(255) NOT NULL default ''",
		),
		'endpoint' => array(
			'label'		=> &$GLOBALS['TL_LANG']['tl_hofff_solr_index']['endpoint'],
			'exclude'	=> true,
			'search'	=> true,
			'inputType'	=> 'text',
			'eval'		=> array(
				'mandatory'		=> true,
				'maxlength'		=> 255,
				'rgxp'			=> 'url',
				'nospace'		=> true,
				'decodeEntities'=> true,
				'tl_class'		=> 'clr long',
			),
			'sql'		=> "varchar(255) NOT NULL default ''",
		),
		'core' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_hofff_solr_index']['core'],
			'exclude'		=> true,
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array(
				'nospace'		=> true,
				'maxlength'		=> 255,
				'decodeEntities'=> true,
				'tl_class'		=> 'clr w50',
			),
			'sql'			=> "varchar(255) NOT NULL default ''",
		),
		'sources' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_hofff_solr_index']['sources'],
			'exclude'		=> true,
			'inputType'		=> 'multiColumnWizard',
			'eval'			=> array(
				'doNotSaveEmpty'=> true,
				'hideButtons'	=> true,
				'tl_class'		=> 'clr',
				'columnFields'	=> array(
					'source'		=> array(
						'label'				=> array(''),
						'exclude'			=> true,
						'inputType'			=> 'justtextoption',
						'options_callback'	=> array('Hofff\\Contao\\Solr\\DCA\\IndexDCA', 'optionsSources'),
						'eval'				=> array(
							'valign'			=> 'center',
							'style'				=> 'width:300px;',
						),
					),
					'handler' => array(
						'label'				=> array(''),
						'exclude'			=> true,
						'inputType'			=> 'select',
						'options_callback'	=> array('Hofff\\Contao\\Solr\\DCA\\IndexDCA', 'optionsHandler'),
						'eval'				=> array(
							'includeBlankOption'=> true,
							'blankOptionLabel'	=> &$GLOBALS['TL_LANG']['tl_hofff_solr_index']['dont_index'],
							'style'				=> 'width:300px;',
						),
					),
				),
			),
			'load_callback'	=> array(
				array('Hofff\\Contao\\Solr\\DCA\\IndexDCA', 'loadSources'),
			),
			'save_callback'	=> array(
				array('Hofff\\Contao\\Solr\\DCA\\IndexDCA', 'saveSources'),
			),
		),
	),

);
