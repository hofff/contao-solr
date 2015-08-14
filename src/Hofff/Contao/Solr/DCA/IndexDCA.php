<?php

namespace Hofff\Contao\Solr\DCA;

class IndexDCA {

	private $sources;

	public function optionsSources($row, $dc) {
		if(!$dc instanceof \DC_Table) {
			return array();
		}

		if(isset($this->sources)) {
			return $this->sources;
		}

		\System::loadLanguageFile('tl_hofff_solr_source');

		$sql = <<<SQL
SELECT		id, name, type
FROM		tl_hofff_solr_source
ORDER BY	name
SQL;
		$result = \Database::getInstance()->prepare($sql)->execute();

		$options = array();
		while($result->next()) {
			$options[$result->id] = sprintf(
				'%s (%s)',
				$result->name,
				$GLOBALS['TL_LANG']['tl_hofff_solr_source']['typeOptions'][$result->type]
			);
		}

		return $this->sources = $options;
	}

	private $handler = array();

	public function optionsHandler($row, $dc) {
		if(!$dc instanceof \DC_Table) {
			return array();
		}

		if(isset($this->handler[$dc->id])) {
			return $this->handler[$dc->id];
		}

		$sql = <<<SQL
SELECT		id, name, type
FROM		tl_hofff_solr_index_handler
WHERE		pid = ?
ORDER BY	name
SQL;
		$result = \Database::getInstance()->prepare($sql)->execute($dc->id);

		$options = array();
		while($result->next()) {
			$label = $result->name;
			strlen($result->type) && $label .= ' [' . $result->type . ']';
			$options[$result->id] = $label;
		}

		return $this->handler[$dc->id] = $options;
	}

	public function loadSources($value, $dc) {
		$sql = <<<SQL
SELECT		t.*
FROM		tl_hofff_solr_source AS s
LEFT JOIN
	(
		SELECT		i.*
		FROM		tl_hofff_solr_index_source AS i
		JOIN		tl_hofff_solr_index_handler AS h ON h.id = i.handler
		WHERE		h.pid = ?
	) AS t ON t.source = s.id
ORDER BY	s.name
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
		foreach($value as $row) {
			if($row['handler']) {
				\Database::getInstance()->prepare($sql)->set($row)->execute();
			}
		}

		return null;
	}

}
