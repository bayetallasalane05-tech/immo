<?php 
include 'includes/header.php'; 
$host = 'localhost'; $dbname = 'SALANE_BASE_DE_DONNEE'; $user = 'root'; $pass = '';
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $annonces = $db->query("SELECT * FROM annonces ORDER BY date_publication DESC")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) { $annonces = []; }
?>

<main class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold mb-4" style="color:var(--royal-dark)">Tous nos Programmes Immobiliers</h2>
        <div class="row g-4">
            <?php foreach ($annonces as $row): ?>
            <div class="col-md-4">
                <a href="details.php?id=<?= $row['id'] ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="img/annonces/<?= $row['image_url'] ?>" class="card-img-top" style="height:200px; object-fit:cover;">
                        <div class="card-body">
                            <span class="badge bg-primary mb-2"><?= strtoupper($row['categorie']) ?></span>
                            <h5 class="card-title fw-bold text-dark"><?= htmlspecialchars($row['titre']) ?></h5>
                            <p class="text-primary fw-bold mb-1"><?= number_format($row['prix'], 0, ',', ' ') ?> FCFA</p>
                            <p class="small text-muted mb-0"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($row['localisation']) ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>