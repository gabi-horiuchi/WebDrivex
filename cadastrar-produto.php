<!DOCTYPE html>
<html>
<head>
  <title>Cadastrar Carro</title>
  <style>
    body {
      font-family: cursive;
      background: linear-gradient(to right, black, #63008a, #6b3fd1);
      color: aliceblue;
      padding: 50px;
      text-align: center;
    }

    form {
      background-color: rgba(0, 0, 0, 0.2);
      display: inline-block;
      padding: 30px;
      border-radius: 10px;
      text-align: left;
      max-width: 400px;
    }

    label {
      display: block;
      margin-top: 10px;
      font-weight: bold;
    }

    input, textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: none;
      border-radius: 6px;
      font-size: 16px;
    }

    button {
      margin-top: 20px;
      background-color: #6b3fd1;
      color: aliceblue;
      padding: 12px 24px;
      border: none;
      border-radius: 6px;
      font-size: 18px;
      cursor: pointer;
      width: 100%;
    }

    input[type="file"] {
      background-color: #fff;
      color: #000;
    }
  </style>
</head>
<body>

  <h1>Cadastrar Novo Produto</h1>

  <!-- enctype obrigatório para upload de arquivos -->
  <form action="main.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="acao" value="cadastrar_produto">

    <label for="nome">Nome do Carro:</label>
    <input type="text" name="nome" id="nome" required>

    <label for="descricao">Descrição:</label>
    <textarea name="descricao" id="descricao" rows="4" required></textarea>

    <label for="preco">Preço (R$):</label>
    <input type="number" step="0.01" name="preco" id="preco" required>

    <label for="categoria">Categoria:</label>
    <input type="text" name="categoria" id="categoria" required>

    <label for="foto">Foto do Carro:</label>
    <input type="file" name="foto" id="foto" accept="image/*" required>

    <button type="submit">Cadastrar Produto</button>
  </form>

</body>
</html>
