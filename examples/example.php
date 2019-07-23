<?php

// Include Composer Autoloader.
require_once __DIR__ . '/../vendor/autoload.php';

use ABGEO\HTMLGenerator\Document;

$document = new Document();

$html = $document
    ->setTitle('Title')
    ->setCharset('utf')
    ->setDescription('description')
    ->setKeywords(['k1', 'k2', 'k3', 'k2'])
    ->setBody('<b>Hello</b>')
    ->getDocument();

echo $html;
