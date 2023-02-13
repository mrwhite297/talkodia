<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$blockFrm->setFormTagAttribute('class', 'web_form form_horizontal');
$blockFrm->setFormTagAttribute('onsubmit', 'setup(this); return(false);');
$blockFrm->developerTags['colClassPrefix'] = 'col-md-';
$blockFrm->developerTags['fld_default_col'] = 12;
?>
<section class="section">
    <div class="sectionhead">
        <h4><?php echo Label::getLabel('LBL_Content_Pages_Setup'); ?></h4>
    </div>
    <div class="sectionbody space">
        <div class="row">	
            <div class="col-sm-12">
                <div class="tabs_nav_container responsive flat">
                    <ul class="tabs_nav">
                        <li><a class="active" href="javascript:void(0)" onclick="addForm(<?php echo $cpage_id ?>);"><?php echo Label::getLabel('LBL_General'); ?></a></li>
                        <?php
                        $inactive = ($cpage_id == 0) ? 'fat-inactive' : '';
                        foreach ($languages as $langId => $langName) {
                            ?>
                            <li class="<?php echo $inactive; ?>">
                                <a href="javascript:void(0);" <?php if ($cpage_id > 0) { ?> onclick="addLangForm(<?php echo $cpage_id ?>, <?php echo $langId; ?>, <?php echo $cpage_layout; ?>);" <?php } ?>>
                                    <?php echo $langName; ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                    <div class="tabs_panel_wrap">
                        <div class="tabs_panel">
                            <?php echo $blockFrm->getFormHtml(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>