<?php

namespace Hofff\Contao\Solr\DCA;

class IndexHandlerDCA {

	public function childRecord($row) {
		$view = '<strong>' . $row['name'] . '</strong>';
		strlen($row['label']) && $view .= ' ' . $row['label'];
		return $view;
	}

}
