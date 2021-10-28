<?php

include_once 'config.php';
include_once 'common.php';

if (isset($_POST['submit'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $author =[
      "authorsId" => $_POST['authorsId'],
      "authorName" => $_POST['authorName'],
      "age" => $_POST['age'],
      "genre" => $_POST['genre']
    ];

    $sql = "UPDATE authors
            SET authorsId = :authorsId,
              authorName = :authorName,
              age = :age,
              genre = :genre
            WHERE authorsId = :authorsId";

  $statement = $connection->prepare($sql);
  $statement->execute($author);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
    }
}

if (isset($_GET['id'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_GET['id'];

    $sql = "SELECT * FROM authors WHERE authorsId = :authorsId";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':authorsId', $id);
    $statement->execute();

    $author = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
  echo "Something went wrong!";
  exit;
}
?>


<?php if (isset($_POST['submit']) && $statement) : ?>
<?php echo escape($_POST['authorName']); ?> successfully updated.
<?php endif; ?>

<h2>Edit a book</h2>

<form method="post">
  <?php foreach ($author as $key => $value) : ?>
    <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'id' ? 'readonly' : null); ?>>
  <?php endforeach; ?>
  <input type="submit" name="submit" value="Submit">
</form>
<a href="update.php">Back</a><br><br>
<a href="../searchbooks.php?userType=admin">Back to home</a>

<?php include_once "../footer.php"; ?>