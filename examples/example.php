<?php

// Include Composer Autoloader.
require_once __DIR__ . '/../vendor/autoload.php';

use ABGEO\HTMLGenerator\Document;
use ABGEO\HTMLGenerator\Element;

$body = new Element();

$body->createLink(
    'Informatics.ge', 'https://informatics.ge',
    Element::TARGET_BLANK, ['class1', 'class1', 'class2'], 'id'
);

$document = new Document();

$document
    ->setLanguage(Document::LANG_GEORGIAN)
    ->setTitle('Title')
    ->setCharset(Document::CHARSET_UTF_8)
    ->setDescription('description')
    ->setKeywords(['k1', 'k2', 'k3', 'k2'])
    ->addStyle('../css/theme.css')
    ->addStyle('../css/custom.css')
    ->setBody($body->getHtml())
    ->addScript('../js/scripts.js')
    ->addScript('../js/messages.js')
    ->addScript('../js/auth.js');

echo $document->getDocument();
