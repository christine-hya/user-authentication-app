
<?php 
if (isset($_POST['submit'])) {
  try {
    require "../config.php";
    require "../common.php";

    $connection = new PDO($dsn, $username, $password, $options);

        // fetch data code
        $sql = "SELECT * 
        FROM books        
        WHERE authorsId = :authorsId";

        $authorName = $_POST['authorsId'];

        $statement = $connection->prepare($sql);
        $statement->bindParam(':authorsId', $authorName, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();

  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}
?>

<?php include "../header.php"; ?>

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
<td><?php echo escape($row["authorsId"]); ?></td>
      </tr>
    <?php } ?>
      </tbody>
  </table>
  <?php } else { ?>
    > No results found for <?php echo escape($_POST['authorsId']); ?>.
  <?php }
} ?>

<h2>Find book based on author</h2>

    <form method="post">
    	<label for="authorsId">Authors Id</label>
    	<input type="text" id="authorsId" name="authorsId">
    	<input type="submit" name="submit" value="View Results">
    </form>

    <a href="../admin.php">Back to home</a>

    <?php include_once "../footer.php"; ?>