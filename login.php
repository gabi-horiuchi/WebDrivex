<!DOCTYPE html>
<html>
<head>
  <title>Login-WebMotors</title>
  <style>
    body {
      background: linear-gradient(to right, black, #63008a, #6b3fd1);
      font-family: cursive;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .login {
      background-color: rgba(0, 0, 0, 0.2);
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 4px 10px black;
      width: 100%;
      max-width: 400px;
      text-align: center;
    }

    h2 {
      margin-bottom: 30px;
      color: aliceblue;
    }

    input{
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
      box-sizing: border-box;
    }

    button {
      background-color: #6b3fd1;
      color: aliceblue;
      padding: 12px 24px;
      border: none;
      border-radius: 8px;
      font-size: 18px;
      cursor: pointer;
      width: 100%;
    }

    .link-voltar {
      display: block;
      margin-top: 20px;
      color: aliceblue;
      text-decoration: none;
    }

    .link-voltar:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="login">
    <h2>Login</h2>
    <form action="main.php" method="POST">
      <input type="hidden" name="acao" value="login_usuario">
      <input type="text" name="usuario" placeholder="Usuário" required>
      <input type="password" name="senha" placeholder="Senha" required>
      <button type="submit">Entrar</button>
    </form>
    <a class="link-voltar" href="index.php">← Voltar à Página Inicial</a>
  </div>

</body>
</html>
