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
				//Create text and cell
				let new_text; 
				let new_cell = new_row.insertCell(i);
				//Create text
				if(i === 2) {
					new_cell.innerHTML = '<a class = "link_target_chembl" href="https://www.ebi.ac.uk/chembl/explore/target/' + value[names_arr[i]] + '" target = "_blank">' + value[names_arr[i]] + '</a>';
				} else {
					new_cell.innerHTML = value[names_arr[i]];
				}
			}
		}
	}
}