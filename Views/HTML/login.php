<!DOCTYPE html>
<html>
<head>
  <title>Login Drive-x</title>
  <link rel="stylesheet" href="../CSS/login.css">
</head>
<body>

  <div class="login">
    <h2>Login</h2>
    <form action="../../Controllers/main.php" method="POST">
      <input type="hidden" name="login" value="login">
      <input type="text" name="usuario" placeholder="Usuário" required>
      <input type="password" name="senha" placeholder="Senha" required>
      <button type="submit">Entrar</button>
    </form>
    <a class="link-voltar" href="index.php">← Voltar à Página Inicial</a>
  </div>

</body>
</html>
