<?php 

session_start(); // Iniciar a sessão

// Limpar o buffer
ob_start();

// Atualizando hora e data para o projeto inteiro
// dessa forma defino o horário padrão, seja para o 
// php na parte de cima, tanto na parte do html na 
// parte de baixo do projeto.

date_default_timezone_set('America/Sao_Paulo');

// gerar horário atual

$horario_atual = date("H:i:s");

// Teste se o horário está ok
// var_dump($horario_atual);

// Gerar a data com php com formato que que deve ser salvo no banco de dados
$data_entrada = date('Y/m/d');

// Incluir a conexao com o banco de dados 
include_once "conexao.php";

// ID do usuario fixo para poder testar
$id_usuario = 1;

// Recuperar o último ponto do usuário
$query_ponto = "SELECT id AS id_ponto, saida_intervalo, retorno_intervalo, saida 
                FROM registros 
                WHERE usuario_id =:usuario_id 
                ORDER BY id DESC 
                LIMIT 1";

// Preparar a QUERY
$result_ponto = $conexao->prepare($query_ponto);

// Substituir o link da QUERY pelo valor
$result_ponto->bindParam(':usuario_id', $id_usuario);

// Executar a QUERY
$result_ponto->execute();

// Verificar se encontrou algum registro no banco de dados
if(($result_ponto) and ($result_ponto->rowCount() != 0)){
    // Realizar a leitura do registro
    $row_ponto = $result_ponto->fetch(PDO::FETCH_ASSOC);
   // var_dump($row_ponto);

    // Extrair para imprimir atraves do nome da chave do array
    extract($row_ponto);

    // Verificar se o usuário já bateu o ponto de saída para o intervalo
    if(($saida_intervalo == "") or ($saida_intervalo == null)) {
        // Coluna que deve receber o valor
        $col_tipo_registro = "saida_intervalo";

        // Tipo de registro
        $tipo_registro = "editar";

        // Texto parcial que deve ser apresentado para o usuário
        $text_tipo_registro = "saída intervalo";
        
    } elseif (($retorno_intervalo == "") or ($retorno_intervalo == null)) { 
    // Verificar se o usuário já bateu o ponto de retorno do intervalo

        // Coluna que deve receber o valor
        $col_tipo_registro = "retorno_intervalo";

        // Tipo de registro
        $tipo_registro = "editar";

        // Texto parcial que deve ser apresentado para o usuário
        $text_tipo_registro = "retorno do intervalo";

    } elseif (($saida == "") or ($saida == null)) { 
        // Verificar se o usuário já bateu o ponto de saida
    
            // Coluna que deve receber o valor
            $col_tipo_registro = "saida";
    
            // Tipo de registro
            $tipo_registro = "editar";
    
            // Texto parcial que deve ser apresentado para o usuário
            $text_tipo_registro = "saída";

    } else { 
        // Criar um novo registro no BD com o horário de entrada
    
            // Tipo de registro
            $tipo_registro = "entrada";
    
            // Texto parcial que deve ser apresentado para o usuário
            $text_tipo_registro = "entrada";
        }
} else {
       // Tipo de registro
       $tipo_registro = "entrada";
    
       // Texto parcial que deve ser apresentado para o usuário
       $text_tipo_registro = "entrada";
}

// Verificar o tipo de registro novo ponto ou editar registro que existe

switch($tipo_registro){

    // Acessa o case quando deve editar o registro
    case "editar":
        // Query para editar no banco de dados 
        $query_horario = "UPDATE registros SET $col_tipo_registro =:horario_atual
                        WHERE id=:id
                        LIMIT 1";
        
        // Preparar a Query
        $cad_horario = $conexao->prepare($query_horario);
        
        // Substituir o link da QUERY pelo valor

        $cad_horario->bindParam(':horario_atual', $horario_atual);
        $cad_horario->bindParam(':id', $id_ponto);
        break; 
    default:
        // Query para cadastrar no banco de dados
        $query_horario = "INSERT INTO registros (data_entrada, entrada, usuario_id  ) VALUES (:data_entrada, :entrada,:usuario_id)";

        // Preparar a QUERY
        $cad_horario = $conexao->prepare($query_horario);

        // Substituir o link
        $cad_horario->bindParam(':data_entrada', $data_entrada);
        $cad_horario->bindParam(':entrada', $horario_atual);
        $cad_horario->bindParam(':usuario_id', $id_usuario);
         break;        
}

// Executar a QUERY
$cad_horario->execute();

// Acessa o if quando cadastrar com sucesso
if($cad_horario->rowCount()){
    $_SESSION['msg']  = "<p style = 'color: green;'>Horário de $text_tipo_registro cadastrado com sucesso!</p>";

    header("Location: index.php");
} else {
    $_SESSION['msg']  = "<p style = 'color: #f00;'>Horário de $text_tipo_registro não cadastrado com sucesso!</p>";

    header("Location: index.php");
}
?>