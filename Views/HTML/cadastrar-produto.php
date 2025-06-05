<!DOCTYPE html>
<html>
<head>
  <title>Cadastrar Carro</title>
  <link rel="stylesheet" href="../CSS/cadastrar-produto.css">
</head>
<body>

  <h1>Cadastrar Novo Produto</h1>

  <!-- enctype obrigatório para upload de arquivos -->
  <form action="../../Controllers/main.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="add_veiculo" value="add_veiculo">

    <label for="marca">Marca do Carro:</label>
    <input type="text" name="marca" id="marca" required>

    <label for="modelo">Modelo:</label>
    <input type="text" name="modelo" id="modelo" required>

    <label for="ano">Ano:</label>
    <input type="number" name="ano" id="ano" required>

    <label for="preco">Preço (R$):</label>
    <input type="number" step="0.01" name="preco" id="preco" required>

    <label for="descricao">Descrição:</label>
    <textarea name="descricao" id="descricao" rows="4" required></textarea>

    <label for="estado">Novo / Usado:</label>
    <input type="text" name="estado" id="estado" required>

    <label for="cor">Cor:</label>
    <input type="text" name="cor" id="cor" required>

    <label for="foto">Foto(s) do Carro:</label>
    <input type="file" name="foto[]" id="foto" accept="image/*" required multiple>

    <button type="submit">Cadastrar Veículo</button>
</form>


</body>
</html>
