<?php

session_start(); //iniciamos a sess�o que foi aberta
session_unset(); //limpamos as variaveis globais das sess�es
session_destroy(); //pei!!! destruimos a sess�o ;)

echo "<script>
        alert('Você saiu!');top.location.href='login.php';
            window.location.href = '../Views/HTML/index.php';
    </script>";
exit;
?>