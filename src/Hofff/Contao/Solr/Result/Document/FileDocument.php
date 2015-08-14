<?php

namespace Hofff\Contao\Solr\Result\Document;

class FileDocument extends Document {

	public function __construct(array $data = null) {
		parent::__construct($data);
	}

	public function getFile() {
		$path = $this->data['m_path_s'];
		if(is_file(TL_ROOT . '/' . $path)) {
			return new \File($path);
		}
	}

// 	public function parse() {
// 		$this->href = $this->getURL(self::URL_ABSOLUTE);

// 		if(is_file(TL_ROOT . '/' . $this->m_path_s)) {
// 			$this->file = new File($this->m_path_s);
// 			$this->filesize = $this->getReadableSize($this->file->filesize, 1);
// 			$this->icon = TL_FILES_URL . 'system/themes/' . $this->getTheme() . '/images/' . $this->file->icon;
// 		}

// 		return parent::parse();
// 	}

	public function getURL($format = self::URL_AUTO) {
		$url = $this->data['m_path_s'];
		$format == self::URL_RELATIVE || $url = \Environment::getInstance()->base . $url;
		return $url;
	}

}
