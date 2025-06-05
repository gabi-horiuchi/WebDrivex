<!DOCTYPE html>
<html>
<head>
  <title>Drive-x vendas</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="../CSS/index.css">
</head>
<body>

  <h1>Bem-vindo à Drive-X </h1>

  <header>
    <img src="Logo.Drivex.png" alt="Logo Drive-x">

    <div class="pesquisa">
      <form method="POST" action="../../Controllers/main.php">
        <input type="text" name="busca_geral" placeholder="Busca geral (marca, modelo etc)">
        <!-- Botão para mostrar filtros -->
        <button type="button" onclick="toggleFiltros()" style="margin-left: 10px;" class="fas fa-filter"></button>
        <!-- Filtros avançados ocultos -->
        <div id="filtros-avancados" style="display: none; margin-top: 10px;">
          <input type="text" name="marca" placeholder="Marca">
          <input type="text" name="modelo" placeholder="Modelo">
          <input type="number" name="ano" placeholder="Ano" min="1900" max="2100">
          <input type="number" name="preco_max" placeholder="Preço máximo">
          <input type="text" name="cor" placeholder="Cor">
        </div>
        <button type="submit" name="busca_com_filtro" class="fas fa-search"></button>
      </form>
    </div>
    <nav>
      <a href="login.php" class="botao">Login</a>
      <a href="cadastro.php" class="botao">Criar Cadastro</a>
      <a href="cadastrar-produto.php" class="botao">Cadastrar Produto</a>
      <a href="logout.php" class="botao">Sair</a>
    </nav>
  </header>

  <div class="produtos-populares">
    <h2>Mais Procurados</h2>
    <?php
      include "../../Models/conect.php";

        // Busca veículos ativos
        session_start();
        if (isset($_SESSION['veiculos_filtrados'])) {
          $veiculos = $_SESSION['veiculos_filtrados'];
          unset($_SESSION['veiculos_filtrados']); // limpa após usar
        } else {
          $veiculos = ler_um("carro", ["anuncio_ativo" => 1]);
        }


        if ($veiculos && is_array($veiculos) && count($veiculos) > 0) {
          foreach ($veiculos as $veiculo) {
            $id_imagem = $veiculo['id_imagem_principal'];
            $caminho = "../../Imagens/";
            $arquivos = glob($caminho . $id_imagem . ".*");
            if (count($arquivos) > 0) {
              $arquivo_imagem = $arquivos[0]; // primeiro que encontrar
            } else {
              $arquivo_imagem = "../../Imagens/imagem-padrao.jpg"; // fallback
            }
            echo "
              <div class='produto-item' style='border:1px solid #ccc; padding:10px; margin:10px; width:200px; display:inline-block; text-align:center;'>
                  <img src='" . $arquivo_imagem . "' alt='Carro' style='width:100%; height:120px; object-fit:cover;'>
                  <h3>" . htmlspecialchars($veiculo['modelo']) . "</h3>
                  <p>R$ " . number_format($veiculo['preco'], 2, ',', '.') . "</p>
                  <a href='descricao-produto.php?id=" . $veiculo['id_veiculo'] . "' style='display:inline-block; padding:8px 12px; background-color:#6b3fd1; color:white; border-radius:5px; text-decoration:none;'>Ver Detalhes</a>
              </div>";
          }
      } else {
          echo "<div class='produto-item'>Nenhum produto popular ainda.</div>";
      }
  ?>
  </div>
  <script>
    function toggleFiltros() {
    const filtros = document.getElementById("filtros-avancados");
    filtros.style.display = filtros.style.display === "none" ? "block" : "none";}
  </script>
</body>
</html>
