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
            <div class="row-fluid">
                <div class="span10 offset1">

                    <div class="well" style="margin: 0px;">
                        <div class="cldnt-info-area">

                            <div class="row-fluid">
                                <div class="span12">

                                    <?php if( isset( $note_replier_name ) and !empty( $note_replier_name ) ) : ?>
                                        <div class="alert alert-info">
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                            <strong>Hello <?php echo $this->user_info->first_name; ?>, </strong>
                                            "<?php echo ($note_replier_id == $this->user_info->id) ? 'You': $note_replier_name; ?>" replied this note at <?php echo $note_reply_time; ?>.
                                        </div>
                                    <?php endif; ?>

                                    <!--<div class="alert-msg alert hidden">
                                        <strong class="msg-type"></strong>
                                        <span class="msg"></span>
                                    </div>-->

                                    <div class="well span12" style="text-align: left; background-color: #FFF;"><?php
                                        $url = base_url() . 'upload/logo/logo.png';
                                        if (!(@file_get_contents($url, 0, NULL, 0, 1))) {
                                            $url = base_url() . 'resources/img/blank.jpeg';
                                        }
                                        ?>
                                        <div class="org-logo" style="margin: 0 auto;text-align: center; margin: 20px 0">
                                            <img src="<?php echo $url; ?>" alt="Image Not Found">
                                        </div>

                                        <div id="tab_preview_note">
                                            <form id="form-inline">
                                                <fieldset id="tab-preview-note-fieldset">

                                                    <?php if( $number_of_page_break > 0 ): ?>
                                                        <div id="preview-note-wizard">

                                                            <div class="tabbable" style=" display: none">
                                                                <ul class="breadcumb nav nav-tabs">
                                                                    <?php for( $page_link = 1; $page_link <= ($number_of_page_break+1); $page_link++ ): ?>
                                                                        <li><a href="#tab<?php echo $page_link; ?>"  data-toggle="tab"><?php echo $page_link; ?></a></li>
                                                                    <?php endfor; ?>
                                                                </ul>
                                                            </div>

                                                            <div class="tab-content">
                                                                <?php for( $page_link = 1; $page_link <= ($number_of_page_break+1); $page_link++ ): ?>
                                                                    <div class="tab-pane" id="tab<?php echo $page_link; ?>"></div>
                                                                <?php endfor; ?>
                                                            </div>

                                                            <ul class="pager wizard">
                                                                <li id="previous-note" class="previous"><a href="#note-area">Back</a></li>

                                                                <span class="btn" href="#">Page
                                                                    <span class="current-page">1</span> of
                                                                    <span class="total-page">3</span>
                                                                </span>

                                                                <li class="next"><a href="#note-area">Next Step</a></li>
                                                            </ul>

                                                        </div>
                                                    <?php endif; ?>

                                                </fieldset>
                                            </form>
                                        </div> <!-- END of preview note -->

                                    </div><!-- END of white well -->

                                    <div style="margin: 0px;text-align: center;">
                                        <div class="powered-by-text">Powered By</div>
                                        <?php
                                        $url = base_url() . 'resources/img/cloudenote_footer_logo.png';
                                        if (!(@file_get_contents($url, 0, NULL, 0, 1))) {
                                            $url = base_url() . 'resources/img/blank.jpeg';
                                        }
                                        ?>
                                        <div class="powered-by-logo"><img src="<?php echo $url; ?>" alt="Image Not Found" /></div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div><!-- End of Well -->



                </div>
            </div>

            <div class="row-fluid">
                <div class="span10 offset1">



                </div>
            </div>

        </div>
    </div>
</section>

