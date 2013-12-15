<?php
/**
 * Customers view to be used to show all customers in an html table.
 * 
 * Show customers and with each customer a link to edit and delete a customer.
 * 
 * @param  $data = array(
 *       'id' => '',
 *       'project_name' => '',
 *       'project_description' => '',
 *       'project_start_date' => '',
 *       'project_end_date' => '',
 *       'type_id' => '',
 *       'customer_id' => '',
 *       'type_name' => '',
 *       'customer_name' => ''
 *   );
 * @param $data['projects'] All projects in an array.
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['heading'] Heading for the error message.
 * @param $data['error_message'] The error message to be printed.
 * @param $data['start_date'] The start date of the search.
 * @param $data['end_date'] The end date of the search.
 * 
 * @package opix
 * @category View
 * @author Arto Ruonala, Pipsa Korkiakoski, Antti Aho, Liisa Auer
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

<h1>
    <?php echo $pagetitle ?>
</h1>

<table>
    <thead>
        <tr>
            <?php
            echo '<th style="width: 250px">' . $this->lang->line('label_project_name') . '</th>';
            #echo '<th>' . $this->lang->line('label_project_description') . '</th>';
            #echo '<th>' . $this->lang->line('label_project_start_date') . '</th>';
            #echo '<th>' . $this->lang->line('label_project_end_date') . '</th>';
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
                #echo '<td>' . $project->project_description . '</td>';
                #echo '<td>' . $project->project_start_date . '</td>';
                #echo '<td>' . $project->project_end_date . '</td>';
                echo '<td>' . Person::toString2($project->project_type) . '</td>';
                echo '<td>' . $project->customer_name . '</td>';
                echo '<td>' . Person::toString3($project->active) . '</td>';
                echo '<td>' . anchor('project/edit/' . $project->project_id, 
                        $this->lang->line('link_edit')) . '</td>';
                echo '<td>';
                    echo form_open('project/delete');
                    echo form_hidden('txt_id', set_value('id', $project->project_id));
                    echo '<input type="submit" value="X" onclick="return deleteconfirm();" />';
                    echo form_close();
                echo '</td>';
                echo '<td>' . anchor('project_staff/index/' . $project->project_id, 
                        $this->lang->line('link_project_staff')) . '</td>';
                
                if (Person::toString2($project->project_type) == "Scrum")
                {
                   echo '<td>' . anchor('product_backlog/index/' . $project->project_id, 
                        $this->lang->line('link_product_backlog')) . '</td>';
                }
                
                else if (Person::toString2($project->project_type) != 'Scrum') {                
                    echo '<td>' . anchor('project_period/index/' . $project->project_id, 
                            $this->lang->line('link_project_period')) . '</td>';       
                }
                
                echo '<td><div class="pop-up-project">';
                    echo 
                         $this->lang->line('label_project_description') . ': ' . $project->project_description . ' ' . '</br>' .
                         $project->project_start_date . ' - ' .
                         $project->project_end_date;      
                echo '</div>'; 
                echo '<a href="#" class="trigger">' . img('application/img/information.jpg') . '</a>';
                echo '</td>';
                echo '</tr>';               
            }
        }
        ?>
    </tbody>
</table>

<?php 
// printing the error message if exists
if ($error_message != '')
{
    echo '<h4>' . $heading . '</h4>';
    echo '<p>' . $error_message . '</p>';
}
?>