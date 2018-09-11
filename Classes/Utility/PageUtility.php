<?php

namespace NL\NlPageconfig\Utility;


use TYPO3\CMS\Core\Database\QueryGenerator;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;

class PageUtility
{
    /**
     * @param $pid
     * @param int $recursive
     * @return array
     */
    public static function getRecursivePidList($pid, $recursive = 0)
    {
        if (!MathUtility::canBeInterpretedAsInteger($pid) || !MathUtility::forceIntegerInRange($pid, 0)) {
            throw new \InvalidArgumentException('Invalid $pid Value. $pid must be positive integer, ' . gettype($pid) . "($pid) given");
        }

        /* @var QueryGenerator $queryGenerator */
        $queryGenerator = GeneralUtility::makeInstance(QueryGenerator::class);

        $pidList = GeneralUtility::intExplode(
            ',',
            $queryGenerator->getTreeList((int)$pid, $recursive, 0, '')
        );

        if (empty($pidList)) {
            throw new \InvalidArgumentException("Invalid \$pid Value. Page Does Not Exists");
        }

        return $pidList;
    }
}