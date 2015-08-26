<?php

namespace Hofff\Contao\Solr\Index;

use Hofff\Contao\Solr\Exception\SolrException;

class RequestHandlerFactory {

	public function __construct() {
	}

	public function createByID($id) {
		$sql = <<<SQL
SELECT		h.*, i.endpoint, i.core
FROM		tl_hofff_solr_index_handler AS h
LEFT JOIN	tl_hofff_solr_index AS i ON i.id = h.pid
WHERE		h.id = ?
SQL;
		$result = \Database::getInstance()->prepare($sql)->execute($id);

		if(!$result->numRows) {
			throw new SolrException(sprintf('Request handler ID %s not found', $id), 1);
		}

		return $this->createFromRow($result->row());
	}

	public function createFromRow($data) {
		return new DCAConfiguredRequestHandler($data);
	}

}
