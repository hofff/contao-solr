<?php

namespace Hofff\Contao\Solr\Source;

use Hofff\Contao\Solr\Index\RequestHandler;

interface Source {

	public function getName();

	public function getDocumentTypes();

	public function getFields();

	public function index(RequestHandler $handler);

	public function unindex(RequestHandler $handler);

}
