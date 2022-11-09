<form>
  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="title">Title</label>
      <input type="text" class="form-control" name="title">
    </div>
  </div>
  <div class="form-group">
    <label for="location">Location</label>
    <input type="text" class="form-control" name="location" placeholder="1234 Main St">
  </div>
  <div class="form-group">
    <label for="description">Description</label>
    <textarea class="form-control" rows="3" name="description"></textarea>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="start_date">Start date</label>
      <input type="date" class="form-control" name="start_date">
    </div>
    <div class="form-group col-md-6">
      <label for="stop_date">Stop date</label>
      <input type="date" class="form-control" name="stop_date">
    </div>
  </div>
  <button type="submit" class="btn btn-primary btn-block">Create Event</button>
</form>