<div class="page-title-container">
    <div class="row-fluid">
        <div class="span12">
            <div class="page-title">
                <h1>CloudeNote Results</h1>
            </div>
            <!-- End of Page Title -->
        </div>
        <!-- End of bootstrap Page Title span12 -->
    </div>
    <!-- End of feature note row-fluid -->
</div>
<div class="row-fluid">
    <div class="span3 cbupperleft" style=" width: 25%;">
        <ul>
            <li class="cbnoteresultright">Name of CloudeNote:</li>
            <!--<li class="cbnoteresultright">Year:</li>-->
            <li class="cbnoteresultright">Staff Assigned</li>
            <li class="cbnoteresultright">Data Sent:</li>
            <li class="cbnoteresultright">Number of Students:</li>
            <li class="cbnoteresultright">Consent:</li>
            <li class="cbnoteresultright">Non-Consent:</li>
            <li class="cbnoteresultright">Not Replied:</li>
        </ul>
    </div>
    <div class="span9 cbupperright" style=" width: 75%;">
        <ul>
            <li class="cbnoteresultright"><?php echo $note_result->note_name; ?></li>
            <!--<li class="cbnoteresultright"><?php /*echo $note_result->group_name; */?></li>-->
            <li class="cbnoteresultright"><?php echo $note_result->first_name . ' ' . $note_result->last_name; ?></li>
            <li class="cbnoteresultright"><?php echo ($note_result->note_schedule_date != '') ? date("d-M-Y", strtotime($note_result->note_schedule_date)) : " "; ?></li>
            <li class="cbnoteresultright"><?php echo ($note_result->student_per_note != "") ? $note_result->student_per_note : 0; ?></li>
            <li class="cbnoteresultright"><?php echo ($note_result->parent_consent != "") ? $note_result->parent_consent : 0; ?></li>
            <li class="cbnoteresultright"><?php echo ($note_result->parent_non_consent != "") ? $note_result->parent_non_consent : 0; ?></li>
            <li class="cbnoteresultright"><?php echo ($note_result->not_replied != "") ? $note_result->not_replied : 0; ?></li>
        </ul>
    </div>
</div>
<div class="clear25"></div>
<div class="row-fluid">
    <div class=" span10 printsave">
        <p class="pull-right">
            <a href="javascript:window.print()"><i class="fa fa-print fa-2x"></i></a>
            <a href="http://pdfcrowd.com/url_to_pdf/"><i class="fa fa-save fa-2x"></i></a>
        </p>
    </div>
</div>