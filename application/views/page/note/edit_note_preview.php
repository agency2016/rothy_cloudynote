<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 12/4/13
 * Time: 3:21 PM
 */

$this->view('template/upload_sign');
?>


<section class="main-content-body">
    <div class="container">
        <div class="container-wrapper">
            <div class="clearfix clear15"></div>
            <div class="row-fluid">
                <div class="span10 offset1">
                    <div class="well" style="margin: 0px;text-align: center;">

                        <?php
                        $url = base_url() . 'upload/logo/logo.png';
                        if (!(@file_get_contents($url, 0, NULL, 0, 1))) {
                            $url = base_url() . 'resources/img/blank.jpeg';
                        }
                        ?>
                        <img
                            src="<?php echo $url; ?>" alt="Image Not Found"
                            >
                    </div>
                </div>
                <div class="span1"></div>
            </div>
            <div class="row-fluid">
                <div class="span10 offset1">
                    <div class="well" style="margin: 0px;">
                        <div class="cldnt-info-area">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div id="tab_preview_note">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End of Well -->
                </div>
                <div class="span1"></div>
            </div>
            <div class="row-fluid">
                <div class="span10 offset1">
                    <div class="well" style="margin: 0px;text-align: center;">

                        <?php
                        $url = base_url() . 'resources/img/cloudenote_footer_logo.png';
                        if (!(@file_get_contents($url, 0, NULL, 0, 1))) {
                            $url = base_url() . 'resources/img/blank.jpeg';
                        }
                        ?>
                        Powered By</br>
                        <img
                            src="<?php echo $url; ?>" alt="Image Not Found"
                            >
                    </div>
                </div>
                <div class="span1"></div>
            </div>
            <div class="clearfix clear15"></div>

        </div>
    </div>
</section>

