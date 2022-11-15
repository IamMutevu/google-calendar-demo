<?php
include 'classes/GoogleCloudApi.php';

if(strtotime($_POST['start_date']) > strtotime($_POST['stop_date'])){
    header('Location: dashboard.php?error=Start date cannot be greater than stop date');
}

$event_details = array(
    'title' => $_POST['title'],
    'location' => $_POST['location'],
    'description' => $_POST['description'],
    'start_date' => $_POST['start_date'],
    'stop_date' => $_POST['stop_date'],
    'attendee' => $_POST['attendee'],
);

$apiObject = new GoogleCloudApi();
$apiObject->addEvent($_POST['access_token'], $event_details);

