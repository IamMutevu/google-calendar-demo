<form action="add_event.php" method="POST">
    <input type="hidden" name="code" value="<?=gettype($access_token)?>">
    <input type="hidden" name="access_token" value="<?=$access_token->refresh_token?>">
    <input type="hidden" name="user_id" value="<?=$user_id?>">
  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="title">Title</label>
      <input type="text" class="form-control" name="title" required>
    </div>
  </div>
  <div class="form-group">
    <label for="location">Location</label>
    <input type="text" class="form-control" name="location" placeholder="1234 Main St" required>
  </div>
  <div class="form-group">
    <label for="description">Description</label>
    <textarea class="form-control" rows="3" name="description" required></textarea>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="start_date">Start date</label>
      <input type="datetime-local" class="form-control" name="start_date" required>
    </div>
    <div class="form-group col-md-6">
      <label for="stop_date">Stop date</label>
      <input type="datetime-local" class="form-control" name="stop_date" required>
    </div>
  </div>
  
  <?
    if(!$access_token_record){
    ?>
    <p class="lead">
    To allow this app to integrate with your Google Calendar, you need to log in using your Gmail account
    </p>

    <?
    if (isset($_GET['access_token'])){
    ?>
    <p>
    <strong>ACCESS TOKEN: </strong><?=$_GET['access_token']?>
    </p>
    <?
    }
    ?>

    <a href="authenticate.php?" class="btn btn-primary btn-block">Integrate</a>
    <?
    }
    else{
    ?>     
    <button type="submit" class="btn btn-primary btn-block">Create Event</button>
    <?
    }
    ?>
</form>