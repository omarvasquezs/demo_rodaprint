<!-- Footer -->
<footer class="bg-dark py-4 footer">
    <div class="container text-center text-opacity-50 text-light">
        <p class="mt-4">DEMO GUIAS RODAPRINT</p>
    </div>
</footer>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Grocery Crud js files -->
<?php foreach ($js_files as $file): ?>
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<!-- select2@4.0.13 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- CUSTOM JS -->
<script type="text/javascript" src="<?= base_url() ?>themes/rodaprint/theme.js"></script>
</body>

</html>