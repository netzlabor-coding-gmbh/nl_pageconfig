<?php

namespace NL\NlPageconfig\Hooks;


use NL\NlPageconfig\Domain\Service\ConfigService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class ConfigParser
{
    /**
     * Reference to the parent (calling) cObject set from TypoScript
     */
    public $cObj;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var ConfigService
     */
    protected $configService;

    /**
     * ConfigParser constructor.
     */
    public function __construct()
    {
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        $this->configService = $this->objectManager->get(ConfigService::class);
    }

    /**
     * Custom method for data processing. Also demonstrates how this gives us the ability to use methods in the parent object.
     *
     * @param string          When custom methods are used for data processing (like in stdWrap functions), the $content variable will hold the value to be processed. When methods are meant to just return some generated content (like in USER and USER_INT objects), this variable is empty.
     * @param array           TypoScript properties passed to this method.
     * @return        string  The input string reversed. If the TypoScript property "uppercase" was set, it will also be in uppercase. May also be linked.
     */
    public function parse($content, $conf)
    {
        $args = [
            isset($conf['key']) ? (string) $conf['key'] : null,
            isset($conf['pid']) ? (int) $conf['pid'] : null,
            isset($conf['recursive']) ? (int) $conf['recursive'] : null,
            isset($conf['rootline']) ? (boolean) $conf['rootline'] : false,
            isset($conf['respectStorage']) ? (boolean) $conf['respectStorage'] : true,
        ];

        $configs = $this->configService->getConfig(...$args);

        return $this->substituteMarkerArray($content, $configs, '###pageconfig__|###');
    }

    /**
     * @param $content
     * @param $markContentArray
     * @param string $wrap
     * @param bool $deleteUnused
     * @return mixed|null|string|string[]
     */
    public function substituteMarkerArray($content, $markContentArray, $wrap = '', $deleteUnused = false)
    {
        if (is_array($markContentArray)) {
            $wrapArr = GeneralUtility::trimExplode('|', $wrap);
            $search = [];
            $replace = [];
            foreach ($markContentArray as $marker => $markContent) {
                if (!empty($wrapArr)) {
                    $marker = $wrapArr[0] . $marker . $wrapArr[1];
                }
                $search[] = $marker;
                $replace[] = $markContent;
            }
            $content = str_replace($search, $replace, $content);
            unset($search, $replace);
            if ($deleteUnused) {
                if (empty($wrap)) {
                    $wrapArr = ['###', '###'];
                }
                $content = preg_replace('/' . preg_quote($wrapArr[0], '/') . '([\w|\\-]*)' . preg_quote($wrapArr[1], '/') . '/is', '', $content);
            }
        }

        return $content;
    }
}