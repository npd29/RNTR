<?php
include 'top.php';
include 'classes.php';

if (isset($_GET['search'])) {
    $search = urldecode($_GET['search']);
    setcookie('search', $search);
    $search = trim($search);
    $search = filter_var($search, FILTER_SANITIZE_STRING);
    $search = htmlspecialchars($search);
    $searchString = explode(' ', $search);
    $displayArray = [];
    $alreadyDisplayed = false;
    $apartment = new Apartment(0, 0, "", "", "", "", "", "", 0, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "","", "", "", 0);


?>
    <main>
        <article id="searchArticle">
            <?php
            function bubble_Sort($apartments)
            {
                do {
                    $swapped = false;
                    for ($i = 0, $c = count($apartments) - 1; $i < $c; $i++) {
                        if ($apartments[$i]->getSimilarity() < $apartments[$i + 1]->getSimilarity()) {
                            list($apartments[$i + 1], $apartments[$i]) =
                                array(
                                    $apartments[$i], $apartments[$i + 1]
                                );
                            $swapped = true;
                        }
                    }
                } while ($swapped);
                return $apartments;
            }
            try {
                //if searching by address
                // if (is_numeric($searchString[0])) {
                foreach ($pdo->query("SELECT pmkApartmentID
                    FROM tblApartments
                    WHERE fldAddress1 LIKE '%" . $search . "%' OR fldLandlord LIKE '%" . $search . "%'
                    ORDER BY
                    CASE
                        WHEN fldAddress1 LIKE '" . $search . "' THEN 1
                        WHEN fldLandlord LIKE '" . $search . "' THEN 2
                        WHEN fldAddress1 LIKE '" . $search . "%' THEN 3
                        WHEN fldAddress1 LIKE '%" . $search . "' THEN 3
                        WHEN fldLandlord LIKE '" . $search . "%' THEN 4
                        WHEN fldLandlord LIKE '%" . $search . "' THEN 4
                        ELSE 5
                    END") as $row) {
                    $apartment = new Apartment(0, 0, "", "", "", "", "", "", 0, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "","", "", "", 0);

                    $alreadyDisplayed = false;
                    $apartment->getAptByID($row['pmkApartmentID']);
                    //get display image
                    foreach ($displayArray as $foo) {
                        if ($foo->getAptID() == $apartment->getAptID()) {
                            $alreadyDisplayed = true;
                        }
                    }
                    if (!$alreadyDisplayed) {
                        array_push($displayArray, $apartment); //add apartment id to displayed array
                    }
                }
                for ($i = 0; $i < count($searchString); $i++) {
                    $alreadyDisplayed = false;
                    $item = $searchString[$i];
                    foreach ($pdo->query("SELECT pmkApartmentID
                    FROM tblApartments
                    WHERE fldAddress1 LIKE '%" . $item . "%' OR fldLandlord LIKE '%" . $item . "%'
                    ORDER BY
                    CASE
                        WHEN fldAddress1 LIKE '" . $item . "' THEN 1
                        WHEN fldLandlord LIKE '" . $item . "' THEN 2
                        WHEN fldAddress1 LIKE '" . $item . "%' THEN 3
                        WHEN fldAddress1 LIKE '%" . $item . "' THEN 3
                        WHEN fldLandlord LIKE '" . $item . "%' THEN 4
                        WHEN fldLandlord LIKE '%" . $item . "' THEN 4
                        ELSE 5
                    END") as $row) {
                        $apartment = new Apartment(0, 0, "", "", "", "", "", "", 0, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "","", "", "", 0);

                        //get display image
                        $alreadyDisplayed = false;
                        $apartment->getAptByID($row['pmkApartmentID']);
                        //get display image
                        foreach ($displayArray as $foo) {
                            if ($foo->getAptID() == $apartment->getAptID()) {
                                $alreadyDisplayed = true;
                            }
                        }
                        if (!$alreadyDisplayed) {
                            array_push($displayArray, $apartment); //add apartment id to displayed array
                        }
                    }
                }

                //Assign similarity to each of the search results
                foreach ($displayArray as $apt) {
                    $lrdSimilarity = 0;
                    $addSimilarity = 0;
                    $addressArray = explode(' ', $apt->getAddress1());
                    $landlordArray = explode(' ', $apt->getLandlord());

                    foreach ($searchString as $searchItem) {
                        foreach ($addressArray as $addyItem) {
                            if (strtoupper($searchItem) == strtoupper($addyItem)) {
                                $addSimilarity++;
                            }
                        }
                        foreach ($landlordArray as $landlordItem) {
                            if (strtoupper($searchItem) == strtoupper($landlordItem)) {
                                $lrdSimilarity++;
                            }
                        }
                    }
                    // print '<p>APT:' . $apt->getAddress1() . ' L:' . $lrdSimilarity . ' A:' . $addSimilarity . '</p>';
                    if ($lrdSimilarity >= $addSimilarity) {
                        $apt->setSimilarity($lrdSimilarity);
                    } else {
                        $apt->setSimilarity($addSimilarity);
                    }
                }

                $displayArray = bubble_Sort($displayArray);

                foreach ($displayArray as $apt) {
                    print($apt->printCard());
                }
                if (sizeof($displayArray) == 0) {
                    print '<h3>Not seeing a lot of results? RNTR relies on people like you to review your apartment and landlord so others can benefit</h3>
                    <h3><a href="addApt">Add your review</a></h3>';
                }
            } catch (PDOException $e) {
                print '<p>Couldn\'t search. Contact someone</p>';
            }
            ?>
        </article>
        <?php
        include 'footer.php'
        ?>
    </main>
    </body>
<?php
} else {
    header("Location:/");
} ?>

</html>