//Function to sort the results
const sort_targets_desc = async function(values, elem_table_body, names_arr) {
		values = values.sort((a, b) => b.val - a.val);
		await update_table(elem_table_body, values, names_arr);
}
//Function to populate the table, SEE: https://developer.mozilla.org/en-US/docs/Web/API/HTMLTableElement/insertRow
//Table here is the table's body
const update_table = async function (table, values, names_arr) {
	//Clear table
	table.innerHTML = "";
	//Populate table
	for (const value of values) {
		if ( value['val'] > 0 ) {
			let new_row = table.insertRow(-1);
			for (let i = 0; i < names_arr.length; i++) {
				//Create cell
				let new_cell = new_row.insertCell(i);
				//Create text
				let new_text = document.createTextNode(value[names_arr[i]]);
				//Append text
				new_cell.appendChild(new_text);
			}
		}
	}
}