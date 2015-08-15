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

	public function hasParam($name) {
		return isset($this->params[$name]);
	}

	public function getParam($name) {
		return $this->hasParam($name) ? $this->params[$name] : null;
	}

	public function setParam($name, $value) {
		$this->params[$name] = array($value);
	}

	public function addParam($name, $value) {
		$this->params[$name][] = $value;
	}

	public function removeParam($name) {
		unset($this->params[$name]);
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
