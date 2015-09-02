<form class="form-horizontal" id="parent-ajax-<?php echo $login_user_data->id; ?>" action="" name="parent-form" method="POST">
    <input type="hidden" name="id"
           value="<?php echo (set_value('id')) ? set_value('id') : $login_user_data->id; ?>">

    <div class="user-innerheader">Parent/Caregiver Info</div>
    <div class="user-edit-form">

        <div class="control-group">
            <label class="control-label">First Name</label>

            <div class="controls">
                <input type="text" name="first_name" placeholder="First Name"
                       value="<?php echo (set_value('first_name')) ? set_value('first_name') : $login_user_data->first_name; ?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Last Name</label>

            <div class="controls">
                <input type="text" name="last_name" placeholder="Last Name"
                       value="<?php echo (set_value('last_name')) ? set_value('last_name') : $login_user_data->last_name; ?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Relation With Child</label>

            <div class="controls">
                <select name="relationwithchild">
                    <option value="">Select your Relation</option>
                    <?php foreach ($relation_with_child as $relation):
                        $selected = "";
                        if ($relation->id == $login_user_data->relationwithchild)
                            $selected = "selected";
                        ?>
                        <option value="<?php echo $relation->id; ?>"
                                selected="<?php echo $selected; ?>"><?php echo $relation->relation; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Address 1</label>

            <div class="controls">
                <input type="text" name="address1" placeholder="Address 1"
                       value="<?php echo (set_value('address1')) ? set_value('address1') : $login_user_data->address1; ?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Address 2</label>

            <div class="controls">
                <input type="text" name="address2" placeholder="Address 2"
                       value="<?php echo (set_value('address2')) ? set_value('address2') : $login_user_data->address2; ?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">City</label>

            <div class="controls">
                <input type="text" name="city_name" placeholder="City"
                       value="<?php echo (set_value('city_name')) ? set_value('city_name') : $login_user_data->city_name; ?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Country <!-- <span class="required">*</span> --></label>

            <div class="controls">
                <select class="country-id" id="section_member_caregivers_country_id" name="country_id" data-country="state<?php echo $login_user_data->id; ?>">
                    <option value="">Select your Country</option>
                    <?php foreach ($country_list as $clist):
                        $selected = "";
                        if ($clist->country_id == $login_user_data->country_id)
                            $selected = 'selected ="selected"';
                        ?>
                        <option value="<?php echo $clist->country_id; ?>"
                                data-country-code="<?php echo $clist->country_code_char2; ?>"
                            <?php echo $selected; ?>>
                            <?php echo $clist->country_name; ?>( <?php echo $clist->country_code_char3; ?> )
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">State / Provinces</label>

            <div class="controls">
                <select class="state state-<?php echo $login_user_data->id; ?>" name="state_id"
                        id="section_member_caregivers_state_id"
                        data-state-of="section_member_caregivers_country_id">
                    <option value="">Select your State / Provinces</option>

                </select>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">Postcode</label>

            <div class="controls">
                <input type="text" name="postcode" placeholder="Postcode"
                       value="<?php echo (set_value('postcode')) ? set_value('postcode') : $login_user_data->postcode; ?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Timezone</label>

            <div class="controls">
                <select name="timezone_id">
                    <option value="">Select Timezone</option>
                    <?php foreach ($timezone_list as $tlist):
                        $selected = "";
                        if ($tlist->timezone_id == $login_user_data->timezone_id)
                            $selected = 'selected ="selected"';
                        ?>
                        <option value="<?php echo $tlist->timezone_id; ?>" <?php echo $selected; ?>>
                            ( <?php echo $tlist->timezone_shown_as; ?>
                            ) <?php echo $tlist->timezone_full_name; ?> </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <br>
        <br>

        <div class="control-group">
            <label class="control-label">Work Phone</label>

            <div class="controls">
                <input type="text" name="workphone" placeholder="Work Phone"
                       value="<?php echo (set_value('workphone')) ? set_value('city_name') : $login_user_data->workphone; ?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Home Phone</label>

            <div class="controls">
                <input type="text" name="homephone" placeholder="Home Phone"
                       value="<?php echo (set_value('homephone')) ? set_value('homephone') : $login_user_data->homephone; ?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Mobile Phone</label>

            <div class="controls">
                <input type="text" name="mobilephone" placeholder="Mobile Phone"
                       value="<?php echo (set_value('mobilephone')) ? set_value('mobilephone') : $login_user_data->mobilephone; ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Profile Photo</label>

            <div class="controls">
                <div class="cdimage">
                    <?php
                    $url= base_url().'upload/avatar/parent/'.md5(md5($login_user_data->id)).'.'.$login_user_data->image_ext ;
                    if (!(@file_get_contents($url, 0, NULL, 0, 1))) {
                        $url =  base_url().'resources/img/blank.jpeg';
                    }

                    ?>
                    <img id = '<?php echo $login_user_data->id;?>' class="imageloadedparentprofile"  src="<?php echo $url ;?>" alt="Image Not Found" width="120" height="180">
                    <!--<img id="postImage" width="120" height="180" name="postImage"  src="<?php /*echo base_url('resources/img/blank.jpeg'); */?>">-->
                    <br>
                    <input  class="add-image buttonpp" type="button"  value="Add" data-user-id="<?php echo $login_user_data->id;?>" data-user-type="parent">
                    <input  class="buttonpp" type="button"  value="Change" name="Submit">
                </div>

            </div>

        </div>
        <div class="control-group">
            <div class="controls">
                <button type="submit" data-formid="parent-ajax-<?php echo $login_user_data->id; ?>"
                        class="save-parent btn btn-success">Save Parent Info
                </button>
            </div>
        </div>
    </div>

</form>