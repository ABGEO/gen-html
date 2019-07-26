<?php

// Include Composer Autoloader.
require_once __DIR__ . '/../vendor/autoload.php';

use ABGEO\HTMLGenerator\Document;
use ABGEO\HTMLGenerator\Element;

$element = new Element();

$element
    ->addElement($element->createHeader('<p>I\'m Paragraph in Header</p>'))
    ->addElement(
        $element->createLink(
            'Informatics.ge', 'https://informatics.ge',
            Element::TARGET_BLANK, ['class1', 'class1', 'class2'], 'id'
        )
    )
    ->addElement($element->createBreak())
    ->addElement($element->createBreak())
    ->addElement($element->createLine())
    ->addElement($element->createArticle('<p>Hello</p>', ['class1'], 'id'))
    ->addElement($element->createBold('I\'m Bold text', [], 'bold'))
    ->addElement(
        $element->createBlockquote(
            'I\'m Quote',
            'http://www.worldwildlife.org/who/index.html', [], 'quote'
        )
    )
    ->addElement($element->createDiv('<p>I\'m Paragraph in Div</p>', [], 'div'))
    ->addElement($element->createHeading('H1'))
    ->addElement($element->createHeading('H3', 3))
    ->addElement($element->createHeading('H6', 6))
    ->addElement($element->createEm('I\'m Emphasized text'))
    ->addElement($element->createBreak())
    ->addElement($element->createBreak())
    ->addElement($element->createCode('print ("Hello. World")'))
    ->addElement($element->createI('<p>I\'m alternate voice</p>'))
    ->addElement($element->createImg('../images/code.jpg', 'Alternative text'))
    ->addElement(
        $element->createList(
            ['item1', 'item2', 'item3'], Element::LIST_UNORDERED
        )
    )
    ->addElement(
        $element->createNav(
            [
                $element->createLink('link1', '#link1'),
                $element->createLink('link2', '#link2'),
                $element->createLink('link3', '#link3'),
            ],
            '|'
        )
    )
    ->addElement($element->createParagraph('I\'m Paragraph'))
    ->addElement($element->createPre('I\'m preformatted text'))
    ->addElement($element->createProgress(10))
    ->addElement($element->createFooter('<p>I\'m Paragraph in Footer</p>'));

$document = new Document();

$document
    ->setLanguage(Document::LANG_GEORGIAN)
    ->setTitle('Title')
    ->setCharset(Document::CHARSET_UTF_8)
    ->setDescription('description')
    ->setKeywords(['k1', 'k2', 'k3', 'k2'])
    ->addStyle('../css/theme.css')
    ->addStyle('../css/custom.css')
    ->setBody($element->getHtml())
    ->addScript('../js/scripts.js')
    ->addScript('../js/messages.js')
    ->addScript('../js/auth.js');

echo $document->getDocument();
