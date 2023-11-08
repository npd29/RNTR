<?php
include 'top.php';
?>
<main>
    <article>
        <?php
        $username = $_SESSION['username'];
        $feedback = false;
        //todo js check cookie mySpaceFlag and create a popup ->delete php
        if ($_SESSION['loggedin'] == true) {
            if ($_SESSION['logins'] == 1) {
                print '<h2>Welcome, ' . $_SESSION['name'] . '!</h2>';
            } else {
                print '<h2>Welcome back, ' . $_SESSION['name'] . '!</h2>';
            }
        if (isset($_COOKIE['mySpaceFlag'])) {
            print("<div class='mySpaceAlert'><h3>");
            if ($_COOKIE['mySpaceFlag']=="delete") {
                print 'Review deleted!';
            }elseif ($_COOKIE['mySpaceFlag']=="update") {
                print 'Review updated!';
            }elseif ($_COOKIE['mySpaceFlag']=="add") {
                print 'Review added!';
            }
            print("</h3></div>");
            setcookie('mySpaceFlag');
        }

            ?>

            <div id="myReviewsDiv">
                <h3>My Reviews</h3>
                <a href="addApt" id="newReviewBtn">New Review</a>
            </div>


            <div class="mySpace" id="reviews">
                <?php
                foreach ($pdo->query("SELECT fldAddress1, fldAddress2, fldLandlord, pmkListingID, fkAptID, fldDeleted FROM tblReviews WHERE fkUsername='$username'") as $row) {
                    if(!$row['fldDeleted']){
                        $listingID = $row['pmkListingID'];
                        $image = $pdo->query("SELECT fldImageID FROM tblImages WHERE fkReviewID='$listingID'")->fetch();
                        $imageID = $image['fldImageID'];
                    ?>
                        <a href="addApt?id=<?php print($listingID)  ?>&edit=true">
                            <div id="reviewBox">
                                <img id="reviewPreview" src="/images/uploaded/<?php
                                                                                if ($imageID != "") {
                                                                                    print($imageID);
                                                                                } else {
                                                                                    print('default.svg');
                                                                                }
                                                                                ?>">
                                <div id="reviewBoxBottom">
                                    <h3 id="address"><?php print($row['fldAddress1']);
                                                        if ($row['fldAddress2'] != "") {
                                                            print ' - ' . $row['fldAddress2'];
                                                        }
                                                        ?>
                                    </h3>
                                    <h4 id="landlord"><?php print($row['fldLandlord']) ?></h4>
                                </div>
                            </div>
                        </a>
                    <?php
                }
                } ?>
            </div>
            <?php
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
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $text = getData('txtFeedback');


                $aptSQL = "INSERT INTO tblFeedback( fkUsername, fldFeedback) VALUES (?,?)";

                $aptStatement = $pdo->prepare($aptSQL);
                $params = array($username, $text);
                if ($aptStatement->execute($params)) {
                    print '<p>Thanks for the feedback!</p>';
                    $feedback = true;
                }
            }
            ?>
    </article>
    <div class="formBox" id="feedbackFormBox">
        <?php
            if (!$feedback) {
        ?>
            <form action="#" method="post" id="feedbackForm">
                <h3>Give us feedback!</h3>
                <textarea name="txtFeedback" id="feedbackText" rows="10" cols="100" required><?php print $feedback; ?></textarea>
                </p>
                <p><input type="submit" value="Submit"></p>
            </form>
        <?php
            }
        ?>
        <a href="mailto: noel@rntr.org">
            <h3>Contact us</h3>
        </a>
    </div>
<?php
        } else {
            header('Location:logIn');
        }
        include 'footer.php';
?>
</main>
</body>

</html>