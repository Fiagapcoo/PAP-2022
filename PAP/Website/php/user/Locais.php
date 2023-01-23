<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locais</title>
    <link href="../../css/css_grid.css" rel="stylesheet">
    <link href="../../css/sidebar.css" rel="stylesheet">
    <link rel="shortcut icon" href="../DB_connection/conhece_portugal.png" type="image/x-icon">
    <?php
    include_once '../side_nav_bar/side_user.php';
    include '../DB_connection/config.php';
    ?>  
</head>
<body>
<?php
$sql = "SELECT * FROM local";
$result = mysqli_query($conn, $sql);
echo "<div class='grid-container'>";
?>

<?php
while($row = mysqli_fetch_assoc($result)) {
  $nome_Loc = $row['Lugares_T'];
  $img_Loc = $row['img_loc'];
  $Lat = $row['Latitude_N'];
  $Long = $row['Longitude_O'];
  $aux = "../admin/Locais/$img_Loc";
  $url = "https://www.google.com/maps/place/$Lat,$Long";
  echo"<script>console.log('$aux')</script>";
  echo'<div class="grid-item"><a href = "'.$url.'">'.$nome_Loc .'<br><img src= '.$aux.' width="150px" alt=""></a></div>';
}
?>
</div>    
</body>
</html>
<style>
    html{
        margin-left: 215px;
    }
</style>