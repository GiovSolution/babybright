<? /* 
	GIOV Solution - Keep IT Simple
*/

class M_master_lesson_plan extends Model{
		
		//constructor
		function M_master_lesson_plan() {
			parent::Model();
		}
		
		//function for detail
		//get record list
		function detail_lesson_plan_list($master_id,$query,$start,$end) {
			$query = "SELECT * FROM detail_lesson_plan where dlesplan_master='".$master_id."'";
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
			$query = "SELECT * FROM master_lesson_plan
						LEFT JOIN class ON class.class_id = master_lesson_plan.lesplan_class
						LEFT JOIN karyawan ON karyawan.karyawan_id = master_lesson_plan.lesplan_teacher";
		} else {
			$query_karyawan = "SELECT * FROM users WHERE users.user_name = '".$_SESSION[SESSION_USERID]."'";
			$query_sql_karyawan= $this->db->query($query_karyawan);
			$data_sql_karyawan= $query_sql_karyawan->row();
			$user_karyawan= $data_sql_karyawan->user_karyawan;
			
			$query = "SELECT * FROM master_lesson_plan
						LEFT JOIN class ON class.class_id = master_lesson_plan.lesplan_class
						LEFT JOIN karyawan ON karyawan.karyawan_id = master_lesson_plan.lesplan_teacher
						WHERE master_lesson_plan.lesplan_teacher='".$user_karyawan."'";
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
				$temp_lesplan_id, 
				$array_dlesplan_id, 
				$array_dlesplan_subject, 
				$array_dlesplan_time_start, 
				$array_dlesplan_time_end, 
				$array_dlesplan_act, 
				$array_dlesplan_materials, 
				$array_dlesplan_desc){
	
		$datetime_now = date('Y-m-d H:i:s');

		// if($dfcl_master=="" || $dfcl_master==NULL || $dfcl_master==0){
		// 		$dfcl_master=$this->get_master_id();
		// }
		
		$size_array = sizeof($array_dlesplan_subject) - 1;
			for($i = 0; $i < sizeof($array_dlesplan_subject); $i++){
				$dlesplan_id = $array_dlesplan_id[$i];
				$dlesplan_master = $temp_lesplan_id;
				$dlesplan_subject = $array_dlesplan_subject[$i];	
				$dlesplan_time_start = $array_dlesplan_time_start[$i];	
				$dlesplan_time_end = $array_dlesplan_time_end[$i];	
				$dlesplan_act = $array_dlesplan_act[$i];	
				$dlesplan_materials = $array_dlesplan_materials[$i];	
				$dlesplan_desc = $array_dlesplan_desc[$i];	
	
				$sql = "SELECT dlesplan_id
					FROM detail_lesson_plan
					WHERE dlesplan_id='".$dlesplan_id."'";
				$rs = $this->db->query($sql);
				
				if($rs->num_rows()){
				// jika datanya sudah ada maka update saja
					$dtu_detail_lesson_report = array(
						"dlesplan_master"=>$dlesplan_master,
						"dlesplan_subject"=>$dlesplan_subject,
						"dlesplan_time_start"=>$dlesplan_time_start,
						"dlesplan_time_end"=>$dlesplan_time_end,
						"dlesplan_act"=>$dlesplan_act,
						"dlesplan_materials"=>$dlesplan_materials,
						"dlesplan_description"=>$dlesplan_desc,
						"dlesplan_creator"=>$_SESSION[SESSION_USERID],
						"dlesplan_date_update"=>$datetime_now
					);
					$this->db->where('dlesplan_id', $dlesplan_id);
					$this->db->update('detail_lesson_plan', $dtu_detail_lesson_report); 
				}else {
					$data = array(
						"dlesplan_master"=>$dlesplan_master,
						"dlesplan_subject"=>$dlesplan_subject,
						"dlesplan_time_start"=>$dlesplan_time_start,
						"dlesplan_time_end"=>$dlesplan_time_end,
						"dlesplan_act"=>$dlesplan_act,
						"dlesplan_materials"=>$dlesplan_materials,
						"dlesplan_description"=>$dlesplan_desc,
						"dlesplan_update"=>$_SESSION[SESSION_USERID],
						"dlesplan_date_create"=>$datetime_now
					);
					$this->db->insert('detail_lesson_plan', $data); 	
				}	
		}

		return '1';
	}
		
		//function for update record
		function lesplan_update(
			$lesplan_id ,$lesplan_tanggal, $lesplan_class, $lesplan_teacher, $lesplan_theme, $lesplan_sub_theme ,$lesplan_week ,$lesplan_day, $lesplan_agreement, 
			$array_dlesplan_id, 
			$array_dlesplan_subject, 
			$array_dlesplan_time_start, 
			$array_dlesplan_time_end, 
			$array_dlesplan_act, 
			$array_dlesplan_materials, 
			$array_dlesplan_desc){
			$data = array(
				"lesplan_tanggal"=>$lesplan_tanggal, 
				"lesplan_theme"=>$lesplan_theme,
				"lesplan_sub_theme"=>$lesplan_sub_theme, 
				"lesplan_week"=>$lesplan_week, 
				"lesplan_day"=>$lesplan_day, 
				"lesplan_agreement"=>$lesplan_agreement, 
				"lesplan_update"=>$_SESSION[SESSION_USERID],			
				"lesplan_date_update"=>date('Y-m-d H:i:s')
			);
			/*
			// Cara untuk mengakali combobox yang pny datastore sendiri
			$sql="SELECT cust_id FROM customer WHERE cust_id='".$lr_cust."'";
				$result=$this->db->query($sql);
				if($result->num_rows())
					$data["lr_customer"]=$lr_cust;
			*/


			// Cara untuk mengakali combobox yang pny datastore sendiri
			$sql="SELECT class_id FROM class WHERE class_id='".$lesplan_class."'";
				$result=$this->db->query($sql);
				if($result->num_rows())
					$data["lesplan_class"]=$lesplan_class;

			// Cara untuk mengakali combobox yang pny datastore sendiri
			$sql="SELECT karyawan_id FROM karyawan WHERE karyawan_id='".$lesplan_teacher."'";
				$result=$this->db->query($sql);
				if($result->num_rows())
					$data["lesplan_teacher"]=$lesplan_teacher;			

			$this->db->where('lesplan_id', $lesplan_id);
			$this->db->update('master_lesson_plan', $data);
			
			$temp_lesplan_id = $lesplan_id;
			$temp_dlesplan_ins = $this->detail_lesson_plan_insert($temp_lesplan_id, 
				$array_dlesplan_id, 
				$array_dlesplan_subject, 
				$array_dlesplan_time_start, 
				$array_dlesplan_time_end, 
				$array_dlesplan_act, 
				$array_dlesplan_materials, 
				$array_dlesplan_desc);
			
			if($this->db->affected_rows()){
				$sql="UPDATE master_lesson_plan set lesplan_revised=(lesplan_revised+1) WHERE lesplan_id='".$lesplan_id."'";
				$this->db->query($sql);
			}
			
			return $lesplan_id;
		}
		
		//function for create new record
		function lesplan_create($lesplan_tanggal, $lesplan_class, $lesplan_teacher, $lesplan_theme, $lesplan_sub_theme ,$lesplan_week ,$lesplan_day, $lesplan_agreement,
			$array_dlesplan_id, 
			$array_dlesplan_subject, 
			$array_dlesplan_time_start, 
			$array_dlesplan_time_end, 
			$array_dlesplan_act, 
			$array_dlesplan_materials, 
			$array_dlesplan_desc){

			$lesplan_tanggal_pattern=strtotime($lesplan_tanggal);
			$pattern="LP/".date("ym",$lesplan_tanggal_pattern)."-";
			$lesplan_code=$this->m_public_function->get_kode_1('master_lesson_plan','lesplan_code',$pattern,12);
			
			$data = array(
				"lesplan_code"=>$lesplan_code, 
				"lesplan_tanggal"=>$lesplan_tanggal, 
				"lesplan_class"=>$lesplan_class, 
				"lesplan_teacher"=>$lesplan_teacher, 
				"lesplan_theme"=>$lesplan_theme, 
				"lesplan_sub_theme"=>$lesplan_sub_theme, 
				"lesplan_week"=>$lesplan_week, 
				"lesplan_day"=>$lesplan_day, 
				"lesplan_agreement"=>$lesplan_agreement, 
				"lesplan_creator"=>$_SESSION[SESSION_USERID],	
				"lesplan_date_create"=>date('Y-m-d H:i:s'),	
				"lesplan_revised"=>'0'
			);
			$this->db->insert('master_lesson_plan', $data);
			
			$temp_lesplan_id = $this->db->insert_id();
			$temp_dlesplan_ins = $this->detail_lesson_plan_insert(
				$temp_lesplan_id, 
				$array_dlesplan_id, 
				$array_dlesplan_subject, 
				$array_dlesplan_time_start, 
				$array_dlesplan_time_end, 
				$array_dlesplan_act, 
				$array_dlesplan_materials, 
				$array_dlesplan_desc
				);
			
			if($this->db->affected_rows())
				return $this->db->insert_id();
			else
				return '0';
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