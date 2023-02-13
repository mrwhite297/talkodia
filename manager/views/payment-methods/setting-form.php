<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'web_form form_horizontal');
$frm->setFormTagAttribute('onsubmit', 'settingSetup(this); return(false);');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;
$submitField = $frm->getField('btn_submit');
$submitField->htmlBeforeField = "<p>" . html_entity_decode($pmethod['pmethod_info']) . "<p><br>";
?>
<section class="section">
    <div class="sectionhead">
        <h4>
            <?php echo Label::getLabel('LBL_' . $pmethod['pmethod_code']); ?>
            <?php echo Label::getLabel('LBL_Settings'); ?>
        </h4>
    </div>
    <div class="sectionbody space">      
        <div class="tabs_nav_container responsive flat">
            <div class="tabs_panel_wrap">
                <div class="tabs_panel">
                    <?php echo $frm->getFormHtml(); ?>
                </div>
            </div>						
        </div>
    </div>						
</section>