<?php 
require_once 'includes/dbh.inc.PHP';
include_once 'header.php';
@session_start();
?>

<ul>
  <li>
    <a href="admin/create.php"><strong>Add books and authors</strong></a> 
  </li>
  <li>
    <a href="admin/read.php"><strong>Find a user</strong></a> 
  </li>
  <li>
    <a href="admin/update.php"><strong>Edit book table</strong></a> 
  </li>
  <li>
    <a href="admin/delete.php"><strong>Delete books</strong></a>
  </li>
  <li>
    <a href=""><strong>Search books by author</strong></a> 
  </li>
</ul>

<section>
    <?php
    //DISPLAY USERNAME MSG
    if (isset($_SESSION['usersUid'])) {
       
        echo "<p>Hello " . $_SESSION['usersUid'] . "</p>";                   
    } 
    //DISPLAY USERTYPE
    $username = $_SESSION['usersUid'];
    $query = "SELECT * FROM users WHERE usersUid='". $username 
    . "'";
    $result = mysqli_query($conn, $query);
    if($result){
        while($row=mysqli_fetch_array($result)) {
            echo "<br>you are logged in as "  . $row['userType'] . "."; 
        }
    }

    ?>

    <h2>List of books </h2>
        <form method="post">
          <input type="text" id="filter" name="filter" autofocus="true" placeholder="filter keyword"/>
          <input type="submit" name="search" value="Search"/>
          <input type="submit" name="clear" value="Clear Filters"/>
        </form>
        <br><br>
     
    <?php

    //CLEAR FILTERS
    if(isset($_POST['clear'])){
        unset($_SESSION['filter']);
    }

    //SEARCH FILTER

    if (isset($_POST['search'])){

        $search = '%' . $_POST['filter'] .'%';
        $_SESSION['filter'] = $search;
    
        $sql = "SELECT bookTitle, year, genre, agegroup FROM books WHERE bookTitle LIKE'" . $search . "'";
    
        $searchResult = $conn->query($sql);
     
        if($searchResult){
            if($searchResult->num_rows > 0){
                echo 
                "<table border=1>
                    <thead>
                        <tr>
                        <th><a href='searchbooks.php?sort=bookTitle'>Book Title</a></th>
                        <th><a href='searchbooks.php?sort=year'>Year</a></th>
                        <th><a href='searchbooks.php?sort=genre'>Genre</th>
                        <th><a href='searchbooks.php?sort=agegroup'>Agegroup</a></th>
                        </tr>
                    </thead>";
                while($row = $searchResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["bookTitle"]. "</td>";
                    echo "<td>" . $row["year"]. "</td>";
                    echo "<td>" . $row["genre"]. "</td>";
                    echo "<td>" . $row["agegroup"]. "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        } else {
            echo "Error selecting table " . $conn->error;
        }
    
        echo $searchResult->fetch_assoc();    
    }

    else { 
    //DISPLAY FULL TABLE

     $sql = "SELECT b.bookTitle, b.year, b.genre, b.agegroup, a.authorName
     FROM books AS b INNER JOIN authors AS a
     ON b.authorsId = a.authorsId";
 
     $result = $conn->query($sql);
 
     if($result){
         if($result->num_rows > 0){
             echo 
             "<table border=1>
                 <thead>
                     <tr>
                     <th><a href='searchbooks.php?sort=bookTitle'>Book Title</a></th>
                     <th><a href='searchbooks.php?sort=year'>Year</a></th>
                     <th><a href='searchbooks.php?sort=genre'>Genre</th>
                     <th><a href='searchbooks.php?sort=agegroup'>Agegroup</a></th>
                     <th>Author</th>
                     </tr>
                 </thead>";
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

    }
     

   ?>

<?php include "footer.php"; ?>
</body>
</html>