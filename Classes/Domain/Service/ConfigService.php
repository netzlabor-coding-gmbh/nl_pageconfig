<?php

namespace NL\NlPageconfig\Domain\Service;


use NL\NlPageconfig\Domain\Model\Config;
use NL\NlPageconfig\Domain\Repository\ConfigRepository;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;

class ConfigService implements SingletonInterface
{
    /**
     * @var ConfigRepository
     */
    protected $configRepository;

    /**
     * @param ConfigRepository $repository
     */
    public function injectConfigRepository(ConfigRepository $repository)
    {
        $this->configRepository = $repository;
    }

    /**
     * @param string $key
     * @param int $pid
     * @param int $recursive
     * @param boolean $rootline
     * @param boolean $respectStorage
     * @return mixed|null
     */
    public function getConfig($key = null, $pid = null, $recursive = null, $rootline = false, $respectStorage = true)
    {
        $result = null;

        if (isset($key)) {
            /* @noinspection PhpUndefinedMethodInspection */
            if ($config = $this->configRepository->findConfig(...func_get_args())) {
                $result = ObjectAccess::getProperty($config, 'value');
            }
        } else {
            $configs = $this->configRepository->findConfig(...func_get_args());

            foreach ($configs as $config) {
                /* @var Config $config */
                $vKey = $config->getValueKey();
                if ($vKey && !isset($result[$vKey])) {
                    $result[$vKey] = $config->getValue();
                }
            }
        }

        return $result;
    }
}