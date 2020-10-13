<?php
ob_start();
?>
    <!-- Script js ToastMessage :
    Affiche un message pour confirmer la connection en cas de succès
    ou un message d'erreur quand le serveur n'a pas validé les informations envoyé via le formulaire. -->
    <script>
        let ToastMessage;

        ToastMessage = `<?= $successMsg ?? $listErrors ?? $messageError ?? ''; ?>`;
        let toast = new Axentix.Toast(ToastMessage, {
            classes: '<?= (isset($successMsg)) ? ' secondary ' : ' red '; ?> dark-2 rounded-2 shadow-2'
        });
        if (ToastMessage) {
            toast.show();
        }


    </script>
<?php $jsToast = ob_get_clean();?>