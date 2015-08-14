<?php

$GLOBALS['TL_CONFIG']['hofff_solr_page_outdate'] = 60 * 60 * 24 * 30;

$GLOBALS['FE_MOD']['application']['hofff_solr_search']
	= 'Hofff\\Contao\\Solr\\Module\\SearchModule';
$GLOBALS['FE_MOD']['application']['hofff_solr_result']
	= 'Hofff\\Contao\\Solr\\Module\\ResultModule';

$GLOBALS['BE_MOD']['hofff_solr']['hofff_solr_source'] = array(
	'tables'	=> array('tl_hofff_solr_source'),
// 	'icon'		=> '',
);
$GLOBALS['BE_MOD']['hofff_solr']['hofff_solr_index'] = array(
	'tables'	=> array('tl_hofff_solr_index', 'tl_hofff_solr_index_handler'),
// 	'icon'		=> '',
);

$GLOBALS['TL_HOOKS']['outputFrontendTemplate'][]
	= array('Hofff\\Contao\\Solr\\Source\\ContaoPageSourceManager', 'hookOutputFrontendTemplate');

$GLOBALS['TL_CACHE']['hofff_solr_page'] = 'tl_hofff_solr_page';

// $GLOBALS['TL_CRON']['daily'][] = array('SolrContaoPageSourceManager', 'cleanURLIndex');
// $GLOBALS['TL_CRON']['daily'][] = array('SolrIndexManager', 'runUpdates');

// $GLOBALS['HOFFF_SOLR_HOOKS']['beforeRunUpdates'] = array('', '');
// $GLOBALS['HOFFF_SOLR_HOOKS']['afterRunUpdates'] = array('', '');
// $GLOBALS['HOFFF_SOLR_HOOKS']['beforeUpdate'] = array('', '');
// $GLOBALS['HOFFF_SOLR_HOOKS']['afterUpdate'] = array('', '');
// $GLOBALS['HOFFF_SOLR_HOOKS']['beforeRunUpdates'] = array('SolrContaoPageSourceManager', 'cleanURLIndex');

$GLOBALS['SOLR_SOURCE_TYPES']['contao_page'] = array(
	'class'	=> 'Hofff\\Contao\\Solr\\Source\\ContaoPageSource',
);
$GLOBALS['SOLR_SOURCE_TYPES']['file'] = array(
	'class'	=> 'Hofff\\Contao\\Solr\\Source\\FileSource',
);

$GLOBALS['SOLR_DOCTYPES']['contao_page'] = array(
	'resultDocumentClass' => 'Hofff\\Contao\\Solr\\Result\\Document\\ContaoPageDocument',
);
$GLOBALS['SOLR_DOCTYPES']['file'] = array(
	'resultDocumentClass' => 'Hofff\\Contao\\Solr\\Result\\Document\\FileDocument',
);
$GLOBALS['SOLR_DOCTYPES']['image'] = array(
	'resultDocumentClass' => 'Hofff\\Contao\\Solr\\Result\\Document\\ImageDocument',
);
