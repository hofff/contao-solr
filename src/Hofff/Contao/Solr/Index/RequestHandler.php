<?php

namespace Hofff\Contao\Solr\Index;

/**
 * @author Oliver Hoff <oliver@hofff.com>
 */
interface RequestHandler {

	/**
	 * @return string
	 */
	public function getEndpoint();

	/**
	 * @param Query $query
	 * @return void
	 */
	public function prepareQuery(Query $query);

}
