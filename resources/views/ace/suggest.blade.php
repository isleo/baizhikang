<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Bootstrap表格插件 - Bootstrap后台管理系统模版Ace下载</title>
        <meta name="keywords" content="Bootstrap模版,Bootstrap模版下载,Bootstrap教程,Bootstrap中文" />
        <meta name="description" content="站长素材提供Bootstrap模版,Bootstrap教程,Bootstrap中文翻译等相关Bootstrap插件下载" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />


        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />

        <script src="{{asset('assets/js/jquery-2.0.3.min.js')}}"></script>
        <link href="{{asset('/assets/css/bootstrap.min.css')}}" rel="stylesheet" />
        <link rel="stylesheet" href="{{asset('/assets/css/font-awesome.min.css')}}" />
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
        <!--[if IE 7]>
          <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
        <![endif]-->

        <!-- page specific plugin styles -->

        <link rel="stylesheet" href="{{asset('/assets/css/jquery-ui-1.10.3.full.min.css')}}" />
        <link rel="stylesheet" href="{{asset('/assets/css/datepicker.css')}}" />
        <link rel="stylesheet" href="{{asset('/assets/css/ui.jqgrid.css')}}" />

    </head>

    <body>
        <div class="navbar navbar-default" id="navbar">
<script type="text/javascript">
try{ace.settings.check('navbar' , 'fixed')}catch(e){}
</script>

            <div class="navbar-container" id="navbar-container">
                <div class="navbar-header pull-left">
                    <a href="#" class="navbar-brand">
                        <small>
                            <i class="icon-leaf"></i>
                            Ace Admin
                        </small>
                    </a><!-- /.brand -->
                </div><!-- /.navbar-header -->
            </div><!-- /.container -->
        </div>

        <div class="main-container" id="main-container">
<script type="text/javascript">
try{ace.settings.check('main-container' , 'fixed')}catch(e){}
</script>

            <div class="main-container-inner">
                <a class="menu-toggler" id="menu-toggler" href="#">
                    <span class="menu-text"></span>
                </a>

                <div class="sidebar" id="sidebar">
<script type="text/javascript">
try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
</script>

                    <div class="sidebar-shortcuts" id="sidebar-shortcuts">
                        <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                            <button class="btn btn-success">
                                <i class="icon-signal"></i>
                            </button>

                            <button class="btn btn-info">
                                <i class="icon-pencil"></i>
                            </button>

                            <button class="btn btn-warning">
                                <i class="icon-group"></i>
                            </button>

                            <button class="btn btn-danger">
                                <i class="icon-cogs"></i>
                            </button>
                        </div>

                        <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                            <span class="btn btn-success"></span>

                            <span class="btn btn-info"></span>

                            <span class="btn btn-warning"></span>

                            <span class="btn btn-danger"></span>
                        </div>
                    </div><!-- #sidebar-shortcuts -->
                                                                         <ul class="nav nav-list">
                        <li class="active">
                            <a href="{{url('/admin/index')}}">
                                <span class="menu-text">设备信息</span>
                            </a>
                        </li>
                        <li class="active">
                            <a href="{{url('/admin/userInfoIndex')}}">
                                <span class="menu-text">用户信息</span>
                            </a>
                        </li>
                        <li class="active">
                            <a href="{{url('/admin/suggestionIndex')}}">
                                <span class="menu-text">意见信息</span>
                            </a>
                        </li>
                        <li class="active">
                            <a href="{{url('/admin/appIndex')}}">
                                <span class="menu-text">app信息</span>
                            </a>
                        </li>

                    </ul><!-- /.nav-list -->

                    <div class="sidebar-collapse" id="sidebar-collapse">
                        <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
                    </div>

<script type="text/javascript">
try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
</script>
                </div>

                <div class="main-content">
                    <div class="breadcrumbs" id="breadcrumbs">
<script type="text/javascript">
try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
</script>

                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-home home-icon"></i>
                                <a href="#">Home</a>
                            </li>

                            <li>
                                <a href="#">Tables</a>
                            </li>
                            <li class="active">Simple &amp; Dynamic</li>
                        </ul><!-- .breadcrumb -->

                        <div class="nav-search" id="nav-search">
                            <form class="form-search">
                                <span class="input-icon">
                                    <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                                    <i class="icon-search nav-search-icon"></i>
                                </span>
                            </form>
                        </div><!-- #nav-search -->
                    </div>

                    <div class="page-content">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h3 class="header smaller lighter blue">意见信息</h3>
                                        <div class="table-responsive">
                                            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>id</th>
                                                        <th>电话号码</th>
                                                        <th>意见</th>
                                                        <th>创建时间</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data as $value)
                                                    <tr>
                                                        <td class="center">
                                                            {{$value->id}}
                                                        </td>
                                                        <td>
                                                            {{$value->mobile}}
                                                        </td>
                                                        <td>
                                                            {{$value->content}}
                                                        </td>
                                                        <td>
                                                            {{date('Y-m-d H:i:s', $value->createTime)}}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                        <div class='center'>{!!$showPage!!}</div>
                    </div><!-- /.page-content -->
                </div><!-- /.main-content -->

                <div class="ace-settings-container" id="ace-settings-container">
                    <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                        <i class="icon-cog bigger-150"></i>
                    </div>

                    <div class="ace-settings-box" id="ace-settings-box">
                        <div>
                            <div class="pull-left">
                                <select id="skin-colorpicker" class="hide">
                                    <option data-skin="default" value="#438EB9">#438EB9</option>
                                    <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                                    <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                                    <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                                </select>
                            </div>
                            <span>&nbsp; Choose Skin</span>
                        </div>

                        <div>
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
                            <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                        </div>

                        <div>
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
                            <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                        </div>

                        <div>
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
                            <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                        </div>

                        <div>
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
                            <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                        </div>

                        <div>
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
                            <label class="lbl" for="ace-settings-add-container">
                                Inside
                                <b>.container</b>
                            </label>
                        </div>
                    </div>
                </div><!-- /#ace-settings-container -->
            </div><!-- /.main-container-inner -->

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="icon-double-angle-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->
<script type="text/javascript">
window.jQuery || document.write("<script src='"+"{{asset('assets/js/jquery-2.0.3.min.js')}}" + "'>"+"<"+"script>");
</script>

        <!-- <![endif]-->

        <!--[if IE]>
<script type="text/javascript">
window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

<script type="text/javascript">
if("ontouchend" in document) document.write("<script src='"+"{{asset('/assets/js/jquery.mobile.custom.min.js')}}" + "'>"+"<"+"script>");
</script>

        <!-- page specific plugin scripts -->

        <script src="{{asset('/assets/js/date-time/bootstrap-datepicker.min.js')}}"></script>
        <script src="{{asset('/assets/js/assets/js/jqGrid/jquery.jqGrid.min.js')}}"></script>
        <script src="{{asset('/assets/js/jqGrid/i18n/grid.locale-en.js')}}"></script>

        <!-- page specific plugin scripts -->

        <script src="{{asset('/assets/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('/assets/js/jquery.dataTables.bootstrap.js')}}"></script>

        <!-- inline scripts related to this page -->

<script type="text/javascript">
jQuery(function($) {
    var oTable1 = $('#sample-table-2').dataTable( {
        "aoColumns": [
{ "bSortable": false },
null, null,null, null, null,
{ "bSortable": false }
] } );


        $('table th input:checkbox').on('click' , function(){
            var that = this;
            $(this).closest('table').find('tr > td:first-child input:checkbox')
                .each(function(){
                    this.checked = that.checked;
                    $(this).closest('tr').toggleClass('selected');
                    });

                });


                $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
                function tooltip_placement(context, source) {
                    var $source = $(source);
                    var $parent = $source.closest('table')
                        var off1 = $parent.offset();
                    var w1 = $parent.width();

                    var off2 = $source.offset();
                    var w2 = $source.width();

                    if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
                    return 'left';
                }
            })
                </script>
    <div style="display:none"><script src='http://v7.cnzz.com/stat.php?id=155540&web_id=155540' language='JavaScript' charset='gb2312'></script></div>
</body>
</html>
