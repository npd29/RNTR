<?php
include 'top.php';
$dataIsValid = false;
$displayForm = true;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = getData('txtSearch');
} else {
    $search = '';
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
?>
<main id="homeMain">
    <figure id="homeDisplay" class="home">
        <div class="page-one">
            <h1 class="home">RNTR.</h1>
            <h2>say goodbye to your sh*tty landlord</h2>

            <?php if ($displayForm) {
            ?>
                <form action="#" method="post" id="searchForm">
                    <input type="text" name="txtSearch" id="txtSearch" placeholder="search by landlord or address" value="<?php print $search; ?>" required>
                    <input type="image" name="submit" id="searchImage">
                </form>
        </div>
    <?php
                if ($_SERVER["REQUEST_METHOD"] == "GET" or $_SERVER["REQUEST_METHOD"] == "POST") {
                    $dataIsValid = true;
                    $search = getData("txtSearch");
                    $search = urlencode($search);

                    //server side validation
                    if ($search == "") {
                        $dataIsValid = false;
                    }

                    if ($dataIsValid) {
                        header("Location: search?search=" . $search);
                    }
                }
            }
    ?>
    <img src="images/bricks.png" class="image-home">
    </figure>
    <article class="homeArticle">
        <div class="box-home-one">
            <div>
                <h2>Welcome to RNTR</h2>
                <h3>We're working to help you find your perfect apartment in the Greater Burlington Area.</h3>
            </div>
        </div>
        <div class="box-home-two">
            <div class="box-home-left">
                <div>
                    <h2>WE'RE <br>YOUR <br>LANDLORD'S<br><span class="emphasis"> NIGHTMARE</span></h2>
                </div>
            </div>
            <div class="box-home-right">
                <div>
                    <p>Here at RNTR, we understand how difficult it can be to find a great apartment. Renting should be easy,
                        but with so many variables, finding the perfect place can feel impossible. We're working to take some of the
                        guesswork out of renting.</p>
                </div>
            </div>
        </div>
        <div class="box-home-three"></div>
        <div class="box-home-four"></div>


    </article>
    <script>
        function navScroll() {
            var myNav = document.getElementById('navbar');
            if (document.documentElement.scrollTop > (window.innerHeight) * .95) {
                myNav.classList.add('nav-colored');
            }
            if (document.documentElement.scrollTop < (window.innerHeight) * .95) {
                myNav.classList.remove('nav-colored');
            }
        }

        window.onscroll = function() {
            navScroll();
        };
    </script>

    <?php
    include 'footer.php'

    ?>

</main>
</body>

</html>