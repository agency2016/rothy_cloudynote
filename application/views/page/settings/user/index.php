<?php
/**
 * Created by PhpStorm.
 * User: ridhia
 * Date: 12/2/13
 * Time: 4:20 PM
 */

?>

<section class="main-content-body">
    <div class="container">
        <div class="container-wrapper">
            <div class="row-fluid">
                <div class="span12">
                    <div class="well">
                        <div class="cldnt-info-area">
                            <div class="row-fluid">
                               <?php if ($login_user_data->user_access_level <=4) {
                                ?>
                                   <a href ="<?php echo base_url('user/permissions');?>">User Capability</a>
                                <?php
                                }?>

                            </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Well -->
                </div>
            </div>
        </div>
    </div>
</section>