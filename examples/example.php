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
    ->addStyle('../css/theme.css')
    ->addStyle('../css/custom.css')
    ->setBody('<b>Hello</b>')
    ->addScript('../js/scripts.js')
    ->addScript('../js/messages.js')
    ->addScript('../js/auth.js');

echo $document->getDocument();
