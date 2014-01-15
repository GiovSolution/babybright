<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: supplier Model
	+ Description	: For record model process back-end
	+ Filename 		: c_supplier.php
 	+ Author  		: zainal, mukhlison
 	+ Created on 16/Jul/2009 13:00:42
	
*/

class M_supplier extends Model{
		
		//constructor
		function M_supplier() {
			parent::Model();
		}
		
		function get_supplier_kategori_list(){
			$sql="SELECT distinct supplier_kategori FROM supplier WHERE supplier_kategori<>''";
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
		
		//function for get list record
		function supplier_list($filter,$start,$end){
			$query = "SELECT * FROM supplier";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (supplier_kategori LIKE '%".addslashes($filter)."%' OR supplier_nama LIKE '%".addslashes($filter)."%' OR supplier_notelp LIKE '%".addslashes($filter)."%' OR supplier_cp LIKE '%".addslashes($filter)."%' OR supplier_contact_cp LIKE '%".addslashes($filter)."%' )";
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
		function supplier_update($supplier_id ,$supplier_kategori ,$supplier_nama ,$supplier_alamat ,$supplier_kota ,$supplier_kodepos ,$supplier_propinsi ,$supplier_negara ,$supplier_notelp ,$supplier_notelp2 ,$supplier_nofax ,$supplier_email ,$supplier_website ,$supplier_cp ,$supplier_contact_cp ,$supplier_aktif ,$supplier_creator ,$supplier_date_create ,$supplier_update ,$supplier_date_update ,$supplier_revised ){
			if ($supplier_aktif=="")
				$supplier_aktif = "Aktif";
			$data = array(
				"supplier_id"=>$supplier_id,			
				"supplier_kategori"=>$supplier_kategori,			
				"supplier_nama"=>$supplier_nama,			
				"supplier_alamat"=>$supplier_alamat,			
				"supplier_kota"=>$supplier_kota,			
				"supplier_kodepos"=>$supplier_kodepos,			
				"supplier_propinsi"=>$supplier_propinsi,			
				"supplier_negara"=>$supplier_negara,			
				"supplier_notelp"=>$supplier_notelp,			
				"supplier_notelp2"=>$supplier_notelp2,			
				"supplier_nofax"=>$supplier_nofax,			
				"supplier_email"=>$supplier_email,			
				"supplier_website"=>$supplier_website,			
				"supplier_cp"=>$supplier_cp,			
				"supplier_contact_cp"=>$supplier_contact_cp,			
				"supplier_aktif"=>$supplier_aktif,			
				// "supplier_creator"=>$supplier_creator,			
				// "supplier_date_create"=>$supplier_date_create,			
				"supplier_update"=>$_SESSION[SESSION_USERID],			
				"supplier_date_update"=>date('Y-m-d H:i:s'),			
				// "supplier_revised"=>$supplier_revised			
			);
			$this->db->where('supplier_id', $supplier_id);
			$this->db->update('supplier', $data);
			
			if($this->db->affected_rows()){
				$sql="UPDATE supplier set supplier_revised=(supplier_revised+1) WHERE supplier_id='".$supplier_id."'";
				$this->db->query($sql);
			}
			return '1';

		}
		
		//function for create new record
		function supplier_create($supplier_kategori ,$supplier_nama ,$supplier_alamat ,$supplier_kota ,$supplier_kodepos ,$supplier_propinsi ,$supplier_negara ,$supplier_notelp ,$supplier_notelp2 ,$supplier_nofax ,$supplier_email ,$supplier_website ,$supplier_cp ,$supplier_contact_cp ,$supplier_keterangan ,$supplier_aktif ,$supplier_creator ,$supplier_date_create ,$supplier_update ,$supplier_date_update ,$supplier_revised ){
			if ($supplier_aktif=="")
				$supplier_aktif = "Aktif";
			$data = array(
	
				"supplier_kategori"=>$supplier_kategori,	
				"supplier_nama"=>$supplier_nama,	
				"supplier_alamat"=>$supplier_alamat,	
				"supplier_kota"=>$supplier_kota,	
				"supplier_kodepos"=>$supplier_kodepos,	
				"supplier_propinsi"=>$supplier_propinsi,	
				"supplier_negara"=>$supplier_negara,	
				"supplier_notelp"=>$supplier_notelp,	
				"supplier_notelp2"=>$supplier_notelp2,	
				"supplier_nofax"=>$supplier_nofax,	
				"supplier_email"=>$supplier_email,	
				"supplier_website"=>$supplier_website,	
				"supplier_cp"=>$supplier_cp,	
				"supplier_contact_cp"=>$supplier_contact_cp,	
				"supplier_keterangan"=>$supplier_keterangan,	
				"supplier_aktif"=>$supplier_aktif,	
				"supplier_creator"=>$_SESSION[SESSION_USERID],	
				"supplier_date_create"=>date('Y-m-d H:i:s'),	
				"supplier_update"=>$supplier_update,	
				"supplier_date_update"=>$supplier_date_update,	
				"supplier_revised"=>'0'	
			);
			$this->db->insert('supplier', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//fcuntion for delete record
		function supplier_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the suppliers at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM supplier WHERE supplier_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM supplier WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "supplier_id= ".$pkid[$i];
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
		function supplier_search($supplier_id ,$supplier_kategori ,$supplier_nama ,$supplier_alamat ,$supplier_kota ,$supplier_kodepos ,$supplier_propinsi ,$supplier_negara ,$supplier_notelp ,$supplier_notelp2 ,$supplier_nofax ,$supplier_email ,$supplier_website ,$supplier_cp ,$supplier_contact_cp ,$supplier_aktif ,$supplier_creator ,$supplier_date_create ,$supplier_update ,$supplier_date_update ,$supplier_revised ,$start,$end){
			if ($supplier_aktif=="")
				$supplier_aktif = "Aktif";
			//full query
			$query="select * from supplier";
			
			if($supplier_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " supplier_id LIKE '%".$supplier_id."%'";
			};
			if($supplier_kategori!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " supplier_kategori LIKE '%".$supplier_kategori."%'";
			};
			if($supplier_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " supplier_nama LIKE '%".$supplier_nama."%'";
			};
			if($supplier_alamat!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " supplier_alamat LIKE '%".$supplier_alamat."%'";
			};
			if($supplier_kota!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " supplier_kota LIKE '%".$supplier_kota."%'";
			};
			if($supplier_kodepos!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " supplier_kodepos LIKE '%".$supplier_kodepos."%'";
			};
			if($supplier_propinsi!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " supplier_propinsi LIKE '%".$supplier_propinsi."%'";
			};
			if($supplier_negara!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " supplier_negara LIKE '%".$supplier_negara."%'";
			};
			if($supplier_notelp!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " supplier_notelp LIKE '%".$supplier_notelp."%'";
			};
			if($supplier_notelp2!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " supplier_notelp2 LIKE '%".$supplier_notelp2."%'";
			};
			if($supplier_nofax!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " supplier_nofax LIKE '%".$supplier_nofax."%'";
			};
			if($supplier_email!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " supplier_email LIKE '%".$supplier_email."%'";
			};
			if($supplier_website!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " supplier_website LIKE '%".$supplier_website."%'";
			};
			if($supplier_cp!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " supplier_cp LIKE '%".$supplier_cp."%'";
			};
			if($supplier_contact_cp!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " supplier_contact_cp LIKE '%".$supplier_contact_cp."%'";
			};
			if($supplier_aktif!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " supplier_aktif LIKE '%".$supplier_aktif."%'";
			};
			if($supplier_creator!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " supplier_creator LIKE '%".$supplier_creator."%'";
			};
			if($supplier_date_create!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " supplier_date_create LIKE '%".$supplier_date_create."%'";
			};
			if($supplier_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " supplier_update LIKE '%".$supplier_update."%'";
			};
			if($supplier_date_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " supplier_date_update LIKE '%".$supplier_date_update."%'";
			};
			if($supplier_revised!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " supplier_revised LIKE '%".$supplier_revised."%'";
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
		function supplier_print($supplier_id ,$supplier_kategori ,$supplier_nama ,$supplier_alamat ,$supplier_kota ,$supplier_kodepos ,$supplier_propinsi ,$supplier_negara ,$supplier_notelp ,$supplier_notelp2 ,$supplier_nofax ,$supplier_email ,$supplier_website ,$supplier_cp ,$supplier_contact_cp ,$supplier_aktif ,$supplier_creator ,$supplier_date_create ,$supplier_update ,$supplier_date_update ,$supplier_revised ,$option,$filter){
			//full query
			$query="select * from supplier";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (supplier_id LIKE '%".addslashes($filter)."%' OR supplier_kategori LIKE '%".addslashes($filter)."%' OR supplier_nama LIKE '%".addslashes($filter)."%' OR supplier_alamat LIKE '%".addslashes($filter)."%' OR supplier_kota LIKE '%".addslashes($filter)."%' OR supplier_kodepos LIKE '%".addslashes($filter)."%' OR supplier_propinsi LIKE '%".addslashes($filter)."%' OR supplier_negara LIKE '%".addslashes($filter)."%' OR supplier_notelp LIKE '%".addslashes($filter)."%' OR supplier_notelp2 LIKE '%".addslashes($filter)."%' OR supplier_nofax LIKE '%".addslashes($filter)."%' OR supplier_email LIKE '%".addslashes($filter)."%' OR supplier_website LIKE '%".addslashes($filter)."%' OR supplier_cp LIKE '%".addslashes($filter)."%' OR supplier_contact_cp LIKE '%".addslashes($filter)."%' OR supplier_aktif LIKE '%".addslashes($filter)."%' OR supplier_creator LIKE '%".addslashes($filter)."%' OR supplier_date_create LIKE '%".addslashes($filter)."%' OR supplier_update LIKE '%".addslashes($filter)."%' OR supplier_date_update LIKE '%".addslashes($filter)."%' OR supplier_revised LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($supplier_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_id LIKE '%".$supplier_id."%'";
				};
				if($supplier_kategori!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_kategori LIKE '%".$supplier_kategori."%'";
				};
				if($supplier_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_nama LIKE '%".$supplier_nama."%'";
				};
				if($supplier_alamat!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_alamat LIKE '%".$supplier_alamat."%'";
				};
				if($supplier_kota!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_kota LIKE '%".$supplier_kota."%'";
				};
				if($supplier_kodepos!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_kodepos LIKE '%".$supplier_kodepos."%'";
				};
				if($supplier_propinsi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_propinsi LIKE '%".$supplier_propinsi."%'";
				};
				if($supplier_negara!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_negara LIKE '%".$supplier_negara."%'";
				};
				if($supplier_notelp!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_notelp LIKE '%".$supplier_notelp."%'";
				};
				if($supplier_notelp2!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_notelp2 LIKE '%".$supplier_notelp2."%'";
				};
				if($supplier_nofax!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_nofax LIKE '%".$supplier_nofax."%'";
				};
				if($supplier_email!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_email LIKE '%".$supplier_email."%'";
				};
				if($supplier_website!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_website LIKE '%".$supplier_website."%'";
				};
				if($supplier_cp!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_cp LIKE '%".$supplier_cp."%'";
				};
				if($supplier_contact_cp!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_contact_cp LIKE '%".$supplier_contact_cp."%'";
				};
				if($supplier_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_aktif LIKE '%".$supplier_aktif."%'";
				};
				if($supplier_creator!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_creator LIKE '%".$supplier_creator."%'";
				};
				if($supplier_date_create!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_date_create LIKE '%".$supplier_date_create."%'";
				};
				if($supplier_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_update LIKE '%".$supplier_update."%'";
				};
				if($supplier_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_date_update LIKE '%".$supplier_date_update."%'";
				};
				if($supplier_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_revised LIKE '%".$supplier_revised."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
		//function  for export to excel
		function supplier_export_excel($supplier_id ,$supplier_kategori ,$supplier_nama ,$supplier_alamat ,$supplier_kota ,$supplier_kodepos ,$supplier_propinsi ,$supplier_negara ,$supplier_notelp ,$supplier_notelp2 ,$supplier_nofax ,$supplier_email ,$supplier_website ,$supplier_cp ,$supplier_contact_cp ,$supplier_aktif ,$supplier_creator ,$supplier_date_create ,$supplier_update ,$supplier_date_update ,$supplier_revised ,$option,$filter){
			//full query
			$query="select 
						if(supplier_kategori='','-',ifnull(supplier_kategori,'-')) AS kategori,
						ifnull(supplier_nama,'-') AS nama,
						ifnull(supplier_alamat,'-') AS alamat,
						ifnull(supplier_kota,'-') AS kota,
						ifnull(supplier_notelp,'-') AS no_tlp,
						ifnull(supplier_cp,'-') AS contact_person,
						ifnull(supplier_contact_cp,'-') AS tlp_cp,
						supplier_aktif AS status
					from supplier";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (supplier_id LIKE '%".addslashes($filter)."%' OR supplier_kategori LIKE '%".addslashes($filter)."%' OR supplier_nama LIKE '%".addslashes($filter)."%' OR supplier_alamat LIKE '%".addslashes($filter)."%' OR supplier_kota LIKE '%".addslashes($filter)."%' OR supplier_kodepos LIKE '%".addslashes($filter)."%' OR supplier_propinsi LIKE '%".addslashes($filter)."%' OR supplier_negara LIKE '%".addslashes($filter)."%' OR supplier_notelp LIKE '%".addslashes($filter)."%' OR supplier_notelp2 LIKE '%".addslashes($filter)."%' OR supplier_nofax LIKE '%".addslashes($filter)."%' OR supplier_email LIKE '%".addslashes($filter)."%' OR supplier_website LIKE '%".addslashes($filter)."%' OR supplier_cp LIKE '%".addslashes($filter)."%' OR supplier_contact_cp LIKE '%".addslashes($filter)."%' OR supplier_aktif LIKE '%".addslashes($filter)."%' OR supplier_creator LIKE '%".addslashes($filter)."%' OR supplier_date_create LIKE '%".addslashes($filter)."%' OR supplier_update LIKE '%".addslashes($filter)."%' OR supplier_date_update LIKE '%".addslashes($filter)."%' OR supplier_revised LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($supplier_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_id LIKE '%".$supplier_id."%'";
				};
				if($supplier_kategori!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_kategori LIKE '%".$supplier_kategori."%'";
				};
				if($supplier_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_nama LIKE '%".$supplier_nama."%'";
				};
				if($supplier_alamat!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_alamat LIKE '%".$supplier_alamat."%'";
				};
				if($supplier_kota!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_kota LIKE '%".$supplier_kota."%'";
				};
				if($supplier_kodepos!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_kodepos LIKE '%".$supplier_kodepos."%'";
				};
				if($supplier_propinsi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_propinsi LIKE '%".$supplier_propinsi."%'";
				};
				if($supplier_negara!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_negara LIKE '%".$supplier_negara."%'";
				};
				if($supplier_notelp!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_notelp LIKE '%".$supplier_notelp."%'";
				};
				if($supplier_notelp2!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_notelp2 LIKE '%".$supplier_notelp2."%'";
				};
				if($supplier_nofax!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_nofax LIKE '%".$supplier_nofax."%'";
				};
				if($supplier_email!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_email LIKE '%".$supplier_email."%'";
				};
				if($supplier_website!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_website LIKE '%".$supplier_website."%'";
				};
				if($supplier_cp!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_cp LIKE '%".$supplier_cp."%'";
				};
				if($supplier_contact_cp!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_contact_cp LIKE '%".$supplier_contact_cp."%'";
				};
				if($supplier_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_aktif LIKE '%".$supplier_aktif."%'";
				};
				if($supplier_creator!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_creator LIKE '%".$supplier_creator."%'";
				};
				if($supplier_date_create!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_date_create LIKE '%".$supplier_date_create."%'";
				};
				if($supplier_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_update LIKE '%".$supplier_update."%'";
				};
				if($supplier_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_date_update LIKE '%".$supplier_date_update."%'";
				};
				if($supplier_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " supplier_revised LIKE '%".$supplier_revised."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		

}
?>