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
                                <div class="user-edit-form">
                                    <form class="form-horizontal" id="access_role_permission" action="<?php echo base_url('/user/permissions'); ?>" name="access_role_permission_form"
                                          method="POST">
                                        <input type="hidden" name="id"  value="<?php echo(set_value('id')) ? set_value('id') : $id;?>" />

                                        <div class="span12">
                                            <div class="cldnt-user-list">
                                                <?php
                                                $possibleroles = array('1' => 'Global Site owner', '2' => 'Admin', '3' => 'Organization Leader', '4' => 'Org Staff', '5' => 'Parents', '6' => 'Students');
                                                $possibleallcaps = array('createnote' => 'Create Note', 'readnote' => 'Read Note', 'editnote' => 'Edit Note', 'deletenote' => 'Delete Note', 'sendnote' => 'Send Note', 'schedulenote' => 'Schedule Note');
                                                //$roles = get_access_capability_box();
                                                $loop = 1;
                                                $navs = '';
                                                $contents = '';
                                                $new_roleaccess[] = array();
                                                foreach ($roles as $rolename => $caps) {

                                                    $role_no = (int)$rolename;
                                                    if($login_user_data->user_access_level < $role_no){
                                                        $navs .= '<li ' . (($loop == 1) ? 'class="active"' : '') . '><a href="#roletab' . $loop . '" data-toggle="tab">' . $possibleroles[$rolename] . '</a></li>';

                                                        $contents .= '<div class="tab-pane ' . (($loop == 1) ? 'active' : '') . '" id="roletab' . $loop . '">';
                                                        $contents .= '<p>Caps for user role: ' . $possibleroles[$rolename] . '</p>';
                                                        $contents .= '<table class="table table-bordered"><thead><tr>';

                                                        foreach ($possibleallcaps as $cap => $v) {
                                                            $contents .= '<th>' . $v . '</th>';
                                                        }

                                                        $contents .= '</tr></thead><tbody><tr>';

                                                        foreach ($possibleallcaps as $cap => $v) {
                                                            $check = "";
                                                            //$new_roleaccess[$rolename][$cap] = $caps[$cap];
                                                            // print_r($new_roleaccess[$rolename][$cap]);
                                                            // $input = '<input style=" width: 96%;" value="' . $caps[$cap] . '" name="' . $rolename . '[' . $cap . ']" />';
                                                          /* if(isset($caps[$cap]) && (int)$caps[$cap] == 1){
                                                            $check ='checked ="checked"';
                                                           }*/
                                                           // $contents .= '<td>' . ((!isset($caps[$cap]) || ($caps[$cap] == '2')) ? 'x' : '<input type="checkbox" class="capability-checkbox"  '.$check.' name="' . $rolename . '[' . $cap . ']" />') . '</td>';
                                                            $contents .= '<td>' . ((!isset($caps[$cap]) || ($caps[$cap] == '2')) ? 'x' : '<input style="width:96%;" value="'.$caps[$cap].'"   name="' . $rolename . '[' . $cap . ']" />') . '</td>';

                                                        }

                                                        $contents .= '</tr></tbody></table>';
                                                        $contents .= '</div>';
                                                        ?>

                                                        <?php
                                                        $loop++;
                                                    } }

                                                ?>
                                                <div id="rolecapsui">
                                                    <div class="tabbable tabs-left">

                                                        <ul class="nav nav-tabs">
                                                            <?php echo $navs; ?>
                                                        </ul>
                                                        <div class="tab-content">
                                                            <?php echo $contents; ?>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <div class="controls">
                                                    <button type="submit"
                                                            class="staff-save btn btn-success">Save Permissions
                                                    </button>

                                                </div>
                                            </div>
                                        </div>
                                    </form>
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
<script>
    $().ready(function(){

        $('input.capability-checkbox').prettyCheckable({
            color: 'red'
        });

    });
</script>