<?php

$sDirRoot = dirname(realpath((dirname(__DIR__)) . "/../../"));
set_include_path(get_include_path().PATH_SEPARATOR.$sDirRoot);

require_once($sDirRoot . "/tests/AbstractFixtures.php");

class SimilarFixtures extends AbstractFixtures
{

    protected $aActivePlugins = array();
    public static function getOrder()
    {
        return 2;
    }

    public function load()
    {
        $oUserFirst = $this->getReference('user-golfer');
        $oPersonalBlogGolfer = $this->getReference('blog-gadgets');

        $date = new \DateTime();
        $date->add(new \DateInterval('P3D'));

        $oTopicInFuture = $this->_createTopic($oPersonalBlogGolfer->getBlogId(), $oUserFirst->getId(),
            'Normal Topic + 3 days to date',
            'normal topic text normal topic text normal topic text normal topic text normal topic text normal topic text',
            'ipad', $date->format('Y-m-d H:i:s'));

        $this->addReference('normal-topic-date-in-future', $oTopicInFuture);
    }

    /**
     * Create topic with default values
     *
     * @param int $iBlogId
     * @param int $iUserId
     * @param string $sTitle
     * @param string $sText
     * @param string $sTags
     * @param string $sDate
     *
     * @return ModuleTopic_EntityTopic
     */
    private function _createTopic($iBlogId, $iUserId, $sTitle, $sText, $sTags, $sDate)
    {
        $this->aActivePlugins = $this->oEngine->Plugin_GetActivePlugins();

        $oTopic = Engine::GetEntity('Topic');
        /* @var $oTopic ModuleTopic_EntityTopic */
        $oTopic->setBlogId($iBlogId);
        $oTopic->setUserId($iUserId);
        $oTopic->setUserIp('127.0.0.1');
        $oTopic->setForbidComment(false);
        $oTopic->setType('topic');
        $oTopic->setTitle($sTitle);
        $oTopic->setPublishIndex(true);
        $oTopic->setPublish(true);
        $oTopic->setPublishDraft(true);
        $oTopic->setDateAdd($sDate);
        $oTopic->setTextSource($sText);
        list($sTextShort, $sTextNew, $sTextCut) = $this->oEngine->Text_Cut($oTopic->getTextSource());

        $oTopic->setCutText($sTextCut);
        $oTopic->setText($this->oEngine->Text_Parser($sTextNew));
        $oTopic->setTextShort($this->oEngine->Text_Parser($sTextShort));

        $oTopic->setTextHash(md5($oTopic->getType() . $oTopic->getTextSource() . $oTopic->getTitle()));
        $oTopic->setTags($sTags);

        //with active plugin l10n added a field topic_lang
        if (in_array('l10n', $this->aActivePlugins)) {
             $oTopic->setTopicLang(Config::Get('lang.current'));
        }
        // @todo refact this
        $oTopic->_setValidateScenario('topic');
        $oTopic->_Validate();

        $this->oEngine->Topic_AddTopic($oTopic);

        return $oTopic;
    }
}