<?php

/**
 * Classes Controller is used for handling Classes on Teacher and Learner Dashboards
 *  
 * @package YoCoach
 * @author Fatbit Team
 */
class ClassesController extends DashboardController
{

    /**
     * Initialize ClassesController 
     * 
     * @param string $action
     */
    public function __construct(string $action)
    {
        parent::__construct($action);
    }

    /**
     * Render Search Form
     */
    public function index()
    {
        $this->_template->addJs([
            'js/teacherLessonCommon.js',
            'js/jquery.datetimepicker.js',
            'issues/page-js/common.js',
            'classes/page-js/common.js',
            'js/jquery.cookie.js',
            'js/app.timer.js',
            'plans/page-js/common.js',
            'js/jquery.barrating.min.js',
            'js/moment.min.js',
            'js/fullcalendar-luxon.min.js',
            'js/fullcalendar.min.js',
            'js/fullcalendar-luxon-global.min.js',
            'js/fateventcalendar.js'
        ]);
        $frm = ClassSearch::getSearchForm($this->siteUserType);
        $postData = FatApp::getQueryStringData();
        if (!empty($postData['package_id'])) {
            $postData = array_merge($postData, [
                'ordcls_status' => '',
                'grpcls_status' => '',
                'grpcls_start_datetime' => ''
            ]);
        }
        $frm->fill($postData);
        $this->sets([
            'frm' => $frm, 'setMonthAndWeekNames' => true,
            'upcomingClass' => $this->getUpcomingClass()
        ]);
        $this->_template->render();
    }

    /**
     * Search & List Classes
     */
    public function search()
    {
        $langId = $this->siteLangId;
        $userId = $this->siteUserId;
        $userType = $this->siteUserType;
        $posts = FatApp::getPostedData();
        $posts['pageno'] = $posts['pageno'] ?? 1;
        $posts['pagesize'] = AppConstant::PAGESIZE;
        $frm = ClassSearch::getSearchForm($userType);
        if (!$post = $frm->getFormDataFromArray($posts)) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }
        $srch = new ClassSearch($langId, $userId, $userType);
        $srch->applySearchConditions($post);
        $srch->applyPrimaryConditions();
        $srch->addSearchListingFields();
        $srch->addOrder('grpcls_start_datetime');
        $srch->setPageSize($post['pagesize']);
        $srch->setPageNumber($post['pageno']);
        $rows = $srch->fetchAndFormat();
        $myDate = new MyDate();
        $myDate->setMonthAndWeekNames();
        $this->sets([
            'post' => $post,
            'myDate' => $myDate,
            'recordCount' => $srch->recordCount(),
            'planType' => Plan::PLAN_TYPE_CLASSES,
            'allClasses' => $srch->groupDates($rows),
        ]);
        $this->_template->render(false, false, 'classes/search-listing.php');
    }

    /**
     * Render Class Detail View
     * 
     * @param type $classId
     */
    public function view($classId)
    {
        $classId = FatUtility::int($classId);
        $condition = ['grpcls_id' => $classId];
        if ($this->siteUserType == User::LEARNER) {
            $condition = ['ordcls_id' => $classId];
        }
        $srch = new ClassSearch($this->siteLangId, $this->siteUserId, $this->siteUserType);
        $srch->applyPrimaryConditions();
        $srch->applySearchConditions($condition);
        $srch->addSearchListingFields();
        $srch->setPageSize(1);
        $classes = $srch->fetchAndFormat(true);
        if (empty($classes)) {
            FatUtility::exitWithErrorCode(404);
        }
        $class = current($classes);
        $learners = [];
        if ($this->siteUserType == User::TEACHER) {
            if (empty($class['grpcls_booked_seats'])) {
                FatUtility::exitWithErrorCode(404);
            }
            $learners = OrderClass::getOrdClsByGroupId($classId, [], [OrderClass::SCHEDULED, OrderClass::COMPLETED]);
        }
        $flashcardEnabled = FatApp::getConfig('CONF_ENABLE_FLASHCARD');
        if ($flashcardEnabled) {
            $flashcardSrchFrm = Flashcard::getSearchForm($this->siteLangId);
            $flashcardSrchFrm->fill(['flashcard_type_id' => $classId]);
            $this->set('flashcardSrchFrm', $flashcardSrchFrm);
        }

        if (!empty($class['grpcls_metool_id'])) {
            $mettingTool = (new MeetingTool($class['grpcls_metool_id']))->getDetail();
        } else {
            $mettingTool = MeetingTool::getActiveTool();
        }
        $this->sets([
            'class' => $class,
            'classId' => $classId,
            'learners' => $learners,
            'mettingTool' => $mettingTool,
            'flashcardEnabled' => $flashcardEnabled
        ]);
        $this->_template->addJs([
            'js/jquery.cookie.js',
            'js/app.timer.js',
            'issues/page-js/common.js',
            'js/jquery.barrating.min.js',
            'classes/page-js/common.js',
            'plans/page-js/common.js'
        ]);
        if ($flashcardEnabled) {
            $this->_template->addJs('js/flashcards.js');
        }
        if ($mettingTool['metool_code'] == MeetingTool::ATOM_CHAT) {
            $this->_template->addJs('js/atom-chat.js');
        }
        $this->_template->render();
    }

    /**
     * Render Calendar View
     */
    public function calendarView()
    {
        $this->set('nowDate', MyDate::formatDate(date('Y-m-d H:i:s')));
        $this->_template->render(false, false);
    }

    /**
     * Calendar JSON
     */
    public function calendarJson()
    {
        $form = ClassSearch::getSearchForm($this->siteUserType, true);
        if (!$post = $form->getFormDataFromArray(FatApp::getPostedData())) {
            FatUtility::dieJsonError(current($form->getValidationErrors()));
        }

        $post['start'] = MyDate::changeDateTimezone($post['start'], $this->siteTimezone, MyUtility::getSystemTimezone());
        $post['end'] = MyDate::changeDateTimezone($post['end'], $this->siteTimezone, MyUtility::getSystemTimezone());
        $srch = new ClassSearch($this->siteLangId, $this->siteUserId, $this->siteUserType);
        $srch->doNotCalculateRecords();
        $srch->applyPrimaryConditions();
        $srch->applySearchConditions($post);
        $srch->applyCalendarConditions($post);
        $srch->addMultipleFields([
            'IFNULL(gclang.grpcls_title, grpcls.grpcls_title) as title',
            'grpcls.grpcls_start_datetime as start',
            'grpcls.grpcls_end_datetime as end'
        ]);
        $db = FatApp::getDb();
        $resultSet = $srch->getResultSet();
        $response = [];
        while ($row = $db->fetch($resultSet)) {
            $row['start'] = MyDate::formatDate($row['start']);
            $row['end'] = MyDate::formatDate($row['end']);
            $response[] = $row;
        }
        FatUtility::dieJsonSuccess(['data' => $response]);
    }

    /**
     * Join Meeting
     * 
     * 1. Get Class to join
     * 2. Initialize Meeting
     * 3. Join on Meeting Tool
     * 4. Add Join Datetime
     */
    public function joinMeeting()
    {
        /* Get Class to join */
        $classId = FatApp::getPostedData('classId', FatUtility::VAR_INT, 0);
        if ($this->siteUserType == User::LEARNER) {
            $classObj = new OrderClass($classId, $this->siteUserId, $this->siteUserType);
        } else {
            $classObj = new GroupClass($classId, $this->siteUserId, $this->siteUserType);
        }
        if (!$class = $classObj->getClassToStart($this->siteLangId)) {
            FatUtility::dieJsonError($classObj->getError());
        }
        if ($this->siteUserType == User::LEARNER && is_null($class['grpcls_teacher_starttime'])) {
            FatUtility::dieJsonError(Label::getLabel('LBL_LET_THE_TEACHER_START_CLASS'));
        }
        /* Initialize Meeting */
        $meetingObj = new Meeting($this->siteUserId, $this->siteUserType);
        if (!$meetingObj->initMeeting($class['grpcls_metool_id'])) {
            FatUtility::dieJsonError($meetingObj->getError());
        }
        /* Join on Meeting Tool */
        if (!$meeting = $meetingObj->joinClass($class)) {
            FatUtility::dieJsonError($meetingObj->getError());
        }
        $class['grpcls_metool_id'] = $meeting['meet_metool_id'];
        /* Add join datetime */
        if (!$classObj->start($class)) {
            FatUtility::dieJsonError($classObj->getError());
        }
        FatUtility::dieJsonSuccess(['meeting' => $meeting, 'msg' => Label::getLabel('LBL_JOINING_PLEASE_WAIT')]);
    }

    /**
     * End Meeting
     * 
     * 1. Get Class to Complete
     * 2. Initialize Meeting Tool
     * 3. End on Meeting Tool
     * 4. Mark Meeting Complete
     */
    public function endMeeting()
    {
        $classId = FatApp::getPostedData('classId', FatUtility::VAR_INT, 0);
        if ($this->siteUserType == User::LEARNER) {
            $classObj = new OrderClass($classId, $this->siteUserId, $this->siteUserType);
        } else {
            $classObj = new GroupClass($classId, $this->siteUserId, $this->siteUserType);
        }
        /* Get Class To Complete */
        if (!$class = $classObj->getClassToComplete()) {
            FatUtility::dieJsonError($classObj->getError());
        }
        /* Initialize Meeting Tool */
        $meetingObj = new Meeting($this->siteUserId, $this->siteUserType);
        if (!$meetingObj->initMeeting($class['grpcls_metool_id'])) {
            FatUtility::dieJsonError($meetingObj->getError());
        }
        /* End on Meeting Tool */
        if (!$meetingObj->endMeeting($classId, AppConstant::GCLASS)) {
            FatUtility::dieJsonError($meetingObj->getError());
        }
        /* Mark Meeting Complete */
        if (!$classObj->complete($class)) {
            FatUtility::dieJsonError($classObj->getError());
        }
        FatUtility::dieJsonSuccess(Label::getLabel('LBL_ACTION_PERFORMED_SUCCESSFULLY'));
    }

    /**
     * Render Cancel Class Form
     */
    public function cancelForm()
    {
        $classId = FatApp::getPostedData('classId', FatUtility::VAR_INT, 0);
        if ($this->siteUserType == User::LEARNER) {
            $class = new OrderClass($classId, $this->siteUserId, $this->siteUserType);
        } else {
            $class = new GroupClass($classId, $this->siteUserId, $this->siteUserType);
        }
        if (!$record = $class->getClassToCancel()) {
            FatUtility::dieJsonError($class->getError());
        }
        $refundPercentage = ($this->siteUserType == User::TEACHER && $record['grpcls_booked_seats'] > 0) ? 100 : 0;
        if ($this->siteUserType == User::LEARNER && FatUtility::float($record['order_net_amount']) > 0) {
            $refundPercentage = OrderClass::getRefundPercentage($this->siteUserType, $record['grpcls_start_datetime']);
        }
        $frm = $this->getCancelForm();
        $frm->fill(['classId' => $classId]);
        $this->sets(['frm' => $frm, 'class' => $record, 'refundPercentage' => $refundPercentage]);
        $this->_template->render(false, false);
    }

    /**
     * Cancel Class
     */
    public function cancelSetup()
    {
        $frm = $this->getCancelForm();
        if (!$post = $frm->getFormDataFromArray(FatApp::getPostedData())) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }
        $classId = $post['classId'];
        if ($this->siteUserType == User::LEARNER) {
            $class = new OrderClass($classId, $this->siteUserId, $this->siteUserType);
        } else {
            $class = new GroupClass($classId, $this->siteUserId, $this->siteUserType);
        }
        if (!$class->cancel($post['comment'], $this->siteLangId)) {
            FatUtility::dieJsonError($class->getError());
        }
        FatUtility::dieJsonSuccess(Label::getLabel('LBL_ACTION_PERFORMED_SUCCESSFULLY'));
    }

    /**
     * Render Feedback Form
     */
    public function feedbackForm()
    {
        $classId = FatApp::getPostedData('classId', FatUtility::VAR_INT, 0);
        $class = new OrderClass($classId, $this->siteUserId, $this->siteUserType);
        if (!$record = $class->getClassToFeedback()) {
            FatUtility::dieJsonError($class->getError());
        }
        $frm = RatingReview::getFeedbackForm();
        $record['ratrev_type_id'] = $classId;
        $frm->fill($record);
        $this->sets(['frm' => $frm, 'class' => $record]);
        $this->_template->render(false, false);
    }

    /**
     * Setup Feedback
     */
    public function feedbackSetup()
    {
        $posts = FatApp::getPostedData();
        $frm = RatingReview::getFeedbackForm();
        if (!$post = $frm->getFormDataFromArray($posts)) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }
        $classId = FatApp::getPostedData('ratrev_type_id', FatUtility::VAR_INT, 0);
        $class = new OrderClass($classId, $this->siteUserId, $this->siteUserType);
        $post['ratrev_lang_id'] = $this->siteLangId;
        if (!$class->feedback($post)) {
            FatUtility::dieJsonError($class->getError());
        }
        FatUtility::dieJsonSuccess(Label::getLabel('LBL_ACTION_PERFORMED_SUCCESSFULLY'));
    }

    /**
     * Get Cancel Form
     * 
     * @return Form
     */
    private function getCancelForm(): Form
    {
        $frm = new Form('cancelFrm');
        $comment = $frm->addTextArea(Label::getLabel('LBL_COMMENTS'), 'comment');
        $comment->requirements()->setLength(10, 300);
        $comment->requirements()->setRequired();
        $frm->addHiddenField('', 'classId')->requirements()->setRequired();
        $frm->addSubmitButton('', 'submit', Label::getLabel('LBL_SUBMIT'));
        return $frm;
    }

    /**
     * Render Add|Edit Class Form
     */
    public function addForm()
    {
        $form = $this->getAddForm();
        $classId = FatApp::getPostedData('classId', FatUtility::VAR_INT, 0);
        $isClassBooked = false;
        if ($classId > 0) {
            $groupClass = new GroupClass($classId, $this->siteUserId, $this->siteUserType);
            if (!$classData = $groupClass->getClassToSave()) {
                FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
            }
            $file = new Afile(Afile::TYPE_GROUP_CLASS_BANNER);
            $this->set('banner', $file->getFile($classId));
            $isClassBooked = ($classData['grpcls_booked_seats'] > 0);
            $classData['grpcls_start_datetime'] = MyDate::formatDate($classData['grpcls_start_datetime']);
            $form->fill($classData);
            $min = max($classData['grpcls_booked_seats'], 1);
            $form->getField('grpcls_total_seats')->requirements()->setRange($min, FatApp::getConfig('CONF_GROUP_CLASS_MAX_LEARNERS'));
        }

        $this->set('frm', $form);
        $this->set('classId', $classId);
        $this->set('isClassBooked', $isClassBooked);
        $this->set('languages', Language::getAllNames(false));
        $this->_template->render(false, false);
    }

    /**
     * Setup Class
     */
    public function setupClass()
    {
        $post = FatApp::getPostedData();
        if (isset($post['grpcls_slug'])) {
            $post['grpcls_slug'] = CommonHelper::seoUrl($post['grpcls_slug']);
        }
        $form = $this->getAddForm(true);
        if (!$post = $form->getFormDataFromArray($post + $_FILES)) {
            FatUtility::dieJsonError(current($form->getValidationErrors()));
        }
        $post['grpcls_start_datetime'] = MyDate::formatToSystemTimezone($post['grpcls_start_datetime']);
        $post['grpcls_end_datetime'] = date('Y-m-d H:i', strtotime($post['grpcls_start_datetime'] . ' + ' . $post['grpcls_duration'] . ' minutes'));
        $post['grpcls_teacher_id'] = $this->siteUserId;
        if (0 >= $post['grpcls_id']) {
            $post['grpcls_status'] = GroupClass::SCHEDULED;
        }
        $class = new GroupClass($post['grpcls_id'], $this->siteUserId, $this->siteUserType);
        if (!$class->saveClass($post)) {
            FatUtility::dieJsonError($class->getError());
        }
        FatUtility::dieJsonSuccess([
            'classId' => $class->getMainTableRecordId(),
            'msg' => Label::getLabel('LBL_CLASS_SETUP_SUCCESSFULLY')
        ]);
    }

    /**
     * Render Class Language Form
     */
    public function langForm()
    {
        $classId = FatApp::getPostedData('classId', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);
        if (empty($classId) || empty($langId)) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $groupClass = new GroupClass($classId, $this->siteUserId, $this->siteUserType);
        $classData = $groupClass->getClassToSave($langId);
        if (empty($classData)) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST'));
        }
        $classData['gclang_grpcls_id'] = $classId;
        $classData['gclang_lang_id'] = $langId;
        $form = $this->getLangForm($langId);
        $form->fill($classData);
        $this->set('frm', $form);
        $this->set('langId', $langId);
        $this->set('classId', $classId);
        $this->set('languages', Language::getAllNames(false));
        $this->_template->render(false, false);
    }

    /**
     * Setup Class Languages
     */
    public function setupLang()
    {
        $form = $this->getLangForm();
        if (!$post = $form->getFormDataFromArray(FatApp::getPostedData())) {
            FatUtility::dieJsonError(current($form->getValidationErrors()));
        }
        $groupClass = new GroupClass($post['gclang_grpcls_id'], $this->siteUserId, $this->siteUserType);
        if (!$groupClass->saveLangData($post)) {
            FatUtility::dieJsonError($groupClass->getError());
        }
        FatUtility::dieJsonSuccess(Label::getLabel('LBL_ACTION_PERFORMED_SUCCESSFULLY'));
    }

    /**
     * Get Add Class Form
     * 
     * @param bool $setUnique
     * @return Form
     */
    private function getAddForm(bool $setUnique = false): Form
    {
        $userTeachLangs = new UserTeachLanguage($this->siteUserId);
        $srch = $userTeachLangs->getSrchObject($this->siteLangId);
        $srch->doNotCalculateRecords();
        $srch->addMultiplefields(['tlang_id', 'IFNULL(tlang_name, tlang_identifier) as tlang_name']);
        $teachLangData = FatApp::getDb()->fetchAllAssoc($srch->getResultSet());
        $form = new Form('classesForm');
        $fld = $form->addHiddenField('', 'grpcls_id');
        $fld->requirements()->setIntPositive(true);
        $fld = $form->addRequiredField(Label::getLabel('LBL_Title'), 'grpcls_title');
        $fld->requirements()->setLength(10, 100);
        $fld = $form->addTextBox(Label::getLabel('LBL_CLASS_SLUG'), 'grpcls_slug');
        $fld->requirements()->setRequired();
        $fld->requirements()->setRequired();
        $fld->requirements()->setLength(10, 100);
        if ($setUnique) {
            $fld->setUnique(GroupClass::DB_TBL, 'grpcls_slug', 'grpcls_id', 'grpcls_id', 'grpcls_id');
        }
        $form->addFileUpload(Label::getLabel('LBL_CLASS_BANNER'), 'grpcls_banner');
        $fld = $form->addTextArea(Label::getLabel('LBL_DESCRIPTION'), 'grpcls_description');
        $fld->requirements()->setRequired(true);
        $fld->requirements()->setLength(10, 1000);
        $fld = $form->addIntegerField(Label::getLabel('LBL_MAX_LEARNERS'), 'grpcls_total_seats', '', ['id' => 'grpcls_total_seats']);
        $fld->requirements()->setRequired(true);
        $fld->requirements()->setRange(1, FatApp::getConfig('CONF_GROUP_CLASS_MAX_LEARNERS', FatUtility::VAR_INT, 9999));
        $form->addSelectBox(Label::getLabel('LBL_LANGUAGE'), 'grpcls_tlang_id', $teachLangData, '', [], Label::getLabel('LBL_SELECT'))->requirements()->setRequired(true);
        $currencyCode = MyUtility::getSystemCurrency()['currency_code'];
        $fld = $form->addFloatField(str_replace('{currency}', $currencyCode, Label::getLabel('LBL_ENTRY_FEE_[{currency}]')), 'grpcls_entry_fee', '', ['id' => 'grpcls_entry_fee']);
        $fld->requirements()->setPositive(true);
        $fld->requirements()->setRange(1, 9999);
        $form->addRequiredField(Label::getLabel('LBL_START_TIME'), 'grpcls_start_datetime', '', ['id' => 'grpcls_start_datetime', 'autocomplete' => 'off', 'readonly' => 'readonly']);
        $form->addSelectBox(Label::getLabel('LBL_DURATION'), 'grpcls_duration', AppConstant::fromatClassSlots(), '', [], '')->requirements()->setRequired(true);
        $form->addSubmitButton('', 'btn_next', Label::getLabel('LBL_SAVE_&_NEXT'));
        return $form;
    }

    /**
     * Get Language Form
     * 
     * @param int $langId
     * @return Form
     */
    private function getLangForm(int $langId = 0): Form
    {
        $frm = new Form('classLangForm');
        $fld = $frm->addHiddenField('', 'gclang_grpcls_id');
        $fld->requirements()->setRequired();
        $fld->requirements()->setIntPositive(true);
        $fld = $frm->addHiddenField('', 'gclang_lang_id');
        $fld->requirements()->setRequired();
        $fld->requirements()->setIntPositive(true);
        $fld = $frm->addRequiredField(Label::getLabel('LBL_TITLE', $langId), 'grpcls_title');
        $fld->requirements()->setLength(10, 100);
        $fld = $frm->addTextArea(Label::getLabel('LBL_DESCRIPTION', $langId), 'grpcls_description');
        $fld->requirements()->setRequired(true);
        $fld->requirements()->setLength(10, 1000);
        $frm->addSubmitButton('', 'btn_submit', Label::getLabel('LBL_SAVE_&_NEXT', $langId));
        return $frm;
    }

    /**
     * Check Class Status
     * 
     * @param int $classId
     */
    public function checkClassStatus($classId = 0)
    {
        $fields = ['ordcls_status', 'grpcls_status', 'grpcls_end_datetime', 'grpcls_teacher_starttime', 'ordcls_starttime'];
        $srch = new ClassSearch($this->siteLangId, $this->siteUserId, $this->siteUserType);
        $srch->addCondition('ordcls_id', '=', $classId);
        $srch->applyPrimaryConditions();
        $srch->addMultipleFields($fields);
        $srch->setPageSize(1);
        $srch->doNotCalculateRecords();
        $class = FatApp::getDb()->fetch($srch->getResultSet());
        if (empty($class)) {
            FatUtility::dieJsonError(Label::getLabel('LBL_INVALID_REQUEST_PLEASE_REFRESH_PAGE'));
        }
        $status = (User::TEACHER == $this->siteUserType) ? $class['grpcls_status'] : $class['ordcls_status'];
        if (User::TEACHER == $this->siteUserType && GroupClass::SCHEDULED == $class['grpcls_status']) {
            if (empty($class['grpcls_teacher_starttime']) && strtotime($class['grpcls_end_datetime']) > time()) {
                FatUtility::dieJsonSuccess(['classStatus' => $status, 'msg' => Label::getLabel('LBL_PLEASE_JOIN_CLASS_AND_START_CLASS')]);
            } elseif (!empty($class['grpcls_teacher_starttime']) && strtotime($class['grpcls_end_datetime']) < time()) {
                FatUtility::dieJsonError(['classStatus' => $status, 'msg' => Label::getLabel('LBL_TIME_IS_OVER_PLEASE_END_THE_CLASS')]);
            }
        }
        if (
                User::LEARNER == $this->siteUserType && !empty($class['grpcls_teacher_starttime']) &&
                GroupClass::SCHEDULED == $class['grpcls_status'] && OrderClass::SCHEDULED == $class['ordcls_status']
        ) {
            if (empty($class['ordcls_starttime']) && strtotime($class['grpcls_end_datetime']) > time()) {
                FatUtility::dieJsonSuccess(['classStatus' => $status, 'msg' => Label::getLabel('LBL_TEACHER_HAS_JOINED_PLEASE_JOIN_CLASS')]);
            } elseif (!empty($class['ordcls_starttime']) && strtotime($class['grpcls_end_datetime']) < time())
                FatUtility::dieJsonError(['classStatus' => $status, 'msg' => Label::getLabel('LBL_TIME_IS_OVER_CLASS_WILL_BE_ENDED_SOON')]);
        }
        FatUtility::dieJsonSuccess(['msg' => '', 'classStatus' => $status]);
    }

    /**
     * Get Upcoming Class
     * 
     * @return array
     */
    private function getUpcomingClass()
    {
        $srch = new ClassSearch($this->siteLangId, $this->siteUserId, $this->siteUserType);
        $srch->addCondition('grpcls_start_datetime', '=', MyDate::formatDate(date('Y-m-d H:i:s')));
        $srch->addCondition('ordcls_status', '=', OrderClass::SCHEDULED);
        $srch->addCondition('grpcls_booked_seats', '>', 0);
        $srch->applyPrimaryConditions();
        $srch->addSearchListingFields();
        $srch->addOrder('grpcls_start_datetime');
        $srch->setPageSize(1);
        $classe = $srch->fetchAndFormat(true);
        if (!empty($classe)) {
            $classe = current($classe);
        }
        return $classe;
    }

}
