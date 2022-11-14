<?php
include 'classes/GoogleCloudApi.php';

$apiObject = new GoogleCloudApi();
$events = $apiObject->getEvents($access_token->refresh_token);

foreach($events as $event){
?>
<div class="card mt-2">
  <div class="card-body">
    <p class="lead"><?=$event->summary?></p>
    <p><strong>Description: </strong><?=$event->description?></p>
    <p><strong>Start: </strong><?=$event->start->dateTime?></p>
    <p><strong>Stop: </strong><?=$event->end->dateTime?></p>
    <p>
      <strong>Attendees: </strong>
      <?php
        foreach($event->attendees as $key => $attendee){
      ?>
        <?=$attendee->displayName?><small>(<?=$attendee->email?>)</small> <?if(count($event->attendees)>1 && ($key-1) != count($event->attendees)){?> | <?}?>
      <?php
        }
      ?>
    </p>
  </div>
</div>

<?
}
?>

