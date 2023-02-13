<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class='page'>
    <div class='fixed_container'>
        <div class="row">
            <div class="space">
                <div class="page__title">
                    <div class="row">
                        <div class="col--first col-lg-auto">
                            <span class="page__icon"><i class="ion-android-star"></i></span>
                            <h5><?php echo Label::getLabel('LBL_Manage_Labels'); ?> </h5>
                            <?php $this->includeTemplate('_partial/header/header-breadcrumb.php'); ?>
                        </div>
                        <div class="col-lg-auto">
                            <div class="buttons-group">
                                <?php if ($canEdit) { ?>
                                    <a href="javascript:void(0);" onclick="importLabels(0);" class="btn-primary"><?php echo Label::getLabel('LBL_Import'); ?></a>
                                <?php } ?>
                                <a href="javascript:void(0);" onclick="exportLabels(0);" class="btn-primary"><?php echo Label::getLabel('LBL_Export'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="section searchform_filter">
                    <div class="sectionhead">
                        <h4> <?php echo Label::getLabel('LBL_Search'); ?></h4>						
                    </div>
                    <div class="sectionbody space togglewrap" style="display:none;">
                        <?php
                        $frmSearch->setFormTagAttribute('onsubmit', 'searchLabels(this); return(false);');
                        $frmSearch->setFormTagAttribute('id', 'frmLabelsSearch');
                        $frmSearch->setFormTagAttribute('class', 'web_form');
                        $frmSearch->developerTags['colClassPrefix'] = 'col-md-';
                        $frmSearch->developerTags['fld_default_col'] = 6;
                        $btn = $frmSearch->getField('btn_clear');
                        $btn->setFieldTagAttribute('onClick', 'clearSearch()');
                        echo $frmSearch->getFormHtml();
                        ?>    
                    </div>
                </section> 
                <section class="section">
                    <div class="sectionbody">
                        <div class="tablewrap" >
                            <div id="listing"> 
                                <?php echo Label::getLabel('LBL_processing...'); ?>
                            </div>
                        </div> 
                    </div>
                </section>
            </div>		
        </div>
    </div>
</div>	