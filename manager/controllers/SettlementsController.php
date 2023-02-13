<?php

/**
 * Settlements Report Controller is used for Settlements Report handling
 *  
 * @package YoCoach
 * @author Fatbit Team
 */
class SettlementsController extends AdminBaseController
{

    /**
     * Initialize Sales Report
     * 
     * @param string $action
     */
    public function __construct(string $action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewSettlementsReport();
    }

    /**
     * Get Search Form
     */
    public function index()
    {
        $datetime = FatApp::getConfig('CONF_SALES_REPORT_GENERATED_DATE');
        $regendatedtime = str_replace('{datetime}', $datetime . ' (UTC)', Label::getLabel('LBL_REPORT_GENERATED_ON_{datetime}'));
        $this->set('regendatedtime', $regendatedtime);
        $this->set('frm', $this->getSearchForm());
        $this->_template->render();
    }

    /**
     * Search & List Settlements Report
     */
    public function search()
    {
        $frm = $this->getSearchForm();
        if (!$post = $frm->getFormDataFromArray(FatApp::getPostedData())) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }
        $srch = new SearchBase('tbl_sales_stats', 'slstat');
        if (!empty($post['slstat_date_from'])) {
            $srch->addCondition('slstat_date', '>=', $post['slstat_date_from']);
        }
        if (!empty($post['slstat_date_to'])) {
            $srch->addCondition('slstat_date', '<=', $post['slstat_date_to']);
        }
        $srch->addMultipleFields([
            'slstat_date',
            '(IFNULL(slstat_les_refund,0) + IFNULL(slstat_cls_refund,0)) AS slstat_refund',
            '(IFNULL(slstat_les_earnings,0) + IFNULL(slstat_cls_earnings,0)) AS slstat_earnings',
            '(IFNULL(slstat_les_teacher_paid,0) + IFNULL(slstat_cls_teacher_paid,0)) AS slstat_teacher_paid',
        ]);
        $srch->setPageNumber($post['pageno']);
        $srch->setPageSize($post['pagesize']);
        $srch->addOrder('slstat_date', 'DESC');
        $srch->addGroupBy('slstat_date');
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
        $this->set('postedData', $post);
        $this->set("records", $records);
        $this->set('page', $post['pageno']);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->_template->render(false, false);
    }

    /**
     * Get Search Form
     * 
     * @return Form
     */
    private function getSearchForm(): Form
    {
        $frm = new Form('frmSaleReport');
        $frm->addDateField(Label::getLabel('LBL_DATE_FROM'), 'slstat_date_from', '', ['readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender']);
        $frm->addDateField(Label::getLabel('LBL_DATE_TO'), 'slstat_date_to', '', ['readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender']);
        $frm->addHiddenField(Label::getLabel('LBL_PAGESIZE'), 'pagesize', FatApp::getConfig('CONF_ADMIN_PAGESIZE'))->requirements()->setInt();
        $frm->addHiddenField(Label::getLabel('LBL_PAGENO'), 'pageno', 1)->requirements()->setInt();
        $btnSubmit = $frm->addSubmitButton('', 'btn_submit', Label::getLabel('LBL_SEARCH'));
        $btnSubmit->attachField($frm->addResetButton('', 'btn_clear', Label::getLabel('LBL_CLEAR')));
        return $frm;
    }

}
