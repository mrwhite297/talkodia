Restoration Setup Instructions
Step 1: To setup restore database, ensure that below list of files exists:
    - {root}/application/controllers/RestoreSystemController.php
    - {root}/application/models/Restore.php
    - {root}/restore/view/header-bar.php
Step 2: Create two databases in order to keep one connected with the application and restore other one as a background process. For eg, yocoach_db_1 and yocoach_db_2
Step 3: In /application/models/Restore.php file update the following settings:
    - replace the database names for constants: DATABASE_FIRST & DATABASE_SECOND.
    - Update the constant RESTORE_TIME_INTERVAL_HOURS value to set the number of hours after which the restoration process will be executed.
Step 4: Setup database and files for restoration:
    - Create the "database" folder in the {root}/restore/ folder.
    - Place the database file to be restored in {root}/restore/database/ folder and rename it as "yocoach-restore-db.sql".
    - Place "user-uploads" folder in {root}/restore/
    - Set 0777 permissions for both above files and folders.
    - Import your restoration db file in both databases(yocoach_db_1 & yocoach_db_2)
    - Set CONF_RESTORED_SUCCESSFULLY=0 in tbl_configurations for second table which is not connected.
Step 5: Edit {root}/public/settings.php
    - Update database name in define('CONF_DB_NAME', 'yocoach_db_1');
Step 6: Add the following query into your yocoach-restore-db.sql file and also execute in the currently connected db.
    - INSERT INTO `tbl_cron_schedules` (`cron_name`, `cron_command`, `cron_duration`, `cron_active`) VALUES ('Database Restoration', 'restoreDb', 7200, 1);
    - Set conf_auto_restore_on=1 in tbl_configurations table in yocoach-restore-db.sql file and in both imported databases.
Step 7: Set the restoration setup date & time in RESTORATION_SETUP_DATE variable in Restore.php file. This is required to update the sessions time.
Step 8: Execute restoration cron manually for fist time after setup the restoration. Hit the below
        URL : {domain}/cron/index/{database-restoration-cron-id}