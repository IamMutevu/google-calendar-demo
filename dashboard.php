<?php
include 'session_head.php';
include 'inc/header.php';
include 'classes/DatabaseConnection.php';

$connection = DatabaseConnection::connect();
$query = $connection->prepare("SELECT user_access_tokens.access_token FROM user_access_tokens WHERE user_id = ?");
$query->execute(array($user_id));
$access_token_record = $query->fetch(PDO::FETCH_OBJ);
// if($access_token_record){
//     echo json_encode($access_token_record->access_token);
// }

$access_token = json_decode($access_token_record->access_token);
// echo $access_token->refresh_token;


?>
    <div class="row d-flex justify-content-center">
        <div class="col-md-8 mt-5">
            <h3 class="text-center pb-2">Welcome to your dashboard <?=$username?></h3>
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Events</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">New Event</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-contact-tab" data-toggle="pill" data-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Integration</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <?
                                include 'events.php';
                            ?>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <?
                                include 'new_event.php';
                            ?>
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                            <div class="card-body">
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
                                    <p class="lead">
                                        Your Gmail account is already integrated
                                        <a href="#" class="btn btn-primary btn-block mt-4">Remove integration</a>
                                    </p>
                                <?
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a class="btn btn-outline-secondary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    -->
  </body>
</html>