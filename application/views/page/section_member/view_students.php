<section class="main-content-body">
    <div class="container">
        <div class="container-wrapper">
            <div class="row-fluid">
                <div class="span3">
                    <!-- Left Sidebar Menu Start -->


                    <?php $this->view('page/include/left_side_menu'); ?>

                    <!-- Left Sidebar Menu End -->


                </div>
                <div class="span9">
                    <div class="well">
                        <div class="cldnt-info-area">
                            <div class="row-fluid">
                                <div class="span12">

                                    <table id="rt2" class="rt cf">
                                        <tbody>
                                        <?php foreach($single_student_data as $val): ?>
                                            <tr>
                                                <td>Student Name</td>
                                                <td><?php echo $val->section_member_name; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Student Class Name</td>
                                                <td><?php echo $val->section_name; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Student Father's Name</td>
                                                <td><?php echo $val->section_member_f_name; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Student Mother's Name</td>
                                                <td><?php echo $val->section_member_m_name; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Student Cell Phone</td>
                                                <td><?php echo $val->section_member_cell; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Student Address</td>
                                                <td><?php echo $val->section_member_address; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                            <tr>
                                                <td></td>
                                                <td class="action-btn"><a href="<?php echo base_url('user/students/'); ?>"><button class="btn btn-success btn-small">Back To Last Page</button></a></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div><!-- End of Well -->
                </div>
            </div>
        </div>
    </div>
</section>