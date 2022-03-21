<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:nl_pageconfig/Resources/Private/Language/locallang_db.xlf:tx_nlpageconfig_domain_model_config',
        'label' => 'value_key',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'sortby' => 'sorting',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => 'type,value_key,page,image,text,string',
        'iconfile' => 'EXT:nl_pageconfig/Resources/Public/Icons/tx_nlpageconfig_domain_model_config.gif'
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, value_key, page, image, text, string'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_nlpageconfig_domain_model_config',
                'foreign_table_where' => 'AND tx_nlpageconfig_domain_model_config.pid=###CURRENT_PID### AND tx_nlpageconfig_domain_model_config.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],

        'type' => [
            'exclude' => false,
            'label' => 'LLL:EXT:nl_pageconfig/Resources/Private/Language/locallang_db.xlf:tx_nlpageconfig_domain_model_config.type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['Please choose...', ''],
                    ['Page', 1],
                    ['Image', 2],
                    ['Text', 3],
                    ['String', 4],
                ],
                'size' => 1,
                'maxitems' => 1,
                'minitems' => 1,
                'eval' => 'int,required'
            ],
            'onChange' => 'reload',
        ],
        'value_key' => [
            'exclude' => false,
            'displayCond' => 'FIELD:type:!=:',
            'label' => 'LLL:EXT:nl_pageconfig/Resources/Private/Language/locallang_db.xlf:tx_nlpageconfig_domain_model_config.value_key',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'page' => [
            'exclude' => false,
            'displayCond' => 'FIELD:type:=:1',
            'label' => 'LLL:EXT:nl_pageconfig/Resources/Private/Language/locallang_db.xlf:tx_nlpageconfig_domain_model_config.page',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'pages',
                'size' => 1,
                'minitems' => 1,
                'maxitems' => 1,
            ]
        ],
        'image' => [
            'exclude' => false,
            'displayCond' => 'FIELD:type:=:2',
            'label' => 'LLL:EXT:nl_pageconfig/Resources/Private/Language/locallang_db.xlf:tx_nlpageconfig_domain_model_config.image',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                    ],
                    'foreign_types' => [
                        '0' => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ]
                    ],
                    'minitems' => 1,
                    'maxitems' => 1,
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
        ],
        'text' => [
            'exclude' => false,
            'displayCond' => 'FIELD:type:=:3',
            'label' => 'LLL:EXT:nl_pageconfig/Resources/Private/Language/locallang_db.xlf:tx_nlpageconfig_domain_model_config.text',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim,required',
            ],
            'defaultExtras' => 'richtext:rte_transform'
        ],
        'string' => [
            'exclude' => false,
            'displayCond' => 'FIELD:type:=:4',
            'label' => 'LLL:EXT:nl_pageconfig/Resources/Private/Language/locallang_db.xlf:tx_nlpageconfig_domain_model_config.string',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],

    ],
];
