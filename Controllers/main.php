<?php
session_start();
include "../Models/conect.php";
function login($email, $senha) {
    $acessar = ler_um("usuario", ["email" => $email, "senha" => $senha]);
    $user = $acessar[0];
    if ($user && $user["email"] == $email && $user["senha"] == $senha) {
        # Direciona para o local certo com base no tipo de usuário
        $_SESSION['usuario'] = $user;
        if ($user['tipo_usuario'] == 'ADMIN') {
            echo "<script>
                    alert('Login realizado com sucesso!');
                    window.location.href = '../Views/HTML/tela-admin.php'; 
                </script>";
        } else {
            echo "<script>
                    alert('Login realizado com sucesso!');
                    window.location.href = '../Views/HTML/index.php'; 
                </script>";
        }
        exit;
    } else {
        // Exibe o alerta e só depois redireciona com JavaScript
        echo "<script>
                alert('Usuário ou senha inválidos!');
                window.location.href = '../Views/HTML/login.php';
            </script>";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login']) and $_POST['login'] == "login") {
        $email = $_POST['usuario'];
        $senha = $_POST['senha'];
        login($email, $senha);
    }
    if (isset($_POST['cadastrar']) and $_POST['cadastrar'] == "cadastrar") {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        incluir_user($nome, $email, $senha, "USER", date("d/m/Y"));
        login($email, $senha);
    }
    if (isset($_POST['add_veiculo']) && $_POST['add_veiculo'] === "add_veiculo" &&
    isset($_SESSION['usuario']) && isset($_SESSION['usuario']['id_usuario'])) {
        incluir_veiculo(
            $_SESSION['usuario']['id_usuario'], 
            $_POST['marca'],
            $_POST['modelo'],
            $_POST['ano'],
            $_POST['preco'],
            $_POST['descricao'],
            $_POST['estado'],
            $_POST['cor']
        );
        $id_veiculo = ultimo_id_inserido("carro", "id_veiculo");
        $imagens = $_FILES['foto'];
        $quantidade = count($imagens['name']);
        $id_primeira_imagem = null;
        for ($i = 0; $i < $quantidade; $i++) {
            $nome_temp = $imagens['tmp_name'][$i];
            $extensao = pathinfo($imagens['name'][$i], PATHINFO_EXTENSION);
            $id_imagem = incluir_imagem($id_veiculo, "../Imagens/");
            if ($i == 0) {
                $id_primeira_imagem = $id_imagem;
            }
            $nome_final = $id_imagem . "." . $extensao;
            $caminho = "../Imagens/" . $nome_final;
            if (move_uploaded_file($nome_temp, $caminho)) {
                atualizar_caminho_imagem($id_imagem, "Imagens/" . $nome_final);
            }
        }
        // Atualiza o id_imagem_principal no veículo
        if ($id_primeira_imagem !== null) {
            $pdo = conectar(); // ajuste conforme sua função de conexão
            $stmt = $pdo->prepare("UPDATE carro SET id_imagem_principal = :id WHERE id_veiculo = :id_veiculo");
            $stmt->execute([
                ':id' => $id_primeira_imagem,
                ':id_veiculo' => $id_veiculo
            ]);
        }
    // Redireciona após sucesso
        echo "<script>
                alert('Veículo cadastrado com sucesso!');
                window.location.href = '../Views/HTML/index.php';
            </script>";
    } elseif (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['id_usuario'])) {
        echo "<script>
                alert('Você precisa estar logado para cadastrar um veículo!');
                window.location.href = '../Views/HTML/index.php';
              </script>";
    }

    if (isset($_POST['excluir_veiculo'])) {
        if ($_SESSION['usuario']["tipo_usuario"] == "ADMIN") {
            $id_veiculo = $_POST['excluir_veiculo'];
            $conn = conectar();
            $sql = "UPDATE carro SET anuncio_ativo = false WHERE id_veiculo = :id_veiculo";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':id_veiculo' => $id_veiculo]);
            echo "<script>
                    alert('Veículo excluído com sucesso!');
                    window.location.href = '../Views/HTML/tela-admin.php';
                </script>";
        }
    }
    if (isset($_POST["aprovar_id"])) {
        if ($_SESSION['usuario']["tipo_usuario"] == "ADMIN") {
            $id_veiculo = $_POST["aprovar_id"];
            $conn = conectar();
            $sql = "UPDATE carro SET anuncio_ativo = true WHERE id_veiculo = :id_veiculo";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':id_veiculo' => $id_veiculo]);
            echo "<script>
                    alert('Veículo aprovado com sucesso!');
                    window.location.href = '../Views/HTML/tela-admin.php';
                </script>";
        }
    }
    if (isset($_POST['busca_com_filtro'])) {
        $params = [];
        $sql = "SELECT * FROM carro WHERE anuncio_ativo = TRUE ";
        // Busca geral (marca, modelo, cor) para um texto simples
        if (!empty($_POST['busca_geral'])) {
            $busca = "%" . $_POST['busca_geral'] . "%";
            $sql .= " AND (marca LIKE ? OR modelo LIKE ? OR cor LIKE ?) ";
            // para 3 parâmetros iguais de busca geral
            $params[] = $busca;
            $params[] = $busca;
            $params[] = $busca;
        }
        // Filtros específicos
        if (!empty($_POST['marca'])) {
            $sql .= " AND marca LIKE ? ";
            $params[] = "%" . $_POST['marca'] . "%";
        }
        if (!empty($_POST['modelo'])) {
            $sql .= " AND modelo LIKE ? ";
            $params[] = "%" . $_POST['modelo'] . "%";
        }
        if (!empty($_POST['ano'])) {
            $sql .= " AND ano = ? ";
            $params[] = $_POST['ano'];
        }
        if (!empty($_POST['preco_max'])) {
            $sql .= " AND preco <= ? ";
            $params[] = $_POST['preco_max'];
        }
        if (!empty($_POST['cor'])) {
            $sql .= " AND cor LIKE ? ";
            $params[] = "%" . $_POST['cor'] . "%";
        }   
        // Conectar com PDO (exemplo)
        $pdo = conectar();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $veiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        session_start();
        $_SESSION['veiculos_filtrados'] = $veiculos;
        header("Location: ../Views/HTML/index.php");
        exit;

    }
}
?>