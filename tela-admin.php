<?php
$mysqli = new mysqli("localhost", "usuario", "senha", "webmotors");

if ($mysqli->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['aprovar_id'])) {
        $id = intval($_POST['aprovar_id']);
        $mysqli->query("UPDATE produtos SET aprovado = 1 WHERE id = $id");
    }

    if (isset($_POST['excluir_id'])) {
        $id = intval($_POST['excluir_id']);
        $mysqli->query("DELETE FROM produtos WHERE id = $id");
    }
}

$result = $mysqli->query("SELECT * FROM produtos ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Painel Admin - Drive-X</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <style>
    body {
      font-family: cursive;
      background: linear-gradient(to right, black, #63008a, #6b3fd1);
      color: aliceblue;
      padding: 100px 30px 30px 30px;
      text-align: center;
    }

    h1 {
      color: #f2b10c;
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      max-width: 1000px;
      margin: auto;
      border-collapse: collapse;
      background-color: rgba(0, 0, 0, 0.2);
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 0 8px rgba(0,0,0,0.3);
    }

    th, td {
      padding: 15px;
      border-bottom: 1px solid #444;
    }

    th {
      background-color: #6b3fd1;
      color: white;
    }

    tr:hover {
      background-color: rgba(255, 255, 255, 0.05);
    }

    img {
      max-width: 100px;
      border-radius: 8px;
    }

    form {
      display: inline;
    }

    .botao {
      background-color: #6b3fd1;
      color: white;
      padding: 8px 14px;
      border: none;
      border-radius: 6px;
      font-size: 14px;
      cursor: pointer;
      margin: 3px;
    }

    .botao.excluir {
      background-color: crimson;
    }
  </style>
</head>
<body>

  <h1>Painel de Administração - Drive-X</h1>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Imagem</th>
        <th>Nome</th>
        <th>Categoria</th>
        <th>Preço</th>
        <th>Aprovado?</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td>
            <?php if (!empty($row['imagem'])): ?>
              <img src="imagens/<?= htmlspecialchars($row['imagem']) ?>" alt="Imagem">
            <?php else: ?>
              Sem imagem
            <?php endif; ?>
          </td>
          <td><?= htmlspecialchars($row['nome']) ?></td>
          <td><?= htmlspecialchars($row['categoria']) ?></td>
          <td>R$ <?= number_format($row['preco'], 2, ',', '.') ?></td>
          <td><?= $row['aprovado'] ? 'Sim' : 'Não' ?></td>
          <td>
            <?php if (!$row['aprovado']): ?>
              <form method="post">
                <input type="hidden" name="aprovar_id" value="<?= $row['id'] ?>">
                <button type="submit" class="botao">Aprovar</button>
              </form>
            <?php endif; ?>
            <form method="post">
              <input type="hidden" name="excluir_id" value="<?= $row['id'] ?>">
              <button type="submit" class="botao excluir">Excluir</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

</body>
</html>
