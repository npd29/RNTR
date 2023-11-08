<?php
//this page is for displaying aggregated apartment results after searching
//TODO: Get rid of top.php and make it fill with apt address and description
session_start();
$phpSelf = htmlspecialchars($_SERVER['PHP_SELF']);
$path_parts = pathinfo($phpSelf);
include 'classes.php';

if (isset($_GET['id'])) {
    $apartment = new Apartment(0, 0, "", "", "", "", "", "", 0, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "",0);
    $id = $_GET['id'];
    $apartment->getAptByID($id);
}
?>
<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset="UTF-8">
        <title>RNTR - <?php print $apartment->getAddress1().' - '.$apartment->getAddress2().' '.$apartment->getCity().', '.$apartment->getState()?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Noel Desmarais">
        <meta name="description" content="The most honest apartment review of <?php print $apartment->getAddress1().' - '.$apartment->getAddress2().' from RNTR'?>">
        <link rel="stylesheet" href="css/custom.css?version=<?php print time(); ?>" type="text/css">
        <link rel="stylesheet" media="(max-width: 800px)" href="css/custom-tablet.css?version=<?php print time(); ?>" type="text/css">
        <link rel="stylesheet" media="(max-width: 600px)" href="css/custom-phone.css?version=<?php print time(); ?>" type="text/css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora:400,700|Montserrat:300">
    </head>
<?php
    print '<body id="' . $path_parts['filename'] . '">';

include 'nav.php';
include 'connect-DB.php';
print '<main><article>';

print '<a href="search?search=' . urlencode($_COOKIE['search']) . '">← Back</a>';
print'<div class="boxAptTop"><div class="boxAptAddress">';
print '<h1>' . $apartment->getAddress1() . ' ' . $apartment->getAddress2() . '</h1><h4>' . $apartment->getCity() . ', ' . $apartment->getState() . '</h4></div>';
print '</div><div class="star-rating" title="' . ($apartment->getAptOverall() * 20) . '%">
            <div class="back-stars">
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
        
                <div class="front-stars" style="width:' . ($apartment->getAptOverall() * 20) . '%">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                </div>
            </div>
        </div></div>';
?>
<div class="boxAptRow1">
    <div class="boxAptRow1Left">
        <div class="boxAptPics">
            <div class="boxAptPic1"></div>
            <div class="boxAptPics23">
                <div class="boxAptPic2"></div>
                <div class="boxAptPic3"></div>
            </div>
        </div>
        <div class="boxAptBedBath"><h3><?php print $apartment->getBedrooms()?> Bed <?php print $apartment->getBathrooms()?> Bath</h3></div>
        <div class="boxAptCost"><h3>$<?php print $apartment->getCost()?> - $<?php print $apartment->getCost()/$apartment->getBedrooms()?>/room</h3></div>
    </div>
    <div class="boxAptLandlord">
        <h1>Landlord</h1>
        <h2><?php print $apartment->getLandlord()?></h2>
    </div>

</div>
<div class="boxAptRow2">
    <div class="boxAptDates">
        <h3>average date of lease signed</h3>
        <h2><?php print $apartment->getLeaseMonth()?>/<?php print $apartment->getLeaseDay()?></h2>
        <h3>move in date</h3>
        <h2><?php print $apartment->getMoveInMonth()?>/<?php print $apartment->getMoveInDay()?></h2>
    </div>
    <div class="boxAptMap"></div>
</div>
<div class="boxAptRow3">
    <div class="boxAptIncluded">
        <h4 class="gas
            <?php
                if ($apartment->isGas()) {
                    print ' include-active';
                }
            ?>
            ">Gas
        </h4>
        <h4 class="water
            <?php
        if ($apartment->isWater()) {
            print ' include-active';
        }
        ?>
            ">Water
        </h4>
        <h4 class="wifi
            <?php
        if ($apartment->isWifi()) {
            print ' include-active';
        }
        ?>
            ">Internet
        </h4>
        <h4 class="parking
            <?php
        if ($apartment->isParking()) {
            print ' include-active';
        }
        ?>
            ">Parking
        </h4>
        <h4 class="trash
            <?php
        if ($apartment->isGarbage()) {
            print ' include-active';
        }
        ?>
            ">Garbage Removal
        </h4>
        <h4 class="electricity
            <?php
        if ($apartment->isElectricity()) {
            print ' include-active';
        }
        ?>
            ">Electricity
        </h4>
        <h4 class="snow
            <?php
        if ($apartment->isSnow()) {
            print ' include-active';
        }
        ?>
            ">Snow Removal
        </h4>

    </div>
    <div class="boxAptIncludedText"><h2><span class="emphasis">Included</span> with rent</h2><h3>(because free stuff is nice)</h3></div>
</div>

<div class="boxAptRow4">
    <?php
    foreach ($pdo->query("SELECT fldComments FROM tblReviews WHERE fldDeleted=0 AND fkAptID='$id'") as $item) {
        print '<div class="boxComment"><p class="comment">' . $item['fldComments'] . '</p></div>';
    }
    ?>
</div>


<div id="aptPicsDiv">
    <?php
    foreach ($pdo->query("SELECT fldImageID FROM tblImages WHERE fkAptID='$id'") as $item) {
        print '<div class="boxAptPic"><img src="images/uploaded/' . $item['fldImageID'] . '" class="aptPics"></div>';
    }
    ?></div>
<?php
print '<h4>' . $apartment->getBedrooms() . ' Bed   ' . $apartment->getBathrooms() . ' Bath</h4>';



print '<h3>Other Information</h3>';
if ($apartment->getWalls()) {
    print '<p>Walls are thin</p>';
}
if ($apartment->isSubletting()) {
    print '<p>Subletting Allowed</p>';
}
if ($apartment->isPaint()) {
    print '<p>Able to make cosmetic changes to walls</p>';
}
print ('<p>Landlord Response: </p>
        <div class="star-rating" title="' . ($apartment->getLnrdResponse() * 20) . '%">
            <div class="back-stars">
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
        
                <div class="front-stars" style="width:' . ($apartment->getLnrdResponse() * 20) . '%">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                </div>
            </div>
        </div>');
print '<h3>Comments</h3>';
foreach ($pdo->query("SELECT fldComments FROM tblReviews WHERE fldDeleted=0 AND fkAptID='$id'") as $item) {
    print '<p>' . $item['fldComments'] . '</p>';
}
?>
<div id="aptPicsDiv">
    <?php
    foreach ($pdo->query("SELECT fldImageID FROM tblImages WHERE fkAptID='$id'") as $item) {
        print '<img src="images/uploaded/' . $item['fldImageID'] . '" class="aptPics">';
    }
    ?></div>
</article>
<?php
include 'footer.php'
?>
</main>
</body>

</html>