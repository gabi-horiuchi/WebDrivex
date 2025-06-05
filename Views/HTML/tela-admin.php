<?php
  include "../../Models/conect.php";
  $veiculos = ler_tudo("carro");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Painel Admin - Drive-X</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link rel="stylesheet" href="../CSS/tela-admin.css">
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
      <?php foreach ($veiculos as $carro): ?>
        <tr>
          <td><?= $carro['id_veiculo'] ?></td>
          <td>
            <?php
              $img = ler_um("imagem", ["id_veiculo" => $carro['id_veiculo']]);
              if ($img && count($img) > 0):
            ?>
              <img src="../../<?= htmlspecialchars($img[0]['nome_arquivo']) ?>" alt="Imagem">
            <?php else: ?>
              Sem imagem
            <?php endif; ?>
          </td>
          <td><?= htmlspecialchars($carro['modelo']) ?></td>
          <td><?= htmlspecialchars($carro['marca']) ?></td>
          <td>R$ <?= number_format($carro['preco'], 2, ',', '.') ?></td>
          <td><?= $carro['anuncio_ativo'] ? 'Sim' : 'Não' ?></td>
          <td>
            <?php if (!$carro['anuncio_ativo']): ?>
              <form method="post" action="../../Controllers/main.php">
                <input type="hidden" name="aprovar_id" value="<?= $carro['id_veiculo'] ?>">
                <button type="submit" class="botao">Aprovar</button>
              </form>
            <?php endif; ?>
            <form method="post" action="../../Controllers/main.php">
              <input type="hidden" name="excluir_veiculo" value="<?= $carro['id_veiculo'] ?>">
              <button type="submit" class="botao excluir">Excluir</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</body>
</html>
