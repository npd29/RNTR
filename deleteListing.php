<?php
include 'top.php';
$listingID=$_GET['id'];
$username = $_SESSION['username'];

$stmt = $pdo->prepare("UPDATE tblReviews SET fldDeleted = 1 WHERE pmkListingID =? AND fkUsername=?" )->execute([$listingID,$username]);

if($stmt){
    setcookie("mySpaceFlag","delete");
    header('Location:mySpace');
}

?>
</body>
</html>