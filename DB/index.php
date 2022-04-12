
<?php
require'DBConnection.php';
$sql="select * from blogmodule";
$data=mysqli_query($con,$sql);




?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>
  <?php
  if(isset($_SESSION['message']))
  {
    echo $_SESSION['message'];
    unset($_SESSION['message']);
  }
  ?>
<table>
  <tr>
    <th>id</th>
    <th>title</th>
    <th>content</th>
    <th>image</th>
    <th>date</th>
  </tr>

      <?php
while($row=mysqli_fetch_assoc($data));
      ?>
   <tr>
       <td><?php echo $row['id'];?></td>
       <td><?php echo $row['title'];?></td>
       <td><?php echo $row['content'];?></td>
       <td><img src="<?php echo $row['image'];?>" width="30px" height="30px"/></td>
       <td><?php echo $row['date'];?></td>
       <td><a href='delete.php?id=<?php echo $row['id'];?>' ></td>
       <td><a href='edit.php?id=<?php echo $row['id'];?>' ></td>
  </tr>
 
</table>
</body>
</html>