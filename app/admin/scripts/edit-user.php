<?php
$user = new \App\User\User();

if (!isset($_GET["username"]) || !$user = $userStorage->fetchByUsername($_GET["username"])) {
    header("LOCATION: ?mod=admin&a=users");
    exit;
}

$user_get = trim($_GET["username"]);


$errors = array();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $user->setUsername($user_get);

    if (empty($_POST["quota"])) {
        $errors["quota"] = "Veuillez indiquer un quota.";
    } else {
        $user->setQuota(trim((int)$_POST["quota"]));
    }
    if (empty($errors)) {
        $userStorage->save($user);
        header("LOCATION: ?mod=admin&a=users");
        exit;
    }
}