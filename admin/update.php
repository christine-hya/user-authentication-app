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

//CONNECT TO DATABASE

try {
  include 'config.php';
  include 'common.php';

  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM books";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch (PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>

<body>
  <div class="mx-auto p-5">
    <h2 class="mb-3">Update books</h2>

    <table>
      <thead>
        <tr>
          <th scope="col">Id</th>
          <th scope="col">Title</th>
          <th scope="col">Year</th>
          <th scope="col">Genre</th>
          <th scope="col">Age group</th>
          <th scope="col">Author</th>
          <th scope="col">Edit</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($result as $row) : ?>
          <tr>
            <td data-label="Id:"><?php echo escape($row["bookId"]); ?></td>
            <td data-label="Title:"><?php echo escape($row["bookTitle"]); ?></td>
            <td data-label="Year:"><?php echo escape($row["year"]); ?></td>
            <td data-label="Genre:"><?php echo escape($row["genre"]); ?></td>
            <td data-label="Age group:"><?php echo escape($row["agegroup"]); ?></td>
            <td data-label="Author:"><?php echo escape($row["authorsId"]); ?></td>
            <td data-label="Edit:"><a href="update-single.php?id=<?php echo escape($row["bookId"]); ?>"><i class='far fa-edit'></i></a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <br><br>

    <?php

    //UPDATE AUTHOR TABLE

    try {
      $sql = "SELECT * FROM authors";

      $statement = $connection->prepare($sql);
      $statement->execute();

      $result = $statement->fetchAll();
    } catch (PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
    }
    ?>

    <h2 class="mb-3">Update authors</h2>

    <table>
      <thead>
        <tr>
          <th scope="col">Id</th>
          <th scope="col">Author's Name</th>
          <th scope="col">Age</th>
          <th scope="col">Genre</th>
          <th scope="col">Edit</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($result as $row) : ?>
          <tr>
            <td data-label="Id:"><?php echo escape($row["authorsId"]); ?></td>
            <td data-label="Author:"><?php echo escape($row["authorName"]); ?></td>
            <td data-label="Age:"><?php echo escape($row["age"]); ?></td>
            <td data-label="Genre:"><?php echo escape($row["genre"]); ?></td>
            <td data-label="Edit:"><a href="update-single-author.php?id=<?php echo escape($row["authorsId"]); ?>"><i class='far fa-edit'></i></a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <br>

    <a href="../searchbooks.php?userType=admin">Back to home</a>

  </div>

  <?php include_once "../footer.php"; ?>