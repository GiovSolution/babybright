<?php
/* 	
	GIOV Solution - Keep IT Simple
*/

//class of anamnesa
class C_lesson_report extends Controller {

	//constructor
	function C_lesson_report(){
		parent::Controller();
		session_start();
		$this->load->model('m_lesson_report', '', TRUE);
		
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_lesson_report');
	}

	function get_student_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$selected_id = isset($_POST['selected_id']) ? @$_POST['selected_id'] : @$_GET['selected_id'];
		$class_id = isset($_POST['class_id']) ? @$_POST['class_id'] : @$_GET['class_id'];
		if($task=='list')
			$result=$this->m_lesson_report->get_student_all_list($query,$start,$end);
		elseif($task=='order')
			$result=$this->m_lesson_report->get_student_order_list($class_id,$query,$start,$end);
		echo $result;
	}


	function  get_class(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		
		$result=$this->m_lesson_report->get_class($query,$start,$end);
		echo $result;
	}
	
	function  get_petugas(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		
		$result=$this->m_lesson_report->get_petugas($query,$start,$end);
		echo $result;
	}

	function get_student_by_class_id(){
		$orderid = isset($_POST['orderid']) ? @$_POST['orderid'] : "";
		$result=$this->m_lesson_report->get_student_by_class_id($orderid);
		echo $result;
	}
	
	//for detail action
	//list detail handler action
	function  detail_lr(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_lesson_report->detail_lr($master_id,$query,$start,$end);
		echo $result;
	}
	//end of handler
	
	//purge all detail
	function detail_anamnesa_problem_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		$result=$this->m_lesson_report->detail_anamnesa_problem_purge($master_id);
	}
	//eof
	
	function get_subject_list(){
		$day = isset($_POST['day']) ? $_POST['day'] : "";
		$week = isset($_POST['week']) ? $_POST['week'] : "";
		$lesson_plan = isset($_POST['lesson_plan']) ? $_POST['lesson_plan'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_lesson_report->get_subject_list($day,$week,$lesson_plan,$start,$end);
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
		
  		$result=$this->m_lesson_report->detail_anamnesa_problem_insert($panam_id ,$panam_master ,$panam_problem ,$panam_lamaproblem ,$panam_aksiproblem ,
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
				$this->lr_update();
				break;
			case "CREATE":
				$this->lr_create();
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
		$result=$this->m_lesson_report->lr_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function lr_update(){
		//POST variable here
		$lr_id=trim(@$_POST["lr_id"]);
		$lr_class=trim(@$_POST["lr_class"]);
		$lr_tanggal=trim(@$_POST["lr_tanggal"]);

		$lr_period=trim(@$_POST["lr_period"]);
		$lr_period=str_replace("/(<\/?)(p)([^>]*>)", "",$lr_period);
		$lr_period=str_replace("'", '"',$lr_period);

		$lr_theme=trim(@$_POST["lr_theme"]);
		$lr_theme=str_replace("/(<\/?)(p)([^>]*>)", "",$lr_theme);
		$lr_theme=str_replace("'", '"',$lr_theme);

		$lr_subtheme=trim(@$_POST["lr_subtheme"]);
		$lr_subtheme=str_replace("/(<\/?)(p)([^>]*>)", "",$lr_subtheme);
		$lr_subtheme=str_replace("'", '"',$lr_subtheme);

		$lr_ld=trim(@$_POST["lr_ld"]);
		$lr_ld=str_replace("/(<\/?)(p)([^>]*>)", "",$lr_ld);
		$lr_ld=str_replace("'", '"',$lr_ld);

		$lr_sed=trim(@$_POST["lr_sed"]);
		$lr_sed=str_replace("/(<\/?)(p)([^>]*>)", "",$lr_sed);
		$lr_sed=str_replace("'", '"',$lr_sed);

		$lr_pd=trim(@$_POST["lr_pd"]);
		$lr_pd=str_replace("/(<\/?)(p)([^>]*>)", "",$lr_pd);
		$lr_pd=str_replace("'", '"',$lr_pd);

		$lr_cb=trim(@$_POST["lr_cb"]);
		$lr_cb=str_replace("/(<\/?)(p)([^>]*>)", "",$lr_cb);
		$lr_cb=str_replace("'", '"',$lr_cb);

		$lr_m=trim(@$_POST["lr_m"]);
		$lr_m=str_replace("/(<\/?)(p)([^>]*>)", "",$lr_m);
		$lr_m=str_replace("'", '"',$lr_m);
		
		// detail lr
		$dlr_id = $_POST['dlr_id'];
		$array_dlr_id = json_decode(stripslashes($dlr_id));
		
		$dlr_master=trim(@$_POST["dlr_master"]);

		$dlr_student=trim(@$_POST["dlr_student"]);
		$array_dlr_student = json_decode(stripslashes($dlr_student));
		
		$dlr_report_ld = $_POST['dlr_report_ld'];
		$array_dlr_report_ld = json_decode(stripslashes($dlr_report_ld));

		$dlr_report_sed = $_POST['dlr_report_sed'];
		$array_dlr_report_sed = json_decode(stripslashes($dlr_report_sed));

		$dlr_report_pd = $_POST['dlr_report_pd'];
		$array_dlr_report_pd = json_decode(stripslashes($dlr_report_pd));

		$dlr_report_cb = $_POST['dlr_report_cb'];
		$array_dlr_report_cb = json_decode(stripslashes($dlr_report_cb));

		$dlr_report_m = $_POST['dlr_report_m'];
		$array_dlr_report_m = json_decode(stripslashes($dlr_report_m));

		$result = $this->m_lesson_report->lr_update($lr_id ,$lr_class ,
					$lr_tanggal ,
					$lr_period ,
					$lr_theme ,
					$lr_subtheme ,
					$lr_ld ,
					$lr_sed ,
					$lr_pd ,
					$lr_cb ,
					$lr_m,
					$array_dlr_id, 
					$array_dlr_student, 
					$array_dlr_report_ld,
					$array_dlr_report_sed,
					$array_dlr_report_pd,
					$array_dlr_report_cb,
					$array_dlr_report_m
					);
		echo $result;
	}
	
	//function for create new record
	function lr_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$lr_class=trim(@$_POST["lr_class"]);
		$lr_lesson_plan=trim(@$_POST["lr_lesson_plan"]);
		$lr_tanggal=trim(@$_POST["lr_tanggal"]);

		$lr_period=trim(@$_POST["lr_period"]);
		$lr_period=str_replace("/(<\/?)(p)([^>]*>)", "",$lr_period);
		$lr_period=str_replace("'", '"',$lr_period);

		$lr_theme=trim(@$_POST["lr_theme"]);
		$lr_theme=str_replace("/(<\/?)(p)([^>]*>)", "",$lr_theme);
		$lr_theme=str_replace("'", '"',$lr_theme);

		$lr_subtheme=trim(@$_POST["lr_subtheme"]);
		$lr_subtheme=str_replace("/(<\/?)(p)([^>]*>)", "",$lr_subtheme);
		$lr_subtheme=str_replace("'", '"',$lr_subtheme);

		$lr_ld=trim(@$_POST["lr_ld"]);
		$lr_ld=str_replace("/(<\/?)(p)([^>]*>)", "",$lr_ld);
		$lr_ld=str_replace("'", '"',$lr_ld);

		$lr_sed=trim(@$_POST["lr_sed"]);
		$lr_sed=str_replace("/(<\/?)(p)([^>]*>)", "",$lr_sed);
		$lr_sed=str_replace("'", '"',$lr_sed);

		$lr_pd=trim(@$_POST["lr_pd"]);
		$lr_pd=str_replace("/(<\/?)(p)([^>]*>)", "",$lr_pd);
		$lr_pd=str_replace("'", '"',$lr_pd);

		$lr_cb=trim(@$_POST["lr_cb"]);
		$lr_cb=str_replace("/(<\/?)(p)([^>]*>)", "",$lr_cb);
		$lr_cb=str_replace("'", '"',$lr_cb);

		$lr_m=trim(@$_POST["lr_m"]);
		$lr_m=str_replace("/(<\/?)(p)([^>]*	>)", "",$lr_m);
		$lr_m=str_replace("'", '"',$lr_m);
		// detail lr
		$dlr_id = $_POST['dlr_id'];
		$array_dlr_id = json_decode(stripslashes($dlr_id));
		
		$dlr_master=trim(@$_POST["dlr_master"]);

		$dlr_student=trim(@$_POST["dlr_student"]);
		$array_dlr_student = json_decode(stripslashes($dlr_student));
		
		$dlr_report_ld = $_POST['dlr_report_ld'];
		$array_dlr_report_ld = json_decode(stripslashes($dlr_report_ld));

		$dlr_report_sed = $_POST['dlr_report_sed'];
		$array_dlr_report_sed = json_decode(stripslashes($dlr_report_sed));

		$dlr_report_pd = $_POST['dlr_report_pd'];
		$array_dlr_report_pd = json_decode(stripslashes($dlr_report_pd));

		$dlr_report_cb = $_POST['dlr_report_cb'];
		$array_dlr_report_cb = json_decode(stripslashes($dlr_report_cb));

		$dlr_report_m = $_POST['dlr_report_m'];
		$array_dlr_report_m = json_decode(stripslashes($dlr_report_m));

		$result=$this->m_lesson_report->lr_create($lr_class, $lr_lesson_plan, 
						$lr_tanggal ,
						$lr_period ,
						$lr_theme ,
						$lr_subtheme ,
						$lr_ld ,
						$lr_sed ,
						$lr_pd ,
						$lr_cb ,
						$lr_m, 
						$array_dlr_id, 
						$array_dlr_student, 
						$array_dlr_report_ld,
						$array_dlr_report_sed,
						$array_dlr_report_pd,
						$array_dlr_report_cb,
						$array_dlr_report_m
						);
		echo $result;
	}

	function print_only(){
  		//POST varibale here
		$jproduk_id=trim(@$_POST["jproduk_id"]);
		
		$result = $this->m_lesson_report->print_paper($jproduk_id);
		//$iklan = $this->m_master_jual_produk->iklan();
		$rs=$result->row();
		//$rsiklan=$iklan->row();
		$detail_jproduk=$result->result();
		
		//$array_cara_bayar = $this->m_master_jual_produk->get_cara_bayar($jproduk_id);
		
		//$cara_bayar=$this->m_master_jual_produk->cara_bayar($jproduk_id);
		//$cara_bayar2=$this->m_master_jual_produk->cara_bayar2($jproduk_id);
		//$cara_bayar3=$this->m_master_jual_produk->cara_bayar3($jproduk_id);

		$data['lr_period']=$rs->lr_period;
		$data['lr_theme']=$rs->lr_theme;
		$data['lr_subtheme']=$rs->lr_subtheme;
		$data['lr_ld']=$rs->lr_ld;
		$data['lr_sed']=$rs->lr_sed;
		$data['lr_pd']=$rs->lr_pd;
		$data['lr_cb']=$rs->lr_cb;
		$data['lr_m']=$rs->lr_m;
		$data['class_name']=$rs->class_name;
		//$data['jproduk_tanggal']=date('d-m-Y', strtotime($rs->jproduk_tanggal));
		$data['cust_nama']=$rs->cust_nama;
		/*$data['cust_nama']=$rs->cust_nama;
		$data['iklantoday_keterangan']=$rsiklan->iklantoday_keterangan;
		$data['cust_alamat']=$rs->cust_alamat;
		$data['jumlah_subtotal']=ubah_rupiah($rs->jumlah_subtotal);
		$data['jumlah_bayar']=$rs->jproduk_bayar;
		$data['jproduk_diskon']=$rs->jproduk_diskon;
		$data['jproduk_cashback']=$rs->jproduk_cashback;
		$data['jproduk_creator']=$rs->jproduk_creator;
		*/
		$data['detail_jproduk']=$detail_jproduk;
		/*
		if($cara_bayar!==NULL){
			$data['cara_bayar1']=$cara_bayar->jproduk_cara;
			$data['nilai_bayar1']=$cara_bayar->bayar_nilai;
		}else{
			$data['cara_bayar1']="";
			$data['bayar_nilai1']="";
		}
		
		if($cara_bayar2!==NULL){
			$data['cara_bayar2']=$cara_bayar2->jproduk_cara2;
			$data['nilai_bayar2']=$cara_bayar2->bayar2_nilai;
		}else{
			$data['cara_bayar2']="";
			$data['nilai_bayar2']="";
		}
		
		if($cara_bayar3!==NULL){
			$data['cara_bayar3']=$cara_bayar3->jproduk_cara3;
			$data['nilai_bayar3']=$cara_bayar3->bayar3_nilai;
		}else{
			$data['cara_bayar3']="";
			$data['nilai_bayar3']="";
		}
		*/
			
		$viewdata=$this->load->view("main/report_formcetak",$data,TRUE);
		$file = fopen("report_cetak.html",'w');
		fwrite($file, $viewdata);	
		fclose($file);
		echo '1';        
	}

	//function for delete selected record
	function anamnesa_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_lesson_report->anamnesa_delete($pkid);
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
		
		$result = $this->m_lesson_report->anamnesa_search($anam_id ,$anam_cust ,$anam_tanggal ,$anam_petugas ,$anam_pengobatan ,$anam_perawatan ,
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
		
		$result = $this->m_lesson_report->anamnesa_print($anam_id ,$anam_cust ,$anam_tanggal ,$anam_petugas ,$anam_pengobatan ,$anam_perawatan ,
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
		
		$query = $this->m_lesson_report->anamnesa_export_excel($anam_id ,$anam_cust ,$anam_tanggal ,$anam_petugas ,$anam_pengobatan ,$anam_perawatan ,
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