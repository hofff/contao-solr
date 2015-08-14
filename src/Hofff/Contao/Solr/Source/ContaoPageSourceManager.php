<?php

namespace Hofff\Contao\Solr\Source;

class ContaoPageSourceManager {

	public function hookOutputFrontendTemplate($buffer) {
		if(!isset($GLOBALS['objPage'])) {
			return $buffer;
		}

		$time = time();
		$page = $GLOBALS['objPage']->id;
		$base = \Environment::get('base');
		list($request) = explode('?', \Environment::get('request'), 2);
		$root = $GLOBALS['objPage']->rootId;
		$hash = md5($base . $request);

		$sql = 'SELECT COUNT(*) AS cnt FROM tl_hofff_solr_page WHERE page = ? AND hash = ?';
		$cnt = \Database::getInstance()->prepare($sql)->execute($page, $hash)->cnt;

		if($cnt) {
			$sql = 'UPDATE tl_hofff_solr_page SET tstamp = ?, root = ? WHERE page = ? AND hash = ?';
			\Database::getInstance()->prepare($sql)->execute($time, $root, $page, $hash);

		} else {
			$sql = 'INSERT INTO tl_hofff_solr_page %s';
			$set = array(
				'tstamp' => $time,
				'page' => $page,
				'base' => $base,
				'request' => $request,
				'root' => $root,
				'hash' => $hash,
			);
			\Database::getInstance()->prepare($sql)->set($set)->execute();
		}

		return $buffer;
	}

	public function cleanURLIndex() {
		$this->deleteOutdated();
		$this->deleteInvalid();
	}

	public function deleteOutdated() {
		$sql = <<<SQL
DELETE
FROM	tl_hofff_solr_page
WHERE	tstamp < ?
SQL;
		$time = time() - max(60 * 60 * 24, intval($GLOBALS['TL_CONFIG']['hofff_solr_page_outdate']));
		\Database::getInstance()->prepare($sql)->execute($time);
	}

	public function deleteInvalid() {
		$sql = <<<SQL
DELETE
FROM		s
USING		tl_hofff_solr_page AS s
LEFT JOIN	tl_page AS p ON p.id = s.page
WHERE		p.id IS NULL
OR			0 = LOCATE(p.alias, s.request)
SQL;
		\Database::getInstance()->query($sql);
	}

}
