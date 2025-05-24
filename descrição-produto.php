<!DOCTYPE html>
<html>
<head>
  <title>Produto - WebMotors</title>
  <style>
    body {
      background: linear-gradient(to right, black, #63008a, #6b3fd1);
      font-family: cursive;
      color: aliceblue;
      padding: 50px;
      text-align: center;
    }

    .produto-container {
      background-color: rgba(0, 0, 0, 0.2);
      padding: 30px;
      border-radius: 10px;
      max-width: 600px;
      margin: auto;
    }

    .produto-info {
      text-align: left;
      margin-top: 20px;
    }

    a {
      color: aliceblue;
      text-decoration: none;
      display: inline-block;
      margin-top: 20px;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="produto-container">
    <h1>Detalhes do Produto</h1>
    
    <?php
      if (isset($_GET['id'])) {
        $id = $_GET['id'];


        
        $conn = new mysqli("localhost", "root", "", "webmotors");
        if ($conn->connect_error) {
          die("Erro: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($produto = $result->fetch_assoc()) {
          echo "<div class='produto-info'>";
          echo "<strong>Nome:</strong> " . htmlspecialchars($produto['nome']) . "<br>";
          echo "<strong>Descrição:</strong> " . htmlspecialchars($produto['descricao']) . "<br>";
          echo "<strong>Preço:</strong> R$ " . number_format($produto['preco'], 2, ',', '.') . "<br>";
          echo "<strong>Categoria:</strong> " . htmlspecialchars($produto['categoria']) . "<br>";
          echo "</div>";
        } else {
          echo "<p>Produto não encontrado.</p>";
        }

        $conn->close();
        
        echo "<p>Função de exibição de produto ainda não implementada.</p>";
      } else {
        echo "<p>Nenhum produto selecionado.</p>";
      }
    ?>
          
    <a href="index.php">← Voltar à Página Inicial</a>
  </div>

</body>
</html>
