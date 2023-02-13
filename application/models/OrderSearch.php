<?php

/**
 * This class is used Search Orders
 * 
 * @package YoCoach
 * @author Fatbit Team
 */
class OrderSearch extends YocoachSearch
{

    /**
     * Initialize Order Search
     * 
     * @param int $langId
     * @param int $userId
     * @param int $userType
     */
    public function __construct(int $langId, int $userId, int $userType)
    {
        $this->table = 'tbl_orders';
        $this->alias = 'orders';
        parent::__construct($langId, $userId, $userType);
        $this->joinTable(User::DB_TBL, 'LEFT JOIN', 'learner.user_id = orders.order_user_id', 'learner');
        $this->joinTable(Order::DB_TBL_LESSON, 'LEFT JOIN', 'orders.order_type = ' . Order::TYPE_LESSON . ' AND orders.order_id = ordles.ordles_order_id', 'ordles');
        $this->joinTable(OrderClass::DB_TBL, 'LEFT JOIN', 'orders.order_type = ' . Order::TYPE_GCLASS . ' AND orders.order_id = ordcls.ordcls_order_id', 'ordcls');
        $this->joinTable(GroupClass::DB_TBL, 'LEFT JOIN', 'orders.order_type = ' . Order::TYPE_GCLASS . ' AND ordcls.ordcls_grpcls_id = grpcls.grpcls_id', 'grpcls');
    }

    /**
     * Apply Primary Conditions
     * 
     * @return void
     */
    public function applyPrimaryConditions(): void
    {
        if ($this->userType === User::LEARNER) {
            $this->addCondition('orders.order_user_id', '=', $this->userId);
            $this->addGroupBy('orders.order_id');
        } elseif ($this->userType === User::TEACHER) {
            $this->addGroupBy('orders.order_id');
            $cond = $this->addCondition('ordles.ordles_teacher_id', '=', $this->userId);
            $cond->attachCondition('grpcls.grpcls_teacher_id', '=', $this->userId);
            $this->addCondition('orders.order_type', 'IN', [Order::TYPE_LESSON, Order::TYPE_GCLASS]);
        } else {
            $this->addGroupBy('orders.order_id');
        }
    }

    /**
     * Apply Search Conditions
     * 
     * @param array $post
     * @return void
     */
    public function applySearchConditions(array $post): void
    {
        if (!empty($post['order_id'])) {
            $this->addCondition('orders.order_id', '=', FatUtility::int(str_replace('O', '', $post['order_id'])));
        }
        if (!empty($post['keyword'])) {
            $fullName = 'mysql_func_CONCAT(learner.user_first_name, " ", learner.user_last_name)';
            $cond = $this->addCondition($fullName, 'LIKE', '%' . trim($post['keyword']) . '%', 'AND', true);
            $orderId = FatUtility::int(str_replace('O', '', $post['keyword']));
            if (!empty($orderId)) {
                $cond->attachCondition('orders.order_id', '=', $orderId);
            }
        }
        if (!empty($post['order_type'])) {
            $this->addCondition('orders.order_type', '=', $post['order_type']);
        }
        if (!empty($post['order_user_id'])) {
            $this->addCondition('orders.order_user_id', '=', $post['order_user_id']);
        } elseif (!empty($post['order_user'])) {
            $fullName = 'mysql_func_CONCAT(learner.user_first_name, " ", learner.user_last_name)';
            $this->addCondition($fullName, 'LIKE', '%' . $post['order_user'] . '%', 'AND', true);
        }
        if (isset($post['order_payment_status']) && $post['order_payment_status'] !== '') {
            $this->addCondition('orders.order_payment_status', '=', $post['order_payment_status']);
        }
        if (isset($post['order_status']) && $post['order_status'] !== '') {
            $this->addCondition('orders.order_status', '=', $post['order_status']);
        }
        if (!empty($post['date_from'])) {
            $start = $post['date_from'] . ' 00:00:00';
            $this->addCondition('orders.order_addedon', '>=', MyDate::formatToSystemTimezone($start));
        }
        if (!empty($post['date_to'])) {
            $end = $post['date_to'] . ' 23:59:59';
            $this->addCondition('orders.order_addedon', '<=', MyDate::formatToSystemTimezone($end));
        }
    }

    /**
     * Fetch And Format
     * 
     * @return array
     */
    public function fetchAndFormat(): array
    {
        $rows = FatApp::getDb()->fetchAll($this->getResultSet());
        if (count($rows) == 0) {
            return [];
        }
        $pmethodIds = array_column($rows, 'order_pmethod_id');
        $pmethods = PaymentMethod::getPayins(true);
        $countryIds = array_column($rows, 'learner_country_id');
        $countries = Country::getNames($this->langId, $countryIds);
        foreach ($rows as $key => $row) {
            $row['order_pmethod'] = $pmethods[$row['order_pmethod_id']] ?? Label::getLabel('LBL_NA');
            $row['learner_country'] = $countries[$row['learner_country_id']] ?? Label::getLabel('LBL_NA');
            $rows[$key] = $row;
        }
        return $rows;
    }

    /**
     * Get Detail Fields
     * 
     * @return array
     */
    public static function getDetailFields(): array
    {
        return static::getListingFields() + [
            'learner.user_timezone' => 'user_timezone',
            'order_related_order_id' => 'order_related_order_id'
        ];
    }

    /**
     * Get Listing Fields
     * 
     * @return array
     */
    public static function getListingFields(): array
    {
        return [
            'orders.order_id' => 'order_id',
            'orders.order_net_amount' => 'order_net_amount',
            'orders.order_type' => 'order_type',
            'orders.order_status' => 'order_status',
            'orders.order_user_id' => 'order_user_id',
            'orders.order_item_count' => 'order_item_count',
            'orders.order_pmethod_id' => 'order_pmethod_id',
            'orders.order_discount_value' => 'order_discount_value',
            'orders.order_currency_code' => 'order_currency_code',
            'orders.order_currency_value' => 'order_currency_value',
            'orders.order_payment_status' => 'order_payment_status',
            'orders.order_total_amount' => 'order_total_amount',
            'orders.order_addedon' => 'order_addedon',
            'learner.user_email' => 'learner_email',
            'learner.user_first_name' => 'learner_first_name',
            'learner.user_last_name' => 'learner_last_name',
            'learner.user_country_id' => 'learner_country_id',
            'CONCAT(learner.user_first_name," ", learner.user_last_name)' => 'learner_full_name',
        ];
    }

    /**
     * Get Search Form
     * 
     * @return Form
     */
    public static function getSearchForm(): Form
    {
        $orderType = Order::getTypeArr();
        unset($orderType[Order::TYPE_COURSE]);
        $frm = new Form('orderSearchFrm');
        $frm->addTextBox(Label::getLabel('LBL_Keyword'), 'keyword', '', ['placeholder' => Label::getLabel('LBL_Search_By_Keyword')]);
        $frm->addSelectBox(Label::getLabel('LBL_Order_Type'), 'order_type', $orderType)->requirements()->setIntPositive();
        $frm->addDateField(Label::getLabel('LBL_Date_From'), 'date_from', '', ['readonly' => 'readonly']);
        $frm->addDateField(Label::getLabel('LBL_Date_To'), 'date_to', '', ['readonly' => 'readonly']);
        $frm->addHiddenField('', 'pagesize', AppConstant::PAGESIZE)->requirements()->setIntPositive();
        $frm->addHiddenField('', 'pageno', 1)->requirements()->setIntPositive();
        $frm->addSubmitButton('', 'btn_submit', Label::getLabel('LBL_Search'));
        $frm->addResetButton('', 'btn_reset', Label::getLabel('LBL_Clear'));
        return $frm;
    }

}
