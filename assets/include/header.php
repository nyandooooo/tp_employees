<?php


function getActiveClass($page, $activePage)
{
    return ($activePage === $page) ? 'active' : '';
}


function displayHeader(
    $primaryColor = '#667eea',
    $secondaryColor = '#764ba2',
    $brandName = 'BrandName',
    $activePage = ''
) {
?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <style>
            .custom-header {
                background: linear-gradient(135deg, <?php echo $primaryColor; ?> 0%, <?php echo $secondaryColor; ?> 100%);
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                min-height: 60px;
            }

            .navbar-brand {
                font-weight: 600;
                font-size: 1.4rem;
                color: white !important;
                text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
                transition: transform 0.3s ease;
            }

            .navbar-brand:hover {
                transform: scale(1.03);
                color: #f8f9fa !important;
            }

            .navbar-nav .nav-link {
                color: rgba(255, 255, 255, 0.9) !important;
                font-weight: 400;
                font-size: 0.9rem;
                margin: 0 5px;
                padding: 8px 14px !important;
                border-radius: 20px;
                transition: all 0.3s ease;
            }

            .navbar-nav .nav-link:hover {
                color: white !important;
                background: rgba(255, 255, 255, 0.1);
                transform: translateY(-1px);
            }

            .navbar-nav .nav-link.active {
                background: rgba(255, 255, 255, 0.2);
                color: white !important;
                font-weight: 500;
            }

            .btn-cta {
                background: linear-gradient(45deg, #ff6b6b, #ee5a24);
                border: none;
                padding: 6px 18px;
                border-radius: 20px;
                font-weight: 500;
                font-size: 0.85rem;
                color: white;
                transition: all 0.3s ease;
                box-shadow: 0 2px 8px rgba(255, 107, 107, 0.3);
            }

            .btn-cta:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(255, 107, 107, 0.4);
                color: white;
            }

            .navbar-toggler {
                border: none;
                padding: 2px 6px;
                font-size: 0.9rem;
            }

            .navbar-toggler:focus {
                box-shadow: none;
            }

            .navbar-toggler-icon {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='m4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
            }

            .search-form {
                position: relative;
            }

            .search-input {
                background: rgba(255, 255, 255, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.3);
                border-radius: 20px;
                padding: 6px 30px 6px 12px;
                color: white;
                font-size: 0.85rem;
                width: 160px;
                transition: all 0.3s ease;
            }

            .search-input::placeholder {
                color: rgba(255, 255, 255, 0.7);
                font-size: 0.85rem;
            }

            .search-input:focus {
                outline: none;
                border-color: rgba(255, 255, 255, 0.5);
                background: rgba(255, 255, 255, 0.15);
                box-shadow: 0 0 0 0.1rem rgba(255, 255, 255, 0.1);
                width: 200px;
            }

            .search-btn {
                position: absolute;
                right: 8px;
                top: 50%;
                transform: translateY(-50%);
                background: none;
                border: none;
                color: rgba(255, 255, 255, 0.8);
                font-size: 0.8rem;
                transition: color 0.3s ease;
            }

            .search-btn:hover {
                color: white;
            }

            .page-indicator {
                background: rgba(255, 255, 255, 0.1);
                padding: 3px 10px;
                border-radius: 15px;
                font-size: 0.75rem;
                color: rgba(255, 255, 255, 0.8);
                margin-left: 8px;
            }

            .navbar-brand i {
                font-size: 1.2rem;
            }

            .nav-link i {
                font-size: 0.8rem;
            }

            .btn-cta i {
                font-size: 0.75rem;
            }

            @media (max-width: 991px) {
                .search-form {
                    margin-top: 8px;
                }

                .search-input {
                    width: 100%;
                }

                .search-input:focus {
                    width: 100%;
                }

                .page-indicator {
                    display: none;
                }

                .navbar-nav .nav-link {
                    margin: 1px 0;
                    font-size: 0.85rem;
                }
            }

            @media (max-width: 768px) {
                .navbar-brand {
                    font-size: 1.2rem;
                }

                .navbar-brand i {
                    font-size: 1rem;
                }
            }

            .search-form .form-select {
                background: rgba(255, 255, 255, 0.18);
                color: #fff;
                border: 1px solid rgba(255, 255, 255, 0.22);
                border-radius: 18px;
                font-size: 0.96rem;
                min-width: 110px;
                max-width: 160px;
                transition: border 0.2s, background 0.2s;
            }

            .search-form .form-select:focus {
                outline: none;
                border-color: #fff;
                background: rgba(255, 255, 255, 0.28);
                color: #fff;
            }

            .search-form .form-select option {
                color: #333;
                background: #f4f4f4;
            }

            @media (max-width: 700px) {
                .search-form {
                    flex-direction: column;
                    align-items: stretch !important;
                    gap: 0.5rem !important;
                }

                .search-form .form-control,
                .search-form .form-select,
                .search-form .btn {
                    width: 100%;
                    min-width: 0;
                    margin-bottom: 0 !important;
                }
            }
        </style>
    </head>

    <body>
        <!-- Header -->
        <nav class="navbar navbar-expand-lg navbar-dark custom-header">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <i class="fas fa-rocket me-2"></i>
                    <?php echo htmlspecialchars($brandName); ?>
                </a>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link <?php echo getActiveClass('dep', $activePage); ?>" href="index.php">
                                <i class="fas fa-home me-1"></i>
                                Départements
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo getActiveClass('employee', $activePage); ?>" href="#">
                                <i class="fas fa-info-circle me-1"></i>
                                Employees
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo getActiveClass('stats', $activePage); ?>" href="stats_departements.php">
                                <i class="fas fa-cogs me-1"></i>
                                Statistiques Départements
                            </a>
                        </li>
                      
                     
                    </ul>
                    <div class="d-flex align-items-center">
                        <form class="d-flex align-items-center me-2 gap-2 search-form" method="GET" action="recherche.php">
                            <input type="search" name="search" class="form-control search-input" placeholder="Rechercher..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <select name="by" class="form-select form-select-sm">
                                <option value="departement">Département</option>
                                <option value="nom">Nom employé</option>
                                <option value="age_min">Age minimum</option>
                                <option value="age_max">Age maximum</option>
                            </select>
                            <button class="btn search-btn btn-primary ms-1" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                        <a href="register.php" class="btn btn-cta ms-2">
                            <i class="fas fa-user-plus me-1"></i>
                            Commencer
                        </a>
                    </div>


                </div>
            </div>
        </nav>
    <?php
}
    ?>

    git push -u origin main
  665  git init
  666  git remote add origin https://github.com/Sedra276/ANDRANA.git
  667  git pull -a -m origin master:main
  668  git pull origin main
  669  git commit -a -m "domino"

  git commit -a -m "message"
  git push -u origin main