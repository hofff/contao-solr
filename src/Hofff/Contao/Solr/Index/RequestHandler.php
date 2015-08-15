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

}
