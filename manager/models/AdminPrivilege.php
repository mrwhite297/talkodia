<?php

/**
 * Admin Class is used to handle Admin Privilege
 *  
 * @package YoCoach
 * @author Fatbit Team
 */
class AdminPrivilege
{

    const DB_TBL = 'tbl_admin_permissions';
    const SECTION_ADMIN_DASHBOARD = 1;
    const SECTION_USERS = 2;
    const SECTION_TEACHER_REQUEST = 3;
    const SECTION_WITHDRAW_REQUESTS = 4;
    const SECTION_TEACHER_REVIEWS = 5;
    const SECTION_GROUP_CLASSES = 6;
    const SECTION_MANAGE_ORDERS = 7;
    const SECTION_LESSONS_ORDERS = 8;
    const SECTION_SUBSCRI_ORDERS = 9;
    const SECTION_CLASSES_ORDERS = 10;
    const SECTION_PACKAGS_ORDERS = 11;
    const SECTION_COURSES_ORDERS = 12;
    const SECTION_WALLETS_ORDERS = 13;
    const SECTION_GIFTCARD_ORDERS = 14;
    const SECTION_ISSUES_REPORTED = 15;
    const SECTION_TEACHER_PREFFERENCES = 16;
    const SECTION_SPEAK_LANGUAGES = 17;
    const SECTION_TEACH_LANGUAGES = 18;
    const SECTION_ISSUE_REPORT_OPTIONS = 19;
    const SECTION_CONTENT_PAGES = 20;
    const SECTION_CONTENT_BLOCKS = 21;
    const SECTION_NAVIGATION_MANAGEMENT = 22;
    const SECTION_COUNTRIES = 24;
    const SECTION_SOCIALPLATFORM = 25;
    const SECTION_PRICE_SLAB = 26;
    const SECTION_BIBLE_CONTENT = 27;
    const SECTION_SLIDES = 28;
    const SECTION_TESTIMONIAL = 30;
    const SECTION_LANGUAGE_LABELS = 31;
    const SECTION_FAQ = 32;
    const SECTION_FAQ_CATEGORY = 33;
    const SECTION_BLOG_POSTS = 34;
    const SECTION_BLOG_POST_CATEGORIES = 35;
    const SECTION_BLOG_CONTRIBUTIONS = 36;
    const SECTION_BLOG_COMMENTS = 37;
    const SECTION_GENERAL_SETTINGS = 38;
    const SECTION_PWA_SETTINGS = 39;
    const SECTION_MEETING_TOOL = 40;
    const SECTION_PAYMENT_METHODS = 41;
    const SECTION_COMMISSION = 42;
    const SECTION_CURRENCY_MANAGEMENT = 43;
    const SECTION_EMAIL_TEMPLATES = 44;
    const SECTION_META_TAGS = 45;
    const SECTION_URL_REWRITE = 46;
    const SECTION_ROBOTS = 47;
    const SECTION_LESSON_TOP_LANGUAGES = 48;
    const SECTION_CLASS_TOP_LANGUAGES = 49;
    const SECTION_TEACHER_PERFORMANCE = 50;
    const SECTION_LESSON_STATS = 52;
    const SECTION_SALES_REPORT = 53;
    const SECTION_SITE_MAPS = 54;
    const SECTION_DISCOUNT_COUPONS = 55;
    const SECTION_ADMIN_USERS = 56;
    const SECTION_ADMIN_PERMISSIONS = 57;
    const SECTION_GDPR_REQUESTS = 59;
    const SECTION_LANGUAGE = 60;
    const SECTION_THEME_MANAGEMENT = 61;
    const SECTION_PACKAGE_CLASSES = 62;
    const SECTION_SETTLEMENTS_REPORT = 63;
    const PRIVILEGE_NONE = 0;
    const PRIVILEGE_READ = 1;
    const PRIVILEGE_WRITE = 2;

    private static $instance = null;
    private $loadedPermissions = [];

    /**
     * Get Instance
     * 
     * @return type
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Is Admin Super Admin
     * 
     * @param int $adminId
     * @return bool
     */
    public static function isAdminSuperAdmin(int $adminId): bool
    {
        return (1 == $adminId);
    }

    /**
     * Get Permissions
     * 
     * @return array
     */
    public static function getPermissions(): array
    {
        $langId = MyUtility::getSiteLangId();
        $arr = [
            static::PRIVILEGE_NONE => Label::getLabel('MSG_None', $langId),
            static::PRIVILEGE_READ => Label::getLabel('MSG_Read_Only', $langId),
            static::PRIVILEGE_WRITE => Label::getLabel('MSG_Read_and_Write', $langId)
        ];
        return $arr;
    }

    /**
     * Get Permission Modules
     * 
     * @return array
     */
    public static function getPermissionModules(): array
    {
        $langId = MyUtility::getSiteLangId();
        $arr = [
            static::SECTION_ADMIN_DASHBOARD => Label::getLabel('MSG_ADMIN_DASHBOARD', $langId),
            static::SECTION_USERS => Label::getLabel('MSG_MANAGE_USERS', $langId),
            static::SECTION_TEACHER_REQUEST => Label::getLabel('MSG_TEACHER_REQUESTS', $langId),
            static::SECTION_WITHDRAW_REQUESTS => Label::getLabel('MSG_WITHDRAW_REQUESTS', $langId),
            static::SECTION_TEACHER_REVIEWS => Label::getLabel('MSG_TEACHER_REVIEWS', $langId),
            static::SECTION_GDPR_REQUESTS => Label::getLabel('MSG_GDPR_REQUESTS', $langId),
            static::SECTION_ADMIN_USERS => Label::getLabel('MSG_ADMIN_USERS', $langId),
            static::SECTION_ADMIN_PERMISSIONS => Label::getLabel('MSG_ADMIN_PERMISSIONS', $langId),
            static::SECTION_GROUP_CLASSES => Label::getLabel('MSG_GROUP_CLASSES', $langId),
            static::SECTION_PACKAGE_CLASSES => Label::getLabel('MSG_PACKAGE_CLASSES', $langId),
            static::SECTION_MANAGE_ORDERS => Label::getLabel('MSG_MANAGE_ORDERS', $langId),
            static::SECTION_LESSONS_ORDERS => Label::getLabel('MSG_LESSONS_ORDERS', $langId),
            static::SECTION_SUBSCRI_ORDERS => Label::getLabel('MSG_SUBSCRIPTION_ORDERS', $langId),
            static::SECTION_CLASSES_ORDERS => Label::getLabel('MSG_CLASSES_ORDERS', $langId),
            static::SECTION_PACKAGS_ORDERS => Label::getLabel('MSG_PACKAGES_ORDERS', $langId),
            static::SECTION_GIFTCARD_ORDERS => Label::getLabel('MSG_GIFTCARD_ORDERS', $langId),
            static::SECTION_WALLETS_ORDERS => Label::getLabel('MSG_WALLET_ORDERS', $langId),
            static::SECTION_ISSUES_REPORTED => Label::getLabel('MSG_REPORTED_ISSUES', $langId),
            static::SECTION_TEACHER_PREFFERENCES => Label::getLabel('MSG_TEACHER_PREFERENCES', $langId),
            static::SECTION_SPEAK_LANGUAGES => Label::getLabel('MSG_SPOKEN_LANGUAGES', $langId),
            static::SECTION_TEACH_LANGUAGES => Label::getLabel('MSG_TEACHING_LANGUAGES', $langId),
            static::SECTION_ISSUE_REPORT_OPTIONS => Label::getLabel('MSG_ISSUE_REPORT_OPTIONS', $langId),
            static::SECTION_SLIDES => Label::getLabel('MSG_HOMEPAGE_SLIDES', $langId),
            static::SECTION_CONTENT_PAGES => Label::getLabel('MSG_CONTENT_PAGES', $langId),
            static::SECTION_CONTENT_BLOCKS => Label::getLabel('MSG_CONTENT_BLOCKS', $langId),
            static::SECTION_NAVIGATION_MANAGEMENT => Label::getLabel('MSG_NAVIGATION_MANAGEMENT', $langId),
            static::SECTION_COUNTRIES => Label::getLabel('MSG_COUNTRIES', $langId),
            static::SECTION_BIBLE_CONTENT => Label::getLabel('MSG_BIBLE_CONTENT', $langId),
            static::SECTION_TESTIMONIAL => Label::getLabel('MSG_TESTIMONIAL', $langId),
            static::SECTION_LANGUAGE_LABELS => Label::getLabel('MSG_LANGUAGE_LABELS', $langId),
            static::SECTION_FAQ_CATEGORY => Label::getLabel('MSG_MANAGE_FAQ_CATEGORIES', $langId),
            static::SECTION_FAQ => Label::getLabel('MSG_MANAGE_FAQS', $langId),
            static::SECTION_EMAIL_TEMPLATES => Label::getLabel('MSG_EMAIL_TEMPLATES', $langId),
            static::SECTION_GENERAL_SETTINGS => Label::getLabel('MSG_GENERAL_SETTINGS', $langId),
            static::SECTION_PWA_SETTINGS => Label::getLabel('MSG_PWA_SETTINGS', $langId),
            static::SECTION_MEETING_TOOL => Label::getLabel('MSG_MEETING_TOOL', $langId),
            static::SECTION_PAYMENT_METHODS => Label::getLabel('MSG_PAYMENT_METHODS', $langId),
            static::SECTION_PRICE_SLAB => Label::getLabel('MSG_PRICE_SLAB', $langId),
            static::SECTION_SOCIALPLATFORM => Label::getLabel('MSG_SOCIAL_PLATFORM', $langId),
            static::SECTION_DISCOUNT_COUPONS => Label::getLabel('MSG_DISCOUNT_COUPONS', $langId),
            static::SECTION_COMMISSION => Label::getLabel('MSG_COMMISSION', $langId),
            static::SECTION_CURRENCY_MANAGEMENT => Label::getLabel('MSG_CURRENCY_MANAGEMENT', $langId),
            static::SECTION_THEME_MANAGEMENT => Label::getLabel('Msg_THEME_MANAGEMENT', $langId),
            static::SECTION_BLOG_POST_CATEGORIES => Label::getLabel('MSG_BLOG_CATEGORIES', $langId),
            static::SECTION_BLOG_POSTS => Label::getLabel('MSG_BLOG_POSTS', $langId),
            static::SECTION_BLOG_COMMENTS => Label::getLabel('MSG_BLOG_COMMENTS', $langId),
            static::SECTION_BLOG_CONTRIBUTIONS => Label::getLabel('MSG_BLOG_CONTRIBUTIONS', $langId),
            static::SECTION_META_TAGS => Label::getLabel('MSG_META_TAGS', $langId),
            static::SECTION_URL_REWRITE => Label::getLabel('MSG_URL_REWRITING', $langId),
            static::SECTION_ROBOTS => Label::getLabel('MSG_ROBOTS_TXT', $langId),
            static::SECTION_SITE_MAPS => Label::getLabel('MSG_SITE_MAPS', $langId),
            static::SECTION_LESSON_TOP_LANGUAGES => Label::getLabel('MSG_LESSON_TOP_LANGUAGES', $langId),
            static::SECTION_CLASS_TOP_LANGUAGES => Label::getLabel('MSG_CLASS_TOP_LANGUAGES', $langId),
            static::SECTION_TEACHER_PERFORMANCE => Label::getLabel('MSG_TEACHER_PERFORMANCE', $langId),
            static::SECTION_LESSON_STATS => Label::getLabel('MSG_LESSON_STATS', $langId),
            static::SECTION_SALES_REPORT => Label::getLabel('MSG_SALE_REPORT', $langId),
            static::SECTION_SETTLEMENTS_REPORT => Label::getLabel('MSG_SETTLEMENTS_REPORT', $langId),
        ];
        return $arr;
    }

    /**
     * Get Admin Permission Level
     * 
     * @param int $adminId
     * @param int $sectionId
     * @return int
     */
    private function getLevel(int $adminId, int $sectionId): int
    {
        if ($this->isAdminSuperAdmin($adminId)) {
            return static::PRIVILEGE_WRITE;
        }
        if (isset($this->loadedPermissions[$sectionId])) {
            return $this->loadedPermissions[$sectionId];
        }
        $srch = new SearchBase(static::DB_TBL);
        $srch->addCondition('admperm_admin_id', '=', $adminId);
        $srch->addCondition('admperm_section_id', '=', $sectionId);
        $srch->addFld('admperm_value');
        $record = FatApp::getDb()->fetch($srch->getResultSet());
        return !empty($record['admperm_value']) ? $record['admperm_value'] : static::PRIVILEGE_NONE;
    }

    /**
     * Check Permissions
     * 
     * @param int $secId
     * @param int $level
     * @param bool $returnResult
     * @return mix boolean|string
     */
    private function checkPermission(int $secId, int $level, bool $returnResult = false)
    {
        if (!in_array($level, [static::PRIVILEGE_READ, static::PRIVILEGE_WRITE])) {
            trigger_error(Label::getLabel('MSG_INVALID_PERMISSION_LEVEL_CHECKED') . ' ' . $level, E_USER_ERROR);
        }
        $permissionLevel = $this->getLevel(AdminAuth::getLoggedAdminId(), $secId);
        $this->loadedPermissions[$secId] = $permissionLevel;
        if ($level > $permissionLevel) {
            if ($returnResult) {
                return false;
            }
            FatUtility::dieWithError(Label::getLabel('MSG_UNAUTHORIZED_ACCESS!'));
        }
        return true;
    }

    /**
     * Can View Admin Dashboard
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewAdminDashboard(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_ADMIN_DASHBOARD, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can View Users
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewUsers(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_USERS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Users
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditUsers(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_USERS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Teacher Reviews
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewTeacherReviews(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_TEACHER_REVIEWS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Teacher Reviews
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditTeacherReviews(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_TEACHER_REVIEWS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Teacher Requests
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewTeacherRequests(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_TEACHER_REQUEST, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Teacher Requests
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditTeacherRequests(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_TEACHER_REQUEST, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Withdraw Requests
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewWithdrawRequests(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_WITHDRAW_REQUESTS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Withdraw Requests
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditWithdrawRequests(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_WITHDRAW_REQUESTS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Group Classes
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewGroupClasses(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_GROUP_CLASSES, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Group Classes
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditGroupClasses(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_GROUP_CLASSES, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Orders
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewOrders(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_MANAGE_ORDERS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Orders
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditOrders(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_MANAGE_ORDERS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Lessons Orders
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewLessonsOrders(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_LESSONS_ORDERS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Lessons Orders
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditLessonsOrders(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_LESSONS_ORDERS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Subscription Orders
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewSubscriptionOrders(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_SUBSCRI_ORDERS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Subscription Orders
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditSubscriptionOrders(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_SUBSCRI_ORDERS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Classes Orders
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewClassesOrders(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_CLASSES_ORDERS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Classes Orders
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditClassesOrders(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_CLASSES_ORDERS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Packages Orders
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewPackagesOrders(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_PACKAGS_ORDERS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Packages Orders
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditPackagesOrders(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_PACKAGS_ORDERS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Courses Orders
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewCoursesOrders(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_COURSES_ORDERS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Courses Orders
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditCoursesOrders(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_COURSES_ORDERS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Wallet Orders
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewWalletOrders(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_WALLETS_ORDERS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Wallet Orders
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditWalletOrders(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_WALLETS_ORDERS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Giftcard Orders
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewGiftcardOrders(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_GIFTCARD_ORDERS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Giftcard Orders
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditGiftcardOrders(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_GIFTCARD_ORDERS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Issues Reported
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewIssuesReported(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_ISSUES_REPORTED, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Issues Reported
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditIssuesReported(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_ISSUES_REPORTED, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Preferences
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewPreferences(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_TEACHER_PREFFERENCES, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Preferences
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditPreferences(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_TEACHER_PREFFERENCES, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Speak Language
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewSpeakLanguage(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_SPEAK_LANGUAGES, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Speak Language
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditSpeakLanguage(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_SPEAK_LANGUAGES, static::PRIVILEGE_WRITE, $returnResult);
    }

    /* code added on 30-07-2019 TEACHING LANGUAGES SEPERATE OPTION */

    /**
     * Can View Teach Language
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewTeachLanguage(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_TEACH_LANGUAGES, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Teach Language
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditTeachLanguage(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_TEACH_LANGUAGES, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Issue Report Options
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewIssueReportOptions(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_ISSUE_REPORT_OPTIONS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Issue Report Options
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditIssueReportOptions(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_ISSUE_REPORT_OPTIONS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Content Pages
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewContentPages(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_CONTENT_PAGES, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Content Pages
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditContentPages(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_CONTENT_PAGES, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Content Blocks
     * 
     * @param type $returnResult
     * @return type
     */
    public function canViewContentBlocks(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_CONTENT_BLOCKS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Content Blocks
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditContentBlocks(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_CONTENT_BLOCKS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Navigation Management
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewNavigationManagement(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_NAVIGATION_MANAGEMENT, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Navigation Management
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditNavigationManagement(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_NAVIGATION_MANAGEMENT, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Countries
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewCountries(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_COUNTRIES, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Countries
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditCountries(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_COUNTRIES, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Social Platforms
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewSocialPlatforms(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_SOCIALPLATFORM, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Social Platforms
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditSocialPlatforms(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_SOCIALPLATFORM, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Price Slab
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewPriceSlab(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_PRICE_SLAB, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Price Slab
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditPriceSlab(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_PRICE_SLAB, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Bible Content
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewBibleContent(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_BIBLE_CONTENT, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Bible Content
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditBibleContent(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_BIBLE_CONTENT, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Slides
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewSlides(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_SLIDES, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Slides
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditSlides(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_SLIDES, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Testimonial
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewTestimonial(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_TESTIMONIAL, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Testimonial
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditTestimonial(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_TESTIMONIAL, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Language Label
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewLanguageLabel(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_LANGUAGE_LABELS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Language Label
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditLanguageLabel(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_LANGUAGE_LABELS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View FAQs
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewFaq(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_FAQ, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit FAQs
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditFaq(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_FAQ, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Faq Category
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewFaqCategory(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_FAQ_CATEGORY, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Faq Category
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditFaqCategory(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_FAQ_CATEGORY, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Blog Posts
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewBlogPosts(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_BLOG_POSTS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Blog Posts
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditBlogPosts(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_BLOG_POSTS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Blog Post Categories
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewBlogPostCategories(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_BLOG_POST_CATEGORIES, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Blog Post Categories
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditBlogPostCategories(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_BLOG_POST_CATEGORIES, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Blog Contributions
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewBlogContributions(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_BLOG_CONTRIBUTIONS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Blog Contributions
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditBlogContributions(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_BLOG_CONTRIBUTIONS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Blog Comments
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewBlogComments(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_BLOG_COMMENTS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Blog Comments
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditBlogComments(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_BLOG_COMMENTS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View General Settings
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewGeneralSettings(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_GENERAL_SETTINGS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit General Settings
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditGeneralSettings(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_GENERAL_SETTINGS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View PWA Settings
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewPwaSettings(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_PWA_SETTINGS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Pwa Settings
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditPwaSettings(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_PWA_SETTINGS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Meeting Tool
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewMeetingTool(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_MEETING_TOOL, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Meeting Tool
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditMeetingTool(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_MEETING_TOOL, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Payment Methods
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewPaymentMethods(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_PAYMENT_METHODS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Payment Methods
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditPaymentMethods(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_PAYMENT_METHODS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Commission Settings
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewCommissionSettings(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_COMMISSION, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Commission Settings
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditCommissionSettings(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_COMMISSION, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Currency Management
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewCurrencyManagement(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_CURRENCY_MANAGEMENT, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Currency Management
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditCurrencyManagement(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_CURRENCY_MANAGEMENT, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Email Templates
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewEmailTemplates(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_EMAIL_TEMPLATES, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Email Templates
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditEmailTemplates(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_EMAIL_TEMPLATES, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Meta Tags
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewMetaTags(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_META_TAGS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Meta Tags
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditMetaTags(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_META_TAGS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Url Rewrites
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewSeoUrl(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_URL_REWRITE, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Url Rewrites
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditSeoUrl(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_URL_REWRITE, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Robots Section
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewRobotsSection(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_ROBOTS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Robots Section
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditRobotsSection(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_ROBOTS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Lesson Languages
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewLessonLanguages(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_LESSON_TOP_LANGUAGES, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can View Class Languages
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewClassLanguages(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_CLASS_TOP_LANGUAGES, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can View Teacher Performance
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewTeacherPerformance(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_TEACHER_PERFORMANCE, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can View Lesson Stats Report
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewLessonStatsReport(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_LESSON_STATS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can View Sales Report
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewSalesReport(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_SALES_REPORT, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can View Settlements Report
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewSettlementsReport(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_SETTLEMENTS_REPORT, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can View Site Map
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewSiteMap(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_SITE_MAPS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Site Map
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditSiteMap(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_SITE_MAPS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Discount Coupons
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewDiscountCoupons(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_DISCOUNT_COUPONS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Discount Coupons
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditDiscountCoupons(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_DISCOUNT_COUPONS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Admin Users
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewAdminUsers(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_ADMIN_USERS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Admin Users
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditAdminUsers(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_ADMIN_USERS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Admin Permissions
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewAdminPermissions(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_ADMIN_PERMISSIONS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Admin Permissions
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditAdminPermissions(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_ADMIN_PERMISSIONS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Gdpr Requests
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewGdprRequests(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_GDPR_REQUESTS, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Gdpr Requests
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditGdprRequests(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_GDPR_REQUESTS, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Language
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewLanguage(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_LANGUAGE, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Language
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditLanguage(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_LANGUAGE, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Themes
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewThemeManagement(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_THEME_MANAGEMENT, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Themes
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditThemeManagement(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_THEME_MANAGEMENT, static::PRIVILEGE_WRITE, $returnResult);
    }

    /**
     * Can View Themes
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canViewPackageClasses(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_PACKAGE_CLASSES, static::PRIVILEGE_READ, $returnResult);
    }

    /**
     * Can Edit Themes
     * 
     * @param bool $returnResult
     * @return type
     */
    public function canEditPackageClasses(bool $returnResult = false)
    {
        return $this->checkPermission(static::SECTION_PACKAGE_CLASSES, static::PRIVILEGE_WRITE, $returnResult);
    }

}
