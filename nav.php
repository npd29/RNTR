<?php
$phpSelf = htmlspecialchars($_SERVER['PHP_SELF']);
$path_parts = pathinfo($phpSelf);
?>

<nav id="navbar">
    <a class="navTitle" href="/">RNTR</a>
    <a class = "home navLink" href = "/" >Home</a>
    <a class = "aboutUs navLink" href = "aboutUs">About Us</a>

    <?php
        if ($_SESSION['loggedin'] == true) {
            print '<a id="mySpace" class = "mySpace navLink" href = "mySpace">' . $_SESSION['name'] . '</a>
            <a class="navLink" href=logout>[]-></a>';
        } else {
            print '<a class = "logIn navLink" href = "logIn">Log In</a><p class="navSlash">/</p><a class = "signUp navLink" href = "signUp">Sign Up</a>';
        }
    if($path_parts['filename'] != 'addApt' && $path_parts['filename'] != 'mySpace' && $path_parts['filename'] != 'logIn' && $path_parts['filename'] != 'signUp'){
        print'<a class = "navAddApt" href = "addApt">add your apartment</a>';
    }?>
</nav>
<script src="js/nav.js"></script>
