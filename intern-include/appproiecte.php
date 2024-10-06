<?php
if ($_SESSION['intern-acces'] < 2) {
    include "404.php";
    die();
}
?>
<div class="pageheader">
    <div class="pageicon"><span class="iconfa-cogs"></span></div>
    <div class="pagetitle">
        <h5>Aproba participarea la proiecte</h5>
        <h1>Proiecte</h1>
    </div>
</div><!--pageheader-->

<div class="maincontent">
    <div class="maincontentinner">

        <h4 class="widgettitle">Proiecte</h4>
        <table class="table responsive">
            <thead>
            <tr>
                <th>ID</th>
                <th>Utilizator</th>
                <th>Proiect</th>
                <th>Responsabilitate</th>
                <th>Actiuni</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Aprobat sau respins un proiect
            if (isset($_GET['app']) && $_GET['app'] != "") {
                app_project($_GET['app']);
            }

            if (isset($_GET['rem']) && $_GET['rem'] != "") {
                rem_project($_GET['rem']);
            }

            // Pagina curentă
            $current_page = isset($_GET['pag']) ? (int)$_GET['pag'] : 0;
            $logs = get_pro($current_page); // Obține log-urile pentru pagina curentă
            foreach ($logs as $log) {
                ?>
                <tr>
                    <td><?php echo $log['ID']; ?></td>
                    <td><?php echo show_user($log['IDutilizator']); ?></td>
                    <td><?php echo get_project_data($log['IDproiect'])['nume']; ?></td>
                    <td><?php echo $log['rank']; ?></td>
                    <td><a href="dashboard.php?pagina=appproiecte&app=<?php echo $log['ID']; ?>">Aproba</a> | <a href="dashboard.php?pagina=appproiecte&rem=<?php echo $log['ID']; ?>">Respinge</a></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>

        <?php if (pro_prev_page($current_page)) { ?>
            <a href="dashboard.php?pagina=appproiecte&pag=<?php echo $current_page - 1; ?>" class="btn btn-primary" style="color:white;">Pagina anterioara</a>&nbsp;
        <?php } ?>
        <?php if (pro_next_page($current_page)) { ?>
            <a href="dashboard.php?pagina=appproiecte&pag=<?php echo $current_page + 1; ?>" class="btn btn-primary" style="color:white;">Pagina urmatoare</a>
        <?php } ?>
