<?php

namespace Hofff\Contao\Solr\Result\Document;

class ContaoPageDocument extends Document {

	public function __construct(array $data = null) {
		parent::__construct($data);
	}

	public function getURL($format = self::URL_AUTO) {
		$url = parent::getURL($format);
// 		$query = $this->getQuery();
// 		if($query) {
// 			$url .= strpos($url, '?') === false ? '?' : '&';
// 			$url .= 'h=' . urlencode(implode(',', $query->getKeywords()));
// 		}
		return $url;
	}

}
