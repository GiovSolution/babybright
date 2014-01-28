<? /* 
	GIOV Solution - Keep IT Simple
*/

class M_lesson_report extends Model{
		
		//constructor
		function M_lesson_report() {
			parent::Model();
		}
		
		function get_student_by_class_id($orderid){
			$sql="select cust_id from class_students
					left join class on class.class_id = class_students.dclass_master
					left join customer on customer.cust_id = class_students.dclass_student
				 	where class.class_id = '".$orderid."'";
					
			$query = $this->db->query($sql);
			$nbrows = $query->num_rows();
			if($nbrows>0){
				foreach($query->result() as $row){
					$arr[] = $row;
				}
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}

		function get_student_all_list($query,$start,$end){

			$sql="SELECT * from class_students
					left join customer on customer.cust_id = class_students.dclass_student";
			/*
			if($query!==""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_nama like '%".$query."%' OR produk_kode like '%".$query."%'";
			}
			*/

			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();

			if($nbrows>0){
				foreach($result->result() as $row){
					$arr[] = $row;
				}
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}

		function get_student_order_list($class_id,$query,$start,$end){
			$sql="SELECT cust_id, cust_nama FROM customer";
			if($class_id<>"")
				$sql.=" WHERE cust_id IN(SELECT dclass_student FROM class_students WHERE dclass_master='".$class_id."')";

			if($query!==""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_nama like '%".$query."%' OR produk_kode like '%".$query."%'";
			}

			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();

			if($nbrows>0){
				foreach($result->result() as $row){
					$arr[] = $row;
				}
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}

		//function for detail
		//get record list
		function detail_lr($master_id,$query,$start,$end) {
			$query = "SELECT * FROM detail_lr where dlr_master='".$master_id."'";
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			$limit = $query." LIMIT ".$start.",".$end;			
			$result = $this->db->query($limit);  
			
			if($nbrows>0){
				foreach($result->result() as $row){
					$arr[] = $row;
				}
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}
		//end of function
		
		function get_subject_list($day,$week,$lesson_plan,$start,$end){
		
		$lesplan_id=0;
		/*
		$sql="SELECT dplan_daily_schedule FROM detail_lesson_plan WHERE dplan_master='".$lesson_plan."'";
		$result=$this->db->query($sql);
		if($result->num_rows()){
			$format_lesson_plan = 'dplan_week'.$week.'_'.$day;
			$sql="SELECT $format_lesson_plan as subject, dplan_daily_schedule FROM detail_lesson_plan WHERE dplan_master='".$lesson_plan."'";	
		}
		else {
			$sql_lp="SELECT lesplan_id FROM master_lesson_plan WHERE lesplan_code='".$lesson_plan."'";
			$result_lp=$this->db->query($sql_lp);
			$data_lp= $result_lp->row();
			$lesplan_id= $data_lp->lesplan_id;
			
			$format_lesson_plan = 'dplan_week'.$week.'_'.$day;
			$sql="SELECT $format_lesson_plan as subject, dplan_daily_schedule FROM detail_lesson_plan WHERE dplan_master='".$lesplan_id."'";
		}
		*/
		$sql="SELECT * FROM detail_lesson_plan
			LEFT JOIN master_lesson_plan ON master_lesson_plan.lesplan_id = detail_lesson_plan.dlesplan_master
			WHERE master_lesson_plan.lesplan_day = '".$day."' AND
			master_lesson_plan.lesplan_week = '".$week."' AND
			detail_lesson_plan.dlesplan_master = '".$lesson_plan."'";	
		$result = $this->db->query($sql);
		$nbrows = $result->num_rows();
		if($end!=0){
			$limit = $sql." LIMIT ".$start.",".$end;			
			$result = $this->db->query($limit);
		}
		if($nbrows>0){
			foreach($result->result() as $row){
				$arr[] = $row;
			}
			$jsonresult = json_encode($arr);
			return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
		} else {
			return '({"total":"0", "results":""})';
		}
	}

	
	//get master id, note : not done yet
	function get_master_id() {
		$query = "SELECT max(lr_id) AS master_id FROM lesson_report";
		$result = $this->db->query($query);
		if($result->num_rows()){
			$data=$result->row();
			$master_id=$data->master_id;
			return $master_id;
		}else{
			return '0';
		}
	}
	//eof

	function get_class($filter,$start,$end){
			/*
			$query = "SELECT karyawan_id,karyawan_nama,jabatan_nama FROM karyawan,jabatan 
						WHERE karyawan_jabatan=jabatan_id AND 
						(jabatan_nama='Dokter' OR jabatan_nama='Suster' OR jabatan_nama='Therapist') ";
			*/
			if($_SESSION[SESSION_GROUPID]=='1'){
				$query = "SELECT * FROM class";
			} else {
				$query_karyawan = "SELECT * FROM users WHERE users.user_name = '".$_SESSION[SESSION_USERID]."'";
				$query_sql_karyawan= $this->db->query($query_karyawan);
				$data_sql_karyawan= $query_sql_karyawan->row();
				$user_karyawan= $data_sql_karyawan->user_karyawan;
				
				// $query = "SELECT * FROM master_lesson_plan WHERE master_lesson_plan.lesplan_teacher='".$user_karyawan."'";
				$query = "SELECT * FROM class WHERE class.class_teacher1='".$user_karyawan."' 
				OR class.class_teacher2='".$user_karyawan."' OR class.class_teacher3 = '".$user_karyawan."'";
			}
			
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (class_name LIKE '%".addslashes($filter)."%'";
			}
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			$limit = $query." LIMIT ".$start.",".$end;			
			$result = $this->db->query($limit);  
			
			if($nbrows>0){
				foreach($result->result() as $row){
					$arr[] = $row;
				}
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
			
		}
		
		function get_petugas($filter,$start,$end){
			/*
			$query = "SELECT karyawan_id,karyawan_nama,jabatan_nama FROM karyawan,jabatan 
						WHERE karyawan_jabatan=jabatan_id AND 
						(jabatan_nama='Dokter' OR jabatan_nama='Suster' OR jabatan_nama='Therapist') ";
			*/
			if($_SESSION[SESSION_GROUPID]=='1'){
				$query = "SELECT * FROM master_lesson_plan";
			} else {
				$query_karyawan = "SELECT * FROM users WHERE users.user_name = '".$_SESSION[SESSION_USERID]."'";
				$query_sql_karyawan= $this->db->query($query_karyawan);
				$data_sql_karyawan= $query_sql_karyawan->row();
				$user_karyawan= $data_sql_karyawan->user_karyawan;
				
				$query = "SELECT * FROM master_lesson_plan WHERE master_lesson_plan.lesplan_teacher='".$user_karyawan."'";
			}
			
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (lesplan_theme LIKE '%".addslashes($filter)."%' OR 
							(lesplan_subtheme LIKE '%".addslashes($filter)."%' OR 
							 lesplan_code LIKE '%".addslashes($filter)."%')";
			}
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			$limit = $query." LIMIT ".$start.",".$end;			
			$result = $this->db->query($limit);  
			
			if($nbrows>0){
				foreach($result->result() as $row){
					$arr[] = $row;
				}
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
			
		}
		
				
		//insert detail record
		function detail_anamnesa_problem_insert($panam_id ,$panam_master ,$panam_problem ,$panam_lamaproblem ,$panam_aksiproblem ,$panam_aksiket ){
				
			$query="";
		   	for($i = 0; $i < sizeof($panam_id); $i++){

				$data = array(
					"panam_master"=>$panam_master, 
					"panam_problem"=>$panam_problem[$i], 
					"panam_lamaproblem"=>$panam_lamaproblem[$i], 
					"panam_aksiproblem"=>$panam_aksiproblem[$i], 
					"panam_aksiket"=>$panam_aksiket[$i]
				);

				if($panam_id[$i]==0){
					$this->db->insert('anamnesa_problem', $data); 
					
					$query = $query.$this->db->insert_id();
					if($i<sizeof($panam_id)-1){
						$query = $query . ",";
					} 
					
				}else{
					$query = $query.$panam_id[$i];
					if($i<sizeof($panam_id)-1){
						$query = $query . ",";
					} 
					$this->db->where('panam_id', $panam_id[$i]);
					$this->db->update('anamnesa_problem', $data);
				}
			}
			
			if($query<>""){
				$sql="DELETE FROM anamnesa_problem WHERE  panam_master='".$panam_master."' AND
						panam_id NOT IN (".$query.")";
				$this->db->query($sql);
			}
			
			return '1';

		}
		//end of function
		
		//function for get list record
		function lr_list($filter,$start,$end){
		if($_SESSION[SESSION_GROUPID]=='1'){
			$query = "SELECT * FROM lesson_report
						LEFT JOIN class ON class.class_id = lesson_report.lr_class
						ORDER BY lr_id DESC";
		} else {
			$query_karyawan = "SELECT * FROM users WHERE users.user_name = '".$_SESSION[SESSION_USERID]."'";
			$query_sql_karyawan= $this->db->query($query_karyawan);
			$data_sql_karyawan= $query_sql_karyawan->row();
			$user_karyawan= $data_sql_karyawan->user_karyawan;
			
			$query = "SELECT * FROM lesson_report
						LEFT JOIN class ON class.class_id = lesson_report.lr_class";
		}
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (cust_nama LIKE '%".addslashes($filter)."%' OR 
							 karyawan_nama LIKE '%".addslashes($filter)."%' OR 
							 anam_alergi LIKE '%".addslashes($filter)."%' OR 
							 anam_obatalergi LIKE '%".addslashes($filter)."%'  )";
			}
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			$limit = $query." LIMIT ".$start.",".$end;		
			$result = $this->db->query($limit);  
			
			if($nbrows>0){
				foreach($result->result() as $row){
					$arr[] = $row;
				}
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}
		
		
		// Function untuk insert Detail Lesson Report
		function detail_lesson_plan_insert(
					$temp_lr_id, 
					$array_dlr_id, 
					$array_dlr_student, 
					$array_dlr_report_ld,
					$array_dlr_report_sed,
					$array_dlr_report_pd,
					$array_dlr_report_cb,
					$array_dlr_report_m
					){
		$datetime_now = date('Y-m-d H:i:s');

		if($temp_lr_id=="" || $temp_lr_id==NULL || $temp_lr_id==0){
		 		$temp_lr_id=$this->get_master_id();
		}
		
		$size_array = sizeof($array_dlr_student) - 1;
			for($i = 0; $i < sizeof($array_dlr_student); $i++){
				echo $array_dlr_id[$i];
				$dlr_id = $array_dlr_id[$i];
				$dlr_master = $temp_lr_id;
				$dlr_student = $array_dlr_student[$i];
				$dlr_report_ld = $array_dlr_report_ld[$i];
				$dlr_report_sed = $array_dlr_report_sed[$i];
				$dlr_report_pd = $array_dlr_report_pd[$i];
				$dlr_report_cb = $array_dlr_report_cb[$i];
				$dlr_report_m = $array_dlr_report_m[$i];

	
				$sql = "SELECT dlr_id
					FROM detail_lr
					WHERE dlr_id='".$dlr_id."'";
				$rs = $this->db->query($sql);
				
				if($rs->num_rows()){
				// jika datanya sudah ada maka update saja
					$dtu_detail_lesson_report = array(
						"dlr_master"=>$dlr_master,
						"dlr_student"=>$dlr_student,
						"dlr_report_ld"=>$dlr_report_ld,
						"dlr_report_sed"=>$dlr_report_sed,
						"dlr_report_pd"=>$dlr_report_pd,
						"dlr_report_cb"=>$dlr_report_cb,
						"dlr_report_m"=>$dlr_report_m,
						"dlr_creator"=>$_SESSION[SESSION_USERID],
						"dlr_date_update"=>$datetime_now
					);
					$this->db->where('dlr_id', $dlr_id);
					$this->db->update('detail_lr', $dtu_detail_lesson_report); 
				}else {
					$data = array(
						"dlr_master"=>$dlr_master,
						"dlr_student"=>$dlr_student,
						"dlr_report_ld"=>$dlr_report_ld,
						"dlr_report_sed"=>$dlr_report_sed,
						"dlr_report_pd"=>$dlr_report_pd,
						"dlr_report_cb"=>$dlr_report_cb,
						"dlr_report_m"=>$dlr_report_m,
						"dlr_update"=>$_SESSION[SESSION_USERID],
						"dlr_date_create"=>$datetime_now
					);
					$this->db->insert('detail_lr', $data); 	
				}	
		}

		return '1';
	}
		
		//function for update record
		function lr_update($lr_id ,$lr_class ,
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
					){
			$data = array(
				"lr_id"=>$lr_id, 
				"lr_tanggal"=>$lr_tanggal, 
				"lr_class"=>$lr_class, 
				"lr_period"=>$lr_period, 
				"lr_theme"=>$lr_theme, 
				"lr_subtheme"=>$lr_subtheme, 
				"lr_ld"=>$lr_ld, 
				"lr_sed"=>$lr_sed, 
				"lr_pd"=>$lr_pd, 
				"lr_cb"=>$lr_cb, 
				"lr_m"=>$lr_m, 
				"lr_update"=>$_SESSION[SESSION_USERID],			
				"lr_date_update"=>date('Y-m-d H:i:s')
			);
			// Cara untuk mengakali combobox yang pny datastore sendiri
			/*
			$sql="SELECT cust_id FROM customer WHERE cust_id='".$lr_cust."'";
				$result=$this->db->query($sql);
				if($result->num_rows())
					$data["lr_customer"]=$lr_cust;
			*/
					
			$this->db->where('lr_id', $lr_id);
			$this->db->update('lesson_report', $data);
			
			$temp_lr_id = $lr_id;
			$temp_dlr_ins = $this->detail_lesson_plan_insert(
						$temp_lr_id, 
						$array_dlr_id, 
						$array_dlr_student, 
						$array_dlr_report_ld,
						$array_dlr_report_sed,
						$array_dlr_report_pd,
						$array_dlr_report_cb,
						$array_dlr_report_m);
			
			if($this->db->affected_rows()){
				$sql="UPDATE lesson_report set lr_revised=(lr_revised+1) WHERE lr_id='".$lr_id."'";
				$this->db->query($sql);
			}
			
			return $lr_id;
		}
		
		//function for create new record
		function lr_create($lr_class, $lr_lesson_plan, 
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
						){
			$lr_tanggal_pattern=strtotime($lr_tanggal);
			$pattern="LR/".date("ym",$lr_tanggal_pattern)."-";
			$lr_code=$this->m_public_function->get_kode_1('lesson_report','lr_code',$pattern,12);
			
			$data = array(
				//"lr_customer"=>$lr_cust, 
				//"lr_lesson_plan"=>$lr_lesson_plan, 
				"lr_code"=>$lr_code, 
				"lr_tanggal"=>$lr_tanggal, 
				"lr_class"=>$lr_class, 
				"lr_period"=>$lr_period, 
				"lr_theme"=>$lr_theme, 
				"lr_subtheme"=>$lr_subtheme, 
				"lr_ld"=>$lr_ld, 
				"lr_sed"=>$lr_sed, 
				"lr_pd"=>$lr_pd, 
				"lr_cb"=>$lr_cb, 
				"lr_m"=>$lr_m, 
				"lr_creator"=>$_SESSION[SESSION_USERID],	
				"lr_date_create"=>date('Y-m-d H:i:s'),	
				"lr_revised"=>'0'
			);
			$this->db->insert('lesson_report', $data);
			
			$temp_lr_id = $this->db->insert_id();
			$temp_dlr_ins = $this->detail_lesson_plan_insert(
						$temp_lr_id, 
						$array_dlr_id, 
						$array_dlr_student, 
						$array_dlr_report_ld,
						$array_dlr_report_sed,
						$array_dlr_report_pd,
						$array_dlr_report_cb,
						$array_dlr_report_m
						);
			
			if($this->db->affected_rows())
				return $this->db->insert_id();
			else
				return '0';
		}

		function print_paper($jproduk_id){
		$sql="SELECT
			lr_period,
			lr_theme,
			lr_subtheme,
			lr_ld,
			lr_sed,	
			lr_pd,
			lr_cb,
			lr_m,
			class_name,
			dlr_report_ld,
			dlr_report_sed,
			dlr_report_pd,
			dlr_report_cb,
			dlr_report_m,
			cust_nama
		FROM detail_lr
		LEFT JOIN customer ON customer.cust_id = detail_lr.dlr_student
		LEFT JOIN lesson_report ON lesson_report.lr_id = detail_lr.dlr_master
		LEFT JOIN class ON class.class_id = lesson_report.lr_class
		WHERE lr_id='$jproduk_id' 
		ORDER BY cust_nama ASC";
		$result = $this->db->query($sql);
		return $result;
	}
		
		//fcuntion for delete record
		function anamnesa_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the anamnesas at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM anamnesa WHERE anam_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM anamnesa WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "anam_id= ".$pkid[$i];
					if($i<sizeof($pkid)-1){
						$query = $query . " OR ";
					}     
				}
				$this->db->query($query);
			}
			if($this->db->affected_rows()>0)
				return '1';
			else
				return '0';
		}
		
		//function for advanced search record
		function anamnesa_search($anam_id ,$anam_cust ,$anam_tanggal ,$anam_petugas ,$anam_pengobatan ,$anam_perawatan ,$anam_terapi ,$anam_alergi ,
								 $anam_obatalergi ,$anam_efekobatalergi ,$anam_hamil ,$anam_kb ,$anam_harapan ,$start,$end){
			//full query
			$query = "SELECT * FROM anamnesa,customer,karyawan
						WHERE anam_cust=cust_id AND anam_petugas=karyawan_id";
			
			
			if($anam_cust!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " anam_cust LIKE '%".$anam_cust."%'";
			};
			if($anam_tanggal!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " anam_tanggal LIKE '%".$anam_tanggal."%'";
			};
			if($anam_petugas!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " anam_petugas LIKE '%".$anam_petugas."%'";
			};
			if($anam_pengobatan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " anam_pengobatan LIKE '%".$anam_pengobatan."%'";
			};
			if($anam_perawatan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " anam_perawatan LIKE '%".$anam_perawatan."%'";
			};
			if($anam_terapi!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " anam_terapi LIKE '%".$anam_terapi."%'";
			};
			if($anam_alergi!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " anam_alergi LIKE '%".$anam_alergi."%'";
			};
			if($anam_obatalergi!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " anam_obatalergi LIKE '%".$anam_obatalergi."%'";
			};
			if($anam_efekobatalergi!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " anam_efekobatalergi LIKE '%".$anam_efekobatalergi."%'";
			};
			if($anam_hamil!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " anam_hamil LIKE '%".$anam_hamil."%'";
			};
			if($anam_kb!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " anam_kb LIKE '%".$anam_kb."%'";
			};
			if($anam_harapan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " anam_harapan LIKE '%".$anam_harapan."%'";
			};
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			
			$limit = $query." LIMIT ".$start.",".$end;		
			$result = $this->db->query($limit);    
			
			if($nbrows>0){
				foreach($result->result() as $row){
					$arr[] = $row;
				}
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}
		
		//function for print record
		function anamnesa_print($anam_id ,$anam_cust ,$anam_tanggal ,$anam_petugas ,$anam_pengobatan ,$anam_perawatan ,$anam_terapi ,$anam_alergi ,
								$anam_obatalergi ,$anam_efekobatalergi ,$anam_hamil ,$anam_kb ,$anam_harapan ,$option,$filter){
			//full query
			$query = "SELECT * FROM anamnesa,customer,karyawan
						WHERE anam_cust=cust_id AND anam_petugas=karyawan_id";
						
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (cust_nama LIKE '%".addslashes($filter)."%' OR 
							 karyawan_nama LIKE '%".addslashes($filter)."%' OR 
							 anam_alergi LIKE '%".addslashes($filter)."%' OR 
							 anam_obatalergi LIKE '%".addslashes($filter)."%'  )";
			} else if($option=='SEARCH'){
				
				if($anam_cust!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " anam_cust LIKE '%".$anam_cust."%'";
				};
				if($anam_tanggal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " anam_tanggal LIKE '%".$anam_tanggal."%'";
				};
				if($anam_petugas!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " anam_petugas LIKE '%".$anam_petugas."%'";
				};
				if($anam_pengobatan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " anam_pengobatan LIKE '%".$anam_pengobatan."%'";
				};
				if($anam_perawatan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " anam_perawatan LIKE '%".$anam_perawatan."%'";
				};
				if($anam_terapi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " anam_terapi LIKE '%".$anam_terapi."%'";
				};
				if($anam_alergi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " anam_alergi LIKE '%".$anam_alergi."%'";
				};
				if($anam_obatalergi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " anam_obatalergi LIKE '%".$anam_obatalergi."%'";
				};
				if($anam_efekobatalergi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " anam_efekobatalergi LIKE '%".$anam_efekobatalergi."%'";
				};
				if($anam_hamil!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " anam_hamil LIKE '%".$anam_hamil."%'";
				};
				if($anam_kb!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " anam_kb LIKE '%".$anam_kb."%'";
				};
				if($anam_harapan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " anam_harapan LIKE '%".$anam_harapan."%'";
				};
				
			}
			$result = $this->db->query($query);
			return $result;
		}
		
		//function  for export to excel
		function anamnesa_export_excel($anam_id ,$anam_cust ,$anam_tanggal ,$anam_petugas ,$anam_pengobatan ,$anam_perawatan ,$anam_terapi ,
									   $anam_alergi ,$anam_obatalergi ,$anam_efekobatalergi ,$anam_hamil ,$anam_kb ,$anam_harapan ,$option,$filter){
			//full query
			$query = "SELECT cust_no as 'No Cust', cust_nama 'Customer', anam_tanggal as Tanggal, karyawan_nama as Petugas,
						anam_pengobatan as Pengobatan, anam_perawatan as Perawatan, anam_terapi as Terapi, anam_alergi as Alergi,
						anam_obatalergi as 'Alergi terhadap Obat', anam_efekobatalergi as 'Efek Alergi', anam_hamil as Hamil, 
						anam_kb 'Alat KB yang digunakan', anam_harapan as Harapan FROM anamnesa,customer,karyawan
						WHERE anam_cust=cust_id AND anam_petugas=karyawan_id";
						
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (cust_nama LIKE '%".addslashes($filter)."%' OR 
							 karyawan_nama LIKE '%".addslashes($filter)."%' OR 
							 anam_alergi LIKE '%".addslashes($filter)."%' OR 
							 anam_obatalergi LIKE '%".addslashes($filter)."%'  )";
			} else if($option=='SEARCH'){
				
				if($anam_cust!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " anam_cust LIKE '%".$anam_cust."%'";
				};
				if($anam_tanggal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " anam_tanggal LIKE '%".$anam_tanggal."%'";
				};
				if($anam_petugas!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " anam_petugas LIKE '%".$anam_petugas."%'";
				};
				if($anam_pengobatan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " anam_pengobatan LIKE '%".$anam_pengobatan."%'";
				};
				if($anam_perawatan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " anam_perawatan LIKE '%".$anam_perawatan."%'";
				};
				if($anam_terapi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " anam_terapi LIKE '%".$anam_terapi."%'";
				};
				if($anam_alergi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " anam_alergi LIKE '%".$anam_alergi."%'";
				};
				if($anam_obatalergi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " anam_obatalergi LIKE '%".$anam_obatalergi."%'";
				};
				if($anam_efekobatalergi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " anam_efekobatalergi LIKE '%".$anam_efekobatalergi."%'";
				};
				if($anam_hamil!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " anam_hamil LIKE '%".$anam_hamil."%'";
				};
				if($anam_kb!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " anam_kb LIKE '%".$anam_kb."%'";
				};
				if($anam_harapan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " anam_harapan LIKE '%".$anam_harapan."%'";
				};
				
			}
			$result = $this->db->query($query);
			return $result;
		}
		
}
?>