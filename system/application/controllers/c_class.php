<?php
/* 	
	GIOV Solution - Keep IT Simple
*/

//class of gudang
class C_class extends Controller {

	//constructor
	function C_class(){
		parent::Controller();
		session_start();
		$this->load->model('m_class', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_class');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->class_list();
				break;
			case "UPDATE":
				$this->class_update();
				break;
			case "CREATE":
				$this->class_create();
				break;
			case "DELETE":
				$this->class_delete();
				break;
			case "SEARCH":
				$this->class_search();
				break;
			case "DDELETE":
				$this->detail_class_delete();
				break;
			case "PRINT":
				$this->class_print();
				break;
			case "PRINT_STUDENT":
				$this->student_print();
				break;
			case "EXCEL":
				$this->class_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	function student_print(){
  		//POST varibale here
		$master_id=trim(@$_POST["master_id"]);
		$class_name=trim(@$_POST["class_name"]);
		$class_name=str_replace("/(<\/?)(p)([^>]*>)", "",$class_name);
		$class_name=str_replace("'", '"',$class_name);
		//$option=$_POST['currentlisting'];
		//$filter=$_POST["query"];
		
		$result = $this->m_class->student_print($master_id);
		$nbrows=$result->num_rows();
		$totcolumn=10;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("kategorilist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
		<title>Class Students List</title>
		<link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'><table summary='Class List'>
		<caption>");
		fwrite($file, $class_name);
		fwrite($file," List</caption>
		<thead>
		<tr>
			<th scope='col'>No</th>
			<th scope='col'>Name</th>
			<th scope='col'>Notes</th>
			<th scope='col'>Active</th>
		</tr>
		</thead>
		<tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, "  Students</td></tr></tfoot><tbody>");
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
				fwrite($file, $data['cust_nama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['dclass_note']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['dclass_aktif']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */
	
	//function fot list record
	function class_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_class->class_list($query,$start,$end);
		echo $result;
	}

	//Get Teacher List Data Store
	function get_teacher_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_class->get_teacher_list($query,$start,$end);
		echo $result;
	}

	//list detail handler action
	function  detail_student_class_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_class->detail_student_class_list($master_id,$query,$start,$end);
		echo $result;
	}
	//end of handler

	function get_student_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$aktif = trim(@$_POST["aktif"]);
		$result=$this->m_class->get_student_list($query,$start,$end, $aktif);
		echo $result;
	}

	function detail_class_delete(){
        $dclass_id = trim(@$_POST["dclass_id"]); // Get our array back and translate it :
		$result=$this->m_class->detail_class_delete($dclass_id);
		echo $result;
    }

	//function for update record
	function class_update(){
		//POST variable here
		$class_id=trim(@$_POST["class_id"]);
		$class_name=trim(@$_POST["class_name"]);
		$class_name=str_replace("/(<\/?)(p)([^>]*>)", "",$class_name);
		$class_name=str_replace("'", '"',$class_name);
		$class_location=trim(@$_POST["class_location"]);
		$class_location=str_replace("/(<\/?)(p)([^>]*>)", "",$class_location);
		$class_location=str_replace("'", '"',$class_location);
		$class_time_start=trim(@$_POST["class_time_start"]);
		$class_time_start=str_replace("/(<\/?)(p)([^>]*>)", "",$class_time_start);
		$class_time_start=str_replace("'", '"',$class_time_start);
		$class_time_end=trim(@$_POST["class_time_end"]);
		$class_time_end=str_replace("/(<\/?)(p)([^>]*>)", "",$class_time_end);
		$class_time_end=str_replace("'", '"',$class_time_end);
		$class_capacity=trim(@$_POST["class_capacity"]);
		$class_capacity=str_replace("/(<\/?)(p)([^>]*>)", "",$class_capacity);
		$class_capacity=str_replace("'", '"',$class_capacity);
		$class_age_down=trim(@$_POST["class_age_down"]);
		$class_age_down=str_replace("/(<\/?)(p)([^>]*>)", "",$class_age_down);
		$class_age_down=str_replace("'", '"',$class_age_down);
		$class_age_up=trim(@$_POST["class_age_up"]);
		$class_age_up=str_replace("/(<\/?)(p)([^>]*>)", "",$class_age_up);
		$class_age_up=str_replace("'", '"',$class_age_up);
		$class_teacher1=trim(@$_POST["class_teacher1"]);
		$class_teacher2=trim(@$_POST["class_teacher2"]);
		$class_teacher3=trim(@$_POST["class_teacher3"]);
		$class_notes=trim(@$_POST["class_notes"]);
		$class_notes=str_replace("/(<\/?)(p)([^>]*>)", "",$class_notes);
		$class_notes=str_replace("'", '"',$class_notes);
		$class_stat=trim(@$_POST["class_stat"]);
		$class_stat=str_replace("/(<\/?)(p)([^>]*>)", "",$class_stat);
		$class_stat=str_replace("'", '"',$class_stat);
		$class_creator=trim(@$_POST["class_creator"]);
		$class_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$class_creator);
		$class_creator=str_replace("'", '"',$class_creator);
		$class_date_create=trim(@$_POST["class_date_create"]);
		$class_update=trim(@$_POST["class_update"]);
		$class_update=str_replace("/(<\/?)(p)([^>]*>)", "",$class_update);
		$class_update=str_replace("'", '"',$class_update);
		$class_date_update=trim(@$_POST["class_date_update"]);
		$class_revised=trim(@$_POST["class_revised"]);

		//Data Detail List Student Class
		$dclass_id = $_POST['dclass_id']; // Get our array back and translate it :
		$array_dclass_id = json_decode(stripslashes($dclass_id));
		
		$dclass_student = $_POST['dclass_student']; // Get our array back and translate it :
		$array_dclass_student = json_decode(stripslashes($dclass_student));
		
		$dclass_note = $_POST['dclass_note']; // Get our array back and translate it :
		$array_dclass_note = json_decode(stripslashes($dclass_note));
		
		$dclass_aktif = $_POST['dclass_aktif']; // Get our array back and translate it :
		$array_dclass_aktif = json_decode(stripslashes($dclass_aktif));

		$result = $this->m_class->class_update($class_id ,$class_name ,$class_location ,$class_time_start ,$class_time_end, $class_capacity, $class_age_down ,$class_age_up , $class_teacher1, $class_teacher2, $class_teacher3, $class_notes ,$class_stat ,$class_creator ,$class_date_create ,$class_update ,$class_date_update ,$class_revised, 
			$array_dclass_id, $array_dclass_student, $array_dclass_note, $array_dclass_aktif );
		echo $result;
	}
	
	//function for create new record
	function class_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$class_name=trim(@$_POST["class_name"]);
		$class_name=str_replace("/(<\/?)(p)([^>]*>)", "",$class_name);
		$class_name=str_replace("'", '"',$class_name);
		$class_location=trim(@$_POST["class_location"]);
		$class_location=str_replace("/(<\/?)(p)([^>]*>)", "",$class_location);
		$class_location=str_replace("'", '"',$class_location);
		$class_time_start=trim(@$_POST["class_time_start"]);
		$class_time_start=str_replace("/(<\/?)(p)([^>]*>)", "",$class_time_start);
		$class_time_start=str_replace("'", '"',$class_time_start);
		$class_time_end=trim(@$_POST["class_time_end"]);
		$class_time_end=str_replace("/(<\/?)(p)([^>]*>)", "",$class_time_end);
		$class_time_end=str_replace("'", '"',$class_time_end);
		$class_capacity=trim(@$_POST["class_capacity"]);
		$class_capacity=str_replace("/(<\/?)(p)([^>]*>)", "",$class_capacity);
		$class_capacity=str_replace("'", '"',$class_capacity);
		$class_age_down=trim(@$_POST["class_age_down"]);
		$class_age_down=str_replace("/(<\/?)(p)([^>]*>)", "",$class_age_down);
		$class_age_down=str_replace("'", '"',$class_age_down);
		$class_age_up=trim(@$_POST["class_age_up"]);
		$class_age_up=str_replace("/(<\/?)(p)([^>]*>)", "",$class_age_up);
		$class_age_up=str_replace("'", '"',$class_age_up);
		$class_teacher1=trim(@$_POST["class_teacher1"]);
		$class_teacher2=trim(@$_POST["class_teacher2"]);
		$class_teacher3=trim(@$_POST["class_teacher3"]);
		$class_notes=trim(@$_POST["class_notes"]);
		$class_notes=str_replace("/(<\/?)(p)([^>]*>)", "",$class_notes);
		$class_notes=str_replace("'", '"',$class_notes);
		$class_stat=trim(@$_POST["class_stat"]);
		$class_stat=str_replace("/(<\/?)(p)([^>]*>)", "",$class_stat);
		$class_stat=str_replace("'", '"',$class_stat);
		$class_creator=trim(@$_POST["class_creator"]);
		$class_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$class_creator);
		$class_creator=str_replace("'", '"',$class_creator);
		$class_date_create=trim(@$_POST["class_date_create"]);
		$class_update=trim(@$_POST["class_update"]);
		$class_update=str_replace("/(<\/?)(p)([^>]*>)", "",$class_update);
		$class_update=str_replace("'", '"',$class_update);
		$class_date_update=trim(@$_POST["class_date_update"]);
		$class_revised=trim(@$_POST["class_revised"]);

		//Data Detail List Student Class
		$dclass_id = $_POST['dclass_id']; // Get our array back and translate it :
		$array_dclass_id = json_decode(stripslashes($dclass_id));
		
		$dclass_student = $_POST['dclass_student']; // Get our array back and translate it :
		$array_dclass_student = json_decode(stripslashes($dclass_student));
		
		$dclass_note = $_POST['dclass_note']; // Get our array back and translate it :
		$array_dclass_note = json_decode(stripslashes($dclass_note));
		
		$dclass_aktif = $_POST['dclass_aktif']; // Get our array back and translate it :
		$array_dclass_aktif = json_decode(stripslashes($dclass_aktif));
		
		$result=$this->m_class->class_create($class_name ,$class_location ,$class_time_start ,$class_time_end ,$class_capacity ,$class_age_down ,$class_age_up , $class_teacher1, $class_teacher2, $class_teacher3, $class_notes ,$class_stat ,$class_creator ,$class_date_create ,$class_update ,$class_date_update ,$class_revised, 
			$array_dclass_id, $array_dclass_student, $array_dclass_note, $array_dclass_aktif );
		echo $result;
	}

	//function for delete selected record
	function class_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_class->class_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function class_search(){
		//POST varibale here
		$class_id=trim(@$_POST["class_id"]);
		$class_name=trim(@$_POST["class_name"]);
		$class_name=str_replace("/(<\/?)(p)([^>]*>)", "",$class_name);
		$class_name=str_replace("'", '"',$class_name);
		$class_location=trim(@$_POST["class_location"]);
		$class_location=str_replace("/(<\/?)(p)([^>]*>)", "",$class_location);
		$class_location=str_replace("'", '"',$class_location);
		$class_time_start=trim(@$_POST["class_time_start"]);
		$class_time_start=str_replace("/(<\/?)(p)([^>]*>)", "",$class_time_start);
		$class_time_start=str_replace("'", '"',$class_time_start);
		$class_time_end=trim(@$_POST["class_time_end"]);
		$class_time_end=str_replace("/(<\/?)(p)([^>]*>)", "",$class_time_end);
		$class_time_end=str_replace("'", '"',$class_time_end);
		$class_capacity=trim(@$_POST["class_capacity"]);
		$class_capacity=str_replace("/(<\/?)(p)([^>]*>)", "",$class_capacity);
		$class_capacity=str_replace("'", '"',$class_capacity);
		$class_age_down=trim(@$_POST["class_age_down"]);
		$class_age_down=str_replace("/(<\/?)(p)([^>]*>)", "",$class_age_down);
		$class_age_down=str_replace("'", '"',$class_age_down);
		$class_age_up=trim(@$_POST["class_age_up"]);
		$class_age_up=str_replace("/(<\/?)(p)([^>]*>)", "",$class_age_up);
		$class_age_up=str_replace("'", '"',$class_age_up);
		$class_teacher1=trim(@$_POST["class_teacher1"]);
		$class_teacher2=trim(@$_POST["class_teacher2"]);
		$class_teacher3=trim(@$_POST["class_teacher3"]);
		$class_notes=trim(@$_POST["class_notes"]);
		$class_notes=str_replace("/(<\/?)(p)([^>]*>)", "",$class_notes);
		$class_notes=str_replace("'", '"',$class_notes);
		$class_stat=trim(@$_POST["class_stat"]);
		$class_stat=str_replace("/(<\/?)(p)([^>]*>)", "",$class_stat);
		$class_stat=str_replace("'", '"',$class_stat);
		$class_creator=trim(@$_POST["class_creator"]);
		$class_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$class_creator);
		$class_creator=str_replace("'", '"',$class_creator);
		$class_date_create=trim(@$_POST["class_date_create"]);
		$class_update=trim(@$_POST["class_update"]);
		$class_update=str_replace("/(<\/?)(p)([^>]*>)", "",$class_update);
		$class_update=str_replace("'", '"',$class_update);
		$class_date_update=trim(@$_POST["class_date_update"]);
		$class_revised=trim(@$_POST["class_revised"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_class->class_search($class_id ,$class_name ,$class_location ,$class_time_start ,$class_time_end ,$class_capacity ,$class_age_down ,$class_age_up ,  $class_notes ,$class_stat ,$class_creator ,$class_date_create ,$class_update ,$class_date_update ,$class_revised ,$start,$end);
		echo $result;
	}


	function class_print(){
  		//POST varibale here
		$class_id=trim(@$_POST["class_id"]);
		$class_name=trim(@$_POST["class_name"]);
		$class_name=str_replace("/(<\/?)(p)([^>]*>)", "",$class_name);
		$class_name=str_replace("'", '"',$class_name);
		$class_location=trim(@$_POST["class_location"]);
		$class_location=str_replace("/(<\/?)(p)([^>]*>)", "",$class_location);
		$class_location=str_replace("'", '"',$class_location);
		$class_notes=trim(@$_POST["class_notes"]);
		$class_notes=str_replace("/(<\/?)(p)([^>]*>)", "",$class_notes);
		$class_notes=str_replace("'", '"',$class_notes);
		$class_stat=trim(@$_POST["class_stat"]);
		$class_stat=str_replace("/(<\/?)(p)([^>]*>)", "",$class_stat);
		$class_stat=str_replace("'", '"',$class_stat);
		$class_creator=trim(@$_POST["class_creator"]);
		$class_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$class_creator);
		$class_creator=str_replace("'", '"',$class_creator);
		$class_date_create=trim(@$_POST["class_date_create"]);
		$class_update=trim(@$_POST["class_update"]);
		$class_update=str_replace("/(<\/?)(p)([^>]*>)", "",$class_update);
		$class_update=str_replace("'", '"',$class_update);
		$class_date_update=trim(@$_POST["class_date_update"]);
		$class_revised=trim(@$_POST["class_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_class->class_print($class_id ,$class_name ,$class_location ,$class_notes ,$class_stat ,$class_creator ,$class_date_create ,$class_update ,$class_date_update ,$class_revised ,$option,$filter);
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
				fwrite($file, $data['class_name']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['class_location']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['class_notes']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['class_stat']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function class_export_excel(){
		//POST varibale here
		$class_id=trim(@$_POST["class_id"]);
		$class_name=trim(@$_POST["class_name"]);
		$class_name=str_replace("/(<\/?)(p)([^>]*>)", "",$class_name);
		$class_name=str_replace("'", '"',$class_name);
		$class_location=trim(@$_POST["class_location"]);
		$class_location=str_replace("/(<\/?)(p)([^>]*>)", "",$class_location);
		$class_location=str_replace("'", '"',$class_location);
		$class_notes=trim(@$_POST["class_notes"]);
		$class_notes=str_replace("/(<\/?)(p)([^>]*>)", "",$class_notes);
		$class_notes=str_replace("'", '"',$class_notes);
		$class_stat=trim(@$_POST["class_stat"]);
		$class_stat=str_replace("/(<\/?)(p)([^>]*>)", "",$class_stat);
		$class_stat=str_replace("'", '"',$class_stat);
		$class_creator=trim(@$_POST["class_creator"]);
		$class_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$class_creator);
		$class_creator=str_replace("'", '"',$class_creator);
		$class_date_create=trim(@$_POST["class_date_create"]);
		$class_update=trim(@$_POST["class_update"]);
		$class_update=str_replace("/(<\/?)(p)([^>]*>)", "",$class_update);
		$class_update=str_replace("'", '"',$class_update);
		$class_date_update=trim(@$_POST["class_date_update"]);
		$class_revised=trim(@$_POST["class_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_class->class_export_excel($class_id ,$class_name ,$class_location ,$class_notes ,$class_stat ,$class_creator ,$class_date_create ,$class_update ,$class_date_update ,$class_revised ,$option,$filter);
		
		to_excel($query,"gudang"); 
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