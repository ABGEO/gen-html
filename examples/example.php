<?php

// Include Composer Autoloader.
require_once __DIR__ . '/../vendor/autoload.php';

use ABGEO\HTMLGenerator\Document;

$document = new Document();

$document
    ->setLanguage(Document::LANG_GEORGIAN)
    ->setTitle('Title')
    ->setCharset(Document::CHARSET_UTF_8)
    ->setDescription('description')
    ->setKeywords(['k1', 'k2', 'k3', 'k2'])
    ->setBody('<b>Hello</b>');

echo $document->getDocument();
