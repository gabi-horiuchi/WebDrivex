<!DOCTYPE html>
<html>
<head>
  <title>Produto - WebMotors</title>
  <link rel="stylesheet" href="../CSS/descricao-produto.css">
</head>
<body>

  <div class="produto-container">
    <h1>Detalhes do Produto</h1>

    <?php
      include "../../Models/conect.php";

      if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $dados = ler_um("carro", ["id_veiculo" => $id]);
        if ($dados && count($dados) > 0) {
          $produto = $dados[0];
          $id_usuario = $produto['id_usuario'];

          // Lê imagens do veículo
          $imagens = ler_um("imagem", ["id_veiculo" => $id]);

          // Lê email do dono
          $dono = ler_um("usuario", ["id_usuario" => $id_usuario]);
          $email_dono = $dono && count($dono) > 0 ? $dono[0]['email'] : "Indisponível";

          // Carrossel
          echo "<div class='carrossel'>";
          foreach ($imagens as $index => $img) {
            $classe = $index === 0 ? "active" : "";
            echo "<img class='$classe' src='../../" . htmlspecialchars($img['nome_arquivo']) . "' alt='Imagem do veículo'>";
          }
          if (count($imagens) > 1) {
            echo "<button id='prev'>&lt;</button><button id='next'>&gt;</button>";
          }
          echo "</div>";

          // Informações
          echo "<div class='produto-info'>";
          echo "<strong>Marca:</strong> " . htmlspecialchars($produto['marca']) . "<br>";
          echo "<strong>Modelo:</strong> " . htmlspecialchars($produto['modelo']) . "<br>";
          echo "<strong>Ano:</strong> " . htmlspecialchars($produto['ano']) . "<br>";
          echo "<strong>Cor:</strong> " . htmlspecialchars($produto['cor']) . "<br>";
          echo "<strong>Estado:</strong> " . ($produto['estado'] == 'novo' ? 'Novo' : 'Usado') . "<br>";
          echo "<strong>Preço:</strong> R$ " . number_format($produto['preco'], 2, ',', '.') . "<br>";
          echo "<strong>Descrição:</strong> " . htmlspecialchars($produto['descricao']) . "<br>";
          echo "<strong>Email do Vendedor:</strong> " . htmlspecialchars($email_dono) . "<br>";
          echo "</div>";

          // Botão de compra
          echo "<a class='botao-comprar' href='comprar.php?id_usuario=" . urlencode($id_usuario) . "'>Comprar</a>";

        } else {
          echo "<p>Produto não encontrado.</p>";
        }
      } else {
        echo "<p>Nenhum produto selecionado.</p>";
      }
    ?>
    <button onclick="window.print()" style="margin-bottom:20px;" class='botao-comprar'>Imprimir página</button>
    <br><a href="index.php">← Voltar à Página Inicial</a>
  </div>

  <script>
    const imagens = document.querySelectorAll('.carrossel img');
    let index = 0;

    function mostrarImagem(i) {
      imagens.forEach(img => img.classList.remove('active'));
      imagens[i].classList.add('active');
    }

    document.getElementById('prev')?.addEventListener('click', () => {
      index = (index - 1 + imagens.length) % imagens.length;
      mostrarImagem(index);
    });

    document.getElementById('next')?.addEventListener('click', () => {
      index = (index + 1) % imagens.length;
      mostrarImagem(index);
    });
  </script>

</body>
</html>
