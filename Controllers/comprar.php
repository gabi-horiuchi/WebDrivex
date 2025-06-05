<?php
include "../../Models/conect.php";

if (isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];

    $usuario = ler_um("usuario", ["id" => $id_usuario]);
    if ($usuario && count($usuario) > 0) {
        $email = $usuario[0]['email'];
        echo "Você será redirecionado para contatar o vendedor no e-mail: <strong>" . htmlspecialchars($email) . "</strong>";
        // Aqui você pode enviar um e-mail, abrir formulário, ou integrar com chat, etc.
    } else {
        echo "Usuário não encontrado.";
    }
} else {
    echo "ID do vendedor não especificado.";
}
?>
