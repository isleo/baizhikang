<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>控制台 - Bootstrap后台管理系统模版Ace下载</title>
		<meta name="keywords" content="Bootstrap模版,Bootstrap模版下载,Bootstrap教程,Bootstrap中文" />
		<meta name="description" content="站长素材提供Bootstrap模版,Bootstrap教程,Bootstrap中文翻译等相关Bootstrap插件下载" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<!-- basic styles -->
		<script src="{{asset('assets/js/jquery-2.0.3.min.js')}}"></script>
		<link href="{{asset('/assets/css/bootstrap.min.css')}}" rel="stylesheet" />
		<link rel="stylesheet" href="{{asset('/assets/css/font-awesome.min.css')}}" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!-- page specific plugin styles -->

		<!-- fonts -->

		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />

		<!-- ace styles -->

		<link rel="stylesheet" href="{{asset('/assets/css/ace.min.css')}}" />
		<link rel="stylesheet" href="{{asset('/assets/css/ace-rtl.min.css')}}" />
		<link rel="stylesheet" href="{{asset('/assets/css/ace-skins.min.css')}}" />
		<script src="{{asset('/assets/js/ace-extra.min.js')}}"></script>
		<script src="{{asset('/assets/js/bootstrap.min.js')}}"></script>
		<script src="{{asset('/assets/js/typeahead-bs2.min.js')}}"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="assets/js/excanvas.min.js"></script>
		<![endif]-->

		<script src="{{asset('/assets/js/jquery-ui-1.10.3.custom.min.js')}}"></script>
		<script src="{{asset('/assets/js/jquery.ui.touch-punch.min.js')}}"></script>
		<script src="{{asset('/assets/js/jquery.slimscroll.min.js')}}"></script>
		<script src="{{asset('/assets/js/jquery.easy-pie-chart.min.js')}}"></script>
		<script src="{{asset('/assets/js/jquery.sparkline.min.js')}}"></script>
		<script src="{{asset('/assets/js/flot/jquery.flot.min.js')}}"></script>
		<script src="{{asset('/assets/js/flot/jquery.flot.pie.min.js')}}"></script>
		<script src="{{asset('/assets/js/flot/jquery.flot.resize.min.js')}}"></script>

		<!-- ace scripts -->

		<script src="{{asset('/assets/js/ace-elements.min.js')}}"></script>
		<script src="{{asset('/assets/js/ace.min.js')}}"></script>

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="assets/js/html5shiv.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="login-layout">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<!-- <i class="icon-leaf green"></i>
									<span class="red">Ace</span> -->
									<span class="white">管理员后台</span>
								</h1>
								<!-- <h4 class="blue">&copy; Company Name</h4> -->
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="icon-coffee green"></i>
												Please Enter Your Information
											</h4>

											<div class="space-6"></div>

											<form action="{{url('/admin/postLogin')}}">
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input name='username' type="text" class="form-control" placeholder="Username" />
															<i class="icon-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input name='password' type="password" class="form-control" placeholder="Password" />
															<i class="icon-lock"></i>
														</span>
													</label>

													<div class="space"></div>

													<div class="center">
														<!-- <label class="inline">
															<input type="checkbox" class="ace" />
															<span class="lbl"> Remember Me</span>
														</label> -->

														<button type="submit" class="btn btn-lg btn-primary">
															<i class="icon-key"></i>
															Login
														</button>
													</div>

													<div class="space-4"></div>
												</fieldset>
											</form>
							
										</div><!-- /widget-main -->

										<!-- <div class="toolbar clearfix">
											<div>
												<a href="#" onclick="show_box('forgot-box'); return false;" class="forgot-password-link">
													<i class="icon-arrow-left"></i>
													I forgot my password
												</a>
											</div>

											<div>
												<a href="#" onclick="show_box('signup-box'); return false;" class="user-signup-link">
													I want to register
													<i class="icon-arrow-right"></i>
												</a>
											</div>
										</div> -->
									</div><!-- /widget-body -->
								</div><!-- /login-box -->
							</div><!-- /position-relative -->
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->

		<!-- <![endif]-->

		<!--[if IE]>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<![endif]-->
<script type="text/javascript">
			window.jQuery || document.write("<script src='"+"{{asset('assets/js/jquery-2.0.3.min.js')}}" + "'>"+"<"+"script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"script>");
</script>
<![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='"+"{{asset('/assets/js/jquery.mobile.custom.min.js')}}" + "'>"+"<"+"script>");
		</script>

		<!--[if !IE]> -->


		<!-- inline scripts related to this page -->

		<script type="text/javascript">
			function show_box(id) {
			 jQuery('.widget-box.visible').removeClass('visible');
			 jQuery('#'+id).addClass('visible');
			}
		</script>
	<div style="display:none"><script src='http://v7.cnzz.com/stat.php?id=155540&web_id=155540' language='JavaScript' charset='gb2312'></script></div>
</body>
</html>
