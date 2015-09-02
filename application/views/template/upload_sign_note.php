<div id="upload-image" class="modal hide fade in" style="display: none; ">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3>Profile Image Uploader</h3>
    </div>
    <div class="modal-body">
        <h4></h4>
        <h6></h6>
        <div id="upload-wrapper">
            <div align="center">
                <form action="<?php echo base_url('user/upload-image'); ?>" method="post" enctype="multipart/form-data" id="MyUploadForm">
                    <input id="image-profile" name="image-profile" type="hidden"/>
                    <input id="user_type" name="user_type" type="hidden"/>
                    <input id="group-id" name="group-id" type="hidden"/>
                    <input id="item-id" name="item-id" type="hidden"/>
                    <input name="ImageFile" id="imageInput" type="file" />
                    <input type="submit"  id="submit-btn" value="Upload" />
                    <img src="<?php echo base_url().'resources/img/ajax-loader.gif';?>" id="loading-img" style="display:none;" alt="Please Wait"/>
                </form>
                <div id="outputshow" style="display:none;"></div>
                <div id="output" style="display:none;"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <!-- <a href="#" id="move_member" class="btn btn-success">Move</a>-->
        <a href="#" id="closenRefresh" class="btn" data-dismiss="modal">Close</a>
    </div>
</div>