<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
</head>
<body>
    <?php
        include 'db.php';
        include 'header.php';
        session_start();

        if (!isset($_SESSION['usuario_id'])) {
        header("Location: login.php");
        exit;
        }

        echo "Bem-vindo, " . $_SESSION['perfil'] . "!<br>";

        if ($_SESSION['perfil'] == 'admin') {
        echo "<a href='gerenciar_livros.php'>Gerenciar Livros</a><br>";
        }

        echo "<a href='logout.php'>Sair</a>";
    ?>
</body>
</html>