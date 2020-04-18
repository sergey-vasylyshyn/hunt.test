<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="main">
  <h1><a href="/chart.php">Link</a></h1>
  </br></br>

  <table>
      <tr>
          <th>Name</th>
          <th>Link</th>
          <th>Budget</th>
          <th>Employer</th>
          <th>Employer Login</th>
      </tr>
  <?php if (!empty($projects)): ?>
     <?php foreach ($projects as $project): ?>
      <tr>
          <td><?= $project['name'] ?></td>
          <td><?= $project['link'] ?></td>
          <td><?= $project['budget'] ?></td>
          <td><?= $project['employer_name'] ?></td>
          <td><?= $project['employer_login'] ?></td>
      </tr>
      <?php endforeach ?>
  </table>

  <?= $paginator ?>
  <? endif ?>
</div>
</body>
</html>