<?php
include 'db.php';
include 'header.php';
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] != 'admin') {
    header("Location: index.php");
    exit;
}

// Adicionar ou Editar Livro
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $ano = $_POST['ano'];
    $livro_id = isset($_POST['livro_id']) ? $_POST['livro_id'] : null;

    if ($livro_id) {
        // Atualizar livro existente
        $stmt = $pdo->prepare("UPDATE livros SET titulo = ?, autor = ?, ano = ? WHERE id = ?");
        $stmt->execute([$titulo, $autor, $ano, $livro_id]);
    } else {
        // Inserir novo livro
        $stmt = $pdo->prepare("INSERT INTO livros (titulo, autor, ano, usuario_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$titulo, $autor, $ano, $_SESSION['usuario_id']]);
    }
}

// Excluir Livro
if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];

    $stmt = $pdo->prepare("DELETE FROM livros WHERE id = ?");
    $stmt->execute([$id]);
}

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

<form method="POST">
    <input type="hidden" name="livro_id" value="<?= $livro_para_editar['id'] ?? '' ?>">
    Título: <input type="text" name="titulo" value="<?= $livro_para_editar['titulo'] ?? '' ?>" required><br>
    Autor: <input type="text" name="autor" value="<?= $livro_para_editar['autor'] ?? '' ?>" required><br>
    Ano: <input type="number" name="ano" value="<?= $livro_para_editar['ano'] ?? '' ?>" required><br>
    <input type="submit" value="<?= $livro_para_editar ? 'Atualizar' : 'Adicionar' ?> Livro">
</form>

<h3>Livros</h3>
<ul>
    <?php foreach ($livros as $livro): ?>
        <li>
            <?= $livro['titulo'] ?> - <?= $livro['autor'] ?> (<?= $livro['ano'] ?>)
            <a href="?editar=<?= $livro['id'] ?>">Editar</a>
            <a href="?excluir=<?= $livro['id'] ?>">Excluir</a>
        </li>
    <?php endforeach; ?>
</ul>
