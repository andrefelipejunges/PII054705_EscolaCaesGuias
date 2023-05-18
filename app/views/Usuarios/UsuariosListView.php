<?php
include_once "../../../Config.php";
include DIR_PATH.'app/views/Esqueleto/Esqueleto.php';

// Cria uma instância do controlador de usuários
require_once DIR_PATH.'/app/controllers/Usuarios/UsuariosController.php';
$usuariosController = new UsuariosController();

// Define a quantidade de registros por página
$registrosPorPagina = 10;

$usuarios = $usuariosController->processRequest("consultarUsuario");
// Calcula o número total de páginas
$totalRegistros = count($usuarios);
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);

// Verifica se a página atual está definida na URL, caso contrário, define como página 1
if (!isset($_GET['pagina'])) {
    $_GET['pagina'] = 1;
}

// Define o número da página atual e calcula o registro inicial e final
$paginaAtual = $_GET['pagina'];
$registroInicial = ($paginaAtual - 1) * $registrosPorPagina;
$registroFinal = $registroInicial + $registrosPorPagina;

// Recupera apenas os registros da página atual
$usuarios = array_slice($usuarios, $registroInicial, $registrosPorPagina);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Consulta de usuário</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            text-align: left;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            text-align: center;
        }

        .container h1 {
            font-size: 36px;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 30px;
            font-size: 18px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #3e8e41;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .pagination a {
            display: inline-block;
            padding: 5px 10px;
            background-color: #f2f2f2;
            color: black;
            border-radius: 5px;
            text-decoration: none;
            margin: 0 5px;
        }

        .pagination a.active {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
<div class="container-cadastro">
    <h1>Consulta de Usuários</h1>
    <table>
        <tr>
            <th style="background-color: #2F4F4F; color: white;" >Login</th>
            <th style="background-color: #2F4F4F; color: white;">E-mail</th>
        </tr>
        <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?php echo $usuario['LOGIN'] ?></td>
                <td><?php echo $usuario['EMAIL'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
   
    <div class="pagination">
        <?php if ($paginaAtual > 1): ?>
            <a href="?pagina=<?php echo $paginaAtual - 1; ?>">Anterior</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
            <?php if ($i == $paginaAtual): ?>
                <a href="?pagina=<?php echo $i; ?>" class="active"><?php echo $i; ?></a>
            <?php else: ?>
                <a href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
            <?php endif; ?>
        <?php endfor; ?>
        <?php if ($paginaAtual < $totalPaginas): ?>
            <a href="?pagina=<?php echo $paginaAtual + 1; ?>">Próxima</a>
        <?php endif; ?>
    </div>
    
</div>
</body>
</html>
