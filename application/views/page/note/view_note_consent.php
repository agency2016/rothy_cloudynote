<?php $json = json_decode($note_result->note_json_form_options); ?>
<section class="main-content-body">
    <div class="container">
        <div class="container-wrapper">
            <?php $this->view('page/include/view_note_data');?>
            <div class="row-fluid">
                <div class="span12">
                    <?php
                    if ($note_parent_student == false) {
                        echo '<div class="cblower">No Note Send to Parents</div>';
                    } else {
                        ?>
                        <div class="table-scroll">
                            <table class="table table-striped  cblower">
                                <thead>
                                <th style="width:15%"> Student Name</th>
                                <th style="width:8%">Class</th>
                                <th style="width:8%">Consent</th>
                                <!--<th style="width:8%"><i class="fa fa-thumbs-o-up fa-2x"></i></th>
                                <th style="width:8%"><i class="fa fa-thumbs-o-down fa-2x"></i></th>-->

                                <?php
                                // echo "<pre>";print_r($json);
                                foreach ($json as $note_item): //echo "<pre>";print_r(get_object_vars($note_item));
                                    if (!is_object($note_item)) {
                                        break;
                                    }

                                    //echo $note_item->label_name;
                                    foreach (get_object_vars($note_item) as $data_type => $note):
                                        // echo "<pre>";print_r($note);
                                        if ($data_type == 'remark' || $data_type == 'pagebreak' || $data_type == 'signature' || $data_type == 'sign' || $data_type == 'reminder-date' || $data_type == 'reply-by-date' || $data_type == 'sectionbreak' || $data_type == 'payment-due') {
                                            continue;
                                        }
                                        ?>
                                        <th>
                                            <?php echo $label = $note->label_name; ?>
                                        </th>
                                    <?php
                                    endforeach;
                                    //echo $label;
                                    ?>

                                <?php endforeach; ?>

                                <th>Remarks</th>
                                </thead>

                                <tbody>
                                <?php
                                // echo "<pre>";print_r($note_parent_student);

                                foreach ($note_parent_student as $student):
                                    $parent_json = json_decode($student->response_note_response_json);
                                    //echo "<pre>";print_r($parent_json);
                                    // exit();
                                    ?>
                                    <tr>
                                        <td><?php echo $student->section_member_first_name . ' ' . $student->section_member_last_name; ?></td>
                                        <td><?php echo $student->section_name; ?> </td>
                                        <td><?php
                                            //echo $student->response_consent;
                                            if ($student->response_consent == '0') {
                                                ?><i class="fa fa-thumbs-o-up fa-2x"></i><?php
                                            } else if ($student->response_consent == '1') {
                                                ?><i class="fa fa-thumbs-o-down fa-2x"></i><?php
                                            } else {
                                                ?>
                                                <i class="fa fa-times fa-2x"></i>
                                            <?php
                                            }
                                            ?>
                                        </td>

                                        <!--<td><i class="fa fa-check fa-2x"></i></td>
                                        <td><i class="fa fa-times fa-2x"></i></td>-->

                                        <?php
                                        //echo "<pre>";print_r($json);
                                        foreach ($json as $note_item): //echo "<pre>";print_r(get_object_vars($note_item));
                                            if (!is_object($note_item)) {
                                                break;
                                            }
                                            ?>

                                            <?php //echo $note_item->label_name;
                                            foreach (get_object_vars($note_item) as $property => $note):
                                                //echo $label= $note->label_name;
                                                //echo $property;
                                                if ($property == 'remark' || $property == 'pagebreak' || $property == 'signature' || $property == 'sign' || $property == 'reminder-date' || $property == 'reply-by-date' || $property == 'sectionbreak' || $property == 'payment-due') {
                                                    continue;
                                                }
                                                ?>
                                                <td><?php
                                                    if ($property == 'textbox') {
                                                        echo $note->text_default_value;

                                                    } else if ($property == 'checkbox') {
                                                        //echo $note->text_default_value;
                                                        ?>
                                                        <ul>
                                                            <?php
                                                            foreach (get_object_vars($note->total_items) as $item):
                                                                //print_r($item);
                                                                if ($item->item_checked == "checked")
                                                                    ?>
                                                                    <li><?php echo $item->label_name; ?></li>
                                                            <?php

                                                            endforeach;
                                                            ?>
                                                        </ul>

                                                    <?php
                                                    } else if ($property == 'paragraph') {
                                                        echo $note->paragraph;
                                                    } else if ($property == 'remark') {
                                                        //print_r($note);
                                                        //echo $note->remark;
                                                    } else if ($property == 'phone') {
                                                        echo $note->phone;
                                                    } else if ($property == 'payment-due') {
                                                        echo $note->default_dollar_value . "." . $note->default_cent_value;
                                                    }
                                                    ?>
                                                </td>
                                            <?php
                                            endforeach;
                                            //echo $label;
                                            ?>

                                        <?php endforeach; ?>

                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                </div>

            </div>
        </div>
    </div>
</section>
