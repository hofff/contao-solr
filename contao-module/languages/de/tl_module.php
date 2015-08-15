<?php

$GLOBALS['TL_LANG']['tl_module']['hofff_solr_search_legend']
	= 'Einstellungen der Suchanfrage';
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_source_legend']
	= 'Quellen-Einstellungen';
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_search_legend']
	= 'Such-Einstellungen';
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_template_legend']
	= 'Template-Einstellungen';


$GLOBALS['TL_LANG']['tl_module']['hofff_solr_doctypeOptions']['contao_page']	= 'Seiten';
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_doctypeOptions']['file']			= 'Dateien';
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_doctypeOptions']['image']			= 'Bilder';

$GLOBALS['TL_LANG']['tl_module']['hofff_solr_template']
	= array('Template', 'Das Modultemplate.');

$GLOBALS['TL_LANG']['tl_module']['hofff_solr_rememberQuery']
	= array('Letzte Anfrage anzeigen', 'Ob die letzte Suchanfrage im Suchfeld wieder angezeigt werden soll');
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_autocomplete']
	= array('Autovervollständigung (Browser)', 'Ob die Autovervollständigungs-Funktion des Browsers aktiviert werden soll.');
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_filter']
	= array('Dokument-Typen-Filter', 'Bietet dem Nutzer an, nach den ausgewählten Dokument-Typen zu filtern.');
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_filter_label']
	= array('Dokumenttyp', '');
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_filter_doctype']
	= array(' ', '');
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_filter_group']
	= array('Gruppe', '');
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_filter_available']
	= array('Verfügbar', 'Zur Filterung durch den Besucher verfügbar.');

$GLOBALS['TL_LANG']['tl_module']['hofff_solr_target']
	= array('Ziel-Ergebnismodul', 'Wenn auf der Weiterleitungsseite, mehrere Ergebnismodule vorhanden sind, können Sie hiermit ein bestimmtes Modul zur Verarbeitung ansprechen, ansonsten bearbeiten alle Ergebnismodule die Anfrage.');
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_live']
	= array('Live Search', 'Aktualisiert die Suchergebnisse bereits bei der Eingabe.');
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_liveTarget']
	= array('Ergebnismodul für Live Search', 'Das Ergebnismodul, welches via Live-Search aktualisiert werden soll. Wird dieses auf der aktuellen Seite nicht gefunden, wird zur Weiterleitungsseite weitergeleitet.');

$GLOBALS['TL_LANG']['tl_module']['hofff_solr_copy']
	= array('Einstellungen übernehmen', 'Die Einstellungen eines anderen Moduls verwenden.');
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_nocopy']
	= 'Keine Einstellungen kopieren';

$GLOBALS['TL_LANG']['tl_module']['hofff_solr_handler']
	= array('Solr Request Handler', 'Wählen Sie den Solr Request Handler aus, der für die Suche verwendet werden soll.');
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_sources']
	= array('Suchquellen', 'Wählen Sie die Suchquellen aus, in denen gesucht werden soll.');

$GLOBALS['TL_LANG']['tl_module']['hofff_solr_regex']
	= array('Anfragezerlegung', 'Der reguläre Ausdruck um die Anfrage zu zerlegen. Freilassen um keine Zerlegung durchzuführen.');
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_prep']
	= array('Anfrage Vorverarbeitung', 'Der Mechanismus der zur Vorverarbeitung der Suchanfrage verwendet werden soll.');
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_prepOptions'] = array(
	'fuzzy'	=> 'Ähnlichkeits-Suche',
	'wildcard_all' => 'Platzhalter am Ende (alle Suchwörter)',
	'wildcard_last' => 'Platzhalter am Ende (nur letztes Suchwort)',
	'fuzzy_wildcard_last' => 'Platzhalter am Ende (nur letztes Suchwort), sonst Ähnlichkeits-Suche',
);
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_doctypes']
	= array('Dokumenttypen-Filter', 'Wählen Sie die Dokumenttypen nach denen die Ergebnisse eingeschränkt werden sollen.');

$GLOBALS['TL_LANG']['tl_module']['hofff_solr_perPage']
	= array('Ergebnisse pro Seite', 'Die Anzahl der Ergebnisse die pro Seite angezeigt werden (größer oder gleich 1).');
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_maxPages']
	= array('Seitenanzahl', 'Die maximale Anzahl an Seiten (größer oder gleich 0). "0" bedeutet soviele Seiten anzeigen um alle gefundenen Ergebnisse verfügbar zu machen.');
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_grouping']
	= array('Gruppierung', 'Die Gruppen in denen die Ergebnisse eingeteilt werden.');
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_grouping_label']
	= array('Dokumenttyp', '');
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_grouping_type']
	= array(' ', '');
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_grouping_group']
	= array('Gruppe', '');
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_documentTemplates']
	= array('Dokumenten-Templates', 'Die Templates der einzelnen Dokumenttypen die im Ergebnis vorkommen <strong>können</strong>.');
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_documentTemplates_label']
	= array('Dokumenttyp', '');
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_documentTemplates_doctype']
	= array(' ', '');
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_documentTemplates_template']
	= array('Template', '');
$GLOBALS['TL_LANG']['tl_module']['hofff_solr_showOnEmpty']
	= array('Alternativinhalt bei ergebnisloser Suche', 'Wenn die Suchanfrage keine Ergebnisse liefert, wird das Modul mit einem statischen Inhalt ausgegeben.');
