<?php

$currentPage = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if ($_SERVER['REQUEST_METHOD'] == "GET" && strcmp(basename($currentPage), basename(__FILE__)) == 0) {
    http_response_code(404);
    include('myCustom404.php');
    die('Please log in to access this page');
}
?>

<div class='header text-white'>
    <?php
    require 'includes/dbh.inc.PHP';
    require_once 'includes/functions.inc.PHP';
    include_once 'header.php';
    session_start();
    $_SESSION['userType'] = $row['userType'];
    ?>

    <div class="text-center p-4">

        <?php

        //DISPLAY USERNAME MSG

        if (isset($_SESSION['usersUid'])) {

            echo "<div class='msg-box form-width mx-auto text-dark p-4 m-4'><p>Welcome " . $_SESSION['usersUid'] . ",<br>";
        }

        //DISPLAY USERTYPE

        $username = $_SESSION['usersUid'];

        $query = "SELECT * FROM users WHERE usersUid = ?;";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);

        if (!mysqli_stmt_prepare($stmt, $query)) {
            exit('There was a connection error');
        }
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            while ($row = mysqli_fetch_array($result)) {

                echo "you are logged in as "  . $row['userType'] . ".</p></div>";
                echo "</div>";
                echo "</div>";

                echo "<div id='search' class='container p-4'>

                   <div class='row mt-5'>     
                    <div class='col-md-5 text-center'>";

                if ($row['userType'] == 'member') {
                    echo "<h4 class='m-3 text-start'>Search</h4>
            <form method='post'>
            <div class='mx-auto'>
                <input class='form-control w-75 mx-auto d-inline' type='text' id='filter' name='filter' placeholder='Type a book title' />
                <button class='btn m-2 text-light d-inline' type='submit' name='search'><i class='fas fa-search'></i></button>
                </div>";
                } else {
                    echo "<h4 class='m-3 text-start'>Search</h4>
            <form method='post'>
            <div class='mx-auto'>
                <input class='form-control w-75 d-inline' type='text' id='filter' name='filter' placeholder='Type a title or author' />
                <button class='btn m-2 text-light d-inline' type='submit' name='searchAuthor'><i class='fas fa-search'></i></button>
                </div>";
                }
            }
        }
        ?>

    </div>

    <div class="col-md-4 text-center">

        <div class='mx-auto'>

            <h4 class="m-3 text-start">Group by genre</h4>
            <select class="form-control w-75 d-inline" name="genre" id="genre">
                <option value="biography">Biography</option>
                <option value="poetry">Poetry</option>
                <option value="fiction">Fiction</option>
                <option value="psychology">Psychology</option>
            </select>
            <button class="btn m-2 text-light d-inline" type="submit" name="submitgenre" value="Search genre" onclick="history.go(-1)"><i class='fas fa-search'></i></button>
        </div>

    </div>

    <div class="col-md-3 text-center my-auto">

        <input class="btn m-3" type="submit" name="clear" value="Clear filters" />
        </form>

    </div>

</div>
</div>
</div>

<br><br>


<!--NAVBAR EXTRA-->

<div class="mx-5 my-2 navigation">

    <?php if ($_GET['userType'] == 'admin') {
        echo "<ul class='nav justify-content-end'>
                <li class='nav-item'>
                    <a class='nav-link active text-light' aria-current='page' href='#add'>Add <i class='fas fa-plus'></i></a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link text-light' href='admin/update.php'>Edit <i class='far fa-edit'></i></a>
                </li>

                <li class='nav-item'>
                    <a class='nav-link text-light' href='admin/delete.php'>Delete <i class='fas fa-trash-alt'></i></a>
                </li>
            </ul>";
    }
    ?>

</div>

<div class="mx-auto pt-0 p-5">

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
        WHERE bookTitle LIKE ?;";

        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            exit('There was an error connecting to the database');
        }
        mysqli_stmt_bind_param($stmt, "ss", $search, $search);
        mysqli_stmt_execute($stmt);

        $searchResult = mysqli_stmt_get_result($stmt);
    } elseif (isset($_POST['searchAuthor'])) {
        $search = '%' . $_POST['filter'] . '%';
        $_SESSION['filter'] = $search;

        $sql = "SELECT b.bookTitle, b.year, b.genre, b.agegroup, a.authorName
        FROM books AS b INNER JOIN authors AS a
        ON b.authorsId = a.authorsId 
        WHERE bookTitle LIKE ? OR a.authorName LIKE ?;";

        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            exit('There was an error connecting to the database');
        }
        mysqli_stmt_bind_param($stmt, "ss", $search, $search);
        mysqli_stmt_execute($stmt);

        $searchResult = mysqli_stmt_get_result($stmt);
    }
    if ($searchResult) {
        if ($searchResult->num_rows > 0) {
            echo
            "<table>
                    <thead>
                        <tr>
                        <th scope='col'>Book title</th>
                        <th scope='col'>Year</th>
                        <th scope='col'>Genre</th>
                        <th scope='col'>Agegroup</th>
                        <th scope='col'>Author</th>
                        </tr>
                    </thead>";
            while ($row = $searchResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td data-label='Book title:'>" . $row["bookTitle"] . "</td>";
                echo "<td data-label='Due date:'>" . $row["year"] . "</td>";
                echo "<td data-label='Genre:'>" . $row["genre"] . "</td>";
                echo "<td data-label='Agegroup:'>" . $row["agegroup"] . "</td>";
                echo "<td data-label='Author:'>" . $row["authorName"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Nothing found for " . $search;
        }
    }

    //GROUP BY GENRE

    elseif (isset($_POST['submitgenre'])) {
        $genre = '%' . $_POST['genre'] . '%';
        $_SESSION['genre'] = $genre;

        $sql = "SELECT b.bookTitle, b.year, b.genre, b.agegroup, a.authorName
        FROM books AS b INNER JOIN authors AS a
        ON b.authorsId = a.authorsId 
        WHERE b.genre LIKE ?;";

        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            exit('There was an error connecting to the database');
        }
        mysqli_stmt_bind_param($stmt, "s", $genre);
        mysqli_stmt_execute($stmt);

        $searchResult = mysqli_stmt_get_result($stmt);


        if ($searchResult) {
            if ($searchResult->num_rows > 0) {
                echo
                "<table>
                    <thead>
                        <tr>
                        <th scope='col'>Book Title</th>
                        <th scope='col'>Year</th>
                        <th scope='col'>Genre</th>
                        <th scope='col'>Agegroup</th>
                        <th scope='col'>Author</th>
                        </tr>
                    </thead>";
                while ($row = $searchResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td data-label='Book title:'>" . $row["bookTitle"] . "</td>";
                    echo "<td data-label='Year:'>" . $row["year"] . "</td>";
                    echo "<td data-label='Genre:'>" . $row["genre"] . "</td>";
                    echo "<td data-label='Agegroup:'>" . $row["agegroup"] . "</td>";
                    echo "<td data-label='Author:'>" . $row["authorName"] . "</td>";
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
            "<table>
                    <thead>
                        <tr>
                        <th scope='col'><a href='searchbooks.php?sort=bookTitle&order=$order'>Book title</a></th>
                        <th scope='col'><a href='searchbooks.php?sort=year&order=$order'>Year</a></th>
                        <th scope='col'><a href='searchbooks.php?sort=genre&order=$order'>Genre</th>
                        <th scope='col'><a href='searchbooks.php?sort=agegroup&order=$order'>Agegroup</a></th>
                        <th scope='col'><a href='searchbooks.php?sort=authorName&order=$order'>Author</a></th>
                        </tr>
                    </thead>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td data-label='Book title:'>" . $row["bookTitle"] . "</td>";
                echo "<td data-label='Year:'>" . $row["year"] . "</td>";
                echo "<td data-label='Genre:'>" . $row["genre"] . "</td>";
                echo "<td data-label='Agegroup:'>" . $row["agegroup"] . "</td>";
                echo "<td data-label='Autor:'>" . $row["authorName"] . "</td>";
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
    <?php echo '<script type="text/javascript">alert(" ' . $_POST['bookTitle'] . ' successfully added." )</script>'; ?>
<?php } ?>

<!--ADD TO TABLES SECTION-->
<div class='container my-4' id='add'>
    <div class='row'>

        <div class='col-sm-6 p-3 text-center'>


            <?php if ($_GET['userType'] == 'admin') {
                echo
                "<h3>Add a book</h3>

    <form class='text-start p-4 mx-4' method='post'>
    	<label for='bookTitle'>Book title</label>
    	<input class='form-control info my-3' type='text' name='bookTitle' id='bookTitle' placeholder='Type a book title'>
    	<label for='year'>Year</label>
    	<input class='form-control my-3' type='number' name='year' id='year' placeholder='Type the publishing year'>

    	<label for='genre'>Genre</label>
    	<input class='form-control my-3' type='text' name='genre' id='genre' placeholder='Type the genre'>

    	<label for='age'>Age Group</label>
    	<input class='form-control my-3' type='text' name='agegroup' id='agegroup' placeholder='Type the recommended age group'>

    	<label for='authorsId'>Author's Id</label>
    	<input class='form-control my-3' type='text' name='authorsId' id='authorsId' placeholder='Type the Id'>
        <div class='text-center pt-3'>
    	<input class='btn' type='submit' name='submitBook' value='Submit'>
        </div>
    </form>
 

    </div>

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
                <?php echo '<script type="text/javascript">alert(" ' . $_POST['authorName'] . ' successfully added." )</script>'; ?>
            <?php } ?>

            <div class='col-sm-6 p-3 text-center my-auto'>

                <?php if ($_GET['userType'] == 'admin') {
                    echo
                    "<h3>Add an author</h3>

    <form class='text-start p-4 mx-4' method='post'>
      <label for='authorName'>Author Name</label>
      <input class='form-control my-3' type='text' name='authorName' id='authorName' placeholder='Type a name'>

      <label for='age'>Age</label>
      <input class='form-control my-3' type='number' name='age' id='age' placeholder='Type current age of author'>

      <label for='genre'>Genre</label>
      <input class='form-control my-3' type='text' name='genre' id='genre' placeholder='Type the genre'>
      <div class='text-center pt-3'>
      <input class='btn' type='submit' name='addAuthor' value='Submit'>
      </div>
    </form>
    </div>

  </div>
</div>
<br><br>";
                }
                ?>


                <?php
                //BACK TO HOME
                if ($_GET['userType'] == 'member') {
                    echo "<a class='p-5' href='searchbooks.php?userType=member'>Back to home</a>";
                } else {
                    echo "<a class='p-5' href='searchbooks.php?userType=admin'>Back to home</a>";
                }
                ?>


                <?php
                include_once 'footer.php';
                ?>