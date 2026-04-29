<style>
    .footer-dark { 
        background: #050505; 
        color: #fff; 
        padding: 10px 0 8px; 
        font-size: 16px;
        border-top: 3px solid var(--royal-dark);
    }
    .footer-grid { 
        display: grid; 
        grid-template-columns: 1.5fr 1fr 1fr 1fr; 
        gap: 40px; 
    }
    .footer-col h5 { 
        color: var(--royal-light); 
        font-weight: 800; 
        margin-bottom: 25px; 
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .footer-links { 
        list-style: none; 
        padding: 0; 
    }
    .footer-links li { 
        margin-bottom: 18px; 
        display: flex; 
        align-items: center; 
        gap: 12px; 
    }
    .footer-links a { 
        color: #ffffff; 
        text-decoration: none; 
        transition: 0.3s ease; 
    }
    .footer-links a:hover { 
        color: var(--royal-light); 
        padding-left: 5px;
    }
    .footer-links i { 
        color: var(--royal-light); 
        font-size: 1.1rem;
    }
    
    .social-icons { 
        display: flex; 
        gap: 12px; 
        margin-top: 15px; 
    }
    .social-icons a { 
        background: #fff; 
        color: #000; 
        width: 38px; 
        height: 38px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        border-radius: 5px; 
        text-decoration: none; 
        font-size: 18px;
        transition: 0.3s transform ease;
    }
    .social-icons a:hover { 
        background: var(--royal-light); 
        color: #fff; 
        transform: translateY(-5px);
    }

    @media (max-width: 992px) {
        .footer-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 576px) {
        .footer-grid { grid-template-columns: 1fr; }
    }
</style>

<footer class="footer-dark">
    <div class="container footer-grid">
        <div class="footer-col">
            <h5>À Propos</h5>
            <p style="line-height: 1.8; color: #d1d1d1;">
                <strong>ROYAL IMMO</strong> est votre partenaire de confiance au Sénégal. Nous bâtissons l'avenir ensemble à travers des projets immobiliers d'exception, alliant sécurité juridique et confort moderne.
            </p>
        </div>

        <div class="footer-col">
            <h5>Contact</h5>
            <ul class="footer-links">
                <li><i class="bi bi-geo-alt-fill"></i> Point E, Dakar, Sénégal</li>
                <li><i class="bi bi-telephone-fill"></i> +221 33 869 40 00</li>
                <li><i class="bi bi-envelope-at-fill"></i> contact@royalimmo.sn</li>
            </ul>
        </div>

        <div class="footer-col">
            <h5>Liens rapides</h5>
            <ul class="footer-links">
                <li><i class="bi bi-chevron-right"></i> <a href="index.php#villas">Nos Villas</a></li>
                <li><i class="bi bi-chevron-right"></i> <a href="index.php#apparts">Nos Appartements</a></li>
                <li><i class="bi bi-chevron-right"></i> <a href="index.php#terrains">Nos Terrains</a></li>
                <li><i class="bi bi-chevron-right"></i> <a href="index.php#avantages">Nos Avantages</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h5>Suivez-nous</h5>
            <div class="social-icons">
                <a href="#" title="Facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" title="TikTok"><i class="bi bi-tiktok"></i></a>
                <a href="#" title="X (Twitter)"><i class="bi bi-twitter-x"></i></a>
                <a href="#" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
                <a href="#" title="Instagram"><i class="bi bi-instagram"></i></a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="text-center mt-5 pt-4" style="border-top: 1px solid #222; color: #797575;">
            <small>© 2026 <strong>ROYAL IMMO</strong> - Excellence Immobilière au Sénégal. Tous droits réservés.</small>
        </div>
    </div>
</footer>