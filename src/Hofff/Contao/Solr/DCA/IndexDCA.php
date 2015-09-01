<?php

namespace Hofff\Contao\Solr\DCA;

use Hofff\Contao\Solr\Source\SourceFactory;
use Hofff\Contao\Solr\Index\RequestHandlerFactory;

class IndexDCA {

	/**
	 * @param integer $index
	 * @return array<array[RequestHandler, Source]>
	 */
	public function createHandlerAndSources($index) {
		$sql = <<<SQL
SELECT		*
FROM		tl_hofff_solr_index_source	AS s
JOIN		tl_hofff_solr_index_handler	AS h ON h.id = s.handler
JOIN		tl_hofff_solr_index			AS i ON i.id = h.pid
WHERE		i.id = ?
GROUP BY	s.source
SQL;
		$result = \Database::getInstance()->prepare($sql)->execute($index);

		$handlerAndSources = array();
		$sourceFactory = SourceFactory::create();
		$handlerFactory = new RequestHandlerFactory;
		while($result->next()) {
			$handler = $handlerFactory->createFromRow($result->row());
			$source = $sourceFactory->createByID($result->source);
			$handlerAndSources[] = array($handler, $source);
		}

		return $handlerAndSources;
	}

	public function keyIndex() {
		foreach($this->createHandlerAndSources(\Input::get('id')) as list($handler, $source)) {
			$source->index($handler);
		}
		\Controller::redirect('contao/main.php?do=hofff_solr_index');
	}

	public function keyUnindex() {
		foreach($this->createHandlerAndSources(\Input::get('id')) as list($handler, $source)) {
			$source->unindex($handler);
		}
		\Controller::redirect('contao/main.php?do=hofff_solr_index');
	}

	public function keyStatus() {
		$output = '';

		foreach($this->createHandlerAndSources(\Input::get('id')) as list($handler, $source)) {
			$output .= '<pre>' . json_encode(json_decode($source->status($handler), true), JSON_PRETTY_PRINT) . '</pre>';
		}

		return $output;
	}

	private $sources;

	public function optionsSources() {
		if(isset($this->sources)) {
			return $this->sources;
		}

		\System::loadLanguageFile('tl_hofff_solr_source');

		$sql = <<<SQL
SELECT		id, name, type, label
FROM		tl_hofff_solr_source
ORDER BY	label
SQL;
		$result = \Database::getInstance()->prepare($sql)->execute();

		$options = array();
		while($result->next()) {
			$options[$result->id] = sprintf(
				'%s (%s) [%s]',
				$result->label,
				$GLOBALS['TL_LANG']['tl_hofff_solr_source']['typeOptions'][$result->type],
				$result->name
			);
		}

		return $this->sources = $options;
	}

	private $handler = array();

	public function optionsHandler() {
		$id = \Input::get('id');

		if(isset($this->handler[$id])) {
			return $this->handler[$id];
		}

		$sql = <<<SQL
SELECT		id, label, name
FROM		tl_hofff_solr_index_handler
WHERE		pid = ?
ORDER BY	name
SQL;
		$result = \Database::getInstance()->prepare($sql)->execute($id);

		$options = array();
		while($result->next()) {
			$label = $result->name;
			strlen($result->label) && $label .= ' [' . $result->label . ']';
			$options[$result->id] = $label;
		}

		return $this->handler[$id] = $options;
	}

	public function loadSources($value, $dc) {
		$sql = <<<SQL
SELECT		s.id AS source, t.handler
FROM		tl_hofff_solr_source AS s
LEFT JOIN
	(
		SELECT		i.*
		FROM		tl_hofff_solr_index_source AS i
		JOIN		tl_hofff_solr_index_handler AS h ON h.id = i.handler
		WHERE		h.pid = ?
	) AS t ON t.source = s.id
ORDER BY	s.label
SQL;
		$result = \Database::getInstance()->prepare($sql)->execute($dc->id);

		$value = array();
		while($result->next()) {
			$value[] = $result->row();
		}

		return $value;
	}

	public function saveSources($value, $dc) {
		$sql = <<<SQL
DELETE
FROM		tl_hofff_solr_index_source
WHERE		handler IN (SELECT h.id FROM tl_hofff_solr_index_handler AS h WHERE h.pid = ?)
SQL;
		\Database::getInstance()->prepare($sql)->execute($dc->id);

		$sql = 'INSERT INTO tl_hofff_solr_index_source %s';
		foreach(deserialize($value, true) as $row) {
			if($row['handler']) {
				\Database::getInstance()->prepare($sql)->set($row)->execute();
			}
		}

		return null;
	}

}
