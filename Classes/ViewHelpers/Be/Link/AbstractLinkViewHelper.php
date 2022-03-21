<?php

namespace NL\NlPageconfig\ViewHelpers\Be\Link;


use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

abstract class AbstractLinkViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'a';

    /**
     * @var UriBuilder
     */
    protected $uriBuilder;

    /**
     * @param UriBuilder $uriBuilder
     */
    public function injectUriBuilder(UriBuilder $uriBuilder)
    {
        $this->uriBuilder = $uriBuilder;
    }

    /**
     * Arguments initialization
     *
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('parameters', 'array', 'An array of parameters');
        $this->registerArgument('referenceType', 'string', 'The type of reference to be generated (one of the constants)', false, UriBuilder::ABSOLUTE_PATH);
        $this->registerTagAttribute('name', 'string', 'Specifies the name of an anchor');
        $this->registerTagAttribute(
            'rel',
            'string',
            'Specifies the relationship between the current document and the linked document'
        );
        $this->registerTagAttribute(
            'rev',
            'string',
            'Specifies the relationship between the linked document and the current document'
        );
        $this->registerTagAttribute('target', 'string', 'Specifies where to open the linked document');
        $this->registerUniversalTagAttributes();
    }

    /**
     * @return string Rendered link
     */
    public function render()
    {
        $uri = $this->buildUri();

        $this->tag->addAttribute('href', $uri);
        $this->tag->setContent($this->renderChildren());
        $this->tag->forceClosingTag(true);

        return $this->tag->render();
    }

    /**
     * @return string
     */
    abstract protected function buildUri();
}