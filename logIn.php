<?php
include 'top.php';
$dataIsValid = false;
$displayForm = true;
$username = '';
$password = '';

function getData($field)
{
    if (!isset($_POST[$field])) {
        $data = "";
    } else {
        $data = trim($_POST[$field]);
        $data = htmlspecialchars($data);
    }
    return $data;
}
?>

<main id="logInMain">
    <?php
    //process form when submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $dataIsValid = true;
        $username = getData("txtUsername");
        $password = getData("txtPassword");

        $checkUsers = $pdo->query("SELECT pmkUsername FROM tblUsers WHERE pmkUsername='$username' && fldPassword= '$password'");

        $countUsers = $checkUsers->rowCount();

        if ($countUsers == 1) {
            $dataIsValid = true;
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            foreach ($pdo->query("SELECT fldFirstName, fldNumLogins FROM tblUsers WHERE pmkUsername='$username'") as $row) {
                $name = $row['fldFirstName'];
                $logins = $row['fldNumLogins'] + 1;
            }
            $_SESSION['name'] = $name;
            $_SESSION['logins'] = $logins;
            $pdo->query("UPDATE tblUsers SET fldNumLogins='$logins', fldLastLogin=now() WHERE pmkUsername='$username'");
            if(isset($_SESSION['savedReview'])){
                header('Location:insertApt');
            }else{
                header('Location:mySpace');
            }
        } else {
            print '<p>Invalid Login credentials. Try again or create an account.</p>';
        }
    }
    ?>

    <div class="box-loginPic">
        <img id="loginPic" src="images/loginRoom.JPG">
        <h1>Get Ready to Find Your Perfect Apartment</h1>
    </div>
    <div class="box-loginForm">
        <h1>LOG IN</h1>
        <form action="#" method="post" class="form-login">

            <div class="labelWrap">
                <input class="inputText" type="text" name="txtUsername" id="txtUsername" value="<?php print $username; ?>" required>
                <label id="userLabel" class="floating-label" for="txtUsername">Username:</label>
            </div>
            <div class="labelWrap">
                <input class="inputText" type="password" name="txtPassword" id="txtPassword" value="" required>
                <label id="passLabel" class="floating-label" for="txtPassword">Password:</label>
            </div>
            <div id="submitDiv">
                <input id="submit" class="btn" type="submit" value="Log In">
            </div>
        </form>
        <a class="btn btn-switchToSignup" href="signUp">Create Account</a>
    </div>
    <?php
    include 'footer.php'
    ?>
</main>
</body>

</html>