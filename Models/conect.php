<?php
function conectar($tipo = 'pgsql') {
    $host = 'localhost';
    $db = 'webmotors';
    $porta = '5433';
    $usuario = 'postgres';
    $senha = '2006';
    if ($tipo === 'mysql') {
        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
        $usuario = 'postgres'; // Altere se seu usuário for diferente
        $senha = '';       // Altere conforme sua senha do MySQL
    } else {
        $dsn = "pgsql:port=$porta;host=$host;dbname=$db";
    }

    try {
        $pdo = new PDO($dsn, $usuario, $senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erro na conexão: " . $e->getMessage());
    }
}
function incluir_user($nome, $email, $senha, $tipo, $data, $banco = 'pgsql') {
    $pdo = conectar($banco);
    $sql = "INSERT INTO usuario (nome, email, senha, tipo_usuario, data_criacao) 
            VALUES (:nome, :email, :senha, :tipo, :data)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nome' => $nome,
        ':email' => $email,
        ':senha' => $senha,
        ':tipo' => $tipo,
        ':data' => $data
    ]);
}
function ler_um($tabela, $valores, $banco = 'pgsql') {
    $pdo = conectar($banco);

    $condicoes = [];
    foreach ($valores as $campo => $valor) {
        $condicoes[] = "$campo = :$campo";
    }
    $where = implode(' AND ', $condicoes);
    $sql = "SELECT * FROM $tabela WHERE $where";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($valores);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function ler_tudo($tabela, $banco = 'pgsql') {
    $pdo = conectar($banco);
    $sql = "SELECT * FROM $tabela";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function incluir_veiculo($id_usuario, $marca, $modelo, $ano, $preco, $descricao, $estado, $cor, $banco = 'pgsql') {
    try {
        $pdo = conectar($banco);
        $sql = "INSERT INTO carro (vendido, id_usuario, marca, modelo, ano, preco, descricao, anuncio_ativo, estado, cor) 
                VALUES (FALSE, :id_usuario, :marca, :modelo, :ano, :preco, :descricao, FALSE, :estado, :cor)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_usuario' => $id_usuario,
            ':marca' => $marca,
            ':modelo' => $modelo,
            ':ano' => $ano,
            ':preco' => $preco,
            ':descricao' => $descricao,
            ':estado' => $estado,
            ':cor' => $cor
        ]);
    } catch (PDOException $e) {
        echo "Erro ao inserir veículo: " . $e->getMessage();
    }
}
function incluir_imagem($id_veiculo, $caminho) {
    $conn = conectar(); 
    // Insere na tabela imagem
    $sql = "INSERT INTO imagem (id_veiculo, nome_arquivo) VALUES (:id, :caminho)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id_veiculo);
    $stmt->bindParam(':caminho', $caminho);
    $stmt->execute();
    return $conn->lastInsertId(); // Retorna o ID da imagem
}
function ultimo_id_inserido($tabela, $nome_id) {
    $conn = conectar();
    $sql = "SELECT $nome_id FROM $tabela ORDER BY $nome_id DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultado ? $resultado[$nome_id] : null;
}
function atualizar_caminho_imagem($id_imagem, $caminho) {
    $conn = conectar();

    $sql = "UPDATE imagem SET nome_arquivo = :caminho WHERE id_imagem = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':caminho', $caminho);
    $stmt->bindParam(':id', $id_imagem);
    $stmt->execute();
}

?>
