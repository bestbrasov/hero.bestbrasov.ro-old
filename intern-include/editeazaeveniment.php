<?php
if($_SESSION['intern-acces'] == 1 || !check_event_exists($_GET['id']))
{
	include "404.php";
	die();
}
$data = get_event_data($_GET['id']);
?>       <div class="pageheader">
            <div class="pageicon"><span class="iconfa-comments"></span></div>
            <div class="pagetitle">
                <h5>Editeaza un eveniment existent</h5>
                <h1>Editeaza evenimentul</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
			<?php
			if(isset($_POST['submit']) && $_POST['submit']=="y")
			{
				echo edit_event($_POST['csrf'],$_POST['nume'],$_POST['descriere'],$_POST['datai'],$_POST['dataf'],$_GET['id']);
				$data = get_event_data($_GET['id']);
			}
			?>
                <h4 class="widgettitle">Editeaza evenimentul</h4>
                <div class="widgetcontent nopadding">
                    <form class="stdform stdform2" method="post">
						    <p>
                                <label>Numele evenimentului</label>
                                <span class="field">
                                     <input type="text" class="form-control input-default" name="nume" value="<?php echo $data['nume']; ?>">
                                </span>
                            </p>
						    <p>
                                <label>Descrierea evenimentului</label>
                                <span class="field">
                                     <textarea class="form-control input-default" name="descriere"><?php echo $data['descriere']; ?></textarea>
                                </span>
                            </p>							
						    <p>
                                <label>Data de inceput</label>
                                <span class="field"><script type="text/javascript">jQuery(document).ready(function(){jQuery("#dp").datepicker({ dateFormat: 'yy-mm-dd' });});</script>
                                     <input type="text" class="form-control input-default" name="datai" placeholder="AAAA-LL-ZZ" id="dp" value="<?php echo $data['datai']; ?>">
                                </span>
                            </p>
						    <p>
                                <label>Data de final</label>
                                <span class="field"><script type="text/javascript">jQuery(document).ready(function(){jQuery("#dp2").datepicker({ dateFormat: 'yy-mm-dd' });});</script>
                                     <input type="text" class="form-control input-default" name="dataf" placeholder="AAAA-LL-ZZ" id="dp2" value="<?php echo $data['dataf']; ?>">
                                </span>
                            </p>							
                            <p class="stdformbutton">
                                <input type="hidden" name="csrf" value="<?php echo $_SESSION['intern-csrf']; ?>"><input type="hidden" name="submit" value="y"><button class="btn btn-primary">Editeaza</button>
                            </p>
                    </form>
                </div>
				
			<div class="row">
				<div id="dashboard-left" class="col-md-6">
				<?php
				if(isset($_POST['submit2']) && $_POST['submit2']=="y")
				{
					echo add_pax_event($_POST['csrf'],$_POST['utilizator'],$_GET['id'],$_POST['rank']);
				}
				?>
                <h4 class="widgettitle">Adauga participanti la eveniment</h4>
                <div class="widgetcontent nopadding">
                    <form class="stdform stdform2" method="post">
			    <p>
                                <label>Utilizator</label>
                                <span class="field">
                                     <select name="utilizator" style="width:100%;">
					<option value=""></option>
					<option style="font-weight:bold;" value="">MEMBRI BABY</option>
<?php
$users = get_users_list(0);
foreach($users as $user)
{
	if($user['ID'] == $_GET['utilizator'])
		echo '<option value="'.$user['ID'].'" SELECTED>'.$user['nume'].'</option>';
	else
		echo '<option value="'.$user['ID'].'">'.$user['nume'].'</option>';
}
 ?>

					<option value=""></option>
					<option style="font-weight:bold;" value="">MEMBRI ACTIVI</option>
<?php
$users = get_users_list(2);
foreach($users as $user)
{
	if($user['ID'] == $_GET['utilizator'])
		echo '<option value="'.$user['ID'].'" SELECTED>'.$user['nume'].'</option>';
	else
		echo '<option value="'.$user['ID'].'">'.$user['nume'].'</option>';
}
 ?>

					<option value=""></option>
					<option style="font-weight:bold;" value="">MEMBRI CU DREPT DE VOT</option>
<?php
$users = get_users_list(4);
foreach($users as $user)
{
	if($user['ID'] == $_GET['utilizator'])
		echo '<option value="'.$user['ID'].'" SELECTED>'.$user['nume'].'</option>';
	else
		echo '<option value="'.$user['ID'].'">'.$user['nume'].'</option>';
}
 ?>

					<option value=""></option>
					<option style="font-weight:bold;" value="">MEMBRI ALUMNI</option>
<?php
$users = get_users_list(5);
foreach($users as $user)
{
	if($user['ID'] == $_GET['utilizator'])
		echo '<option value="'.$user['ID'].'" SELECTED>'.$user['nume'].'</option>';
	else
		echo '<option value="'.$user['ID'].'">'.$user['nume'].'</option>';
}
 ?>


					<option value=""></option>
					<option style="font-weight:bold;" value="">MEMBRI FORMER</option>
<?php
$users = get_users_list(3);
foreach($users as $user)
{
	if($user['ID'] == $_GET['utilizator'])
		echo '<option value="'.$user['ID'].'" SELECTED>'.$user['nume'].'</option>';
	else
		echo '<option value="'.$user['ID'].'">'.$user['nume'].'</option>';
}
 ?>


					<option value=""></option>
					<option style="font-weight:bold;" value="">MEMBRI EXCLUSI</option>
<?php
$users = get_users_list(1);
foreach($users as $user)
{
	if($user['ID'] == $_GET['utilizator'])
		echo '<option value="'.$user['ID'].'" SELECTED>'.$user['nume'].'</option>';
	else
		echo '<option value="'.$user['ID'].'">'.$user['nume'].'</option>';
}
 ?>
</select>
                                </span>
                            </p>
                            <p>
                                <label>Responsabilitate</label>
                                <span class="field">
                                    <input class="form-control input-lg" type="text" name="rank">
                                </span>
                            </p>
                            <p class="stdformbutton">
                                <input type="hidden" name="csrf" value="<?php echo $_SESSION['intern-csrf']; ?>"><input type="hidden" name="submit2" value="y"><button class="btn btn-primary">Adauga</button>
                            </p>
                    </form>
                </div>
			</div>
			<div id="dashboard-left" class="col-md-6">
			<?php
			if(isset($_GET['del']) && $_GET['del']!="")
			{
				del_pax_from_event($_GET['del']);
			}
			?>
			    <h4 class="widgettitle">Participanti la eveniment</h4>
                <div class="widgetcontent">
					<?php echo get_pax_from_event($_GET['id']); ?>
				</div>
			</div>
		</div>
