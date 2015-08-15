<?php

namespace Hofff\Contao\Solr\Module;

abstract class AbstractSolrModule extends \Module {

	const DEFAULT_TEMPLATE = 'mod_hofff_solr_search';

	protected $displayName = 'hofff_solr';

	public function generate() {
		if(TL_MODE == 'BE') {
			return $this->generateBE($this->displayName);
		}

		$this->setTemplate($this->hofff_solr_template ? $this->hofff_solr_template : $this::DEFAULT_TEMPLATE);

		return parent::generate();
	}

	protected function setTemplate($template) {
		$this->strTemplate = $this->hofff_solr_template = $template;
	}

	protected function getQuery($target = null) {
		if($target && isset($_GET['q' . $target])) {
			return \Input::get('q' . $target);
		} elseif(isset($_GET['q'])) {
			return \Input::get('q');
		}
	}

	protected function getHTMLID($id = null, $name = 'hofff_solr') {
		return $name . ($id === null ? $this->id : $id);
	}

	protected function generateBE($displayName) {
		$tpl = new \BackendTemplate('be_wildcard');

		$tpl->wildcard = sprintf('### %s ###', $displayName);
		$tpl->title = $this->headline;
		$tpl->id = $this->id;
		$tpl->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

		return $tpl->parse();
	}

}
