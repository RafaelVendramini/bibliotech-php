<?php
include 'db.php';
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] != 'admin') {
    header("Location: index.php");
    exit;
}

// Adicionar Livro
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $ano = $_POST['ano'];

    $stmt = $pdo->prepare("INSERT INTO livros (titulo, autor, ano, usuario_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$titulo, $autor, $ano, $_SESSION['usuario_id']]);
}

// Excluir Livro
if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];

    $stmt = $pdo->prepare("DELETE FROM livros WHERE id = ?");
    $stmt->execute([$id]);
}

$livros = $pdo->query("SELECT * FROM livros")->fetchAll();
?>

<form method="POST">
    Título: <input type="text" name="titulo" required><br>
    Autor: <input type="text" name="autor" required><br>
    Ano: <input type="number" name="ano" required><br>
    <input type="submit" value="Adicionar Livro">
</form>

<h3>Livros</h3>
<ul>
    <?php foreach ($livros as $livro): ?>
        <li>
            <?= $livro['titulo'] ?> - <?= $livro['autor'] ?> (<?= $livro['ano'] ?>)
            <a href="?excluir=<?= $livro['id'] ?>">Excluir</a>
        </li>
    <?php endforeach; ?>
</ul>