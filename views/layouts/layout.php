<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.prod.website-files.com/63f5f9fd64b1330b28a07cac/63fdfc1c3e4e4de9ffdae05a_Frame%2024.png" rel="shortcut icon" type="image/x-icon">
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

</body>
</html>
