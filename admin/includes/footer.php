            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile menu toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('collapse');
        });

        // Confirm before delete
        function confirmDelete() {
            return confirm('Are you sure you want to delete this item?');
        }
    </script>
</body>
</html>