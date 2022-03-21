<?php

namespace NL\NlPageconfig\ViewHelpers\Pageconfig;


use NL\NlPageconfig\Domain\Service\ConfigService;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class GetViewHelper extends AbstractViewHelper
{
    /**
     * @var ConfigService
     */
    protected $configService;

    /**
     * @param ConfigService $service
     */
    public function injectConfigService(ConfigService $service)
    {
        $this->configService = $service;
    }

    /**
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('key', 'string', 'Key of variable to retrieve');
        $this->registerArgument('pid', 'integer', 'Storage id of variables to retrieve');
        $this->registerArgument('recursive', 'integer', 'Recursive levels to retrieve variables');
        $this->registerArgument('rootline', 'boolean', 'Retrieve variables from rootline', false, false);
        $this->registerArgument('respectStorage', 'boolean', 'Respect variables storage', false, true);
    }

    /**
     * @return mixed|null
     */
    public function render()
    {
        return $this->configService->getConfig(...array_values($this->arguments));
    }
}