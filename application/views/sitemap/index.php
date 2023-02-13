<section class="section section--page">
    <div class="container container--fixed">
        <div class="row">
            <?php foreach ($urls as $title => $urlData) { ?>
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <h5 style="font-size:1.6em;"><?php echo $title; ?></h5>
                    <ol style="margin:0 0 30px 0; padding:0; list-style:inside decimal;">
                        <?php foreach ($urlData as $url) { ?>
                            <li><a href="<?php echo $url['url'] ?>"><?php echo $url['value'];  ?></a></li>
                        <?php } ?>
                    </ol>
                </div>
            <?php } ?>
        </div>
    </div>
</section>