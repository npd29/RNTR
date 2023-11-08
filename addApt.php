<?php
include 'top.php';
include 'classes.php';

$displayForm = true;
$dataIsValid = false;
$edit = false;
?><main id="addAptMain">
    <?php
    if (isset($_SESSION['username'])) { //if logged in
        $review = new Review($_SESSION['username']);
        $username = $review->getUsername();
        if (isset($_GET['edit']) and $_GET['edit'] == 'true') { //TODO: should this be just get id? is edit ever false
            $review->getReviewByID($_GET['id']);
            $edit = true;
            if (empty($review->getAddress1())) {
                header('Location:mySpace');
            }
        }
    }else{
        $review = new Review(null);
        $username = null;
    }
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
        //process form when submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {


            $info = pathinfo($_FILES['upload']['name']);

            $dataIsValid = true;
            //sanitize inputs and pass to review function
            //sets address fields and review/apartment IDs
            $review->setFullAddress(getData("txtAddress1"), getData("txtAddress2"), getData("txtCity"), getData("txtState"));
            //sets rest of variables
            $review->setReviewData(
                getData("numBedrooms"),
                getData("numBathrooms"),
                getData("txtLandlord"),
                getData("numLnrdResponse"),
                getData("radLnrdOverall"),
                getData("chkSublet"),
                getData("chkGarbage"),
                getData("chkWater"),
                getData("chkElectricity"),
                getData("chkGas"),
                getData("chkWifi"),
                getData("chkSnow"),
                getData("chkParking"),
                getData("radPets"),
                getData("numSecure"),
                getData("radHeat"),
                getData("txtComments"),
                getData("txtLandlordComments"),
                getData('radAptOverall'),
                getData('monthMoveIn'),
                getData('dayMoveIn'),
                getData('monthLease'),
                getData('dayLease'),
                getData('radLaundry'),
                getData('numCost')
            );

            //server side validation
            //if anything is wrong then don't let the form be submitted
            if ($review->getAddress1() == "" or $review->getCity() == "" or $review->getState() == "") {
                print '<p class = "mistake"> Please enter the full address</p>';
                $dataIsValid = false;
            }

            if ($review->getLandlord() == "") {
                print '<p class = "mistake"> Please enter the Landlord\'s name</p>';
                $dataIsValid = false;
            }

            if ($review->getAptOverall() > 5 or $review->getAptOverall() < 0) {
                print '<p class="mistake">Please enter an overall apartment between 1-5</p>';
            }
            if ($review->getLandlordOverall() > 5 or $review->getLandlordOverall() < 0) {
                print '<p class="mistake">Please enter a landlord overall rating between 1-5</p>';
            }
            if ($review->getLnrdResponse() > 5 or $review->getLnrdResponse() < 0) {
                print '<p class="mistake">Please enter a landlord response between 1-5</p>';
            }

            //if data is valid
            if ($dataIsValid) {

                if (isset($_SESSION['username'])) { //if logged in

                    include "insertApt.php";

                }else{//if not logged in save data as session variables
                    $_SESSION['savedReview'] = true;
                    $_SESSION["aptID"] = $review->getAptID();
                    $_SESSION["bedrooms"] = $review->getBedrooms();
                    $_SESSION["bathrooms"] = $review->getBathrooms();
                    $_SESSION["address1"] = $review->getAddress1();
                    $_SESSION["address2"] = $review->getAddress2();
                    $_SESSION["city"] = $review->getCity();
                    $_SESSION["state"] = $review->getState();
                    $_SESSION["zip"] = $review->getZip();
                    $_SESSION["landlord"] = $review->getLandlord();
                    $_SESSION["lnrdResponse"] = $review->getLnrdResponse();
                    $_SESSION["subletting"] = $review->isSubletting();
                    $_SESSION["garbage"] = $review->isGarbage();
                    $_SESSION["water"] = $review->isWater();
                    $_SESSION["wifi"] = $review->isWifi();
                    $_SESSION["electricity"] = $review->isElectricity();
                    $_SESSION["gas"] = $review->isGas();
                    $_SESSION["snow"] = $review->isSnow();
                    $_SESSION["parking"] = $review->isParking();
                    $_SESSION["pets"] = $review->getPets();
                    $_SESSION["secure"] = $review->getSecure();
                    $_SESSION["heating"] = $review->getHeating();
                    $_SESSION["aptOverall"] = $review->getAptOverall();
                    $_SESSION["landlordOverall"] = $review->getLandlordOverall();
                    $_SESSION["moveInMonth"] = $review->getMoveInMonth();
                    $_SESSION["moveInDay"] = $review->getMoveInDay();
                    $_SESSION["leaseMonth"] = $review->getLeaseMonth();
                    $_SESSION["leaseDay"] = $review->getLeaseDay();
                    $_SESSION["laundry"] = $review->getLaundry();
                    $_SESSION["cost"] = $review->getCost();
                    $_SESSION["comments"] = $review->getComments();
                    $_SESSION["landlordComments"] = $review->getLandlordComments();
                    header('Location: logIn');//redirect to login page
                }
            }

        }

        if ($displayForm) {
    ?>

            <script src="js/radio.js"></script>
            <script src="js/checkbox.js"></script>


            <div class="formBox" id="addApartmentFormBox">
                <form action="#" method="post" enctype="multipart/form-data" id="addAptForm">
                    <h1>My Review</h1>
                    <!-- One "tab" for each step in the form: -->
                    <div class="tab">
                        <div id="address1">
                            <!-- Address -->
                            <label for="txtAddress1">Address:</label>
                            <input type="text" name="txtAddress1" id="txtAddress1" oninput="this.className" value="<?php print $review->getAddress1(); ?>" required>
                        </div>

                        <div id="address2">
                            <!-- Address 2 -->
                            <label for="txtAddress2">Apartment #:</label>
                            <input type="text" name="txtAddress2" id="txtAddress2" oninput="this.className" value="<?php print $review->getAddress2(); ?>">
                        </div>
                        <div id="cityState">
                            <div id="city">
                                <!-- City -->
                                <label for="txtCity">City:</label>
                                <input type="text" name="txtCity" id="txtCity" oninput="this.className" value="<?php print $review->getCity(); ?>" required>
                            </div>

                            <div id="state">
                                <!-- State -->
                                <label for="txtState">State:</label>
                                <input type="text" name="txtState" id="txtState" oninput="this.className" value="<?php print $review->getState(); ?>" required>
                            </div>
                        </div>
                        <div id="bedBath">
                            <!-- Number of Rooms -->
                            <div id="bedrooms">
                                <label for="numBedrooms">Bedrooms:</label>
                                <input type="text" name="numBedrooms" id="numBedrooms" oninput="this.className" value="<?php print $review->getBedrooms(); ?>" required>
                            </div>

                            <!-- Number of Bathrooms -->
                            <div id="bathrooms">
                                <label for="numBathrooms">Bathrooms:</label>
                                <input type="text" name="numBathrooms" id="numBathrooms" oninput="this.className" value="<?php print $review->getBathrooms(); ?>" required>
                            </div>
                        </div>
                        <div id="aptOverall" class="starsBox">
                            <p>How would you rate your apartment overall?</p>
                            <fieldset class="rating" id="aptOverall">
                                <input type="radio" id="aO5" name="radAptOverall" value="5" <?php if ($review->getAptOverall() == "5") print "checked"; ?> /><label class="full" for="la5" title="Awesome - 5 stars"></label>
                                <input type="radio" id="aO45" name="radAptOverall" value="4.5" <?php if ($review->getAptOverall() == "4.5") print "checked"; ?> /><label class="half" for="aO45" title="Good - 4.5 stars"></label>
                                <input type="radio" id="aO4" name="radAptOverall" value="4" <?php if ($review->getAptOverall() == "4") print "checked"; ?> /><label class="full" for="aO4" title="Pretty good - 4 stars"></label>
                                <input type="radio" id="aO35" name="radAptOverall" value="3.5" <?php if ($review->getAptOverall() == "3.5") print "checked"; ?> /><label class="half" for="aO35" title="Ok - 3.5 stars"></label>
                                <input type="radio" id="aO3" name="radAptOverall" value="3" <?php if ($review->getAptOverall() == "3") print "checked"; ?> /><label class="full" for="aO3" title="Meh - 3 stars"></label>
                                <input type="radio" id="aO25" name="radAptOverall" value="2.5" <?php if ($review->getAptOverall() == "2.5") print "checked"; ?> /><label class="half" for="aO25" title="Kinda bad - 2.5 stars"></label>
                                <input type="radio" id="aO2" name="radAptOverall" value="2" <?php if ($review->getAptOverall() == "2") print "checked"; ?> /><label class="full" for="aO2" title="Pretty bad - 2 stars"></label>
                                <input type="radio" id="aO15" name="radAptOverall" value="1.5" <?php if ($review->getAptOverall() == "1.5") print "checked"; ?> /><label class="half" for="aO15" title="Bad - 1.5 stars"></label>
                                <input type="radio" id="aO1" name="radAptOverall" value="1" <?php if ($review->getAptOverall() == "1") print "checked"; ?> /><label class="full" for="aO1" title="Very bad - 1 star"></label>
                                <input type="radio" id="aO05" name="radAptOverall" value="0.5" <?php if ($review->getAptOverall() == "0.5") print "checked"; ?> /><label class="half" for="aO05" title="The worst - 0.5 stars"></label>
                            </fieldset>
                        </div>
                    </div>

                    <!--------------                   LANDLORD INFORMATION                             ----------->


                    <div class="tab">
                        <div id="landlordName">
                            <!-- Landlord Name-->
                            <label for="txtLandlord">Landlord Name:</label>
                            <input type="text" name="txtLandlord" id="txtLandlord" value="<?php print $review->getLandlord(); ?>" required>
                        </div>
                        <div id="landlordResponse" class="starsBox">
                            <!-- Landlord response-->
                            <p>How responsive is your landlord?</p>
                            <fieldset class="rating" id="landlordResponse">
                                <input type="radio" id="lR5" name="numLnrdResponse" value="5" <?php if ($review->getLnrdResponse() == "5") print "checked"; ?> /><label class="full" for="lR5" title="Awesome - 5 stars"></label>
                                <input type="radio" id="lR45" name="numLnrdResponse" value="4.5" <?php if ($review->getLnrdResponse() == "4.5") print "checked"; ?> /><label class="half" for="lR45" title="Good - 4.5 stars"></label>
                                <input type="radio" id="lR4" name="numLnrdResponse" value="4" <?php if ($review->getLnrdResponse() == "4") print "checked"; ?> /><label class="full" for="lR4" title="Pretty good - 4 stars"></label>
                                <input type="radio" id="lR35" name="numLnrdResponse" value="3.5" <?php if ($review->getLnrdResponse() == "3.5") print "checked"; ?> /><label class="half" for="lR35" title="Ok - 3.5 stars"></label>
                                <input type="radio" id="lR3" name="numLnrdResponse" value="3" <?php if ($review->getLnrdResponse() == "3") print "checked"; ?> /><label class="full" for="lR3" title="Meh - 3 stars"></label>
                                <input type="radio" id="lR25" name="numLnrdResponse" value="2.5" <?php if ($review->getLnrdResponse() == "2.5") print "checked"; ?> /><label class="half" for="lR25" title="Kinda bad - 2.5 stars"></label>
                                <input type="radio" id="lR2" name="numLnrdResponse" value="2" <?php if ($review->getLnrdResponse() == "2") print "checked"; ?> /><label class="full" for="lR2" title="Pretty bad - 2 stars"></label>
                                <input type="radio" id="lR15" name="numLnrdResponse" value="1.5" <?php if ($review->getLnrdResponse() == "1.5") print "checked"; ?> /><label class="half" for="lR15" title="Bad - 1.5 stars"></label>
                                <input type="radio" id="lR1" name="numLnrdResponse" value="1" <?php if ($review->getLnrdResponse() == "1") print "checked"; ?> /><label class="full" for="lR1" title="Very bad - 1 star"></label>
                                <input type="radio" id="lR05" name="numLnrdResponse" value="0.5" <?php if ($review->getLnrdResponse() == "0.5") print "checked"; ?> /><label class="half" for="lR05" title="The worst - 0.5 stars"></label>
                            </fieldset>
                        </div>
                        <div id="landlordOverall" class="starsBox">
                            <p>How would you rate the landlord overall?</p>
                            <fieldset class="rating" id="landlordOverall">
                                <input type="radio" id="lO5" name="radLnrdOverall" value="5" <?php if ($review->getLandlordOverall() == "5") print "checked"; ?> /><label class="full" for="lO5" title="Awesome - 5 stars"></label>
                                <input type="radio" id="lO45" name="radLnrdOverall" value="4.5" <?php if ($review->getLandlordOverall() == "4.5") print "checked"; ?> /><label class="half" for="lO45" title="Good - 4.5 stars"></label>
                                <input type="radio" id="lO4" name="radLnrdOverall" value="4" <?php if ($review->getLandlordOverall() == "4") print "checked"; ?> /><label class="full" for="lO4" title="Pretty good - 4 stars"></label>
                                <input type="radio" id="lO35" name="radLnrdOverall" value="3.5" <?php if ($review->getLandlordOverall() == "3.5") print "checked"; ?> /><label class="half" for="lO35" title="Ok - 3.5 stars"></label>
                                <input type="radio" id="lO3" name="radLnrdOverall" value="3" <?php if ($review->getLandlordOverall() == "3") print "checked"; ?> /><label class="full" for="lO3" title="Meh - 3 stars"></label>
                                <input type="radio" id="lO25" name="radLnrdOverall" value="2.5" <?php if ($review->getLandlordOverall() == "2.5") print "checked"; ?> /><label class="half" for="lO25" title="Kinda bad - 2.5 stars"></label>
                                <input type="radio" id="lO2" name="radLnrdOverall" value="2" <?php if ($review->getLandlordOverall() == "2") print "checked"; ?> /><label class="full" for="lO2" title="Pretty bad - 2 stars"></label>
                                <input type="radio" id="lO15" name="radLnrdOverall" value="1.5" <?php if ($review->getLandlordOverall() == "1.5") print "checked"; ?> /><label class="half" for="lO15" title="Bad - 1.5 stars"></label>
                                <input type="radio" id="lO1" name="radLnrdOverall" value="1" <?php if ($review->getLandlordOverall() == "1") print "checked"; ?> /><label class="full" for="lO1" title="Very bad - 1 star"></label>
                                <input type="radio" id="lO05" name="radLnrdOverall" value="0.5" <?php if ($review->getLandlordOverall() == "0.5") print "checked"; ?> /><label class="half" for="lO05" title="The worst - 0.5 stars"></label>
                            </fieldset>
                        </div>
                        <div id="landlordComments">
                            <!-- Comments -->
                            <p>Add any comments about your landlord</p>
                            <textarea name="txtLandlordComments" rows="10" cols="100"><?php print $review->getLandlordComments(); ?></textarea>
                        </div>
                    </div>

                    <!--------------                   ADDITIONAL INFORMATION                             ----------->

                    <div class="tab">
                        <!--Cost-->
                        <div class="box-cost">
                            <label for="numCost">What is the total cost of your apartment:</label>
                            <input type="number" name="numCost" id="numCost" value="<?php print $review->getCost(); ?>">
                        </div>

                        <!--Move in date-->

                        <div id="moveIn">
                            <select id='monthMoveIn' name="monthMoveIn">
                                <option value=''>Month</option>
                                <option <?php if ($review->getMoveInMonth()==1) print 'selected'; ?> value="1">1</option>
                                <option <?php if ($review->getMoveInMonth()==2) print 'selected'; ?> value="2">2</option>
                                <option <?php if ($review->getMoveInMonth()==3) print 'selected'; ?> value="3">3</option>
                                <option <?php if ($review->getMoveInMonth()==4) print 'selected'; ?> value="4">4</option>
                                <option <?php if ($review->getMoveInMonth()==5) print 'selected'; ?> value="5">5</option>
                                <option <?php if ($review->getMoveInMonth()==6) print 'selected'; ?> value="6">6</option>
                                <option <?php if ($review->getMoveInMonth()==7) print 'selected'; ?> value="7">7</option>
                                <option <?php if ($review->getMoveInMonth()==8) print 'selected'; ?> value="8">8</option>
                                <option <?php if ($review->getMoveInMonth()==9) print 'selected'; ?> value="9">9</option>
                                <option <?php if ($review->getMoveInMonth()==10) print 'selected'; ?> value="10">10</option>
                                <option <?php if ($review->getMoveInMonth()==11) print 'selected'; ?> value="11">11</option>
                                <option <?php if ($review->getMoveInMonth()==12) print 'selected'; ?> value="12">12</option>
                            </select>


                            <select id="dayMoveIn" name="dayMoveIn">
                                <option value="">Day</option>
                                <option <?php if ($review->getMoveInDay()==1) print 'selected'; ?> value="1">1</option>
                                <option <?php if ($review->getMoveInDay()==2) print 'selected'; ?> value="2">2</option>
                                <option <?php if ($review->getMoveInDay()==3) print 'selected'; ?> value="3">3</option>
                                <option <?php if ($review->getMoveInDay()==4) print 'selected'; ?> value="4">4</option>
                                <option <?php if ($review->getMoveInDay()==5) print 'selected'; ?> value="5">5</option>
                                <option <?php if ($review->getMoveInDay()==6) print 'selected'; ?> value="6">6</option>
                                <option <?php if ($review->getMoveInDay()==7) print 'selected'; ?> value="7">7</option>
                                <option <?php if ($review->getMoveInDay()==8) print 'selected'; ?> value="8">8</option>
                                <option <?php if ($review->getMoveInDay()==9) print 'selected'; ?> value="9">9</option>
                                <option <?php if ($review->getMoveInDay()==10) print 'selected'; ?> value="10">10</option>
                                <option <?php if ($review->getMoveInDay()==11) print 'selected'; ?> value="11">11</option>
                                <option <?php if ($review->getMoveInDay()==12) print 'selected'; ?> value="12">12</option>
                                <option <?php if ($review->getMoveInDay()==13) print 'selected'; ?> value="13">13</option>
                                <option <?php if ($review->getMoveInDay()==14) print 'selected'; ?> value="14">14</option>
                                <option <?php if ($review->getMoveInDay()==15) print 'selected'; ?> value="15">15</option>
                                <option <?php if ($review->getMoveInDay()==16) print 'selected'; ?> value="16">16</option>
                                <option <?php if ($review->getMoveInDay()==17) print 'selected'; ?> value="17">17</option>
                                <option <?php if ($review->getMoveInDay()==18) print 'selected'; ?> value="18">18</option>
                                <option <?php if ($review->getMoveInDay()==19) print 'selected'; ?> value="19">19</option>
                                <option <?php if ($review->getMoveInDay()==20) print 'selected'; ?> value="20">20</option>
                                <option <?php if ($review->getMoveInDay()==21) print 'selected'; ?> value="21">21</option>
                                <option <?php if ($review->getMoveInDay()==22) print 'selected'; ?> value="22">22</option>
                                <option <?php if ($review->getMoveInDay()==23) print 'selected'; ?> value="23">23</option>
                                <option <?php if ($review->getMoveInDay()==24) print 'selected'; ?> value="24">24</option>
                                <option <?php if ($review->getMoveInDay()==25) print 'selected'; ?> value="25">25</option>
                                <option <?php if ($review->getMoveInDay()==26) print 'selected'; ?> value="26">26</option>
                                <option <?php if ($review->getMoveInDay()==27) print 'selected'; ?> value="27">27</option>
                                <option <?php if ($review->getMoveInDay()==28) print 'selected'; ?> value="28">28</option>
                                <option <?php if ($review->getMoveInDay()==29) print 'selected'; ?> value="29">29</option>
                                <option <?php if ($review->getMoveInDay()==30) print 'selected'; ?> value="30">30</option>
                                <option <?php if ($review->getMoveInDay()==31) print 'selected'; ?> value="31">31</option>
                            </select>
                        </div>

                        <!--Lease date-->
                        <div id="leaseDate">
                            <select id='monthLease' name="monthLease">
                                <option value=''>Month</option>
                                <option <?php if ($review->getLeaseMonth()==1) print 'selected'; ?> value="1">1</option>
                                <option <?php if ($review->getLeaseMonth()==2) print 'selected'; ?> value="2">2</option>
                                <option <?php if ($review->getLeaseMonth()==3) print 'selected'; ?> value="3">3</option>
                                <option <?php if ($review->getLeaseMonth()==4) print 'selected'; ?> value="4">4</option>
                                <option <?php if ($review->getLeaseMonth()==5) print 'selected'; ?> value="5">5</option>
                                <option <?php if ($review->getLeaseMonth()==6) print 'selected'; ?> value="6">6</option>
                                <option <?php if ($review->getLeaseMonth()==7) print 'selected'; ?> value="7">7</option>
                                <option <?php if ($review->getLeaseMonth()==8) print 'selected'; ?> value="8">8</option>
                                <option <?php if ($review->getLeaseMonth()==9) print 'selected'; ?> value="9">9</option>
                                <option <?php if ($review->getLeaseMonth()==10) print 'selected'; ?> value="10">10</option>
                                <option <?php if ($review->getLeaseMonth()==11) print 'selected'; ?> value="11">11</option>
                                <option <?php if ($review->getLeaseMonth()==12) print 'selected'; ?> value="12">12</option>
                            </select>


                            <select id="dayLease" name="dayLease">
                                <option <?php if ($review->getLeaseDay()==1) print 'selected'; ?> value="1">1</option>
                                <option <?php if ($review->getLeaseDay()==2) print 'selected'; ?> value="2">2</option>
                                <option <?php if ($review->getLeaseDay()==3) print 'selected'; ?> value="3">3</option>
                                <option <?php if ($review->getLeaseDay()==4) print 'selected'; ?> value="4">4</option>
                                <option <?php if ($review->getLeaseDay()==5) print 'selected'; ?> value="5">5</option>
                                <option <?php if ($review->getLeaseDay()==6) print 'selected'; ?> value="6">6</option>
                                <option <?php if ($review->getLeaseDay()==7) print 'selected'; ?> value="7">7</option>
                                <option <?php if ($review->getLeaseDay()==8) print 'selected'; ?> value="8">8</option>
                                <option <?php if ($review->getLeaseDay()==9) print 'selected'; ?> value="9">9</option>
                                <option <?php if ($review->getLeaseDay()==10) print 'selected'; ?> value="10">10</option>
                                <option <?php if ($review->getLeaseDay()==11) print 'selected'; ?> value="11">11</option>
                                <option <?php if ($review->getLeaseDay()==12) print 'selected'; ?> value="12">12</option>
                                <option <?php if ($review->getLeaseDay()==13) print 'selected'; ?> value="13">13</option>
                                <option <?php if ($review->getLeaseDay()==14) print 'selected'; ?> value="14">14</option>
                                <option <?php if ($review->getLeaseDay()==15) print 'selected'; ?> value="15">15</option>
                                <option <?php if ($review->getLeaseDay()==16) print 'selected'; ?> value="16">16</option>
                                <option <?php if ($review->getLeaseDay()==17) print 'selected'; ?> value="17">17</option>
                                <option <?php if ($review->getLeaseDay()==18) print 'selected'; ?> value="18">18</option>
                                <option <?php if ($review->getLeaseDay()==19) print 'selected'; ?> value="19">19</option>
                                <option <?php if ($review->getLeaseDay()==20) print 'selected'; ?> value="20">20</option>
                                <option <?php if ($review->getLeaseDay()==21) print 'selected'; ?> value="21">21</option>
                                <option <?php if ($review->getLeaseDay()==22) print 'selected'; ?> value="22">22</option>
                                <option <?php if ($review->getLeaseDay()==23) print 'selected'; ?> value="23">23</option>
                                <option <?php if ($review->getLeaseDay()==24) print 'selected'; ?> value="24">24</option>
                                <option <?php if ($review->getLeaseDay()==25) print 'selected'; ?> value="25">25</option>
                                <option <?php if ($review->getLeaseDay()==26) print 'selected'; ?> value="26">26</option>
                                <option <?php if ($review->getLeaseDay()==27) print 'selected'; ?> value="27">27</option>
                                <option <?php if ($review->getLeaseDay()==28) print 'selected'; ?> value="28">28</option>
                                <option <?php if ($review->getLeaseDay()==29) print 'selected'; ?> value="29">29</option>
                                <option <?php if ($review->getLeaseDay()==30) print 'selected'; ?> value="30">30</option>
                                <option <?php if ($review->getLeaseDay()==31) print 'selected'; ?> value="31">31</option>
                            </select>
                        </div>
                        <div class="box-checks">
                            <!--Subletting -->
                            <div class="container-checkbox" onclick="adjustCheck('chkSublet')">
                                <input type="checkbox" id="chkSublet" name="chkSublet" value="1" <?php if ($review->isSubletting()) print " checked "; ?>>
                                <label class="label-checkbox" for="chkSublet">Subletting allowed</label>
                            </div>
                        </div>

                        <div class="box-checks-included">
                            <p>What's Included in Rent?</p>
                            <!-- Garbage -->
                            <div class="container-checkbox" onclick="adjustCheck('chkGarbage')">
                                <input type="checkbox" id="chkGarbage" name="chkGarbage" value="1" <?php if ($review->isGarbage()) print " checked "; ?>>
                                <label class="label-checkbox" for="chkGarbage">Garbage</label>
                            </div>

                            <!-- Water -->
                            <div class="container-checkbox" onclick="adjustCheck('chkWater')">
                                <input type="checkbox" id="chkWater" name="chkWater" value="1" <?php if ($review->isWater()) print " checked "; ?>>
                                <label class="label-checkbox" for="chkWater">Water</label>
                            </div>

                            <!-- Electricity -->
                            <div class="container-checkbox" onclick="adjustCheck('chkElectricity')">
                                <input type="checkbox" id="chkElectricity" name="chkElectricity" value="1" <?php if ($review->isElectricity()) print " checked "; ?>>
                                <label class="label-checkbox" for="chkElectricity">Electricity</label>
                            </div>

                            <!-- Gas -->
                            <div class="container-checkbox" onclick="adjustCheck('chkGas')">
                                <input type="checkbox" id="chkGas" name="chkGas" value="1" <?php if ($review->isGas()) print " checked "; ?>>
                                <label class="label-checkbox" for="chkGas">Gas</label>
                            </div>

                            <!-- Wifi -->
                            <div class="container-checkbox" onclick="adjustCheck('chkWifi')">
                                <input type="checkbox" id="chkWifi" name="chkWifi" value="1" <?php if ($review->isWifi()) print " checked "; ?>>
                                <label class="label-checkbox" for="chkWifi">Wifi/TV</label>
                            </div>

                            <!-- Snow Removal -->
                            <div class="container-checkbox" onclick="adjustCheck('chkSnow')">
                                <input type="checkbox" id="chkSnow" name="chkSnow" value="1" <?php if ($review->isSnow()) print " checked "; ?>>
                                <label class="label-checkbox" for="chkSnow">Snow Removal</label>
                            </div>

                            <!-- Parking -->
                            <div class="container-checkbox" onclick="adjustCheck('chkParking')">
                                <input type="checkbox" id="chkParking" name="chkParking" value="1" <?php if ($review->isParking()) print " checked "; ?>>
                                <label class="label-checkbox" for="chkParking">Parking</label>
                            </div>
                        </div>

                        <div class="box-radio-pets">
                            <!-- Pets -->
                            <p>Are pets allowed?</p>
                            <div class="box-radio">
                                <div class="container-radio" onclick="adjustRadio('pets', 'radPetsYes')">
                                    <input <?php if ($review->getPets() == "yes") print "checked"; ?> class="pets" type="radio" id="radPetsYes" name="radPets" value="yes">
                                    <label id="radlabel" for="radPetsYes">Yes</label><br>
                                </div>
                                <div class="container-radio" onclick="adjustRadio('pets', 'radPetsSome')">
                                    <input <?php if ($review->getPets() == "some") print "checked"; ?> class="pets" type="radio" id="radPetsSome" name="radPets" value="some">
                                    <label id="radlabel" for="radPetsSome">Some</label><br>
                                </div>
                                <div class="container-radio" onclick="adjustRadio('pets', 'radPetsNo')">
                                    <input <?php if ($review->getPets() == "no") print "checked"; ?> class="pets" type="radio" id="radPetsNo" name="radPets" value="no">
                                    <label id="radlabel" for="radPetsNo">No</label>
                                </div>
                            </div>
                        </div>

                        <!--How Secure-->
                        <div class="box-secure">
                            <label for="numSecure">From 1-5 how secure is your apartment:</label>
                            <input type="number" name="numSecure" id="numSecure" value="<?php print $review->getSecure(); ?>">
                        </div>

                        <div class="box-heating">
                            <!-- Heating Type -->
                            <p>What type of heating is used?</p>
                            <div class="box-radio">
                                <div class="container-radio" onclick="adjustRadio('heat', 'radHeatGas')">
                                    <input <?php if ($review->getHeating() == "gas") print "checked"; ?> class="heat" type="radio" id="radHeatGas" name="radHeat" value="gas">
                                    <label id="radlabel" for="radHeatGas">Gas</label><br>
                                </div>
                                <div class="container-radio" onclick="adjustRadio('heat', 'radHeatElectric')">
                                    <input <?php if ($review->getHeating() == "electric") print "checked"; ?> class="heat" type="radio" id="radHeatElectric" name="radHeat" value="electric">
                                    <label id="radlabel" for="radHeatElectric">Electric</label><br>
                                </div>
                                <div class="container-radio" onclick="adjustRadio('heat', 'radHeatOther')">
                                    <input <?php if ($review->getHeating() == "other") print "checked"; ?> class="heat" type="radio" id="radHeatOther" name="radHeat" value="other">
                                    <label id="radlabel" for="radHeatOther">Other</label>
                                </div>
                            </div>
                        </div>
                        <div class="box-comments">
                            <!-- Comments -->
                            <p>Add any comments</p>
                            <textarea name="txtComments" rows="10" cols="100"><?php print $review->getComments(); ?></textarea>
                        </div>

                    </div>

                    <!--------------                   UPLOAD IMAGES                             ----------->

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
                <script src="js/multiStepForm.js"></script>
                <?php
                if ($edit) {
                    //todo make this a cookie/session variable
                    print '<p id="deleteReview"><a href="deleteListing?id=' . $review->getReviewID() . '">Delete Review</a> </p>';
                }
                ?>
            </div>
    <?php
        }


    include 'footer.php';
    ?>

</main>
</body>

</html>