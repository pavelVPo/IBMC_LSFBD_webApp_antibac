<!DOCTYPE html>
<html>
<head>
	<title>Probable bacterial targets</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<!-- outer CSS and JS -->
	<link href="css/index_style.css" type="text/css" rel="stylesheet" />
	<script type="text/javascript" src="js/table.js"></script>
</head>


<body>
<div class="wrapper">

	<nav class="menu">
		<div class="download_btn"><div class="spacer" id="spacer_1"></div><div class="spacer" id="spacer_1"></div><button id="dwnld_btn" autofocus>Download</button></div>
		<ul>
			<!-- SEE:
			https://developer.mozilla.org/en-US/docs/Web/URI/Reference/Schemes/javascript
			https://developer.mozilla.org/ru/docs/Web/HTML/Reference/Elements/dialog -->
			<li class="navli_right"><a id="open_contact" href="javascript:open_contact()">Contact</a></li>
			<li class="navli_right"><a id="open_interp" href="javascript:open_interp()">Interpretation</a></li>
			<li class="navli_right"><a id="open_about" href="javascript:open_about()">About</a></li>
		</ul>
	</nav>

	<main>
		<div class="container" id="main_container_result">
			<div class="spacer" id="spacer_1"> <p></p> </div>
			<div id="container_appicability">
				<h4 id="applicability"></h4>
			</div>
			<div class="spacer" id="spacer_rslt_1"> <p></p> </div>
			<div id="container_svg">
			</div> 
			<!-- table with the results -->
			<div id="container_table" style="height: 50vh; overflow-y: scroll;">
			<table id="table_data" class="display wrap" style="width:100%">
				<thead>
         			<tr>
           			<th>Name</th>
            		<th>Score</th>
            		<th>ChEMBL ID</th>
          			</tr>
        		</thead>
        		<tbody id="table_data_body">
        		</tbody>
			</table>
			</div>
			<div id="container_download">
			</div>
			<div class="spacer" id="spacer_rslt_btm"> <p></p> </div>	
		</div>
	</main>

	<footer>
		<p class="text" id="footer_txt">Way2Drug &#169 2011 - <script type="text/javascript">document.write(new Date().getFullYear());</script> | 
			<a href="http://way2drug.com/prpol.php" target="_blank">Privacy Policy </a>
			The work was performed in the framework of the State Academies of Sciences Basic Research program for 2020-2030.
		</p>
	</footer>
	
</div>
</body>


<dialog class="dlg_off" id="about_dlg">
	<header class="dlg_header"><h2>About</h2></header>
	<div class="dlg_div">
		<div class="dlg_txt">
			  <p ALIGN=JUSTIFY style="font-weight: bold;">The chemical structure must fullfil the following requirements:</p>
			  <p ALIGN=JUSTIFY>• Structure should be uncharged or charges should be balanced</p>
			  <p ALIGN=JUSTIFY>• Only single, double and triple bonds are allowed</p>
			  <p ALIGN=JUSTIFY>• Structure should contain at least 3 carbon atoms</p>
			  <p ALIGN=JUSTIFY>• Structure should contain only one component, single atoms are not considered</p>
			  <p ALIGN=JUSTIFY>• Absolute molecular weight should exceed 1250</p>
				<p ALIGN=JUSTIFY>• Discovery of novel antibacterial agents is important ongoning task and this process benefits from using (Q)SAR methods, which are based on the extensively validated predictive methods and experimental data accumulated in the field.</p>
				<p></p>
				<p ALIGN=JUSTIFY style="font-weight: bold;">General information:</p>
				<p ALIGN=JUSTIFY>Data on antibacterial action of chemical compounds are well represented in public domain. ChEMBL database [2], for example, contains records on activity of chemical compounds against more than 1386 bacteria. We extracted bioactivity records on minimum inhibitory concentrations (MICs) of chemical compounds from ChEMBL_24 and prepared them as follows:</p>
				<p>• Chemical data were prepared according to the good (Q)SAR practice [3].</p>
		    <p>• Biological data were reviewed to exclude the unreliable data points and to specify the records, related to the resistant microorganisms.</p>
		    <p ALIGN=JUSTIFY>In general, pipeline for the data preparation was similar to those and described in publications [4, 5].</p>
		    <p ALIGN=JUSTIFY>The training set containing structures of 41,065 chemical compounds and data on their antibacterial activities was prepared. All molecules with MIC < 10000 nM were considered as “actives”. Using this set, we trained PASS [6] to classify drug-like molecule as “actives” and “inactives” against <a href="alist.html" target="_blank">353 bacteria</a>, including resistant ones. The average accuracy of prediction assessed as IAP (corresponds numerically to the ROC AUC) in Leave-One-Out Cross-Validation equals 0.93 (for particular biological activities IAP was in range from 0.75 to 1.00).</p>
		    <p ALIGN=JUSTIFY>Update from january 2026:  RDKit.JS is now used for the intial chemical structure processing [7] instead of the MarvinJS (https://chemaxon.com/). Also, the code of antiBac pages is available via GitHub:</p>
		  	<p>https://github.com/pavelVPo/IBMC_LSFBD_webApp_antibac</p>
    	</div>
	    <div class="dlg_ref">
	    	<p ALIGN=LEFT>References:
1. Brown, E. D., Wright, G. D. (2016), Antibacterial drug discovery in the resistance era. Nature, 529(7586), 336.
2. Gaulton, A., et al. (2016), The ChEMBL database in 2017. Nucleic acids research, 45(D1), D945-D954.
3. Fourches, D., et al.. (2015), Curation of chemogenomics data. Nature chemical biology, 11(8), 535.
4. Pogodin, P. V., et al. (2015), PASS Targets: Ligand-based multi-target computational system based on a public data and naïve Bayes approach. SAR and QSAR in Environmental Research, 26(10), 783-793.
5. Pogodin, P., et al. (2018), How to Achieve Better Results Using PASS-Based Virtual Screening: Case Study for Kinase Inhibitors. Frontiers in chemistry, 6, 133.
6. Filimonov, D. A., et al. (2014). Prediction of the biological activity spectra of organic compounds using the PASS online web resource. Chemistry of Heterocyclic Compounds, 50(3), 444-457.
7. Landrum, G. (2013). Rdkit documentation. Release, 1(1-79), 4.</p>
			</div>
		</div>
  <div id="btn_close_about" class="dlg_btn"><button autofocus>Close</button></div>
</dialog>
<dialog class="dlg_off" id="interp_dlg">
	<header class="dlg_header"><h2>Interpretation</h2></header>
	<div class="dlg_div">
		<div class="dlg_txt">
			<p ALIGN=JUSTIFY>This app allows user to predict the growth's inhibition of one or more of <a href="alist.html" target="_blank">353 bacteria</a> in concentration below the 10000 nM. The score for each compound is expressed as a difference between probabilities for chemical compound to inhibit and to do not inhibit the growth of the particular bacteria, which are computed using PASS software based on the existing data. The higher confidence means the higher chance of the positive prediction to be true.</p>
			<p ALIGN=JUSTIFY>Only bacterial targets with Pa > Pi (score > 0) are considered as possible for a particular compound and provided to the user.</p>
			<p ALIGN=JUSTIFY>The higher the score, the higher the chances for the compound to be found active in the experiment against this particular bacteria.</p>
			<p ALIGN=JUSTIFY>During the validation experiments it was shown that prediction results for the compounds having more than 15% of new descriptors have lower accuracy. Thus, the user gets the
				notification that compound of his interest is probably out of applicability domain if it has more than 15% of new descriptors.</p>
			<p ALIGN=JUSTIFY>Thus, interpretation of the results is quite simple: the higher the score - the higher the chances for the compound to be found active in the experiment on condition that it has fewer than 15% of new descriptors. 
        Detailed explanation of how to interpet the results of PASS is given in <a href="http://bmc-rm.org/index.php/bmcrm/article/view/4" target="_blank">this</a> publication</p>
		</div>
	</div>
  <div id="btn_close_interp" class="dlg_btn"><button autofocus>Close</button></div>
</dialog>
<dialog class="dlg_off" id="contact_dlg">
	<header class="dlg_header"><h2>Contacts</h2></header>
	<div class="dlg_div">
		<div class="dlg_txt">
			<p>Laboratory for Structure-Function Based Drug Design, Department for Bioinformatics, Institute of Biomedical Chemistry (IBMC) Pogodinskaya Str. 10, Moscow, Russia, 119121</p>
        <p>	------------------------------	</p>
        <p>• Way2Drug Team Tel:  +7 499 246-09-20 Fax: +7 499 245-08-57  E-mail: pass@ibmc.msk.ru</p>
        <p>• pogodinpv@ibmc.msk.ru</p>
		</div>
	</div>
  <div id="btn_close_contact" class="dlg_btn"><button autofocus>Close</button></div>
</dialog>
<dialog class="dlg_off" id="draw_dlg">
	<header class="dlg_header"><h3>Please, use the chemical editor of your choice to draw and prepare the chemical structure for prediction</h3></header>
	<div class="dlg_div">
		<p>Dedicated software of users' choice for chemical drawing is the way to not to restrict the users' choice and to allow them to comply with their own requirements.</p>
		<p>One of the web tools having free base functionality for the researchers from academia is MolView, <a href="https://molview.org/" target="_blank">https://molview.org/</a></p>
		<p>For the details on licensing of the current version of the MolView, please SEE: https://molview.com/subscriptions/</p>
		<p>To use it:
			<ul>
				<li><a>go to https://molview.org/</a></li>
				<li><a>click "Continue to old app"</a></li>
				<li><a>draw the chemical structure</a></li>
				<li><a>go to Tools, click MOL file</a></li>
				<li><a>use the content of the downloaded MOL file to make the prediction</a></li>
		</ul>
		</p>
		<p>In the future we will consider other options for chemical drawing.</p>
	</div>
  <div id="btn_close_draw" class="dlg_btn"><button autofocus>Close</button></div>
</dialog>
</html>
<script src="js/main_script.js"></script>
<script type="text/javascript">
	// Some vars
	const names_arr = Array("name", "val", "id");
	const values = data['values'];
	const elem_table_body = document.getElementById("table_data_body");
	const elem_applicability = document.getElementById("applicability");
	const elem_svg = document.getElementById('container_svg');
	// Actually populate the table
	sort_targets_desc(values, elem_table_body, names_arr);
	// Add info on applicability
	elem_applicability.innerHTML = data.ad;
	elem_svg.innerHTML = data.picture.replace(/<rect.*rect>/, "");
</script>