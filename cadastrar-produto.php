<!DOCTYPE html>
<html>
<head>
  <title>Criar Cadastro</title>
  <style>
    body {
      background: linear-gradient(to right, black, #63008a, #6b3fd1);
      font-family: cursive;
      color: aliceblue;
      padding: 50px;
      text-align: center;
    }

    form {
      background-color: rgba(0, 0, 0, 0.2);
      display: inline-block;
      padding: 30px;
      border-radius: 10px;
    }

    input {
      display: block;
      margin: 10px auto;
      padding: 10px;
      width: 300px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
    }

    button {
      background-color: #6b3fd1;
      color: aliceblue;
      padding: 12px 24px;
      border: none;
      border-radius: 6px;
      font-size: 18px;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <h1>Cadastro de Novo Usuário</h1>

  <form action="main.php" method="POST">
    <input type="hidden" name="acao" value="criar_cadastro">

    <input type="text" name="nome" placeholder="Nome completo" required>
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="password" name="senha" placeholder="Senha" required>
    
    <button type="submit">Cadastrar</button>
  </form>

</body>
</html>
