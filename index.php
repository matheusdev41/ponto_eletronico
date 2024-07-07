<?php

session_start(); // iniciar a sessão

//atulalizando hora e data para o projeto inteiro
//dessa forma defino o horário padrão, seja para o 
//php na parte de cima, tanto na parte do html na 
//parte de baixo do projeto.

date_default_timezone_set('America/Sao_Paulo');


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h1>Registrar ponto</h1>

    <?php 
    
if(isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
    
    
    ?>

    <p id="horario"><?php echo date("d/m/Y H:i:s"); ?></p>
    
    <a href="registrar.php">Registrar</a><br>

    <script>
        var horario = document.getElementById('horario');

        function atualizarHorario(){

        //data recebe hora local formato pt-br com a timeZone 
            var data = new Date().toLocaleString("pt-br", {timeZone: "America/Sao_Paulo"});

        //substituindo a vírgula por -
            var formatarData = data.replace(",","-");
        
            horario.innerHTML = formatarData    
        }

        //deve chamar a função a cada ms
        setInterval(atualizarHorario, 1000);
    </script>
</body>
</html>