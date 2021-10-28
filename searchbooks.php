<?php
require_once 'includes/dbh.inc.PHP';
require_once 'includes/functions.inc.PHP';
include_once 'header.php';
@session_start();
?>

<div class="text-center p-4">
    <?php
    //DISPLAY USERNAME MSG
    if (isset($_SESSION['usersUid'])) {

        echo "<p>Hello " . $_SESSION['usersUid'] . "<br>";
    }
    //DISPLAY USERTYPE
    $username = $_SESSION['usersUid'];
    $query = "SELECT * FROM users WHERE usersUid='" . $username
        . "'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            echo "you are logged in as "  . $row['userType'] . ".</p>";
        }
    }

    $_SESSION['userType'] = $row['userType'];
    ?>
</div>

<div class="container p-4">
    <div class="row">

        <div class="col-sm-5 p-3 my-auto text-center">
            <h3>Search for books</h3>
            <form method="post">
                <input class="form-control mb-3 m-3" type="text" id="filter" name="filter" placeholder="Type a book title" />
                <input class="btn btn-primary" type="submit" name="search" value="Search" />
        </div>

        <div class="col-sm-4 p-3 my-auto text-center">

            <h3>Group by genre</h3>
            <select class="form-control mb-3 m-3" name="genre" id="genre">
                <option value="biography">Biography</option>
                <option value="poetry">Poetry</option>
                <option value="fiction">Fiction</option>
                <option value="psychology">Psychology</option>
            </select>
            <input class="btn btn-primary" type="submit" name="submitgenre" value="Search genre" onclick="history.go(-1)" ;>

        </div>

        <div class="col-sm-3 p-3 my-auto text-center">
            <input class="btn btn-primary mb-3 m-3" type="submit" name="clear" value="Clear Filters" />
            </form>
        </div>

    </div>
</div>


<br><br>

<div class="mx-auto p-4">
    <?php





    //CLEAR FILTERS

    if (isset($_POST['clear'])) {
        unset($_SESSION['filter']);
        unset($_SESSION['genre']);
    }

    //SEARCH FILTER

    if (isset($_POST['search'])) {

        $search = '%' . $_POST['filter'] . '%';
        $_SESSION['filter'] = $search;

        $sql = "SELECT b.bookTitle, b.year, b.genre, b.agegroup, a.authorName
        FROM books AS b INNER JOIN authors AS a
        ON b.authorsId = a.authorsId 
        WHERE bookTitle LIKE'" . $search . "'";

        $searchResult = $conn->query($sql);

        if ($searchResult) {
            if ($searchResult->num_rows > 0) {
                echo
                "<table class='mx-auto p-3' border=1>
                    <thead>
                        <tr>
                        <th>Book Title</th>
                        <th>Year</th>
                        <th>Genre</th>
                        <th>Agegroup</th>
                        <th>Author</th>
                        </tr>
                    </thead>";
                while ($row = $searchResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["bookTitle"] . "</td>";
                    echo "<td>" . $row["year"] . "</td>";
                    echo "<td>" . $row["genre"] . "</td>";
                    echo "<td>" . $row["agegroup"] . "</td>";
                    echo "<td>" . $row["authorName"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "Nothing found for " . $search;
            }
        }
        echo $searchResult->fetch_assoc();
    }

    //GROUP BY GENRE

    elseif (isset($_POST['submitgenre'])) {
        $genre = '%' . $_POST['genre'] . '%';
        $_SESSION['genre'] = $genre;

        $sql = "SELECT b.bookTitle, b.year, b.genre, b.agegroup, a.authorName
        FROM books AS b INNER JOIN authors AS a
        ON b.authorsId = a.authorsId 
        WHERE b.genre LIKE'" . $genre . "'";

        $searchResult = $conn->query($sql);

        if ($searchResult) {
            if ($searchResult->num_rows > 0) {
                echo
                "<table class='mx-auto p-3' border=1>
                    <thead>
                        <tr>
                        <th>Book Title</th>
                        <th>Year</th>
                        <th>Genre</th>
                        <th>Agegroup</th>
                        <th>Author</th>
                        </tr>
                    </thead>";
                while ($row = $searchResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["bookTitle"] . "</td>";
                    echo "<td>" . $row["year"] . "</td>";
                    echo "<td>" . $row["genre"] . "</td>";
                    echo "<td>" . $row["agegroup"] . "</td>";
                    echo "<td>" . $row["authorName"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        } elseif ($searchResult->num_rows == 0) {
            echo "Error selecting table " . $conn->error;
        }

        echo $searchResult->fetch_assoc();
    }

    //SORT

    elseif (isset($_GET['sort'])) {

        $sort = $_GET['sort'];
    } else {
        $sort = 'bookTitle';
    }

    if (isset($_GET['order'])) {
        $order = $_GET['order'];
    } else {
        $order = 'ASC';
    }
    $sql = "SELECT b.bookTitle, b.year, b.genre, b.agegroup, a.authorName
    FROM books AS b INNER JOIN authors AS a
    ON b.authorsId = a.authorsId ORDER BY $sort $order";
    $result = $conn->query($sql);



    if ($result) {


        if ($result->num_rows > 0) {

            $order == 'DESC' ? $order = 'ASC' : $order = 'DESC';

            echo
            "<table class='mx-auto p-3' border=1>
                    <thead>
                        <tr>
                        <th><a href='searchbooks.php?sort=bookTitle&order=$order'>Book Title</a></th>
                        <th><a href='searchbooks.php?sort=year'>Year</a></th>
                        <th><a href='searchbooks.php?sort=genre'>Genre</th>
                        <th><a href='searchbooks.php?sort=agegroup'>Agegroup</a></th>
                        <th><a href='searchbooks.php?sort=authorName'>Author</a></th>
                        </tr>
                    </thead>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["bookTitle"] . "</td>";
                echo "<td>" . $row["year"] . "</td>";
                echo "<td>" . $row["genre"] . "</td>";
                echo "<td>" . $row["agegroup"] . "</td>";
                echo "<td>" . $row["authorName"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Error selecting table " . $conn->error;
        }

        echo $result->fetch_assoc();
    }




    ?>
</div>

<br><br>

<a class="p-5" href="searchbooks.php">Back to home</a>

<?php
include_once 'footer.php';
?>