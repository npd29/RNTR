<?php
include 'top.php';
include 'classes.php';

$displayForm = true;
$dataIsValid = false;
$edit=false;
?><main>
    <?php

    if(isset($_SESSION['username'])){//if logged in
        $review = new Review($_SESSION['username']);
        $username=$review->getUsername();
        if(isset($_GET['edit']) AND $_GET['edit']=='true'){//TODO: should this be just get id? is edit ever false
            $review->getReviewByID($_GET['id']);
            $edit = true;
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
        //process form when submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $info = pathinfo($_FILES['upload']['name']);

            $dataIsValid = true;
            //sanitize inputs and pass to review function
            $review->setFullAddress(getData("txtAddress1"),getData("txtAddress2"),getData("txtCity"),getData("txtState"), $username);
            $review->setReviewData(getData("numBedrooms"),getData("numBathrooms"),getData("txtLandlord"),getData("numLnrdResponse"),
                getData("radLnrdOverall"),getData("chkWalls"),getData("chkSublet"),getData("chkPaint"),getData("chkGarbage"),
                getData("chkWater"), getData("chkElectricity"),getData("chkGas"), getData("chkWifi"),getData("chkSnow"),
                getData("chkParking"), getData("radPets"), getData("numSecure"),getData("radHeat"),getData("numMaintenance"),
                getData("txtComments"), getData("txtLandlordComments"), getData("numViews"), getData("numLocation"),getData('numAptOverall'));

            //server side validation
            //if anything is wrong then don't let the form be submitted
            if ($review->getAddress1() == "" OR $review->getCity() =="" OR $review->getState() =="") {
                print '<p class = "mistake"> Please enter the full address</p>';
                $dataIsValid = false;
            }

            if ($review->getLandlord() == "") {
                print '<p class = "mistake"> Please enter the Landlord\'s name</p>';
                $dataIsValid = false;
            }

            if ($review->getPets() != 'yes' AND $review->getPets() != 'no' AND $review->getPets() != 'some' AND $review->getPets() != ''){
                print '<p class="mistake">Please choose one of the answers for pets</p>';
                $dataIsValid = false;
            }
            if ($review->getLnrdResponse()>5 OR $review->getLnrdResponse()<0){
                print '<p class="mistake">Please enter a landlord response between 1-5</p>';
            }
            if ($review->getAptOverall()>5 OR $review->getAptOverall()<0){
                print '<p class="mistake">Please enter an overall apartment between 1-5</p>';
            }
            if ($review->getLandlordOverall()>5 OR $review->getLandlordOverall()<0){
                print '<p class="mistake">Please enter a landlord overall rating between 1-5</p>';
            }
            if ($review->getMaintenance()>5 OR $review->getMaintenance()<0){
                print '<p class="mistake">Please enter a maintenance response rating between 1-5</p>';
                $dataIsValid = false;
            }
            if ($review->getLnrdResponse()>5 OR $review->getLnrdResponse()<0){
                print '<p class="mistake">Please enter a landlord response between 1-5</p>';
            }

            //if data is valid
            if ($dataIsValid) {
                try {
                    //check for similar addresses (used when editing)
                    //search to see if youve already reviewed this apartment
                    $listingID = $review->getReviewID();
                    //if the listing isnt already in the apartments table, add it
                    if ($listingID == 0) {
                        $review->insertReview();
                    } else {
                        $review->updateReview();
                    }


                    /*
                    TODO: put insert into numedits to after update apt table
                    TODO: dont need $edit and !$edit variations
                    TODO: then send fldListingID and fldAptID to tblEdits table
                    TODO: then check watchlist for that AptID and if fldSendEmail send an email to fldEmail
      */


                } catch (PDOException $e) {
                    if (!$edit){
                        print '<p>Couldn\'t add the apartment. Contact RNTR </p>';
                    }else{
                        print '<p>Couldn\'t update the listing. Contact RNTR </p>';
                    }
                }

                if ($review->getNumEdits() < 15 OR $username == 'ndesmara') {
                    //AVERAGE THE VALUES
                    $apartment = new Apartment(0, 0, "", "", "", "", "", "", 0, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "","",0);
                    $aptID=$review->getAptID();
                    //get the bedroom mode
                    foreach ($pdo->query("SELECT fldBedrooms
                FROM   tblReviews WHERE fkAptID='$aptID'
                GROUP  BY fldBedrooms
                ORDER  BY COUNT(*) DESC 
                LIMIT 1") as $row) {
                        $apartment->setBedrooms($row['fldBedrooms']);
                    }
                    //get the bathroom mode
                    foreach ($pdo->query("SELECT fldBathrooms
                FROM   tblReviews WHERE fkAptID='$aptID'
                GROUP  BY fldBathrooms
                ORDER  BY COUNT(*) DESC
                LIMIT 1") as $row) {

                        $apartment->setBathrooms($row['fldBathrooms']);
                    }

                    //get the average of the rest of them
                    $row = $pdo->query("SELECT Avg(fldLandlordResponse), Avg(fldWalls), Avg(fldSubletting), Avg(fldPaint), Avg( 
                                fldGarbage), Avg(fldWater), Avg(fldElectricity), Avg(fldGas), Avg(fldWifi), Avg(fldSnow), Avg(
                                fldParking), Avg(fldSecure), Avg(fldMaintenance), Avg(fldApartmentOverall), Avg(fldLandlordOverall), Avg(fldViews), Avg(fldLocation) FROM tblReviews 
                                    WHERE fkAptID='$aptID'")->fetch();
                    $apartment->setLnrdResponse(round($row[0], 1));
                    $apartment->setWalls(round($row[1], 0));
                    $apartment->setSubletting(round($row[2], 0));
                    $apartment->setPaint(round($row[3]));
                    $apartment->setGarbage(round($row[4]));
                    $apartment->setWater(round($row[5]));
                    $apartment->setElectricity(round($row[6]));
                    $apartment->setGas(round($row[7]));
                    $apartment->setWifi(round($row[8]));
                    $apartment->setSnow(round($row[9]));
                    $apartment->setParking(round($row[10]));
                    $apartment->setSecure(round($row[11], 1));
                    $apartment->setMaintenance(round($row[12], 1));
                    $apartment->setAptOverall(round($row[13], 1));
                    $apartment->setLandlordOverall(round($row[14], 1));
                    $apartment->setViews(round($row[15], 1));
                    $apartment->setLocation(round($row[16], 1));

                    //get the mode for if pets are allowed
                    foreach ($pdo->query("SELECT fldPets
                FROM tblReviews WHERE fkAptID='$aptID'
                GROUP  BY fldPets
                ORDER  BY COUNT(*) DESC 
                LIMIT 1") as $row) {
                        $pets = $row['fldPets'];
                    }
                    //get the mode for what type of heating
                    foreach ($pdo->query("SELECT fldHeating
                FROM tblReviews WHERE fkAptID='$aptID'
                GROUP  BY fldHeating
                ORDER  BY COUNT(*) DESC 
                LIMIT 1") as $row) {
                        $heating = $row['fldHeating'];
                    }

                    if ($aptID != 0) {//if the apartment exists in the tablw
                        $sqlRun = $apartment->updateApt();
                    } else {//if it's a new apartment
                        $sqlRun = $apartment->insertApt();
                    }
                    $listingID=$review->getReviewID();
                    if ($sqlRun) {
                        $pdo->query("INSERT INTO tblEdits(fkUsername, fldEditTime, fkAptID, fkListingID) VALUES('$username', now(), '$aptID', '$listingID')");
                        $update = "UPDATE tblReviews SET fkAptID=? WHERE pmkListingID='$listingID'";
                        $updateStatement=$pdo->prepare($update);
                        $params=array($aptID);
                        $updateStatement->execute($params);

                        $imageSQL = 'INSERT INTO tblImages (fkUsername, fkAptID, fkReviewID, fldImageID) VALUES (?,?,?,?)';
                        $numPhotos = $pdo->query("SELECT count(*) FROM tblImages WHERE fkAptID = '$aptID' AND fkReviewID = '$listingID' AND fkUsername='$username'")->fetch();

                        $imageStatement = $pdo->prepare($imageSQL);
                        $imgID = ($aptID.$listingID.$numPhotos[0]);

                        //TODO: get apt/review id and concat imgID

                        //upload the file
                        $info = pathinfo($_FILES['upload']['name']);
                        $ext = $info['extension']; // get the extension of the file
                        if ($info['extension']!=""){
                            $newName = $imgID.'.'.$ext;
                            $target = 'images/uploaded/'.$newName;
                            move_uploaded_file( $_FILES['upload']['tmp_name'], $target);
                            $imageParams = array($username, $aptID, $listingID, $newName);
                            $imageStatement->execute($imageParams);
                        }


                        //check the watchlist database and send out emails about the apartment being updated
                        include "checkWatchlist.php";
                    }
                    if (!$review->getNew()) {
                        header('Location: mySpace?update=true');
                    } else {
                        header('Location: mySpace?add=true');
                    }
                }
            }
        }

        if ($displayForm){
            ?>
            <script>
                window.onload=function(){
                    document.getElementById('addAptForm').reset();
                    checkRadio('pets');
                    checkRadio('heat');
                    checkCheck();
                };
                function checkCheck(){
                    let elements = document.querySelectorAll('input[type=checkbox]');
                    for (let i = 0; i < elements.length; i++) {
                        if (elements[i].checked){
                            elements[i].parentElement.style.backgroundColor="var(--brightblue)";
                        }else{
                            elements[i].parentElement.style.background="0";
                        }
                    }

                }
                function checkRadio(x){
                    let elements = document.getElementsByClassName(x);
                    for (let i=0;i<elements.length;i++){
                        if (elements[i].checked){
                            elements[i].parentElement.style.backgroundColor="var(--brightblue)";
                        }else{
                            elements[i].parentElement.style.background="0";
                        }
                    }
                }
                function adjustCheck(x){
                    let element = document.getElementById(x);
                    if (element.checked){
                        element.parentElement.style.background="0";
                        element.checked=false;
                    }else{
                        element.parentElement.style.backgroundColor="var(--brightblue)";
                        element.checked=true;
                    }
                }
                function adjustRadio(x, y){
                    let elements = document.getElementsByClassName(x);
                    for (let i=0;i<elements.length;i++){
                        if (elements[i].id === y){
                            elements[i].checked=true;
                            elements[i].parentElement.style.backgroundColor="var(--brightblue)";
                        }else{
                            elements[i].parentElement.style.background="0";
                            elements[i].checked=false;

                        }
                    }
                }
            </script>

            <div class="formBox" id="addApartmentFormBox">
                <form action="#" method="post" enctype="multipart/form-data" id="addAptForm">
                    <!-- One "tab" for each step in the form: -->
                    <div class="tab">
                        <div id="address1">
                            <!-- Address -->
                            <label for="txtAddress1">Address:</label>
                            <input type="text" name="txtAddress1" id="txtAddress1" oninput="this.className" value="<?php print $review->getAddress1();?>" required>
                        </div>

                        <div id="address2">
                            <!-- Address 2 -->
                            <label for="txtAddress2">Apartment #:</label>
                            <input type="text" name="txtAddress2" id="txtAddress2" oninput="this.className" value="<?php print $review->getAddress2();?>">
                        </div>
                        <div id="cityState">
                            <div id="city">
                                <!-- City -->
                                <label for="txtCity">City:</label>
                                <input type="text" name="txtCity" id="txtCity" oninput="this.className" value="<?php print $review->getCity();?>" required>
                            </div>

                            <div id="state">
                                <!-- State -->
                                <label for="txtState">State:</label>
                                <input type="text" name="txtState" id="txtState" oninput="this.className" value="<?php print $review->getState();?>" required>
                            </div>
                        </div>
                        <div id="bedBath">
                            <!-- Number of Rooms -->
                            <div id="bedrooms">
                                <label for="numBedrooms">Bedrooms:</label>
                                <input type="text" name="numBedrooms" id="numBedrooms" oninput="this.className" value="<?php print $review->getBedrooms();?>" required>
                            </div>

                            <!-- Number of Bathrooms -->
                            <div id="bathrooms">
                                <label for="numBathrooms">Bathrooms:</label>
                                <input type="text" name="numBathrooms" id="numBathrooms" oninput="this.className" value="<?php print $review->getBathrooms();?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="tab">
                        <div id="landlordName">
                            <!-- Landlord Name-->
                            <label for="txtLandlord">Landlord Name:</label>
                            <input type="text" name="txtLandlord" id="txtLandlord" value="<?php print $review->getLandlord();?>" required>
                        </div>
                        <div id="landlordResponse" class="starsBox">
                            <!-- Landlord response-->
                            <p>How responsive is your landlord?</p>
                            <fieldset class="rating" id="landlordResponse">
                                <input type="radio" id="lR5" name="numLnrdResponse" value="5" <?php if ($review->getLnrdResponse() == "5") print "checked"; ?>/><label class = "full" for="lR5" title="Awesome - 5 stars"></label>
                                <input type="radio" id="lR45" name="numLnrdResponse" value="4.5" <?php if ($review->getLnrdResponse() == "4.5") print "checked"; ?>/><label class="half" for="lR45" title="Good - 4.5 stars"></label>
                                <input type="radio" id="lR4" name="numLnrdResponse" value="4" <?php if ($review->getLnrdResponse() == "4") print "checked"; ?>/><label class = "full" for="lR4" title="Pretty good - 4 stars"></label>
                                <input type="radio" id="lR35" name="numLnrdResponse" value="3.5" <?php if ($review->getLnrdResponse() == "3.5") print "checked"; ?>/><label class="half" for="lR35" title="Ok - 3.5 stars"></label>
                                <input type="radio" id="lR3" name="numLnrdResponse" value="3" <?php if ($review->getLnrdResponse() == "3") print "checked"; ?>/><label class = "full" for="lR3" title="Meh - 3 stars"></label>
                                <input type="radio" id="lR25" name="numLnrdResponse" value="2.5" <?php if ($review->getLnrdResponse() == "2.5") print "checked"; ?>/><label class="half" for="lR25" title="Kinda bad - 2.5 stars"></label>
                                <input type="radio" id="lR2" name="numLnrdResponse" value="2" <?php if ($review->getLnrdResponse() == "2") print "checked"; ?>/><label class = "full" for="lR2" title="Pretty bad - 2 stars"></label>
                                <input type="radio" id="lR15" name="numLnrdResponse" value="1.5" <?php if ($review->getLnrdResponse() == "1.5") print "checked"; ?>/><label class="half" for="lR15" title="Bad - 1.5 stars"></label>
                                <input type="radio" id="lR1" name="numLnrdResponse" value="1" <?php if ($review->getLnrdResponse() == "1") print "checked"; ?>/><label class = "full" for="lR1" title="Very bad - 1 star"></label>
                                <input type="radio" id="lR05" name="numLnrdResponse" value="0.5" <?php if ($review->getLnrdResponse() == "0.5") print "checked"; ?>/><label class="half" for="lR05" title="The worst - 0.5 stars"></label>
                            </fieldset>
                        </div>
                        <div id="landlordOverall" class="starsBox">
                            <p>How would you rate the landlord overall?</p>
                            <fieldset class="rating" id="landlordOverall">
                                <input type="radio" id="lO5" name="radLnrdOverall" value="5" <?php if ($review->getLandlordOverall() == "5") print "checked"; ?>/><label class = "full" for="lO5" title="Awesome - 5 stars"></label>
                                <input type="radio" id="lO45" name="radLnrdOverall" value="4.5" <?php if ($review->getLandlordOverall() == "4.5") print "checked"; ?>/><label class="half" for="lO45" title="Good - 4.5 stars"></label>
                                <input type="radio" id="lO4" name="radLnrdOverall" value="4" <?php if ($review->getLandlordOverall() == "4") print "checked"; ?>/><label class = "full" for="lO4" title="Pretty good - 4 stars"></label>
                                <input type="radio" id="lO35" name="radLnrdOverall" value="3.5" <?php if ($review->getLandlordOverall() == "3.5") print "checked"; ?>/><label class="half" for="lO35" title="Ok - 3.5 stars"></label>
                                <input type="radio" id="lO3" name="radLnrdOverall" value="3" <?php if ($review->getLandlordOverall() == "3") print "checked"; ?>/><label class = "full" for="lO3" title="Meh - 3 stars"></label>
                                <input type="radio" id="lO25" name="radLnrdOverall" value="2.5" <?php if ($review->getLandlordOverall() == "2.5") print "checked"; ?>/><label class="half" for="lO25" title="Kinda bad - 2.5 stars"></label>
                                <input type="radio" id="lO2" name="radLnrdOverall" value="2" <?php if ($review->getLandlordOverall() == "2") print "checked"; ?>/><label class = "full" for="lO2" title="Pretty bad - 2 stars"></label>
                                <input type="radio" id="lO15" name="radLnrdOverall" value="1.5" <?php if ($review->getLandlordOverall() == "1.5") print "checked"; ?>/><label class="half" for="lO15" title="Bad - 1.5 stars"></label>
                                <input type="radio" id="lO1" name="radLnrdOverall" value="1" <?php if ($review->getLandlordOverall() == "1") print "checked"; ?>/><label class = "full" for="lO1" title="Very bad - 1 star"></label>
                                <input type="radio" id="lO05" name="radLnrdOverall" value="0.5" <?php if ($review->getLandlordOverall() == "0.5") print "checked"; ?>/><label class="half" for="lO05" title="The worst - 0.5 stars"></label>
                            </fieldset>
                        </div>
                        <div id="landlordComments">
                            <!-- Comments -->
                            <p>Add any comments about your landlord</p>
                            <textarea name="txtLandlordComments" rows="10" cols="100"><?php print $review->getLandlordComments();?></textarea>
                        </div>
                    </div>
                    <div class="tab">
                        <div id="checks">
                            <!--Thin walls-->
                            <div class="checkDiv" onclick="adjustCheck('chkWalls')">
                                <input type="checkbox" id="chkWalls" name="chkWalls" value="1" <?php if($review->getWalls()) print " checked ";?>>
                                <label class="checkLabel" for="chkWalls">Thin walls</label>
                            </div>
                            <!--Subletting -->
                            <div class="checkDiv" onclick="adjustCheck('chkSublet')">
                                <input type="checkbox" id="chkSublet" name="chkSublet" value="1" <?php if($review->isSubletting()) print " checked ";?>>
                                <label class="checkLabel" for="chkSublet">Subletting allowed</label>
                            </div>
                            <!--Modifying walls-->
                            <div class="checkDiv" onclick="adjustCheck('chkPaint')">
                                <input type="checkbox" id="chkPaint" name="chkPaint" value="1" <?php if($review->isPaint()) print " checked ";?>>
                                <label class="checkLabel" for="chkPaint">Painting/Modifying walls allowed</label>
                            </div>
                        </div>

                        <div id="included">
                            <p>What's Included in Rent?</p>
                            <!-- Garbage -->
                            <div class="checkDiv" onclick="adjustCheck('chkGarbage')">
                                <input type="checkbox" id="chkGarbage" name="chkGarbage" value="1" <?php if($review->isGarbage()) print " checked ";?>>
                                <label class="checkLabel" for="chkGarbage">Garbage</label>
                            </div>

                            <!-- Water -->
                            <div class="checkDiv" onclick="adjustCheck('chkWater')">
                                <input type="checkbox" id="chkWater" name="chkWater" value="1" <?php if($review->isWater()) print " checked ";?>>
                                <label class="checkLabel" for="chkWater">Water</label>
                            </div>

                            <!-- Electricity -->
                            <div class="checkDiv" onclick="adjustCheck('chkElectricity')">
                                <input type="checkbox" id="chkElectricity" name="chkElectricity" value="1" <?php if($review->isElectricity()) print " checked ";?>>
                                <label class="checkLabel" for="chkElectricity">Electricity</label>
                            </div>

                            <!-- Gas -->
                            <div class="checkDiv" onclick="adjustCheck('chkGas')">
                                <input type="checkbox" id="chkGas" name="chkGas" value="1" <?php if($review->isGas()) print " checked ";?>>
                                <label class="checkLabel" for="chkGas">Gas</label>
                            </div>

                            <!-- Wifi -->
                            <div class="checkDiv" onclick="adjustCheck('chkWifi')">
                                <input type="checkbox" id="chkWifi" name="chkWifi" value="1" <?php if($review->isWifi()) print " checked ";?>>
                                <label class="checkLabel" for="chkWifi">Wifi/TV</label>
                            </div>

                            <!-- Snow Removal -->
                            <div class="checkDiv" onclick="adjustCheck('chkSnow')">
                                <input type="checkbox" id="chkSnow" name="chkSnow" value="1" <?php if($review->isSnow()) print " checked ";?>>
                                <label class="checkLabel" for="chkSnow">Snow Removal</label>
                            </div>

                            <!-- Parking -->
                            <div class="checkDiv" onclick="adjustCheck('chkParking')">
                                <input type="checkbox" id="chkParking" name="chkParking" value="1" <?php if($review->isParking()) print " checked ";?>>
                                <label class="checkLabel" for="chkParking">Parking</label>
                            </div>
                        </div>

                        <div id="pets">
                            <!-- Pets -->
                            <p>Are pets allowed?</p>
                            <div class="radioDiv">
                                <div class="petsSubDiv" onclick="adjustRadio('pets', 'radPetsYes')">
                                    <input  <?php if ($review->getPets() == "yes") print "checked"; ?> class="pets" type="radio" id="radPetsYes" name="radPets" value="yes">
                                    <label id="radlabel" for="radPetsYes">Yes</label><br>
                                </div>
                                <div class="petsSubDiv" onclick="adjustRadio('pets', 'radPetsSome')">
                                    <input  <?php if ($review->getPets() == "some") print "checked"; ?> class="pets" type="radio" id="radPetsSome" name="radPets" value="some">
                                    <label id="radlabel" for="radPetsSome">Some</label><br>
                                </div>
                                <div class="petsSubDiv" onclick="adjustRadio('pets', 'radPetsNo')">
                                    <input <?php if ($review->getPets() == "no") print "checked"; ?> class="pets" type="radio" id="radPetsNo" name="radPets" value="no">
                                    <label id="radlabel" for="radPetsNo">No</label>
                                </div>
                            </div>
                        </div>

                        <!--How Secure-->
                        <div id="secure">
                            <label for="numSecure">From 1-5 how secure is your apartment:</label>
                            <input type="number" name="numSecure" id="numSecure" value="<?php print $review->getSecure();?>">
                        </div>

                        <div id="heating">
                            <!-- Heating Type -->
                            <p>What type of heating is used?</p>
                            <div class="radioDiv">
                                <div class="heatSubDiv" onclick="adjustRadio('heat', 'radHeatGas')">
                                    <input <?php if ($review->getHeating() == "gas") print "checked"; ?> class="heat" type="radio" id="radHeatGas" name="radHeat" value="gas">
                                    <label id="radlabel" for="radHeatGas">Gas</label><br>
                                </div>
                                <div class="heatSubDiv" onclick="adjustRadio('heat', 'radHeatElectric')">
                                    <input <?php if ($review->getHeating() == "electric") print "checked"; ?> class="heat" type="radio" id="radHeatElectric" name="radHeat" value="electric">
                                    <label id="radlabel" for="radHeatElectric">Electric</label><br>
                                </div>
                                <div class="heatSubDiv" onclick="adjustRadio('heat', 'radHeatOther')">
                                    <input <?php if ($review->getHeating() == "other") print "checked"; ?> class="heat" type="radio" id="radHeatOther" name="radHeat" value="other">
                                    <label id="radlabel" for="radHeatOther">Other</label>
                                </div>
                            </div>
                        </div>

                        <!-- Maintenance Response -->
                        <div id="maintenance">
                            <label for="numMaintenance">From 1-5 how responsive are they to maintenance requests:</label>
                            <input type="number" name="numMaintenance" id="numMaintenance" value="<?php print $review->getMaintenance();?>">
                        </div>

                        <div id="comments">
                            <!-- Comments -->
                            <p>Add any comments</p>
                            <textarea name="txtComments" rows="10" cols="100"><?php print $review->getComments();?></textarea>
                        </div>

                    </div>
                    <div class="tab">
                        <label for="upload">Select image:</label>
                        <input type="file" id="upload" name="upload" accept="image/*">
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
                <script>
                    var currentTab = 0; // Current tab is set to be the first tab (0)
                    showTab(currentTab); // Display the current tab

                    function showTab(n) {
                        // This function will display the specified tab of the form ...
                        var x = document.getElementsByClassName("tab");
                        x[n].style.display = "block";
                        // ... and fix the Previous/Next buttons:
                        if (n == 0) {
                            document.getElementById("prevBtn").style.display = "none";
                        } else {
                            document.getElementById("prevBtn").style.display = "inline";
                        }
                        if (n == (x.length - 1)) {
                            document.getElementById("nextBtn").innerHTML = "Submit";
                        } else {
                            document.getElementById("nextBtn").innerHTML = "Next";
                        }
                        // ... and run a function that displays the correct step indicator:
                        fixStepIndicator(n)
                        window.scrollTo(0,0);
                    }


                    function nextPrev(n) {
                        // This function will figure out which tab to display
                        var x = document.getElementsByClassName("tab");
                        // Exit the function if any field in the current tab is invalid:
                        // Hide the current tab:
                        x[currentTab].style.display = "none";
                        // Increase or decrease the current tab by 1:
                        currentTab = currentTab + n;
                        // if you have reached the end of the form... :
                        if (currentTab >= x.length) {
                            //...the form gets submitted:
                            document.getElementById("addAptForm").submit();
                            return false;
                        }
                        // Otherwise, display the correct tab:
                        showTab(currentTab);
                    }



                    function fixStepIndicator(n) {
                        // This function removes the "active" class of all steps...
                        var i, x = document.getElementsByClassName("step");
                        for (i = 0; i < x.length; i++) {
                            x[i].className = x[i].className.replace(" active", "");
                        }
                        //... and adds the "active" class to the current step:
                        x[n].className += " active";
                    }
                </script>
                <?php
                if($edit){
                    print '<p id="deleteReview"><a href="deleteListing?id=' . $review->getReviewID().'">Delete Review</a> </p>';
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