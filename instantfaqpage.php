<?php

header( "Pragma: no-cache" );



/*

Plugin Name: Instant Faq Page
Description: A plugin that allows you to instantly create an FAQ page
Author: Joyel Puryear (http://www.infotechnologist.biz)
Version: 1.0
*/



// Create Database Tables on install

function instantfaqpage_install() {

	global $wpdb;
	$table_name1 = $wpdb->prefix . "questions_answers";

	
	if($wpdb->get_var("show tables like '".$table_name1."'") != $table_name1) {

      

    $sql = "CREATE TABLE " . $table_name1 . " (
	question1 char(225) NOT NULL,
	answer1 char(225) NOT NULL,
	question2 char(225) NOT NULL,
	answer2 char(225) NOT NULL,
	question3 char(225) NOT NULL,
	answer3 char(225) NOT NULL,
	question4 char(225) NOT NULL,
	answer4 char(225) NOT NULL,
	question5 char(225) NOT NULL,
	answer5 char(225) NOT NULL,
	question6 char(225) NOT NULL,
	answer6 char(225) NOT NULL,
	question7 char(225) NOT NULL,
	answer7 char(225) NOT NULL,
	question8 char(225) NOT NULL, 
	answer8 char(225) NOT NULL,
	question9 char(225) NOT NULL,
	answer9 char(225) NOT NULL,
	question10 char(225) NOT NULL,
	answer10 char(225) NOT NULL
	);

	";
      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);

   }

}



// Call to create DB upon activation

register_activation_hook( __FILE__, 'instantfaqpage_install' );



/* Admin Functionality */

add_action('admin_menu', 'instantfaqpage_pluginmenu');



function instantfaqpage_pluginmenu() {

  add_options_page('Instant FAQ Plugin Menu', 'Instant FAQ Plugin Menu', 'manage_options', 'instantfaqpage_customizeqanda', 'instantfaqpage_customizeqanda');

}



function instantfaqpage_customizeqanda() {	

	global $wpdb;

	if (!current_user_can('manage_options'))  {

		wp_die( __('You do not have sufficient permissions to access this page.') );

	}

	// Set form by default

	$show_form = 1;



	// Perform processing.

	if ($_POST['submitted'] == 1) {
		/* Show form 0/1 depending on processing  (if errors show form, if not don't) */

		$show_form = 1;

		$db_data['question1']  = $_POST['question1'];
		$db_data['answer1']   = $_POST['answer1'];
		$db_data['question2']  = $_POST['question2'];
		$db_data['answer2']   = $_POST['answer2'];
		$db_data['question3']  = $_POST['question3'];
		$db_data['answer3']   = $_POST['answer3'];
		$db_data['question4']  = $_POST['question4'];
		$db_data['answer4']   = $_POST['answer4'];
		$db_data['question5']  = $_POST['question5'];
		$db_data['answer5']   = $_POST['answer5'];
		$db_data['question6']  = $_POST['question6'];
		$db_data['answer6']   = $_POST['answer6'];
		$db_data['question7']  = $_POST['question7'];
		$db_data['answer7']   = $_POST['answer7'];
		$db_data['question8']  = $_POST['question8'];
		$db_data['answer8']   = $_POST['answer8'];
		$db_data['question9']  = $_POST['question9'];
		$db_data['answer9']   = $_POST['answer9'];
		$db_data['question10'] = $_POST['question10'];
		$db_data['answer10']  = $_POST['answer10'];
		

		$sql = "DELETE FROM " . $wpdb->prefix . "questions_answers";

		mysql_query($sql);

		

		$sql = "INSERT INTO " . $wpdb->prefix . "questions_answers";

		$paren_string = "(";

		$value_string = "(";

		foreach($db_data as $key => $value) {

			$paren_string .= $key . ", ";

			$value_string .= "'" . $value . "', ";

		}

		$paren_string = substr_replace($paren_string ,"",-2);

		$value_string = substr_replace($value_string, "", -2);

		$paren_string .= ")";

		$value_string .= ")";

		$sql .= $paren_string . " VALUES " . $value_string;
		if (mysql_query($sql)) {
			$show_form = 0;	
		}else {
			$show_form = 1;
		}

	}else {

		$sql   = "SELECT * FROM " . $wpdb->prefix . "questions_answers";

		$query = mysql_query($sql);
		$results = array();

		while ($row = mysql_fetch_array($query)) {
			$results[1]['question']  = $row['question1'];
			$results[1]['answer']    = $row['answer1']; 
			$results[2]['question']  = $row['question2'];
			$results[2]['answer']    = $row['answer2']; 
			$results[3]['question']  = $row['question3'];
			$results[3]['answer']    = $row['answer3']; 
			$results[4]['question']  = $row['question4'];
			$results[4]['answer']    = $row['answer4']; 
			$results[5]['question']  = $row['question5'];
			$results[5]['answer']    = $row['answer5']; 
			$results[6]['question']  = $row['question6'];
			$results[6]['answer']    = $row['answer6']; 
			$results[7]['question']  = $row['question7'];
			$results[7]['answer']    = $row['answer7']; 
			$results[8]['question']  = $row['question8'];
			$results[8]['answer']    = $row['answer8']; 
			$results[9]['question']  = $row['question9'];
			$results[9]['answer']    = $row['answer9']; 
			$results[10]['question'] = $row['question10'];
			$results[10]['answer']   = $row['answer10']; 
		}

	}



	// Display form

	if ($show_form == 1) {

		echo '<span style="color: red;">' . $error . '</span>';

		echo '<div class="wrap">';

		echo '<p>Please use the following form to enter your questions and answers.</p>

		<form name="instantfaqpage" id="instantfaqpage" action="" method="post">
		<fieldset>
			<legend>Frequently Asked Questions</legend>		
		';
		for ($x = 1; $x <= 10; $x++) {
			echo '<label for="question' . $x . '">Question ' . $x . '</label>';
			echo '<input name="question' . $x . '" id="question' . $x . '" type="text" value="' . $results[$x]['question'] . '" /><br />';
			echo '<label for="answer' . $x . '">Answer ' . $x . '</label>';
			echo '<input name="answer' . $x . '" id="answer' . $x . '" type="text" value="' . $results[$x]['answer'] . '" /><br />';
		}
		echo '
		</fieldset>
		<br />
		

		<input name="submit" id="submit" type="submit" value="Update Database" /> 

		<input name="submitted" id="submitted" type="hidden" value="1" />

		</form>';

		echo '</div>';

	}else {

		echo '<span style="color: blue;">The system has been successfully updated.</span>';	

	}

}

/* Setup Filter */
add_filter ('the_content', 'instantfaqpage_filter');

// Add front end filter functions
function instantfaqpage_filter($content) {
	if (preg_match('{instantfaqpage}', $content)) {
		$content = str_replace('{instantfaqpage}', instantfaqpage_page(), $content);
	}
	return $content;
}

// Specify front end includes for filters
function instantfaqpage_page() {
	global $wpdb;
	$sql   = "SELECT * FROM " . $wpdb->prefix . "questions_answers";
	$query = mysql_query($sql);
	$content = '';

	$num = 1;
	$content .= '<dl>';
	while ($row = mysql_fetch_array($query)) {
		if ($row['question1'] != '' && $row['answer1'] != '') {
			$content .= '<dt>' . $row['question1'] . '</dt>';
			$content .= '<dd>' . $row['answer1'] . '</dd>';
		}
		if ($row['question2'] != '' && $row['answer2'] != '') {
			$content .= '<dt>' . $row['question2'] . '</dt>';
			$content .= '<dd>' . $row['answer2'] . '</dd>';	
		}
		if ($row['question3'] != '' && $row['answer3'] != '') {
			$content .= '<dt>' . $row['question3'] . '</dt>';
			$content .= '<dd>' . $row['answer3'] . '</dd>';	
		}
		if ($row['question4'] != '' && $row['answer4'] != '') {
			$content .= '<dt>' . $row['question4'] . '</dt>';
			$content .= '<dd>' . $row['answer4'] . '</dd>';	
		}
		if ($row['question5'] != '' && $row['answer5'] != '') {
			$content .= '<dt>' . $row['question5'] . '</dt>';
			$content .= '<dd>' . $row['answer5'] . '</dd>';	
		}
		if ($row['question6'] != '' && $row['answer6'] != '') {
			$content .= '<dt>' . $row['question6'] . '</dt>';
			$content .= '<dd>' . $row['answer6'] . '</dd>';	
		}
		if ($row['question7'] != '' && $row['answer7'] != '') {
			$content .= '<dt>' . $row['question7'] . '</dt>';
			$content .= '<dd>' . $row['answer7'] . '</dd>';	
		}
		if ($row['question8'] != '' && $row['answer8'] != '') {
			$content .= '<dt>' . $row['question8'] . '</dt>';
			$content .= '<dd>' . $row['answer8'] . '</dd>';	
		}
		if ($row['question9'] != '' && $row['answer9'] != '') {
			$content .= '<dt>' . $row['question9'] . '</dt>';
			$content .= '<dd>' . $row['answer9'] . '</dd>';	
		}
		if ($row['question10'] != '' && $row['answer10'] != '') {
			$content .= '<dt>' . $row['question10'] . '</dt>';
			$content .= '<dd>' . $row['answer10'] . '</dd>';	
		}
	}	
	$content .= '</dl>';
	return $content;
}
?>