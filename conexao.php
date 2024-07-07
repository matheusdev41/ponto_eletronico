<?php 
//Inicio da conexao com o banco de dados utilizado 

$host = "localhost";
$user= "root";
$pass = "";
$dbname = "ponto_eletronico";

try {
    //conexao sem a porta 
    $conexao = new PDO("mysql:host=$host;dbname=" . $dbname, $user, $pass);
    //echo "Conexao com banco de dados realizado com sucesso.";  
} catch (PDOException $err) {
    echo "Erro: Conexão com banco de dados não realizado com sucesso. Erro gerado " . $err->getMessage();
}
    //fim da conexão com o banco de dados utilizando PDO

?>