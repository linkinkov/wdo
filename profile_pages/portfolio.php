<?php
if ( !isset($from_include) )
{
	require_once('../_global.php');
	include_once(PD.'/_includes.php');
	$current_user = new User($_SESSION["user_id"]);
	$user_id = get_var("user_id","int",$current_user->user_id);
	$user = new User($user_id);
	$job = get_var("job","string",false);
	$db = db::getInstance();
	check_access($db,false);
}

if ( $job == "publish" )
{
	$data = get_var("data","array",Array());
	$response = Portfolio::publish($data);
	header('Content-Type: application/json');
	echo json_encode($response);
	exit;
}
elseif ( $job == "delete" )
{
	$portfolio_id = get_var("portfolio_id","int",0);
	$response = Portfolio::delete($portfolio_id);
	header('Content-Type: application/json');
	echo json_encode($response);
	exit;
}
elseif ( $job == "update" )
{
	// $portfolio_id = get_var("portfolio_id","int",0);
	$data = get_var("data","array",Array());
	$response = Portfolio::update($data);
	header('Content-Type: application/json');
	echo json_encode($response);
	exit;
}
elseif ( $job == "update_cover" )
{
	$portfolio_id = get_var("portfolio_id","int",0);
	$attach_id = get_var("attach_id","string","");
	$action = get_var("action","string","delete-cover");
	$response = Portfolio::update_cover($portfolio_id,$action,$attach_id);
	header('Content-Type: application/json');
	echo json_encode($response);
	exit;
}
elseif ( $job == "delete_attach" )
{
	// $portfolio_id = get_var("portfolio_id","int",0);
	// print_r($_GET);
	$attach_id = get_var("attach_id","string","");
	// echo "a_id:".$attach_id;
	$type = get_var("type","string","image");
	$response = Array(
		"result" => Attach::delete($attach_id,$type)
	);
	header('Content-Type: application/json');
	echo json_encode($response);
	exit;
}

$_SESSION["LAST_PAGE"] = "profile/portfolio";

if ( $current_user->user_id == $user->user_id )
{
?>
<div class="row">
	<div class="col">
		<a class="wdo-btn btn-sm yellow-outline" data-toggle="tab" data-target="#portfolio-add" role="tab"><i class="fa fa-plus"></i> Добавить работу</a>
	</div>
</div>
<br />
<?php
}
?>

<div class="row" style="min-height: 1200px;">
	<div class="col" style="overflow-x: hidden;position: relative;">
		<div id="portfolio_single">
			<div class="row">
				<div class="col">
					<span class="pull-left">
						<h4 class="text-purple-dark" id="portfolio-title"></h4>
					</span>
					<?php
					if ( $user->user_id == $current_user->user_id )
					{
					?>
					<span class="pull-right">
						<a id="portfolio-delete-link" class="wdo-link opacity" data-portfolio_id=""><i class="fa fa-trash"></i> Удалить</a>
						<a id="portfolio-edit-link" class="wdo-link opacity" data-portfolio_id="" data-toggle="tab" data-target="#portfolio-edit" role="tab"><i class="fa fa-pencil"></i> Редактировать</a>
					</span>
					<?php
					}
					?>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<a class="wdo-link opacity" onClick="app.portfolio.hide();"><img src="/images/back-arrow.png" /> Вернуться</a>
				</div>
			</div>
			<div class="row"><div class="col"><hr /></div></div>

			<div class="row">
				<div class="col">
					<div class="jumbotron jumbotron-fluid">
						<div class="container" style="max-width: 700px;">
							<p id="portfolio-descr" class="lead" style="white-space: pre-wrap;"></p>
						</div>
					</div>
				</div>
			</div>

			<div class="portfolio-photos-container">
				<div class="row"><div class="col"><hr /></div></div>
				<div class="row">
					<div class="col" style="max-width: 100px;">
						Фото
					</div>
					<div class="col" id="portfolio-photos"></div>
				</div>
			</div>

			<div class="portfolio-videos-container">
				<div class="row"><div class="col"><hr /></div></div>
				<div class="row">
					<div class="col" style="max-width: 100px;">
						Видео
					</div>
					<div class="col" id="portfolio-videos"></div>
				</div>
			</div>

			<div class="portfolio-docs-container">
				<div class="row"><div class="col"><hr /></div></div>
				<div class="row">
					<div class="col" style="max-width: 100px;">
						Документы
					</div>
					<div class="col" id="portfolio-docs"></div>
				</div>
			</div>

		</div>

		<div class="card-columns" id="portfolio_list">
		<!-- Portfolio cards from JSON answer -->
		</div>

	</div>
</div>
<script>
$(function(){
	preselected_pfid = document.preselected_pfid;
	app.portfolio.getList(function(response){
		if ( response.length > 0 )
		{
			$("#portfolio_list").html('');
			$.each(response,function(){
				$("#portfolio_list").append(app.formatter.format_portfolio_preview(this));
			})
			if ( preselected_pfid > 0 )
			{
				console.log("Click on id: ",preselected_pfid);
				$("#portfolio_list").find("[data-toggle='show-portfolio'][data-portfolio_id='"+preselected_pfid+"']").click();
			}
		}
	})
})
</script>
