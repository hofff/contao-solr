<?php

namespace Hofff\Contao\Solr\Query\Builder;

use Hofff\Contao\Solr\Query\Query;

class SearchQueryBuilder {

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

	public function setPaging($perPage, $page = 0) {
		$this->query->setParam('rows', $perPage);
		$this->query->setParam('start', $page * $perPage);
	}

	public function addDocTypeFilter() {
		$conjunction = func_get_args();
		foreach($conjunction as &$disjunction) {
			$disjunction = str_replace('"', '\\"', array_filter((array) $disjunction));
			$disjunction && $disjunction = '+("' . implode('" OR "', $disjunction) . '")';
		}
		$conjunction = array_filter($conjunction);
		$conjunction && $this->query->addParam('fq', 'm_doctype_s:(' . implode(' AND ', $conjunction) . ')');
	}

	public function setKeywords(array $keywords, $prep = null) {
		switch($prep) {
			case 'fuzzy':
				$query = implode('~ ', $keywords) . '~';
				break;

			case 'wildcard_all':
				$query = implode('* ', $keywords) . '*';
				break;

			case 'wildcard_last':
				$query = implode(' ', $keywords) . '*';
				break;

			case 'fuzzy_wildcard_last':
				$query = implode('~ ', $keywords) . '*';
				break;

			default:
				$query = implode(' ', $keywords);
				break;
		}
		$this->query->setParam('q', $query);
	}

}
