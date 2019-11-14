<html>
 <head>
   <?php
   class MySQL{

     private $host;
     private $user;
     private $password;
     private $connection;

     function __construct(){}

     function getHost(){
       return $this->host;
     }

     function setHost($host){
       $this->host = $host;
     }

     function getUser(){
       return $user;
     }

     function setUser($user){
       $this->user = $user;
     }

     function getPassword(){
       return $password;
     }

     function setPassword($password){
       $this->password = $password;
     }

     function getConnection(){
       echo $this->connection;
       if(empty($this->connection)){
         $this->connection = mysqli_connect($this->host, $this->user, $this->password);
       }

       return $this->connection;
     }

   }
  $mysql = new MySQL();
  $mysql->setHost('localhost');
  $mysql->setUser('alexis');
  $mysql->setPassword('1234');

  $connection = $mysql->getConnection();
  mysqli_select_db($connection, 'world');

  $cities = "SELECT * FROM city";
  if(isset($_GET['search_city']) AND strlen($_GET['search_city']) == 3){
    $cities = "SELECT * FROM city WHERE CountryCode ='".$_GET['search_city']."'";
  }else if(isset($_GET['search_city']) AND strlen($_GET['search_city']) != 3){
    $cities = "SELECT * FROM city WHERE CountryCode = (SELECT Code FROM country WHERE Name = '".$_GET['search_city']."');";
  }

  $resultat_cities = mysqli_query($connection, $cities);

  $countries = "SELECT * FROM country";
  $resultat_countries = mysqli_query($connection, $countries);
  if (!$resultat_cities) {
    $message  = 'Consulta invàlida: ' . mysqli_error() . "\n";
    $message .= 'Consulta realitzada: ' . $cities;
    die($message);
  }
  ?>
 	<title>Exemple de lectura de dades a MySQL</title>
  <meta charset="utf-8">
 	<style>
 		table,td {
 			border: 1px solid black;
 			border-spacing: 0px;
 		}

    td img{
      display: block;
      margin: 0 auto;
    }
 	</style>
 </head>

 <body>
 	<h1>Exemple de lectura de dades a MySQL</h1>
  <form action="mysql.php" method="get">
      <input list="datalist_countries" name="search_city">
      <datalist id="datalist_countries">
        <?php
          while($registre = mysqli_fetch_assoc($resultat_countries)){
            echo '<option style="background-image:url(./gif/esp.gif)" value="'.$registre["Code"].'" label="'.$registre["Name"].'"></option>';
          }
        ?>
      </datalist>
  </form>

 	<table>
 	<thead><td colspan="4" align="center" bgcolor="cyan">Llistat de ciutats</td></thead>
    <?php
      while( $registre = mysqli_fetch_assoc($resultat_cities) )
      {
        echo "\t<tr>\n";
        echo "\t\t<td>".$registre["Name"]."</td>\n";
        echo "\t\t<td><img src='gif/".strtolower($registre['CountryCode']).".gif' alt='".$registre['CountryCode']."' title='".$registre['CountryCode']."'/></td>\n";
        echo "\t\t<td>".$registre["District"]."</td>\n";
        echo "\t\t<td>".$registre['Population']."</td>\n";
        echo "\t</tr>\n";
      }
   	?>
 	</table>
 </body>
</html>
