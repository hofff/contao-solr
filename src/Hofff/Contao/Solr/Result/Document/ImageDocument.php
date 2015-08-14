<?php

namespace Hofff\Contao\Solr\Result\Document;

class ImageDocument extends Document {

	public function __construct(array $data = null) {
		parent::__construct($data);
	}

	public function getImageURL($format = self::URL_RELATIVE) {
		$src = $this->data['m_src_s'];

		if($format == self::URL_RELATIVE) {
			$base = \Environment::getInstance()->base;
			$n = strlen($base);
			if(0 == strncmp($base, $src, $n)) {
				return substr($src, $n);
			}
		}

		return $src;
	}

	public function getImage(array $size = null, $mode = 'box') {
		$url = $this->getImageURL();
		$image = array();

		if(!$size || 0 == strncmp($url, 'http://', 7)) {
			$image['src'] = $url;
			$image['width'] = $size[0];
			$image['height'] = $size[1];

		} else {
			$image['src'] = \Image::get($url, $size[0], $size[1], $mode);
			$file = new \File($image['src']);
			$image['width'] = $file->width;
			$image['height'] = $file->height;
		}

		return $image;
	}

}
