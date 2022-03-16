<!DOCTYPE html>
<html lang="en">
<head>

    <?php
    wp_head();
    $logo = get_theme_mod( 'custom_logo' );
    $image = wp_get_attachment_image_src( $logo , 'full' );
    ?>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="author" content="">
    <meta name="keywords" content="">
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>

</head>
<body>

<nav class="navbar is-dark" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <img class="logo" src="<?php echo $image[0] ?>" >

        <a role="button" onclick="openNavbar()"
           class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="nav-menu" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item">
                Αρχική
            </a>

            <a class="navbar-item">
                Εκπαιδευτικοί
            </a>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link" id="more">
                    Νέα
                </a>

                <div class="navbar-dropdown" id="dropdown-more">
                    <a class="navbar-item">
                        Ανακοινώσεις
                    </a>
                </div>
            </div>
            <a class="navbar-item">
                Επικοινωνία
            </a>
        </div>

    </div>
</nav>
