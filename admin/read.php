
<?php 
@session_start();

if(isset($_POST['clear'])){
  unset($_SESSION['authorName']);
}

if (isset($_POST['submit'])) {
  try {
    require 'config.php';
    require 'common.php';

    $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT b.bookTitle, b.year, b.genre, b.agegroup, a.authorsId, a.authorName 
        FROM books AS b INNER JOIN authors AS a
        ON b.authorsId = a.authorsId        
        WHERE authorName LIKE '%' :authorName '%'";

        $authorName = $_POST['authorName'];
        $_SESSION['authorName'] = $authorName;

        $statement = $connection->prepare($sql);
        $statement->bindParam(':authorName', $authorName, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();

  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<h2>Find book based on author</h2>

<form method="post">
  <label for="authorName">Type a name of an author:</label>
  <input type="text" id="authorName" name="authorName">
  <input type="submit" name="submit" value="View results">
  <input type="submit" name="clear" value="Clear search">
</form>

<?php
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>
    <h2>Results</h2>

    <table>
      <thead>
<tr>
  <th>#</th>
  <th>Book Title</th>
  <th>Year</th>
  <th>Genre</th>
  <th>Age group</th>
  <th>Author's name</th>
  <th>Author's Id</th>
</tr>
      </thead>
      <tbody>
  <?php foreach ($result as $row) { ?>
      <tr>
<td><?php echo escape($row["id"]); ?></td>
<td><?php echo escape($row["bookTitle"]); ?></td>
<td><?php echo escape($row["year"]); ?></td>
<td><?php echo escape($row["genre"]); ?></td>
<td><?php echo escape($row["agegroup"]); ?></td>
<td><?php echo escape($row["authorName"]); ?></td>
<td><?php echo escape($row["authorsId"]); ?></td>
      </tr>
    <?php } ?>
      </tbody>
  </table>
  <?php } else { ?>
    > No results found for <?php echo escape($_POST['authorName']); ?>.
  <?php }
} ?>



    <a href="../admin.php">Back to home</a>

    <?php include_once "../footer.php"; ?>