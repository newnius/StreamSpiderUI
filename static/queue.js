function register_events_queue()
{
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
		console.log(result);
		return result;
	}
	alert(res['msg']);
	return [];
}
