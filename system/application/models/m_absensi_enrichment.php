<? /* 	
	GIOV Solution - Keep IT Simple
*/

class M_absensi_enrichment extends Model{
		
		//constructor
		function M_absensi_enrichment() {
			parent::Model();
		}


		function get_info_data_pengantar($cust_id){
			$sql = "SELECT customer.* , class.class_name
					FROM customer 
					LEFT JOIN class_students ON (class_students.dclass_student = customer.cust_id)
					LEFT JOIN class ON (class.class_id = class_students.dclass_master)
					WHERE cust_id='".$cust_id."'";
			
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


	function get_customer_list($query,$start,$end){
		$sql="SELECT cust_id,cust_no,cust_nama,cust_tgllahir,cust_alamat,cust_telprumah,cust_point,date_format(cust_tgllahir,'%Y-%m-%d') as cust_tgllahir 
			FROM customer 
			WHERE cust_id IN (select dclass_student from class_students where dclass_aktif = 'Aktif')";
		if($query<>""){
			$sql=$sql." and (/*cust_id = '".$query."' or*/ cust_no like '%".$query."%' or cust_alamat like '%".$query."%' or cust_nama like '%".$query."%' or cust_telprumah like '%".$query."%' or cust_telprumah2 like '%".$query."%' or cust_telpkantor like '%".$query."%' or cust_hp like '%".$query."%' or cust_hp2 like '%".$query."%' or cust_hp3 like '%".$query."%' or date_format(cust_tgllahir,'%d-%m') like '%".$query."%' ) ";
		}
		
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
	
		
		//function for get list record
		function absenrich_list($filter,$start,$end){
			$query = "SELECT absensi_enrichment.* , customer.cust_nama
					FROM absensi_enrichment
					LEFT JOIN customer ON (customer.cust_id = absensi_enrichment.absenrich_cust)
					";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (absenrich_pengantar1 LIKE '%".addslashes($filter)."%' OR absenrich_class LIKE '%".addslashes($filter)."%' OR customer_nama LIKE '%".addslashes($filter)."%' )";
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
		function absenrich_update($gudang_id ,$gudang_nama ,$gudang_lokasi ,$gudang_keterangan ,$gudang_aktif ,$gudang_creator ,$gudang_date_create ,$absenrich_updater ,$gudang_date_update ,$gudang_revised ){
			if ($gudang_aktif=="")
				$gudang_aktif = "Aktif";
			$data = array(
				"gudang_id"=>$gudang_id,			
				"gudang_nama"=>$gudang_nama,			
				"gudang_lokasi"=>$gudang_lokasi,			
				"gudang_keterangan"=>$gudang_keterangan,			
				"gudang_aktif"=>$gudang_aktif,			
				"absenrich_updater"=>$_SESSION[SESSION_USERID],			
				"gudang_date_update"=>date('Y-m-d H:i:s')			
			);
			$this->db->where('gudang_id', $gudang_id);
			$this->db->update('gudang', $data);
			
			if($this->db->affected_rows()){
				$sql="UPDATE gudang set gudang_revised=(gudang_revised+1) WHERE gudang_id='".$gudang_id."'";
				$this->db->query($sql);
			}
			return '1';

		}
		
		//function for create new record
		function absenrich_create($absenrich_cust, $absenrich_tgl, $absenrich_class, $absenrich_keterangan, $absenrich_pengantar1, $absenrich_pengantar2, $absenrich_pengantar3, $absenrich_pengantar4, $absenrich_pengantar5, $absenrich_check1, $absenrich_check2, $absenrich_check3, $absenrich_check4, $absenrich_check5){

			$datetime_now = date('Y-m-d H:i:s');
			$datetime = date('Y-m-d');

			$sql_temp = "SELECT absenrich_id 
						FROM absensi_enrichment
						WHERE absenrich_cust = '".$absenrich_cust."' and absenrich_tgl = '".$datetime."'
							";
			$result=$this->db->query($sql_temp);
			if($result->num_rows())
			{
				return '-1';

			}
			else{


			

			if($absenrich_check1=='true')
			{	$pengantar1 = $absenrich_pengantar1; }
			else if($absenrich_check1=='false')
			{	$pengantar1 = ""; }

			if($absenrich_check2=='true')
			{	$pengantar2 = $absenrich_pengantar2; }
			else if($absenrich_check2=='false')
			{	$pengantar2 = "";	}

			if($absenrich_check3=='true')
			{	$pengantar3 = $absenrich_pengantar3; }
			else if($absenrich_check3=='false')
			{	$pengantar3 = "";	}

			if($absenrich_check4=='true')
			{	$pengantar4 = $absenrich_pengantar4; }
			else if($absenrich_check4=='false')
			{	$pengantar4 = "";	}

			if($absenrich_check5=='true')
			{	$pengantar5 = $absenrich_pengantar5; }
			else if($absenrich_check5=='false')
			{	$pengantar5 = "";	}

			$data = array(
				"absenrich_cust"=>$absenrich_cust,	
				"absenrich_tgl"=>$absenrich_tgl,	
				"absenrich_class"=>$absenrich_class,	
				"absenrich_keterangan"=>$absenrich_keterangan,	
				"absenrich_creator"=>$_SESSION[SESSION_USERID],	
				"absenrich_date_create"=>$datetime_now,	
				"absenrich_pengantar1"=>$pengantar1,	
				"absenrich_pengantar2"=>$pengantar2,	
				"absenrich_pengantar3"=>$pengantar3,	
				"absenrich_pengantar4"=>$pengantar4,	
				"absenrich_pengantar5"=>$pengantar5
			);
			$this->db->insert('absensi_enrichment', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
			}
		}
		
		//fcuntion for delete record
		function absenrich_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the gudangs at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM gudang WHERE gudang_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM gudang WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "gudang_id= ".$pkid[$i];
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
		function absenrich_search($gudang_id ,$gudang_nama ,$gudang_lokasi ,$gudang_keterangan ,$gudang_aktif ,$gudang_creator ,$gudang_date_create ,$absenrich_updater ,$gudang_date_update ,$gudang_revised ,$start,$end){
			if($gudang_aktif=="")
				$gudang_aktif="Aktif";
			//full query
			$query="select * from gudang";
			
			if($gudang_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " gudang_id LIKE '%".$gudang_id."%'";
			};
			if($gudang_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " gudang_nama LIKE '%".$gudang_nama."%'";
			};
			if($gudang_lokasi!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " gudang_lokasi LIKE '%".$gudang_lokasi."%'";
			};
			if($gudang_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " gudang_keterangan LIKE '%".$gudang_keterangan."%'";
			};
			if($gudang_aktif!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " gudang_aktif LIKE '%".$gudang_aktif."%'";
			};
			if($gudang_creator!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " gudang_creator LIKE '%".$gudang_creator."%'";
			};
			if($gudang_date_create!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " gudang_date_create LIKE '%".$gudang_date_create."%'";
			};
			if($absenrich_updater!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " absenrich_updater LIKE '%".$absenrich_updater."%'";
			};
			if($gudang_date_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " gudang_date_update LIKE '%".$gudang_date_update."%'";
			};
			if($gudang_revised!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " gudang_revised LIKE '%".$gudang_revised."%'";
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
		function absenrich_print($gudang_id ,$gudang_nama ,$gudang_lokasi ,$gudang_keterangan ,$gudang_aktif ,$gudang_creator ,$gudang_date_create ,$absenrich_updater ,$gudang_date_update ,$gudang_revised ,$option,$filter){
			//full query
			$query="select * from gudang";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (gudang_id LIKE '%".addslashes($filter)."%' OR gudang_nama LIKE '%".addslashes($filter)."%' OR gudang_lokasi LIKE '%".addslashes($filter)."%' OR gudang_keterangan LIKE '%".addslashes($filter)."%' OR gudang_aktif LIKE '%".addslashes($filter)."%' OR gudang_creator LIKE '%".addslashes($filter)."%' OR gudang_date_create LIKE '%".addslashes($filter)."%' OR absenrich_updater LIKE '%".addslashes($filter)."%' OR gudang_date_update LIKE '%".addslashes($filter)."%' OR gudang_revised LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($gudang_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_id LIKE '%".$gudang_id."%'";
				};
				if($gudang_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_nama LIKE '%".$gudang_nama."%'";
				};
				if($gudang_lokasi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_lokasi LIKE '%".$gudang_lokasi."%'";
				};
				if($gudang_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_keterangan LIKE '%".$gudang_keterangan."%'";
				};
				if($gudang_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_aktif LIKE '%".$gudang_aktif."%'";
				};
				if($gudang_creator!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_creator LIKE '%".$gudang_creator."%'";
				};
				if($gudang_date_create!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_date_create LIKE '%".$gudang_date_create."%'";
				};
				if($absenrich_updater!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " absenrich_updater LIKE '%".$absenrich_updater."%'";
				};
				if($gudang_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_date_update LIKE '%".$gudang_date_update."%'";
				};
				if($gudang_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_revised LIKE '%".$gudang_revised."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
		//function  for export to excel
		function absenrich_export_excel($gudang_id ,$gudang_nama ,$gudang_lokasi ,$gudang_keterangan ,$gudang_aktif ,$gudang_creator ,$gudang_date_create ,$absenrich_updater ,$gudang_date_update ,$gudang_revised ,$option,$filter){
			//full query
			$query="select 	gudang_nama AS nama,
							gudang_lokasi AS lokasi,
							gudang_keterangan AS keterangan,
							gudang_aktif AS aktif

					from gudang";
					
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (gudang_id LIKE '%".addslashes($filter)."%' OR gudang_nama LIKE '%".addslashes($filter)."%' OR gudang_lokasi LIKE '%".addslashes($filter)."%' OR gudang_keterangan LIKE '%".addslashes($filter)."%' OR gudang_aktif LIKE '%".addslashes($filter)."%' OR gudang_creator LIKE '%".addslashes($filter)."%' OR gudang_date_create LIKE '%".addslashes($filter)."%' OR absenrich_updater LIKE '%".addslashes($filter)."%' OR gudang_date_update LIKE '%".addslashes($filter)."%' OR gudang_revised LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($gudang_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_id LIKE '%".$gudang_id."%'";
				};
				if($gudang_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_nama LIKE '%".$gudang_nama."%'";
				};
				if($gudang_lokasi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_lokasi LIKE '%".$gudang_lokasi."%'";
				};
				if($gudang_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_keterangan LIKE '%".$gudang_keterangan."%'";
				};
				if($gudang_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_aktif LIKE '%".$gudang_aktif."%'";
				};
				if($gudang_creator!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_creator LIKE '%".$gudang_creator."%'";
				};
				if($gudang_date_create!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_date_create LIKE '%".$gudang_date_create."%'";
				};
				if($absenrich_updater!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " absenrich_updater LIKE '%".$absenrich_updater."%'";
				};
				if($gudang_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_date_update LIKE '%".$gudang_date_update."%'";
				};
				if($gudang_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_revised LIKE '%".$gudang_revised."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		

}
?>