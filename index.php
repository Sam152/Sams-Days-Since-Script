<?php

// The database class.
include("Database.class.php");

// The config file
include("config.php");

// Connect to the database.
$database = new Database(array(
	'host' => $db_host,
	'user' => $db_user,
	'password' => $db_password,
	'database' => $db_name
));

// Some public config flags
$config = array(
	'accept_new_events' => TRUE,
	'auth_enabled' => TRUE
);

// If the user has posted the form.
if(isset($_POST['create_new_time'])){

	// A simple honeypot
	if($_POST['website'] !== ''){
		die('Honeypot failed.');
	}

	if($config['auth_enabled'] && $_POST['password'] !== $submit_password){
		die('Password wrong.');
	}

	// Get the submitted timestamp.
	$timestamp = strtotime($_POST['event_time']);

	if(!$timestamp){
		die('Unable to read time format.');
	}

	// Ensure we have entered an event name.
	if(!isset($_POST['event_name']) || trim($_POST['event_name']) == ''){
		die('Missing event name');
	}

	// Get a human representation of what the date was parsed as.
	$parsed_as = date('l jS \of F Y h:i:s A', $timestamp);

	// Insert the row into the DB.
	$database->query(
		"INSERT into `events`
			(
				`name`,
				`timestamp`,
				`ip`
			) VALUES(
				':name',
				':timestamp',
				':ip'
			)",
		array(
			':name' => $_POST['event_name'],
			':timestamp' => $timestamp,
			':ip' => $_SERVER['REMOTE_ADDR']
		)
	);


}

?>


<!doctype html>
<html>
	<head>
		<title>Days Since an Event</title>
		<meta name="description" content="Count the number of days since an event.">
		<meta name="author" content="Sam152">

		<script type="text/javascript">
			<? foreach($config as $name => $value): ?>
				var <?=$name; ?> = <?=$value ? 'true' : 'false'; ?>;
			<? endforeach ?>
		</script>

		<link rel="stylesheet" href="style.css">
		<script type="text/javascript" src="app.js"></script>

	</head>
	<body>

		<form method="post" id="create">

			<input <?=!$config['accept_new_events'] ? 'disabled' : ''; ?> type="text" name="event_time" placeholder="Time of event">
			was the last time  
			<input <?=!$config['accept_new_events'] ? 'disabled' : ''; ?> type="text" maxlength="200" name="event_name" placeholder="Name of Event">
			<input <?=!$config['accept_new_events'] ? 'disabled' : ''; ?> type="text" name="website" placeholder="website">
			<input <?=!$config['accept_new_events'] ? 'disabled' : ''; ?> type="submit" name="create_new_time" value="submit">
			<input <?=!$config['accept_new_events'] ? 'disabled' : ''; ?> type="hidden" name="password" value="false">
		</form>

	</body>
</html>