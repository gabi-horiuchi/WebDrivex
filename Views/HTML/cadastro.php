<!DOCTYPE html>
<html>
<head>
  <title>Criar Cadastro</title>
  <link rel="stylesheet" href="../CSS/cadastro.css">
</head>
<body>

  <h1>Cadastro de Novo Usuário</h1>

  <form action="../../Controllers/main.php" method="POST">
    <input type="hidden" name="cadastrar" value="cadastrar">

    <input type="text" name="nome" placeholder="Nome completo" required>
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="password" name="senha" placeholder="Senha" required>
    
    <button type="submit">Cadastrar</button>
  </form>

</body>
</html>
