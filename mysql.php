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
  if(isset($_GET['search_city'])){
    $cities = "SELECT * FROM city WHERE CountryCode ='".$_GET['search_city']."'";
  }

  $resultat_cities = mysqli_query($connection, $cities);

  $countries = "SELECT * FROM country";
  $resultat_countries = mysqli_query($connection, $countries);
  if (!$resultat_cities) {
    $message  = 'Consulta invàlida: ' . mysqli_error() . "\n";
    $message .= 'Consulta realitzada: ' . $consulta;
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
 	</style>
 </head>

 <body>
 	<h1>Exemple de lectura de dades a MySQL</h1>
  <form action="mysql.php" method="get">
      <!-- <input type="text" name="search_city"> -->
      <input list="datalist_countries" name="search_city">
      <datalist id="datalist_countries">
        <?php
          while($registre = mysqli_fetch_assoc($resultat_countries)){
            echo '<option value="'.$registre["Code"].'" label="'.$registre["Name"].'"></option>';
          }
        ?>
      </datalist>
  </form>

 	<!-- (3.1) aquí va la taula HTML que omplirem amb dades de la BBDD -->
 	<table>
 	<!-- la capçalera de la taula l'hem de fer nosaltres -->
 	<thead><td colspan="4" align="center" bgcolor="cyan">Llistat de ciutats</td></thead>
  	<!-- (3.6) tanquem la taula -->
    <?php
      # (3.2) Bucle while
      while( $registre = mysqli_fetch_assoc($resultat_cities) )
      {
        # els \t (tabulador) i els \n (salt de línia) son perquè el codi font quedi llegible

        # (3.3) obrim fila de la taula HTML amb <tr>
        echo "\t<tr>\n";

        # (3.4) cadascuna de les columnes ha d'anar precedida d'un <td>
        #	després concatenar el contingut del camp del registre
        #	i tancar amb un </td>
        echo "\t\t<td>".$registre["Name"]."</td>\n";
        echo "\t\t<td>".$registre['CountryCode']."</td>\n";
        echo "\t\t<td>".$registre["District"]."</td>\n";
        echo "\t\t<td>".$registre['Population']."</td>\n";

        # (3.5) tanquem la fila
        echo "\t</tr>\n";
      }
   	?>
 	</table>
 </body>
</html>
