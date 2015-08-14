<?php

namespace Hofff\Contao\Solr\Source;

use Hofff\Contao\Solr\Index\RequestHandler;
use Hofff\Contao\Solr\Query\Builder\DataImportHandlerQueryBuilder;
use Hofff\Contao\Solr\Query\QueryExecutor;

class ContaoPageSource extends AbstractDCAConfiguredSource {

	public function __construct(array $data) {
		parent::__construct($data);
	}

	public function getDocumentTypes() {
		return array('page', 'image');
	}

	public function getFields() {
		return array();
	}

	public function index(RequestHandler $handler) {
		$executor = new QueryExecutor;

		$builder = new DataImportHandlerQueryBuilder;
		$builder->setCommand(DataImportHandlerQueryBuilder::COMMAND_ABORT);
		$executor->execute($handler, $builder->createQuery());

		$this->generatePagesFile();

		$builder = new DataImportHandlerQueryBuilder;
		$builder->setCommand(DataImportHandlerQueryBuilder::COMMAND_FULL_IMPORT);
		$query = $builder->createQuery();
		$query->setParam('source', $this->getName());
		$query->setParam('pages', \Environment::get('base') . $this->getPagesFilePath());
		$executor->execute($handler, $query);
	}

	public function unindex(RequestHandler $handler) {
		$executor = new QueryExecutor;

		$builder = new DataImportHandlerQueryBuilder;
		$builder->setCommand(DataImportHandlerQueryBuilder::COMMAND_ABORT);
		$executor->execute($handler, $builder->createQuery());

		$builder = new DataImportHandlerQueryBuilder;
		$builder->setCommand(DataImportHandlerQueryBuilder::COMMAND_FULL_IMPORT);
		$query = $builder->createQuery();
		$query->setParam('source', $this->getName());
		$query->setParam('unindex', 1);
		$executor->execute($handler, $query);
	}

	public function getRoots() {
		return array_filter(array_map('intval', deserialize($this['page_roots'], true)));
	}

	public function isIndexImages() {
		return (bool) $this['index_images'];
	}

	public function getPagesFilePath() {
		return sprintf(
			'system/cache/hofff-solr/%d-%s.txt',
			$this['id'],
			standardize($this->getName())
		);
	}

	protected function generatePagesFile() {
		$roots = $this->getRoots() ?: array(0);
		$pages = \Database::getInstance()->getChildRecords($roots, 'tl_page');
		if(false === file_put_contents($this->getPagesFilePath(), implode(',', $pages))) {
			throw new \Exception;
		}
	}

}
