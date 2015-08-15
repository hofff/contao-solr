<?php

namespace Hofff\Contao\Solr\Source;

use Hofff\Contao\Solr\Exception\SolrException;

class SourceFactory {

	public static function create() {
		return new self($GLOBALS['SOLR_SOURCE_TYPES']);
	}

	private $sourceConfig;

	public function __construct(array $sourceConfig) {
		$this->sourceConfig = $sourceConfig;
	}

	public function createByID($id) {
		$sql = <<<SQL
SELECT		*
FROM		tl_hofff_solr_source AS s
WHERE		s.id = ?
SQL;
		$result = \Database::getInstance()->prepare($sql)->execute($id);

		if(!$result->numRows) {
			throw new SolrException(sprintf('Source ID %s not found', $id), 1);
		}

		return $this->createFromRow($result->row());
	}

	public function createFromRow($data) {
		$config = $this->getSourceConfig($data['type']);
		$class = $config['class'];
		return new $class($data);
	}

	public function getSourceConfig($type) {
		if(!isset($this->sourceConfig[$type])) {
			throw new SolrException(sprintf('Unknown source type "%s"', $type), 1);
		}
		return $this->sourceConfig[$type];
	}

}
