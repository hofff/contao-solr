<?php

namespace Hofff\Contao\Solr\Result;

use Hofff\Contao\Solr\Result\Document\Document;

class DocumentTemplateFactory {

	private $defaultTemplate;

	private $documentTemplates = array();

	public function __construct() {
	}

	public function setDefaultTemplate($defaultTemplate) {
		$this->defaultTemplate = $defaultTemplate;
	}

	public function setDocumentTemplates(array $documentTemplates) {
		$this->documentTemplates = $documentTemplates;
	}

	public function createTemplate(Document $doc) {
		$templateClass = TL_MODE == 'FE' ? 'FrontendTemplate' : 'BackendTemplate';
		$template = new $templateClass($this->getDocumentTemplate($doc->getType()));
		$template->setData($doc->getData());
		$template->doc = $doc;
		return $template;
	}

	public function getDocumentTemplate($type) {
		return isset($this->documentTemplates[$type]) ? $this->documentTemplates[$type] : $this->defaultTemplate;
	}

}
