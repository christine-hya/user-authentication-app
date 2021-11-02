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
    $book = [
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
  } catch (PDOException $error) {
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
      
    <?php echo '<script type="text/javascript">alert(" ' . escape($_POST['bookTitle']) . ' successfully updated." )</script>'; ?>
           
    <?php endif; ?>

    <h2 class="m-4 text-center">Update book</h2>

    <form class="text-center" method="post">
      <?php foreach ($book as $key => $value) : ?>
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