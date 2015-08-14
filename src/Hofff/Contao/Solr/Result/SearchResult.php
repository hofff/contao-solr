<?php

namespace Hofff\Contao\Solr\Result;

class SearchResult implements \IteratorAggregate, \Countable {

	protected $docs;

	protected $found;

	protected $intPointer = 0;

	public function __construct(array $docs, $found) {
		$this->docs = $docs;
		$this->found = $found;
	}

	public function getDocuments() {
		return $this->docs;
	}

	public function getFound() {
		return $this->found;
	}

	public function isEmpty() {
		return $this->count() == 0;
	}

	public function getDocumentTypes() {
		$types = array();
		foreach($this as $doc) {
			$types[$doc->getType()] = true;
		}
		return array_keys($types);
	}

	public function getIterator() {
		return new \ArrayIterator($this->docs);
	}

	public function count() {
		return count($this->arrContent['response']['docs']);
	}

}
