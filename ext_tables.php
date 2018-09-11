<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        if (TYPO3_MODE === 'BE') {

            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'NL.NlPageconfig',
                'web', // Make module a submodule of 'web'
                'pc', // Submodule key
                '', // Position
                [
                    'Config' => 'list',
                    
                ],
                [
                    'access' => 'user,group',
                    'icon'   => 'EXT:nl_pageconfig/Resources/Public/Icons/user_mod_pc.svg',
                    'labels' => 'LLL:EXT:nl_pageconfig/Resources/Private/Language/locallang_pc.xlf',
                ]
            );

        }

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nlpageconfig_domain_model_config', 'EXT:nl_pageconfig/Resources/Private/Language/locallang_csh_tx_nlpageconfig_domain_model_config.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nlpageconfig_domain_model_config');

    }
);
