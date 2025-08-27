<?php
require 'vendor/autoload.php';
require 'db.php';
require 'gemini.php';

header('Content-Type: application/json');

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (isset($data['question'])) {
  // 1. Obter o esquema do banco de dados (substituir pela sua string de esquema)
  $dbSchema = $_ENV['DB_SCHEMA'];

  // 2. Chamar a API do Gemini para obter o SQL
  $sqlQuery = getSQLFromGemini($data['question'], $dbSchema);

  if ($sqlQuery) {
    // 3. Conectar e executar a consulta no banco de dados
    try {
      $pdo = getDBConnection();
      $stmt = $pdo->prepare($sqlQuery);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      // 4. Enviar a resposta de volta para o frontend
      echo json_encode(['success' => true, 'data' => $result, 'sql' => $sqlQuery]);
    } catch (PDOException $e) {
      echo json_encode(['success' => false, 'error' => 'Erro ao executar a consulta SQL: ' . $e->getMessage()]);
    }
  } else {
    echo json_encode(['success' => false, 'error' => 'Não foi possível gerar a consulta SQL.']);
  }
} else {
  echo json_encode(['success' => false, 'error' => 'Nenhuma pergunta foi recebida.']);
}
?>
