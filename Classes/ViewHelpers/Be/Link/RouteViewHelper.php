<?php

namespace NL\NlPageconfig\ViewHelpers\Be\Link;

use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;
use TYPO3\CMS\Backend\Routing\Exception\RouteNotFoundException;
class RouteViewHelper extends AbstractLinkViewHelper
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
    }

    /**
     * @return string
     * @throws RouteNotFoundException
     */
    protected function buildUri()
    {
        $route = $this->arguments['route'];
        $parameters = $this->arguments['parameters'];
        $referenceType = $this->arguments['referenceType'];

        return $this->uriBuilder->buildUriFromRoute($route, $parameters, $referenceType);
    }
}