<?php 
include 'includes/header.php'; 

// Connexion BDD
$host = 'localhost'; $dbname = 'SALANE_BASE_DE_DONNEE'; $user = 'root'; $pass = '';
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    
    // 1. Récupération des terrains uniquement
    $stmt = $db->prepare("SELECT * FROM annonces WHERE categorie = 'terrain' ORDER BY date_publication DESC");
    $stmt->execute();
    $terrains = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 2. Initialisation de la variable vidéo pour éviter le Warning
    $video_terrain = null; 
    $vid_query = $db->prepare("SELECT video_url FROM videos_accueil WHERE section_nom = ?");
    $vid_query->execute(['terrain']);
    $video_terrain = $vid_query->fetchColumn();

} catch (Exception $e) { 
    $terrains = []; 
    $video_terrain = null;
}


?>

<style>
    :root { --royal-dark: #003366; --royal-light: #00BFFF; }

   /* --- HERO CATEGORY --- */
.hero-category {
    position: relative;
    height: 50vh;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    text-align: center;
}

.hero-category video {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    object-fit: cover; z-index: -1;
}

.hero-overlay {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    /* On change le 0.6 en 0 pour une transparence totale */
    background: rgba(0, 51, 102, 0); 
    z-index: 0;
    /* Optionnel : si tu ne veux plus qu'il bloque les clics */
    pointer-events: none; 
}

    /* --- GRILLE --- */
    .terrains-section { padding: 80px 0; }
    .annonce-link { text-decoration: none; color: inherit; display: block; }
    
    .project-card { 
        position: relative; 
        height: 380px; 
        border-radius: 15px; 
        overflow: hidden; 
        display: flex; 
        flex-direction: column; 
        justify-content: flex-end; 
        background-size: cover; 
        background-position: center;
        transition: 0.3s ease;
        border: 1px solid #eee;
    }
    .annonce-link:hover .project-card { transform: translateY(-10px); box-shadow: 0 15px 35px rgba(0,0,0,0.2); }

    .project-info { 
        background: rgba(0, 51, 102, 0.85); 
        padding: 25px; 
        color: #fff; 
        backdrop-filter: blur(5px);
    }
    .price-tag { color: var(--royal-light); font-weight: 800; font-size: 1.2rem; }
</style>

<main>
    <section class="hero-category">
        <video autoplay muted loop playsinline><source src="terrains.mp4" type="video/mp4"></video>
        <div class="hero-overlay"></div>
        <div class="hero-content" style="position:relative; z-index:1;">
            <h1 class="display-3 fw-bold">Terrains Viabilisés</h1>
            <p class="lead">Bâtissez votre futur sur des bases solides de Diamniadio à Bambilor.</p>
        </div>
    </section>

    <section class="container terrains-section">
        <div class="text-center mb-5">
            <h2 style="color:var(--royal-dark); font-weight:800; text-transform:uppercase;">Nos Opportunités Foncières</h2>
            <div style="width:80px; height:4px; background:var(--royal-light); margin:10px auto;"></div>
        </div>

        <?php if (count($terrains) > 0): ?>
            <div class="row g-4">
                <?php foreach ($terrains as $row): ?>
                <div class="col-md-4">
                    <a href="details.php?id=<?= $row['id'] ?>" class="annonce-link">
                        <div class="project-card" style="background-image: url('img/annonces/<?= $row['image_url'] ?>');">
                            <div class="project-info">
                                <h4 class="mb-1 text-uppercase fw-bold"><?= htmlspecialchars($row['titre']) ?></h4>
                                <div class="price-tag mb-2"><?= number_format($row['prix'], 0, ',', ' ') ?> FCFA</div>
                                <div class="small">
                                    <i class="bi bi-rulers"></i> <?= $row['surface'] ?> m² | 
                                    <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($row['localisation']) ?>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-map text-muted display-1"></i>
                <p class="mt-3 fs-5 text-muted">Aucun terrain disponible pour le moment.</p>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php include 'includes/footer.php'; ?>