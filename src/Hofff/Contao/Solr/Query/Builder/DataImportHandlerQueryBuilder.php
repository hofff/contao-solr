<?php

namespace Hofff\Contao\Solr\Query\Builder;

use Hofff\Contao\Solr\Query\Query;

class DataImportHandlerQueryBuilder {

	const PARAM_COMMAND		= 'command';
	const PARAM_ENTITY		= 'entity';
	const PARAM_CLEAN		= 'clean';
	const PARAM_COMMIT		= 'commit';
	const PARAM_OPTIMIZE	= 'optimize';
	const PARAM_DEBUG		= 'debug';

	const COMMAND_FULL_IMPORT	= 'full-import';
	const COMMAND_DELTA_IMPORT	= 'delta-import';
	const COMMAND_STATUS		= 'status';
	const COMMAND_RELOAD_CONFIG	= 'reload-config';
	const COMMAND_ABORT			= 'abort';

	private $query;

	public function __construct(Query $query = null) {
		$this->query = $query ? clone $query : new Query;
	}

	public function __clone() {
		$this->query = clone $this->query;
	}

	public function createQuery() {
		return clone $this->query;
	}

	public function setCommand($command) {
		$this->query->setParam(self::PARAM_COMMAND, $command);
	}

	public function addEntity($entity) {
		$entities = $this->query->hasParam(self::PARAM_ENTITY) ? $this->query->getParam(self::PARAM_ENTITY)[0] : '';
		$entities = array_filter(explode(',', $entities), 'strlen');
		$entities[] = $entity;
		$entities = implode(',', array_unique($entities));
		$this->query->setParam(self::PARAM_ENTITY, $entities);
	}

	public function setClean($clean) {
		$this->setBooleanParam(self::PARAM_CLEAN, $clean);
	}

	public function setCommit($commit) {
		$this->setBooleanParam(self::PARAM_COMMIT, $commit);
	}

	public function setOptimize($optimize) {
		$this->setBooleanParam(self::PARAM_OPTIMIZE, $optimize);
	}

	public function setDebug($debug) {
		$this->setBooleanParam(self::PARAM_DEBUG, $debug);
	}

	protected function setBooleanParam($name, $state) {
		$this->query->setParam($name, $state ? 'true' : 'false');
	}

}
