<footer>
    <small class="text-muted">App empleados - Desarrollado por Jonathan Blazquez © 2024</small>
</footer>

<script>
    $(document).ready(function() {
        $("#tabla_id").DataTable({
            "pageLength": 5,
            lengthMenu: [
                [5, 10, 20, -1],
                [5, 10, 20, "All"]
            ],
            "language": {
                "url": 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
            }
        });
    });

    const myModal = document.getElementById('myModal')
    const myInput = document.getElementById('myInput')

    myModal.addEventListener('shown.bs.modal', () => {
        myInput.focus()
    })
</script>

</body>

</html>
<style>
    footer {
        padding: 2rem;
    }

    .card {
        padding: 0;
    }

    .connection-state {
        height: 18px;
        width: 18px;
        border-radius: 100%;
    }

    main {
        min-height: 100dvh;
        height: auto;
    }

    .btn-profile {
        padding: 0;
        margin: 0;
        border-radius: 10px;
        border: none;
    }
</style>