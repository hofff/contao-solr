<?php

$GLOBALS['TL_DCA']['tl_hofff_solr_source'] = array(

	'config' => array(
		'dataContainer'		=> 'Table',
// 		'ctable'			=> array(),
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
			'fields'		=> array('title'),
			'flag'			=> 1,
			'panelLayout'	=> 'filter;search,limit',
		),
		'label' => array(
			'fields'		=> array('title'),
			'format'		=> '%s',
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
				'label'				=> &$GLOBALS['TL_LANG']['tl_hofff_solr_source']['edit'],
				'href'				=> 'table=tl_vmi_newsletter',
				'icon'				=> 'edit.gif',
			),
// 			'copy' => array(
// 				'label'				=> &$GLOBALS['TL_LANG']['tl_hofff_solr_source']['copy'],
// 				'href'				=> 'act=copy',
// 				'icon'				=> 'copy.gif',
// 			),
			'delete' => array(
				'label'				=> &$GLOBALS['TL_LANG']['tl_hofff_solr_source']['delete'],
				'href'				=> 'act=delete',
				'icon'				=> 'delete.gif',
				'attributes'		=> 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
			),
			'show' => array(
				'label'				=> &$GLOBALS['TL_LANG']['tl_hofff_solr_source']['show'],
				'href'				=> 'act=show',
				'icon'				=> 'show.gif',
			),
		),
	),

	'palettes' => array(
		'__selector__'	=> array('type'),
		'default'		=> '{general_legend},label,name,type',
		'contao_page'	=> '{general_legend},label,name,type,{contao_page_legend},page_roots,index_images',
		'file'			=> '{general_legend},label,name,type,{file_legend},base,file_roots,extensions',
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
			'label'		=> &$GLOBALS['TL_LANG']['tl_hofff_solr_source']['label'],
			'exclude'	=> true,
			'search'	=> true,
			'inputType'	=> 'text',
			'eval'		=> array(
				'mandatory'		=> true,
				'maxlength'		=> 255,
				'tl_class'		=> 'clr w50',
			),
			'sql'		=> "varchar(255) NOT NULL default ''",
		),
		'name' => array(
			'label'		=> &$GLOBALS['TL_LANG']['tl_hofff_solr_source']['name'],
			'exclude'	=> true,
			'search'	=> true,
			'inputType'	=> 'text',
			'eval'		=> array(
				'unique'		=> true,
				'mandatory'		=> true,
				'maxlength'		=> 255,
				'decodeEntities'=> true,
				'tl_class'		=> 'w50',
			),
			'sql'		=> "varchar(255) NOT NULL default ''",
		),
		'type' => array(
			'label'		=> &$GLOBALS['TL_LANG']['tl_hofff_solr_source']['type'],
			'default'	=> 'contao_page',
			'exclude'	=> true,
			'search'	=> true,
			'inputType'	=> 'select',
			'options'	=> array_keys($GLOBALS['SOLR_SOURCE_TYPES']),
			'reference'	=> &$GLOBALS['TL_LANG']['tl_hofff_solr_source']['typeOptions'],
			'eval'		=> array(
				'mandatory'		=> true,
				'tl_class'		=> 'clr w50',
			),
			'sql'		=> "varchar(255) NOT NULL default ''",
		),
		'page_roots' => array(
			'label'		=> &$GLOBALS['TL_LANG']['tl_hofff_solr_source']['page_roots'],
			'exclude'	=> true,
			'inputType'	=> 'pageTree',
			'foreignKey'=> 'tl_page.title',
			'eval'		=> array(
				'multiple'		=> true,
				'fieldType'		=> 'checkbox',
// 				'orderField'	=> 'orderPages',
				'tl_class'		=> 'clr',
			),
			'sql'		=> "blob NULL",
			'relation'	=> array('type' => 'hasMany', 'load' => 'lazy'),
		),
		'index_images' => array(
			'label'		=> &$GLOBALS['TL_LANG']['tl_hofff_solr_source']['index_images'],
			'exclude'	=> true,
			'inputType'	=> 'checkbox',
			'eval'		=> array(
				'tl_class'		=> 'clr',
			),
			'sql'		=> "char(1) NOT NULL default ''",
		),
		'base' => array(
			'label'		=> &$GLOBALS['TL_LANG']['tl_hofff_solr_source']['base'],
			'exclude'	=> true,
			'search'	=> true,
			'inputType'	=> 'text',
			'eval'		=> array(
				'maxlength'		=> 255,
				'rgxp'			=> 'url',
				'decodeEntities'=> true,
				'tl_class'		=> 'clr long',
			),
			'sql'		=> "varchar(255) NOT NULL default ''",
		),
		'file_roots' => array(
			'label'		=> &$GLOBALS['TL_LANG']['tl_hofff_solr_source']['file_roots'],
			'exclude'	=> true,
			'inputType'	=> 'text',
			'eval'		=> array(
				'multiple'		=> true,
				'fieldType'		=> 'checkbox',
// 				'orderField'	=> 'orderSRC',
				'files'			=> true,
				'tl_class'		=> 'clr',
			),
			'sql'		=> "blob NULL",
		),
		'extensions' => array(
			'label'		=> &$GLOBALS['TL_LANG']['tl_hofff_solr_source']['extensions'],
			'exclude'	=> true,
			'search'	=> true,
			'inputType'	=> 'text',
			'eval'		=> array(
				'maxlength'		=> 255,
				'decodeEntities'=> true,
				'tl_class'		=> 'clr w50',
			),
			'sql'		=> "varchar(255) NOT NULL default ''",
		),
	),
);
