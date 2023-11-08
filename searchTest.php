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
    $apartment = new Apartment(0, 0, "", "", "", "", "", "", 0, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "","",0);


?>
    <main>
        <article id="searchArticle">
            <?php
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
                    $alreadyDisplayed = false;
                    //get display image
                    foreach ($displayArray as $foo) {
                        if ($foo == $row['pmkApartmentID']) {
                            $alreadyDisplayed = true;
                        }
                    }
                    if (!$alreadyDisplayed) {
                        $apartment->getAptByID($row['pmkApartmentID']);
                        print $apartment->printCard();
                        array_push($displayArray, $row['pmkApartmentID']); //add apartment id to displayed array
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
                        //get display image
                        foreach ($displayArray as $foo) {
                            if ($foo == $row['pmkApartmentID']) {
                                $alreadyDisplayed = true;
                            }
                        }
                        if (!$alreadyDisplayed) {
                            $apartment->getAptByID($row['pmkApartmentID']);
                            print $apartment->printCard();
                            array_push($displayArray, $row['pmkApartmentID']); //add apartment id to displayed array
                        }
                    }
                }
                if (sizeof($displayArray) == 0) {
                    print '<h3>No Results...yet <a href="addApt">Add your own</a></h3>';
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