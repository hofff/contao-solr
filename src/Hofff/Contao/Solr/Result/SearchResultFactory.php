<?php

namespace Hofff\Contao\Solr\Result;

class SearchResultFactory {

	public function __construct() {
	}

	public function create($content) {
		$content = json_decode($content, true);

		$offset = intval($content['response']['start']);
		$docs = array();
		foreach($content['response']['docs'] as $i => $data) {
			$docs[$i + $offset] = $this->createDocument($data);
		}

		$found = intval($content['response']['numFound']);

		return new SearchResult($docs, $found);
	}

	public function createDocument($data) {
		$class = $this->getDocumentClass($data['m_doctype_s']);
		$doc = $class->newInstance();
		$doc->setData($data);
		return $doc;
	}

	public function getDocumentClass($type) {
		if(isset($GLOBALS['SOLR_DOCTYPES'][$type]['resultDocumentClass'])) {
			$class = $GLOBALS['SOLR_DOCTYPES'][$type]['resultDocumentClass'];
		} else {
			$class = 'Hofff\\Contao\\Solr\\Result\\Document\\Document';
		}

		return new \ReflectionClass($class);
	}

}
