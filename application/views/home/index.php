<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if (isset($slides) && count($slides)) { ?>
    <section class="section section--slideshow">
        <div class="slideshow slideshow-js">
            <?php
            foreach ($slides as $slide) {
                $desktopUrl = '';
                $tabletUrl = '';
                $mobileUrl = '';
                $haveUrl = ($slide['slide_url'] != '');
                if (empty($slideImages[$slide['slide_id']])) {
                    continue;
                }
                $slideImage = $slideImages[$slide['slide_id']];
                if (!empty($slideImage[Afile::TYPE_HOME_BANNER_DESKTOP])) {
                    $imgUrl = MyUtility::makeUrl('Image', 'show', [Afile::TYPE_HOME_BANNER_DESKTOP, $slide['slide_id'], Afile::SIZE_LARGE]);
                    $desktopUrl = FatCache::getCachedUrl($imgUrl, CONF_IMG_CACHE_TIME, '.jpg');
                }
                if (!empty($slideImage[Afile::TYPE_HOME_BANNER_MOBILE])) {
                    $imgUrl = MyUtility::makeUrl('Image', 'show', [Afile::TYPE_HOME_BANNER_MOBILE, $slide['slide_id'], Afile::SIZE_LARGE]);
                    $mobileUrl = FatCache::getCachedUrl($imgUrl, CONF_IMG_CACHE_TIME, '.jpg');
                }
                $html = '<div><div class="caraousel__item">';
                if (!empty($slideImage[Afile::TYPE_HOME_BANNER_IPAD])) {
                    $imgUrl = MyUtility::makeUrl('Image', 'show', [Afile::TYPE_HOME_BANNER_IPAD, $slide['slide_id'], Afile::SIZE_LARGE]);
                    $tabletUrl = FatCache::getCachedUrl($imgUrl, CONF_IMG_CACHE_TIME, '.jpg');
                }
                if ($haveUrl) {
                    $html .= '<a target="' . $slide['slide_target'] . '" href="' . CommonHelper::processUrlString($slide['slide_url']) . '">';
                }
                $html .= '<div>
                            <div class="slideshow__item">
                               <picture class="hero-img">
                                  <source data-aspect-ratio="4:3" srcset="' . $mobileUrl . '" media="(max-width: 767px)">
                                  <source data-aspect-ratio="4:3" srcset="' . $tabletUrl . '" media="(max-width: 1024px)">
                                  <source data-aspect-ratio="10:3" srcset="' . $desktopUrl . '">
                                  <img data-aspect-ratio="10:3" srcset="' . $desktopUrl . '" alt="' . $slide['slide_identifier'] . '">
                               </picture>
                           </div>
                        </div>';
                if ($haveUrl) {
                    $html .= '</a>';
                }
                $html .= "</div></div>";
                echo $html;
            }
            ?>
        </div>
        <div class="slideshow-content">
            <h1><?php echo Label::getLabel('LBL_SLIDER_TITLE_TEXT'); ?></h1>
            <p><?php echo Label::getLabel('LBL_SLIDER_DESCRIPTION_TEXT'); ?></p>
            <div class="slideshow__form">
                <form method="POST" class="form" action="<?php echo MyUtility::makeFullUrl('Teachers', 'languages'); ?>" name="homeSearchForm" id="homeSearchForm">
                    <div class="slideshow-input">
                        <svg class="icon icon--search">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL . 'images/sprite.svg#search'; ?>"></use>
                        </svg>
                        <input type="text" name="language" placeholder="<?php echo Label::getLabel('LBL_I_AM_LEARNING'); ?>" />
                        <input type="hidden" name="teachLangId" />
                        <input type="hidden" name="teachLangSlug" />
                    </div>
                    <button class="btn btn--secondary btn--large btn--block"><?php echo Label::getLabel('LBL_SEARCH_FOR_TEACHERS'); ?></button>
                </form>
            </div>
            <?php
            if (!empty($popularLanguages)) {
                $lastkey = array_key_last($popularLanguages);
                ?>
                <div class="tags-inline">
                    <b><?php echo Label::getLabel("LBL_POPULAR:") ?></b>
                    <ul>
                        <?php
                        foreach ($popularLanguages as $language) {
                            $language['tlang_name'] = ($lastkey != $language['tlang_id']) ? $language['tlang_name'] . ', ' : $language['tlang_name'];
                            ?>
                            <li class="tags-inline__item"><a href="<?php echo MyUtility::makeUrl('teachers', 'languages', [$language['tlang_slug']]) ?>"><?php echo $language['tlang_name']; ?></a></li>
                            <?php
                        }
                        unset($lastkey);
                        ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </section>
    <?php
}
/**
 * This if (!empty($whyUsBlock)) { condition can be removed
 */
if (!empty($whyUsBlock)) {
    echo html_entity_decode($whyUsBlock);
}
if (!empty($popularLanguages)) {
    ?>
    <section class="section section--language">
        <div class="container container--narrow">
            <div class="section__head">
                <h2><?php echo Label::getLabel('LBL_WHAT_LANGUAGE_YOU_WANT_TO_LEARN?'); ?></h2>
            </div>
            <div class="section__body">
                <div class="flag-wrapper">
                    <?php foreach ($popularLanguages as $language) { ?>
                        <div class="flag__box">
                            <div class="flag__media">
                                <img src="<?php echo FatCache::getCachedUrl(MyUtility::makeUrl('Image', 'show', [Afile::TYPE_TEACHING_LANGUAGES, $language['tlang_id'], Afile::SIZE_SMALL]), CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt="<?php echo $language['tlang_name']; ?>">
                            </div>
                            <div class="flag__name">
                                <span><?php echo $language['tlang_name'] ?></span>
                                <div class="lesson-count"></div>
                            </div>
                            <a class="flag__action" href="<?php echo MyUtility::makeUrl('Teachers', 'languages', [$language['tlang_slug']]); ?>"></a>
                        </div>
                    <?php } ?>
                </div>
                <div class="more-info align-center">
                    <p><?php echo Label::getLabel("LBL_DIFFERENT_LANGUAGE_NOTE"); ?> <a href="<?php echo MyUtility::makeUrl('teachers'); ?>"><?php echo Label::getLabel('LBL_BROWSE_THEM_NOW'); ?></a></p>
                </div>
            </div>
        </div>
    </section>
    <?php
}
if ($topRatedTeachers) {
    ?>
    <section class="section padding-bottom-5">
        <div class="container container--narrow">
            <div class="section__head">
                <h2><?php echo Label::getLabel('LBL_TOP_RATED_TEACHERS', $siteLangId); ?></h2>
            </div>
            <div class="section__body">
                <div class="teacher-wrapper">
                    <div class="row">
                        <?php foreach ($topRatedTeachers as $teacher) { ?>
                            <div class="col-auto col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="tile">
                                    <div class="tile__head">
                                        <div class="tile__media ratio ratio--1by1">
                                            <img src="<?php echo FatCache::getCachedUrl(MyUtility::makeUrl('Image', 'show', [Afile::TYPE_USER_PROFILE_IMAGE, $teacher['user_id'], Afile::SIZE_MEDIUM]), CONF_IMG_CACHE_TIME, '.jpg') ?>" alt="<?php echo $teacher['full_name']; ?>">
                                        </div>
                                    </div>
                                    <div class="tile__body">
                                        <a class="tile__title" href="<?php echo MyUtility::makeUrl('Teachers', 'view', [$teacher['user_username']]); ?>">
                                            <h4><?php echo CommonHelper::truncateCharacters($teacher['full_name'], 60); ?></h4>
                                        </a>
                                        <div class="info-wrapper">
                                            <div class="info-tag location">
                                                <svg class="icon icon--location">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL . 'images/sprite.svg#location'; ?>"></use>
                                                </svg>
                                                <span class="lacation__name"><?php echo $teacher['country_name']['name'] ?? ''; ?></span>
                                            </div>
                                            <div class="info-tag ratings">
                                                <svg class="icon icon--rating">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL . 'images/sprite.svg#rating' ?>"></use>
                                                </svg>
                                                <span class="value"><?php echo $teacher['testat_ratings']; ?></span>
                                                <span class="count">(<?php echo $teacher['testat_reviewes']; ?>)</span>
                                            </div>
                                        </div>
                                        <div class="card__row--action ">
                                            <a href="<?php echo MyUtility::makeUrl('Teachers', 'view', [$teacher['user_username']]); ?>" class="btn btn--primary btn--block"><?php echo Label::getLabel('LBL_VIEW_DETAILS', $siteLangId); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
}
if (!empty($browseTutorPage)) {
    ?>
    <?php echo html_entity_decode($browseTutorPage); ?>
    <?php
}
if (count($classes) > 0) {
    ?>
    <section class="section section--gray section--upcoming-class">
        <div class="container container--narrow">
            <div class="section__head d-flex justify-content-between align-items-center">
                <h2><?php echo Label::getLabel('LBL_UPCOMING_GROUP_CLASSES'); ?></h2>
                <a class="view-all" href="<?php echo MyUtility::makeUrl('GroupClasses'); ?>"><?php echo Label::getLabel("LBL_VIEW_ALL", $siteLangId); ?></a>
            </div>
            <div class="section__body">
                <div class="slider slider--onethird slider-onethird-js">
                    <?php
                    foreach ($classes as $class) {
                        $classData = ['class' => $class, 'siteUserId' => $siteUserId, 'bookingBefore' => $bookingBefore, 'cardClass' => 'card-class-cover'];
                        $this->includeTemplate('group-classes/card.php', $classData, false);
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}
if ($testmonialList) {
    ?>
    <section class="section section--quote">
        <div class="container container--narrow">
            <div class="quote-slider">
                <div class="slider slider--quote slider-quote-js">
                    <?php foreach ($testmonialList as $testmonialDetail) { ?>
                        <div>
                            <div class="slider__item">
                                <div class="quote">
                                    <div class="quote__media">
                                        <img src="<?php echo FatCache::getCachedUrl(MyUtility::makeUrl('Image', 'show', [Afile::TYPE_TESTIMONIAL_IMAGE, $testmonialDetail['testimonial_id'], Afile::SIZE_LARGE]), CONF_DEF_CACHE_TIME, '.jpg'); ?>" alt="<?php echo $testmonialDetail['testimonial_user_name']; ?>">
                                        <div class="quote__box">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="30.857" viewBox="0 0 36 30.857">
                                            <g transform="translate(0 -29.235)">
                                            <path d="M233.882,29.235V44.664h10.286a10.3,10.3,0,0,1-10.286,10.286v5.143a15.445,15.445,0,0,0,15.429-15.429V29.235Z" transform="translate(-213.311)" />
                                            <path d="M0,44.664H10.286A10.3,10.3,0,0,1,0,54.949v5.143A15.445,15.445,0,0,0,15.429,44.664V29.235H0Z" transform="translate(0 0)" />
                                            </g>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="quote__content">
                                        <p><?php echo $testmonialDetail['testimonial_text']; ?></p>
                                        <div class="quote-info">
                                            <h4><?php echo $testmonialDetail['testimonial_user_name']; ?></h4>
                                        </div>
                                        <div class="quote__icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="138" height="118.286" viewBox="0 0 138 118.286">
                                            <g transform="translate(0 -29.235)">
                                            <path d="M233.882,29.235V88.378H273.31a39.474,39.474,0,0,1-39.429,39.429v19.714a59.208,59.208,0,0,0,59.143-59.143V29.235Z" transform="translate(-155.025 0)" />
                                            <path class="b" d="M0,88.378H39.429A39.474,39.474,0,0,1,0,127.806v19.714A59.208,59.208,0,0,0,59.143,88.378V29.235H0Z" transform="translate(0 0)" />
                                            </g>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}
if (!empty($startLearning)) {
    echo html_entity_decode($startLearning);
}
if ($blogPostsList) {
    ?>
    <section class="section">
        <div class="container container--narrow">
            <div class="section__head d-flex justify-content-between align-items-center">
                <h2><?php echo Label::getLabel('LBL_Latest_Blogs'); ?></h2>
                <a class="view-all" href="<?php echo MyUtility::makeUrl('Blog') ?>"><?php echo Label::getLabel('LBL_View_Blogs'); ?></a>
            </div>
            <div class="section__body">
                <div class="blog-wrapper">
                    <div class="slider slider--onehalf slider-onehalf-js">
                        <?php foreach ($blogPostsList as $postDetail) { ?>
                            <div>
                                <div class="slider__item">
                                    <div class="blog-card">
                                        <div class="blog__head">
                                            <div class="blog__media ratio ratio--4by3">
                                                <img src="<?php echo FatCache::getCachedUrl(MyUtility::makeFullUrl('Image', 'show', [Afile::TYPE_BLOG_POST_IMAGE, $postDetail['post_id'], Afile::SIZE_MEDIUM]), CONF_DEF_CACHE_TIME, '.jpg') ?>" alt="<?php echo $postDetail['post_title']; ?>">
                                            </div>
                                        </div>
                                        <div class="blog__body">
                                            <div class="blog__detail">
                                                <div class="tags-inline__item"><?php echo $postDetail['bpcategory_name']; ?></div>
                                                <div class="blog__title">
                                                    <h3><?php echo $postDetail['post_title'] ?></h3>
                                                </div>
                                                <div class="blog__date">
                                                    <svg class="icon icon--calendar">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL . 'images/sprite.svg#calendar' ?>"></use>
                                                    </svg>
                                                    <span><?php echo MyDate::formatDate($postDetail['post_published_on']); ?> </span>
                                                </div>
                                                <a href="<?php echo MyUtility::makeUrl('Blog', 'PostDetail', [$postDetail['post_id']]); ?>" class="btn btn--secondary"><?php echo Label::getLabel('LBL_VIEW_BLOG'); ?></a>
                                            </div>
                                        </div>
                                        <a href="<?php echo MyUtility::makeUrl('Blog', 'PostDetail', [$postDetail['post_id']]); ?>" class="blog__action"></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
<script>
    LANGUAGES = <?php echo json_encode($teachLangs); ?>;
</script>