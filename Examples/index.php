<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once("quanta/quanta.php");
include_once("modules/user-module/user-module.php");

$quanta = new Quanta();
// $user_module = new UserModule("user_module");
// $quanta->add_module($user_module);
// $quanta->load_modules();

include_once("inc/components.php");
include_once("inc/actions.php");

$quanta->routeHandler->initial_routing('page', 'fallbackComponent');
$quanta->routeHandler->register_route('news', 'grid');

$quanta->actionHandler->init();
$quanta->process_action(false);
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quanta - Build Smarter</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.11.1/styles/dark.min.css">
    <link rel="stylesheet" href="style/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/go.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script>hljs.highlightAll();</script>
</head>

<body>
    <!--Navigation-->
    <section class="navigation">
        <?php $quanta->render_component('navbar'); ?>
    </section>

    <!--Hero-->
    <section class="hero border-bottom py-3" id="hero">
        <?php $quanta->render_component('hero'); ?>
    </section>

    <!--About-->
    <section class="about border-bottom py-3" id="about">
        <?php $quanta->render_component('about'); ?>
    </section>

    <!--Features-->
    <section class="features border-bottom py-3" id="features">
        <?php $quanta->render_component('features'); ?>
    </section>

    <!--Get started-->
    <section class="getting-started border-bottom py-3" id="start" class="py-5">
        <?php $quanta->render_component('get_started'); ?>
    </section>

    <!--footer-->
    <section class="footer">
        <?php $quanta->render_component('footer'); ?>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>