<?php
$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';

// Conexão com banco de dados
$mysqli = new mysqli("localhost", "usuario", "senha", "webmotors");
if ($mysqli->connect_error) {
    die("Erro de conexão: " . $mysqli->connect_error);
}

switch ($acao) {

    // Login de usuário
    case 'login_usuario':
        $usuario = $_POST['usuario'] ?? '';
        $senha = $_POST['senha'] ?? '';

        $stmt = $mysqli->prepare("SELECT * FROM usuarios WHERE nome=?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $usuario_data = $resultado->fetch_assoc();

            if (password_verify($senha, $usuario_data['senha'])) {
                echo "<h1>Bem-vindo, $usuario!</h1>";
                echo "<a href='index.php'>Voltar à página inicial</a>";
            } else {
                echo "<h1>Senha incorreta.</h1>";
                echo "<a href='login.php'>Tentar novamente</a>";
            }
        } else {
            echo "<h1>Usuário não encontrado.</h1>";
            echo "<a href='login.php'>Tentar novamente</a>";
        }
        break;

    // Cadastro de usuário
    case 'criar_cadastro':
        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $mysqli->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $senha_hash);

        if ($stmt->execute()) {
            echo "<h1>Cadastro realizado com sucesso!</h1>";
            echo "<a href='login.php'>Fazer login</a>";
        } else {
            echo "Erro ao cadastrar.";
        }
        break;

    // Cadastro de produto
    case 'cadastrar_produto':
        $nome = $_POST['nome'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $preco = $_POST['preco'] ?? 0;
        $categoria = $_POST['categoria'] ?? '';

        $stmt = $mysqli->prepare("INSERT INTO produtos (nome, descricao, preco, categoria) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $nome, $descricao, $preco, $categoria);
        if ($stmt->execute()) {
            echo "<h1>Produto cadastrado com sucesso!</h1>";
            echo "<a href='produto.php'>Ver produtos</a>";
        } else {
            echo "Erro ao cadastrar produto.";
        }
        break;

    default:
        echo "<h1>Ação não reconhecida.</h1>";
        echo "<a href='index.php'>Voltar à página inicial</a>";
        break;
}

$mysqli->close();
?>
