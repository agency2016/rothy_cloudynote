<section class="main-content-body" xmlns="http://www.w3.org/1999/html">
<?php
      /**
       * Created by PhpStorm.
       * User: ADNAN
       * Date: 4/16/14
       * Time: 11:54 AM
       */

      $this->view('page/dashboard-icon-menu/index');
      //echo "<pre>"; print_r($note_list);echo "</pre>";
?>

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
</section>