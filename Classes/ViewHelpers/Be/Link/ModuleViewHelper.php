<?php

namespace NL\NlPageconfig\ViewHelpers\Be\Link;

use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;
class ModuleViewHelper extends AbstractLinkViewHelper
{
    /**
     * Arguments initialization
     *
     * @throws Exception
     */
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('module', 'string', 'The name of the module');
    }

    /**
     * @return string
     */
    protected function buildUri()
    {
        $module = $this->arguments['module'];
        $parameters = $this->arguments['parameters'];
        $referenceType = $this->arguments['referenceType'];

        return $this->uriBuilder->buildUriFromModule($module, $parameters, $referenceType);
    }
}