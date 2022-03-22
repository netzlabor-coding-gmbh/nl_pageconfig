<?php

namespace NL\NlPageconfig\ViewHelpers\Be\Uri;


use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;
use TYPO3\CMS\Backend\Routing\Exception\RouteNotFoundException;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\ViewHelpers\Be\AbstractBackendViewHelper;

class RouteViewHelper extends AbstractBackendViewHelper
{
    /**
     * Arguments initialization
     *
     * @throws Exception
     */
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('route', 'string', 'The name of the route');
        $this->registerArgument('parameters', 'array', 'An array of parameters');
        $this->registerArgument(
            'referenceType',
            'string',
            'The type of reference to be generated (one of the constants)',
            false,
            UriBuilder::ABSOLUTE_PATH
        );
    }

    /**
     * @return string Rendered link
     * @throws RouteNotFoundException
     */
    public function render()
    {
        /** @var UriBuilder $uriBuilder */
        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);

        $route = $this->arguments['route'];
        $parameters = $this->arguments['parameters'];
        $referenceType = $this->arguments['referenceType'];

        $uri = $uriBuilder->buildUriFromRoute($route, $parameters, $referenceType);

        return (string)$uri;
    }
}