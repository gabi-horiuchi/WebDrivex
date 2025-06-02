<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {
    $acao = $_POST['acao'];

    if ($acao === 'cadastrar_produto') {
        // Dados do formulário
        $nome = $_POST['nome'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $preco = $_POST['preco'] ?? 0.0;
        $categoria = $_POST['categoria'] ?? '';

        // Verifica se a imagem foi enviada
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
            $nomeImagem = uniqid() . '_' . basename($_FILES['imagem']['name']);
            $caminhoPasta = 'imagens/';

            // Cria a pasta se não existir
            if (!is_dir($caminhoPasta)) {
                mkdir($caminhoPasta, 0755, true);
            }

            $caminhoFinal = $caminhoPasta . $nomeImagem;

            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoFinal)) {
                // Conecta ao banco de dados
                $mysqli = new mysqli("localhost", "usuario", "senha", "webmotors");

                if ($mysqli->connect_error) {
                    die("Erro ao conectar ao banco de dados: " . $mysqli->connect_error);
                }

                // Insere no banco
                $stmt = $mysqli->prepare("INSERT INTO produtos (nome, descricao, preco, categoria, imagem) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("ssdss", $nome, $descricao, $preco, $categoria, $nomeImagem);

                if ($stmt->execute()) {
                    echo "✅ Produto cadastrado com sucesso!";
                } else {
                    echo "❌ Erro ao cadastrar produto: " . $stmt->error;
                }

                $stmt->close();
                $mysqli->close();
            } else {
                echo "❌ Erro ao salvar a imagem.";
            }
        } else {
            echo "❌ Nenhuma imagem enviada ou erro no upload.";
        }
    } else {
        echo "❌ Ação desconhecida.";
    }
} else {
    echo "❌ Requisição inválida.";
}
?>
