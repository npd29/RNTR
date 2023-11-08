/*this is a backup for addApt*/

<?php
include 'top.php';

$displayForm = true;
$dataIsValid = false;


if(isset($_SESSION['username'])){
$username = $_SESSION['username'];

if(isset($_GET['edit']) AND $_GET['edit']=='true'){//if we're editing a listing
    $listingID=$_GET['id'];//set the listing id and fetch the information
    foreach($pdo->query("SELECT fldAddress1, fldAddress2, fldCity, fldState, fldZIP, fldLandlord, fldBedrooms, fldBathrooms,fkUsername, 
           fldLandlordResponse, fldWalls, fldSubletting, fldPaint, fldGarbage, fldWater, fldElectricity, fldGas, fldWifi, 
           fldSnow, fldParking, fldPets, fldSecure, fldHeating, fldMaintenance, fldComments, fldApartmentOverall, fldLandlordOverall, fldViews, fldLocation, fldLandlordComments FROM tblReviews WHERE 
            pmkListingID='$listingID'") as $row) {
        if ($_SESSION['username']==$row['fkUsername']) {
            $address1 = $row['fldAddress1'];
            $address2 = $row['fldAddress2'];
            $city = $row['fldCity'];
            $state = $row['fldState'];
            $zip = $row['fldZIP'];
            $landlord = $row['fldLandlord'];
            $bedrooms = $row['fldBedrooms'];
            $bathrooms = $row['fldBathrooms'];
            $garbage = $row['fldGarbage'];
            $electricity = $row['fldElectricity'];
            $water = $row['fldWater'];
            $parking = $row['fldParking'];
            $gas = $row['fldGas'];
            $wifi = $row['fldWifi'];
            $snow = $row['fldSnow'];
            $lnrdResponse = $row['fldLandlordResponse'];
            $walls = $row['fldWalls'];
            $subletting = $row['fldSubletting'];
            $paint = $row['fldPaint'];
            $secure = $row['fldSecure'];
            $pets = $row['fldPets'];
            $heating = $row['fldHeating'];
            $comments = $row['fldComments'];
            $maintenance = $row['fldMaintenance'];
            $aptOverall = $row['fldApartmentOverall'];
            $landlordOverall = $row['fldLandlordOverall'];
            $views = $row['fldViews'];
            $location = $row['fldLocation'];
            $landlordComments = $row['fldLandlordComments'];
            //$photos = $row['fldPhotos'];
            $edit = true;
        }
    }
}
else {//if we're creating a new listing initialize variables
    $bedrooms = 0;
    $bathrooms = 0;
    $address1 = '';
    $address2 = '';
    $city = '';
    $state = '';
    $zip = '';
    $landlord = '';
    $lnrdResponse = 0;
    $landlordOverall = 0;
    $walls = '';
    $subletting = false;
    $paint = false;
    $garbage = false;
    $water = false;
    $electricity = false;
    $gas = false;
    $wifi = false;
    $snow = false;
    $parking = false;
    $pets = 'unsure';
    $secure = 0;
    $heating = '';
    $maintenance = 0;
    $comments = '';
    $aptOverall = 0;
    $landlordOverall = 0;
    $views=0;
    $location=0;
    $landlordComments='';

    //    $photos=';';
    $edit=false;
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
?>

<main>

    <?php
    //process form when submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //sanitize all inputs
        $dataIsValid = true;
        $bedrooms = getData("numBedrooms");
        $bathrooms = getData("numBathrooms");
        $address1 = getData("txtAddress1");
        $address1 = urlencode($address1);
        $address2 = getData("txtAddress2");
        $address2 = urlencode($address2);
        $city = getData("txtCity");
        $city = urlencode($city);
        $state = getData("txtState");
        $state = urlencode($state);
        $zip = getData("txtZip");
        $zip = urlencode($zip);
        //run smartystreets
        include 'smartyStreets.php';

        $address1=explode('And', $address1);
        $address1=implode($address1);
        $address1=preg_replace('/\s+/', ' ', $address1);
        $address2=ltrim($address2,'#');
        $address2=explode('And', $address2);
        $address2=implode($address2);
        $city=explode('And', $city);
        $city=implode($city);
        $city=preg_replace('/\s+/', ' ', $city);
        $zip=urldecode($zip);
        $state=urldecode($state);
        $aptOverall=getData('numAptOverall');

        $landlord = getData("txtLandlord");
        $landlord=ucwords(strtolower($landlord));
        $lnrdResponse = getData("numLnrdResponse");
        $landlordOverall = getData("radLnrdOverall");
        $walls = getData("chkWalls");
        $subletting = getData("chkSublet");
        $paint = getData("chkPaint");
        $garbage = getData("chkGarbage");
        $water = getData("chkWater");
        $electricity = getData("chkElectricity");
        $gas = getData("chkGas");
        $wifi = getData("chkWifi");
        $snow = getData("chkSnow");
        $parking = getData("chkParking");
        $pets = getData("radPets");
        $secure = getData("numSecure");
        $heating = getData("chkHeating");
        $maintenance = getData("numMaintenance");
        $comments = getData("txtComments");
        $landlordComments=getData("txtLandlordComments");
        $views = getData("numViews");
        $location = getData("numLocation");




        //server side validation
        //if anything is wrong then don't let the form be submitted
        if ($address1 == "" OR $city=="" OR $state =="") {
            print '<p class = "mistake"> Please enter the full address</p>';
            $dataIsValid = false;
        }

        if ($landlord == "") {
            print '<p class = "mistake"> Please enter the Landlord\'s name</p>';
            $dataIsValid = false;
        }

        if ($pets != 'yes' AND $pets != 'no' AND $pets != 'some' AND $pets != ''){
            print '<p class="mistake">Please choose one of the answers for pets</p>';
            $dataIsValid = false;
        }
        if ($lnrdResponse>5 OR $lnrdResponse<1){
            print '<p class="mistake">Please enter a landlord response between 1-5</p>';
        }
//            if ($aptOverall>5 OR $aptOverall<1){
//                print '<p class="mistake">Please enter an overall apartment between 1-5</p>';
//            }
        if ($landlordOverall>5 OR $landlordOverall<1){
            print '<p class="mistake">Please enter a landlord overall rating between 1-5</p>';
        }
        if ($maintenance>5 OR $maintenance<1){
            print '<p class="mistake">Please enter a maintenance response rating between 1-5</p>';
            $dataIsValid = false;
        }
        if ($lnrdResponse>5 OR $lnrdResponse<1){
            print '<p class="mistake">Please enter a landlord response between 1-5</p>';
        }

        //if data is valid
        if ($dataIsValid) {
            if (!$edit) {
                try {
                    $lstCount = 0;
                    //search the listings table to see if that review is already in it
                    foreach ($pdo->query("SELECT pmklistingID FROM tblReviews 
                                    WHERE fldAddress1='$address1'AND fldAddress2='$address2'AND fldCity='$city'AND fldState='$state' AND fkUsername='$username'") as $row) {
                        $lstCount++;
                        $listingID = $row['pmklistingID'];
                    }
                    //if the listing isnt already in the apartments table, add it
                    if ($lstCount == 0) {
                        $sql = 'INSERT INTO tblReviews (fldAddress1, fldAddress2, fldCity, fldState, fldZIP, fldLandlord, fldBedrooms, fldBathrooms,fkUsername, fldLandlordResponse,
                             fldWalls, fldSubletting, fldPaint, fldGarbage, fldWater, fldElectricity, fldGas, fldWifi, fldSnow, 
                                fldParking, fldPets, fldSecure, fldHeating, fldMaintenance, fldComments, fldApartmentOverall, fldLandlordOverall, fldViews, fldLocation, fldLandlordComments, fldTime) VALUES (?,?,?,?,?,?,
                                ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,now())';
                    } else {
                        $sql = 'UPDATE tblReviews SET fldAddress1=?,fldAddress2=?, fldCity=?, fldState=?, fldZIP=?, fldLandlord=?, fldBedrooms=?,
                           fldBathrooms=?, fkUsername=?, fldLandlordResponse=?, fldWalls=?, fldSubletting=?,
                           fldPaint=?, fldGarbage=?, fldWater=?, fldElectricity=?, fldGas=?, fldWifi=?, fldSnow=?, 
                                fldParking=?, fldPets=?, fldSecure=?, fldHeating=?, fldMaintenance=?, fldComments=? fldApartmentOverall=?, fldLandlordOverall=?, fldViews=?, fldLocation=?, fldLandlordComments=?, fldTime=now() WHERE pmkListingID=' . $listingID;
                    }
                    $statement = $pdo->prepare($sql);
                    $params = array($address1, $address2, $city, $state, $zip, $landlord, $bedrooms, $bathrooms, $username, $lnrdResponse, $walls, $subletting,
                        $paint, $garbage, $water, $electricity, $gas, $wifi, $snow, $parking, $pets, $secure, $heating,
                        $maintenance, $comments, $aptOverall, $landlordOverall, $views, $location, $landlordComments);

                    //update edit table
                    $numEdits = $pdo->query("SELECT count(*) FROM tblEdits WHERE fldEditTime >= now()-INTERVAL 10 MINUTE AND fkUsername='$username'")->fetch();
                    if ($numEdits[0] < 15 OR $username == "ndesmara") {
                        $pdo->query("INSERT INTO tblEdits(fkUsername, fldEditTime) VALUES('$username', now())");
                        if ($statement->execute($params)) {
                            $displayForm = false;
                        }
                    }else{
                        print '<p>Too many changes made recently. Please wait to make more changes.</p>';
                    }
                } catch (PDOException $e) {
                    print '<p>Couldn\'t add the apartment. Contact RNTR </p>';
                }
            } elseif ($edit) {
                try {
                    //get the address of the original listing before it is updated
                    $oldListing = $pdo->query("SELECT fldAddress1, fldAddress2, fldCity, fldState FROM tblReviews WHERE pmkListingID='$listingID'")->fetch();
                    //check the listings table to see if there is more than one other listing with that address
                    $similarAddresses = 0;
                    foreach ($pdo->query("SELECT pmkListingID FROM tblReviews WHERE fldAddress1='$oldListing[0]'AND fldAddress2='$oldListing[1]'AND fldCity='$oldListing[2]'AND fldState='$oldListing[3]'") as $item) {
                        $similarAddresses++;
                    }
                    //if there is only one listing with that address, delete it from the apartment table
                    if ($similarAddresses = 1) {
                        $pdo->query("DELETE FROM tblApartments WHERE fldAddress1='$oldListing[0]'AND fldAddress2='$oldListing[1]'AND fldCity='$oldListing[2]'AND fldState='$oldListing[3]'");
                    }
                    $sql = 'UPDATE tblReviews SET fldAddress1=?,fldAddress2=?, fldCity=?, fldState=?, fldZIP=?, fldLandlord=?, fldBedrooms=?,
                           fldBathrooms=?, fldLandlordResponse=?, fldWalls=?, fldSubletting=?,
                           fldPaint=?, fldGarbage=?, fldWater=?, fldElectricity=?, fldGas=?, fldWifi=?, fldSnow=?, 
                                fldParking=?, fldPets=?, fldSecure=?, fldHeating=?, fldMaintenance=?, fldComments=?, fldApartmentOverall=?, fldLandlordOverall=?, fldViews=?, fldLocation=?, fldLandlordComments=?, fldTime=now() WHERE pmkListingID=' . $listingID;
                    $statement = $pdo->prepare($sql);
                    $params = array($address1, $address2, $city, $state, $zip, $landlord, $bedrooms, $bathrooms, $lnrdResponse, $walls, $subletting,
                        $paint, $garbage, $water, $electricity, $gas, $wifi, $snow, $parking, $pets, $secure, $heating,
                        $maintenance, $comments, $aptOverall, $landlordOverall, $views, $location, $landlordComments);


                    //update edits table
                    $numEdits = $pdo->query("SELECT count(*) FROM tblEdits WHERE fldEditTime >= now()-INTERVAL 10 MINUTE AND fkUsername='$username'")->fetch();






                    /*
                    TODO: put insert into numedits to after update apt table
                    TODO: dont need $edit and !$edit variations
                    TODO: then send fldListingID and fldAptID to tblEdits table
                    TODO: then check watchlist for that AptID and if fldSendEmail send an email to fldEmail
                    */








                    if ($numEdits[0] < 15 OR $username == 'ndesmara') {
                        $pdo->query("INSERT INTO tblEdits(fkUsername, fldEditTime) VALUES('$username', now())");
                        if ($statement->execute($params)) {
                            $displayForm = false;
                        }
                    }else{
                        print '<p>Too many changes made recently. Please wait to make more changes.</p>';
                    }

                } catch (PDOException $e) {
                    print '<p>Couldn\'t update the listing. Contact RNTR </p>';
                }
            }

            if ($numEdits[0] < 15 OR $username == 'ndesmara') {
                //RESET VARIABLES
                $lnrdResponse = 0;
                $walls = '';
                $subletting = false;
                $paint = false;
                $garbage = false;
                $water = false;
                $electricity = false;
                $gas = false;
                $wifi = false;
                $snow = false;
                $parking = false;
                $pets = 'unsure';
                $secure = 0;
                $heating = '';
                $maintenance = 0;
                $aptOverall = 0;
                $landlordOverall = 0;
                $views = 0;
                $location = 0;


                //AVERAGE THE VALUES
                foreach ($pdo->query("SELECT fldBedrooms
                FROM   tblReviews WHERE fldAddress1='$address1'AND fldAddress2='$address2'AND fldCity='$city'AND fldState='$state'
                GROUP  BY fldBedrooms
                ORDER  BY COUNT(*) DESC 
                LIMIT 1") as $row) {
                    $bedrooms = $row['fldBedrooms'];
                }

                foreach ($pdo->query("SELECT fldBathrooms
                FROM   tblReviews WHERE fldAddress1='$address1'AND fldAddress2='$address2'AND fldCity='$city'AND fldState='$state'
                GROUP  BY fldBathrooms
                ORDER  BY COUNT(*) DESC
                LIMIT 1") as $row) {

                    $bathrooms = $row['fldBathrooms'];
                }


                $row = $pdo->query("SELECT Avg(fldLandlordResponse), Avg(fldWalls), Avg(fldSubletting), Avg(fldPaint), Avg( 
                                fldGarbage), Avg(fldWater), Avg(fldElectricity), Avg(fldGas), Avg(fldWifi), Avg(fldSnow), Avg(
                                fldParking), Avg(fldSecure), Avg(fldMaintenance), Avg(fldApartmentOverall), Avg(fldLandlordOverall), Avg(fldViews), Avg(fldLocation) FROM tblReviews 
                                    WHERE fldAddress1='$address1'AND fldAddress2='$address2'AND fldCity='$city'AND fldState='$state'")->fetch();
                $lnrdResponse = round($row[0], 1);
                $walls = round($row[1], 0);
                $subletting = round($row[2], 0);
                $paint = round($row[3]);
                $garbage = round($row[4]);
                $water = round($row[5]);
                $electricity = round($row[6]);
                $gas = round($row[7]);
                $wifi = round($row[8]);
                $snow = round($row[9]);
                $parking = round($row[10]);
                $secure = round($row[11], 1);
                $maintenance = round($row[12], 1);
                $aptOverall = round($row[13], 1);
                $landlordOverall = round($row[14], 1);
                $views = round($row[15], 1);
                $location = round($row[16], 1);


                foreach ($pdo->query("SELECT fldPets
                FROM   tblReviews WHERE fldAddress1='$address1'AND fldAddress2='$address2'AND fldCity='$city'AND fldState='$state'
                GROUP  BY fldPets
                ORDER  BY COUNT(*) DESC 
                LIMIT 1") as $row) {
                    $pets = $row['fldPets'];
                }
                foreach ($pdo->query("SELECT fldHeating
                FROM   tblReviews WHERE fldAddress1='$address1'AND fldAddress2='$address2'AND fldCity='$city'AND fldState='$state'
                GROUP  BY fldHeating
                ORDER  BY COUNT(*) DESC 
                LIMIT 1") as $row) {
                    $heating = $row['fldHeating'];
                }
                //update the apartments table
                $aptID = 0;
                foreach ($pdo->query("SELECT pmkApartmentID FROM tblApartments 
                                    WHERE fldAddress1='$address1'AND fldAddress2='$address2'AND fldCity='$city'AND fldState='$state'") as $row) {
                    $aptID = $row['pmkApartmentID'];
                }

                if ($aptID != 0) {
                    $aptSQL = "UPDATE tblApartments SET fldAddress1=?,fldAddress2=?, fldCity=?, fldState=?, fldZIP=?, fldLandlord=?, fldBedrooms=?,
                           fldBathrooms=?, fldLandlordResponse=?, fldWalls=?, fldSubletting=?,
                           fldPaint=?, fldGarbage=?, fldWater=?, fldElectricity=?, fldGas=?, fldWifi=?, fldSnow=?, 
                                fldParking=?, fldPets=?, fldSecure=?, fldHeating=?, fldMaintenance=?, fldApartmentOverall=?, fldLandlordOverall=?, fldViews=?, fldLocation=? WHERE fldAddress1='$address1'AND fldAddress2='$address2'AND fldCity='$city'AND fldState='$state'";
                } else {
                    $aptSQL = "INSERT INTO tblApartments( fldAddress1,fldAddress2, fldCity, fldState, fldZIP, fldLandlord, fldBedrooms,
                           fldBathrooms, fldLandlordResponse, fldWalls, fldSubletting,
                           fldPaint, fldGarbage, fldWater, fldElectricity, fldGas, fldWifi, fldSnow, 
                                fldParking, fldPets, fldSecure, fldHeating, fldMaintenance, fldApartmentOverall, fldLandlordOverall, fldViews, fldLocation) VALUES (?,?,?,?,?,?,
                                ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                }
                $aptStatement = $pdo->prepare($aptSQL);
                $params = array($address1, $address2, $city, $state, $zip, $landlord, $bedrooms, $bathrooms, $lnrdResponse, $walls, $subletting,
                    $paint, $garbage, $water, $electricity, $gas, $wifi, $snow, $parking, $pets, $secure, $heating,
                    $maintenance, $aptOverall, $landlordOverall, $views, $location);
                if ($aptStatement->execute($params)) {

                    if ($lstCount != 0 or $edit) {
                        header('Location: mySpace?update=true');
                        print '<p>Added</p>';
                    } elseif ($lstCount == 0) {
                        header('Location: mySpace?add=true');
                    }
                }
            }
        }
    }
    if ($displayForm){
        ?>

        <div class="formBox" id="addApartmentFormBox">
            <form action="#" method="post" id="addAptForm">
                <div id="generalInfo" class="tab">
                    <div id="addresses">
                        <div id="address1">
                            <!-- Address -->
                            <label for="txtAddress1">Address:</label>
                            <input type="text" name="txtAddress1" id="txtAddress1" value="<?php print $address1;?>" required>
                        </div>

                        <div id="address2">
                            <!-- Address 2 -->
                            <label for="txtAddress2">Apartment #:</label>
                            <input type="text" name="txtAddress2" id="txtAddress2" value="<?php print $address2;?>">
                        </div>
                    </div>
                    <div id="cityState">
                        <div id="city">
                            <!-- City -->
                            <label for="txtCity">City:</label>
                            <input type="text" name="txtCity" id="txtCity" value="<?php print $city;?>" required>
                        </div>

                        <div id="state">
                            <!-- State -->
                            <label for="txtState">State:</label>
                            <input type="text" name="txtState" id="txtState" value="<?php print $state;?>" required>
                        </div>
                    </div>
                    <!-- ZIP Code
                        <div id="zip">
                            <label for="txtZip">Zip Code:</label>
                            <input type="text" name="txtZip" id="txtZip" value="<?php print $zip;?>">
                        </div>
                        -->
                    <div id="bedBath">
                        <!-- Number of Rooms -->
                        <div id="bedrooms">
                            <label for="numBedrooms">Bedrooms:</label>
                            <input type="text" name="numBedrooms" id="numBedrooms" value="<?php print $bedrooms;?>" required>
                        </div>

                        <!-- Number of Bathrooms -->
                        <div id="bathrooms">
                            <label for="numBathrooms">Bathrooms:</label>
                            <input type="text" name="numBathrooms" id="numBathrooms" value="<?php print $bathrooms;?>" required>
                        </div>
                    </div>
                </div>

                <div id="landlord" class="tab">
                    <div id="landlordName">
                        <!-- Landlord Name-->
                        <label for="txtLandlord">Landlord Name:</label>
                        <input type="text" name="txtLandlord" id="txtLandlord" value="<?php print $landlord;?>" required>
                    </div>

                    <div id="landlordResponse" class="starsBox">
                        <!-- Landlord response-->
                        <p>How responsive is your landlord?</p>
                        <fieldset class="rating" id="landlordResponse">
                            <input type="radio" id="lR5" name="numLnrdResponse" value="5" <?php if ($lnrdResponse == "5") print "checked"; ?>/><label class = "full" for="lR5" title="Awesome - 5 stars"></label>
                            <input type="radio" id="lR45" name="numLnrdResponse" value="4.5" <?php if ($lnrdResponse == "4.5") print "checked"; ?>/><label class="half" for="lR45" title="Good - 4.5 stars"></label>
                            <input type="radio" id="lR4" name="numLnrdResponse" value="4" <?php if ($lnrdResponse == "4") print "checked"; ?>/><label class = "full" for="lR4" title="Pretty good - 4 stars"></label>
                            <input type="radio" id="lR35" name="numLnrdResponse" value="3.5" <?php if ($lnrdResponse == "3.5") print "checked"; ?>/><label class="half" for="lR35" title="Ok - 3.5 stars"></label>
                            <input type="radio" id="lR3" name="numLnrdResponse" value="3" <?php if ($lnrdResponse == "3") print "checked"; ?>/><label class = "full" for="lR3" title="Meh - 3 stars"></label>
                            <input type="radio" id="lR25" name="numLnrdResponse" value="2.5" <?php if ($lnrdResponse == "2.5") print "checked"; ?>/><label class="half" for="lR25" title="Kinda bad - 2.5 stars"></label>
                            <input type="radio" id="lR2" name="numLnrdResponse" value="2" <?php if ($lnrdResponse == "2") print "checked"; ?>/><label class = "full" for="lR2" title="Pretty bad - 2 stars"></label>
                            <input type="radio" id="lR15" name="numLnrdResponse" value="1.5" <?php if ($lnrdResponse == "1.5") print "checked"; ?>/><label class="half" for="lR15" title="Bad - 1.5 stars"></label>
                            <input type="radio" id="lR1" name="numLnrdResponse" value="1" <?php if ($lnrdResponse == "1") print "checked"; ?>/><label class = "full" for="lR1" title="Very bad - 1 star"></label>
                            <input type="radio" id="lR05" name="numLnrdResponse" value="0.5" <?php if ($lnrdResponse == "0.5") print "checked"; ?>/><label class="half" for="lR05" title="The worst - 0.5 stars"></label>
                        </fieldset>
                    </div>
                    <div id="landlordOverall" class="starsBox">
                        <p>How would you rate the landlord overall?</p>
                        <fieldset class="rating" id="landlordOverall">
                            <input type="radio" id="lO5" name="radLnrdOverall" value="5" <?php if ($landlordOverall == "5") print "checked"; ?>/><label class = "full" for="lO5" title="Awesome - 5 stars"></label>
                            <input type="radio" id="lO45" name="radLnrdOverall" value="4.5" <?php if ($landlordOverall == "4.5") print "checked"; ?>/><label class="half" for="lO45" title="Good - 4.5 stars"></label>
                            <input type="radio" id="lO4" name="radLnrdOverall" value="4" <?php if ($landlordOverall == "4") print "checked"; ?>/><label class = "full" for="lO4" title="Pretty good - 4 stars"></label>
                            <input type="radio" id="lO35" name="radLnrdOverall" value="3.5" <?php if ($landlordOverall == "3.5") print "checked"; ?>/><label class="half" for="lO35" title="Ok - 3.5 stars"></label>
                            <input type="radio" id="lO3" name="radLnrdOverall" value="3" <?php if ($landlordOverall == "3") print "checked"; ?>/><label class = "full" for="lO3" title="Meh - 3 stars"></label>
                            <input type="radio" id="lO25" name="radLnrdOverall" value="2.5" <?php if ($landlordOverall == "2.5") print "checked"; ?>/><label class="half" for="lO25" title="Kinda bad - 2.5 stars"></label>
                            <input type="radio" id="lO2" name="radLnrdOverall" value="2" <?php if ($landlordOverall == "2") print "checked"; ?>/><label class = "full" for="lO2" title="Pretty bad - 2 stars"></label>
                            <input type="radio" id="lO15" name="radLnrdOverall" value="1.5" <?php if ($landlordOverall == "1.5") print "checked"; ?>/><label class="half" for="lO15" title="Bad - 1.5 stars"></label>
                            <input type="radio" id="lO1" name="radLnrdOverall" value="1" <?php if ($landlordOverall == "1") print "checked"; ?>/><label class = "full" for="lO1" title="Very bad - 1 star"></label>
                            <input type="radio" id="lO05" name="radLnrdOverall" value="0.5" <?php if ($landlordOverall == "0.5") print "checked"; ?>/><label class="half" for="lO05" title="The worst - 0.5 stars"></label>
                        </fieldset>
                    </div>
                    <div id="landlordComments">
                        <!-- Comments -->
                        <p>Add any comments about your landlord</p>
                        <textarea name="txtLandlordComments" rows="10" cols="100"><?php print $landlordComments;?></textarea>
                    </div>
                </div>
                <div id="aptInfo" class="tab">
                    <div id="checks">
                        <!--Thin walls-->
                        <input type="checkbox" id="chkWalls" name="chkWalls" value="1" <?php if($walls) print " checked ";?>>
                        <label for="chkWalls">Thin walls</label>

                        <!--Subletting -->
                        <input type="checkbox" id="chkSublet" name="chkSublet" value="1" <?php if($subletting) print " checked ";?>>
                        <label for="chkSublet">Subletting allowed</label>

                        <!--Modifying walls-->
                        <input type="checkbox" id="chkPaint" name="chkPaint" value="1" <?php if($paint) print " checked ";?>>
                        <label for="chkPaint">Painting/Modifying walls allowed</label>
                    </div>

                    <div id="included">
                        <p>What's Included in Rent?</p>
                        <!-- Garbage -->
                        <input type="checkbox" id="chkGarbage" name="chkGarbage" value="1" <?php if($garbage) print " checked ";?>>
                        <label for="chkGarbage">Garbage</label>

                        <!-- Water -->
                        <input type="checkbox" id="chkWater" name="chkWater" value="1" <?php if($water) print " checked ";?>>
                        <label for="chkWater">Water</label>

                        <!-- Electricity -->
                        <input type="checkbox" id="chkElectricity" name="chkElectricity" value="1" <?php if($electricity) print " checked ";?>>
                        <label for="chkElectricity">Electricity</label>

                        <!-- Gas -->
                        <input type="checkbox" id="chkGas" name="chkGas" value="1" <?php if($gas) print " checked ";?>>
                        <label for="chkGas">Gas</label>

                        <!-- Wifi -->
                        <input type="checkbox" id="chkWifi" name="chkWifi" value="1" <?php if($wifi) print " checked ";?>>
                        <label for="chkWifi">Wifi/TV</label>

                        <!-- Snow Removal -->
                        <input type="checkbox" id="chkSnow" name="chkSnow" value="1" <?php if($snow) print " checked ";?>>
                        <label for="chkSnow">Snow Removal</label>

                        <!-- Parking -->
                        <input type="checkbox" id="chkParking" name="chkParking" value="1" <?php if($parking) print " checked ";?>>
                        <label for="chkParking">Parking</label>
                    </div>

                    <div id="pets">
                        <!-- Pets -->
                        <p>Are pets allowed?</p>
                        <input <?php if ($pets == "yes") print "checked"; ?> type="radio" id="radPetsYes" name="radPets" value="yes">
                        <label for="radPetsYes">Yes</label><br>
                        <input <?php if ($pets == "some") print "checked"; ?> type="radio" id="radPetsSome" name="radPets" value="some">
                        <label for="radPetsSome">Some</label><br>
                        <input <?php if ($pets == "no") print "checked"; ?> type="radio" id="radPetsNo" name="radPets" value="no">
                        <label for="radPetsNo">No</label>
                    </div>

                    <!--How Secure-->
                    <div id="secure">
                        <label for="numSecure">From 1-5 how secure is your apartment:</label>
                        <input type="number" name="numSecure" id="numSecure" value="<?php print $secure;?>">
                    </div>

                    <div id="heating">
                        <!-- Heating Type -->
                        <p>What type of heating is used?</p>
                        <input <?php if ($heating == "gas") print "checked"; ?> type="radio" id="radHeatGas" name="radHeat" value="gas">
                        <label for="radHeatGas">Gas</label><br>
                        <input <?php if ($heating == "electric") print "checked"; ?> type="radio" id="radHeatElectric" name="radHeat" value="electric">
                        <label for="radHeatElectric">Electric</label><br>
                        <input <?php if ($heating == "other") print "checked"; ?> type="radio" id="radHeatOther" name="radHeat" value="other">
                        <label for="radHeatOther">Other</label>
                    </div>

                    <!-- Maintenance Response -->
                    <div id="maintenance">
                        <label for="numMaintenance">From 1-5 how responsive are they to maintenance requests:</label>
                        <input type="number" name="numMaintenance" id="numMaintenance" value="<?php print $maintenance;?>">
                    </div>

                    <div id="comments">
                        <!-- Comments -->
                        <p>Add any comments</p>
                        <textarea name="txtComments" rows="10" cols="100"><?php print $comments;?></textarea>
                    </div>

                    <p><input type="submit" value="Submit"></p>
                </div>

                <div style="overflow:auto;">
                    <div style="float:right;">
                        <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                        <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                    </div>
                </div>
                <div style="text-align:center;margin-top:40px;">
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                </div>
            </form>
            <form id="regForm" action="">

                <h1>Register:</h1>

                <!-- One "tab" for each step in the form: -->
                <div class="tab">Name:
                    <p><input placeholder="First name..." oninput="this.className = ''"></p>
                    <p><input placeholder="Last name..." oninput="this.className = ''"></p>
                </div>

                <div class="tab">Contact Info:
                    <p><input placeholder="E-mail..." oninput="this.className = ''"></p>
                    <p><input placeholder="Phone..." oninput="this.className = ''"></p>
                </div>

                <div class="tab">Birthday:
                    <p><input placeholder="dd" oninput="this.className = ''"></p>
                    <p><input placeholder="mm" oninput="this.className = ''"></p>
                    <p><input placeholder="yyyy" oninput="this.className = ''"></p>
                </div>

                <div class="tab">Login Info:
                    <p><input placeholder="Username..." oninput="this.className = ''"></p>
                    <p><input placeholder="Password..." oninput="this.className = ''"></p>
                </div>

                <div style="overflow:auto;">
                    <div style="float:right;">
                        <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                        <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                    </div>
                </div>

                <!-- Circles which indicates the steps of the form: -->
                <div style="text-align:center;margin-top:40px;">
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                </div>

            </form>
            <?php
            if(edit){
                print '<p><a href="deleteListing?id=' . $listingID.'">Delete Review</a> </p>';
            }
            ?>
        </div>
        <?php
    }
    }else{
        header("Location:logIn");
    }

    include 'footer.php';
    ?>

</main>
</body>
</html>