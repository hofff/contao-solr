<?php

namespace Hofff\Contao\Solr\Module;

use Hofff\Contao\Solr\Index\Builder\SearchQueryBuilder;
use Hofff\Contao\Solr\Index\QueryExecutor;
use Hofff\Contao\Solr\Result\SearchResultFactory;
use Hofff\Contao\Solr\Result\DocumentTemplateFactory;
use Hofff\Contao\Solr\Index\RequestHandlerFactory;

class ResultModule extends AbstractSolrModule {

	const DEFAULT_TEMPLATE = 'mod_hofff_solr_result';

	public function generate() {
		$this->displayName = $GLOBALS['TL_LANG']['FMD']['hofff_solr_result'][0];
		$content = parent::generate();
		if(TL_MODE == 'FE' && $_GET['l'] == 1) {
			while(ob_end_clean());
			echo $content;
			exit;
		} else {
			return $content;
		}
	}

	protected function compile() {
		$this->Template->id = $this->getHTMLID();

		$query = $this->getQuery();
		if(!strlen($query)) {
			return;
		}

		$matches = null;
		if(false === preg_match_all($this->hofff_solr_regex, $query, $matches)) {
			$keywords = array($query);
		} elseif(!$matches[0]) {
			return;
		} else {
			$keywords = $matches[0];
		}

		$builder = new SearchQueryBuilder;
		$builder->setKeywords($keywords, $this->hofff_solr_prep);

		$filter = deserialize($this->hofff_solr_doctypes, true);
		$userFilter = explode(',', strval(\Input::get('f')));
		$builder->addDocTypeFilter($filter, $userFilter);

		$page = \Input::get('page') ?: 1;
		$builder->setPaging($this->hofff_solr_perPage, $page - 1);

		$query = $builder->createQuery();

		$executor = new QueryExecutor;

		$handlerFactory = new RequestHandlerFactory;
		$handler = $handlerFactory->createByID($this->hofff_solr_handler);
		$content = $executor->execute($handler, $query);

// 		var_dump($content); exit;

		$resultFactory = new SearchResultFactory;
		$result = $resultFactory->create($content);

		if($result->isEmpty()) {
			if($this->hofff_solr_showOnEmpty) {
				$this->Template->content = true;
				$this->Template->alternate = \IncludeArticleUtils::generateArticle(
					$this->bbit_mod_art_id,
					$this->bbit_mod_art_nosearch,
					$this->bbit_mod_art_container,
					$this->strColumn
				);
			}
			return;
		}

		$templateFactory = new DocumentTemplateFactory;
		$templateFactory->setDefaultTemplate('hofff_solr_doc');
		$templateFactory->setDocumentTemplates(deserialize($this->hofff_solr_documentTemplates, true));

		$this->Template->content = true;
		$this->Template->query = $query;
		$this->Template->keywords = $keywords;
		$this->Template->result = $result;
		$this->Template->templateFactory = $templateFactory;
		$this->Template->perPage = $this->hofff_solr_perPage;
		$this->Template->maxResults = $this->hofff_solr_maxPages
			? $this->hofff_solr_maxPages * $this->hofff_solr_perPage
			: PHP_INT_MAX;
	}

}
