
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Library Database App</title>
  <link rel="icon" href="../assets/book-favicon.png" type="image/x-icon">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Zen+Antique+Soft&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/stylesheet.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
</head>

<?php

include_once 'config.php';
include_once 'common.php';

if (isset($_POST['submit'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $author = [
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
  } catch (PDOException $error) {
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
  } catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
} else {
  echo "Something went wrong!";
  exit;
}
?>

<body>
  <div class="form-width mx-auto p-5">
    <?php if (isset($_POST['submit']) && $statement) : ?>
      <?php echo escape($_POST['authorName']); ?> successfully updated.
    <?php endif; ?>

    <h3 class="m-4 text-center">Update author</h3>

    <form class="text-center" method="post">
      <?php foreach ($author as $key => $value) : ?>
        <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
        <input class="form-control my-3" type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'id' ? 'readonly' : null); ?>>
      <?php endforeach; ?>
      <input class="btn" type="submit" name="submit" value="Submit">
    </form>
  </div>

  <div class="m-4 p-4 p-0 mt-0">
    <a href="update.php">Back</a><br><br>
    <a href="../searchbooks.php?userType=admin">Back to home</a>
  </div>

  <?php include_once "../footer.php"; ?>