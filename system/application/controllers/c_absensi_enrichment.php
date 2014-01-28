<?php
/* 	
	GIOV Solution - Keep IT Simple
*/

//class of Absensi Enrichment
class C_absensi_enrichment extends Controller {

	//constructor
	function C_absensi_enrichment(){
		parent::Controller();
		session_start();
		$this->load->model('m_absensi_enrichment', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_absensi_enrichment');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->absenrich_list();
				break;
			case "UPDATE":
				$this->absenrich_update();
				break;
			case "CREATE":
				$this->absenrich_create();
				break;
			case "DELETE":
				$this->absenrich_delete();
				break;
			case "SEARCH":
				$this->absenrich_search();
				break;
			case "PRINT":
				$this->absenrich_print();
				break;
			case "EXCEL":
				$this->absenrich_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function absenrich_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_absensi_enrichment->absenrich_list($query,$start,$end);
		echo $result;
	}

	function get_customer_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_absensi_enrichment->get_customer_list($query,$start,$end);
		echo $result;
	}

	function get_info_data_pengantar(){
		$cust_id = (integer) (isset($_POST['cust_id']) ? $_POST['cust_id'] : $_GET['cust_id']);
		$result=$this->m_absensi_enrichment->get_info_data_pengantar($cust_id);
		echo $result;
	}


	//function for update record
	function absenrich_update(){
		//POST variable here
		$gudang_id=trim(@$_POST["gudang_id"]);
		$gudang_nama=trim(@$_POST["gudang_nama"]);
		$gudang_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_nama);
		$gudang_nama=str_replace("'", '"',$gudang_nama);
		$gudang_lokasi=trim(@$_POST["gudang_lokasi"]);
		$gudang_lokasi=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_lokasi);
		$gudang_lokasi=str_replace("'", '"',$gudang_lokasi);
		$gudang_keterangan=trim(@$_POST["gudang_keterangan"]);
		$gudang_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_keterangan);
		$gudang_keterangan=str_replace("'", '"',$gudang_keterangan);
		$gudang_aktif=trim(@$_POST["gudang_aktif"]);
		$gudang_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_aktif);
		$gudang_aktif=str_replace("'", '"',$gudang_aktif);
		$gudang_creator=trim(@$_POST["gudang_creator"]);
		$gudang_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_creator);
		$gudang_creator=str_replace("'", '"',$gudang_creator);
		$gudang_date_create=trim(@$_POST["gudang_date_create"]);
		$absenrich_updater=trim(@$_POST["absenrich_updater"]);
		$absenrich_updater=str_replace("/(<\/?)(p)([^>]*>)", "",$absenrich_updater);
		$absenrich_updater=str_replace("'", '"',$absenrich_updater);
		$gudang_date_update=trim(@$_POST["gudang_date_update"]);
		$gudang_revised=trim(@$_POST["gudang_revised"]);
		$result = $this->m_absensi_enrichment->absenrich_update($gudang_id ,$gudang_nama ,$gudang_lokasi ,$gudang_keterangan ,$gudang_aktif ,$gudang_creator ,$gudang_date_create ,$absenrich_updater ,$gudang_date_update ,$gudang_revised );
		echo $result;
	}
	
	//function for create new record
	function absenrich_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$absenrich_cust=trim(@$_POST["absenrich_cust"]);
		$absenrich_tgl=trim(@$_POST["absenrich_tgl"]);
		$absenrich_class=trim(@$_POST["absenrich_class"]);
		$absenrich_class=str_replace("/(<\/?)(p)([^>]*>)", "",$absenrich_class);
		$absenrich_class=str_replace("'", '"',$absenrich_class);
		$absenrich_keterangan=trim(@$_POST["absenrich_keterangan"]);
		$absenrich_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$absenrich_keterangan);
		$absenrich_keterangan=str_replace("'", '"',$absenrich_keterangan);
		$absenrich_pengantar1=trim(@$_POST["absenrich_pengantar1"]);
		$absenrich_pengantar2=trim(@$_POST["absenrich_pengantar2"]);
		$absenrich_pengantar3=trim(@$_POST["absenrich_pengantar3"]);
		$absenrich_pengantar4=trim(@$_POST["absenrich_pengantar4"]);
		$absenrich_pengantar5=trim(@$_POST["absenrich_pengantar5"]);
		$absenrich_check1=trim(@$_POST["absenrich_check1"]);
		$absenrich_check2=trim(@$_POST["absenrich_check2"]);
		$absenrich_check3=trim(@$_POST["absenrich_check3"]);
		$absenrich_check4=trim(@$_POST["absenrich_check4"]);
		$absenrich_check5=trim(@$_POST["absenrich_check5"]);

		$result=$this->m_absensi_enrichment->absenrich_create($absenrich_cust, $absenrich_tgl, $absenrich_class, $absenrich_keterangan, $absenrich_pengantar1, $absenrich_pengantar2, $absenrich_pengantar3, $absenrich_pengantar4, $absenrich_pengantar5, $absenrich_check1, $absenrich_check2, $absenrich_check3, $absenrich_check4, $absenrich_check5);
		echo $result;
	}

	//function for delete selected record
	function absenrich_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_absensi_enrichment->absenrich_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function absenrich_search(){
		//POST varibale here
		$gudang_id=trim(@$_POST["gudang_id"]);
		$gudang_nama=trim(@$_POST["gudang_nama"]);
		$gudang_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_nama);
		$gudang_nama=str_replace("'", '"',$gudang_nama);
		$gudang_lokasi=trim(@$_POST["gudang_lokasi"]);
		$gudang_lokasi=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_lokasi);
		$gudang_lokasi=str_replace("'", '"',$gudang_lokasi);
		$gudang_keterangan=trim(@$_POST["gudang_keterangan"]);
		$gudang_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_keterangan);
		$gudang_keterangan=str_replace("'", '"',$gudang_keterangan);
		$gudang_aktif=trim(@$_POST["gudang_aktif"]);
		$gudang_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_aktif);
		$gudang_aktif=str_replace("'", '"',$gudang_aktif);
		$gudang_creator=trim(@$_POST["gudang_creator"]);
		$gudang_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_creator);
		$gudang_creator=str_replace("'", '"',$gudang_creator);
		$gudang_date_create=trim(@$_POST["gudang_date_create"]);
		$absenrich_updater=trim(@$_POST["absenrich_updater"]);
		$absenrich_updater=str_replace("/(<\/?)(p)([^>]*>)", "",$absenrich_updater);
		$absenrich_updater=str_replace("'", '"',$absenrich_updater);
		$gudang_date_update=trim(@$_POST["gudang_date_update"]);
		$gudang_revised=trim(@$_POST["gudang_revised"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_absensi_enrichment->absenrich_search($gudang_id ,$gudang_nama ,$gudang_lokasi ,$gudang_keterangan ,$gudang_aktif ,$gudang_creator ,$gudang_date_create ,$absenrich_updater ,$gudang_date_update ,$gudang_revised ,$start,$end);
		echo $result;
	}


	function absenrich_print(){
  		//POST varibale here
		$gudang_id=trim(@$_POST["gudang_id"]);
		$gudang_nama=trim(@$_POST["gudang_nama"]);
		$gudang_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_nama);
		$gudang_nama=str_replace("'", '"',$gudang_nama);
		$gudang_lokasi=trim(@$_POST["gudang_lokasi"]);
		$gudang_lokasi=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_lokasi);
		$gudang_lokasi=str_replace("'", '"',$gudang_lokasi);
		$gudang_keterangan=trim(@$_POST["gudang_keterangan"]);
		$gudang_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_keterangan);
		$gudang_keterangan=str_replace("'", '"',$gudang_keterangan);
		$gudang_aktif=trim(@$_POST["gudang_aktif"]);
		$gudang_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_aktif);
		$gudang_aktif=str_replace("'", '"',$gudang_aktif);
		$gudang_creator=trim(@$_POST["gudang_creator"]);
		$gudang_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_creator);
		$gudang_creator=str_replace("'", '"',$gudang_creator);
		$gudang_date_create=trim(@$_POST["gudang_date_create"]);
		$absenrich_updater=trim(@$_POST["absenrich_updater"]);
		$absenrich_updater=str_replace("/(<\/?)(p)([^>]*>)", "",$absenrich_updater);
		$absenrich_updater=str_replace("'", '"',$absenrich_updater);
		$gudang_date_update=trim(@$_POST["gudang_date_update"]);
		$gudang_revised=trim(@$_POST["gudang_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_absensi_enrichment->absenrich_print($gudang_id ,$gudang_nama ,$gudang_lokasi ,$gudang_keterangan ,$gudang_aktif ,$gudang_creator ,$gudang_date_create ,$absenrich_updater ,$gudang_date_update ,$gudang_revised ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=10;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("gudanglist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Gudang Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'><table summary='Gudang List'><caption>DAFTAR GUDANG</caption><thead><tr><th scope='col'>No</th><th scope='col'>Nama</th><th scope='col'>Lokasi</th><th scope='col'>Keterangan</th><th scope='col'>Aktif</th></tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " Gudang</td></tr></tfoot><tbody>");
		$i=0;
		if($nbrows>0){
			foreach($result->result_array() as $data){
				$i++;
				fwrite($file,'<tr');
				if($i%1==0){
					fwrite($file," class='odd'");
				}
			
				fwrite($file, "><th scope='row' id='r97'>");
				fwrite($file, $i);
				fwrite($file,"</th><td>");
				fwrite($file, $data['gudang_nama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['gudang_lokasi']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['gudang_keterangan']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['gudang_aktif']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function absenrich_export_excel(){
		//POST varibale here
		$gudang_id=trim(@$_POST["gudang_id"]);
		$gudang_nama=trim(@$_POST["gudang_nama"]);
		$gudang_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_nama);
		$gudang_nama=str_replace("'", '"',$gudang_nama);
		$gudang_lokasi=trim(@$_POST["gudang_lokasi"]);
		$gudang_lokasi=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_lokasi);
		$gudang_lokasi=str_replace("'", '"',$gudang_lokasi);
		$gudang_keterangan=trim(@$_POST["gudang_keterangan"]);
		$gudang_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_keterangan);
		$gudang_keterangan=str_replace("'", '"',$gudang_keterangan);
		$gudang_aktif=trim(@$_POST["gudang_aktif"]);
		$gudang_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_aktif);
		$gudang_aktif=str_replace("'", '"',$gudang_aktif);
		$gudang_creator=trim(@$_POST["gudang_creator"]);
		$gudang_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_creator);
		$gudang_creator=str_replace("'", '"',$gudang_creator);
		$gudang_date_create=trim(@$_POST["gudang_date_create"]);
		$absenrich_updater=trim(@$_POST["absenrich_updater"]);
		$absenrich_updater=str_replace("/(<\/?)(p)([^>]*>)", "",$absenrich_updater);
		$absenrich_updater=str_replace("'", '"',$absenrich_updater);
		$gudang_date_update=trim(@$_POST["gudang_date_update"]);
		$gudang_revised=trim(@$_POST["gudang_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_absensi_enrichment->absenrich_export_excel($gudang_id ,$gudang_nama ,$gudang_lokasi ,$gudang_keterangan ,$gudang_aktif ,$gudang_creator ,$gudang_date_create ,$absenrich_updater ,$gudang_date_update ,$gudang_revised ,$option,$filter);
		
		to_excel($query,"absensi_enrichment"); 
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
	
	// Encodes a YYYY-MM-DD into a MM-DD-YYYY string
	function codeDate ($date) {
	  $tab = explode ("-", $date);
	  $r = $tab[1]."/".$tab[2]."/".$tab[0];
	  return $r;
	}
	
}
?>