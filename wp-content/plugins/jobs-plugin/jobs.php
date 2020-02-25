<?php
  /**
  *  Plugin Name: Job board Plugin
  *  Description: My Jobs plugin!
  *  Author: Prerak Patel
  *
  */
//StAuth10127: I Prerak Patel, 000825410 certify that this material is my original work. No other person's work has been used without due acknowledgement. I have not made my work available to anyone else.

  function myplugin_activate() {
     global $wpdb;
     $wpdb->query("CREATE TABLE Jobs (
        Job_ID int NOT NULL AUTO_INCREMENT,
        Job_Position varchar(255) NOT NULL,
		Job_Type VARCHAR(30) NOT NULL,
		Job_Email VARCHAR(50) NOT NULL,
		Job_Description longtext,
		Job_Wage decimal(3,2) NOT NULL,
		Job_Posting_Date datetime NOT NULL,
        PRIMARY KEY(Job_ID)
      );");
    }
  register_activation_hook( __FILE__,
                          'myplugin_activate' );

  function myplugin_deactivate() 
  {
    global $wpdb;
    $wpdb->query("DELETE FROM Jobs;");
  }
  register_deactivation_hook( __FILE__,
                             'myplugin_deactivate' );

  function wporg_shortcode($atts = [], $content = null){
   global $wpdb;
   
    if(isset($atts[0]))
    {
      if(is_numeric($atts[0]))
      {

        if(isset($atts[1]))
        {
          if(is_string($atts[1]))
          {
            if($atts[1] == "full")
            {
              $query = $wpdb->prepare("SELECT Job_Position,Job_Type,Job_Email,Job_Wage,Job_Posting_Date,Job_Description FROM Jobs WHERE Job_Wage >= %d AND Job_Type LIKE 'Full%' ",$atts[0]);
              $results = $wpdb->get_results($query);
              $finalString = '<h2>'.count($results).' results</h2>';

              foreach ($results as $value) 
              {
                $finalString .= '<div id="viewJob"><h4>'. $value->Job_Position . '</h4><h6><span>' . $value->Job_Type ."   |   ".$value->Job_Email ."   |   $". $value->Job_Wage ."   |   Posted on ". $value->Job_Posting_Date .'</span></h6><p>'. $value->Job_Description  . '</p></div>';
              }
              return $finalString;
            }
            elseif ($atts[1] == "part") 
            {
              $query = $wpdb->prepare("SELECT Job_Position,Job_Type,Job_Email,Job_Wage,Job_Posting_Date,Job_Description FROM Jobs WHERE Job_Wage >= %d AND Job_Type LIKE 'Part%' ",$atts[0]);
              $results = $wpdb->get_results($query);
              $finalString = '<h2>'.count($results).' results</h2>';

              foreach ($results as $value) 
              {
                $finalString .= '<div id="viewJob"><h4>'. $value->Job_Position . '</h4><h6><span>' . $value->Job_Type ."   |   ".$value->Job_Email ."   |   $". $value->Job_Wage ."   |   Posted on ". $value->Job_Posting_Date .'</span></h6><p>'. $value->Job_Description  . '</p></div>';
              }
              return $finalString;
            }
            elseif ($atts[1] == "contract") 
            {
              $query = $wpdb->prepare("SELECT Job_Position,Job_Type,Job_Email,Job_Wage,Job_Posting_Date,Job_Description FROM Jobs WHERE Job_Wage >= %d AND Job_Type LIKE 'Contract%' ",$atts[0]);
              $results = $wpdb->get_results($query);
              $finalString = '<h2>'.count($results).' results</h2>';

              foreach ($results as $value) 
              {
                $finalString .= '<div id="viewJob"><h4>'. $value->Job_Position . '</h4><h6><span>' . $value->Job_Type ."   |   ".$value->Job_Email ."   |   $". $value->Job_Wage ."   |   Posted on ". $value->Job_Posting_Date .'</span></h6><p>'. $value->Job_Description  . '</p></div>';
              }
              return $finalString;
            }

          }
        }
        else
        {
          $query = $wpdb->prepare("SELECT Job_Position,Job_Type,Job_Email,Job_Wage,Job_Posting_Date,Job_Description FROM Jobs WHERE Job_Wage >= %d",$atts[0]);
          $results = $wpdb->get_results($query);
          $finalString = '<h2>'.count($results).' results</h2>';

          foreach ($results as $value) 
          {
            $finalString .= '<div id="viewJob"><h4>'. $value->Job_Position . '</h4><h6><span>' . $value->Job_Type ."   |   ".$value->Job_Email ."   |   $". $value->Job_Wage ."   |   Posted on ". $value->Job_Posting_Date .'</span></h6><p>'. $value->Job_Description  . '</p></div>';
          }
          return $finalString;

        }
      }

      elseif (is_string($atts[0]))
      {

        if ($atts[0] == "full") 
        {
          	$query = $wpdb->prepare("SELECT Job_Position,Job_Type,Job_Email,Job_Wage,Job_Posting_Date,Job_Description FROM Jobs WHERE Job_Type LIKE 'Full%' ",$atts[0]);
          	$results = $wpdb->get_results($query);
          	$finalString = '<h2>'.count($results).' results</h2>';

          	foreach ($results as $value) 
          	{
          		$finalString .= '<div id="viewJob"><h4>'. $value->Job_Position . '</h4><h6><span>' . $value->Job_Type ."   |   ".$value->Job_Email ."   |   $". $value->Job_Wage ."   |   Posted on ". $value->Job_Posting_Date .'</span></h6><p>'. $value->Job_Description  . '</p></div>';
          	}
        	return $finalString;
        }
        elseif ($atts[0] == "part") 
        {
          	$query = $wpdb->prepare("SELECT Job_Position,Job_Type,Job_Email,Job_Wage,Job_Posting_Date,Job_Description FROM Jobs WHERE Job_Type LIKE 'Part%' ",$atts[0]);
          	$results = $wpdb->get_results($query);
          	$finalString = '<h2>'.count($results).' results</h2>';

          	foreach ($results as $value) 
        	{
          		$finalString .= '<div id="viewJob"><h4>'. $value->Job_Position . '</h4><h6><span>' . $value->Job_Type ."   |   ".$value->Job_Email ."   |   $". $value->Job_Wage ."   |   Posted on ". $value->Job_Posting_Date .'</span></h6><p>'. $value->Job_Description  . '</p></div>';
        	}
        	return $finalString;
        }
        elseif ($atts[0] == "contract") 
        {
          	$query = $wpdb->prepare("SELECT Job_Position,Job_Type,Job_Email,Job_Wage,Job_Posting_Date,Job_Description FROM Jobs WHERE Job_Type LIKE 'Contract%' ",$atts[0]);
          	$results = $wpdb->get_results($query);
          	$finalString = '<h2>'.count($results).' results</h2>';

          	foreach ($results as $value) 
        	{
          		$finalString .= '<div id="viewJob"><h4>'. $value->Job_Position . '</h4><h6><span>' . $value->Job_Type ."   |   ".$value->Job_Email ."   |   $". $value->Job_Wage ."   |   Posted on ". $value->Job_Posting_Date .'</span></h6><p>'. $value->Job_Description  . '</p></div>';
        	}
        	return $finalString;
        }
      }
    }
    else 
    {
     	$query_full = $wpdb->prepare("SELECT Job_Position,Job_Type,Job_Email,Job_Wage,Job_Posting_Date,Job_Description FROM Jobs WHERE Job_Type LIKE 'Full%' ");
      	$results = $wpdb->get_results($query_full);
      	$finalString = '<h2>'.count($results).' results</h2>';

      	foreach ($results as $value) 
      	{
        	$finalString .= '<div id="viewJob" style="background-color: #d9ffcc"><h4>'. $value->Job_Position . '</h4><h6><span>' . $value->Job_Type ."   |   ".$value->Job_Email ."   |   $". $value->Job_Wage ."   |   Posted on ". $value->Job_Posting_Date .'</span></h6><p>'. $value->Job_Description  . '</p></div>';
      	}

      $query_part = $wpdb->prepare("SELECT Job_Position,Job_Type,Job_Email,Job_Wage,Job_Posting_Date,Job_Description FROM Jobs WHERE Job_Type LIKE 'part%' ");
      $results = $wpdb->get_results($query_part);
      $finalString .= '<h2>'.count($results).' results</h2>';

      foreach ($results as $value) 
      {
        $finalString .= '<div id="viewJob" style="background-color: #f9ffcc"><h4>'. $value->Job_Position . '</h4><h6><span>' . $value->Job_Type ."   |   ".$value->Job_Email ."   |   $". $value->Job_Wage ."   |   Posted on ". $value->Job_Posting_Date .'</span></h6><p>'. $value->Job_Description  . '</p></div>';
      }


      $query_contracts = $wpdb->prepare("SELECT Job_Position,Job_Type,Job_Email,Job_Wage,Job_Posting_Date,Job_Description FROM Jobs WHERE Job_Type LIKE 'contract%' ");
      $results = $wpdb->get_results($query_contracts);
      $finalString .= '<h2>'.count($results).' results</h2>';

      foreach ($results as $value) 
      {
        $finalString .= '<div id="viewJob" style="background-color: #ffbab8"><h4>'. $value->Job_Position . '</h4><h6><span>' . $value->Job_Type ."   |   ".$value->Job_Email ."   |   $". $value->Job_Wage ."   |   Posted on ". $value->Job_Posting_Date .'</span></h6><p>'. $value->Job_Description  . '</p></div>';
      }
      return $finalString;
    }
  }
  add_shortcode('jobs', 'wporg_shortcode');


  function wp_jobs_adminpage_html() 
  {
    global $wpdb;
   	// check user capabilities
   	if ( ! current_user_can( 'manage_options' ) ) 
   	{
     return;
 	}

    if (isset($_POST['create'])) 
    {
    	$wpdb->query("INSERT INTO $table_name(name,email) VALUES('$name','$email')");
	  	$job_position = $_POST['Job_Position'];
	  	$job_type = $_POST['Job_Type'];
	  	$job_email = $_POST['Job_Email'];
	  	$job_description = $_POST['Job_Description'];
	  	$job_wage = $_POST['Job_Wage'];
	  	$job_posting_date = $_POST['Job_Posting_Date'];

        $wpdb->query("INSERT INTO `jobs` (`Job_ID`, `Job_Position`, `Job_Type`, `Job_Email`, `Job_Description`, `Job_Wage`, `Job_Posting_Date`) VALUES (NULL, '$job_position', '$job_type', '$job_email', '$job_description', '$job_wage', '$job_posting_date')");

    }

   	if (isset($_POST['edit'])) 
   	{
    	$edit_id = filter_input(INPUT_GET, "editNumber");
    	?>

     	<div class="wrap">
      		<h2>Edit Job Dashboard</h2>
      		<table class="wp-list-table widefat striped">
        		<thead>
          			<tr>
		                <th width='20%'>Job Position</th>
		                <th width='10%'>Job Type</th>
		                <th width='10%'>Job Email</th>
		                <th width='10%'>Job Hourly Wage</th>
		                <th width='30%'>Job Description</th>
		                <th width='10%'>Job Posting Date</th>
		                <th width='10%'>Action</th>
              		</tr>
        		</thead>
        		<tbody>
    				<?php

    					$editJob = $wpdb->get_results($wpdb->prepare("SELECT Job_Position,Job_Type,Job_Email,Job_Wage,Job_Description,Job_Posting_Date FROM Jobs WHERE Job_ID = %d ", $edit_id));

   						echo "<form method='post' action=''>
					            <td><input style='width: 100%' id='Job_Position' name='Updated_Job_Position'type='text' maxlength='255' value='" . $editJob[0]->Job_Position . "' required /></td>
					            <td><select style='width: 100%' id='Job_Type' name='Updated_Job_Type'>
										<option value='Full-time'>Full-time</option>
										<option value='Part-time'selected >Part-time</option>
										<option value='Contract'>Contract</option>
					    			</select>
					    		</td>
					    		<td><input style='width: 100%' id='Job_Email' name='Updated_Job_Email' type='email' maxlength='255' value='" . $editJob[0]->Job_Email . "'required /></td>
					    		<td><input style='width: 100%' id='Job_Wage' name='Updated_Job_Wage'size='10' value='" . $editJob[0]->Job_Wage . "' type='number' /></td>
					    		<td><textarea style='width: 100%' id='Job_Description' name='Updated_Job_Description' required> ".$editJob[0]->Job_Description."</textarea></td>
					    		<td><input style='width: 100%' type='date' id = 'Job_Posting_Date' name='Updated_Job_Posting_Date' value='" . $editJob[0]->Job_Posting_Date . "'></td>
					            <td><button style='width: 100%' id='newupdate' name='newupdate' type='submit'>Update</button></td>
    						</form>";
    				?>

				</tbody>
			</table>
		</div>
    <?php
  	}

  if (isset($_POST['newupdate'])) 
  {
  	$update_id = filter_input(INPUT_GET, "editNumber");
  	$updated_job_position = $_POST['Updated_Job_Position'];
    $updated_job_type = $_POST['Updated_Job_Type'];
	$updated_job_email = $_POST['Updated_Job_Email'];
	$updated_job_description = $_POST['Updated_Job_Description'];
	$updated_job_wage = $_POST['Updated_Job_Wage'];
	$updated_job_posting_date = $_POST['Updated_Job_Posting_Date'];

	$wpdb->query("UPDATE `jobs` SET `Job_Position`='$updated_job_position', `Job_Type`= '$updated_job_type', `Job_Email`='$updated_job_email', `Job_Description`='$updated_job_description', `Job_Wage`='$updated_job_wage', `Job_Posting_Date`='$updated_job_posting_date' WHERE `Job_ID`='$update_id'");
  }

  if (isset($_POST['del'])) 
  {
    $del_id = filter_input(INPUT_GET,"delNumber");
    $wpdb->query("DELETE FROM Jobs WHERE Job_ID='$del_id'");
  }

   ?>

   <div class="wrap">
      <h2>Jobs Dashboard</h2>
      <table class="wp-list-table widefat striped">
        <thead>
          <tr>
            <th width='20%'>Job Position</th>
            <th width='10%'>Job Type</th>
            <th width='10%'>Job Email</th>
            <th width='10%'>Job Hourly Wage</th>
            <th width='30%'>Job Description</th>
            <th width='10%'>Job Posting Date</th>
            <th width='10%'>Action</th>
          </tr>
        </thead>
        <tbody>

	        <form method="post" action="">
	            <td><input id="Job_Position" name="Job_Position" style="width: 100%" type="text" maxlength="255" value="" required/></td>
	            <td><select style="width: 100%" id="Job_Type" name="Job_Type"> 
						<option value="1" >Full-time</option>
						<option value="2" >Part-time</option>
						<option value="3" >Contract</option>

	    			</select>
	    		</td>
	    		<td><input id="Job_Email" name="Job_Email" style="width: 100%" type="email" maxlength="255" value="" required /></td>
	    		<td><input id="Job_Wage" name="Job_Wage" style="width: 100%" size="10" value="" type="number" min="1"/></td>
	    		<td><textarea id="Job_Description" name="Job_Description" style="width: 100%" required></textarea></td>
	    		<td><input type="date" id = "Job_Posting_Date" name="Job_Posting_Date" style="width: 100%"></td>
	            <td><button id="create" name="create" type="submit" style="width: 100%">Create</button></td>
	    	</form>

	          
	        <?php

	            $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM Jobs"));
	        
	          foreach ($results as $print) 
	          {
	            echo "
	              <tr>
	                <td>$print->Job_Position</td>
	                <td>$print->Job_Type</td>
	                <td>$print->Job_Email</td>
	                <td>$print->Job_Wage</td>
	                <td>$print->Job_Description</td>
	                <td>$print->Job_Posting_Date</td>
	                <td><form action='admin.php?page=jobs&amp;editNumber=$print->Job_ID' method='post'><input type='submit' name = 'edit' value='Edit'> </form>
	                <form action='admin.php?page=jobs&amp;delNumber=$print->Job_ID' method='post'><input type='submit' name = 'del' value='Delete'> </form></td>
	              </tr>";
	          }
	          ?>
          </tbody>
      </table>
  	</div>
  <?php
}
	
function wp_jobs_adminpage() 
{
     add_menu_page(
       'Jobs',
       'Jobs',
       'manage_options',
       'jobs',
       'wp_jobs_adminpage_html',
       '', // could give a custom icon here
       20
     );
}

add_action( 'admin_menu', 'wp_jobs_adminpage' );

function myplugin_uninstall() 
{
	global $wpdb;
  	$wpdb->query("DROP TABLE IF EXISTS Jobs;");
}
register_uninstall_hook( __FILE__,
                             'myplugin_uninstall' );
