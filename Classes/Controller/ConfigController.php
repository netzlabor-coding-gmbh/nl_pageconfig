<?php

namespace NL\NlPageconfig\Controller;


use NL\NlPageconfig\Domain\Repository\ConfigRepository;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Class ConfigController
 * @package NL\NlPageconfig\Controller
 */
class ConfigController extends ActionController
{
    /**
     * @var ConfigRepository
     */
    protected $configRepository;

    /**
     * @var UriBuilder
     */
    protected $backendUriBuilder;

    /**
     * @param ConfigRepository $repository
     */
    public function injectConfigRepository(ConfigRepository $repository)
    {
        $this->configRepository = $repository;
    }

    /**
     * @param UriBuilder $uriBuilder
     */
    public function injectBackendUriBuilder(UriBuilder $uriBuilder)
    {
        $this->backendUriBuilder = $uriBuilder;
    }

    /**
     *
     * @throws \TYPO3\CMS\Backend\Routing\Exception\RouteNotFoundException
     */
    public function listAction()
    {
        $configs = $this->getCurrentPageId() ? $this->configRepository->findAll()->toArray() : [];

        if (empty($configs)) {
            $this->addFlashMessage(
                LocalizationUtility::translate(
                    'flash.configsEmpty',
                    $this->request->getControllerExtensionName()
                ),
                '',
                FlashMessage::INFO
            );
        }

        $this->view->assignMultiple([
            'configs' => $configs,
            'createUri' => $this->backendUriBuilder->buildUriFromRoute('record_edit', $this->getRecordCreateParams()),
        ]);
    }

    /**
     * @return array
     */
    protected function getRecordCreateParams()
    {
        return [
            'edit' => [
                'tx_nlpageconfig_domain_model_config' => [
                    $this->getCurrentPageId() => 'new'
                ]
            ]
        ];
    }

    /**
     * @return int
     */
    protected function getCurrentPageId()
    {
        return (int) GeneralUtility::_GP('id');
    }

    /**
     * @inheritdoc
     */
    protected function getErrorFlashMessage()
    {
        return false;
    }
}