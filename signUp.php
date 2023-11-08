<?php
include 'top.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$displayForm = true;
$displayCode = false;
$dataIsValid = false;
$username = '';
$firstName = '';
$lastName = '';
$email = '';
$password = '';
$birthday = '';
$gender = '';
$code = 0;
$verify = '';

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

<main id="signUpMain">

    <?php
    //process form when submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $dataIsValid = true;
        $firstName = getData("txtFirstName");
        $firstName = ucwords($firstName);
        $lastName = getData("txtLastName");
        $lastName = ucwords($firstName);
        $username = getData("txtUsername");
        $password = getData("txtPassword");
        $gender = getData("radGender");
        $birthday = getData("dteBirthday");
        $verify = getData("txtVerify");

        $email = getData("txtEmail");
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        //server side validation
        if ($email == "") {
            print '<p class = "mistake"> Please enter your email</p>';
            $dataIsValid = false;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            print '<p class = "mistake"> Your email address appears to be incorrect</p>';
            $dataIsValid = false;
        }

        if ($gender != 'female' and $gender != 'male' and $gender != 'other') {
            print '<p class="mistake">Please choose a gender.</p>';
            $dataIsValid = false;
        }

        if ($password != $verify) {
            print '<p class="mistake">Passwords do not match</p>';
            $dataIsValid = false;
        }


        if ($dataIsValid) {
            try {
                $sql = 'INSERT INTO tblUnverifiedUsers (fldFirstName, fldLastName, fldEmail, fldGender,pmkUsername, fldPassword,
                     fldBirthday, fldRandCode) VALUES (?,?,?,?,?,?,?,?)';
                $statement = $pdo->prepare($sql);
                $code = rand(100000, 999999);
                $params = array($firstName, $lastName, $email, $gender, $username, $password, $birthday, $code);
                $checkUsername = $pdo->query("SELECT pmkUsername FROM tblUsers WHERE pmkUsername='$username'");
                $checkEmail = $pdo->query("SELECT fldEmail FROM tblUsers WHERE fldEmail='$email'");
                $countUsername = $checkUsername->rowCount();
                $countEmail = $checkEmail->rowCount();
                if ($countUsername > 0) {
                    print '<p>That username is already in use. Try another</p>';
                    $dataIsValid = false;
                }
                if ($countEmail > 0) {
                    print '<p>The email address provided is already associated with an account. <a id="switchToLogin" href="logIn.php">Log In here</a></p>';
                    $dataIsValid = false;
                }

                if ($dataIsValid && $statement->execute($params)) {
                    $to = $email;
                    $from = 'The RNTR Team <noel@rntr.org>';
                    $subject = 'RNTR Account Verification';

                    $mailMessage = '<div style="background-color: white"><p style="font-family: Montserrat, sans-serif; color:var(--purple)">Welcome to RNTR! Please enter the code below to finish setting up your account</p><p>Your code:</p><h3>' . $code . '</h3> <p>-The RNTR Team</p></div>';
                    $headers = "MIME-Version: 1.0\r\n";
                    $headers .= "Content-type: text/html; charset=utf-8\r\n";
                    $headers .= "From: " . $from . "\r\n";

                    $mailSent = mail($to, $subject, $mailMessage, $headers);
                }
            } catch (PDOException $e) {
                print '<p>Couldn\'t create the account. Contact RNTR </p>';
            }
        }
    }
    if ($dataIsValid) {
        $_SESSION['username'] = $username;
        header('Location:verifyUser');
    }
    ?>
    <script src="js/radio.js"></script>
    <div class="box-signupPic">
        <img id="signupPic" src="images/signupHouse.JPG">
        <h1>Welcome to the Team</h1>
    </div>
    <div class="box-signupForm">
        <h1>Create Account</h1>
        <form action="#" method="post" class="form-signup"">
            <div id=" firstName">
            <input class="inputText" type="text" name="txtFirstName" id="txtFirstName" value="<?php print $firstName; ?>" required>
            <label class="floating-label" for="txtFirstName">First Name:</label>
            </div>
            <div id="lastName">
                <input class="inputText" type="text" name="txtLastName" id="txtLastName" value="<?php print $lastName; ?>" required>
                <label class="floating-label" for="txtLastName">Last Name:</label>
            </div>
            <div id="email">
                <input class="inputText" type="email" name="txtEmail" id="txtEmail" value="<?php print $email; ?>" required>
                <label class="floating-label" for="txtEmail">Email:</label>
            </div>
            <div id="username">
                <input class="inputText" type="text" name="txtUsername" id="txtUsername" value="<?php print $username; ?>" required>
                <label class="floating-label" for="txtUsername">Create a Username</label>
            </div>
            <div id="password">
                <input class="inputText" type="password" name="txtPassword" id="txtPassword" value="" required>
                <label class="floating-label" for="txtPassword">Password</label>
            </div>
            <div id="verifyPassword">
                <input class="inputText" type="password" name="txtVerify" id="txtVerify" value="" required>
                <label class="floating-label" for="txtVerify">Verify Password</label>
            </div>
            <div id="birthday">
                <input class="inputText" type="date" name="dteBirthday" id="dteBirthday" value="<?php print $birthday; ?>">
                <label class="floating-label" for="dteBirthday">Birthday:</label>
            </div>
            <div id="gender">
                <p>What is your gender?</p>
                <div class="box-radio">
                    <div class="container-radio" onclick="adjustRadio('radio', 'radGenderMale')">
                        <input <?php if ($gender == "male") print "checked"; ?> class="radio" type="radio" id="radGenderMale" name="radGender" value="male">
                        <label id="radlabel" for="radGenderMale">Male</label><br>
                    </div>
                    <div class="container-radio" onclick="adjustRadio('radio','radGenderFemale')">
                        <input <?php if ($gender == "female") print "checked"; ?> class="radio" type="radio" id="radGenderFemale" name="radGender" value="female">
                        <label id="radlabel" for="radGenderFemale">Female</label><br>
                    </div>
                    <div class="container-radio" onclick="adjustRadio('radio','radGenderOther')">
                        <input <?php if ($gender == "other") print "checked"; ?> class="radio" type="radio" id="radGenderOther" name="radGender" value="other">
                        <label id="radlabel" for="radGenderOther">Other</label>
                    </div>
                </div>
            </div>
            <div id="submitDiv">
                <input id="submit" class="btn" type="submit" value="Create Account">
            </div>
        </form>
        <a class=" btn btn-switchToLogin" href="logIn">Already have an account? Log In</a>
    </div>
    <?php
    include 'footer.php'
    ?>
</main>
</body>

</html>