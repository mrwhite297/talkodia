<?php

/**
 * This class is used to handle Course
 * 
 * @package YoCoach
 * @author Fatbit Team
 */
class Course extends MyAppModel
{

    const DB_TBL = 'tbl_order_course';
    const DB_TBL_PREFIX = 'ordcrs_';

    /* Course Status */
    const PUBLISHED = 1;

    /**
     * Initialize Course
     * 
     * @param int $id
     */
    public function __construct(int $id = 0)
    {
        parent::__construct(static::DB_TBL, 'ordcrs_id', $id);
    }

}
