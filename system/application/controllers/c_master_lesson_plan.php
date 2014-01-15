<?php
/* 	
	GIOV Solution - Keep IT Simple
*/

//class of anamnesa
class C_master_lesson_plan extends Controller {

	//constructor
	function C_master_lesson_plan(){
		parent::Controller();
		session_start();
		$this->load->model('m_master_lesson_plan', '', TRUE);
		
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_master_lesson_plan');
	}
	
	function  get_class(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		
		$result=$this->m_master_lesson_plan->get_class($query,$start,$end);
		echo $result;
	}

	function  get_teacher(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		
		$result=$this->m_public_function->get_karyawan_list($query,$start,$end);
		echo $result;
	}
	
	//for detail action
	//list detail handler action
	function  detail_lesson_plan_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_master_lesson_plan->detail_lesson_plan_list($master_id,$query,$start,$end);
		echo $result;
	}
	//end of handler
	
	//purge all detail
	function detail_anamnesa_problem_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		$result=$this->m_master_lesson_plan->detail_anamnesa_problem_purge($master_id);
	}
	//eof
	
	function get_subject_list(){
		$day = isset($_POST['day']) ? $_POST['day'] : "";
		$week = isset($_POST['week']) ? $_POST['week'] : "";
		$lesson_plan = isset($_POST['lesson_plan']) ? $_POST['lesson_plan'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_master_lesson_plan->get_subject_list($day,$week,$lesson_plan,$start,$end);
		echo $result;
	}
	
	
	//add detail
	function detail_anamnesa_problem_insert(){
	//POST variable here
		$panam_id=trim(@$_POST["panam_id"]);
		$panam_master=trim(@$_POST["panam_master"]);
		$panam_problem=trim(@$_POST["panam_problem"]);
		$panam_problem=str_replace("/(<\/?)(p)([^>]*>)", "",$panam_problem);
		$panam_lamaproblem=trim(@$_POST["panam_lamaproblem"]);
		$panam_lamaproblem=str_replace("/(<\/?)(p)([^>]*>)", "",$panam_lamaproblem);
		$panam_aksiproblem=trim(@$_POST["panam_aksiproblem"]);
		$panam_aksiproblem=str_replace("/(<\/?)(p)([^>]*>)", "",$panam_aksiproblem);
		$panam_aksiket=trim(@$_POST["panam_aksiket"]);
		$panam_aksiket=str_replace("/(<\/?)(p)([^>]*>)", "",$panam_aksiket);
		
		$panam_id = json_decode(stripslashes($panam_id));
		$panam_problem = json_decode(stripslashes($panam_problem));
		$panam_lamaproblem = json_decode(stripslashes($panam_lamaproblem));
		$panam_aksiproblem = json_decode(stripslashes($panam_aksiproblem));
		$panam_aksiket = json_decode(stripslashes($panam_aksiket));
		
  		$result=$this->m_master_lesson_plan->detail_anamnesa_problem_insert($panam_id ,$panam_master ,$panam_problem ,$panam_lamaproblem ,$panam_aksiproblem ,
																  $panam_aksiket );
		
		echo $result;
		
	}
	
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->lr_list();
				break;
			case "UPDATE":
				$this->lesplan_update();
				break;
			case "CREATE":
				$this->lesplan_create();
				break;
			case "DELETE":
				$this->anamnesa_delete();
				break;
			case "SEARCH":
				$this->anamnesa_search();
				break;
			case "PRINT":
				$this->anamnesa_print();
				break;
			case "EXCEL":
				$this->anamnesa_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function lr_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_master_lesson_plan->lr_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function lesplan_update(){
		//POST variable here
		$lesplan_id=trim(@$_POST["lesplan_id"]);
		$lesplan_class=trim(@$_POST["lesplan_class"]);
		$lesplan_teacher=trim(@$_POST["lesplan_teacher"]);
		$lesplan_tanggal=trim(@$_POST["lesplan_tanggal"]);
		$lesplan_theme=trim(@$_POST["lesplan_theme"]);
		$lesplan_theme=str_replace("/(<\/?)(p)([^>]*>)", "",$lesplan_theme);
		$lesplan_theme=str_replace("'", '"',$lesplan_theme);
		$lesplan_sub_theme=trim(@$_POST["lesplan_sub_theme"]);
		$lesplan_sub_theme=str_replace("/(<\/?)(p)([^>]*>)", "",$lesplan_sub_theme);
		$lesplan_sub_theme=str_replace("'", '"',$lesplan_sub_theme);
		$lesplan_week=trim(@$_POST["lesplan_week"]);
		$lesplan_week=str_replace("/(<\/?)(p)([^>]*>)", "",$lesplan_week);
		$lesplan_week=str_replace("'", '"',$lesplan_week);
		$lesplan_day=trim(@$_POST["lesplan_day"]);
		$lesplan_day=str_replace("/(<\/?)(p)([^>]*>)", "",$lesplan_day);
		$lesplan_day=str_replace("'", '"',$lesplan_day);
		$lesplan_agreement=trim(@$_POST["lesplan_agreement"]);
		$lesplan_agreement=str_replace("/(<\/?)(p)([^>]*>)", "",$lesplan_agreement);
		$lesplan_agreement=str_replace("'", '"',$lesplan_agreement);
			
		// detail lp
		$dlesplan_id = $_POST['dlesplan_id'];
		$array_dlesplan_id = json_decode(stripslashes($dlesplan_id));

		$dlesplan_time_start = $_POST['dlesplan_time_start'];
		$array_dlesplan_time_start = json_decode(stripslashes($dlesplan_time_start));

		$dlesplan_time_end = $_POST['dlesplan_time_end'];
		$array_dlesplan_time_end = json_decode(stripslashes($dlesplan_time_end));

		$dlesplan_act = $_POST['dlesplan_act'];
		$array_dlesplan_act = json_decode(stripslashes($dlesplan_act));

		$dlesplan_materials = $_POST['dlesplan_materials'];
		$array_dlesplan_materials = json_decode(stripslashes($dlesplan_materials));

		$dlesplan_desc = $_POST['dlesplan_desc'];
		$array_dlesplan_desc = json_decode(stripslashes($dlesplan_desc));
		
		$dlesplan_master=trim(@$_POST["dlesplan_master"]);
		
		$dlesplan_subject = $_POST['dlesplan_subject'];
		$array_dlesplan_subject = json_decode(stripslashes($dlesplan_subject));
		// eof detail lp

		$result = $this->m_master_lesson_plan->lesplan_update(
			$lesplan_id ,$lesplan_tanggal, $lesplan_class, $lesplan_teacher, $lesplan_theme, $lesplan_sub_theme ,$lesplan_week ,$lesplan_day, $lesplan_agreement, 
			$array_dlesplan_id, 
			$array_dlesplan_subject, 
			$array_dlesplan_time_start, 
			$array_dlesplan_time_end, 
			$array_dlesplan_act, 
			$array_dlesplan_materials, 
			$array_dlesplan_desc);
		echo $result;
	}
	
	//function for create new record
	function lesplan_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$lesplan_tanggal=trim(@$_POST["lesplan_tanggal"]);
		$lesplan_class=trim(@$_POST["lesplan_class"]);
		$lesplan_teacher=trim(@$_POST["lesplan_teacher"]);
		$lesplan_theme=trim(@$_POST["lesplan_theme"]);
		$lesplan_theme=str_replace("/(<\/?)(p)([^>]*>)", "",$lesplan_theme);
		$lesplan_theme=str_replace("'", '"',$lesplan_theme);
		$lesplan_sub_theme=trim(@$_POST["lesplan_sub_theme"]);
		$lesplan_sub_theme=str_replace("/(<\/?)(p)([^>]*>)", "",$lesplan_sub_theme);
		$lesplan_sub_theme=str_replace("'", '"',$lesplan_sub_theme);
		$lesplan_week=trim(@$_POST["lesplan_week"]);
		$lesplan_week=str_replace("/(<\/?)(p)([^>]*>)", "",$lesplan_week);
		$lesplan_week=str_replace("'", '"',$lesplan_week);
		$lesplan_day=trim(@$_POST["lesplan_day"]);
		$lesplan_day=str_replace("/(<\/?)(p)([^>]*>)", "",$lesplan_day);
		$lesplan_day=str_replace("'", '"',$lesplan_day);
		$lesplan_agreement=trim(@$_POST["lesplan_agreement"]);
		$lesplan_agreement=str_replace("/(<\/?)(p)([^>]*>)", "",$lesplan_agreement);
		$lesplan_agreement=str_replace("'", '"',$lesplan_agreement);
		
		// detail lp
		$dlesplan_id = $_POST['dlesplan_id'];
		$array_dlesplan_id = json_decode(stripslashes($dlesplan_id));

		$dlesplan_time_start = $_POST['dlesplan_time_start'];
		$array_dlesplan_time_start = json_decode(stripslashes($dlesplan_time_start));

		$dlesplan_time_end = $_POST['dlesplan_time_end'];
		$array_dlesplan_time_end = json_decode(stripslashes($dlesplan_time_end));

		$dlesplan_act = $_POST['dlesplan_act'];
		$array_dlesplan_act = json_decode(stripslashes($dlesplan_act));

		$dlesplan_materials = $_POST['dlesplan_materials'];
		$array_dlesplan_materials = json_decode(stripslashes($dlesplan_materials));

		$dlesplan_desc = $_POST['dlesplan_desc'];
		$array_dlesplan_desc = json_decode(stripslashes($dlesplan_desc));
		
		$dlesplan_master=trim(@$_POST["dlesplan_master"]);
		
		$dlesplan_subject = $_POST['dlesplan_subject'];
		$array_dlesplan_subject = json_decode(stripslashes($dlesplan_subject));
		// eof detail lp


		$result=$this->m_master_lesson_plan->lesplan_create($lesplan_tanggal, $lesplan_class, $lesplan_teacher, $lesplan_theme, $lesplan_sub_theme ,$lesplan_week ,$lesplan_day, $lesplan_agreement, 
			$array_dlesplan_id, 
			$array_dlesplan_subject, 
			$array_dlesplan_time_start, 
			$array_dlesplan_time_end, 
			$array_dlesplan_act, 
			$array_dlesplan_materials, 
			$array_dlesplan_desc
			);
		echo $result;
	}

	//function for delete selected record
	function anamnesa_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_master_lesson_plan->anamnesa_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function anamnesa_search(){
		//POST varibale here
		$anam_id=trim(@$_POST["anam_id"]);
		$anam_cust=trim(@$_POST["anam_cust"]);
		$anam_tanggal=trim(@$_POST["anam_tanggal"]);
		$anam_petugas=trim(@$_POST["anam_petugas"]);
		$anam_pengobatan=trim(@$_POST["anam_pengobatan"]);
		$anam_pengobatan=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_pengobatan);
		$anam_perawatan=trim(@$_POST["anam_perawatan"]);
		$anam_perawatan=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_perawatan);
		$anam_terapi=trim(@$_POST["anam_terapi"]);
		$anam_terapi=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_terapi);
		$anam_alergi=trim(@$_POST["anam_alergi"]);
		$anam_alergi=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_alergi);
		$anam_obatalergi=trim(@$_POST["anam_obatalergi"]);
		$anam_obatalergi=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_obatalergi);
		$anam_efekobatalergi=trim(@$_POST["anam_efekobatalergi"]);
		$anam_efekobatalergi=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_efekobatalergi);
		$anam_hamil=trim(@$_POST["anam_hamil"]);
		$anam_hamil=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_hamil);
		$anam_kb=trim(@$_POST["anam_kb"]);
		$anam_kb=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_kb);
		$anam_harapan=trim(@$_POST["anam_harapan"]);
		$anam_harapan=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_harapan);
		
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		
		$result = $this->m_master_lesson_plan->anamnesa_search($anam_id ,$anam_cust ,$anam_tanggal ,$anam_petugas ,$anam_pengobatan ,$anam_perawatan ,
													 $anam_terapi ,$anam_alergi ,$anam_obatalergi ,$anam_efekobatalergi ,$anam_hamil ,$anam_kb ,
													 $anam_harapan ,$start,$end);
		echo $result;
	}


	function anamnesa_print(){
  		//POST varibale here
		$anam_id=trim(@$_POST["anam_id"]);
		$anam_cust=trim(@$_POST["anam_cust"]);
		$anam_tanggal=trim(@$_POST["anam_tanggal"]);
		$anam_petugas=trim(@$_POST["anam_petugas"]);
		$anam_pengobatan=trim(@$_POST["anam_pengobatan"]);
		$anam_pengobatan=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_pengobatan);
		$anam_perawatan=trim(@$_POST["anam_perawatan"]);
		$anam_perawatan=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_perawatan);
		$anam_terapi=trim(@$_POST["anam_terapi"]);
		$anam_terapi=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_terapi);
		$anam_alergi=trim(@$_POST["anam_alergi"]);
		$anam_alergi=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_alergi);
		$anam_obatalergi=trim(@$_POST["anam_obatalergi"]);
		$anam_obatalergi=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_obatalergi);
		$anam_efekobatalergi=trim(@$_POST["anam_efekobatalergi"]);
		$anam_efekobatalergi=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_efekobatalergi);
		$anam_hamil=trim(@$_POST["anam_hamil"]);
		$anam_hamil=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_hamil);
		$anam_kb=trim(@$_POST["anam_kb"]);
		$anam_kb=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_kb);
		$anam_harapan=trim(@$_POST["anam_harapan"]);
		$anam_harapan=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_harapan);
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_master_lesson_plan->anamnesa_print($anam_id ,$anam_cust ,$anam_tanggal ,$anam_petugas ,$anam_pengobatan ,$anam_perawatan ,
													$anam_terapi ,$anam_alergi ,$anam_obatalergi ,$anam_efekobatalergi ,$anam_hamil ,$anam_kb ,
													$anam_harapan ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=13;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("anamnesalist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Daftar Anamnesa</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'>
						<table summary='Anamnesa List'>
						<caption>Daftar Anamnesa</caption>
						<thead>
							<tr>
								<th scope='col'>No</th>
								<th scope='col'>No Cust</th>
								<th scope='col'>Customer</th>
								<th scope='col'>Tanggal</th>
								<th scope='col'>Petugas</th>
								<th scope='col'>Pengobatan</th>
								<th scope='col'>Perawatan</th>
								<th scope='col'>Terapi</th>
								<th scope='col'>Alergi</th>
								<th scope='col'>Alergi terhadap Obat</th>
								<th scope='col'>Efek Alergi</th>
								<th scope='col'>Hamil</th>
								<th scope='col'>Alat KB yang digunakan</th>
								<th scope='col'>Harapan</th>
							</tr>
						</thead>
						<tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " Anamnesa</td></tr></tfoot><tbody>");
		$i=0;
		if($nbrows>0){
			foreach($result->result_array() as $data){
				$i++;
				fwrite($file,'<tr');
				if($i%1==0){
					fwrite($file," class='odd'");
				}
			
				fwrite($file, "><td>");
				fwrite($file, $i);
				fwrite($file,"</td><td>");
				fwrite($file, $data['cust_no']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['cust_nama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['anam_tanggal']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['karyawan_nama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['anam_pengobatan']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['anam_perawatan']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['anam_terapi']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['anam_alergi']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['anam_obatalergi']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['anam_efekobatalergi']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['anam_hamil']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['anam_kb']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['anam_harapan']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function anamnesa_export_excel(){
		//POST varibale here
		$anam_id=trim(@$_POST["anam_id"]);
		$anam_cust=trim(@$_POST["anam_cust"]);
		$anam_tanggal=trim(@$_POST["anam_tanggal"]);
		$anam_petugas=trim(@$_POST["anam_petugas"]);
		$anam_pengobatan=trim(@$_POST["anam_pengobatan"]);
		$anam_pengobatan=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_pengobatan);
		$anam_pengobatan=str_replace("'", '"',$anam_pengobatan);
		$anam_perawatan=trim(@$_POST["anam_perawatan"]);
		$anam_perawatan=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_perawatan);
		$anam_perawatan=str_replace("'", '"',$anam_perawatan);
		$anam_terapi=trim(@$_POST["anam_terapi"]);
		$anam_terapi=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_terapi);
		$anam_terapi=str_replace("'", '"',$anam_terapi);
		$anam_alergi=trim(@$_POST["anam_alergi"]);
		$anam_alergi=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_alergi);
		$anam_alergi=str_replace("'", '"',$anam_alergi);
		$anam_obatalergi=trim(@$_POST["anam_obatalergi"]);
		$anam_obatalergi=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_obatalergi);
		$anam_obatalergi=str_replace("'", '"',$anam_obatalergi);
		$anam_efekobatalergi=trim(@$_POST["anam_efekobatalergi"]);
		$anam_efekobatalergi=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_efekobatalergi);
		$anam_efekobatalergi=str_replace("'", '"',$anam_efekobatalergi);
		$anam_hamil=trim(@$_POST["anam_hamil"]);
		$anam_hamil=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_hamil);
		$anam_hamil=str_replace("'", '"',$anam_hamil);
		$anam_kb=trim(@$_POST["anam_kb"]);
		$anam_kb=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_kb);
		$anam_kb=str_replace("'", '"',$anam_kb);
		$anam_harapan=trim(@$_POST["anam_harapan"]);
		$anam_harapan=str_replace("/(<\/?)(p)([^>]*>)", "",$anam_harapan);
		$anam_harapan=str_replace("'", '"',$anam_harapan);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_master_lesson_plan->anamnesa_export_excel($anam_id ,$anam_cust ,$anam_tanggal ,$anam_petugas ,$anam_pengobatan ,$anam_perawatan ,
														  $anam_terapi ,$anam_alergi ,$anam_obatalergi ,$anam_efekobatalergi ,$anam_hamil ,$anam_kb ,
														  $anam_harapan ,$option,$filter);
		
		$this->load->plugin('to_excel');
		to_excel($query,"anamnesa"); 
		echo '1';
			
	}
	
	// Encodes a SQL array into a JSON formated string
	function JEncode($arr){
		if (version_compare(PHP_VERSION,"5.2","<"))
		{    
			require_once("./JSON.php"); //if php<5.2 need JSON class
			$json = new Services_JSON();//instantiate new json object
			$data=$json->encode($arr);  //encode the data in json format
		} else {
			$data = json_encode($arr);  //encode the data in json format
		}
		return $data;
	}
	
	// Decode a SQL array into a JSON formated string
	function JDecode($arr){
		if (version_compare(PHP_VERSION,"5.2","<"))
		{    
			require_once("./JSON.php"); //if php<5.2 need JSON class
			$json = new Services_JSON();//instantiate new json object
			$data=$json->decode($arr);  //decode the data in json format
		} else {
			$data = json_decode($arr);  //decode the data in json format
		}
		return $data;
	}
	
	// Encodes a YYYY-MM-DD into a MM-DD-YYYY string
	function codeDate ($date) {
	  $tab = explode ("-", $date);
	  $r = $tab[1]."/".$tab[2]."/".$tab[0];
	  return $r;
	}
	
}
?>