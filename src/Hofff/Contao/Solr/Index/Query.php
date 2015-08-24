<?php

namespace Hofff\Contao\Solr\Index;

class Query {

	private $params;

	private $content;

	private $contentType;

	public function __construct() {
		$this->params = array();
	}

	public function getParams() {
		return $this->params;
	}

	public function hasParam($name, $key = null) {
		if($key === null) {
			return isset($this->params[$name]);
		} else {
			return isset($this->params[$name][$key]);
		}
	}

	public function getParam($name, $key = null) {
		if(!$this->hasParam($name, $key)) {
			return null;
		} elseif($key === null) {
			return $this->params[$name];
		} else {
			return $this->params[$name][$key];
		}
	}

	public function setParam($name, $value, $key = null) {
		if($key === null) {
			$this->params[$name] = array($value);
		} else {
			$this->params[$name] = array($key => $value);
		}
	}

	public function addParam($name, $value, $key = null) {
		if($key === null) {
			$this->params[$name][] = $value;
		} else {
			$this->params[$name][$key] = $value;
		}
	}

	public function removeParam($name, $key = null) {
		if($key !== null) {
			unset($this->params[$name]);
		} else {
			unset($this->params[$name][$key]);
			if(!$this->params[$name]) {
				unset($this->params[$name]);
			}
		}
	}

	public function hasContent() {
		return isset($this->content);
	}

	public function getContent() {
		return $this->content;
	}

	public function getContentType() {
		return $this->hasContent() ? $this->mime : null;
	}

	public function setContent($content, $contentType = 'application/octet-stream') {
		$this->content = $content;
		$this->contentType = $contentType;
	}

	public function removeContent() {
		unset($this->content, $this->contentType);
	}

}
