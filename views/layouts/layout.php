<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \Core\Support\Config::getInstance()->get('app.app_name', 'Title') ?></title>

    <!--  Fonts  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!--  Material icons  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!--  Custom styles  -->
    <link rel="stylesheet" href="./styles/main.css">
</head>
<body>
<?php
    include_once __DIR__ . '/../partials/header.php';
?>

<?= $content ?>

<?php
    include_once __DIR__ . '/../partials/footer.php';
?>


<script src="./scripts/index.js"></script>
</body>
</html>
