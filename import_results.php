function karnic_import() {
include 'simple_html_dom.php';
include 'constituencies.inc';
$consti = get_constituencies();
$base_url = "http://eciresults.nic.in/ConstituencywiseS10";
	foreach($consti as $key => $city) {
		$full_url = $base_url . $key . '.htm';
		if($key<2) {	
				$html = '';
				$html = file_get_html($full_url); 
				foreach($html->find('table',9)->find('tr') as $row_number => $row) {
					if($row_number>2) {
						$record = array (
								"city_code" => $key,
								"city_name" => $city,
						 );

						foreach($row->find('td') as $td_count => $td_value) {
							switch($td_count){
							  case 0 :
							  $record['candidate_name'] = $td_value;
							  break;
							  case 1 :
							  $record['party_name'] = $td_value;
							  break;
							  case 2 :
							  $record['votes_recieved'] = $td_value;							  
							  break;
							}
							//This is a drupal function for inserting the record into database. Replace with any db write function 
							drupal_write_record('karnic', $record); 
						}
						
					}
				}
		}
	}
	
}
