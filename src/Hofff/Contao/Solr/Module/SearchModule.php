<?php

namespace Hofff\Contao\Solr\Module;

class SearchModule extends AbstractSolrModule {

	const DEFAULT_TEMPLATE = 'mod_hofff_solr_search';

	public function generate() {
		$this->displayName = $GLOBALS['TL_LANG']['FMD']['hofff_solr_search'][0];
		return parent::generate();
	}

	protected function compile() {
		$page = $this->jumpTo ? \PageModel::findWithDetails($this->jumpTo) : $GLOBALS['objPage'];
		$query = $this->getQuery($this->hofff_solr_target);

		$this->Template->action = $this->generateFrontendUrl($page->row());

		$this->Template->queryID = $this->getHTMLID();
		$this->Template->queryName = 'q';
		$this->Template->queryValue = $this->hofff_solr_rememberQuery ? $query : '';
		$this->Template->queryAutocomplete = $this->hofff_solr_autocomplete ? 'on' : 'off';

		$this->Template->targetName = 't';
		$this->Template->targetValue = $this->hofff_solr_target;

		$filter = array();
		foreach(deserialize($this->hofff_solr_filter) as $doctype => $group) {
			$filter[$group][] = $doctype;
		}
		foreach($filter as &$doctypes) {
			$doctypes = implode(',', $doctypes);
		}
		$this->Template->filter = $filter;
		$this->Template->filterID = 'f' . $this->id;
		$this->Template->filterName = 'f';
		$checked = \Input::get('f');
		$this->Template->filterChecked = isset($filter[$checked]) ? $checked : 'all';

		if($this->hofff_solr_live) {
			$GLOBALS['TL_JAVASCRIPT']['hofff.solr.js'] = 'system/modules/backboneit_solr/html/js/hofff.solr.js';
			$this->Template->live = true;
			$this->Template->liveTargetID = $this->getHTMLID($this->hofff_solr_liveTarget);
			$this->Template->liveTargetModule = intval($this->hofff_solr_liveTarget);
// 			$this->Template->liveOptions = array();
		}
	}

}
