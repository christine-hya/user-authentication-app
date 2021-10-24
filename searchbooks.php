

<?php
require_once 'includes/dbh.inc.PHP';
include_once 'header.php';

?>

<section>
    <?php
    if (isset($_SESSION['usersUid'])) {
       
        echo "<p>Hello " . $_SESSION['usersUid'] . "</p>";
    } 
    ?>

    <h1>Library Search System</h1>
    <p>Search for books by title.</p>
</section>


    <form method="post">
    	<label for="location">Location</label>
    	<input type="text" id="location" name="location">
    	<input type="submit" name="submit" value="View Results">
    </form>

    <h2>Display table</h2>

    <?php
     $conn = new mysqli($serverName, $dBUsername, $dBPassword, $dBName);

    $sql = "SELECT b.bookTitle, b.year, b.genre, b.agegroup, a.authorName
    FROM books AS b INNER JOIN authors AS a
    ON b.authorsId = a.authorsId";

    $result = $conn->query($sql);// Sending the query to SQL

    if($result){
        if($result->num_rows > 0){
            echo "<table border=1>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["bookTitle"]. "</td>";
                echo "<td>" . $row["year"]. "</td>";
                echo "<td>" . $row["genre"]. "</td>";
                echo "<td>" . $row["agegroup"]. "</td>";
                echo "<td>" . $row["authorName"]. "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    } else {
        echo "Error selecting table " . $conn->error;
    }

    echo $result->fetch_assoc();

   ?>
    <br><br>
    <a href="index.php">Back to home</a>

<?php
include_once 'footer.php';
?>