<?php
include 'classes/GoogleCloudApi.php';

$user_id = $_GET['u_id'];
$refresh_token = $_GET['r_tkn'];

try {
    $apiObject = new GoogleCloudApi();

    $apiObject->deleteStoredAccessToken($user_id, $refresh_token);
    header('Location: dashboard.php?success=Token revoked successfully');
} catch (\Throwable $th) {
    header('Location: dashboard.php?error=An error occurred');
}

