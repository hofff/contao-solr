<?php

namespace Hofff\Contao\Solr\Source;

use Hofff\Contao\Solr\Exception\SolrException;

/**
 * @author Oliver Hoff <oliver@hofff.com>
 */
class SourceFactory {

	/**
	 * @return SourceFactory
	 */
	public static function create() {
		return new self($GLOBALS['SOLR_SOURCE_TYPES']);
	}

	/**
	 * @var array
	 */
	private $sourceConfig;

	/**
	 * @param array $sourceConfig
	 */
	public function __construct(array $sourceConfig) {
		$this->sourceConfig = $sourceConfig;
	}

	/**
	 * @param integer $id
	 * @throws SolrException
	 * @return Source
	 */
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

	/**
	 * @param array $data
	 * @return Source
	 */
	public function createFromRow(array $data) {
		$config = $this->getSourceConfig($data['type']);
		$class = $config['class'];
		return new $class($data);
	}

	/**
	 * @param string $type
	 * @return string
	 * @throws SolrException
	 */
	public function getSourceConfig($type) {
		if(!isset($this->sourceConfig[$type])) {
			throw new SolrException(sprintf('Unknown source type "%s"', $type), 1);
		}
		return $this->sourceConfig[$type];
	}

}
