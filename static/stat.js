function register_events_stats()
{
}

function load_stats()
{
	$table = $("#table-stat");
	$table.bootstrapTable({
		url: 'ajax.php?action=get_stats',
		responseHandler: statResponseHandler,
		cache: true,
		striped: true,
		pagination: false,
		pageSize: 25,
		pageList: [10, 25, 50, 100, 200],
		search: false,
		showColumns: false,
		showRefresh: true,
		showToggle: false,
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
			field: 'item',
			title: 'Item',
			align: 'center',
			valign: 'middle',
			sortable: true
		}, {
			field: 'value',
			title: 'Value',
			align: 'center',
			valign: 'middle',
			sortable: false
		}]
	});
}

function statResponseHandler(res)
{
	var records = [];
	if(res['errno'] == 0){
		var stats = res["stats"];
		$.each(stats, function(item, value){
			var record = { "item": item, "value": value };
			records.push(record);
		});
		return records;
	}
	alert(res['msg']);
	return [];
}
