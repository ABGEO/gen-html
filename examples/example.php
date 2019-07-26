<?php

// Include Composer Autoloader.
require_once __DIR__ . '/../vendor/autoload.php';

use ABGEO\HTMLGenerator\Document;
use ABGEO\HTMLGenerator\Element;

$body = new Element();

$body->createHeader('<p>I\'m Paragraph in Header</p>')
    ->createLink(
        'Informatics.ge', 'https://informatics.ge',
        Element::TARGET_BLANK, ['class1', 'class1', 'class2'], 'id'
    )
    ->createBreak()
    ->createBreak()
    ->createLine()
    ->createArticle('<p>Hello</p>', ['class1'], 'id')
    ->createBold('I\'m Bold text', [], 'bold')
    ->createBlockquote(
        'I\'m Quote',
        'http://www.worldwildlife.org/who/index.html', [], 'quote'
    )
    ->createDiv('<p>I\'m Paragraph in Div</p>', [], 'div')
    ->createHeading('H1')
    ->createHeading('H3', 3)
    ->createHeading('H6', 6)
    ->createEm('I\'m Emphasized text')
    ->createBreak()
    ->createBreak()
    ->createCode('print ("Hello. World")')
    ->createI('<p>I\'m alternate voice</p>')
    ->createImg('../images/code.jpg', 'Alternative text')
    ->createList(['item1', 'item2', 'item3'], Element::LIST_UNORDERED)
    ->createFooter('<p>I\'m Paragraph in Footer</p>');

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
