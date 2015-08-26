<?php

namespace Hofff\Contao\Solr\DCA;

class ModuleDCA {

	public function loadGroups($value, $dc) {
		$grouping = deserialize($value, true);
		$doctypes = $this->getDocumentTypeOptions();
		// filter unknown doctypes and apply user order
		$doctypes = array_merge(array_intersect_key($grouping, $doctypes), $doctypes);

		$rows = array();
		$group = null;
		foreach($doctypes as $doctype => $label) {
			$row = array();
			$row['label'] = $label;
			$row['docType'] = $doctype;

			if(isset($grouping[$doctype])) {
				$row['group'] = $grouping[$doctype] == $group ? '' : $grouping[$doctype];
				$row['available'] = true;
				$group = $grouping[$doctype];
			}

			$rows[] = $row;
		}

		return array_values($rows);
	}

	public function saveGroups($value, $dc) {
		$availableField = isset($GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['columnFields']['available']);

		$grouping = array();
		$group = null;
		foreach(deserialize($value, true) as $row) if(!$availableField || $row['available']) {
			$group = $row['group'] ?: $group ?: $this->getDocumentTypeLabel($row['docType']);
			$grouping[$row['docType']] = $group;
		}

		return $grouping;
	}

	public function savePositiveInteger($value) {
		return max(1, intval($value));
	}

	public function saveNonNegativeInteger($value) {
		return max(0, intval($value));
	}

	public function loadDocumentTemplates($value, $dc) {
		$rows = array();

		foreach($this->optionsDocumentTypes($dc) as $doctype => $label) {
			$rows[$doctype] = array('doctype' => $doctype, 'label' => $label);
		}

		foreach(deserialize($value, true) as $doctype => $template) if(isset($rows[$doctype])) {
			$rows[$doctype]['template'] = $template;
		}

		return array_values($rows);
	}

	public function saveDocumentTemplates($value) {
		$templates = array();

		foreach(deserialize($value, true) as $row) if(strlen($row['template'])) {
			$templates[$row['doctype']] = $row['template'];
		}

		return $templates;
	}

	public function optionsTemplates($dc) {
		$class = $GLOBALS['FE_MOD']['application'][$dc->activeRecord->type];

		if(!$class) {
			return array();
		}

		try {
			$class = new \ReflectionClass($class);
		} catch (LogicException $e) {
			return array();
		}

		$default = $class->getConstant('DEFAULT_TEMPLATE');

		if(!$default) {
			return array();
		}

		$theme = \Input::get('act') == 'overrideAll' ? \Input::get('id') : $dc->activeRecord->pid;
		return $this->getTemplateGroupExcludeDefault($default, $theme);
	}

	public function optionsResultModules($dc) {
		$options = array();
		if($dc && $GLOBALS['TL_DCA']['tl_module']['fields'][$dc->field]['hofff_solr_nocopyOption']) {
			$options['hofff_solr_nocopy'] = &$GLOBALS['TL_LANG']['tl_module']['hofff_solr_nocopy'];
		}

		$sql = 'SELECT id, name FROM tl_module WHERE id != ? AND type = ? ORDER BY name';
		$result = \Database::getInstance()->prepare($sql)->execute($dc->activeRecord->id, 'hofff_solr_result');
		while($result->next()) {
			$options[$result->id] = $result->name . ' (ID ' . $result->id . ')';
		}

		return $options;
	}

	public function optionsHandlers($dc) {
		$sql = <<<SQL
SELECT		h.id, i.label AS index_label, h.label AS handler_label, h.name AS handler_name
FROM		tl_hofff_solr_index_handler AS h
JOIN		tl_hofff_solr_index AS i ON i.id = h.pid
ORDER BY	i.label, h.name, h.label
SQL;
		$result = \Database::getInstance()->prepare($sql)->execute();

		$options = array();
		while($result->next()) {
			$options[$result->id] = trim(sprintf(
				'%s - %s %s',
				$result->index_label,
				$result->handler_name,
				$result->handler_label
			));
		}

		return $options;
	}

	public function optionsSources() {
		\System::loadLanguageFile('tl_hofff_solr_source');

		$sql = <<<SQL
SELECT		s.id, s.label, s.name, s.type
FROM		tl_hofff_solr_source AS s
ORDER BY	s.label
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

		return $options;
	}

	public function optionsDocumentTypes() {
		$options = array();
		foreach(array_keys($GLOBALS['SOLR_DOCTYPES']) as $doctype) {
			$options[$doctype] = $this->getDocumentTypeLabel($doctype);
		}

		asort($options);
		return $options;
	}

	public function optionsDocumentTemplates($dc) {
		if(\Input::get('act') == 'overrideAll') {
			$theme = \Input::get('id');
		} else {
			$sql = 'SELECT pid FROM tl_module WHERE id = ?';
			$theme = \Database::getInstance()->prepare($sql)->execute(\Input::get('id'))->pid;
		}
		return $this->getTemplateGroupExcludeDefault('hofff_solr_doc', $theme);
	}

	protected function getDocumentTypeLabel($doctype) {
		return $GLOBALS['TL_LANG']['tl_module']['hofff_solr_doctypeOptions'][$doctype] ?: $doctype;
	}

	protected function getTemplateGroupExcludeDefault($default, $theme) {
		$templates = array();
		foreach($this->getTemplateGroup($default, $theme) as $template) {
			if($default != $template) {
				$templates[] = $template;
			}
		}

		sort($templates);
		return $templates;
	}

}
