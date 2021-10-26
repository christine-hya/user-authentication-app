
<?php    

//ADD NEW BOOK

if (isset($_POST['submit'])) {
    require 'config.php';
    require 'common.php';

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

    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
      }
}


//ADD NEW AUTHOR

if (isset($_POST['addAuthor'])) {
  require "config.php";
  require "common.php";

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

  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
    }
}

?>

<?php include "../header.php"; 
?>

<?php if (isset($_POST['submit']) && $statement) { ?>
  <?php echo $_POST['bookTitle']; ?> successfully added.
<?php } ?>
 
    <h2>Add a book</h2>

    <form method="post">
    	<label for="bookTitle">Book title</label>
    	<input type="text" name="bookTitle" id="bookTitle">
    	<label for="year">Year</label>
    	<input type="number" name="year" id="year">

    	<label for="genre">Genre</label>
    	<input type="text" name="genre" id="genre">

    	<label for="age">Age Group</label>
    	<input type="text" name="agegroup" id="agegroup">

    	<label for="authorsId">Author's Id</label>
    	<input type="text" name="authorsId" id="authorsId">
    	<input type="submit" name="submit" value="Submit">
    </form>

    <br><br>

    <?php if (isset($_POST['addAuthor']) && $statement) { ?>
    <?php echo $_POST['authorName']; ?> successfully added.
    <?php } ?>

    <h2>Add author</h2>

    <form method="post">
      <label for="authorName">Author Name</label>
      <input type="text" name="authorName" id="authorName">

      <label for="age">Age</label>
      <input type="number" name="age" id="age">

      <label for="genre">Genre</label>
      <input type="text" name="genre" id="genre">
      <input type="submit" name="addAuthor" value="Submit">
    </form>

    <br><br>
    <a href="../admin.php">Back to home</a>

    <?php include_once "../footer.php"; ?>