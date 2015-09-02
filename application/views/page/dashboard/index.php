<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 12/2/13
 * Time: 4:20 PM
 */


$this->view('page/dashboard-icon-menu/super-admin-icon');
?>

<section class="main-content-body">
    <div class="container">
        <div class="container-wrapper">
            <div class="row-fluid">
                <div class="span12">
                    <div class="statistics-title">
                        <h5>User Statistics</h5>
                    </div>
                    <div class="well">
                        <div class="cldnt-info-area">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="cldnt-user-list">
                                        <?php echo (isset($user_no_found) and !empty($user_no_found)) ? '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Sorry! </strong>'.$user_no_found.'</div>' : ''; ?>
                                        <?php echo (isset($remove_user_error) and !empty($remove_user_error)) ? '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$remove_user_error.'</div>' : ''; ?>
                                        <?php echo (isset($update_profile_success) and !empty($update_profile_success)) ? '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$update_profile_success.'</div>' : ''; ?>
                                        <?php echo (isset($remove_user_success) and !empty($remove_user_success)) ? '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$remove_user_success.'</div>' : ''; ?>
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th colspan="3">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach($user_list as $row): ?>
                                                <tr>
                                                    <td>1</td>
                                                    <td><?php echo $row->first_name; ?></td>
                                                    <td><?php echo $row->last_name; ?></td>
                                                    <td><?php echo $row->email; ?></td>
                                                    <td class="action-btn"><a href="<?php echo base_url('dashboard/user/view/'.$row->id); ?>"><button class="btn btn-success"><i class="fa fa-user"></i></button></a></td>
                                                    <td class="action-btn"><a href="<?php echo base_url('dashboard/user/edit/'.$row->id); ?>"><button class="btn btn-primary"><i class="fa fa-pencil"></i></button></a></td>
                                                    <td class="action-btn"><a href="<?php echo base_url('dashboard/user/remove/'.$row->id); ?>" onclick="return confirm('Are you sure want to delete this user?')"><button class="btn btn-danger"><i class="fa fa-trash-o"></i></button></a></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="cldnt-pagination">
                                        <div class="pagination">
                                            <?php echo $pagination; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="row-fluid"><div class="span12"></div></div>
                        </div>
                    </div><!-- End of Well -->
                </div>
            </div>
        </div>
    </div>
</section>

<div class="row-fluid">
    <div class="container">
        <div class="row-fluid">
            <div class="span12">
                <div class="statistics-title">
                    <h5>Note Statistics</h5>
                </div>
                <div class="statistics-area">
                    <table class="table table-striped">
                        <?php if($note_list == false){

                            echo '<div class="alert alert-info"><strong>No Data Available </strong></div>';
                        }else{?>
                            <tr>
                                <th>Title of Note</th>
                                <th>Created</th>
                                <th>Status</th>
                                <th>Out</th>
                            </tr>

                            <?php foreach ($note_list as $list) : ?>
                                <tr>
                                    <td><?php echo $list->note_name; ?></td>
                                    <td><?php echo $list->note_created_date; ?></td>
                                    <td><?php echo ($list->note_send == 1) ? "<span class='label label-success'>Sent</span>" : "<span class='label label-warning'>Not Sent</span>"; ?></td>
                                    <td><?php echo (isset($list->note_schedule_date)) ? $list->note_schedule_date : ''; ?></td>
                                </tr>

                            <?php endforeach;
                        }?>

                    </table>
                </div>
            </div>
        </div>
        <!--end of note statistics div-->


        <div class="row-fluid">

            <div class="span12">

                <div class="statistics-title">

                    <h5>Financial Statistics</h5>

                </div>

                <div class="statistics-area">

                    <table class="table table-striped">

                        <?php if(!isset($financial_stat) || $financial_stat == ''){

                            echo '<div class="alert alert-info"><strong>No Data Available </strong></div>';
                        }else{?>

                            <tr>

                                <th>Transaction</th>

                                <th>Date</th>

                                <th>AUS $</th>

                            </tr>

                            <?php foreach($financial_stat as $data): ?>
                                <?php ($data->recurring_transaction == 1) ? $title = 'Monthly Subscription Fee for CloudeNotes ' : $title = 'Note Collection: ' ?>
                                <tr>

                                    <td><?php echo $title.'('.$data->package_description.')' ?></td>

                                    <td><?php echo $data->created_at; ?></td>

                                    <td><?php echo $data->amount; ?></td>

                                </tr>
                            <?php endforeach; } ?>


                    </table>

                </div>

            </div>

        </div>
        <!--end of financial statistics div-->

    </div>
    <!--endo of container div of-->

</div><!--statistics div end-->