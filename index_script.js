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
	// Check minimally, i.e. is it possible to parse structure using RDKit.JS (?)
	try {
		const mol = RDKit.get_mol(input_cs);
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
	console.log(result);
	result['picture'] = pic;
	//Open new tab and bring the data there
	const representation_tab = window.open("https://way2drug.com/antibac/antibac/represent.php", '_blank');
	if (representation_tab) {
    representation_tab.data = result;
	}
}
////////////////////////////////////////////////////////////////////////////////////////////////
// Populate table with the results
////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////
//Elements
///////////////////////////////////////////////////////////////////////////////////////////////
const btn_close_about = document.querySelector("#btn_close_about");
const btn_close_interp = document.querySelector("#btn_close_interp");
const btn_close_contact = document.querySelector("#btn_close_contact");
const btn_close_draw = document.querySelector("#btn_close_draw");
const btn_predict = document.querySelector("#predict_btn");
const btn_open_draw = document.querySelector("#open_draw_btn");
const main_input = document.querySelector("#main_input");
//Elements & events
btn_close_about.addEventListener("click", close_dlg, false);
btn_close_interp.addEventListener("click", close_dlg, false);
btn_close_contact.addEventListener("click", close_dlg, false);
btn_close_draw.addEventListener("click", close_dlg, false);
btn_open_draw.addEventListener("click", open_draw, false);
btn_predict.addEventListener("click", send_cs, false);