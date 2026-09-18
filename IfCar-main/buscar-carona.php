<?php

require_once "config/database.php";

$origem  = $_GET['origem'] ?? '';
$destino = $_GET['destino'] ?? '';
$data    = $_GET['data'] ?? '';

$sql = "
    SELECT
        c.*,
        u.nome,
        u.foto
    FROM caronas c
    INNER JOIN usuarios u
        ON u.id = c.motorista_id
    WHERE c.origem LIKE :origem
    AND c.destino LIKE :destino
    AND c.data = :data
    AND c.status = 'ativa'
    ORDER BY c.horario ASC
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':origem' => "%$origem%",
    ':destino' => "%$destino%",
    ':data' => $data
]);

$caronas = $stmt->fetchAll();

?>

<h1>Encontrar carona</h1>

<?php foreach ($caronas as $carona): ?>

<div class="carona-card">

    <div class="motorista">

        <img
            src="<?= htmlspecialchars($carona['foto'] ?: '../assets/img/avatar.png') ?>"
            width="50"
        >

        <strong>
            <?= htmlspecialchars($carona['nome']) ?>
        </strong>

    </div>

    <p>
        📍 <?= htmlspecialchars($carona['origem']) ?>
    </p>

    <p>
        🎓 <?= htmlspecialchars($carona['destino']) ?>
    </p>

    <p>
        🕐 <?= htmlspecialchars($carona['horario']) ?>
    </p>

    <p>
        👥 <?= htmlspecialchars($carona['vagas']) ?> vagas
    </p>

    <strong>
        R$ <?= number_format($carona['valor'], 2, ',', '.') ?>
    </strong>

    <br>

    <a href="detalhes-carona.php<?= $carona['id'] ?>">
        Ver carona
    </a>

</div>

<?php endforeach; ?>