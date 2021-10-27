<?php
require_once 'includes/dbh.inc.PHP';
require_once 'includes/functions.inc.PHP';
include_once 'header.php';
@session_start();
?>

<section>
    <?php
    //DISPLAY USERNAME MSG
    if (isset($_SESSION['usersUid'])) {

        echo "<p>Hello " . $_SESSION['usersUid'] . "</p>";
    }
    //DISPLAY USERTYPE
    $username = $_SESSION['usersUid'];
    $query = "SELECT * FROM users WHERE usersUid='" . $username
        . "'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            echo "<br>you are logged in as "  . $row['userType'] . ".";
        }
    }

    $_SESSION['userType'] = $row['userType'];
    ?>

    <h2>Search for books</h2>
    <form method="post">
        <input type="text" id="filter" name="filter" placeholder="Type a book title" />
        <input type="submit" name="search" value="Search" />
       
    <br>

    <h2>Group by genre</h2>
        <select name="genre" id="genre">
            <option value="biography">Biography</option>
            <option value="poetry">Poetry</option>
            <option value="fiction">Fiction</option>
            <option value="psychology">Psychology</option>
        </select>
        <input type="submit" name="submitgenre" value="Search genre" onclick="history.go(-1)";>
        <br><br><br><br>
        <input type="submit" name="clear" value="Clear Filters" />
        
    </form>
    <br><br>

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
                "<table border=1>
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
            echo "Nothing found for " . $search;
        }

        echo $searchResult->fetch_assoc();
    }

    //SORT

    elseif (isset($_GET['sort'])) {
        $sort = $_GET['sort'];
        $sort .= ($sort == 'ASC') ? ' DESC' : ' ASC';

        $sql = "SELECT b.bookTitle, b.year, b.genre, b.agegroup, a.authorName
            FROM books AS b INNER JOIN authors AS a
            ON b.authorsId = a.authorsId ORDER BY $sort";


        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {

                echo
                "<table border=1>
                        <thead>
                            <tr>
                            <th><a href='searchbooks.php?sort=bookTitle'>Book Title</a></th>
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
            }
        } else {
            echo "Error selecting table " . $conn->error;
        }

        echo $result->fetch_assoc();
    }

    //GROUP BY GENRE

    else if (isset($_POST['submitgenre'])) {
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
                "<table border=1>
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
        
    } else {

        //DISPLAY TABLE

        $sql = "SELECT b.bookTitle, b.year, b.genre, b.agegroup, a.authorName
     FROM books AS b INNER JOIN authors AS a
     ON b.authorsId = a.authorsId";

        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                echo
                "<table border=1>
                 <thead>
                     <tr>
                     <th><a href='searchbooks.php?sort=bookTitle'>Book Title</a></th>
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
            }
        } else {
            echo "Error selecting table " . $conn->error;
        }

        echo $result->fetch_assoc();
    }

    ?>

    <br><br>
    <a href="searchbooks.php">Back to home</a>

    <?php
    include_once 'footer.php';
    ?>