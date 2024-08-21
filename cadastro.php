<?php
include 'db.php';
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);
    $perfil = $_POST['perfil'];

    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, perfil) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $email, $senha, $perfil]);

    header("Location: login.php");
}
?>

<form method="POST">
    Nome: <input type="text" name="nome" required><br>
    Email: <input type="email" name="email" required><br>
    Senha: <input type="password" name="senha" required><br>
    Perfil: 
    <select name="perfil">
        <option value="usuario">Usuário</option>
        <option value="admin">Administrador</option>
    </select><br>
    <input type="submit" value="Cadastrar">
</form>