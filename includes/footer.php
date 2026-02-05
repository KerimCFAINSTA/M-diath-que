</main>
<!-- Fin du contenu principal -->

<footer class="footer bg-dark text-white text-center py-4 mt-5">
    <div class="container">
        <p class="mb-0">&copy; <?= date('Y') ?> Médiathèque de Versailles - Tous droits réservés</p>
    </div>
</footer>

<script>
// Fonction pour confirmer la suppression
function confirmerSuppression(message) {
    return confirm(message || 'Êtes-vous sûr de vouloir supprimer cet élément ?');
}
</script>

</body>
</html>