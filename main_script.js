////////////////////////////////////////////////////////////////////////////////////////////////
// Interface Functions
////////////////////////////////////////////////////////////////////////////////////////////////
function open_about() {
	const dlg = document.querySelector("#about_dlg");
	dlg.showModal();
	dlg.className = "dlg_on";
}
function open_interp() {
	const dlg = document.querySelector("#interp_dlg");
	dlg.showModal();
	dlg.className = "dlg_on";
}
function open_contact() {
	const dlg = document.querySelector("#contact_dlg");
	dlg.showModal();
	dlg.className = "dlg_on";
}
function open_draw() {
	const dlg = document.querySelector("#draw_dlg");
	dlg.showModal();
	dlg.className = "dlg_on";
}
function close_dlg() {
	const dlg = document.querySelector(".dlg_on"); 
	dlg.showModal();
	dlg.close();
	dlg.className = "dlg_off";
}
////////////////////////////////////////////////////////////////////////////////////////////////
// Send chemical structure
////////////////////////////////////////////////////////////////////////////////////////////////
async function send_cs() {
	let pic, molfile;
	// Get the input
	let input_cs = main_input.value.trim();
	input_cs = input_cs.replaceAll("\r\n", "\n");
	input_cs = input_cs.replaceAll("\n", "\r\n");
	if (input_cs.length < 1) {
		window.alert("Empty input");
		return;
	}
	mol_test = input_cs;
	// Check minimally, i.e. is it possible to parse structure using RDKit.JS (?)
	try {
		let mol;
		// Check if it is MOL or SMILES
		const n_lines = input_cs.split(/\r\n/).length
		if (n_lines < 2) {
			// SMILES
			mol = RDKit.get_mol(input_cs);
		} else {
			// MOL -> check where the counts line start
			// Get the substring from start to V2000
			const initial_substr = input_cs.substring(0,input_cs.indexOf("V2000\r\n"));
			// Count number of lines before the counts line
			const preline_count = (initial_substr.match(/\r\n/g) || []).length;
			// Act according to the results
			if (preline_count > 3) {
				window.alert("Something is wrong with the input");
				return;
			}
			if (preline_count === 3) {
				input_cs = input_cs.replace(/.*\r\n/, "\r\n");
			}
			if (preline_count == 2) {
				input_cs = "\r\n" + input_cs;
			}
			if (preline_count === 1) {
				input_cs = "\r\n" + "\r\n" + input_cs;
			}
			if (preline_count === 0) {
				input_cs = "\r\n" + "\r\n" + "\r\n" + input_cs;
			}
			mol = RDKit.get_mol(input_cs);
		}
		pic = mol.get_svg();
		molfile = mol.get_molblock();
	} catch {
		window.alert("Something is wrong with the input");
		return;
	}
	//Gather data to JSON
	data_toServer = {"molfile": molfile};
	//Send to the srever
	let response = await fetch('process.php', {
		method: 'POST',
		headers: {'Content-Type': 'application/json;charset=utf-8'},
 		body: JSON.stringify(data_toServer)
	});
	const result = await response.json();
	if (result === "no_result") {
		window.alert("Please, check the input structure (see About) or try again latter");
		return;
	}
	result['picture'] = pic;
	//Open new tab and bring the data there
	const representation_tab = window.open("https://way2drug.com/antibac/represent.php", '_blank');
	if (representation_tab) {
    representation_tab.data = result;
	}
	//Clear form
	main_input.value = "";
}
// SEE: https://stackoverflow.com/questions/15547198/export-html-table-to-csv-using-vanilla-javascript
function download_tab() {
	// Prepare some vars
	const tab = [];
	const rows = document.querySelectorAll('table#' + 'table_data' + ' tr');
	// Prepare the data
	for (let i = 0; i < rows.length; i++) {
        const row = [], cols = rows[i].querySelectorAll('td, th');
        for (let j = 0; j < cols.length; j++) {
        	let current_cell = cols[j].innerText.trim();
        	row.push(current_cell + '\t');
        }
    const row_str = row.join('');
    tab.push(row_str + '\r\n');
    }
    const tab_str = tab.join('').trim();
    // Prepare the file and download it
    const filename = 'antibac_' + 'predictions' + '.tsv';
    const link = document.createElement('a');
    link.style.display = 'none';
    link.setAttribute('target', '_blank');
    link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(tab_str));
    link.setAttribute('download', filename);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
///////////////////////////////////////////////////////////////////////////////////////////////
//Elements
///////////////////////////////////////////////////////////////////////////////////////////////
const btn_close_about = document.querySelector("#btn_close_about");
const btn_close_interp = document.querySelector("#btn_close_interp");
const btn_close_contact = document.querySelector("#btn_close_contact");
const btn_close_draw = document.querySelector("#btn_close_draw");
const btn_predict = document.querySelector("#predict_btn");
const btn_download = document.querySelector("#dwnld_btn");
const btn_open_draw = document.querySelector("#open_draw_btn");
const main_input = document.querySelector("#main_input");
//Elements & events
btn_close_about?.addEventListener("click", close_dlg, false);
btn_close_interp?.addEventListener("click", close_dlg, false);
btn_close_contact?.addEventListener("click", close_dlg, false);
btn_close_draw?.addEventListener("click", close_dlg, false);
btn_open_draw?.addEventListener("click", open_draw, false);
btn_predict?.addEventListener("click", send_cs, false);
btn_download?.addEventListener("click", download_tab, false);