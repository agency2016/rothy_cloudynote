<?php
/**
 * Created by PhpStorm.
 * User: ADNAN
 * Date: 4/16/14
 * Time: 1:54 PM
 */


?>

<div class="row-fluid">
    <div class="container">
        <div class="span8 log-bg">
            <!--<h3>Activity Log</h3>-->
            <table class="table table-act">
                <?php foreach ($log as $list) : ?>
                <tr>
                    <td>
                        <p><strong><?php echo $list->activity_log_date; ?></strong></p>
                    </td>
                    <td>
                        <ul>
                            <?php if ($list->activity_type_name == 'Note') { ?>
                                <li><span><i class="fa fa-cloud note-act"></i></span><span class="label note-act-bg label-override"><?php echo $list->activity_type_name; ?></span><span class="profile-name"><?php echo $list->activity_log_from_name; ?> </span><?php echo $list->activity_log_message; ?></li>
                            <?php } elseif($list->activity_type_name == 'Users') { ?>
                                <?php
                                    if ($list->activity_label_type == 'Sign In') $icon = 'fa-sign-in';
                                    elseif ($list->activity_label_type == 'Sign Out') $icon = 'fa-sign-out';
                                    elseif ($list->activity_label_type == 'Banned') $icon = 'fa-minus-circle';
                                    elseif ($list->activity_label_type == 'Removed') $icon = 'fa-times-circle';
                                ?>
                                <li><span><i class="fa <?php echo $icon; ?> user-act"></i></span><span class="label user-act-bg label-override"><?php echo $list->activity_type_name; ?></span><span class="profile-name"><?php echo $list->activity_log_from_name; ?> </span><?php echo $list->activity_log_message; ?></li>
                            <?php } elseif ($list->activity_type_name == 'Account') { ?>
                                <li><span><i class="fa fa-pencil account-act"></i></span><span class="label account-act-bg label-override"><?php echo $list->activity_type_name; ?></span><span class="profile-name"><?php echo $list->activity_log_from_name; ?> </span><?php echo $list->activity_log_message; ?></li>
                            <?php } elseif ($list->activity_type_name == 'Sign Up') { ?>
                                <li><span><i class="fa fa-pencil signup-act"></i></span><span class="label signup-act-bg label-override"><?php echo $list->activity_type_name; ?></span><span class="profile-name"><?php echo $list->activity_log_from_name; ?> </span><?php echo $list->activity_log_message; ?></li>
                            <?php } ?>
                        </ul>
                    </td>
                </tr>
                <?php endforeach; ?>
                <!--<tr>
                    <td>
                        <p><strong>Dec 3, 2014</strong></p>
                        <p>Wednessday</p>
                    </td>
                    <td>
                        <ul>
                            <li><span><i class="fa fa-sign-out user-act"></i></span><span class="label user-act-bg label-override">User</span><span class="profile-name">David Thomas</span>Logged out. 11.53am</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>Dec 3, 2014</strong></p>
                        <p>Wednessday</p>
                    </td>
                    <td>
                        <ul>
                            <li><span><i class="fa fa-sign-in user-act"></i></span><span class="label user-act-bg label-override">User</span><span class="profile-name">David Thomas</span>Logged in. 9.09am</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>Dec 3, 2014</strong></p>
                        <p>Wednessday</p>
                    </td>
                    <td>
                        <ul>
                            <li><span><i class="fa fa-cloud note-act"></i></span><span class="label note-act-bg label-override">Note</span><span class="profile-name">David Thomas</span>created note: Visit to Taranga Zoo. 11.53am</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>Dec 3, 2014</strong></p>
                        <p>Wednessday</p>
                    </td>
                    <td>
                        <ul>
                            <li><span><i class="fa fa-pencil signup-act"></i></span><span class="label signup-act-bg label-override">Signup</span><span class="profile-name">South Breeze Jr School</span>signed up for free trial. 11.53am</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>Dec 3, 2014</strong></p>
                        <p>Wednessday</p>
                    </td>
                    <td>
                        <ul>
                            <li><span><i class="fa fa-cloud note-act"></i></span><span class="label note-act-bg label-override">Note</span><span class="profile-name">Larry Thomas</span>replied to note: Visit to Taranga Zoo. 11.53am</li>
                            <li><span><i class="fa fa-cloud note-act"></i></span><span class="label note-act-bg label-override">Note</span><span class="profile-name">David Luis</span>view the note: Visit to Taranga Zoo. 12.53am</li>
                            <li><span><i class="fa fa-cloud note-act"></i></span><span class="label note-act-bg label-override">Note</span><span class="profile-name">Shah Butt</span>replied to note: Visit to Taranga Zoo. 12.59am</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>Dec 3, 2014</strong></p>
                        <p>Wednessday</p>
                    </td>
                    <td>
                        <ul>
                            <li><span><i class="fa fa-pencil signup-act"></i></span><span class="label signup-act-bg label-override">Signup</span><span class="profile-name">South Breeze Jr School</span>signed up $269 Plan. 11.53am</li>
                            <li><span><i class="fa fa-sign-out user-act"></i></span><span class="label user-act-bg label-override">User</span><span class="profile-name">David Thomas</span>Logged out. 11.53am</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>Dec 3, 2014</strong></p>
                        <p>Wednessday</p>
                    </td>
                    <td>
                        <ul>
                            <li><span><i class="fa fa-pencil account-act"></i></span><span class="label account-act-bg label-override">Account</span><span class="profile-name">John Doe</span>changed billing information 11.54am</li>
                            <li><span><i class="fa fa-sign-in user-act"></i></span><span class="label user-act-bg label-override">User</span><span class="profile-name">David Thomas</span>Logged in. 11.53am</li>
                        </ul>
                    </td>
                </tr>-->
            </table>
            <div class="footer-table">
                <div class="pagination">
                    <?php echo $pagination; ?>
                </div>
            </div>
        </div>
        <div class="span4">
            <div class="form-group">
                <label for="User Filter">Show Me</label>
                <select id="class-filter" class="selectpicker">
                    <option selected="selected" >All Activities</option>
                    <option>Signup Activity</option>
                    <option>Account Activity</option>
                    <option>Note Activity</option>
                    <option>User Activity</option>
                </select>
            </div>
            <div class="legend-unit">
                <label for="Legend">Activity Legend</label>
                <ul>
                    <li class="signup-act"><i class="fa fa-circle"></i>Signup Activity</li>
                    <li class="account-act"><i class="fa fa-circle"></i>Account Activity</li>
                    <li class="note-act"><i class="fa fa-circle"></i>Note Activity</li>
                    <li class="user-act"><i class="fa fa-circle"></i>User Activity</li>
                </ul>
            </div>
        </div>
    </div>
</div>