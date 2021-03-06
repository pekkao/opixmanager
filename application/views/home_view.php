<?php
/**
 * Show the home page of a user
 * 
 * Shows user's projects and links to edit password and personal data
 * 
 * @param  $data = array(
 *       'project_id',
 *       'person_id',
 *       'project_name',
 *       'project_description',
 *       'surname',
 *       'firstname',
 *       'role_name',
 *       'id',
 *       'start_date',
 *       'end_date',
 *       'can_edit_project_data'
 *   );
 * 
 * @param $data['projects'] Users projects in an array.
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['heading'] Heading for the error message.
 * @param $data['error_message'] The error message to be printed.
 * @param $data['login_user_id'] User's login id (session data)
 * @param $data['login_id'] User's id (session data)
 * 
 * @package opix
 * @category View
 * @author Tuukka Kiiskinen, Roni Kokkonen, Liisa Auer
 */
?>

<script type="text/javascript">
       $(document).ready(function() {
        //If Javascript is running, change css on product-description to display:block
        //then hide the div, ready to animate
        $("div.pop-up-project").css({'display':'block','opacity':'0'})
      });
      
      $(document).ready(function() {
        $("a.trigger").hover(
          function () {
            $(this).prev().stop().animate({
              opacity: 1
            }, 500);
          },
          function () {
            $(this).prev().stop().animate({
              opacity: 0
            }, 200);
          }
        )
      });
       function deleteconfirm()
    {
        var answer = confirm("Are you sure you want to delete?")
        if (answer){
            document.messages.submit();
        }
        return false;  
    }
</script>

<h1><?php echo $pagetitle . $login_user_id ?></h1>

<h4><?php echo $this->lang->line('title_my_projects')  ?> </h4>
<div class="table-responsive">
    <table class="table table-striped table-condensed">
    <thead>
        <tr class="success">
            <?php
            echo '<th style="width: 200px;">' . $this->lang->line('label_project_name') . '</th>';
            echo '<th>' . $this->lang->line('label_project_type') . '</th>';
            echo '<th>' . $this->lang->line('label_active') . '</th>';  
            echo '<th colspan="8"></th>';
            ?>
        </tr>
    </thead>
    <tbody>
        <?php    
        if (isset($projects)) {
            foreach ($projects as $project) { 
                
                echo '<tr>';
                echo '<td>' . $project->project_name . '</td>';
                echo '<td>' . Home::toString2($project->project_type) . '</td>';
                echo '<td>' . Home::toString3($project->active) . '</td>';
                
                
                echo '<td>';
                if ($project->can_edit_project_data == true || 
                        ($this->session->userdata('account_type') == 1))
                {
                    echo anchor('project/edit/' . $project->project_id, 
                       '<span class="glyphicon glyphicon-edit"></span>');
                }
                echo '</td>';
                
                echo '<td>';
                // only admin user can delete project
                if ($this->session->userdata('account_type') == 1)
                {
                    echo form_open('project/delete');
                    echo form_hidden('txt_id', set_value('id', $project->project_id));
                    echo '<span class="glyphicon glyphicon-remove-circle" <input onclick="return deleteconfirm();"></span>';
                    echo form_close();
                }
                echo '</td>';
                
                echo '<td>' . anchor('project_staff/index/' . $project->project_id, 
                        $this->lang->line('link_project_staff')) . '</td>';
                
                if (Home::toString2($project->project_type) == "Scrum")
                {
                   echo '<td>' . anchor('product_backlog/index/' . $project->project_id, 
                        $this->lang->line('link_product_backlog')) . '</td>';
                }
                
                else if (Home::toString2($project->project_type) != 'Scrum') {                
                    echo '<td>' . anchor('project_period/index/' . $project->project_id, 
                            $this->lang->line('link_project_period')) . '</td>';       
                }
                
                echo '<td>' . anchor('#',  $this->lang->line('link_work_hours')) . '</td>';
                
//                echo '<td><div class="pop-up-project">';
//                    echo 
//                         $this->lang->line('label_customer_name') . ': ' . $project->customer_name . ' ' . '<br>' .
//                         $this->lang->line('label_project_description') . ': ' . $project->project_description . ' ' . '<br>' .
//                         $project->project_start_date . ' - ' .
//                         $project->project_end_date;      
//                echo '</div>'; 
//                echo '<a href="#" class="trigger">' . img('img/information.jpg') . '</a>';
//                echo '</td>';
                                echo '<td><div class="pop-up-project">';
                    echo 
                      
                         $this->lang->line('label_project_description') . ': ' . $project->project_description . ' ' . '</br>' .
                         $project->project_start_date . ' - ' .
                         $project->project_end_date;      
                echo '</div>'; 
                echo '<a href="#" class="trigger">' . img('img/information.jpg') . '</a>';
                echo '</td>';
                echo '</tr>';               
            }
        }
        ?>
    </tbody>
</table>
</div>

<h4><?php echo $this->lang->line('title_my_data')  ?> </h4>

<p><?php echo anchor('person/edit/' . $login_id,
        $this->lang->line('link_edit_profile')); ?></p>

<p><?php echo anchor('person/edit_password/' . $login_id, 
        $this->lang->line('link_change_password')); ?>
</p>

<?php 
if ($error_message != '')
{
    echo '<h4>' . $heading . '</h4>';
    echo '<p>' . $error_message . '</p>';
}
?>