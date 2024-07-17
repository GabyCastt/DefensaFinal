<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once('./html/head.php') ?>
    <link href="../public/lib/calendar/lib/main.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        .custom-flatpickr {
            display: flex;
            align-items: center;
        }

        .custom-flatpickr input {
            margin-right: 5px;
            flex: 1;
        }

        .welcome-hero {
            background-image: linear-gradient(to bottom, #34C759, #2E865F);
            background-size: 100% 300px;
            background-position: 0% 100%;
            height: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }

        .welcome-hero h1 {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .welcome-hero p {
            font-size: 18px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <!-- Spinner End -->

    <!-- Sidebar Start -->
    <?php require_once('./html/menu.php') ?>
    <!-- Sidebar End -->

    <!-- Content Start -->
    <div class="content">
        <!-- Navbar Start -->
        <?php require_once('./html/header.php') ?>
        <!-- Navbar End -->











        <!-- Footer Start -->
        <?php require_once('./html/footer.php') ?>