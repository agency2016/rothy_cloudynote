
<div class="note-counter text-center">
    <div class="row-fluid">
        <div class="span12">
            <!-- <div class="span3 popText">
                 <span class="firstLetter">CloudNote Sent</span>
            </div> -->
            <div class="row-fluid">
                <div class="span4">
                    <p class="newLetter-left index-clogo">CloudeNotes Sent</p>
                </div>
                <div class="span4">
                    <?php foreach($note_count_show as $note_count): ?>
                        <span class="digits"><?php echo $note_count; ?></span>
                    <?php endforeach ?>
                </div>
                <!-- <div class="span3 popText"><span class="lastLetter">Paper Saved</span></div> -->
                <div class="span4">
                    <p class="newLetter-right index-clogo">Paper Saved</p>
                </div>
            </div> <!-- now row end -->
        </div><!--End of counter div in center-->
    </div><!--End of note counter row fluid-->
</div><!--End of note counter class-->