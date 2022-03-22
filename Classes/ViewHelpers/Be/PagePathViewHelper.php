<?php

namespace NL\NlPageconfig\ViewHelpers\Be;


use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;

class PagePathViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Be\PagePathViewHelper
{
    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $id = GeneralUtility::_GP('id');
        $pageRecord = BackendUtility::readPageAccess($id, $GLOBALS['BE_USER']->getPagePermsClause(1));
        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);

        // Is this a real page
        if (is_array($pageRecord) && $pageRecord['uid']) {
            $title = substr($pageRecord['_thePathFull'], 0, -1);
            // Remove current page title
            $pos = strrpos($title, $pageRecord['title']);
            if ($pos !== false) {
                $title = substr($title, 0, $pos);
            }
        } else {
            $title = '';
        }
        // Setting the path of the page
        $pagePath = htmlspecialchars($GLOBALS['LANG']->sL('LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:labels.path')) . ': <span class="typo3-docheader-pagePath">';
        // crop the title to title limit (or 50, if not defined)
        $cropLength = empty($GLOBALS['BE_USER']->uc['titleLen']) ? 50 : $GLOBALS['BE_USER']->uc['titleLen'];
        $croppedTitle = GeneralUtility::fixed_lgd_cs($title, -$cropLength);
        if ($croppedTitle !== $title) {
            $pagePath .= '<abbr title="' . htmlspecialchars($title) . '">' . htmlspecialchars($croppedTitle) . '</abbr>';
        } else {
            $pagePath .= htmlspecialchars($title);
        }
        $pagePath .= '</span>';

        // Add icon with context menu, etc:
        // If there IS a real page
        if (is_array($pageRecord) && $pageRecord['uid']) {
            $alttext = BackendUtility::getRecordIconAltText($pageRecord, 'pages');
            $iconImg = '<span title="' . htmlspecialchars($alttext) . '">' . $iconFactory->getIconForRecord('pages', $pageRecord, Icon::SIZE_SMALL)->render() . '</span>';
            // Make Icon:
            $theIcon = BackendUtility::wrapClickMenuOnIcon($iconImg, 'pages', $pageRecord['uid']);
            $uid = '&nbsp;[' . $pageRecord['uid'] . ']';
            $title = BackendUtility::getRecordTitle('pages', $pageRecord);
        } else {
            // On root-level of page tree
            // Make Icon
            $iconImg = '<span title="' . htmlspecialchars($GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename']) . '">' . $iconFactory->getIcon('apps-pagetree-root', Icon::SIZE_SMALL)->render() . '</span>';
            if ($GLOBALS['BE_USER']->user['admin']) {
                $theIcon = BackendUtility::wrapClickMenuOnIcon($iconImg, 'pages', 0);
            } else {
                $theIcon = $iconImg;
            }
            $uid = '';
            $title = $GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'];
        }
        // Setting icon with context menu + uid
        $pageInfo = $theIcon . '&nbsp;<strong>' . htmlspecialchars($title) . $uid . '</strong>';

        return $pagePath . ' ' .  $pageInfo;
    }
}