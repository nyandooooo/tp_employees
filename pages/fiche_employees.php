<?php
require("../inc/fonction.php");
$departement = get_Fiche_Employees($_GET["emp_no"]);
$salaire_historique = get_Salaire_Historique($_GET["emp_no"]);
$employe = $departement[0];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profil Employé - <?= htmlspecialchars($employe["first_name"] . " " . $employe["last_name"]) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: #232526;
            color: #f2f2f2;
            font-family: 'Inter', sans-serif;
        }
        .container-profile {
            max-width: 650px;
            margin: 2rem auto;
            padding: 2rem 1rem;
            background: #414345;
            border-radius: 18px;
            box-shadow: 0 4px 24px #0003;
        }
        .profile-header {
            display: flex;
            align-items: center;
            gap: 1.2rem;
            border-bottom: 1px solid #35363a;
            padding-bottom: 1.5rem;
            margin-bottom: 1.2rem;
        }
        .avatar {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 700;
        }
        .profile-header-info h2 {
            font-size: 1.35rem;
            margin: 0 0 .2rem 0;
            font-weight: 700;
            color: #fff;
        }
        .profile-header-info .role {
            color: #d6d7e2;
            font-size: .95rem;
            margin-bottom: .2rem;
        }
        .profile-header-info .years {
            font-size: .93rem;
            color: #667eea;
        }
        .actions {
            margin-top: 1rem;
            display: flex;
            gap: .7rem;
        }
        .actions .btn {
            font-size: .93rem;
            border-radius: 50px;
            font-weight: 600;
            border: none;
            transition: background .15s;
        }
        .btn-dep {
            background: linear-gradient(90deg,#667eea,#764ba2);
            color: #fff;
        }
        .btn-dep:hover {
            filter: brightness(1.08);
        }
        .btn-manager {
            background: linear-gradient(90deg,#43e97b,#38f9d7);
            color: #232526;
        }
        .btn-manager:hover {
            filter: brightness(1.08);
        }
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-top: 1.7rem;
            margin-bottom: .8rem;
            color: #667eea;
            display: flex;
            align-items: center;
            gap: .5rem;
        }
        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        .detail-block {
            background: #35363a;
            border-radius: 9px;
            padding: .8rem 1rem;
            margin-bottom: .3rem;
        }
        .detail-label {
            color: #a9aab5;
            font-size: .82rem;
            font-weight: 600;
        }
        .detail-value {
            font-size: 1.03rem;
            margin-top: .16rem;
            font-weight: 600;
        }
        /* Salaires */
        .salary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        .salary-table th, .salary-table td {
            padding: .65rem .5rem;
            text-align: left;
        }
        .salary-table th {
            color: #667eea;
            border-bottom: 1px solid #35363a;
            font-weight: 600;
            background: none;
        }
        .salary-table tr {
            border-radius: 8px;
        }
        .salary-table tr.current {
            background: #2d323e;
        }
        .salary-table td {
            color: #fff;
            font-size: .97rem;
            border-bottom: 1px solid #35363a;
        }
        .salary-table td.amount {
            color: #43e97b;
            font-weight: 700;
        }
        .salary-table td.period {
            color: #a3a7b7;
        }
        .salary-table tr:last-child td {
            border-bottom: none;
        }
        .salary-table .badge {
            background: linear-gradient(90deg,#43e97b,#38f9d7);
            color: #232526;
            font-weight: 600;
            border-radius: 11px;
            padding: 2px 12px;
            font-size: .81em;
            margin-left: 8px;
        }
        .empty-state {
            color: #a9aab5;
            text-align: center;
            padding: 2.5rem 0 1rem 0;
        }
        @media (max-width: 600px) {
            .container-profile {padding: 1rem;}
            .profile-header {flex-direction: column; align-items: flex-start; gap: .7rem;}
            .details-grid {grid-template-columns: 1fr;}
        }
    </style>
</head>
<body>
<?php
include '../assets/include/header.php';
displayHeader('#232526', '#414345', 'Salut', 'employee');
?>
<div class="container-profile">

    <div class="profile-header">
        <div class="avatar">
            <?= strtoupper(substr($employe["first_name"], 0, 1)) . strtoupper(substr($employe["last_name"], 0, 1)) ?>
        </div>
        <div class="profile-header-info">
            <h2><?= htmlspecialchars($employe["first_name"] . " " . $employe["last_name"]) ?></h2>
            <div class="role">Employé depuis le <?= date('d/m/Y', strtotime($employe["hire_date"])) ?></div>
            <div class="years"><?= date('Y') - date('Y', strtotime($employe["hire_date"])) ?> ans dans l'équipe</div>
        </div>
    </div>

    <div class="actions">
        <form action="custom.php" method="post">
            <input type="hidden" name="emp_no" value="<?= $employe["emp_no"] ?>">
            <button type="submit" class="btn btn-dep"><i class="fa fa-sync-alt me-1"></i>Changer de département</button>
        </form>
        <form action="custom_manager.php" method="post">
            <input type="hidden" name="emp_no" value="<?= $employe["emp_no"] ?>">
            <button type="submit" class="btn btn-manager"><i class="fa fa-user-tie me-1"></i>Devenir Manager</button>
        </form>
    </div>

    <div class="section-title"><i class="fas fa-user"></i>Informations personnelles</div>
    <div class="details-grid">
        <div class="detail-block">
            <div class="detail-label">Date de naissance</div>
            <div class="detail-value"><?= date('d/m/Y', strtotime($employe["birth_date"])) ?></div>
        </div>
        <div class="detail-block">
            <div class="detail-label">Âge</div>
            <div class="detail-value"><?= date('Y') - date('Y', strtotime($employe["birth_date"])) ?> ans</div>
        </div>
        <div class="detail-block">
            <div class="detail-label">Genre</div>
            <div class="detail-value"><?= $employe["gender"] == 'M' ? 'Masculin' : 'Féminin' ?></div>
        </div>
        <div class="detail-block">
            <div class="detail-label">ID Employé</div>
            <div class="detail-value"><?= $employe["emp_no"] ?></div>
        </div>
    </div>

    <div class="section-title"><i class="fas fa-money-bill-wave"></i>Historique des salaires</div>
    <?php if (!empty($salaire_historique)) { ?>
        <table class="salary-table">
            <thead>
                <tr>
                    <th>Période</th>
                    <th>Dates</th>
                    <th>Salaire</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($salaire_historique as $index => $salaire) { ?>
                <tr class="<?= $index === 0 ? 'current' : '' ?>">
                    <td class="period"><?= date('M Y', strtotime($salaire["from_date"])) ?> - <?= date('M Y', strtotime($salaire["to_date"])) ?>
                        <?php if ($index === 0) { ?><span class="badge">Actuel</span><?php } ?>
                    </td>
                    <td><?= date('d/m/Y', strtotime($salaire["from_date"])) ?> - <?= date('d/m/Y', strtotime($salaire["to_date"])) ?></td>
                    <td class="amount"><?= number_format($salaire["salary"], 0, ',', ' ') ?> €</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <div class="empty-state">
            <i class="fas fa-chart-line fa-2x mb-2"></i><br>
            Aucun historique de salaire disponible
        </div>
    <?php } ?>

</div>
</body>
</html>
