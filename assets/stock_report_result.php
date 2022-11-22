<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Stock Report | Result</title>
	<!-- Global stylesheets -->
	<?php $this->load->view('backend/common/css-js'); ?>
	<style>
		.panel-heading{
			border-bottom-color: #ddd;
		}
        tfoot {
            background: lightcyan;
        }
	</style>
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/assets/lightbox/css/lightbox.css">
</head>

<body class="navbar-top">
	<!-- Main navbar -->
	<?php $this->load->view('backend/common/header'); ?>
	<!-- /main navbar -->
	<!-- Page container -->
	<div class="page-container">
		<!-- Page content -->
		<div class="page-content">
			<!-- Main sidebar -->
			<?php $this->load->view('backend/common/sidebar'); ?>
			<!-- /main sidebar -->
			<!-- Main content -->
			<div class="content-wrapper">
				<div class="page-header">
					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="<?php echo base_url();?>backend/Dashboard"><i class="icon-home2 position-left"></i> Dashboard</a></li>
							<li>Inventory Report</li>
							<li><a href="<?php echo base_url();?>backend/Stock_Report"> Stock Report</a></li>
							<li class="active">Stock Report Result</li>
						</ul>
					</div>
				</div>
				<?php
					$summary = $postdata['stock_summary'];
					$image = ((isset($postdata['stock_images']) && $postdata['stock_images'] == "on") ? '1' : '0');
					if($this->session->userdata('cid') == 32)
					{
						// pre($postdata);
					}
					$form_attributes = array('id' => 'stock_report_form', 'name' => 'stock_report_form');
					
					echo form_open_multipart(base_url().'backend/Stock_Report/generate_pdf_excel/',$form_attributes); 

					echo form_hidden('send_total',''); //For send PDF/ Excel time send total value

					echo form_hidden('send_caption',''); //For send PDF/ Excel time send total value

					echo form_hidden('pdf_type','');
					echo form_hidden('stock_summary',$summary);
					echo form_hidden('stock_images',$image);

					echo form_hidden('post_data', serialize($postdata));

					echo form_hidden('report_type','stock_report');
				?>
				<!-- Content area -->
				<div class="content">
					<div class="panel panel-flat border-top-primary-800">
						<div class="panel-heading">
							<h6 class="panel-title"><i class="icon-cog3 position-left"></i> Stock Report <?php echo (($summary == 1) ? 'Summary' : 'Details');?></h6>
							<a class="heading-elements-toggle"><i class="icon-menu"></i></a>
							<div class="heading-elements panel-tabs">
								<ul class="nav nav-tabs nav-tabs-bottom">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="padding-top: 10px;padding-bottom: 10px;">
											<i class="icon-cog5"></i>
											Tools
											<span class="visible-xs-inline-block position-right">Dropdown</span>
											<span class="caret"></span>
										</a>
										<ul class="dropdown-menu dropdown-menu-right">
											<li><a onclick="send_type('pdf');"><i class="icon-file-pdf"></i> PDF </a></li>
											<li><a onclick="send_type('excel');"><i class="icon-file-excel"></i> Excel </a></li>
											<li><a onclick="send_type1('with_img');"><i class="icon icon-upload"></i> With Image </a></li>
										</ul>
									</li>
								</ul>
		                	</div>
						</div>
						<table class="table table-condensed table-bordered dataTable" id="datatable-result">
							<thead>
								<?php
									echo $this->jfv4_stock_report->generate_header_row('stock_report',$summary,$image);
								?>
							</thead>
							<tfoot>
								<?php
									echo $this->jfv4_stock_report->generate_footer_row('stock_report',$summary,$image);
								?>
							</tfoot>
							<tbody>
								<?php
									if($this->session->userdata('cCode') == 'TGC')
									{
										echo $this->jfv4_stock_report->generate_data_rows('stock_report',$postdata['stock_date'],$postdata['stock_location'],$postdata['show_categories'],(isset($postdata['worker']) ? $postdata['worker'] : []),(isset($postdata['vendor']) ? $postdata['vendor'] : []),$postdata['gross_wt_from'],$postdata['gross_wt_to'],$postdata['net_wt_from'],$postdata['net_wt_to'],$postdata['pieces_from'],$postdata['pieces_to'],(isset($postdata['size']) && !empty($postdata['size']) && is_array($postdata['size']) ? implode(',',$postdata['size']) : ''),$summary,$image,$pdf_type='',$postdata['inventory_status'], (isset($postdata['box_master_id']) ? $postdata['box_master_id'] : []));
									}
									else
									{
										echo $this->jfv4_stock_report->generate_data_rows('stock_report',$postdata['stock_date'],$postdata['stock_location'],$postdata['show_categories'],(isset($postdata['worker']) ? $postdata['worker'] : []),(isset($postdata['vendor']) ? $postdata['vendor'] : []),$postdata['gross_wt_from'],$postdata['gross_wt_to'],$postdata['net_wt_from'],$postdata['net_wt_to'],$postdata['pieces_from'],$postdata['pieces_to'],(isset($postdata['size']) && !empty($postdata['size']) && is_array($postdata['size']) ? implode(',',$postdata['size']) : ''),$summary,$image,$pdf_type='',$postdata['inventory_status']);
									}
									
								?>
							</tbody>
						</table>
					</div>

					
				</div>
				<?php form_close(); ?>
				<!-- /content area -->
<!-- Footer -->
					<?php $this->load->view('backend/common/footer'); ?>
					<!-- /footer -->
			</div>
			<!-- /main content -->
			


		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

</body>
<!-- Theme JS files for modal dialog box-->
<script type="text/javascript" src="<?php echo base_url(); ?>public/assets/js/plugins/notifications/bootbox.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/assets/js/plugins/notifications/sweet_alert.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/assets/js/pages/components_modals.js"></script>
<!-- /theme JS files -->
<script type="text/javascript" src="<?php echo base_url(); ?>public/assets/js/plugins/tables/datatables/datatables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/assets/js/plugins/tables/datatables/extensions/fixed_header.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/assets/js/plugins/tables/datatables/extensions/select.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/assets/js/plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/assets/js/pages/datatables_init.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>public/assets/lightbox/js/lightbox.js"></script>

<?php echo $this->jfv4_form->get_global_additional_scriptimports(); ?> 

<script type="text/javascript" src="<?php echo base_url(); ?>public/assets/js/core/app.js"></script>
<script>
<?php echo $this->jfv4_form->get_global_additional_JS(); ?>  	  
<?php echo $this->jfv4_form->form_validatation_handling(); ?>
</script>
<script type="text/javascript">
$(document).ready(function (){
	TotalCals();
	//to hide flashdata message after 3 seconds
	$('.alert').fadeOut(3000);

	// $('#excel_export').click(function(){
	// 	$("input[name^=pdf_type]").val('excel');
	// 	$.ajax({
	// 		type:"POST",
	// 		data:$('#stock_report_form').serialize(),
	// 		url:"<?php //echo base_url(); ?>backend/Stock_Report/generate_pdf_excel",
	// 		success:function(result)
	// 		{
	// 			// alert(result);
	// 			var excel = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(result));
	// 			return (excel);
	// 		}
	// 	});
	// });

	 $.extend( $.fn.dataTable.defaults, {
        lengthMenu: [ 25, 50, 75, 100, -1 ],
        autoWidth: false,
		
        columnDefs: [{ 
            orderable: false,
            targets: [ 5 ]
        }],
		  
        dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
        language: {
            search: '<span>Search:</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        },
        drawCallback: function () {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
        },
        preDrawCallback: function() {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
        }
    });

	//  $('#example').dataTable({
	//     paging: false
	// });

	// $('#datatable-result').DataTable({
	// 	scrollX: true,
	// 	scrollY: true,
	// 	bSort: false,
	// });

	var dtable = $('#datatable-result').dataTable({
	    	lengthMenu : [[ 25, 50, 75, 100, -1],[ 25, 50, 75, 100, "All" ]],
	    	iDisplayLength : -1,
			paging : false,
	        stateSave : true,
	        bSortCellsTop : true,
	        processing : true,
	        bInfo : false,
	        bPaginate : false,
        	bFilter : true,
        	bSort : false,
	        drawCallback : function( settings ) {
		        $(".styled, .multiselect-container input").uniform({
			        radioClass: 'choice'
			    });
		    },
	        columnDefs : [],
			fixedColumns:{
				leftColumns: 2
			},
	        order: [[3, 'asc']],
	        buttons: {}
	    });
	});

function TotalCals()
{
	//Declare array to store total value
	var total_value_store = [];
	//Declare array to store caption value
	var caption_value_store = [];
	var totals = [];
	var number_format = [];

	$("#datatable-result > tfoot > tr:last > td.totalcol").each(function(i)
	{
		totals[i] = 0;
	});

	var dataRows = $("#datatable-result >tbody > tr:not('.totalColumn, .titlerow, .cat_title')");
	// console.log(dataRows);
	
	dataRows.each(function() 
	{
		$(this).find('.showtotal').each(function(i)
		{
			var res = $(this).attr('class').split(' ');
			number_format[i] = res[1];

			// if(i == 0)
			// {
			// 	alert($(this).html());
			// }
			// console.log($(this).html());
			if($.isNumeric($(this).html()))
			{
				totals[i] += parseFloat($(this).html());
				// if(i == 0)
				// {
				// 	alert($(this).html());
				// }
				// console.log("Index = "+i+" Value = "+$(this).html());
			}
			else
			{
				totals[i] += 0;
			}
		});
	});

	// console.log(totals);
	// console.log(number_format);

	// $("#datatable-result tr:last td.totalCol").each(function(i)
	$("#datatable-result > tfoot > tr:last > td.totalcol").each(function(i)
	{
		<?php if(isset($show_zero_values) && $show_zero_values == 'Yes'){?>
			$(this).html(totals[i].toFixed(number_format[i]));
		<?php } else { ?>
			$(this).html((totals[i] != 0) ? totals[i].toFixed(number_format[i]) : '');
		<?php } ?>
	});	

	//Send Last Tr Total Value

	$("#datatable-result > tfoot > tr:last > td").each(function(i)
	{
		total_value_store[i] = $(this).text() >= 0 ? $(this).text() : "@@";
		// console.log($(this).text());
	});

	//Send First Tr Caption Value
	$("#datatable-result > thead > tr:first-child > th").each(function(j)
	{
		caption_value_store[j] = $(this).text();
	});

	// In case of voucher dont consider last column of action
	// if($("input[name^=stock_report_logic]").val()!=1)
	// {
	// 	total_value_store.pop();
	// 	caption_value_store.pop();
	// }
	
	$("input[name^=send_total]").val(total_value_store.join());
	$("input[name^=send_caption]").val(caption_value_store.join());
}

function send_type(type) 
{
	$("input[name^=pdf_type]").val(type);


	if(type == "excel" || type == "excel_summary")
	{
		
		$("#stock_report_form").attr('target', '_self');
	}
	else if(type == "with_img")
	{
		
		$("#stock_report_form").attr('target', '_self');
	}
	else
	{
		
		$("#stock_report_form").attr('target', '_blank');
	}
	$("#stock_report_form").submit();
}


function send_type1(type) 
{
	$("input[name^=pdf_type]").val(type);
	if(type == "with_img")
	{
		
		$("#stock_report_form").attr('target', '_self');
	}
	
	$("#stock_report_form").submit();
}

function downloadAsExcel()
{
	// window.open('data:application/vnd.ms-excel,' + $('#datatable-result').html());
	// e.preventDefault();
	var url = "<table border = '1'>";
	var j = 0;
	var i = 0;
	tab = document.getElementById('datatable-result');
	
	for(j = 0 ; j < tab.rows.length; j++) 
	{
		url = url + "<tr>";
		for(i = 0 ; i < tab.rows[j].cells.length; i++) 
		{
			url = url + "<td>" + tab.rows[j].cells[i].innerHTML+"</td>";
		}
		url = url + "</tr>";
	}
	url = url + "</table>";
	// alert(url);
	var excel = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(url));
	return (excel);
}

</script>

<?php $this->load->view('backend/common/datatable-uniform'); ?>
</html>