function register_events_queue()
{
	$('#btn-queue-add').click(function(e){
		$("#form-queue-seed").val("");
		$('#modal-queue').modal('show');
	});

	$("#form-queue-submit").click(function(e){
		$("#form-queue-submit").attr("disabled", "disabled");
		var seed = $("#form-queue-seed").val();
		var ajax = $.ajax({
			url: "ajax.php?action=add_seed",
			type: 'POST',
			data: {
				seed: seed
			}
		});
		ajax.done(function(json){
			var res = JSON.parse(json);
			if(res["errno"] == 0){
				$('#modal-queue').modal('hide');
				$('#table-queue').bootstrapTable("refresh");
			}else{
				$("#form-queue-msg").html(res["msg"]);
				$("#modal-queue").effect("shake");
			}
			$("#form-queue-submit").removeAttr("disabled");
		});
		ajax.fail(function(jqXHR,textStatus){
			alert("Request failed :" + textStatus);
			$("#form-queue-submit").removeAttr("disabled");
		});
	});
}

function load_queue()
{
	$table = $("#table-queue");
	$table.bootstrapTable({
		url: 'ajax.php?action=get_queue',
		responseHandler: queueResponseHandler,
		cache: true,
		sidePagination: 'server',
		striped: true,
		pagination: true,
		pageSize: 15,
		pageList: [10, 25, 50, 100, 200],
		search: false,
		showColumns: false,
		showRefresh: true,
		showToggle: true,
		showPaginationSwitch: false,
		minimumCountColumns: 2,
		clickToSelect: false,
		sortName: 'nobody',
		sortOrder: 'desc',
		smartDisplay: true,
		mobileResponsive: true,
		showExport: false,
		columns: [{
			field: 'selected',
			title: 'Select',
			checkbox: true
		}, {
			field: 'url',
			title: 'Url',
			align: 'center',
			valign: 'middle',
			sortable: false
		}, {
			field: 'time',
			title: 'Add Time',
			align: 'center',
			valign: 'middle',
			sortable: false,
			formatter: timeFormatter
		}]
	});
}

function queueResponseHandler(res)
{
	var result = {};
	var records = [];
	if(res['errno'] == 0){
		var members = res["members"];
		$.each(members, function(key ,value){
			var record = { "url": key, "time": value };
			records.push(record);
		});
		result['total'] = res['total'];
		result['rows'] = records;
		return result;
	}
	alert(res['msg']);
	return [];
}
