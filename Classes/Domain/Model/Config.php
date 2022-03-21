<?php
namespace NL\NlPageconfig\Domain\Model;

use TYPO3\CMS\Backend\Utility\BackendUtility;

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
 * Config
 */
class Config extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    const TYPE_PROPERTY_MAP = [
        1 => 'page',
        2 => 'image',
        3 => 'text',
        4 => 'string',
    ];

    /**
     * type
     *
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $type = 0;

    /**
     * valueKey
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $valueKey = '';

    /**
     * page
     *
     * @var int
     */
    protected $page = 0;

    /**
     * image
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $image = null;

    /**
     * text
     *
     * @var string
     */
    protected $text = '';

    /**
     * string
     *
     * @var string
     */
    protected $string = '';

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->{$this->getValuePropertyName()};
    }

    /**
     * @return string
     */
    public function getValueTitle()
    {
        return call_user_func([$this, 'get' . ucfirst($this->getValuePropertyName() . 'Title')]);
    }

    /**
     * @return string
     */
    public function getPageTitle()
    {
        if (!$this->getPage()) {
            return null;
        }

        $page = BackendUtility::getRecord('pages', $this->getPage(), 'uid, title');

        return $page['title'] . ' [' . $page['uid'] . ']';
    }

    /**
     * @return string
     */
    public function getTextTitle()
    {
        return $this->getText();
    }

    /**
     * @return string
     */
    public function getImageTitle()
    {
        if (!$this->getImage()) {
            return null;
        }

        $originalResource = $this->getImage()->getOriginalResource();
        return $originalResource->getProperty('name') . ' [' . $originalResource->getOriginalFile()->getUid() . ']';
    }

    /**
     * @return string
     */
    public function getValuePropertyName()
    {
        return static::TYPE_PROPERTY_MAP[$this->type];
    }

    /**
     * @return array
     */
    public function getRecordEditParams()
    {
        return [
            'edit' => [
                'tx_nlpageconfig_domain_model_config' => [
                    $this->getUid() => 'edit'
                ]
            ]
        ];
    }

    /**
     * Returns the type
     *
     * @return int $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the type
     *
     * @param int $type
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Returns the valueKey
     *
     * @return string $valueKey
     */
    public function getValueKey()
    {
        return $this->valueKey;
    }

    /**
     * Sets the valueKey
     *
     * @param string $valueKey
     * @return void
     */
    public function setValueKey($valueKey)
    {
        $this->valueKey = $valueKey;
    }

    /**
     * Returns the page
     *
     * @return int $page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Sets the page
     *
     * @param int $page
     * @return void
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * Returns the image
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Sets the image
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return void
     */
    public function setImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image)
    {
        $this->image = $image;
    }

    /**
     * Returns the text
     *
     * @return string $text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Sets the text
     *
     * @param string $text
     * @return void
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Returns the string
     *
     * @return string $string
     */
    public function getString()
    {
        return $this->string;
    }

    /**
     * Sets the string
     *
     * @param string $string
     * @return void
     */
    public function setString($string)
    {
        $this->string = $string;
    }
}
