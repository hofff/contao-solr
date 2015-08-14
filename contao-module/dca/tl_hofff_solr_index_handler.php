<?php

$GLOBALS['TL_DCA']['tl_hofff_solr_index_handler'] = array(

	'config' => array(
		'dataContainer'		=> 'Table',
		'ptable'			=> 'tl_hofff_solr_index',
// 		'ctable'			=> array(),
		'switchToEdit'		=> true,
		'enableVersioning'	=> true,
// 		'onload_callback'	=> array(
// 			array('', ''),
// 		),
// 		'oncut_callback'	=> array(
// 			array('', ''),
// 		),
// 		'ondelete_callback'	=> array(
// 			array('', ''),
// 		),
// 		'onsubmit_callback'	=> array(
// 			array('', ''),
// 		),
		'sql' => array(
			'keys' => array(
				'id' => 'primary',
				'pid' => 'index',
// 				'alias' => 'index',
			),
		),
	),

	'list' => array(
		'sorting' => array(
			'mode'					=> 4,
			'fields'				=> array('name'),
			'headerFields'			=> array('name', 'endpoint', 'core'),
			'panelLayout'			=> 'filter;sort,search,limit',
			'disableGrouping'		=> true,
			'child_record_callback'	=> array('Hofff\\Contao\\Solr\\DCA\\IndexHandlerDCA', 'childRecord'),
// 			'child_record_class'	=> 'no_padding',
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
			'edit' => array(
				'label'				=> &$GLOBALS['TL_LANG']['tl_hofff_solr_index_handler']['edit'],
				'href'				=> 'act=edit',
				'icon'				=> 'header.gif',
			),
// 			'copy' => array(
// 				'label'				=> &$GLOBALS['TL_LANG']['tl_hofff_solr_index_handler']['copy'],
// 				'href'				=> 'act=paste&amp;mode=copy',
// 				'icon'				=> 'copy.gif',
// 			),
// 			'cut' => array(
// 				'label'				=> &$GLOBALS['TL_LANG']['tl_hofff_solr_index_handler']['cut'],
// 				'href'				=> 'act=paste&amp;mode=cut',
// 				'icon'				=> 'cut.gif',
// 			),
			'delete' => array(
				'label'				=> &$GLOBALS['TL_LANG']['tl_hofff_solr_index_handler']['delete'],
				'href'				=> 'act=delete',
				'icon'				=> 'delete.gif',
				'attributes'		=> 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
			),
// 			'show' => array(
// 				'label'				=> &$GLOBALS['TL_LANG']['tl_hofff_solr_index_handler']['show'],
// 				'href'				=> 'act=show',
// 				'icon'				=> 'show.gif',
// 			),
		),
	),

	'palettes' => array(
		'__selector__'	=> array(),
		'default'		=> '{general_legend},name,type'
	),

	'subpalettes' => array(
	),

	'fields' => array(
		'id' => array(
			'sql'			=> "int(10) unsigned NOT NULL auto_increment",
		),
		'pid' => array(
			'foreignKey'	=> 'tl_hofff_solr_index.name',
			'sql'			=> "int(10) unsigned NOT NULL default '0'",
			'relation'		=> array('type' => 'belongsTo', 'load' => 'eager'),
		),
		'tstamp' => array(
			'label'			=> &$GLOBALS['TL_LANG']['MSC']['tstamp'],
			'sql'			=> "int(10) unsigned NOT NULL default '0'",
		),
		'name' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_hofff_solr_index_handler']['name'],
			'exclude'		=> true,
			'search'		=> true,
			'sorting'		=> true,
			'flag'			=> 1,
			'inputType'		=> 'text',
			'eval'			=> array(
				'mandatory'		=> true,
				'maxlength'		=> 255,
				'decodeEntities'=> true,
				'nospace'		=> true,
				'tl_class'		=> 'clr w50',
			),
			'sql'			=> "varchar(255) NOT NULL default ''",
		),
		'type' => array(
			'label'			=> &$GLOBALS['TL_LANG']['tl_hofff_solr_index_handler']['type'],
			'exclude'		=> true,
			'search'		=> true,
			'inputType'		=> 'text',
			'eval'			=> array(
				'maxlength'		=> 255,
				'decodeEntities'=> true,
				'nospace'		=> true,
				'tl_class'		=> 'w50',
			),
			'sql'			=> "varchar(255) NOT NULL default ''",
		),
	),
);
