<?php
	$Row_awd=1;
	if (($handle = fopen("awards.csv", "r")) !== FALSE) {
		while (($Data1[$Row_awd] = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$Row_awd++;
		}
		fclose($handle);
	}

	$fp = fopen('final.csv', 'w');

	$Row_con=1;
	$final_Field=0;
	if (($handle = fopen("contracts.csv", "r")) !== FALSE){
		while (($Data2[$Row_con] = fgetcsv($handle, 1000, ",")) !== FALSE){
			$final_Data = $Data2[$Row_con];
			if($Row_con==1)
				$final_Field= count($Data1[1]) + count($Data2[1]);
			 for($i=1;$i<$Row_awd;$i++)
			 {
				$num = count($Data1[$i]);
				if(strtoupper($Data2[$Row_con][0]) == strtoupper($Data1[$i][0])){
					for($j=1;$j<$num;$j++){
						array_push($final_Data,$Data1[$i][$j]);
					}
				}	
			}
			if(count($final_Data)<$final_Field){
				for($i=count($final_Data);$i<$final_Field-1;$i++){
					array_push($final_Data,'');
				}
			}

			fputcsv($fp, $final_Data);
			$Row_con++;
		}
		fclose($fp);
		fclose($handle);
	}


	$Row=1;
	$totalSum =0;
	$amount_index = -1;
	if (($handle = fopen("final.csv", "r")) !== FALSE) {
		while (($Data[$Row] = fgetcsv($handle, 1000, ",")) !== FALSE) {
			if($Row==1){
				$num = count($Data[$Row]);
				for($i=0;$i<$num;$i++){
					if(strtoupper($Data[$Row][$i])==strtoupper("Amount"))
						$amount_index = $i;
				}
			}
			if($amount_index!==-1){
				if(strtoupper($Data[$Row][1])==strtoupper("current")){
					if(count($Data[$Row])>=$amount_index){
						$totalSum += intval($Data[$Row][$amount_index]);
					}
				}
			}
			$Row++;
		}
		fclose($handle);
	}
	
	echo "Total Amounts in current contracts:".$totalSum;


?>
