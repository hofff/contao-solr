<?php

namespace Hofff\Contao\Solr\Source;

use Hofff\Contao\Solr\Query\Builder\DataImportHandlerQueryBuilder;
use Hofff\Contao\Solr\Query\QueryExecutor;
use Hofff\Contao\Solr\Index\RequestHandler;

class FileSource extends AbstractDCAConfiguredSource {

	public function __construct($strName) {
		parent::__construct($strName);
	}

	public function getDocumentTypes() {
		return array('file', 'image');
	}

	public function getFields() {
		return array();
	}

	public function index(RequestHandler $handler) {
		$executor = new QueryExecutor;

		$builder = new DataImportHandlerQueryBuilder;
		$builder->setCommand(DataImportHandlerQueryBuilder::COMMAND_ABORT);
		$executor->execute($handler, $builder->createQuery());

		$this->generateFilesFile();

		$builder = new DataImportHandlerQueryBuilder;
		$builder->setCommand(DataImportHandlerQueryBuilder::COMMAND_FULL_IMPORT);
		$query = $builder->createQuery();
		$query->setParam('source', $this->getName());
		$query->setParam('base', $this->getBase());
		$query->setParam('files', \Environment::get('base') . $this->getFilesFilePath());
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
		return array_filter(deserialize($this['file_roots'], true), 'strlen');
	}

	public function getExtension() {
		$extensions = array_filter(explode(',', $this['extensions']), 'strlen');
		return array_combine($extensions, $extensions);
	}

	public function getBase() {
		if(!strlen($this['base'])) {
			return \Environment::get('base');
		}
		return trim($this['base'], ' /') . '/';
	}

	public function getFilesFilePath() {
		return sprintf(
			'system/cache/hofff-solr/%d-%s.txt',
			$this['id'],
			standardize($this->getName())
		);
	}

	protected function generateFilesFile() {
		$files = array();
		$dirs = array();
		$extensions = $this->getExtension();

		$roots = $this->getRoots();
		if($roots) {
			foreach(\FilesModel::findMultipleByUuids($roots) as $file) {
				if($file->type == 'folder') {
					$dirs[$file->id] = $file->path;
				} elseif(!$extensions || isset($extensions[$file->extension])) {
					$files[$file->id] = true;
				}
			}
		} else {
			$dirs[0] = $GLOBALS['TL_CONFIG']['uploadPath'];
		}

		if($dirs) {
			$dirs = str_replace(array('%', '_', '\\'), array('\\\\%', '\\\\_', '\\\\\\\\'), $dirs);
			$dirs = array_map(function($dir) { return $dir . '/%'; }, $dirs);

			$pathConditionExtra = str_repeat(' OR path LIKE ?', count($dirs) - 1);
			$extensionCondition = $extensions ? 'AND extension IN (' . rtrim(str_repeat('?,', count($extensions)), ',') . ')' : '';
			$sql = <<<SQL
SELECT	id
FROM	tl_files
WHERE	type = 'file'
AND		(path LIKE ?$pathConditionExtra)
$extensionCondition
SQL;
			$params = array_merge(array_values($dirs), array_values($extensions));
			$result = \Database::getInstance()->prepare($sql)->execute($params);

			while($result->next()) {
				$files[$result->id] = true;
			}
		}

		if(false === file_put_contents($this->getFilesFilePath(), implode(',', array_keys($files)))) {
			throw new \Exception;
		}
	}

}
