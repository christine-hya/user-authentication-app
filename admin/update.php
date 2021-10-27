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

} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>


<h2>Update books</h2>

<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Title</th>
      <th>Year</th>
      <th>Genre</th>
      <th>Age group</th>
      <th>Author</th>
      <th>Edit</th>
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
      <td><a href="update-single.php?id=<?php echo escape($row["bookId"]); ?>">Edit</a></td>
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

} catch(PDOException $error) {
echo $sql . "<br>" . $error->getMessage();
}
?>


<h2>Update authors</h2>

<table>
<thead>
  <tr>
    <th>#</th>
    <th>Author's Name</th>
    <th>Age</th>
    <th>Genre</th>
    <th>Edit</th>
  </tr>
</thead>
<tbody>
<?php foreach ($result as $row) : ?>
  <tr>
    <td><?php echo escape($row["authorsId"]); ?></td>
    <td><?php echo escape($row["authorName"]); ?></td>
    <td><?php echo escape($row["age"]); ?></td>
    <td><?php echo escape($row["genre"]); ?></td>
    <td><a href="update-single-author.php?id=<?php echo escape($row["authorsId"]); ?>">Edit</a></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<br><br>

<a href="../admin.php">Back to home</a>

<?php include_once "../footer.php"; ?>