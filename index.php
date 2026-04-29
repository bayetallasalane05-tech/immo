<?php 
include 'includes/header.php'; 

// Connexion BDD
$host = 'localhost'; $dbname = 'SALANE_BASE_DE_DONNEE'; $user = 'root'; $pass = '';
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Annonces Récentes
    $annonces = $db->query("SELECT * FROM annonces ORDER BY date_publication DESC LIMIT 6")->fetchAll(PDO::FETCH_ASSOC);
    // Villas & Apparts
    $residentiel = $db->query("SELECT * FROM annonces WHERE type_bien IN ('VILLA', 'APPARTEMENT') ORDER BY date_publication DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);
    // Terrains
    $foncier = $db->query("SELECT * FROM annonces WHERE type_bien = 'TERRAIN' ORDER BY date_publication DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) { $annonces = []; $residentiel = []; $foncier = []; }
?>

<style>
    :root { --royal-dark: #003366; --royal-light: #00BFFF; }
    
    /* Structure Full-Width pour les vidéos */
    .section-hero {
        position: relative;
        width: 100%;
        height: 60vh;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        color: #fff;
        text-align: center;
        margin-bottom: 50px;
    }

    .section-hero video {
        position: absolute;
        top: 50%; left: 50%;
        min-width: 100%; min-height: 100%;
        width: auto; height: auto;
        transform: translate(-50%, -50%);
        z-index: -2;
        object-fit: cover;
    }

    .hero-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 51, 102, 0.4); /* Filtre pour la lisibilité */
        z-index: -1;
    }

    .hero-text-content { padding: 20px; z-index: 1; }
    .hero-text-content h1, .hero-text-content h2 { font-weight: 800; text-shadow: 2px 2px 10px rgba(0,0,0,0.5); }
    .hero-text-content p { font-size: 1.3rem; max-width: 800px; margin: 0 auto; text-shadow: 1px 1px 5px rgba(0,0,0,0.5); }

    /* Grille d'annonces */
    .project-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px; margin-bottom: 80px; }
    .annonce-link { text-decoration: none; color: inherit; }
    .project-card { 
        height: 380px; border-radius: 12px; overflow: hidden; 
        display: flex; flex-direction: column; justify-content: flex-end; 
        background-size: cover; background-position: center; transition: 0.3s ease; 
    }
    .annonce-link:hover .project-card { transform: translateY(-10px); box-shadow: 0 15px 35px rgba(0,0,0,0.2); }
    .project-info { background: linear-gradient(to top, rgba(0, 51, 102, 0.9) 20%, transparent); padding: 25px 20px; color: #fff; }

    /* Nouvelles sections générées */
    .content-block { padding: 80px 0; border-bottom: 1px solid #f0f0f0; }
    .content-block h2 { color: var(--royal-dark); font-weight: 800; margin-bottom: 30px; position: relative; }
    .content-block h2::after { content: ''; display: block; width: 60px; height: 4px; background: var(--royal-light); margin-top: 10px; }
    .content-block p { line-height: 1.8; color: #444; font-size: 1.1rem; }

    .stats-section { background: var(--royal-dark); color: #fff; padding: 80px 0; text-align: center; }
</style>

<main>
    <section class="section-hero">
        <video autoplay muted loop playsinline><source src="acceuil.mp4" type="video/mp4"></video>
        <div class="hero-overlay"></div>
        <div class="hero-text-content">
            <h1>Vivez la Sécurité et le Confort avec Royal Immo</h1>
        </div>
    </section>

    <section class="container">
        <h2 class="text-center mb-5" style="color:var(--royal-dark); font-weight:800;">Nos Annonces Récentes</h2>
        <div class="project-grid">
            <?php foreach ($annonces as $row): ?>
            <a href="details.php?id=<?= $row['id_annonce'] ?>" class="annonce-link">
                <div class="project-card" style="background-image: url('uploads/<?= $row['image_principale'] ?>');">
                    <div class="project-info">
                        <h4><?= htmlspecialchars($row['titre']) ?></h4>
                        <p><?= number_format($row['prix'], 0, ',', ' ') ?> FCFA</p>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="villas" class="section-hero">
        <video autoplay muted loop playsinline><source src="video_villas.mp4" type="video/mp4"></video>
        <div class="hero-overlay"></div>
        <div class="hero-text-content">
            <h2>Nos Villas d'Exception</h2>
            <p>Le luxe, le confort et l'intimité dans les plus beaux quartiers du Sénégal.</p>
        </div>
    </section>

    <section class="container">
        <div class="project-grid">
            <?php foreach ($residentiel as $res): if($res['type_bien'] == 'VILLA'): ?>
            <a href="details.php?id=<?= $res['id_annonce'] ?>" class="annonce-link">
                <div class="project-card" style="background-image: url('uploads/<?= $res['id_annonce'] ?>.jpg');">
                    <div class="project-info"><h4><?= htmlspecialchars($res['titre']) ?></h4></div>
                </div>
            </a>
            <?php endif; endforeach; ?>
        </div>
        <div class="content-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <h2>L'Excellence Architecturale à Votre Service</h2>
                    <p>
                        Chez Royal Immo, nous concevons des villas qui ne sont pas seulement des maisons, mais des havres de paix. Chaque projet est étudié pour maximiser la lumière naturelle et la circulation de l'air, tout en garantissant une sécurité totale pour votre famille. Nos finitions haut de gamme et nos emplacements stratégiques à Dakar et Saly font de nos villas un investissement pérenne et prestigieux.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="apparts" class="section-hero">
        <video autoplay muted loop playsinline><source src="video_appartements.mp4" type="video/mp4"></video>
        <div class="hero-overlay"></div>
        <div class="hero-text-content">
            <h2>Appartements de Standing</h2>
            <p>Modernité, confort et sécurité au cœur des plus beaux quartiers de Dakar.</p>
        </div>
    </section>

    <section class="container">
        <div class="project-grid">
            <?php foreach ($residentiel as $res): if($res['type_bien'] == 'APPARTEMENT'): ?>
            <a href="details.php?id=<?= $res['id_annonce'] ?>" class="annonce-link">
                <div class="project-card" style="background-image: url('uploads/<?= $res['id_annonce'] ?>.jpg');">
                    <div class="project-info"><h4><?= htmlspecialchars($res['titre']) ?></h4></div>
                </div>
            </a>
            <?php endif; endforeach; ?>
        </div>
        <div class="content-block">
            <h2>Une Vie Urbaine Redéfinie</h2>
            <p>
                Nos résidences d'appartements offrent une expérience de vie moderne sans compromis. Équipés de systèmes de domotique, de parkings sécurisés et d'espaces communs optimisés, nos appartements répondent aux exigences des citadins actifs. Que vous cherchiez un pied-à-terre luxueux au Plateau ou un appartement familial à Ngor Virage, Royal Immo vous accompagne vers le bien idéal.
            </p>
        </div>
    </section>

    <section id="terrains" class="section-hero">
        <video autoplay muted loop playsinline><source src="video_terrains.mp4" type="video/mp4"></video>
        <div class="hero-overlay"></div>
        <div class="hero-text-content">
            <h2>Terrains Viabilisés</h2>
            <p>Bâtissez votre futur sur des bases solides de Diamniadio à Bambilor.</p>
        </div>
    </section>

    <section class="container">
        <div class="project-grid">
            <?php foreach ($foncier as $fon): ?>
            <a href="details.php?id=<?= $fon['id_annonce'] ?>" class="annonce-link">
                <div class="project-card" style="background-image: url('uploads/<?= $fon['id_annonce'] ?>.jpg');">
                    <div class="project-info"><h4><?= htmlspecialchars($fon['titre']) ?></h4></div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <div class="content-block">
            <h2>Investir dans le Foncier Sécurisé</h2>
            <p>
                L'acquisition d'un terrain est la première étape d'un projet de vie. C'est pourquoi Royal Immo sélectionne rigoureusement des parcelles viabilisées, avec des titres de propriété clairs et vérifiés. De Diamniadio à Bambilor, nous vous offrons l'accès à des zones en plein développement économique, garantissant une plus-value certaine pour vos projets de construction futurs.
            </p>
        </div>
    </section>

    <section class="container content-block text-center">
        <h2>Pourquoi Faire Confiance à Royal Immo ?</h2>
        <div class="row mt-5">
            <div class="col-md-4">
                <i class="bi bi-shield-check" style="font-size: 3rem; color: var(--royal-light);"></i>
                <h4 class="mt-3">Sécurité Juridique</h4>
                <p>Tous nos biens passent par un audit rigoureux pour garantir une transaction transparente et sans litige.</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-geo-fill" style="font-size: 3rem; color: var(--royal-light);"></i>
                <h4 class="mt-3">Emplacements Premium</h4>
                <p>Nous ne choisissons que les zones à fort potentiel de croissance et de qualité de vie.</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-people-fill" style="font-size: 3rem; color: var(--royal-light);"></i>
                <h4 class="mt-3">Accompagnement</h4>
                <p>De la visite à la signature finale, nos experts vous conseillent pour chaque étape de votre achat.</p>
            </div>
        </div>
    </section>

    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4"><h4>2026</h4><p>Depuis</p></div>
                <div class="col-md-4"><h4>30 +</h4><p>Projets livrés</p></div>
                <div class="col-md-4"><h4>1,500 +</h4><p>Clients satisfaits</p></div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>