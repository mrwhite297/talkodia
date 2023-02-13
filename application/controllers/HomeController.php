<?php

use MailchimpMarketing\ApiClient;

/**
 * Home Controller
 *  
 * @package YoCoach
 * @author Fatbit Team
 */
class HomeController extends MyAppController
{

    /**
     * Initialize Home
     * 
     * @param string $action
     */
    public function __construct(string $action)
    {
        parent::__construct($action);
    }

    /**
     * Render Website Homepage
     */
    public function index()
    {
        $slides = Slide::getSlides();
        $this->sets([
            'slides' => $slides,
            'slideImages' => Slide::getSlideImages(array_keys($slides), $this->siteLangId),
            'whyUsBlock' => ExtraPage::getBlockContent(ExtraPage::BLOCK_WHY_US, $this->siteLangId),
            'browseTutorPage' => ExtraPage::getBlockContent(ExtraPage::BLOCK_BROWSE_TUTOR, $this->siteLangId),
            'startLearning' => ExtraPage::getBlockContent(ExtraPage::BLOCK_HOW_TO_START_LEARNING, $this->siteLangId),
            'bookingBefore' => FatApp::getConfig('CONF_CLASS_BOOKING_GAP'),
            'popularLanguages' => TeachLanguage::getPopularLangs($this->siteLangId),
            'testmonialList' => Testimonial::getTestimonials($this->siteLangId),
            'blogPostsList' => BlogPost::getBlogsForGrids($this->siteLangId),
            'topRatedTeachers' => $this->getTopRatedTeachers()
        ]);
        $class = new GroupClassSearch($this->siteLangId, $this->siteUserId, $this->siteUserType);
        $this->set('classes', $class->getUpcomingClasses());
        $this->_template->render();
    }

    /**
     * Setup News Letter
     */
    public function setUpNewsLetter()
    {
        $post = FatApp::getPostedData();
        $apikey = FatApp::getConfig("CONF_MAILCHIMP_KEY");
        $listId = FatApp::getConfig("CONF_MAILCHIMP_LIST_ID");
        $prefix = FatApp::getConfig("CONF_MAILCHIMP_SERVER_PREFIX");
        if (empty($apikey) || empty($listId) || empty($prefix)) {
            FatUtility::dieJsonError(Label::getLabel('LBL_NOT_CONFIGURED_PLEASE_CONTACT_SUPPORT'));
        }
        try {
            $mailchimp = new ApiClient();
            $mailchimp->setConfig(['apiKey' => $apikey, 'server' => $prefix]);
            $response = $mailchimp->ping->get();
            if (!isset($response->health_status)) {
                FatUtility::dieJsonError(Label::getLabel('LBL_CONFIGURED_ERROR_MESSAGE'));
            }
            $subscriber = $mailchimp->lists->addListMember($listId, ['email_address' => $post['email'], 'status' => 'subscribed'], true);
            if ($subscriber->status != 'subscribed') {
                FatUtility::dieJsonError(Label::getLabel('MSG_NEWSLETTER_SUBSCRIPTION_VALID_EMAIL'));
            }
        } catch (Exception $e) {
            $error = strtolower($e->getMessage());
            if (strpos($error, 'member exists') > -1) {
                FatUtility::dieJsonSuccess(Label::getLabel('MSG_YOU_ARE_ALREADY_SUBSCRIBER'));
            } else {
                FatUtility::dieJsonError($error);
            }
        }
        FatUtility::dieJsonSuccess(Label::getLabel('MSG_SUCCESSFULLY_SUBSCRIBED'));
    }

    /**
     * Get Top Rated Teachers
     * 
     * @return array
     */
    private function getTopRatedTeachers(): array
    {
        $srch = new TeacherSearch($this->siteLangId, $this->siteUserId, User::LEARNER);
        $srch->addMultipleFields([
            'teacher.user_first_name', 'teacher.user_last_name',
            'teacher.user_id', 'user_username', 'testat.testat_ratings',
            'teacher.user_country_id',
            'testat.testat_reviewes'
        ]);
        $srch->applyPrimaryConditions();
        $srch->addCondition('testat_ratings', '>', 0);
        $srch->addOrder('testat_ratings', 'DESC');
        $srch->setPageSize(8);
        $srch->doNotCalculateRecords();
        $records = FatApp::getDb()->fetchAll($srch->getResultSet(), 'user_id');
        $countryIds = array_column($records, 'user_country_id');
        $countries = TeacherSearch::getCountryNames($this->siteLangId, $countryIds);
        foreach ($records as $key => $record) {
            $records[$key]['country_name'] = $countries[$record['user_country_id']] ?? '';
            $records[$key]['full_name'] = $record['user_first_name'] . ' ' . $record['user_last_name'];
        }
        return $records;
    }

}
