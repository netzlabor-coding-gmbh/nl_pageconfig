<?php
namespace NL\NlPageconfig\Domain\Repository;

use NL\NlPageconfig\Utility\PageUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/***
 *
 * This file is part of the "Page Config" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Maksym Chubin <maksim.chubin@netzlabor-coding.de>, netzlabor coding GmbH
 *
 ***/

/**
 * The repository for Configs
 */
class ConfigRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * @var array
     */
    protected $defaultOrderings = [
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    ];

    /**
     * @param bool $respectStoragePage
     * @return $this
     */
    public function setDefaultQueryRespectStoragePage($respectStoragePage = true)
    {
        $querySettings = $this->createQuery()->getQuerySettings()->setRespectStoragePage($respectStoragePage);

        $this->setDefaultQuerySettings($querySettings);

        return $this;
    }

    /**
     * @param string $key
     * @param int $pid
     * @param int $recursive
     * @param bool $rootline
     * @param bool $respectStorage
     * @return array|object|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findConfig($key = null, $pid = null, $recursive = null, $rootline = false, $respectStorage = true)
    {
        $query = $this->setDefaultQueryRespectStoragePage(false)->createQuery();

        $constraints = [];

        if (isset($key)) {
            $constraints['valueKey'] = ['equals', 'valueKey', (string) $key];
            $query->setLimit(1);
        }

        if ($respectStorage) {
            $constraints['pid'] = ['equals', 'pid', $pid ?: $this->getTypoScriptFrontendController()->id];

            if (isset($recursive)) {
                $constraints['pid'] = ['in', 'pid',
                    PageUtility::getRecursivePidList($constraints['pid'][2], (int) $recursive)
                ];
                $query->setOrderings(array_merge(['pid' => QueryInterface::ORDER_ASCENDING], $this->defaultOrderings));
            } elseif (!isset($pid) && $rootline) {
                $constraints['pid'] = ['in', 'pid',
                    array_column($this->getTypoScriptFrontendController()->rootLine, 'uid')
                ];
                $query->setOrderings(array_merge(['pid' => QueryInterface::ORDER_DESCENDING], $this->defaultOrderings));
            }
        }

        $constraints = array_map(function ($constraint) use ($query) {

            $method = array_shift($constraint);

            return call_user_func_array([$query, $method], $constraint);
        }, $constraints);

        $query->matching($query->logicalAnd($constraints));

        $result = $query->execute();

        return isset($key) ? $result->getFirst() : $result;
    }

    /**
     * @return \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
     */
    protected function getTypoScriptFrontendController()
    {
        return $GLOBALS['TSFE'];
    }
}
