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

        // Carregar livro para edição
        $livro_para_editar = null;
        if (isset($_GET['editar'])) {
            $id = $_GET['editar'];

            $stmt = $pdo->prepare("SELECT * FROM livros WHERE id = ?");
            $stmt->execute([$id]);
            $livro_para_editar = $stmt->fetch();
        }

        $livros = $pdo->query("SELECT * FROM livros")->fetchAll();
        
    ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
</head>
<body>
    

    <div class="container">
        <h1>Livros</h1>

        <?php foreach($livros as $livro): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $livro['titulo']; ?></h5>
                        <p class="card-text">Autor: <?php echo $livro['autor']; ?></p>
                        <a href="emprestar.php?id=<?php echo $livro['id']; ?>" class="btn btn-primary">Emprestar</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<script>

</script>
</body>
</html>