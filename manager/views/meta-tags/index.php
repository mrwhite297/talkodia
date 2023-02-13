<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class='page'>
    <div class='fixed_container'>
        <div class="row">
            <div class="space">
                <div class="page__title">
                    <div class="row">
                        <div class="col--first">
                            <span class="page__icon"><i class="ion-android-star"></i></span>
                            <h5><?php echo Label::getLabel('LBL_Meta_Tags_Setup'); ?> </h5>
                            <?php $this->includeTemplate('_partial/header/header-breadcrumb.php'); ?>
                        </div>
                    </div>
                </div>
                <div class="tabs_nav_container vertical">
                    <ul class="tabs_nav">
                        <?php
                        $itr = 0;
                        foreach ($tabsArr as $metaType => $metaDetail) {
                            ?>
                            <li><a class="<?php echo ($activeTab == $metaType) ? 'active' : '' ?>" href="javascript:void(0)" onClick="listMetaTags(<?php echo "'$metaType'"; ?>)"><?php echo $metaDetail['name']; ?></a></li>
                            <?php
                            $itr++;
                        }
                        ?>
                    </ul>
                    <div class="tabs_panel_wrap">
                        <div class="tabs_nav_container" id="frmBlock"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>