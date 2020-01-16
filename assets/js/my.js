viewData()
function viewData(){
	$.ajax({
		url:'http://localhost/backend-ci/api/angular',
		method:'GET',
		dataType: "json",
		success:function(d){
			 $.each(d, function(){
			 	var html = `
			 	<tr>
					<td hidden>${this.id}</td>
					<td>${this.first_name}</td>
					<td>${this.last_name}</td>
			 	</tr>`
			    // $('tbody').append(html);
			});
			tableData()
		}
	})
}

function tableData(){
	$('#tabledit').Tabledit({
		url: 'http://localhost/stores/admin/group_produk/cek',
	    eventType:'dblclick',
		editButton: true,
	    deleteButton: true,
	    hideIdentifier: true,
	    columns: {
	        identifier: [0, 'id'],
	        editable: [[1, 'first_name', '{"semut": "semut", "toke": "toke"}'], [2, 'last_name']]
	    }
	})
}