

<?php
require_once 'includes/dbh.inc.PHP';
require_once 'includes/functions.inc.PHP';
include_once 'header.php';

?>

<section>
    <?php
    if (isset($_SESSION['usersUid'])) {
       
        echo "<p>Hello " . $_SESSION['usersUid'] . "</p>";                   
    } 
    //DISPLAY USERTYPE
    $username = $_SESSION['usersUid'];
    // $pwd = $_POST['pwd'];
    $query = "SELECT * FROM users WHERE usersUid='". $username 
    . "'";
    $result = mysqli_query($conn, $query);
    if($result){
        while($row=mysqli_fetch_array($result)) {
            echo "<br>you are logged in as "  . $row['userType'] . "."; 
        }
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

    //NEW CONNECTION TO DATABASE

    // $conn = new mysqli($serverName, $dBUsername, $dBPassword, $dBName);

    $sql = "SELECT b.bookTitle, b.year, b.genre, b.agegroup, a.authorName
    FROM books AS b INNER JOIN authors AS a
    ON b.authorsId = a.authorsId";

    //SENDING QUERY TO MySQL

    $result = $conn->query($sql);

    //DISPLAY IN TABLE

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