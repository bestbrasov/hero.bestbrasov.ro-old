<?php
if ($_SESSION['intern-acces'] < 2) {
    include "404.php";
    die();
}
?>

<div class="pageheader">
    <div class="pageicon"><span class="iconfa-cogs"></span></div>
    <div class="pagetitle">
        <h5>Activitate realizată de responsabilii HR și administratori</h5>
        <h1>Log-uri administrative</h1>
    </div>
</div><!--pageheader-->

<div class="maincontent">
    <div class="maincontentinner">
        <h4 class="widgettitle">Log-uri administrative</h4>
        <table class="table responsive">
            <thead>
            <tr>
                <th>ID</th>
                <th>Autor</th>
                <th>Data</th>
                <th>Activitate</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Validare pagină
            $current_page = isset($_GET['pag']) ? (int)$_GET['pag'] : 0;
            $logs = get_logs($current_page);

            if (count($logs) > 0) {
                foreach ($logs as $log) {
                    ?>
                    <tr>
                        <td><?php echo $log['ID']; ?></td>
                        <td><?php echo show_user($log['autor']); ?></td>
                        <td><?php echo return_time($log['timestamp']); ?></td>
                        <td><?php echo html_entity_decode($log['text'],ENT_QUOTES); ?></td></tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='4'>Nu există log-uri disponibile.</td></tr>";
            }
            ?>
            </tbody>
        </table>

        <?php
        if (log_prev_page($current_page)) { ?>
            <a href="dashboard.php?pagina=logs&pag=<?php echo $current_page - 1; ?>" class="btn btn-primary" style="color:white;">Log-uri noi</a>&nbsp;
        <?php } ?>
        <?php
        if (log_next_page($current_page)) { ?>
            <a href="dashboard.php?pagina=logs&pag=<?php echo $current_page + 1; ?>" class="btn btn-primary" style="color:white;">Log-uri vechi</a>
        <?php } ?>
