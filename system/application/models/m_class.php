<? /*
	GIOV Solution - Keep IT Simple
*/

class M_class extends Model{
		
		//constructor
		function M_class() {
			parent::Model();
		}
		

		//function for detail
		//get record list
		function detail_student_class_list($master_id,$query,$start,$end) {
			$query = "SELECT * FROM class_students where dclass_master='".$master_id."'";
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

		//get master id, note : not done yet
		function get_master_id() {
			$query = "SELECT max(class_id) as master_id from class";
			$result = $this->db->query($query);
			if($result->num_rows()){
				$data=$result->row();
				$master_id=$data->master_id;
				return $master_id;
			}
			else{
				return '0';
				}
		}
		//eof

	//function for print record
		function student_print($master_id){
			//full query
			$query="SELECT * FROM class_students
					LEFT JOIN class ON class.class_id = class_students.dclass_master
					LEFT JOIN customer ON customer.cust_id = class_students.dclass_student
					WHERE class.class_id = '".$master_id."'";
			$result = $this->db->query($query);  
			return $result;
		}

	function get_teacher_list($query="",$start=0,$end=10){
		$sql="select karyawan_id,karyawan_no,karyawan_nama, karyawan_kelamin from vu_karyawan where karyawan_aktif='Aktif'";
		if($query!=="")
			$sql.=" and (karyawan_id like '%".$query."%' or karyawan_no like '%".$query."%' or karyawan_nama like '%".$query."%')";
	
		$result = $this->db->query($sql);
		$nbrows = $result->num_rows();
		$limit = $sql." LIMIT ".$start.",".$end;			
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

		function get_student_list($query,$start,$end, $aktif){
			// Mestie disini ntik ditambahin join from master_enrichment, supaya student list e isa dikelompokkan dari yg sudah bayar enrichment saja
			// $sql="SELECT cust_id,cust_no,cust_nama,cust_tgllahir,cust_alamat,cust_telprumah,cust_point,date_format(cust_tgllahir,'%Y-%m-%d') as cust_tgllahir 
					// FROM customer 
					// WHERE cust_aktif='Aktif'";
			$rs_rows=0;
		if(is_numeric($query)==true){
			$sql_dstudent="SELECT dclass_student FROM class_students WHERE dclass_master='$query'";
			$rs=$this->db->query($sql_dstudent);
			$rs_rows=$rs->num_rows();
		}
		
		if($aktif=='yes'){
			$sql="SELECT cust_id,cust_no,cust_nama,cust_tgllahir,cust_alamat,cust_telprumah,cust_point,date_format(cust_tgllahir,'%Y-%m-%d') as cust_tgllahir 
				FROM customer 
				WHERE cust_aktif='Aktif'";
		}else{
			$sql="SELECT cust_id,cust_no,cust_nama,cust_tgllahir,cust_alamat,cust_telprumah,cust_point,date_format(cust_tgllahir,'%Y-%m-%d') as cust_tgllahir 
				FROM customer";
		}
		
		if($query<>"" && is_numeric($query)==false){
			$sql.=eregi("WHERE",$sql)? " AND ":" WHERE ";
			$sql.=" (cust_panggilan like '%".$query."%' or cust_nama like '%".$query."%' ) ";
		}else{
			if($rs_rows){
				$filter="";
				$sql.=eregi("WHERE",$sql)? " AND ":" WHERE ";
				foreach($rs->result() as $row_dstudent){
					
					$filter.="OR cust_id='".$row_dstudent->dclass_student."' ";
				}
				$sql=$sql."(".substr($filter,2,strlen($filter)).")";
			}
		}
		
		$result = $this->db->query($sql);
		$nbrows = $result->num_rows();
		if(($end!=0)  && ($aktif<>'yesno')){
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

		//Delete detail_pendidikan
        function detail_class_delete($dclass_id){
            $date_now = date('Y-m-d');
			$datetime_now = date('Y-m-d H:i:s');
			$query = "DELETE FROM class_students WHERE dclass_id = ".$dclass_id;
			$this->db->query($query);
			if($this->db->affected_rows()>0)
				return '1';
			else
				return '-1';
		}
		// EOF PENDIDIKAN

		// Function untuk insert Detail Lesson Plan
		function detail_class_student_insert($temp_class_id, $array_dclass_id, $array_dclass_student, $array_dclass_note, $array_dclass_aktif){
	
		$datetime_now = date('Y-m-d H:i:s');

		if($temp_class_id=="" || $temp_class_id==NULL || $temp_class_id==0){
				$temp_class_id=$this->get_master_id();
		}
		
		$size_array = sizeof($array_dclass_student) - 1;
			for($i = 0; $i < sizeof($array_dclass_student); $i++){
				$dclass_id = $array_dclass_id[$i];
				$dclass_master = $temp_class_id;
				$dclass_student = $array_dclass_student[$i];
				$dclass_note = $array_dclass_note[$i];
				$dclass_aktif = $array_dclass_aktif[$i];
	
				$sql = "SELECT dclass_id
					FROM class_students
					WHERE dclass_id='".$dclass_id."'";
				$rs = $this->db->query($sql);
				
				if($rs->num_rows()){
				// jika datanya sudah ada maka update saja
					$dtu_detail_class_student = array(
						"dclass_master"=>$dclass_master,
						"dclass_student"=>$dclass_student,
						"dclass_note"=>$dclass_note,
						"dclass_aktif"=>$dclass_aktif,
						"dclass_date_update"=>$datetime_now
					);
					$this->db->where('dclass_id', $dclass_id);
					$this->db->update('class_students', $dtu_detail_class_student); 
				}else {
					$data = array(
						"dclass_master"=>$dclass_master,
						"dclass_student"=>$dclass_student,
						"dclass_note"=>$dclass_note,
						"dclass_aktif"=>$dclass_aktif,
						"dclass_date_update"=>$datetime_now
					);
					$this->db->insert('class_students', $data); 	
				}	
		}

		return '1';
	}



		//function for get list record
		function class_list($filter,$start,$end){
			$query = "SELECT class.*, teacher1.karyawan_nama as class_teacher1, teacher2.karyawan_nama as class_teacher2, teacher3.karyawan_nama as class_teacher3,
						TIME_FORMAT(class.class_time_start,'%H:%i') as time_start,
						TIME_FORMAT(class.class_time_end,'%H:%i') as time_end
					FROM class
					LEFT JOIN karyawan teacher1 on (teacher1.karyawan_id = class.class_teacher1)
					LEFT JOIN karyawan teacher2 on (teacher2.karyawan_id = class.class_teacher2)
					LEFT JOIN karyawan teacher3 on (teacher3.karyawan_id = class.class_teacher3)
					";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (class_name LIKE '%".addslashes($filter)."%' OR class_location LIKE '%".addslashes($filter)."%' OR class_notes LIKE '%".addslashes($filter)."%' )";
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
		
		//function for update record
		function class_update($class_id ,$class_name ,$class_location ,$class_time_start ,$class_time_end, $class_capacity, $class_age_down ,$class_age_up , $class_teacher1, $class_teacher2, $class_teacher3, $class_notes ,$class_stat ,$class_creator ,$class_date_create ,$class_update ,$class_date_update ,$class_revised,
		$array_dclass_id, $array_dclass_student, $array_dclass_note, $array_dclass_aktif ){
			//echo "masuk";
			if ($class_stat=="")
				$class_stat = "Aktif";
			$data = array(
				//"lass_id"=>$class_id,			
				"class_name"=>$class_name,			
				"class_location"=>$class_location,			
				"class_time_start"=>$class_time_start,			
				"class_time_end"=>$class_time_end,			
				"class_capacity"=>$class_capacity,			
				"class_age_down"=>$class_age_down,			
				"class_age_up"=>$class_age_up,			
				"class_notes"=>$class_notes,			
				"class_stat"=>$class_stat,			
				"class_update"=>$_SESSION[SESSION_USERID],			
				"class_date_update"=>date('Y-m-d H:i:s')			
			);

			$sql="SELECT karyawan_id FROM karyawan WHERE karyawan_id='".$class_teacher1."'";
				$result=$this->db->query($sql);
				if($result->num_rows())
					$data["class_teacher1"]=$class_teacher1;
				

			$sql="SELECT karyawan_id FROM karyawan WHERE karyawan_id='".$class_teacher2."'";
				$result=$this->db->query($sql);
				if($result->num_rows())
					$data["class_teacher2"]=$class_teacher2;
	

			$sql="SELECT karyawan_id FROM karyawan WHERE karyawan_id='".$class_teacher3."'";
				$result=$this->db->query($sql);
				if($result->num_rows())
					$data["class_teacher3"]=$class_teacher3;
		

			$this->db->where('class_id', $class_id);
			$this->db->update('class', $data);
			
			$temp_dclass_upd = $this->detail_class_student_insert($class_id, $array_dclass_id, $array_dclass_student, $array_dclass_note, $array_dclass_aktif
			 );

			if($this->db->affected_rows()){
				$sql="UPDATE class set class_revised=(class_revised+1) WHERE class_id='".$class_id."'";
				$this->db->query($sql);
			}
			return '1';

		}
		
		//function for create new record
		function class_create($class_name ,$class_location ,$class_time_start ,$class_time_end ,$class_capacity ,$class_age_down ,$class_age_up , $class_teacher1, $class_teacher2, $class_teacher3, $class_notes ,$class_stat ,$class_creator ,$class_date_create ,$class_update ,$class_date_update ,$class_revised,
			$array_dclass_id, $array_dclass_student, $array_dclass_note, $array_dclass_aktif){
			if ($class_stat=="")
				$class_stat = "Aktif";
			$data = array(
	
				"class_name"=>$class_name,	
				"class_location"=>$class_location,	
				"class_time_start"=>$class_time_start,	
				"class_time_end"=>$class_time_end,	
				"class_capacity"=>$class_capacity,	
				"class_age_down"=>$class_age_down,	
				"class_age_up"=>$class_age_up,	
				"class_teacher1"=>$class_teacher1,	
				"class_teacher2"=>$class_teacher2,	
				"class_teacher3"=>$class_teacher3,	
				"class_notes"=>$class_notes,	
				"class_stat"=>$class_stat,	
				"class_creator"=>$_SESSION[SESSION_USERID],	
				"class_date_create"=>date('Y-m-d H:i:s'),	
				"class_update"=>$class_update,	
				"class_date_update"=>$class_date_update,	
				"class_revised"=>'0'	
			);
			$this->db->insert('class', $data); 

			$temp_class_id = $this->db->insert_id();
			$temp_dclass_ins = $this->detail_class_student_insert($temp_class_id, $array_dclass_id, $array_dclass_student, $array_dclass_note, $array_dclass_aktif
			 );


			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//fcuntion for delete record
		function class_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the gudangs at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM class WHERE class_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM class WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "class_id= ".$pkid[$i];
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
		function class_search($class_id ,$class_name ,$class_location ,$class_capacity ,$class_age_down ,$class_age_up ,$class_notes ,$class_stat ,$class_creator ,$class_date_create ,$class_update ,$class_date_update ,$class_revised ,$start,$end){
			if($class_stat=="")
				$class_stat="Aktif";
			//full query
			$query="select * from class";
			
			if($class_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " class_id LIKE '%".$class_id."%'";
			};
			if($class_name!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " class_name LIKE '%".$class_name."%'";
			};
			if($class_location!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " class_location LIKE '%".$class_location."%'";
			};
			if($class_notes!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " class_notes LIKE '%".$class_notes."%'";
			};
			if($class_stat!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " class_stat LIKE '%".$class_stat."%'";
			};
			if($class_creator!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " class_creator LIKE '%".$class_creator."%'";
			};
			if($class_date_create!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " class_date_create LIKE '%".$class_date_create."%'";
			};
			if($class_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " class_update LIKE '%".$class_update."%'";
			};
			if($class_date_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " class_date_update LIKE '%".$class_date_update."%'";
			};
			if($class_revised!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " class_revised LIKE '%".$class_revised."%'";
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
		function class_print($class_id ,$class_name ,$class_location ,$class_notes ,$class_stat ,$class_creator ,$class_date_create ,$class_update ,$class_date_update ,$class_revised ,$option,$filter){
			//full query
			$query="select * from class";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (class_id LIKE '%".addslashes($filter)."%' OR class_name LIKE '%".addslashes($filter)."%' OR class_location LIKE '%".addslashes($filter)."%' OR class_notes LIKE '%".addslashes($filter)."%' OR class_stat LIKE '%".addslashes($filter)."%' OR class_creator LIKE '%".addslashes($filter)."%' OR class_date_create LIKE '%".addslashes($filter)."%' OR class_update LIKE '%".addslashes($filter)."%' OR class_date_update LIKE '%".addslashes($filter)."%' OR class_revised LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($class_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " class_id LIKE '%".$class_id."%'";
				};
				if($class_name!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " class_name LIKE '%".$class_name."%'";
				};
				if($class_location!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " class_location LIKE '%".$class_location."%'";
				};
				if($class_notes!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " class_notes LIKE '%".$class_notes."%'";
				};
				if($class_stat!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " class_stat LIKE '%".$class_stat."%'";
				};
				if($class_creator!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " class_creator LIKE '%".$class_creator."%'";
				};
				if($class_date_create!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " class_date_create LIKE '%".$class_date_create."%'";
				};
				if($class_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " class_update LIKE '%".$class_update."%'";
				};
				if($class_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " class_date_update LIKE '%".$class_date_update."%'";
				};
				if($class_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " class_revised LIKE '%".$class_revised."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
		//function  for export to excel
		function class_export_excel($class_id ,$class_name ,$class_location ,$class_notes ,$class_stat ,$class_creator ,$class_date_create ,$class_update ,$class_date_update ,$class_revised ,$option,$filter){
			//full query
			$query="select 	class_name AS nama,
							class_location AS lokasi,
							class_notes AS keterangan,
							class_stat AS aktif

					from class";
					
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (class_id LIKE '%".addslashes($filter)."%' OR class_name LIKE '%".addslashes($filter)."%' OR class_location LIKE '%".addslashes($filter)."%' OR class_notes LIKE '%".addslashes($filter)."%' OR class_stat LIKE '%".addslashes($filter)."%' OR class_creator LIKE '%".addslashes($filter)."%' OR class_date_create LIKE '%".addslashes($filter)."%' OR class_update LIKE '%".addslashes($filter)."%' OR class_date_update LIKE '%".addslashes($filter)."%' OR class_revised LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($class_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " class_id LIKE '%".$class_id."%'";
				};
				if($class_name!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " class_name LIKE '%".$class_name."%'";
				};
				if($class_location!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " class_location LIKE '%".$class_location."%'";
				};
				if($class_notes!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " class_notes LIKE '%".$class_notes."%'";
				};
				if($class_stat!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " class_stat LIKE '%".$class_stat."%'";
				};
				if($class_creator!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " class_creator LIKE '%".$class_creator."%'";
				};
				if($class_date_create!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " class_date_create LIKE '%".$class_date_create."%'";
				};
				if($class_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " class_update LIKE '%".$class_update."%'";
				};
				if($class_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " class_date_update LIKE '%".$class_date_update."%'";
				};
				if($class_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " class_revised LIKE '%".$class_revised."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		

}
?>