<?php

include_once 'config.php';
include_once 'common.php';

//DELETE BOOKS

if (isset($_GET["id"])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $id = $_GET["id"];

    $sql = "DELETE FROM books WHERE bookId = :bookId";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':bookId', $id);
    $statement->execute();

    $success = "Book successfully deleted";
  } catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM books";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch (PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>

<h2>Delete books</h2>

<?php if ($success) echo $success; ?>

<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Book Title</th>
      <th>Year</th>
      <th>Genre</th>
      <th>Agegroup</th>
      <th>Author</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($result as $row) : ?>
      <tr>
        <td><?php echo escape($row["bookId"]); ?></td>
        <td><?php echo escape($row["bookTitle"]); ?></td>
        <td><?php echo escape($row["year"]); ?></td>
        <td><?php echo escape($row["genre"]); ?></td>
        <td><?php echo escape($row["agegroup"]); ?></td>
        <td><?php echo escape($row["authorsId"]); ?></td>
        <td><a href="delete.php?id=<?php echo escape($row["bookId"]); ?>">Delete</a></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<br>
<a href="../searchbooks.php?userType=admin">Back to home</a>

<?php include_once "../footer.php"; ?>