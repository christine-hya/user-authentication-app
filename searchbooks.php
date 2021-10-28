<?php

$currentPage = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if ($_SERVER['REQUEST_METHOD'] == "GET" && strcmp(basename($currentPage), basename(__FILE__)) == 0) {
    http_response_code(404);
    include('myCustom404.php');
    die('Please log in to access this page');
}

require_once 'includes/dbh.inc.PHP';
require_once 'includes/functions.inc.PHP';
include_once 'header.php';
session_start();
$_SESSION['userType'] = $row['userType'];
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
    ?>



    <?php
    $result = mysqli_query($conn, $query);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {

            echo "you are logged in as "  . $row['userType'] . ".</p>";

            echo "<div class='container p-4'>

                   <div class='row'>     
                    <div class='col-sm-5 p-3 my-auto text-center'>";

            if ($row['userType'] == 'member') {
                echo "<h3>Search</h3>
            <form method='post'>
                <input class='form-control mb-3 m-3' type='text' id='filter' name='filter' placeholder='Type a book title' />
                <input class='btn btn-primary' type='submit' name='search' value='Search'/>";
            } else {
                echo "<h3>Search</h3>
            <form method='post'>
                <input class='form-control mb-3 m-3' type='text' id='filter' name='filter' placeholder='Type a title or author' />
                <input class='btn btn-primary' type='submit' name='searchAuthor' value='Search'/>";
            }
        }
    }
    ?>

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
</div>

<br><br>

<?php if ($_GET['userType'] == 'admin') {
    echo "<ul class='nav justify-content-center'>
                <li class='nav-item'>
                    <a class='nav-link active text-light' aria-current='page' href='#add'>Add</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link text-light' href='admin/update.php'>Edit</a>
                </li>

                <li class='nav-item'>
                    <a class='nav-link text-light' href='admin/delete.php'>Delete</a>
                </li>
            </ul>";
}
?>

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
    } elseif (isset($_POST['searchAuthor'])) {
        $search = '%' . $_POST['filter'] . '%';
        $_SESSION['filter'] = $search;

        $sql = "SELECT b.bookTitle, b.year, b.genre, b.agegroup, a.authorName
        FROM books AS b INNER JOIN authors AS a
        ON b.authorsId = a.authorsId 
        WHERE bookTitle LIKE'" . $search . "' OR a.authorName LIKE '" . $search . "'";

        $searchResult = $conn->query($sql);
    }
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
    // echo $searchResult->fetch_assoc();


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
                        <th><a href='searchbooks.php?sort=year&order=$order'>Year</a></th>
                        <th><a href='searchbooks.php?sort=genre&order=$order'>Genre</th>
                        <th><a href='searchbooks.php?sort=agegroup&order=$order'>Agegroup</a></th>
                        <th><a href='searchbooks.php?sort=authorName&order=$order'>Author</a></th>
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

<?php

//ADD NEW BOOK

if (isset($_POST['submitBook'])) {
    require 'admin/config.php';
    require 'admin/common.php';

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $new_book = array(
            "bookTitle" => $_POST['bookTitle'],
            "year"  => $_POST['year'],
            "genre" => $_POST['genre'],
            "agegroup" => $_POST['agegroup'],
            "authorsId" => $_POST['authorsId']
        );

        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "books",
            implode(", ", array_keys($new_book)),
            ":" . implode(", :", array_keys($new_book))
        );

        //PREPARED STATEMENT

        $statement = $connection->prepare($sql);
        $statement->execute($new_book);
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php if (isset($_POST['submitBook']) && $statement) { ?>
    <?php echo $_POST['bookTitle']; ?> successfully added.
<?php } ?>
<?php if ($_GET['userType'] == 'admin') {
    echo "
 <div id='add'>
    <h2>Add a book</h2>

    <form method='post'>
    	<label for='bookTitle'>Book title</label>
    	<input type='text' name='bookTitle' id='bookTitle'>
    	<label for='year'>Year</label>
    	<input type='number' name='year' id='year'>

    	<label for='genre'>Genre</label>
    	<input type='text' name='genre' id='genre'>

    	<label for='age'>Age Group</label>
    	<input type='text' name='agegroup' id='agegroup'>

    	<label for='authorsId'>Author's Id</label>
    	<input type='text' name='authorsId' id='authorsId'>
    	<input type='submit' name='submitBook' value='Submit'>
    </form>

<br><br>";
}
?>

<?php

//ADD NEW AUTHOR

if (isset($_POST['addAuthor'])) {
    require "admin/config.php";
    require "admin/common.php";

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $new_author = array(
            "authorName" => $_POST['authorName'],
            "age"  => $_POST['age'],
            "genre" => $_POST['genre'],
        );

        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "authors",
            implode(", ", array_keys($new_author)),
            ":" . implode(", :", array_keys($new_author))
        );

        //PREPARED STATEMENT

        $statement = $connection->prepare($sql);
        $statement->execute($new_author);
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>


<?php if (isset($_POST['addAuthor']) && $statement) { ?>
    <?php echo $_POST['authorName']; ?> successfully added.
<?php } ?>

<?php if ($_GET['userType'] == 'admin') {
    echo "<h2>Add author</h2>

    <form method='post'>
      <label for='authorName'>Author Name</label>
      <input type='text' name='authorName' id='authorName'>

      <label for='age'>Age</label>
      <input type='number' name='age' id='age'>

      <label for='genre'>Genre</label>
      <input type='text' name='genre' id='genre'>
      <input type='submit' name='addAuthor' value='Submit'>
    </form>
    </div>
<br><br>";
}
?>

<?php if ($_GET['userType'] == 'member') {
    echo "<a class='p-5' href='searchbooks.php?userType=member'>Back to home</a>";
} else {
    echo "<a class='p-5' href='searchbooks.php?userType=admin'>Back to home</a>";
}
?>


<?php
include_once 'footer.php';
?>