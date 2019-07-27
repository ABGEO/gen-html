<?php

// Include Composer Autoloader.
require_once __DIR__ . '/../vendor/autoload.php';

use ABGEO\HTMLGenerator\Document;
use ABGEO\HTMLGenerator\Element;

$element = new Element();

$element
    ->add2Content($element->createHeader('<p>I\'m Paragraph in Header</p>'))
    ->add2Content(
        $element->createLink(
            'Informatics.ge', 'https://informatics.ge',
            Element::TARGET_BLANK, ['class1', 'class1', 'class2'], 'id'
        )
    )
    ->add2Content($element->createBreak())
    ->add2Content($element->createBreak())
    ->add2Content($element->createLine())
    ->add2Content($element->createArticle('<p>Hello</p>', ['class1'], 'id'))
    ->add2Content($element->createBold('I\'m Bold text', [], 'bold'))
    ->add2Content(
        $element->createBlockquote(
            'I\'m Quote',
            'http://www.worldwildlife.org/who/index.html', [], 'quote'
        )
    )
    ->add2Content($element->createDiv('<p>I\'m Paragraph in Div</p>', [], 'div'))
    ->add2Content($element->createHeading('H1'))
    ->add2Content($element->createHeading('H3', 3))
    ->add2Content($element->createHeading('H6', 6))
    ->add2Content($element->createEm('I\'m Emphasized text'))
    ->add2Content($element->createBreak())
    ->add2Content($element->createBreak())
    ->add2Content($element->createCode('print ("Hello. World")'))
    ->add2Content($element->createI('<p>I\'m alternate voice</p>'))
    ->add2Content($element->createImg('../images/code.jpg', 'Alternative text'))
    ->add2Content(
        $element->createList(
            ['item1', 'item2', 'item3'], Element::LIST_UNORDERED
        )
    )
    ->add2Content(
        $element->createNav(
            [
                $element->createLink('link1', '#link1'),
                $element->createLink('link2', '#link2'),
                $element->createLink('link3', '#link3'),
            ],
            '|'
        )
    )
    ->add2Content($element->createParagraph('I\'m Paragraph'))
    ->add2Content($element->createPre('I\'m preformatted text'))
    ->add2Content($element->createProgress(10))
    ->add2Content($element->createFooter('<p>I\'m Paragraph in Footer</p>'));

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
