<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>webXadmin</title>
    <?php include( base_path('resources/views/' ). 'note/includes/jss.php'); ?>

</head>
<body>
<div class="page">
    <header class="navbar navbar-expand-md navbar-light d-print-none">
        <div class="container-xl">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                <a href="..">
                    <img src="https://wave.bzh/wp-domains/breizhwave/uploads/2020/12/wave2021-50.png" width="110" height="32" alt="waveXadmin" class="navbar-brand-image">
                </a> webXadmin
            </h1>

        </div>
    </header>
    <div class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
            <?php include( base_path('resources/views/' ). '/note/includes/menu.php'); ?>
        </div>
    </div>
    <div class="page-wrapper">
        <div class="container-xl">


            <!-- Page title -->
            <div class="page-header d-print-none">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                        webXadmin
                        </h2>
                    </div>
                </div>
            </div>
        </div>

