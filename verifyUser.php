<?php
include 'top.php';
$codeInput = 0;
$username = $_SESSION['username'];
$secretCode = 0;
$firstName = '';
$lastName = '';
$email = '';
$password = '';
$birthday = '';
$gender = '';

foreach($pdo->query("SELECT fldRandCode FROM tblUnverifiedUsers WHERE pmkUsername='$username'") as $row){
    $secretCode = $row['fldRandCode'];
}

function getData($field){
    if (!isset($_POST[$field])) {
        $data = "";
    } else {
        $data = trim($_POST[$field]);
        $data = htmlspecialchars($data);
    }
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codeInput = getData('numCode');
    if ($codeInput == $secretCode){
        foreach($pdo->query("SELECT * FROM tblUnverifiedUsers WHERE pmkUsername='$username'") as $row){
            $firstName = $row['fldFirstName'];
            $password = $row['fldPassword'];
            $lastName= $row['fldLastName'];
            $birthday= $row['fldBirthday'];
            $email= $row['fldEmail'];
            $gender= $row['fldGender'];
        }

        $sql = 'INSERT INTO tblUsers (fldFirstName, fldLastName, fldEmail, fldGender,pmkUsername, fldPassword,
                     fldBirthday) VALUES (?,?,?,?,?,?,?)';
        $statement = $pdo->prepare($sql);
        $params = array($firstName, $lastName, $email, $gender, $username, $password, $birthday);

        if ($statement->execute($params)){
            $delete = $pdo->prepare("DELETE FROM tblUnverifiedUsers WHERE pmkUsername='$username'");
            $delete->execute();
            $dataIsValid = true;
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['name']=$firstName;
            $_SESSION['username'] = $username;
            if(isset($_SESSION['savedReview'])){
                header('Location:insertApt');
            }else{
                header('Location:mySpace');
            }
        }
    }else{
        print '<p>Incorrect code. Try Again</p>';
        //TODO: Make limit of 10 guesses
    }

}
?>
        <main>
            <article>
                <div class="formBox" id="verifyFormBox">
                <form action="#" method="post" id="verifyAccountForm">
                            <p>
                                <label for="numCode">Enter the 6-digit code we sent to your email:</label>
                                <input type="number" name="numCode" id="numCode" required>
                            </p>
                    <p><input type="submit" value="Verify"></p>
                </form>
                </div>
            </article>

            <?php
            include 'footer.php'
            ?>
        </main>
    </body>
</html>