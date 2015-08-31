<?php

namespace Hofff\Contao\Solr\Index\Builder;

use Hofff\Contao\Solr\Index\Query;

class QueryBuilderUtils {

	public static function addParamsFromArray(Query $query, $params) {
		foreach(deserialize($params, true) as $param) {
			if(!strlen($param['name'])) {
				continue;
			}
			$method = $param['add'] ? 'addParam' : 'setParam';
			$query->$method($param['name'], $param['value']);
		}
	}

}
