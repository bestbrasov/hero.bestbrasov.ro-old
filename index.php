<?php
/* 
Name:		HeRo - index
Description:	Pagina de login pentru platforma de HR
Author:		dragos.gaftoneanu@gmail.com
Dev:        Departamentul IT (vlad.paunescu.96@gmai.com / viperamov20@gmail.com)
*/

include "intern-core/config.php"; // fisier principal de configurari si functii
include "intern-core/google/settings.php"; // fisier pentru folosirea Google Auth

/* Daca persoana este deja conectata pe platforma, o redirectionam spre panou */
session_start(); // Asigură-te că sesiunile sunt pornite

if (isset($_SESSION['intern-name']) && $_SESSION['intern-name'] != "") {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>HeRo - Panou Intern BEST Brasov</title>

    <link rel="stylesheet" href="intern-design/css/style.default.css" type="text/css" />
    <link rel="stylesheet" href="intern-design/css/login.css" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="intern-design/js/jquery-1.10.2.min.js"></script>
    <script src="intern-design/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="intern-design/js/jquery-ui-1.10.3.min.js"></script>
    <script src="intern-design/js/modernizr.min.js"></script>
    <script src="intern-design/js/jquery.cookies.js"></script>
    <script src="intern-design/js/custom.js"></script>
</head>

<body class="loginpage">

<div class="loginpanel">
    <div class="loginpanelinner">
        <div class="logo">
            <span class="title">HeRo</span><br />
            <span class="subtitle">Panou Intern BEST Brasov</span>
        </div>
        <div style="padding-top:50px; text-align: center;">
            <a class="login" href="<?php echo 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online'; ?>" style="color:white;font-size:25px;font-weight:bold;">
                Conectare prin Google
            </a>
        </div>
        <?php if (isset($_GET['page']) && $_GET['page'] == "error"): ?>
            <br /><br />
            <div style="text-align: center;">
                <span class="error-message">EROARE<br />Contul nu este autorizat să acceseze platforma.</span>
            </div>
        <?php endif; ?>
    </div><!--loginpanelinner-->
</div><!--loginpanel-->

<div class="loginfooter">
    <p>Copyright &copy; 2017-<?php echo date("Y"); ?> <a href="https://hero.bestbrasov.ro">HeRo</a> - versiunea <?php echo htmlspecialchars($ver, ENT_QUOTES, 'UTF-8'); ?><br />
        <span>Creat cu &#10084; de <a href="mailto:bestbvit@gmail.com">Departamentul de IT</a></span>
    </p>
</div>

</body>
</html>
