<?php
//Log
$log_file = fopen("log.txt", "a+");
//Path to software
$pass_path = "...";
// IDs
$uid = uniqid();
$sdf_name = $pass_path.$uid.".SDF";
$task_name = $pass_path.$uid.".task";
//Get the data
$data_str = file_get_contents('php://input');
$data = json_decode($data_str, true);
$structure = "\r\n".trim($data['molfile']).">  <id>\r\n".$uid."\r\n\r\n$$$$";
// Prepare the task for prediction
$task = "InputName=".$uid.".SDF\r\nOutputName=".$uid.".csv\r\nBaseName=MICb.SAR\r\nIdKeyField=<id>";
// Write the structure and task
$structure_file = fopen($sdf_name, "w");
$task_file = fopen($task_name, "w");
fwrite($structure_file, $structure);
fwrite($task_file, $task);
fclose($structure_file);
fclose($task_file);
// Predict
//Descriptors
$descriptorspec = array(
   0 => array("pipe", "r"),
   1 => array("pipe", "w"),
   2 => array("pipe", "w")
);
//Command
$command = $pass_path."PASS2CSV.exe ".$task_name;
//Process
$process = proc_open(
        $command,
        $descriptorspec,
        $pipes
);
//Do the thing
if (is_resource($process)) {
	//Write
	//fwrite($pipes[0]);
   fclose($pipes[0]);
   //Get the results
   $process_result = stream_get_contents($pipes[1]);
   fclose($pipes[1]);
   fclose($pipes[2]);
   //Shutdown the process
   proc_close($process);
}
fwrite($log_file, $process_result);
fwrite($log_file, "\r\n\r\n");
//Check if predicted
$is_done = preg_match("|.*1 of 1 Substances are predicted.*|", @file_get_contents($pass_path.$uid.".HST"));
if ($is_done == '1') {
   //Prepare the results
   $result = trim(file_get_contents($pass_path.$uid.".csv"));
   $result = str_replace("<id>", "id", $result);
   $result = str_replace(">", "-", $result); 
   $result = trim(str_replace(",", ".", $result));
   $result = str_replace(";", ",", $result);
   //Values to array
   $result_arr = array_map("str_getcsv", explode("\r\n", $result));
   $result_arr = array_combine($result_arr['0'], $result_arr['1']);
   //Calculate AD
   $sDescr = $result_arr['Substructure Descriptors'];
   $nDescr = $result_arr['New Descriptors'];
   $fraqD = $nDescr/$sDescr;
   if ($fraqD > 0.15) {
      $ad_status = 'Compound of your interest is out of AD, its predicted bacterial targets are:';
   } else {
      $ad_status = 'Predicted bacterial targets for the compound of your interest:';
   }
   unset($result_arr['id']);
   unset($result_arr['Substructure Descriptors']);
   unset($result_arr['New Descriptors']);
   unset($result_arr['Possible Activities at Pa-Pi']);
   arsort($result_arr);
   $result_arr = array_filter($result_arr, function ($v) {
      return $v > 0;
   });
   //Make normal array
   $result_norm = array();
   foreach ($result_arr as $key => $value) {
      $arrLine['val'] = trim($value);
      $arrLine['name'] = trim(preg_replace("|.- CHEMBL.*|", "", $key));
      $arrLine['id'] = str_replace("-R", "", preg_replace("|.*CHEMBL|", "CHEMBL", $key));
      $result_norm[] = $arrLine;
   }
   //Convert to JSON
   $result_json = json_encode(["ad" => $ad_status, "values" => $result_norm]);
   fwrite($log_file, $result_json);
   fclose($log_file);
}
if ($is_done != '1') {
   $result_json = json_encode("no_result");
}
//Delete temporary things
@unlink($pass_path.$uid.".SDF");
@unlink($pass_path.$uid.".task");
@unlink($pass_path.$uid.".csv");
@unlink($pass_path.$uid.".HST");
// Return the results to browser
echo $result_json;
//Exit
exit();