<?php
session_write_close();
session_start();
require "connect-DB.php";

//TODO: OK so the savedreview variable is UNSET therefore its throwing an exception when trying to do all of the operations

if ($_SESSION["savedReview"]) { //if a review is saved
    include "classes.php";
    $review = new Review($_SESSION['username']);
    $review->setFullAddress($_SESSION['address1'],$_SESSION['address2'],$_SESSION['city'],$_SESSION['state']);
    $review->setReviewData($_SESSION['bedrooms'],$_SESSION['bathrooms'], $_SESSION['landlord'], $_SESSION['lnrdResponse'], $_SESSION['landlordOverall'],
        $_SESSION['subletting'], $_SESSION['garbage'], $_SESSION['water'], $_SESSION['electricity'], $_SESSION['gas'],
        $_SESSION['wifi'], $_SESSION['snow'], $_SESSION['parking'], $_SESSION['pets'], $_SESSION['secure'], $_SESSION['heating'],
         $_SESSION['comments'], $_SESSION['landlordComments'], $_SESSION['aptOverall'],
        $_SESSION['moveInMonth'], $_SESSION['moveInDay'], $_SESSION['leaseMonth'], $_SESSION['leaseDay'],
        $_SESSION['laundry'], $_SESSION['cost']);

}

try {
    $username=$review->getUsername();
    //search to see if youve already reviewed this apartment
    $listingID = $review->checkPrevReviews();
    $aptID = $review->getAptID();

    // $listingID = $review->getReviewID();
    //if the listing isnt already in the apartments table, add it
    if ($listingID == 0) {
        $review->insertReview();
        $review->getIDbyAddress();
        $listingID = $review->checkPrevReviews();

    } else {
        $review->updateReview();

    }
    $aptID = $review->getAptID();



    /*
    TODO: put insert into numedits to after update apt table
    TODO: dont need $edit and !$edit variations
    TODO: then send fldListingID and fldAptID to tblEdits table
    TODO: then check watchlist for that AptID and if fldSendEmail send an email to fldEmail
*/
} catch (PDOException $e) {

    if (!$edit) {
        print '<p>Couldn\'t add the apartment. Contact RNTR </p>';
    } else {
        print '<p>Couldn\'t update the listing. Contact RNTR </p>';
    }
}

if ($review->getNumEdits() < 15 or $username == 'ndesmara') {

    //create an apartment object to average the values with
    $apartment = new Apartment(0, 0, $review->getAddress1(), $review->getAddress2(), $review->getCity(), $review->getState(),
        $review->getZip(), $review->getLandlord(), 0, "", "",
        "", "", "", "", "", "", "", "", "",
        "", "", "", "", "", "", "", 0);
    $aptID = $review->getAptID();//if it's a new apartment this is 0

    //get the bedroom mode
    foreach ($pdo->query("SELECT fldBedrooms
                FROM   tblReviews WHERE fkAptID='$aptID' OR pmkListingID='$listingID'
                GROUP  BY fldBedrooms
                ORDER  BY COUNT(*) DESC 
                LIMIT 1") as $row) {
        $apartment->setBedrooms($row['fldBedrooms']);
    }


    //get the bathroom mode
    foreach ($pdo->query("SELECT fldBathrooms
                FROM   tblReviews WHERE fkAptID='$aptID' OR pmkListingID='$listingID'
                GROUP  BY fldBathrooms
                ORDER  BY COUNT(*) DESC
                LIMIT 1") as $row) {

        $apartment->setBathrooms($row['fldBathrooms']);
    }

    //get the average of the rest of them
    $row = $pdo->query("SELECT Avg(fldLandlordResponse), Avg(fldSubletting), Avg( 
                                fldGarbage), Avg(fldWater), Avg(fldElectricity), Avg(fldGas), Avg(fldWifi), Avg(fldSnow), Avg(
                                fldParking), Avg(fldSecure), Avg(fldApartmentOverall), Avg(fldLandlordOverall), Avg(fldLeaseMonth),Avg(fldLeaseDay) FROM tblReviews 
                                    WHERE fkAptID='$aptID' OR pmkListingID='$listingID'")->fetch();
    $apartment->setLnrdResponse(round($row[0], 1));
    $apartment->setSubletting(round($row[1], 0));
    $apartment->setGarbage(round($row[2]));
    $apartment->setWater(round($row[3]));
    $apartment->setElectricity(round($row[4]));
    $apartment->setGas(round($row[5]));
    $apartment->setWifi(round($row[6]));
    $apartment->setSnow(round($row[7]));
    $apartment->setParking(round($row[8]));
    $apartment->setSecure(round($row[9], 1));
    $apartment->setAptOverall(round($row[10], 1));
    $apartment->setLandlordOverall(round($row[11], 1));
    $apartment->setLeaseMonth(round($row[14]));
    $apartment->setLeaseDay(round($row[15]));

    //get move in month mode
    foreach ($pdo->query("SELECT fldMoveInMonth
                FROM tblReviews WHERE fkAptID='$aptID' OR pmkListingID='$listingID'
                GROUP  BY fldMoveInMonth
                ORDER  BY COUNT(*) DESC 
                LIMIT 1") as $row) {
        $apartment->setMoveInMonth($row['fldMoveInMonth']);
    }

    //get move in day mode
    foreach ($pdo->query("SELECT fldMoveInDay
                FROM tblReviews WHERE fkAptID='$aptID' OR pmkListingID='$listingID'
                GROUP  BY fldMoveInDay
                ORDER  BY COUNT(*) DESC 
                LIMIT 1") as $row) {
        $apartment->setMoveInDay($row['fldMoveInDay']);
    }

    //get lease date month mode
    foreach ($pdo->query("SELECT fldLeaseMonth
                FROM tblReviews WHERE fkAptID='$aptID' OR pmkListingID='$listingID'
                GROUP  BY fldLeaseMonth
                ORDER  BY COUNT(*) DESC 
                LIMIT 1") as $row) {
        $apartment->setLeaseMonth($row['fldLeaseMonth']);
    }

    //get lease day day mode
    foreach ($pdo->query("SELECT fldLeaseDay
                FROM tblReviews WHERE fkAptID='$aptID' OR pmkListingID='$listingID'
                GROUP  BY fldLeaseDay
                ORDER  BY COUNT(*) DESC 
                LIMIT 1") as $row) {
        $apartment->setLeaseDay($row['fldLeaseDay']);
    }
    //get the mode for if pets are allowed
    foreach ($pdo->query("SELECT fldPets
                FROM tblReviews WHERE fkAptID='$aptID' OR pmkListingID='$listingID'
                GROUP  BY fldPets
                ORDER  BY COUNT(*) DESC 
                LIMIT 1") as $row) {
        $apartment->setPets($row['fldPets']);
    }
    //get the mode for what type of heating
    foreach ($pdo->query("SELECT fldHeating
                FROM tblReviews WHERE fkAptID='$aptID' OR pmkListingID='$listingID'
                GROUP  BY fldHeating
                ORDER  BY COUNT(*) DESC 
                LIMIT 1") as $row) {
        $apartment->setHeating($row['fldHeating']);
    }

    if ($aptID != 0) { //if the apartment exists in the table
        $sqlRun = $apartment->updateApt();
    } else { //if it's a new apartment
        $sqlRun = $apartment->insertApt();
        $aptID=$apartment->getAptID();
    }
    if ($sqlRun) {
        $pdo->query("INSERT INTO tblEdits(fkUsername, fldEditTime, fkAptID, fkListingID) VALUES('$username', now(), '$aptID', '$listingID')");
        $update = "UPDATE tblReviews SET fkAptID=? WHERE pmkListingID='$listingID'";
        $updateStatement = $pdo->prepare($update);
        $params = array($aptID);
        $updateStatement->execute($params);

        $imageSQL = 'INSERT INTO tblImages (fkUsername, fkAptID, fkReviewID, fldImageID) VALUES (?,?,?,?)';
        $numPhotos = $pdo->query("SELECT count(*) FROM tblImages WHERE fkAptID = '$aptID' AND fkReviewID = '$listingID' AND fkUsername='$username'")->fetch();

        $imageStatement = $pdo->prepare($imageSQL);
        $imgID = ($aptID . $listingID . $numPhotos[0]);

        //upload the file
        $info = pathinfo($_FILES['upload']['name']);
        $ext = $info['extension']; // get the extension of the file
        if ($info['extension'] != "") {

            $newName = $imgID . '.' . $ext;
            $target = 'images/uploaded/' . $newName;
            move_uploaded_file($_FILES['upload']['tmp_name'], $target);
            $imageParams = array($username, $aptID, $listingID, $newName);
            $imageStatement->execute($imageParams);
        }


        //check the watchlist database and send out emails about the apartment being updated
        include "checkWatchlist.php";
    }
    if (isset($_SESSION['savedReview'])){
        unset($_SESSION['savedReview']);
    }
    if (!$review->getNew()) {
        setcookie("mySpaceFlag","update");
        header('Location: mySpace');
    } else {
        setcookie("mySpaceFlag","add");
        header('Location: mySpace');
    }
}
