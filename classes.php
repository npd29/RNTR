<?php

class Apartment
{
    private $bedrooms = 0;
    private $bathrooms = 0;
    private $address1 = '';
    private $address2 = '';
    private $city = '';
    private $state = '';
    private $zip = '';
    private $landlord = '';
    private $lnrdResponse = 0;
    private $subletting = false;
    private $garbage = false;
    private $water = false;
    private $electricity = false;
    private $gas = false;
    private $wifi = false;
    private $snow = false;
    private $parking = false;
    private $pets = 'unsure';
    private $secure = 0;
    private $heating = '';
    private $aptOverall = 0;
    private $landlordOverall = 0;
    private $aptID = 0;
    private $similarity = 0;
    private $moveInMonth = '';
    private $moveInDay = '';
    private $leaseMonth = '';
    private $leaseDay = '';
    private $laundry = '';
    private $cost = 0;


    /**
     * @param int $bedrooms
     * @param int $bathrooms
     * @param string $address1
     * @param string $address2
     * @param string $city
     * @param string $state
     * @param string $zip
     * @param string $landlord
     * @param int $lnrdResponse
     * @param bool $subletting
     * @param bool $garbage
     * @param bool $water
     * @param bool $electricity
     * @param bool $gas
     * @param bool $wifi
     * @param bool $snow
     * @param bool $parking
     * @param string $pets
     * @param int $secure
     * @param string $heating
     * @param int $aptOverall
     * @param int $landlordOverall
     */
    public function __construct($bedrooms, $bathrooms, $address1, $address2, $city, $state, $zip, $landlord, $lnrdResponse,
                                $subletting, $garbage, $water, $electricity, $gas, $wifi, $snow, $parking,
                                $pets, $secure, $heating, $aptOverall, $landlordOverall, $moveInMonth, $moveInDay, $leaseMonth,
                                $leaseDay, $laundry, $cost)
    {
        $this->bedrooms = $bedrooms;
        $this->bathrooms = $bathrooms;
        $this->address1 = $address1;
        $this->address2 = $address2;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
        $this->landlord = $landlord;
        $this->lnrdResponse = $lnrdResponse;
        $this->subletting = $subletting;
        $this->garbage = $garbage;
        $this->water = $water;
        $this->electricity = $electricity;
        $this->gas = $gas;
        $this->wifi = $wifi;
        $this->snow = $snow;
        $this->parking = $parking;
        $this->pets = $pets;
        $this->secure = $secure;
        $this->heating = $heating;
        $this->aptOverall = $aptOverall;
        $this->landlordOverall = $landlordOverall;
        $this->moveInMonth = $moveInMonth;
        $this->moveInDay = $moveInDay;
        $this->leaseMonth = $leaseMonth;
        $this->leaseDay = $leaseDay;
        $this->laundry = $laundry;
        $this->cost = $cost;
    }


    /**
     * @return int
     */
    public function getBedrooms()
    {
        return $this->bedrooms;
    }

    /**
     * @param int $bedrooms
     */
    public function setBedrooms($bedrooms)
    {
        $this->bedrooms = $bedrooms;
    }

    /**
     * @return int
     */
    public function getBathrooms()
    {
        return $this->bathrooms;
    }

    /**
     * @param int $bathrooms
     */
    public function setBathrooms($bathrooms)
    {
        $this->bathrooms = $bathrooms;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * @return int
     */
    public function getLnrdResponse()
    {
        return $this->lnrdResponse;
    }

    /**
     * @param int $lnrdResponse
     */
    public function setLnrdResponse($lnrdResponse)
    {
        $this->lnrdResponse = $lnrdResponse;
    }

    /**
     * @return bool
     */
    public function isSubletting()
    {
        return $this->subletting;
    }

    /**
     * @param bool $subletting
     */
    public function setSubletting($subletting)
    {
        $this->subletting = $subletting;
    }

    /**
     * @return bool
     */
    public function isGarbage()
    {
        return $this->garbage;
    }

    /**
     * @param bool $garbage
     */
    public function setGarbage($garbage)
    {
        $this->garbage = $garbage;
    }

    /**
     * @return bool
     */
    public function isWater()
    {
        return $this->water;
    }

    /**
     * @param bool $water
     */
    public function setWater($water)
    {
        $this->water = $water;
    }

    /**
     * @return bool
     */
    public function isElectricity()
    {
        return $this->electricity;
    }

    /**
     * @param bool $electricity
     */
    public function setElectricity($electricity)
    {
        $this->electricity = $electricity;
    }

    /**
     * @return bool
     */
    public function isGas()
    {
        return $this->gas;
    }

    /**
     * @param bool $gas
     */
    public function setGas($gas)
    {
        $this->gas = $gas;
    }

    /**
     * @return bool
     */
    public function isWifi()
    {
        return $this->wifi;
    }

    /**
     * @param bool $wifi
     */
    public function setWifi($wifi)
    {
        $this->wifi = $wifi;
    }

    /**
     * @return bool
     */
    public function isSnow()
    {
        return $this->snow;
    }

    /**
     * @param bool $snow
     */
    public function setSnow($snow)
    {
        $this->snow = $snow;
    }

    /**
     * @return bool
     */
    public function isParking()
    {
        return $this->parking;
    }

    /**
     * @param bool $parking
     */
    public function setParking($parking)
    {
        $this->parking = $parking;
    }

    /**
     * @return string
     */
    public function getPets()
    {
        return $this->pets;
    }

    /**
     * @param string $pets
     */
    public function setPets($pets)
    {
        $this->pets = $pets;
    }

    /**
     * @return int
     */
    public function getSecure()
    {
        return $this->secure;
    }

    /**
     * @param int $secure
     */
    public function setSecure($secure)
    {
        $this->secure = $secure;
    }

    /**
     * @return string
     */
    public function getHeating()
    {
        return $this->heating;
    }

    /**
     * @param string $heating
     */
    public function setHeating($heating)
    {
        $this->heating = $heating;
    }

    /**
     * @return int
     */
    public function getAptOverall()
    {
        return $this->aptOverall;
    }

    /**
     * @param int $aptOverall
     */
    public function setAptOverall($aptOverall)
    {
        $this->aptOverall = $aptOverall;
    }

    /**
     * @return int
     */
    public function getLandlordOverall()
    {
        return $this->landlordOverall;
    }

    /**
     * @param int $landlordOverall
     */
    public function setLandlordOverall($landlordOverall)
    {
        $this->landlordOverall = $landlordOverall;
    }

    /**
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param string $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * @return string
     */
    public function getMoveInMonth()
    {
        return $this->moveInMonth;
    }

    /**
     * @param string $moveIn
     * @return Apartment
     */
    public function setMoveInMonth($moveInMonth)
    {
        $this->moveInMonth = $moveInMonth;
    }

    /**
     * @return string
     */
    public function getMoveInDay()
    {
        return $this->moveInDay;
    }

    /**
     * @param string $moveIn
     * @return Apartment
     */
    public function setMoveInDay($moveInDay)
    {
        $this->moveInDay = $moveInDay;
    }

    /**
     * @return string
     */
    public function getLeaseMonth()
    {
        return $this->leaseMonth;
    }

    /**
     * @param string $leaseDate
     * @return Apartment
     */
    public function setLeaseMonth($leaseMonth)
    {
        $this->leaseMonth = $leaseMonth;
    }

    /**
     * @return string
     */
    public function getLeaseDay()
    {
        return $this->leaseDay;
    }

    /**
     * @param string $leaseDay
     * @return Apartment
     */
    public function setLeaseDay($leaseDay)
    {
        $this->leaseDay = $leaseDay;
    }

    /**
     * @return string
     */
    public function getLaundry()
    {
        return $this->laundry;
    }

    /**
     * @param string $laundry
     * @return Apartment
     */
    public function setLaundry($laundry)
    {
        $this->laundry = $laundry;
    }

    /**
     * @return int
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param int $cost
     * @return Apartment
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    /**
     * @return int
     */
    public function getSimilarity()
    {
        return $this->similarity;
    }

    /**
     * @param int $similarity
     */
    public function setSimilarity($similarity)
    {
        $this->similarity = $similarity;
    }

    public function insertApt()
    {
        include 'connect-DB.php';
        $aptSQL = "INSERT INTO tblApartments( fldAddress1,fldAddress2, fldCity, fldState, fldZIP, fldLandlord, fldBedrooms,
                          fldBathrooms, fldLandlordResponse, fldSubletting, fldGarbage, fldWater, 
                          fldElectricity, fldGas, fldWifi, fldSnow, fldParking, fldPets, fldSecure, fldHeating, 
                          fldApartmentOverall, fldLandlordOverall, fldMoveInMonth, fldMoveInDay, fldLeaseMonth, fldLeaseDay, fldLaundry, fldCost) 
                          VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $aptParams = array(
            $this->address1, $this->address2, $this->city, $this->state, $this->zip, $this->landlord, $this->bedrooms,
            $this->bathrooms, $this->lnrdResponse, $this->subletting, $this->garbage,
            $this->water, $this->electricity, $this->gas, $this->wifi, $this->snow, $this->parking, $this->pets, $this->secure,
            $this->heating, $this->aptOverall, $this->landlordOverall, $this->moveInMonth, $this->moveInDay, $this->leaseMonth,
            $this->leaseDay, $this->laundry, $this->cost
        );
        $aptStatement = $pdo->prepare($aptSQL);
        if ($aptStatement->execute($aptParams)) {
            $aptID = $pdo->query("SELECT LAST_INSERT_ID() FROM tblApartments")->fetch();
            $this->setAptID($aptID[0]);
            return true;
        } else {
            return false;
        }
    }

    public function updateApt()
    {
        include 'connect-DB.php';
        $aptSQL = "UPDATE tblApartments SET fldLandlord=?, fldBedrooms=?,fldBathrooms=?, fldLandlordResponse=?, 
                         fldSubletting=?, fldGarbage=?, fldWater=?, fldElectricity=?, fldGas=?, fldWifi=?, 
                         fldSnow=?, fldParking=?, fldPets=?, fldSecure=?, fldHeating=?, fldApartmentOverall=?, 
                         fldLandlordOverall=?,fldMoveInMonth=?, fldMoveInDay=?, fldLeaseMonth=?, fldLeaseDay=?, fldLaundry=?, fldCost=? WHERE pmkApartmentID='$this->aptID'";
        $aptParams = array(
            $this->landlord, $this->bedrooms, $this->bathrooms, $this->lnrdResponse, $this->subletting,
            $this->garbage, $this->water, $this->electricity, $this->gas, $this->wifi, $this->snow,
            $this->parking, $this->pets, $this->secure, $this->heating, $this->aptOverall, $this->landlordOverall,
            $this->moveInMonth, $this->moveInDay, $this->leaseMonth, $this->leaseDay, $this->laundry, $this->cost
        );
        $aptStatement = $pdo->prepare($aptSQL);
        if ($aptStatement->execute($aptParams)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * set the apartment info from database
     */
    public function getAptByID($aptID)
    {
        include 'connect-DB.php';
        $this->aptID = $aptID;
        foreach ($pdo->query("SELECT fldAddress1, fldAddress2, fldCity, fldState, fldZIP, fldLandlord, fldBedrooms, fldBathrooms, 
           fldLandlordResponse, fldSubletting, fldGarbage, fldWater, fldElectricity, fldGas, fldWifi, 
           fldSnow, fldParking, fldPets, fldSecure, fldHeating, fldApartmentOverall, fldLandlordOverall, 
            fldMoveInMonth, fldMoveInDay, fldLeaseMonth, fldLeaseDay, fldLaundry, fldCost FROM tblApartments WHERE pmkApartmentID='$aptID'") as $row) {
            $this->address1 = $row['fldAddress1'];
            $this->address2 = $row['fldAddress2'];
            $this->city = $row['fldCity'];
            $this->state = $row['fldState'];
            $this->zip = $row['fldZIP'];
            $this->landlord = $row['fldLandlord'];
            $this->bedrooms = $row['fldBedrooms'];
            $this->bathrooms = $row['fldBathrooms'];
            $this->garbage = $row['fldGarbage'];
            $this->electricity = $row['fldElectricity'];
            $this->water = $row['fldWater'];
            $this->parking = $row['fldParking'];
            $this->gas = $row['fldGas'];
            $this->wifi = $row['fldWifi'];
            $this->snow = $row['fldSnow'];
            $this->lnrdResponse = $row['fldLandlordResponse'];
            $this->subletting = $row['fldSubletting'];
            $this->secure = $row['fldSecure'];
            $this->pets = $row['fldPets'];
            $this->heating = $row['fldHeating'];
            $this->aptOverall = $row['fldApartmentOverall'];
            $this->landlordOverall = $row['fldLandlordOverall'];
            $this->moveInMonth = $row['fldMoveInMonth'];
            $this->moveInDay = $row['fldMoveInDay'];
            $this->leaseMonth = $row['fldLeaseMonth'];
            $this->leaseDay = $row['fldLeaseDay'];
            $this->laundry = $row['fldLaundry'];
            $this->cost = $row['fldCost'];
        }
    }

    public function isSame($other)//why the fuck can't you overload operators in PHP
    {
        return ($this->getAptID() == $other->getAptID());
    }

    /**
     * @return int
     */
    public function getAptID()
    {
        include 'connect-DB.php';
        if ($this->aptID == 0) {
            $aptID = $pdo->query("SELECT pmkApartmentID FROM tblApartments WHERE fldAddress1='$this->address1' AND fldAddress2='$this->address2' AND fldCity='$this->city' AND fldState='$this->state'")->fetch();
            return $aptID[0];
        }
        return $this->aptID;
    }

    /**
     * @param int $aptID
     * @return Apartment
     */
    public function setAptID($aptID)
    {
        $this->aptID = $aptID;
        return $this;
    }

    /**
     * @return string
     * @var string
     */
    public function printCard()
    {
        include 'connect-DB.php';
        //TODO: make this an array and pass to js https://www.geeksforgeeks.org/how-to-pass-a-php-array-to-a-javascript-function/
        $imageRow = $pdo->query("SELECT fldImageID FROM tblImages WHERE fkAptID=" . $this->getAptID())->fetch();
        $imageID = $imageRow['fldImageID'];
        if ($imageID != "") {
            $imgName = $imageID;
        } else {
            $imgName = 'default.svg';
        }
        return ('<a href="apartment?id=' . $this->getAptID() . '">
                    <div id="reviewBox">
                        <img class="loader" id="reviewPreview" src="/images/uploaded/' . $imgName . '">
                        <div id="reviewBoxBottom">
                            <h3 id="address"> ' . $this->getAddress1() . ' - ' . $this->getAddress2() . '</h3>
                            <h4 id="landlord">' . $this->getLandlord() . '</h4>
                        </div>
                    </div></a>');
    }

    /**
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @param string $address1
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;
    }

    /**
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @param string $address2
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
    }

    /**
     * @return string
     */
    public function getLandlord()
    {
        return $this->landlord;
    }

    /**
     * @param string $landlord
     */
    public function setLandlord($landlord)
    {
        $this->landlord = $landlord;
    }
}

class Review extends Apartment
{
    private $reviewID = 0;
    private $comments = "";
    private $username = "";
    private $landlordComments = "";
    private $new = false;
    private $numEdits = 0;

    public function __construct($username)
    {
        parent::__construct(0, 0, "", "", "", "", "", "",
            0, "", "", "", "", "", "", "",
            "", "", "", "", "", "", "", "", "", "", "", 0);
        $this->setUsername($username);
    }

    public function setReviewVars($bedrooms, $bathrooms, $address1, $address2, $city, $state, $zip, $landlord, $lnrdResponse,
                                  $subletting, $garbage, $water, $electricity, $gas, $wifi, $snow, $parking,
                                  $pets, $secure, $heating, $aptOverall, $landlordOverall, $comments,
                                  $landlordComments, $username, $moveInMonth, $moveInDay, $leaseMonth, $leaseDay, $laundry, $cost)
    {
        parent::__construct($bedrooms, $bathrooms, $address1, $address2, $city, $state, $zip, $landlord, $lnrdResponse,
            $subletting, $garbage, $water, $electricity, $gas, $wifi, $snow, $parking, $pets, $secure,
            $heating, $aptOverall, $landlordOverall, $moveInMonth, $moveInDay, $leaseMonth, $leaseDay, $laundry, $cost);
        $this->username = $username;
        $this->landlordComments = $landlordComments;
        $this->comments = $comments;
    }

    public function getNew()
    {
        return $this->new;
    }

    public function getNumEdits()
    {
        return $this->numEdits;
    }

    /**
     * @param $address1
     * @param $address2
     * @param $city
     * @param $state
     * @return void
     * Sets review ID if the user has already reviewed that apartment
     * sets apartment ID if that address has been reviewed before
     */
    public function setFullAddress($address1, $address2, $city, $state)
    {
        include 'connect-DB.php';
        $username = $this->getUsername();
        $address1 = urlencode($address1);
        $address2 = urlencode($address2);
        $city = urlencode($city);
        $state = urlencode($state);
        include 'smartyStreets.php';
        $address1 = explode('And', $address1);
        $address2 = explode('And', $address2);
        $address1 = implode($address1);
        $address2 = implode($address2);
        $address1 = preg_replace('/\s+/', ' ', $address1);
        $this->setAddress1($address1);
        $address2 = ltrim($address2, '#');
        $address2 = explode('And', $address2);
        $address2 = implode($address2);
        $this->setAddress2($address2);
        $city = explode('And', $city);
        $city = implode($city);
        $this->city = preg_replace('/\s+/', ' ', $city);
        $this->setCity($city);
        $this->state = urldecode($state);
        $this->setState($state);
        foreach ($pdo->query("SELECT pmkListingID FROM tblReviews WHERE fldAddress1='$address1'
                                     AND fldAddress2='$address2'AND fldCity='$city'AND fldState='$state' AND fkUsername='$username' AND fldDeleted=0") as $row) {
            $this->reviewID = $row['pmkListingID'];
        }
        foreach ($pdo->query("SELECT pmkApartmentID FROM tblApartments WHERE fldAddress1='$address1'
                                     AND fldAddress2='$address2'AND fldCity='$city'AND fldState='$state'") as $row) {
            $this->setAptID($row['pmkApartmentID']);
        }
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return Review
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setReviewData(
        $bedrooms,
        $bathrooms,
        $landlord,
        $lnrdResponse,
        $landlordOverall,
        $subletting,
        $garbage,
        $water,
        $electricity,
        $gas,
        $wifi,
        $snow,
        $parking,
        $pets,
        $secure,
        $heating,
        $comments,
        $landlordComments,
        $aptOverall,
        $moveInMonth,
        $moveInDay,
        $leaseMonth,
        $leaseDay,
        $laundry,
        $cost
    )
    {
        $this->setBedrooms($bedrooms);
        $this->setBathrooms($bathrooms);
        $this->setLandlord($landlord);
        $this->setLnrdResponse($lnrdResponse);
        $this->setSubletting($subletting);
        $this->setGarbage($garbage);
        $this->setWater($water);
        $this->setElectricity($electricity);
        $this->setGas($gas);
        $this->setWifi($wifi);
        $this->setSnow($snow);
        $this->setParking($parking);
        $this->setPets($pets);
        $this->setSecure($secure);
        $this->setHeating($heating);
        $this->setComments($comments);
        $this->setLandlordComments($landlordComments);
        $this->setLandlordOverall($landlordOverall);
        $this->setAptOverall($aptOverall);
        $this->setMoveInMonth($moveInMonth);
        $this->setMoveInDay($moveInDay);
        $this->setLeaseMonth($leaseMonth);
        $this->setLeaseDay($leaseDay);
        $this->setLaundry($laundry);
        $this->setCost($cost);
    }

    public function getReviewByID($reviewID)
    {
        include 'connect-DB.php';
        $username = $this->getUsername();
        $this->setReviewID($reviewID);
        foreach ($pdo->query("SELECT fldAddress1, fldAddress2, fldCity, fldState, fldZIP, fldLandlord, fldBedrooms, fldBathrooms, 
           fldLandlordResponse, fldSubletting, fldGarbage, fldWater, fldElectricity, fldGas, fldWifi, 
           fldSnow, fldParking, fldPets, fldSecure, fldHeating, fldComments, fldApartmentOverall, 
            fldLandlordOverall, fldLandlordComments, fkAptID, fldMoveInMonth, fldMoveInDay, fldLeaseMonth, fldLeaseDay, fldLaundry, fldCost FROM tblReviews 
            WHERE pmkListingID=" . $reviewID . " AND fldDeleted = 0 AND fkUsername='" . $username . "';") as $row) {

            $this->setAddress1($row['fldAddress1']);
            $this->setAddress2($row['fldAddress2']);
            $this->setCity($row['fldCity']);
            $this->setState($row['fldState']);
            $this->setZip($row['fldZIP']);
            $this->setLandlord($row['fldLandlord']);
            $this->setBedrooms($row['fldBedrooms']);
            $this->setBathrooms($row['fldBathrooms']);
            $this->setGarbage($row['fldGarbage']);
            $this->setElectricity($row['fldElectricity']);
            $this->setWater($row['fldWater']);
            $this->setParking($row['fldParking']);
            $this->setGas($row['fldGas']);
            $this->setWifi($row['fldWifi']);
            $this->setSnow($row['fldSnow']);
            $this->setLnrdResponse($row['fldLandlordResponse']);
            $this->setSubletting($row['fldSubletting']);
            $this->setSecure($row['fldSecure']);
            $this->setPets($row['fldPets']);
            $this->setHeating($row['fldHeating']);
            $this->setAptOverall($row['fldApartmentOverall']);
            $this->setLandlordOverall($row['fldLandlordOverall']);
            $this->setComments($row['fldComments']);
            $this->setLandlordComments($row['fldLandlordComments']);
            $this->setAptID($row['fkAptID']);
            $this->setMoveInMonth($row['fldMoveInMonth']);
            $this->setMoveInDay($row['fldMoveInDay']);
            $this->setLeaseMonth($row['fldLeaseMonth']);
            $this->setLeaseDay($row['fldLeaseDay']);
            $this->setLaundry($row['fldLaundry']);
            $this->setCost($row['fldCost']);
        }
    }

    public function getIDbyAddress()
    {
        include 'connect-DB.php';
        $address1 = $this->getAddress1();
        $address2 = $this->getAddress2();
        $city = $this->getCity();
        $state = $this->getState();
        foreach ($pdo->query("SELECT pmkListingID FROM tblReviews WHERE fldAddress1='$address1'
                                     AND fldAddress2='$address2'AND fldCity='$city'AND fldState='$state' AND fkUsername='$this->username' AND fldDeleted=0") as $row) {
            $this->reviewID = $row['pmkListingID'];
        }
        foreach ($pdo->query("SELECT pmkApartmentID FROM tblApartments WHERE fldAddress1='$address1'
                                     AND fldAddress2='$address2'AND fldCity='$city'AND fldState='$state'") as $row) {
            $this->setAptID($row['pmkApartmentID']);
        }
    }

    public function insertReview()
    {
        include 'connect-DB.php';
        $this->new = true;
        $sql = 'INSERT INTO tblReviews (fldAddress1, fldAddress2, fldCity, fldState, fldZIP, fldLandlord, fldBedrooms, 
                        fldBathrooms,fkUsername, fldLandlordResponse, fldSubletting, fldGarbage, fldWater, 
                        fldElectricity, fldGas, fldWifi, fldSnow, fldParking, fldPets, fldSecure, fldHeating, 
                        fldComments, fldApartmentOverall, fldLandlordOverall, fldLandlordComments, fldTime, fldMoveInMonth, 
                        fldMoveInDay, fldLeaseMonth, fldLeaseDay, fldLaundry, fldCost) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,now(),?,?,?,?,?,?)';
        $params = array(
            $this->getAddress1(), $this->getAddress2(), $this->getCity(), $this->getState(), $this->getZip(), $this->getLandlord(),
            $this->getBedrooms(), $this->getBathrooms(), $this->getUsername(), $this->getLnrdResponse(),
            $this->isSubletting(), $this->isGarbage(), $this->isWater(), $this->isElectricity(),
            $this->isGas(), $this->isWifi(), $this->isSnow(), $this->isParking(), $this->getPets(), $this->getSecure(),
            $this->getHeating(), $this->getComments(), $this->getAptOverall(), $this->getLandlordOverall(),
            $this->getLandlordComments(), $this->getMoveInMonth(), $this->getMoveInDay(), $this->getLeaseMonth(), $this->getLeaseDay(), $this->getLaundry(), $this->getCost()
        );
        $statement = $pdo->prepare($sql);

        $numEdits = $pdo->query("SELECT count(*) FROM tblEdits WHERE fldEditTime >= now()-INTERVAL 10 MINUTE AND fkUsername='$this->username'")->fetch();
        if ($numEdits[0] > 15 and $this->username != "ndesmara") { //if they have made too many changes in the time period
            header('Location: mySpace');
        } else {
            $displayForm = false;
            if ($statement->execute($params)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param string $comments
     * @return Review
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * @return string
     */
    public function getLandlordComments()
    {
        return $this->landlordComments;
    }

    /**
     * @param string $landlordComments
     * @return Review
     */
    public function setLandlordComments($landlordComments)
    {
        $this->landlordComments = $landlordComments;
        return $this;
    }

    public function updateReview()
    {
        include 'connect-DB.php';
        $sql = 'UPDATE tblReviews SET fldAddress1=?,fldAddress2=?, fldCity=?, fldState=?, fldZIP=?, fldLandlord=?, fldBedrooms=?,
                      fldBathrooms=?, fkUsername=?, fldLandlordResponse=?, fldSubletting=?, fldGarbage=?,
                      fldWater=?, fldElectricity=?, fldGas=?, fldWifi=?, fldSnow=?,fldParking=?, fldPets=?, fldSecure=?, 
                      fldHeating=?, fldComments=?, fldApartmentOverall=?, fldLandlordOverall=?, fldLandlordComments=?, 
                      fldTime=now(), fldMoveInMonth=?, fldMoveInDay=?, fldLeaseMonth=?, fldLeaseDay=?, fldLaundry=?, fldCost=? WHERE pmkListingID=' . $this->getReviewID();
        $params = array(
            $this->getAddress1(), $this->getAddress2(), $this->getCity(), $this->getState(), $this->getZip(), $this->getLandlord(),
            $this->getBedrooms(), $this->getBathrooms(), $this->getUsername(), $this->getLnrdResponse(), $this->isSubletting(),
            $this->isGarbage(), $this->isWater(), $this->isElectricity(), $this->isGas(), $this->isWifi(),
            $this->isSnow(), $this->isParking(), $this->getPets(), $this->getSecure(), $this->getHeating(),
            $this->getComments(), $this->getAptOverall(), $this->getLandlordOverall(), $this->getLandlordComments(),
            $this->getMoveInMonth(), $this->getMoveInDay(), $this->getLeaseMonth(), $this->getLeaseDay(), $this->getLaundry(), $this->getCost()
        );

        $statement = $pdo->prepare($sql);
        $numEdits = $pdo->query("SELECT count(*) FROM tblEdits WHERE fldEditTime >= now()-INTERVAL 10 MINUTE AND fkUsername='$this->username'")->fetch();
        if ($numEdits[0] > 15 and $this->username != "ndesmara") { //if they have made too many changes in the time period

            header('Location: mySpace');
        } else {
            $displayForm = false;
            if ($statement->execute($params)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * @return int
     */
    public function getReviewID()
    {
        return $this->reviewID;
    }

    /**
     * @param int $reviewID
     * @return Review
     */
    public function setReviewID($reviewID)
    {
        $this->reviewID = $reviewID;
    }

    public function checkPrevReviews()
    {
        include 'connect-DB.php';
        foreach ($pdo->query("SELECT fldAddress1, fldAddress2, fldCity, fldState, pmkListingID, fkAptID FROM tblReviews WHERE fkUsername='$this->username' AND fldDeleted=0") as $row) {
            if ($this->getAddress1() == $row['fldAddress1'] and $this->getAddress2() == $row['fldAddress2'] and $this->getCity() == $row['fldCity'] and $this->getState() == $row['fldState']) {
                $this->setReviewID($row['pmkListingID']);
                $this->setAptID($row['fkAptID']);
            }
        }
        return $this->getReviewID();
    }
}

?>
