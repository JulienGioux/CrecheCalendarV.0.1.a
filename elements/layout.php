<?php
//inclus mes controlers dans la mémoire tampon si besoin
echo $controller ?? '';
require '../elements/header.php';
?>
<body class="layout with-sidenav">
<?php
//inclus la bar de nav suppérieur et celle sur le côté si besoin  à partir de la mémoire tampon
echo $Nav ?? '';
?>

<!--inclus le contenu de ma page à partir de la mémoire tampon-->
<?= $pageContent ?? '';?>

<?php
require '../elements/footer.php';
/*inclus mes scripts js si besoin à partir de la mémoire tampon*/
echo $jsToast ?? '' ;
echo $jsValidateFormInput ?? '';
?>

</body>
</html>