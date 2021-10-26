<?php

/**
  * Use an HTML form to edit an entry in the
  * users table.
  *
  */
  include_once 'config.php';
  include_once 'common.php';

  if (isset($_POST['submit'])) {
    try {
      $connection = new PDO($dsn, $username, $password, $options);
      $book =[
        "bookId" => $_POST['bookId'],
        "bookTitle" => $_POST['bookTitle'],
        "year" => $_POST['year'],
        "genre" => $_POST['genre'],
        "agegroup" => $_POST['agegroup'],
        "authorsId" => $_POST['authorsId']
      ];
  
      $sql = "UPDATE books
              SET bookId = :bookId,
                bookTitle = :bookTitle,
                year = :year,
                genre = :genre,
                agegroup = :agegroup,
                authorsId = :authorsId
              WHERE bookId = :bookId";
  
    $statement = $connection->prepare($sql);
    $statement->execute($book);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
      }
  }

  if (isset($_GET['id'])) {
    try {
      $connection = new PDO($dsn, $username, $password, $options);
      $id = $_GET['id'];
  
      $sql = "SELECT * FROM books WHERE bookId = :bookId";
      $statement = $connection->prepare($sql);
      $statement->bindValue(':bookId', $id);
      $statement->execute();
  
      $book = $statement->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
  } else {
    echo "Something went wrong!";
    exit;
  }
?>

<?php include_once "../header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
  <?php echo escape($_POST['bookTitle']); ?> successfully updated.
<?php endif; ?>

<h2>Edit a user</h2>

<form method="post">
    <?php foreach ($book as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
      <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'id' ? 'readonly' : null); ?>>
    <?php endforeach; ?>
    <input type="submit" name="submit" value="Submit">
</form>

<a href="../admin.php">Back to home</a>

<?php include_once "../footer.php"; ?>