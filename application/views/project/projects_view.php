<?php
/**
 * Customers view to be used to show all customers in an html table.
 * 
 * Show customers and with each customer a link to edit and delete a customer.
 * 
 * @param  $data = array(
 *       'id',
 *       'project_name',
 *       'project_description', 
 *       'project_start_date', 
 *       'project_end_date', 
 *       'customer_id', 
 *       'customer_name', 
 *       'project_type', 
 *       'active'
 *   );
 * @param $data['projects'] All projects in an array.
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['heading'] Heading for the error message.
 * @param $data['error_message'] The error message to be printed.
 * @param $data['start_date'] The start date of the search.
 * @param $data['end_date'] The end date of the search.
 * @param $data['login_user_id'] User's login id (session data)
 * @param $data['login_id'] User's id (session data)
 * 
 * @package opix
 * @category View
 * @author Arto Ruonala, Pipsa Korkiakoski, Antti Aho, Liisa Auer,
 *      Tuukka Kiiskinen, Roni Kokkonen
 */
?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script> $(function() {
        $( ".datepicker" ).datepicker({
            dateFormat: "yy-mm-dd",
            showOtherMonths: true,
            selectOtherMonths: true,
            showAnim: "slideDown"
        });
    });
</script>

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

<h1><?php echo($pagetitle) ?></h1>

<?php echo form_fieldset(); ?>

<h5><?php echo $this->lang->line('title_search_project') ?></h5>
<p class="search_info"><?php echo $this->lang->line('text_search_project') ?></p>
<?php 
echo form_open("project/find");

echo form_label('<p><span class="label label-success">Start Date: </span></p>',$this->lang->line('label_start_date'), 'dtm_start_date');

$data = array(
    'name' => 'dtm_start_date',
    'class' => 'datepicker',
    'value' => set_value('dtm_start_date', $start_date),
    'maxlength' => '10',
    'size' => '10',
    'type' => 'date',
    'class' => "form-control"
);

echo form_input($data);
echo form_error('dtm_start_date');
echo br(1);

echo form_label('<p><span class="label label-success">End Date: </span></p>',$this->lang->line('label_end_date'), 'dtm_end_date');

$data = array(
    'name' => 'dtm_end_date',
    'class' => 'datepicker',
    'value' => set_value('dtm_end_date', $end_date),
    'maxlength' => '10',
    'size' => '10',
    'type' => 'date',
    'class' => "form-control"
);

echo form_input($data);
echo form_error('dtm_end_date');
echo br(1);

echo form_submit('btn_submit', $this->lang->line('button_search'), 'class="btn btn-primary"');
echo ' ';
echo '<input type="button" class="btn btn-warning" value="' . $this->lang->line('button_reset') .
            '" onclick="location.href=' . "'".base_url() .
            'index.php/project/clear' . "'" . '" />';
echo anchor('project', $this->lang->line('link_all'), 'class="returnlink"');

echo form_close();
echo form_fieldset_close();
?>

<p><br />
<?php echo anchor('project/add', $this->lang->line('link_insert_project')) . ' ';  
?>
</p>
<div class="table-responsive">
<table class="table table-striped table-condensed">
    <thead>
        <tr class="success">
            <?php
            echo '<th style="width: 250px">' . $this->lang->line('label_project_name') . '</th>';
            echo '<th>' . $this->lang->line('label_project_type') . '</th>';
            echo '<th>' . $this->lang->line('label_customer_name') . '</th>';
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
                echo '<td>' . Project::toString($project->project_type) . '</td>';
                echo '<td>' . $project->customer_name . '</td>';
                echo '<td>' . Project::toString2($project->active) . '</td>';
                echo '<td>' . anchor('project/edit/' . $project->id, 
                       '<span class="glyphicon glyphicon-edit"></span>') . '</td>';
                echo '<td>';
                    echo form_open('project/delete');
                    echo form_hidden('txt_id', set_value('id', $project->id));
                    echo '<span class="glyphicon glyphicon-remove-circle" <input onclick="return deleteconfirm();" /></span>';
                    echo form_close();
                echo '</td>';
                echo '<td>' . anchor('project_staff/index/' . $project->id, 
                        $this->lang->line('link_project_staff')) . '</td>';
                
                if (Project::toString($project->project_type) == "Scrum")
                {
                   echo '<td>' . anchor('product_backlog/index/' . $project->id, 
                        $this->lang->line('link_product_backlog')) . '</td>';
                }
                
                else if (Project::toString($project->project_type) != 'Scrum') {                
                    echo '<td>' . anchor('project_period/index/' . $project->id, 
                            $this->lang->line('link_project_period')) . '</td>';       
                }
                
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

<?php 
// printing the error message if exists
if ($error_message != '')
{
    echo '<h4>' . $heading . '</h4>';
    echo '<p>' . $error_message . '</p>';
}
?>