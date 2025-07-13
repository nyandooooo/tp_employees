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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --surface-color: #ffffff;
            --background-color: #f8fafc;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
            --accent-color: #667eea;
            --shadow-light: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-medium: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-strong: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--background-color);
            color: var(--text-primary);
            line-height: 1.6;
        }

        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Header avec effet moderne */
        /* Améliorations visuelles supplémentaires */
        .profile-header {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.02) 0%, rgba(118, 75, 162, 0.02) 100%);
            border-radius: 2rem;
            padding: 2.5rem;
            margin-bottom: 2rem;
            border: 1px solid var(--border-color);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06);
            position: relative;
            overflow: hidden;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }

        .profile-header::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.03) 0%, transparent 70%);
            pointer-events: none;
        }

        .profile-header-content {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .profile-avatar-container {
            position: relative;
        }

        .profile-avatar {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            border: 6px solid white;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            position: relative;
        }

        .profile-avatar::before {
            content: '';
            position: absolute;
            top: -8px;
            left: -8px;
            right: -8px;
            bottom: -8px;
            background: conic-gradient(from 0deg, #667eea, #764ba2, #667eea);
            border-radius: 50%;
            z-index: -1;
            opacity: 0.3;
        }

        .profile-status {
            position: absolute;
            bottom: 10px;
            right: 10px;
            width: 24px;
            height: 24px;
            background: var(--success-gradient);
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: var(--shadow-light);
        }

        .profile-info {
            flex: 1;
        }

        .profile-name {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .profile-title {
            color: var(--text-secondary);
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .profile-stats {
            display: flex;
            gap: 2rem;
            margin-bottom: 1.5rem;
        }

        .profile-stat {
            text-align: center;
            padding: 1rem 1.25rem;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
            border-radius: 1.25rem;
            min-width: 90px;
            border: 1px solid rgba(102, 126, 234, 0.1);
            transition: all 0.2s ease;
        }

        .profile-stat:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.15);
        }

        .stat-count {
            display: block;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--accent-color);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.75rem;
            color: var(--text-secondary);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .profile-bio {
            background: rgba(102, 126, 234, 0.05);
            padding: 0.75rem 1.25rem;
            border-radius: 1rem;
            border-left: 4px solid var(--accent-color);
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        /* Section des détails */
        .profile-details {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 250, 252, 0.9) 100%);
            border-radius: 2rem;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid var(--border-color);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06);
            backdrop-filter: blur(10px);
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            color: var(--text-primary);
        }

        .section-title i {
            margin-right: 0.75rem;
            color: var(--accent-color);
            font-size: 1rem;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .detail-item {
            padding: 1.25rem;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.8) 0%, rgba(248, 250, 252, 0.8) 100%);
            border-radius: 1.25rem;
            border: 1px solid rgba(102, 126, 234, 0.08);
            transition: all 0.2s ease;
        }

        .detail-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.12);
            border-color: rgba(102, 126, 234, 0.2);
        }

        .detail-label {
            display: block;
            font-size: 0.75rem;
            color: var(--text-secondary);
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .detail-value {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .detail-icon {
            color: var(--accent-color);
            font-size: 0.875rem;
        }

        /* Section historique des salaires */
        .salary-history {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 250, 252, 0.9) 100%);
            border-radius: 2rem;
            padding: 2rem;
            border: 1px solid var(--border-color);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06);
            backdrop-filter: blur(10px);
        }

        .salary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.8) 0%, rgba(248, 250, 252, 0.8) 100%);
            border-radius: 1.25rem;
            border: 1px solid rgba(102, 126, 234, 0.08);
            transition: all 0.3s ease;
        }

        .salary-item:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(102, 126, 234, 0.15);
            border-color: rgba(102, 126, 234, 0.2);
        }

        .salary-item:last-child {
            margin-bottom: 0;
        }

        .salary-dates {
            color: var(--text-secondary);
            font-size: 0.8rem;
            font-weight: 500;
        }

        .salary-period {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .salary-amount {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--accent-color);
        }

        .salary-currency {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin-left: 0.25rem;
        }

        /* Badge pour le salaire actuel */
        .current-salary {
            position: relative;
        }

        .current-salary::after {
            content: 'Actuel';
            position: absolute;
            top: -8px;
            right: -8px;
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
            border-radius: 50px;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(67, 233, 123, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Message d'état vide */
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--accent-color);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .profile-container {
                padding: 1rem;
            }

            .profile-header {
                padding: 2rem;
            }

            .profile-header-content {
                flex-direction: column;
                text-align: center;
            }

            .profile-avatar {
                width: 120px;
                height: 120px;
                font-size: 2.5rem;
            }

            .profile-name {
                font-size: 2rem;
            }

            .profile-stats {
                justify-content: center;
                gap: 1rem;
            }

            .details-grid {
                grid-template-columns: 1fr;
            }

            .salary-item {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .profile-details, .salary-history {
                padding: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .profile-stats {
                flex-direction: column;
                align-items: center;
            }

            .profile-stat {
                width: 100%;
                max-width: 200px;
            }
        }
    </style>
</head>

<body>
    <?php
    include '../assets/include/header.php';
    displayHeader('#232526', '#414345', 'Salut', 'employee');
    ?>
    <div class="profile-container">
        <form action="custom.php" method="post">
            <input type="hidden" name="emp_no" value="<?= $employe["emp_no"] ?>">
          <input type="submit" value="changer de département">
        </form>
         <form action="custom_manager.php" method="post">
            <input type="hidden" name="emp_no" value="<?= $employe["emp_no"] ?>">
          <input type="submit" value="Devenir Manager">
        </form>
        <div class="profile-header">
            <div class="profile-header-content">
                <div class="profile-avatar-container">
                    <div class="profile-avatar">
                        <?= strtoupper(substr($employe["first_name"], 0, 1)) . strtoupper(substr($employe["last_name"], 0, 1)) ?>
                    </div>
                    <div class="profile-status"></div>
                </div>
                
                <div class="profile-info">
                    <h1 class="profile-name"><?= htmlspecialchars($employe["first_name"] . " " . $employe["last_name"]) ?></h1>
                    <p class="profile-title">Employé depuis le <?= date('d/m/Y', strtotime($employe["hire_date"])) ?></p>
                    
                    <div class="profile-stats">
                        <div class="profile-stat">
                            <span class="stat-count"><?= $employe["emp_no"] ?></span>
                            <span class="stat-label">ID Employé</span>
                        </div>
                        <div class="profile-stat">
                            <span class="stat-count"><?= $employe["gender"] == 'M' ? 'H' : 'F' ?></span>
                            <span class="stat-label">Genre</span>
                        </div>
                        <div class="profile-stat">
                            <span class="stat-count"><?= date('Y') - date('Y', strtotime($employe["hire_date"])) ?></span>
                            <span class="stat-label">Années</span>
                        </div>
                    </div>
                    
                    <div class="profile-bio">
                        <i class="fas fa-info-circle"></i>
                        Membre de l'équipe depuis <?= date('Y') - date('Y', strtotime($employe["hire_date"])) ?> ans
                    </div>
                </div>
            </div>
        </div>

        <!-- Détails du profil -->
        <div class="profile-details">
            <h2 class="section-title">
                <i class="fas fa-user"></i>
                Informations personnelles
            </h2>
            
            <div class="details-grid">
                <div class="detail-item">
                    <span class="detail-label">Date de naissance</span>
                    <div class="detail-value">
                        <i class="fas fa-calendar-alt detail-icon"></i>
                        <?= date('d/m/Y', strtotime($employe["birth_date"])) ?>
                    </div>
                </div>
                
                <div class="detail-item">
                    <span class="detail-label">Date d'embauche</span>
                    <div class="detail-value">
                        <i class="fas fa-briefcase detail-icon"></i>
                        <?= date('d/m/Y', strtotime($employe["hire_date"])) ?>
                    </div>
                </div>
                
                <div class="detail-item">
                    <span class="detail-label">Genre</span>
                    <div class="detail-value">
                        <i class="fas fa-<?= $employe["gender"] == 'M' ? 'mars' : 'venus' ?> detail-icon"></i>
                        <?= $employe["gender"] == 'M' ? 'Masculin' : 'Féminin' ?>
                    </div>
                </div>
                
                <div class="detail-item">
                    <span class="detail-label">Âge</span>
                    <div class="detail-value">
                        <i class="fas fa-hourglass-half detail-icon"></i>
                        <?= date('Y') - date('Y', strtotime($employe["birth_date"])) ?> ans
                    </div>
                </div>
            </div>
        </div>

        <!-- Historique des salaires -->
        <?php if (!empty($salaire_historique)) { ?>
            <div class="salary-history">
                <h2 class="section-title">
                    <i class="fas fa-money-bill-wave"></i>
                    Historique des salaires
                </h2>

                <?php foreach ($salaire_historique as $index => $salaire) { ?>
                    <div class="salary-item <?= $index === 0 ? 'current-salary' : '' ?>">
                        <div>
                            <div class="salary-period">
                                <?= date('M Y', strtotime($salaire["from_date"])) ?> - <?= date('M Y', strtotime($salaire["to_date"])) ?>
                            </div>
                            <div class="salary-dates">
                                <?= date('d/m/Y', strtotime($salaire["from_date"])) ?> - <?= date('d/m/Y', strtotime($salaire["to_date"])) ?>
                            </div>
                        </div>
                        <div class="salary-amount">
                            <?= number_format($salaire["salary"], 0, ',', ' ') ?><span class="salary-currency">€</span>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="salary-history">
                <h2 class="section-title">
                    <i class="fas fa-money-bill-wave"></i>
                    Historique des salaires
                </h2>
                <div class="empty-state">
                    <i class="fas fa-chart-line"></i>
                    <p>Aucun historique de salaire disponible</p>
                </div>
            </div>
        <?php } ?>
    </div>
</body>

</html>