		<div class="container">
			<div class="page-header" style="margin-top:10px;border-bottom:1px solid #ececec;">
				<div class="row">
					<div class="col-lg-12">
						<h4>Disease Statistics (interactive map) <small><a href="#">Switch to disease specific map</a></small></h4>
						<style>
							.data-table{font-size:90%;background:#fff;border:1px solid #efefef;border-radius:4px;box-shadow:1px 1px 8px #efefef;}
							.data-table th{background:#2FA4E7;color:#fff;border:1px solid #efefef;padding:5px;font-weight:bold}
							.data-table td{border:1px solid #efefef;padding:5px;}
						</style>
						<script type="text/javascript"  src="<?php echo scripts_url('map/jquery.min.js');?>"></script>
						<script type="text/javascript"  src="<?php echo scripts_url('map/d3/d3.min.js');?>"></script>
						<script type="text/javascript"  src="<?php echo scripts_url('map/topojson.v1.min.js');?>"></script>
						<link href="<?php echo css_url('map_style.css');?>" media="screen" rel="stylesheet" type="text/css">
						
						<div class="col-lg-12" id="nepalmap" style=";padding:0;">
							<div id="data-table" class="hidden">
								<p><strong id ="heading"></strong><strong><a href="#" id="close">X</a></strong></p>
								<p><span id="data"></span></p>
							</div>
							<script type ="text/javascript" src ="<?php echo scripts_url('map/multi_var_map.js');?>"></script>
						</div>
						
						<script type="text/javascript">
							$(document).ready(function(){
								width = 1100;
								height = 450;
								container = document.getElementById("nepalmap");
								dataUrl = "http://edcd.local/public/data.json";
								multiVariableMap(container,width,height,dataUrl);
								$("#close").on("click",function(e){
									e.preventDefault();
									$("#data-table").addClass("hidden");
								});
							});
						</script>
                    </div>
				</div>
			</div>
			
			<div class="bs-docs-section">
				<?php include_once('includes/sidebar-bottom.php');?>
			</div>