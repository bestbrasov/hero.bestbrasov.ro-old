<?php
if ($_SESSION['intern-acces'] < 2) {
    include "404.php";
    die();
}
?>
<div class="pageheader">
    <div class="pageicon"><span class="iconfa-cogs"></span></div>
    <div class="pagetitle">
        <h5>Aproba participarea la evenimente</h5>
        <h1>Evenimente</h1>
    </div>
</div><!--pageheader-->

<div class="maincontent">
    <div class="maincontentinner">

        <h4 class="widgettitle">Evenimente</h4>
        <table class="table responsive">
            <thead>
            <tr>
                <th>ID</th>
                <th>Utilizator</th>
                <th>Eveniment</th>
                <th>Responsabilitate</th>
                <th>Actiuni</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (isset($_GET['app']) && $_GET['app'] != "") {
                app_event($_GET['app']);
            }

            if (isset($_GET['rem']) && $_GET['rem'] != "") {
                rem_event($_GET['rem']);
            }

            $current_page = isset($_GET['pag']) ? (int)$_GET['pag'] : 0; // Pagina curentă
            $logs = get_eve($current_page); // Obține log-urile pentru pagina curentă
            foreach ($logs as $log) {
                ?>
                <tr>
                    <td><?php echo $log['ID']; ?></td>
                    <td><?php echo show_user($log['IDutilizator']); ?></td>
                    <td><?php echo get_event_data($log['IDproiect'])['nume']; ?></td>
                    <td><?php echo $log['rank']; ?></td>
                    <td><a href="dashboard.php?pagina=appevenimente&app=<?php echo $log['ID']; ?>">Aproba</a> | <a href="dashboard.php?pagina=appevenimente&rem=<?php echo $log['ID']; ?>">Respinge</a></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>

        <?php if (eve_prev_page($current_page)) { ?>
            <a href="dashboard.php?pagina=appevenimente&pag=<?php echo $current_page - 1; ?>" class="btn btn-primary" style="color:white;">Pagina anterioara</a>&nbsp;
        <?php } ?>
        <?php if (eve_next_page($current_page)) { ?>
            <a href="dashboard.php?pagina=appevenimente&pag=<?php echo $current_page + 1; ?>" class="btn btn-primary" style="color:white;">Pagina urmatoare</a>
        <?php } ?>
