<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    
<?php
  echo"  <table>";


    
for($row=0;$row<=7;$row++)
{
    
  echo"  <tr>";

    for($col=0;$col<=7;$col++)
    {
       $total=$row+$col;
       if( $total%2==0)
       {
          echo"  <td bgcolor=white width=30px height=30px ></td>";
       }
       else
       {
           echo"  <td bgcolor=black width=30px height=30px ></td>";
       }

    }
echo"</tr>";
  
}
echo"  </table> "; 

?>

</body>
</html>
