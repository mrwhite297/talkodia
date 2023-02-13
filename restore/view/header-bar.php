<style>
    .-fixed-wrap {
        position: fixed;
        bottom: 10rem;
        right: 1rem;
        z-index: 9999;
    }

    .-fixed-wrap a {
        position: relative;
        display: inline-block;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        border: none;
        border-radius: 2px;
        padding: 2.25rem 1rem 0.5rem;
        vertical-align: middle;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        text-align: center;
        text-overflow: ellipsis;
        text-transform: uppercase;
        color: #fff;
        background: #666;
        text-decoration: none;
        font-size: 1.5rem;
        letter-spacing: 0.15em;
        overflow: hidden;
        min-width: 150px;
    }

    .-fixed-wrap a small {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        display: block;
        padding: 0.5rem 1rem;
        font-size: 0.5rem;
        letter-spacing: 0.05em;
        white-space: nowrap;
        background-color: rgba(0, 0, 0, 0.2);
    }

    .restore-demo-bg {
        background-image: url('<?php echo MyUtility::makeFullUrl('', '', array(), CONF_WEBROOT_FRONT_URL) . 'images/catalog-bg.png'; ?>') !important;
        background-color: #fff !important;
        background-repeat: no-repeat !important;
        background-position: 130% top !important;
    }

    .restore-demo .demo-data-inner>ul,
    .restore-demo .demo-data-inner .heading {
        max-width: 500px;
        margin-right: 250px;
    }

    .demo-data-inner {
        margin: 20px;
        color: #4c4c4c;
    }

    .demo-data-inner .heading {
        font-size: 4rem;
        font-weight: 600;
        text-transform: uppercase;
        position: relative;
        line-height: 1.2;
        margin-bottom: 40px;
        color: inherit;
    }

    .demo-data-inner .heading:after {
        background: var(--color-primary);
        width: 60px;
        height: 3px;
        position: absolute;
        bottom: -10px;
        content: "";
        display: block;
    }

    .demo-data-inner .heading span {
        display: block;
        font-size: 0.8rem;
        text-transform: none;
    }

    .demo-data-inner ul li {
        position: relative;
        margin: 10px 0;
        padding: 0 15px;
        display: block;
        font-size: 0.9rem;
    }

    .demo-data-inner ul li:before {
        width: 5px;
        height: 5px;
        content: "";
        display: block;
        position: absolute;
        left: 0;
        top: 8px;
        transform: rotate(45deg);
        background: #4c4c4c;
    }

    .demo-data-inner ul ul {
        margin-inline-start: 15px;
        margin-bottom: 20px;
    }

    .restore-demo {
        min-height: 300px;
    }

    .restore-demo a {
        color: var(--secondary-color);
    }

    .restore-demo p {
        font-size: 1.1rem;
        font-weight: 400;
        line-height: 1.5;
    }

    #facebox .restore-demo.fbminwidth {
        min-width: 350px;
        min-height: 150px;
    }

    #facebox .restore-demo {
        display: block;
        width: 100%;
        padding: 15px;
        background-color: #fff;
        border-radius: 4px;
        margin: 0 auto;
        position: relative;
    }

    .demo-data-inner ul li {
        position: relative;
        margin: 10px 0;
        padding: 0 15px;
        display: block;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    /* preview header */
    .preview-header{background-color:#000; color: #fff;position: sticky;top: 0; z-index: 12;width: 100%; height: 60px;}
    .preview-header a {color: inherit;}
    .preview-progress__head{display: flex; align-items: center; justify-content: space-between; font-size: 0.85rem; padding-bottom: 0.4rem;}
    .progress-count{font-weight: 800; color: #ff793d;}

    .preview-container{ min-height: 40px;display: -webkit-box; display: -ms-flexbox; display: flex; -webkit-box-align: center; -ms-flex-align: center; align-items: center; -webkit-box-pack: justify; -ms-flex-pack: justify; justify-content: space-between;}

    @media(min-width:576px){
        /* .is-preview-on .header.nav-up,.is-preview-on .header.nav-down{transform: translateY(inherit);-webkit-transform: translateY(inherit);} */
        .is-preview-on .header.nav-down, .is-preview-on #header{top: 60px;}
        .is-preview-on.teachers.teachers-index .header.nav-down, .groupclasses.groupclasses-index .header.nav-down{top: 0;}
        .is-preview-on.teacherrequest.teacherrequest-form .header{top: 8.6rem; transition: none;}




        /* .is-tutor-listing.is-preview-on .header, .is-group-classes.is-preview-on .header, .teachers.teachers-index.is-preview-on .header, .groupclasses.groupclasses-index.is-preview-on .header, .teachers.teachers-languages.is-preview-on .header
         {position: sticky;} */

        /* .is-preview-on .header .header-primary{box-shadow: none;} */

    }

    /* .is-preview-on #header, .is-preview-on.is-filter-fixed #header{top: 60px;} */
    .is-preview-on .leftside{padding-top: 132px;}

    @media(min-width:1199px){
        /* .is-preview-on.is-filter-fixed .header{top: 60px;} */
        .is-preview-on.is-filter-fixed .section-filters{top:60px;}
    }




    /* @media(min-width:1199px){
        .preview-container__cell{-webkit-box-flex: 1;-ms-flex: 1;flex: 1;}  

       
    } */

    .preview-container__cell{ display: -webkit-box; display: -ms-flexbox; display: flex; -webkit-box-align: center; -ms-flex-align: center; align-items: center;}

    .preview-progress{min-width: 240px; max-width: 240px;padding: 0.4rem 1rem;}


    .preview-controls{position: relative; margin: 0 auto;
                      display: -webkit-box; display: -ms-flexbox; display: flex; -webkit-box-align: center; -ms-flex-align: center; align-items: center; -webkit-box-pack: center; -ms-flex-pack: center; justify-content: center;}
    .preview-controls__action{width: 60px; height: 60px; position: relative;
                              display: -webkit-box; display: -ms-flexbox; display: flex; -webkit-box-align: center; -ms-flex-align: center; align-items: center; -webkit-box-pack: center; -ms-flex-pack: center; justify-content: center; margin: 0 0.3rem;}
    .preview-controls__action .control-svg{opacity: 0.6;}
    .preview-controls__action.is-active{background-color:rgba(255,255,255,0.3);}
    .preview-controls__action.is-active .control-svg{opacity: 1;}
    .preview-controls__action:hover .control-svg{opacity: 1;}

    .control-svg{width: 32px; height: 32px; position: relative; overflow: hidden;}
    .control-svg svg{width:100%; height:100%; display: block; overflow: hidden; fill: currentColor;}

    .preview-button{display: inline-flex; padding: 0.7rem 1.2rem; background-color: #ff5317; border: 1px solid transparent; font-size: 13px; border-radius:3px;}
    .preview-button:hover{background-color:#0037B4;}
    .buttons-bucket{margin-left: auto;}

    .preview-close{width: 60px; height: 60px; position: relative; margin-left: 1rem; text-align: center; line-height: 60px; overflow: hidden;}
    .preview-close::before{position: absolute; left: 0;right: 0;top: 0; bottom: 0; margin: auto; content: "+"; font-size:3rem; font-weight: 500; transform: rotate(45deg);-webkit-transform: rotate(45deg);}

    .progress-ui {width: 100%;height: 0.3rem;background-color:#eee;min-width: 120px;overflow: hidden; border-radius: 60px;}
    .progress-ui__bar { -webkit-transition: width .6s ease;    -o-transition: width .6s ease;    transition: width .6s ease;    background-color: #ff793d;    display: -webkit-box;    display: -ms-flexbox;    display: flex;    -webkit-box-pack: end;        -ms-flex-pack: end;            justify-content: flex-end;    -webkit-box-align: center;-ms-flex-align: center;   align-items: center; border-radius: 60px;    height: 100%;    font-size: 11px;}


    .preview-controls__action--admin .control-svg{width: 30px; height: 30px;}

    @media(max-width:1199px){
        .preview-container__cell.preview-container__middle{display: none;}
    }

    @media(max-width:767px){
        .preview-header{display: none;}
    }

    body[dir='rtl'] .buttons-bucket{margin-right: auto; margin-left: 0;}
    body[dir='rtl'] .preview-closet{margin-left: 0; margin-right: 1rem;}



</style>
<?php
$backendUrl = MyUtility::makeFullUrl('', '', [], CONF_WEBROOT_BACKEND);
$frontendUrl = MyUtility::makeFullUrl('', '', [], CONF_WEBROOT_FRONTEND);
$mobileUrl = MyUtility::makeFullUrl('Mobile', '', [], CONF_WEBROOT_FRONTEND);
$requestUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

$mobileView = '';
$backendView = '';
$frontendView = '';
if (strpos($requestUrl, $mobileUrl) > -1) {
    $mobileView = 'is-active';
} elseif (strpos($requestUrl, $backendUrl) > -1) {
    $backendView = 'is-active';
} else {
    $frontendView = 'is-active';
}
?>
<div class="preview-header">
    <div class="preview-container">
        <div class="preview-container__cell preview-container__left">
            <a class="preview-progress" href="javascript:void(0)" onclick="showRestorePopup()">
                <div class="preview-progress__head">
                    <span>Database Restore In</span>
                    <span><span class="progress-count" id="restoreCounter">00:00:00</span></span>
                </div>
                <div class="preview-progress__body">
                    <div class="progress-ui">
                        <div class="progress-ui__bar" role="progressbar" style="width:25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </a>
        </div>
        <div class="preview-container__cell preview-container__middle">
            <div class="preview-controls">
                <?php $view = explode("/", trim($_SERVER['REQUEST_URI'], "/"))[0] ?? ''; ?>
                <a href="<?php echo MyUtility::makeUrl('', '', [], CONF_WEBROOT_BACKEND); ?>" class="preview-controls__action preview-controls__action--admin <?php echo $backendView; ?>" title="Admin View">
                    <span class="control-svg">
                        <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 -16 384 384">
                            <path d="m80 0h-80v352h384v-352zm-48 32h48v40h-48zm320 288h-320v-216h320zm0-248h-240v-40h240zm0 0" />
                            <path d="m64 192h32v96h-32zm0 0" /><path d="m120 160h32v128h-32zm0 0" />
                            <path d="m232 224h32v64h-32zm0 0" /><path d="m288 136h32v152h-32zm0 0" />
                        </svg>
                    </span>
                </a>
                <a href="<?php echo MyUtility::makeUrl('', '', [], CONF_WEBROOT_FRONTEND); ?>" class="preview-controls__action <?php echo $frontendView; ?>" title="Desktop View">
                    <span class="control-svg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M4 16h16V5H4v11zm9 2v2h4v2H7v-2h4v-2H2.992A.998.998 0 0 1 2 16.993V4.007C2 3.451 2.455 3 2.992 3h18.016c.548 0 .992.449.992 1.007v12.986c0 .556-.455 1.007-.992 1.007H13z"/></svg>
                    </span>
                </a>
                <a href="<?php echo MyUtility::makeUrl('Mobile', '', [], CONF_WEBROOT_FRONTEND); ?>" class="preview-controls__action <?php echo $mobileView; ?>" title="Mobile View">
                    <span class="control-svg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7 4v16h10V4H7zM6 2h12a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1zm6 15a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>
                    </span>
                </a>
            </div>
        </div>
        <div class="preview-container__cell preview-container__right">
            <div class="buttons-bucket">
                <a target="_blank" href="https://www.fatbit.com/online-learning-consultation-marketplace-platform.html" class="preview-button"><?php echo Label::getLabel('LBL_START_YOUR_MARKETPLACE'); ?></a>
                <a target="_blank" href="https://www.yo-coach.com/?demo_form" class="preview-button"><?php echo Label::getLabel('LBL_Get_A_Personalized_Demo'); ?></a>
                <a target="_blank" href="https://www.yo-coach.com/clients.html" class="preview-button"><?php echo Label::getLabel('LBL_OUR_CLIENTS') ?></a>
            </div>
            <a href="javascript:void(0)" class="preview-close" onclick="closePreview();"></a>
        </div>
    </div>
</div>
<script>

    function closePreview() {
        $('.preview-header').slideUp();
        $('body').removeClass('is-preview-on');
    }

    function showRestorePopup() {
        $.facebox('<div class="demo-data-inner"><div class="heading">Yo!Coach<span></span></div> <p>To enhance your demo experience, we periodically  restore our database every 24 hours.</p><br> <p>For technical issues :-</p> <ul> <li><strong>Call us at: </strong>+1 469 844 3346, +91 85919 19191, +91 95555 96666, +91 73075 70707, +91 93565 35757</li> <li><strong>Mail us at : </strong> <a href="mailto:sales@fatbit.com">sales@fatbit.com</a></li> </ul> <br> Create Your Online Tutoring & Consultation Platform With Yo!Coach <a href="https://www.fatbit.com/website-design-company/requestaquote.html" target="_blank">Click here</a></li></div>', 'restore-demo restore-demo-bg fbminwidth');
    }

    function restoreSystem() {
        fcom.process('Restore is in process..');
        fcom.updateWithAjax(fcom.makeUrl('RestoreSystem', 'index', '', '/'), '', function (resp) {
            window.location.reload();
        }, false, false);
    }

    $(document).on("click", "#demoBoxClose", function (e) {
        $('.demo-header').hide();
        $('html').removeClass('sticky-demo-header');
    });
    // Set the date we're counting down to
    var countDownDate = new Date('<?php echo FatApp::getConfig('CONF_RESTORE_SCHEDULE_TIME'); ?>').getTime();
    // Update the count down every 1 second
    var x = setInterval(function () {
        // Get today's date and time
        //var now = new Date().getTime();
        var date = new Date();
        var utcDate = new Date(date.toLocaleString('en-US', {timeZone: "UTC"}));
        var now = utcDate.getTime();
        // Find the distance between now and the count down date
        var distance = countDownDate - now - 65000;

        // Time calculations for days, hours, minutes and seconds
        // var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        var str = ('0' + hours).slice(-2) + ":" + ('0' + minutes).slice(-2) + ":" + ('0' + seconds).slice(-2);
        // Display the result in the element with id="demo"
        document.getElementById("restoreCounter").innerHTML = str;
        var progressPercentage = 100 - (parseFloat(hours + '.' + parseFloat(minutes / 15 * 25)) * 100 / 4);
        $('.progress-ui__bar').css('width', progressPercentage + '%');
        // If the count down is finished, write some text
        if (distance < 0) {
            document.getElementById("restoreCounter").innerHTML = 'Restoring...';
            clearInterval(x);
            restoreSystem();
        }
    }, 1000);
</script>