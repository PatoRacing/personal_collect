<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Collect | <?php echo $titulo ?? '';?></title>
    <!--Favicon-->
    <link rel="apple-touch-icon" sizes="180x180" href="build/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="build/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="build/img/favicon-16x16.png">
    <link rel="manifest" href="build/img/site.webmanifest">
    <link rel="mask-icon" href="build/img/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <!--Fontawesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--SweetAlert-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--Fuentes-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="build/css/app.css">
</head>
<body>

    <?php echo $contenido; ?>
    <?php echo $script ?? ''; ?>


</body>
</html>


