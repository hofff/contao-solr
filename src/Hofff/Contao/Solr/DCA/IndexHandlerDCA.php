<?php

namespace Hofff\Contao\Solr\DCA;

class IndexHandlerDCA {

	public function childRecord($row) {
		$view = '<strong>' . $row['name'] . '</strong>';
		strlen($row['type']) && $view .= '[' . $row['type'] . ']';
		return $view;
	}

}
