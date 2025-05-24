<!DOCTYPE html>
<html>
<head>
  <title>WebMotors</title>
  <style>
    body {
      background: linear-gradient(to right, black, #63008a, #6b3fd1);
      font-family: cursive;
      text-align: center;
      padding: 30px;
    }
    h1 {
      color: aliceblue;
    }
    .botao {
      color: aliceblue;
      background-color: #6b3fd1;
      display: inline-block;
      margin: 10px;
      padding: 12px 24px;
      border-radius: 8px;
      font-size: 20px;
      text-decoration: none;
    }
    .pesquisa {
      margin: 20px;
    }
    .pesquisa input {
      padding: 10px;
      width: 600px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
    }
    .pesquisa button {
      color: aliceblue;
      background-color: #0e0ba5;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }
    .produtos-populares {
      background-color: rgba(0, 0, 0, 0.2);
      margin-top: 40px;
      margin-left: auto;
      margin-right: auto;
      padding: 20px;
      max-width: 600px;
      border-radius: 10px;
      text-align: left;
      box-shadow: 2px 5px rgba(0, 0, 0, 0.2);
    }
    .produto-item {
      margin: 10px;
      font-size: 18px;
      color: white;
    }
    h2 {
      color: aliceblue;
    }
  </style>
</head>
<body>

  <h1>Bem-vindo à WebMotors</h1>

  <div class="pesquisa">
    <form method="GET" action="produto.php">
      <input type="text" name="busca" placeholder="Buscar Anúncios...">
      <button type="submit">Pesquisar</button>
    </form>
  </div>

  <div>
    <a href="login.php" class="botao">Login</a>
    <a href="criar-cadastro.php" class="botao">Criar Cadastro</a>
    <a href="cadastrar-produto.php" class="botao">Cadastrar Produto</a>
    <a href="produto.php" class="botao">Ver Produtos</a>
  </div>

  <div class="produtos-populares">
    <h2>Mais Procurados</h2>
    <?php
      $mysqli = new mysqli("localhost", "usuario", "senha", "webmotors");

      if ($mysqli->connect_error) {
        die("Erro ao conectar ao banco de dados: " . $mysqli->connect_error);
      }

      $sql = "SELECT nome FROM produtos ORDER BY id DESC LIMIT 5";
      $result = $mysqli->query($sql);

      if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<div class='produto-item'>" . htmlspecialchars($row['nome']) . "</div>";
        }
      } else {
        echo "<div class='produto-item'>Nenhum produto popular ainda.</div>";
      }

      $mysqli->close();
    ?>
  </div>

</body>
</html>
