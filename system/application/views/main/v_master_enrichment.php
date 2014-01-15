<?
/* 	
	GIOV Solution - Keep IT Simple
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<style type="text/css">
        p { width:650px; }
		.search-item {
			font:normal 11px tahoma, arial, helvetica, sans-serif;
			padding:3px 10px 3px 10px;
			border:1px solid #fff;
			border-bottom:1px solid #eeeeee;
			white-space:normal;
			color:#555;
		}
		.search-item h3 {
			display:block;
			font:inherit;
			font-weight:bold;
			color:#222;
		}
		
		.search-item h3 span {
			float: right;
			font-weight:normal;
			margin:0 0 5px 5px;
			width:100px;
			display:block;
			clear:none;
		}
    </style>
<script>
/* declare function */		
var master_enrichment_DataStore;
var kwitansi_enrichment_DataStore;
var card_enrichment_DataStore;
var cek_enrichment_DataStore;
var transfer_enrichment_DataStore;
//
var master_enrichment_ColumnModel;
var master_enrichmentListEditorGrid;
var master_enrichment_createForm;
var master_enrichment_createWindow;
var master_enrichment_searchForm;
var master_enrichment_searchWindow;
var master_enrichment_SelectedRow;
var master_enrichment_ContextMenu;
//for detail data
var detail_enrichment_DataStore;
var detail_enrichmentListEditorGrid;
var detail_enrichment_ColumnModel;
var detail_enrichment_proxy;
var detail_enrichment_writer;
var detail_enrichment_reader;
var editor_detail_enrichment;

//declare konstant
var enrichment_post2db = '';
var msg = '';
var enrich_pageS=20;
var today = new Date().format('d-m-Y');
var today_ultah = new Date().format('m-d');

var MIN_CREATE_DATE="<?php echo $this->m_public_function->get_permission($_SESSION[SESSION_GROUPID],37); ?>";

/* declare variable here for Field*/
var enrichment_idField;
var enrichment_noField;
var enrichment_studentField;
var enrichment_classLPField;
var enrichment_tanggalField;
//var jproduk_member_validField;
var enrich_diskonField;
var enrich_ket_diskField;
var enrichment_bayarField;
var enrichment_caraField;
var enrichment_cara2Field;
var enrichment_cara3Field;
var enrichment_keteranganField;
//tunai
var enrichment_tunai_nilaiField;
//tunai-2
var enrichment_tunai_nilai2Field;
//tunai-3
var enrichment_tunai_nilai3Field;
//voucher
var enrich_voucher_noField;
var enrich_voucher_cashbackField;
//voucher-2
var enrich_voucher_no2Field;
var enrich_voucher_cashback2Field;
//voucher-3
var enrich_voucher_no3Field;
var enrich_voucher_cashback3Field;

var enrich_cashbackField;
var is_member=false;
//kwitansi
var enrichment_kwitansi_namaField;
var enrichment_kwitansi_nilaiField;
var enrichment_kwitansi_noField;
//kwitansi-2
var enrichment_kwitansi_nama2Field;
var enrichment_kwitansi_nilai2Field;
var enrichment_kwitansi_no2Field;
//kwitansi-3
var enrichment_kwitansi_nama3Field;
var enrichment_kwitansi_nilai3Field;
var enrichment_kwitansi_no3Field;

//card
var enrichment_card_namaField;
var enrichment_card_edcField;
var enrichment_card_noField;
var enrichment_card_nilaiField;
//card-2
var enrichment_card_nama2Field;
var enrichment_card_edc2Field;
var enrichment_card_no2Field;
var enrichment_card_nilai2Field;
//card-3
var enrichment_card_nama3Field;
var enrichment_card_edc3Field;
var enrichment_card_no3Field;
var enrichment_card_nilai3Field;

//cek
var enrich_cek_namaField;
var enrich_cek_noField;
var enrich_cek_validField;
var enrich_cek_bankField;
var enrich_cek_nilaiField;
//cek-2
var enrich_cek_nama2Field;
var enrich_cek_no2Field;
var enrich_cek_valid2Field;
var enrich_cek_bank2Field;
var enrich_cek_nilai2Field;
//cek-3
var enrich_cek_nama3Field;
var enrich_cek_no3Field;
var enrich_cek_valid3Field;
var enrich_cek_bank3Field;
var enrich_cek_nilai3Field;

//transfer
var enrichment_transfer_bankField;
var enrichment_transfer_namaField;
var enrichment_transfer_nilaiField;
//transfer-2
var enrichment_transfer_bank2Field;
var enrichment_transfer_nama2Field;
var enrichment_transfer_nilai2Field;
//transfer-3
var enrichment_transfer_bank3Field;
var enrichment_transfer_nama3Field;
var enrichment_transfer_nilai3Field;

var enrichment_idSearchField;
var enrichment_noSearchField;
var enrichment_custSearchField;
var enrichment_tanggal_awalSearchField;
var enrichment_tanggal_akhirSearchField;
var enrich_diskonSearchField;
var enrichment_caraSearchField;
var enrichment_keteranganSearchField;
var enrichment_stat_dokSearchField;
var enrich_stat_timeSearchField;
var dt= new Date();

var cetak_enrichment=0;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  	Ext.util.Format.comboRenderer = function(combo){
  	    return function(value){
  	        var record = combo.findRecord(combo.valueField, value);
  	        return record ? record.get(combo.displayField) : combo.valueNotFoundText;
  	    }
  	}

/*Function utk ReadOnly */
Ext.override(Ext.form.Field, {
    setReadOnly: function(readOnly) {
        if (readOnly == this.readOnly) {
            return;
        }
        this.readOnly = readOnly;
        if (readOnly) {
            this.el.dom.setAttribute('readOnly', true);
        } else {
            this.el.dom.removeAttribute('readOnly');
        }
    }
});	
	
	/*Data Store khusus utk menampung welcome mesage */
	enrichment_welcome_msgDataStore = new Ext.data.Store({
		id: 'enrichment_welcome_msgDataStore ',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_welcome_msg&m=get_welcome_message', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results'
		},[
			{name: 'welcome_id', type: 'int', mapping: 'welcome_id'},
			{name: 'welcome_msg', type: 'string', mapping: 'welcome_msg'},
			{name: 'welcome_title', type: 'string', mapping: 'welcome_title'},
			{name: 'welcome_icon', type: 'string', mapping: 'welcome_icon'}
		]),
		sortInfo:{field: 'welcome_id', direction: "ASC"}
	});
	/*
	enrichment_welcome_msgDataStore.load({
		params: {task : "LIST", menu_id : 37},
			callback: function(opts, success, response)  {
				if (success) {					
					if(enrichment_welcome_msgDataStore.getCount()){
						if (enrichment_welcome_msgDataStore.getAt(0).data.welcome_icon == 'INFO') {
							var jproduk_icon = Ext.MessageBox.INFO;
						} else if (enrichment_welcome_msgDataStore.getAt(0).data.welcome_icon == 'WARNING'){
							var jproduk_icon = Ext.MessageBox.WARNING;
						} else if (enrichment_welcome_msgDataStore.getAt(0).data.welcome_icon == 'QUESTION'){
							var jproduk_icon = Ext.MessageBox.QUESTION;
						} else if (enrichment_welcome_msgDataStore.getAt(0).data.welcome_icon == 'ERROR'){
							var jproduk_icon = Ext.MessageBox.ERROR;
						}
						Ext.MessageBox.show({
							title: enrichment_welcome_msgDataStore.getAt(0).data.welcome_title,
							msg: enrichment_welcome_msgDataStore.getAt(0).data.welcome_msg,
							buttons: Ext.MessageBox.OK,
							animEl: 'save',
							icon: jproduk_icon
						});
					}
				}
			}
	});	
	*/
	
	function enrichment_cetak(master_id){ 
		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});	
		
		Ext.Ajax.request({   
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_master_enrichment&m=print_paper',
			params: { enrich_id : master_id}, 
			success: function(response){              
				var result=eval(response.responseText);
				switch(result){
				case 1:
					win = window.open('./jproduk_paper.html','Cetak Penjualan Produk','height=480,width=1340,resizable=1,scrollbars=0, menubar=0');
					enrich_btn_cancel();
					Ext.MessageBox.hide();
					
					master_enrichment_DataStore.load({
											params: {start: 0, limit: enrich_pageS},
											callback: function(opts, success, response){
												if(success){
													master_enrichment_createWindow.show();
													//Ext.MessageBox.alert(enrichment_post2db+' OK','Data penjualan produk berhasil disimpan');
												}
											}
										});
					
					break;
				default:
					Ext.MessageBox.show({
						title: 'Warning',
						msg: 'Unable to print the grid!',
						buttons: Ext.MessageBox.OK,
						animEl: 'save',
						icon: Ext.MessageBox.WARNING
					});
					break;
				}  
			},
			failure: function(response){
				var result=response.responseText;
				Ext.MessageBox.show({
				   title: 'Error',
				   msg: 'Could not connect to the database. retry later.',
				   buttons: Ext.MessageBox.OK,
				   animEl: 'database',
				   icon: Ext.MessageBox.ERROR
				});		
			} 	                     
		});
	}
	
	function enrichment_cetak2(master_id){ 
		Ext.Ajax.request({   
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_master_enrichment&m=print_paper2',
			params: { enrich_id : master_id}, 
			success: function(response){              
				var result=eval(response.responseText);
				switch(result){
				case 1:
					win = window.open('./jproduk_paper2.html','Cetak Penjualan Produk','height=480,width=1340,resizable=1,scrollbars=0, menubar=0');
					enrich_btn_cancel();
					break;
				default:
					Ext.MessageBox.show({
						title: 'Warning',
						msg: 'Unable to print the grid!',
						buttons: Ext.MessageBox.OK,
						animEl: 'save',
						icon: Ext.MessageBox.WARNING
					});
					break;
				}  
			},
			failure: function(response){
				var result=response.responseText;
				Ext.MessageBox.show({
				   title: 'Error',
				   msg: 'Could not connect to the database. retry later.',
				   buttons: Ext.MessageBox.OK,
				   animEl: 'database',
				   icon: Ext.MessageBox.ERROR
				});		
			} 	                     
		});
	}
	
	function enrichment_cetak_print_only(master_id){ 
		Ext.Ajax.request({   
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_master_enrichment&m=print_only',
			params: { enrich_id : master_id}, 
			success: function(response){              
				var result=eval(response.responseText);
				switch(result){
				case 1:
					win = window.open('./jproduk_paper.html','Cetak Penjualan Produk','height=480,width=1340,resizable=1,scrollbars=0, menubar=0');
					enrich_btn_cancel();
					break;
				default:
					Ext.MessageBox.show({
						title: 'Warning',
						msg: 'Unable to print the grid!',
						buttons: Ext.MessageBox.OK,
						animEl: 'save',
						icon: Ext.MessageBox.WARNING
					});
					break;
				}  
			},
			failure: function(response){
				var result=response.responseText;
				Ext.MessageBox.show({
				   title: 'Error',
				   msg: 'Could not connect to the database. retry later.',
				   buttons: Ext.MessageBox.OK,
				   animEl: 'database',
				   icon: Ext.MessageBox.ERROR
				});		
			} 	                     
		});
	}
	
	function enrichment_cetak_print_only2(master_id){ 
		Ext.Ajax.request({   
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_master_enrichment&m=print_only2',
			params: { enrich_id : master_id}, 
			success: function(response){              
				var result=eval(response.responseText);
				switch(result){
				case 1:
					win = window.open('./jproduk_paper2.html','Cetak Penjualan Produk','height=480,width=1340,resizable=1,scrollbars=0, menubar=0');
					enrich_btn_cancel();
					break;
				default:
					Ext.MessageBox.show({
						title: 'Warning',
						msg: 'Unable to print the grid!',
						buttons: Ext.MessageBox.OK,
						animEl: 'save',
						icon: Ext.MessageBox.WARNING
					});
					break;
				}  
			},
			failure: function(response){
				var result=response.responseText;
				Ext.MessageBox.show({
				   title: 'Error',
				   msg: 'Could not connect to the database. retry later.',
				   buttons: Ext.MessageBox.OK,
				   animEl: 'database',
				   icon: Ext.MessageBox.ERROR
				});		
			} 	                     
		});
	}
  
	/*Function for pengecekan _dokumen */
	function pengecekan_dokumen(){
		var enrich_tanggal_create = "";
		if(enrichment_tanggalField.getValue()!== ""){enrich_tanggal_create = enrichment_tanggalField.getValue().format('Y-m-d');} 
		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});	
		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_enrichment&m=get_action',
			params: {
				task: "CEK",
				tanggal_pengecekan	: enrich_tanggal_create
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						if (enrich_diskonField.getValue()!=0 && enrich_cashback_cfField.getValue()!=0){
							Ext.MessageBox.show({
							title: 'Warning',
							msg: 'Diskon tambahan dan Voucher hanya bisa diisi salah satu',
							buttons: Ext.MessageBox.OK,
							animEl: 'save',
							icon: Ext.MessageBox.WARNING
						});
						} 
						else
						{
							master_enrichment_create();
						}
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Penjualan Produk tidak bisa disimpan, karena telah melebihi batas hari yang diperbolehkan ',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'save',
						   icon: Ext.MessageBox.WARNING
						});
						break;
				}
			},
			failure: function(response){
				var result=response.responseText;
				Ext.MessageBox.show({
				   title: 'Error',
				   msg: 'Could not connect to the database. retry later.',
				   buttons: Ext.MessageBox.OK,
				   animEl: 'database',
				   icon: Ext.MessageBox.ERROR
				});	
			}									    
		});   
	}
  
  	/* Function for add data, open window create form */
	function master_enrichment_create(){
		/*
		var dproduk_produk_id="";
		for(i=0; i<detail_enrichment_DataStore.getCount(); i++){
			detail_jual_produk_record=detail_enrichment_DataStore.getAt(i);
			if(detail_jual_produk_record.data.denrich_jasa > 1){
				dproduk_produk_id="ada";
			}
		}
		*/
		
		var enrich_id_for_cetak = 0;
		if(enrichment_idField.getValue()!== null){
			enrich_id_for_cetak = enrichment_idField.getValue();
		}
        
		//if(enrichment_bayarField.getValue()>=0 && enrichment_bayarField.getValue()<=enrichment_totalField.getValue()){
			if(/*dproduk_produk_id=="ada"
			   && */(enrichment_post2db=="CREATE" || enrichment_post2db=="UPDATE")
			   && enrichment_stat_dokField.getValue()=='Terbuka'){
				var enrich_id_create_pk=null; 
				var enrich_no_create=null; 
				var enrich_student_create=null; 
				var enrich_tanggal_create=""; 
				var enrich_class_create=null; 
				var enrich_cara_create=null; 
				var enrich_cara2_create=null;
				var enrich_cara3_create=null; 
	
				var enrich_statdok_create=null;
				var enrich_stattime_create=null;
				var enrich_notes_create=null; 

				//tunai
				var enrich_tunai_nilai_create=null;
				//tunai-2
				var enrich_tunai_nilai2_create=null;
				//tunai-3
				var enrich_tunai_nilai3_create=null;

				//voucher
				var enrich_voucher_no_create="";
				var enrich_voucher_cashback_create=null;
				//voucher-2
				var enrich_voucher_no2_create="";
				var enrich_voucher_cashback2_create=null;
				//voucher-3
				var enrich_voucher_no3_create="";
				var enrich_voucher_cashback3_create=null;
				
				var enrich_cashback_create=null;
				//bayar
				var enrich_subtotal_create=null;
				var enrich_totalbiaya_create=null;
				var enrich_kembalian_create=null;
				var enrich_totalbayar_create=null;
				var enrich_hutang_create=null;
				//kwitansi
				var enrich_kwitansi_nama_create="";
				var enrich_kwitansi_nomor_create="";
				var enrich_kwitansi_nilai_create=null;
				//kwitansi-2
				var enrich_kwitansi_nama2_create="";
				var enrich_kwitansi_nomor2_create="";
				var enrich_kwitansi_nilai2_create=null;
				//kwitansi-3
				var enrich_kwitansi_nama3_create="";
				var enrich_kwitansi_nomor3_create="";
				var enrich_kwitansi_nilai3_create=null;
				//card
				var enrich_card_nama_create="";
				var enrich_card_edc_create="";
				var enrich_card_no_create="";
				var enrich_card_nilai_create=null;
				//card-2
				var enrich_card_nama2_create="";
				var enrich_card_edc2_create="";
				var enrich_card_no2_create="";
				var enrich_card_nilai2_create=null;
				//card -3
				var enrich_card_nama3_create="";
				var enrich_card_edc3_create="";
				var enrich_card_no3_create="";
				var enrich_card_nilai3_create=null;
				//cek
				var enrich_cek_nama_create="";
				var enrich_cek_nomor_create="";
				var enrich_cek_valid_create="";
				var enrich_cek_bank_create="";
				var enrich_cek_nilai_create=null;
				//cek 2
				var enrich_cek_nama2_create="";
				var enrich_cek_nomor2_create="";
				var enrich_cek_valid2_create="";
				var enrich_cek_bank2_create="";
				var enrich_cek_nilai2_create=null;
				//cek 3
				var enrich_cek_nama3_create="";
				var enrich_cek_nomor3_create="";
				var enrich_cek_valid3_create="";
				var enrich_cek_bank3_create="";
				var enrich_cek_nilai3_create=null;


				//transfer
				var enrich_transfer_bank_create="";
				var enrich_transfer_nama_create="";
				var enrich_transfer_nilai_create=null;
				//transfer-2
				var enrich_transfer_bank2_create="";
				var enrich_transfer_nama2_create="";
				var enrich_transfer_nilai2_create=null;
				//transfer-3
				var enrich_transfer_bank3_create="";
				var enrich_transfer_nama3_create="";
				var enrich_transfer_nilai3_create=null;
				
				if(enrichment_idField.getValue()!== null){enrich_id_create_pk = enrichment_idField.getValue();}else{enrich_id_create_pk=get_enrichment_pk();} 
				if(enrichment_noField.getValue()!== null){enrich_no_create = enrichment_noField.getValue();}
		
				if((enrichment_post2db=="CREATE") && (enrichment_studentField.getValue()!== null)){
					enrich_student_create = enrichment_studentField.getValue();
				}else if(enrichment_post2db=="UPDATE"){
					enrich_student_create = enrichment_student_idField.getValue();
				}
				if(enrichment_tanggalField.getValue()!== ""){enrich_tanggal_create = enrichment_tanggalField.getValue().format('Y-m-d');} 
				if(enrichment_classLPField.getValue()!== null){enrich_class_create = enrichment_classLPField.getValue();} 
				if(enrichment_caraField.getValue()!== null){enrich_cara_create = enrichment_caraField.getValue();} 
				if(enrichment_cara2Field.getValue()!== null){enrich_cara2_create = enrichment_cara2Field.getValue();} 
	
				if(enrichment_stat_dokField.getValue()!== null){enrich_statdok_create = enrichment_stat_dokField.getValue();}
				if(enrich_stat_timeField.getValue()!== null){enrich_stattime_create = enrich_stat_timeField.getValue();} 				
				if(enrichment_keteranganField.getValue()!== null){enrich_notes_create = enrichment_keteranganField.getValue();}
				
				//tunai
				if(enrichment_tunai_nilaiField.getValue()!== null){enrich_tunai_nilai_create = enrichment_tunai_nilaiField.getValue();}
				//tunai-2
				if(enrichment_tunai_nilai2Field.getValue()!== null){enrich_tunai_nilai2_create = enrichment_tunai_nilai2Field.getValue();}
				//tunai-3
				if(enrichment_tunai_nilai3Field.getValue()!== null){enrich_tunai_nilai3_create = enrichment_tunai_nilai3Field.getValue();}
	
				//voucher
				if(enrich_voucher_noField.getValue()!== ""){enrich_voucher_no_create = enrich_voucher_noField.getValue();}
				if(enrich_voucher_cashbackField.getValue()!== null){enrich_voucher_cashback_create = enrich_voucher_cashbackField.getValue();} 
				//voucher-2
				if(enrich_voucher_no2Field.getValue()!== ""){enrich_voucher_no2_create = enrich_voucher_no2Field.getValue();} 
				if(enrich_voucher_cashback2Field.getValue()!== null){enrich_voucher_cashback2_create = enrich_voucher_cashback2Field.getValue();} 
				//voucher-3
				if(enrich_voucher_no3Field.getValue()!== ""){enrich_voucher_no3_create = enrich_voucher_no3Field.getValue();} 
				if(enrich_voucher_cashback3Field.getValue()!== null){enrich_voucher_cashback3_create = enrich_voucher_cashback3Field.getValue();} 
				
				if(enrich_cashbackField.getValue()!== null){enrich_cashback_create = enrich_cashbackField.getValue();} 
				//bayar
				if(enrichment_bayarField.getValue()!== null){enrich_totalbayar_create = enrichment_bayarField.getValue();}
				if(enrichment_subTotalField.getValue()!== null){enrich_subtotal_create = enrichment_subTotalField.getValue();} 
				if(enrichment_totalField.getValue()!== null){enrich_totalbiaya_create = enrichment_totalField.getValue();} 
				if(enrichment_kembalianField.getValue()!== null){enrich_kembalian_create = enrichment_kembalianField.getValue();} 
				if(enrich_hutangField.getValue()!== null){enrich_hutang_create = enrich_hutangField.getValue();} 
				//kwitansi value
				if(enrichment_kwitansi_namaField.getValue()!== ""){enrich_kwitansi_nama_create = enrichment_kwitansi_namaField.getValue();} 
				if(enrichment_kwitansi_nilaiField.getValue()!== null){enrich_kwitansi_nilai_create = enrichment_kwitansi_nilaiField.getValue();} 
				//kwitansi-2 value
				if(enrichment_kwitansi_nama2Field.getValue()!== ""){enrich_kwitansi_nama2_create = enrichment_kwitansi_nama2Field.getValue();} 
				if(enrichment_kwitansi_nilai2Field.getValue()!== null){enrich_kwitansi_nilai2_create = enrichment_kwitansi_nilai2Field.getValue();} 
				//kwitansi-3 value
				if(enrichment_kwitansi_nama3Field.getValue()!== ""){enrich_kwitansi_nama3_create = enrichment_kwitansi_nama3Field.getValue();} 
				if(enrichment_kwitansi_nilai3Field.getValue()!== null){enrich_kwitansi_nilai3_create = enrichment_kwitansi_nilai3Field.getValue();} 
				//card value
				if(enrichment_card_namaField.getValue()!== ""){enrich_card_nama_create = enrichment_card_namaField.getValue();} 
				if(enrichment_card_edcField.getValue()!==""){enrich_card_edc_create = enrichment_card_edcField.getValue();} 
				if(enrichment_card_noField.getValue()!==""){enrich_card_no_create = enrichment_card_noField.getValue();}
				if(enrichment_card_nilaiField.getValue()!==null){enrich_card_nilai_create = enrichment_card_nilaiField.getValue();} 
				//card-2 value
				if(enrichment_card_nama2Field.getValue()!== ""){enrich_card_nama2_create = enrichment_card_nama2Field.getValue();} 
				if(enrichment_card_edc2Field.getValue()!==""){enrich_card_edc2_create = enrichment_card_edc2Field.getValue();} 
				if(enrichment_card_no2Field.getValue()!==""){enrich_card_no2_create = enrichment_card_no2Field.getValue();}
				if(enrichment_card_nilai2Field.getValue()!==null){enrich_card_nilai2_create = enrichment_card_nilai2Field.getValue();} 
				// card-3 value
				if(enrichment_card_nama3Field.getValue()!== ""){enrich_card_nama3_create = enrichment_card_nama3Field.getValue();} 
				if(enrichment_card_edc3Field.getValue()!==""){enrich_card_edc3_create = enrichment_card_edc3Field.getValue();} 
				if(enrichment_card_no3Field.getValue()!==""){enrich_card_no3_create = enrichment_card_no3Field.getValue();}
				if(enrichment_card_nilai3Field.getValue()!==null){enrich_card_nilai3_create = enrichment_card_nilai3Field.getValue();} 
				//cek value
				if(enrich_cek_namaField.getValue()!== ""){enrich_cek_nama_create = enrich_cek_namaField.getValue();} 
				if(enrich_cek_noField.getValue()!== ""){enrich_cek_nomor_create = enrich_cek_noField.getValue();} 
				if(enrich_cek_validField.getValue()!== ""){enrich_cek_valid_create = enrich_cek_validField.getValue().format('Y-m-d');} 
				if(enrich_cek_bankField.getValue()!== ""){enrich_cek_bank_create = enrich_cek_bankField.getValue();} 
				if(enrich_cek_nilaiField.getValue()!== null){enrich_cek_nilai_create = enrich_cek_nilaiField.getValue();} 
				//cek 2 value
				if(enrich_cek_nama2Field.getValue()!== ""){enrich_cek_nama2_create = enrich_cek_nama2Field.getValue();} 
				if(enrich_cek_no2Field.getValue()!== ""){enrich_cek_nomor2_create = enrich_cek_no2Field.getValue();} 
				if(enrich_cek_valid2Field.getValue()!== ""){enrich_cek_valid2_create = enrich_cek_valid2Field.getValue().format('Y-m-d');} 
				if(enrich_cek_bank2Field.getValue()!== ""){enrich_cek_bank2_create = enrich_cek_bank2Field.getValue();} 
				if(enrich_cek_nilai2Field.getValue()!== null){enrich_cek_nilai2_create = enrich_cek_nilai2Field.getValue();} 
				//cek 3 value
				if(enrich_cek_nama3Field.getValue()!== ""){enrich_cek_nama3_create = enrich_cek_nama3Field.getValue();} 
				if(enrich_cek_no3Field.getValue()!== ""){enrich_cek_nomor3_create = enrich_cek_no3Field.getValue();} 
				if(enrich_cek_valid3Field.getValue()!== ""){enrich_cek_valid3_create = enrich_cek_valid3Field.getValue().format('Y-m-d');} 
				if(enrich_cek_bank3Field.getValue()!== ""){enrich_cek_bank3_create = enrich_cek_bank3Field.getValue();} 
				if(enrich_cek_nilai3Field.getValue()!== null){enrich_cek_nilai3_create = enrich_cek_nilai3Field.getValue();} 

				//transfer value
				if(enrichment_transfer_bankField.getValue()!== ""){enrich_transfer_bank_create = enrichment_transfer_bankField.getValue();} 
				if(enrichment_transfer_namaField.getValue()!== ""){enrich_transfer_nama_create = enrichment_transfer_namaField.getValue();}
				if(enrichment_transfer_nilaiField.getValue()!== null){enrich_transfer_nilai_create = enrichment_transfer_nilaiField.getValue();} 
				//transfer-2 value
				if(enrichment_transfer_bank2Field.getValue()!== ""){enrich_transfer_bank2_create = enrichment_transfer_bank2Field.getValue();} 
				if(enrichment_transfer_nama2Field.getValue()!== ""){enrich_transfer_nama2_create = enrichment_transfer_nama2Field.getValue();}
				if(enrichment_transfer_nilai2Field.getValue()!== null){enrich_transfer_nilai2_create = enrichment_transfer_nilai2Field.getValue();} 
				//transfer-3 value
				if(enrichment_transfer_bank3Field.getValue()!== ""){enrich_transfer_bank3_create = enrichment_transfer_bank3Field.getValue();} 
				if(enrichment_transfer_nama3Field.getValue()!== ""){enrich_transfer_nama3_create = enrichment_transfer_nama3Field.getValue();}
				if(enrichment_transfer_nilai3Field.getValue()!== null){enrich_transfer_nilai3_create = enrichment_transfer_nilai3Field.getValue();} 

				var cetak_enrichment = this.cetak_enrichment;
				var denrich_id=[];
				var denrich_jasa=[];
				var denrich_subtot=[];
				var denrich_satuan=[];
				var denrich_jumlah=[];
				var denrich_price=[];
				var denrich_disc=[];
				var denrich_diskon_jenis=[];
				var dcount = detail_enrichment_DataStore.getCount() - 1;
				
				if(detail_enrichment_DataStore.getCount()>0){
					for(i=0; i<detail_enrichment_DataStore.getCount();i++){
						if(
						   detail_enrichment_DataStore.getAt(i).data.denrich_jasa!==undefined
						   && detail_enrichment_DataStore.getAt(i).data.denrich_jasa!==''
						   && detail_enrichment_DataStore.getAt(i).data.denrich_jasa!==0){
							
							denrich_id.push(detail_enrichment_DataStore.getAt(i).data.denrich_id);
							denrich_jasa.push(detail_enrichment_DataStore.getAt(i).data.denrich_jasa);
							
							if((detail_enrichment_DataStore.getAt(i).data.denrich_satuan==undefined)
							   || (detail_enrichment_DataStore.getAt(i).data.denrich_satuan=='')){
								denrich_satuan.push(0);
							}else{
								denrich_satuan.push(detail_enrichment_DataStore.getAt(i).data.denrich_satuan);
							}
							
							if(detail_enrichment_DataStore.getAt(i).data.denrich_jumlah==undefined){
								denrich_jumlah.push(0);
							}else{
								denrich_jumlah.push(detail_enrichment_DataStore.getAt(i).data.denrich_jumlah);
							}
							
							if(detail_enrichment_DataStore.getAt(i).data.denrich_price==undefined){
								denrich_price.push(0);
							}else{
								denrich_price.push(detail_enrichment_DataStore.getAt(i).data.denrich_price);
							}
							
							if(detail_enrichment_DataStore.getAt(i).data.denrich_diskon_jenis==undefined){
								denrich_diskon_jenis.push('');
							}else{
								denrich_diskon_jenis.push(detail_enrichment_DataStore.getAt(i).data.denrich_diskon_jenis);
							}
							
							if((detail_enrichment_DataStore.getAt(i).data.denrich_disc==undefined)
							   || (detail_enrichment_DataStore.getAt(i).data.denrich_disc=='')){
								denrich_disc.push(0);
							}else{
								denrich_disc.push(detail_enrichment_DataStore.getAt(i).data.denrich_disc);
							}
							
							if((detail_enrichment_DataStore.getAt(i).data.denrich_subtot==undefined)){
								denrich_subtot.push(0);
							}else{
								denrich_subtot.push(detail_enrichment_DataStore.getAt(i).data.denrich_subtot);
							}
						}
						
						if(i==dcount){
							var encoded_array_denrich_id = Ext.encode(denrich_id);
							var encoded_array_denrich_jasa = Ext.encode(denrich_jasa);
							var encoded_array_denrich_satuan = Ext.encode(denrich_satuan);
							var encoded_array_denrich_jumlah = Ext.encode(denrich_jumlah);
							var encoded_array_denrich_price = Ext.encode(denrich_price);
							var encoded_array_denrich_diskon_jenis = Ext.encode(denrich_diskon_jenis);
							var encoded_array_denrich_disc = Ext.encode(denrich_disc);
							var encoded_array_denrich_subtot = Ext.encode(denrich_subtot);
							
							Ext.Ajax.request({
								waitMsg: 'Mohon tunggu...',
								url: 'index.php?c=c_master_enrichment&m=get_action',
								params: {
									task 					: 	enrichment_post2db,
									cetak_enrichment 		: 	cetak_enrichment,
									enrich_id				: 	enrich_id_create_pk, 
									enrich_no				: 	enrich_no_create, 
									enrich_student			: 	enrich_student_create, 
									enrich_tanggal			: 	enrich_tanggal_create, 
									enrich_class			: 	enrich_class_create, 
									enrich_cara				: 	enrich_cara_create, 
									enrich_cara2			: 	enrich_cara2_create, 
									enrich_cara3			: 	enrich_cara3_create, 
					
									enrich_stat_dok			:	enrich_statdok_create,
									enrich_stat_time		:	enrich_stattime_create,
									enrich_note				: 	enrich_notes_create, 
							 
									enrich_cashback			: 	enrich_cashback_create,
									//tunai
									enrich_tunai_nilai		:	enrich_tunai_nilai_create,
									//tunai-2
									enrich_tunai_nilai2		:	enrich_tunai_nilai2_create,
									//tunai-3
									enrich_tunai_nilai3 	: 	enrich_tunai_nilai3_create,
		
									//voucher
									enrich_voucher_no		:	enrich_voucher_no_create,
									enrich_voucher_cashback :	enrich_voucher_cashback_create,
									//voucher-2
									enrich_voucher_no2		:	enrich_voucher_no2_create,
									enrich_voucher_cashback2:	enrich_voucher_cashback2_create,
									//voucher-3
									enrich_voucher_no3		:	enrich_voucher_no3_create,
									enrich_voucher_cashback3:	enrich_voucher_cashback3_create,
									
									//bayar
									enrich_total_bayar		: 	enrich_totalbayar_create,
									enrich_subtotal			: 	enrich_subtotal_create,
									enrich_total_biaya		: 	enrich_totalbiaya_create,
									enrich_kembalian		: 	enrich_kembalian_create,
									enrich_hutang			: 	enrich_hutang_create,
									//kwitansi posting
									enrich_kwitansi_id		: 	enrich_kwitansi_idField1.getValue(),
									enrich_kwitansi_no		:	enrichment_kwitansi_noField.getValue(),
									enrich_kwitansi_nama	:	enrich_kwitansi_nama_create,
									enrich_kwitansi_nilai	:	enrich_kwitansi_nilai_create,
									//kwitansi-2 posting
									enrich_kwitansi_id2		: 	enrich_kwitansi_idField2.getValue(),
									enrich_kwitansi_no2		:	enrichment_kwitansi_no2Field.getValue(),
									enrich_kwitansi_nama2	:	enrich_kwitansi_nama2_create,
									enrich_kwitansi_nilai2	:	enrich_kwitansi_nilai2_create,
									//kwitansi-3 posting
									enrich_kwitansi_id3		: 	enrich_kwitansi_idField3.getValue(),
									enrich_kwitansi_no3		:	enrichment_kwitansi_no3Field.getValue(),
									enrich_kwitansi_nama3	:	enrich_kwitansi_nama3_create,
									enrich_kwitansi_nilai3	:	enrich_kwitansi_nilai3_create,

									//card posting
									enrich_card_nama		: 	enrich_card_nama_create,
									enrich_card_edc			:	enrich_card_edc_create,
									enrich_card_no			:	enrich_card_no_create,
									enrich_card_nilai		:	enrich_card_nilai_create,
									//card-2 posting
									enrich_card_nama2		: 	enrich_card_nama2_create,
									enrich_card_edc2		:	enrich_card_edc2_create,
									enrich_card_no2			:	enrich_card_no2_create,
									enrich_card_nilai2		:	enrich_card_nilai2_create,
									//card-3 posting
									enrich_card_nama3		: 	enrich_card_nama3_create,
									enrich_card_edc3		:	enrich_card_edc3_create,
									enrich_card_no3			:	enrich_card_no3_create,
									enrich_card_nilai3		:	enrich_card_nilai3_create,

									//cek posting
									enrich_cek_nama			: 	enrich_cek_nama_create,
									enrich_cek_no			:	enrich_cek_nomor_create,
									enrich_cek_valid		: 	enrich_cek_valid_create,
									enrich_cek_bank			:	enrich_cek_bank_create,
									enrich_cek_nilai		:	enrich_cek_nilai_create,
									//cek 2 posting
									enrich_cek_nama2		: 	enrich_cek_nama2_create,
									enrich_cek_no2			:	enrich_cek_nomor2_create,
									enrich_cek_valid2		: 	enrich_cek_valid2_create,
									enrich_cek_bank2		:	enrich_cek_bank2_create,
									enrich_cek_nilai2		:	enrich_cek_nilai2_create,
									//cek 3 posting
									enrich_cek_nama3		: 	enrich_cek_nama3_create,
									enrich_cek_no3			:	enrich_cek_nomor3_create,
									enrich_cek_valid3		: 	enrich_cek_valid3_create,
									enrich_cek_bank3		:	enrich_cek_bank3_create,
									enrich_cek_nilai3		:	enrich_cek_nilai3_create,

		
									//transfer posting
									enrich_transfer_bank	:	enrich_transfer_bank_create,
									enrich_transfer_nama	:	enrich_transfer_nama_create,
									enrich_transfer_nilai	:	enrich_transfer_nilai_create,
									//transfer-2 posting
									enrich_transfer_bank2	:	enrich_transfer_bank2_create,
									enrich_transfer_nama2	:	enrich_transfer_nama2_create,
									enrich_transfer_nilai2	:	enrich_transfer_nilai2_create,
									//transfer-3 posting
									enrich_transfer_bank3	:	enrich_transfer_bank3_create,
									enrich_transfer_nama3	:	enrich_transfer_nama3_create,
									enrich_transfer_nilai3	:	enrich_transfer_nilai3_create,
									
									//Data Detail Penjualan Produk
									denrich_id			: encoded_array_denrich_id,
									denrich_jasa		: encoded_array_denrich_jasa,
									denrich_satuan		: encoded_array_denrich_satuan,
									denrich_jumlah		: encoded_array_denrich_jumlah,
									denrich_price		: encoded_array_denrich_price,
									denrich_diskon_jenis: encoded_array_denrich_diskon_jenis,
									denrich_disc		: encoded_array_denrich_disc,
									denrich_subtot 		: encoded_array_denrich_subtot
								}, 
								success: function(response){
									Ext.MessageBox.hide();
									var result=eval(response.responseText);
									if(result==0){
										enrich_btn_cancel();
										//show_windowGrid();
										master_enrichment_DataStore.load({
											params: {start: 0, limit: enrich_pageS, task: "LIST"},
											callback: function(opts, success, response){
												if(success){
													master_enrichment_createWindow.show();
													Ext.MessageBox.alert(enrichment_post2db+' OK','Your Data has been saved');
												}
											}
										});
										//master_enrichment_createWindow.hide();
									}else if(result>0 && cetak_enrichment == 2){
										enrichment_cetak2(result);
										enrich_btn_cancel();
									}else if(result>0){
										// enrichment_cetak(result); // dimatikan dulu sampe query di M di benerin
										Ext.MessageBox.alert(enrichment_post2db+' OK','Your Data has been saved');
										enrich_btn_cancel();
									}else{
										enrich_btn_cancel();
										Ext.MessageBox.show({
										   title: 'Warning',
										   msg: 'Data cannot be saved',
										   buttons: Ext.MessageBox.OK,
										   animEl: 'save',
										   icon: Ext.MessageBox.WARNING
										});
									}
								},
								failure: function(response){
									var result=response.responseText;
									Ext.MessageBox.show({
										   title: 'Error',
										   msg: 'Could not connect to the database. retry later.',
										   buttons: Ext.MessageBox.OK,
										   animEl: 'database',
										   icon: Ext.MessageBox.ERROR
									});
									enrich_btn_cancel();
								}                      
							});
						}
					}
				}
				
			}else if(enrichment_post2db=='UPDATE' && enrichment_stat_dokField.getValue()=='Tertutup'){
				if(cetak_enrichment==1){
					// enrichment_cetak(enrich_id_for_cetak); // di matiin dl sampe query di M di perbaikin
					cetak_enrichment=0;
				}else if(cetak_enrichment==2){
					// enrichment_cetak2(enrich_id_for_cetak); //di matiin dl sampe query di M di perbaikin
					cetak_enrichment=0;
				}
				enrich_btn_cancel();
			}else if(enrichment_post2db=='UPDATE' && enrichment_stat_dokField.getValue()=='Batal'){
				Ext.Ajax.request({  
					waitMsg: 'Mohon  Tunggu...',
					url: 'index.php?c=c_master_enrichment&m=get_action',
					params: {
						task: 'BATAL',
						enrich_id	: enrichment_idField.getValue(),
						enrich_tanggal : enrichment_tanggalField.getValue().format('Y-m-d')
					}, 
					success: function(response){             
						var result=eval(response.responseText);
						if(result==1){
							enrichment_post2db='CREATE';
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Dokumen Penjualan Produk telah dibatalkan.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'save',
							   icon: Ext.MessageBox.OK
							});
							enrich_btn_cancel();
						}else{
							enrichment_post2db='CREATE';
							Ext.MessageBox.show({
							   title: 'Warning',
							   width: 400,
							   msg: 'Dokumen Penjualan Produk tidak bisa dibatalkan, <br/>karena yang boleh dibatalkan adalah Dokumen yang terbit hari ini saja.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'save',
							   icon: Ext.MessageBox.WARNING
							});
							enrich_btn_cancel();
						}
					},
					failure: function(response){
						enrichment_post2db='CREATE';
						var result=response.responseText;
						Ext.MessageBox.show({
							   title: 'Error',
							   msg: 'Could not connect to the database. retry later.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'database',
							   icon: Ext.MessageBox.ERROR
						});
						enrich_btn_cancel();
					}                      
				});
			}else {
				if(dproduk_produk_id!="ada"){
					Ext.MessageBox.show({
						title: 'Warning',
						msg: 'Detail penjualan produk tidak boleh kosong',
						buttons: Ext.MessageBox.OK,
						minWidth: 250,
						animEl: 'save',
						icon: Ext.MessageBox.WARNING
					});
				}else {
					Ext.MessageBox.show({
						title: 'Warning',
						msg: 'Form anda belum lengkap',
						buttons: Ext.MessageBox.OK,
						animEl: 'save',
						icon: Ext.MessageBox.WARNING
					});
				}
			}
			/*
		}else{
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Maaf, kelebihan jumlah bayar.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
		*/
	}
 	/* End of Function */
	
	function save_andPrint(){
		cetak_enrichment=1;
		pengecekan_dokumen();
		enrichment_pesanLabel.setText('');
		enrich_lunasLabel.setText('');
		enrich_cust_priorityLabel.setText('');
	}
	
	function save_andPrint2(){
		cetak_enrichment=2;
		pengecekan_dokumen();
		enrichment_pesanLabel.setText('');
		enrich_lunasLabel.setText('');
		enrich_cust_priorityLabel.setText('');
	}
	
	function save_button(){
		cetak_enrichment=0;
		pengecekan_dokumen();
	}
	
	//function ini untuk melakukan print saja, tanpa perlu melakukan proses pengecekan dokumen.. 
	function print_only(){
		if(enrichment_idField.getValue()==''){
			Ext.MessageBox.show({
			msg: 'Faktur tidak dapat dicetak, karena data kosong',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		}
		else{
		cetak_enrichment=1;		
		var enrich_id_for_cetak = 0;
		if(enrichment_idField.getValue()!== null){
			enrich_id_for_cetak = enrichment_idField.getValue();
		}
		if(cetak_enrichment==1){
			enrichment_cetak_print_only(enrich_id_for_cetak);
			cetak_enrichment=0;
		}
		}
	}
	
	function print_only2(){
		if(enrichment_idField.getValue()==''){
			Ext.MessageBox.show({
			msg: 'Faktur tidak dapat dicetak, karena data kosong',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		}
		else{
		cetak_enrichment=2;		
		var enrich_id_for_cetak = 0;
		if(enrichment_idField.getValue()!== null){
			enrich_id_for_cetak = enrichment_idField.getValue();
		}
		if(cetak_enrichment==2){
			enrichment_cetak_print_only2(enrich_id_for_cetak);
			cetak_enrichment=0;
		}
		}
	}
  
  	/* Function for get PK field */
	function get_enrichment_pk(){
		if(enrichment_post2db=='UPDATE')
			return master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_id');
		else 
			return 0;
	}
	/* End of Function  */
	
    /* Function for get PK field */
	function get_stat_dok(){
		if(enrichment_post2db=='UPDATE')
			return master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_stat_dok');
		else 
			return 'Terbuka';
	}
	/* End of Function  */
	
	// Reset kwitansi option
	function kwitansi_enrichment_reset_form(){
		enrichment_kwitansi_namaField.reset();
		enrichment_kwitansi_nilaiField.reset();
		enrich_kwitansi_nilai_cfField.reset();
		enrichment_kwitansi_noField.reset();
		enrich_kwitansi_sisaField.reset();
		enrichment_kwitansi_namaField.setValue("");
		enrichment_kwitansi_nilaiField.setValue(null);
		enrich_kwitansi_nilai_cfField.setValue(null);
		enrichment_kwitansi_noField.setValue("");
		enrich_kwitansi_sisaField.setValue(null);
		enrich_kwitansi_idField1.reset();
		enrich_kwitansi_idField1.setValue(null);
	}
	// Reset kwitansi-2 option
	function kwitansi2_enrichment_reset_form(){
		enrichment_kwitansi_nama2Field.reset();
		enrichment_kwitansi_nilai2Field.reset();
		enrich_kwitansi_nilai2_cfField.reset();
		enrichment_kwitansi_no2Field.reset();
		enrich_kwitansi_sisa2Field.reset();
		enrichment_kwitansi_nama2Field.setValue("");
		enrichment_kwitansi_nilai2Field.setValue(null);
		enrich_kwitansi_nilai2_cfField.setValue(null);
		enrichment_kwitansi_no2Field.setValue("");
		enrich_kwitansi_sisa2Field.setValue(null);
		enrich_kwitansi_idField2.reset();
		enrich_kwitansi_idField2.setValue(null);
	}
	// Reset kwitansi-3 option
	function kwitansi3_enrichment_reset_form(){
		enrichment_kwitansi_nama3Field.reset();
		enrichment_kwitansi_nilai3Field.reset();
		enrich_kwitansi_nilai3_cfField.reset();
		enrichment_kwitansi_no3Field.reset();
		enrich_kwitansi_sisa3Field.reset();
		enrichment_kwitansi_nama3Field.setValue("");
		enrichment_kwitansi_nilai3Field.setValue(null);
		enrich_kwitansi_nilai3_cfField.setValue(null);
		enrichment_kwitansi_no3Field.setValue("");
		enrich_kwitansi_sisa3Field.setValue(null);
		enrich_kwitansi_idField3.reset();
		enrich_kwitansi_idField3.setValue(null);
	}
	
	// Reset card option
	function card_enrichment_reset_form(){
		enrichment_card_namaField.reset();
		enrichment_card_edcField.reset();
		enrichment_card_noField.reset();
		enrichment_card_nilaiField.reset();
		enrich_card_nilai_cfField.reset();
		enrichment_card_namaField.setValue("");
		enrichment_card_edcField.setValue("");
		enrichment_card_noField.setValue("");
		enrichment_card_nilaiField.setValue(null);
		enrich_card_nilai_cfField.setValue(null);
	}
	// Reset card-2 option
	function card2_enrichment_reset_form(){
		enrichment_card_nama2Field.reset();
		enrichment_card_edc2Field.reset();
		enrichment_card_no2Field.reset();
		enrichment_card_nilai2Field.reset();
		enrich_card_nilai2_cfField.reset();
		enrichment_card_nama2Field.setValue("");
		enrichment_card_edc2Field.setValue("");
		enrichment_card_no2Field.setValue("");
		enrichment_card_nilai2Field.setValue(null);
		enrich_card_nilai2_cfField.setValue(null);
	}
	// Reset card-3 option
	function card3_enrichment_reset_form(){
		enrichment_card_nama3Field.reset();
		enrichment_card_edc3Field.reset();
		enrichment_card_no3Field.reset();
		enrichment_card_nilai3Field.reset();
		enrich_card_nilai3_cfField.reset();
		enrichment_card_nama3Field.setValue("");
		enrichment_card_edc3Field.setValue("");
		enrichment_card_no3Field.setValue("");
		enrichment_card_nilai3Field.setValue(null);
		enrich_card_nilai3_cfField.setValue(null);
	}
	
	// Reset cek option
	function cek_jual_produk_reset_form(){
		enrich_cek_namaField.reset();
		enrich_cek_noField.reset();
		enrich_cek_validField.reset();
		enrich_cek_bankField.reset();
		enrich_cek_nilaiField.reset();
		enrich_cek_nilai_cfField.reset();
		enrich_cek_namaField.setValue(null);
		enrich_cek_noField.setValue("");
		enrich_cek_validField.setValue("");
		enrich_cek_bankField.setValue("");
		enrich_cek_nilaiField.setValue(null);
		enrich_cek_nilai_cfField.setValue(null);
	}
	// Reset cek-2 option
	function cek2_jual_produk_reset_form(){
		enrich_cek_nama2Field.reset();
		enrich_cek_no2Field.reset();
		enrich_cek_valid2Field.reset();
		enrich_cek_bank2Field.reset();
		enrich_cek_nilai2Field.reset();
		enrich_cek_nilai2_cfField.reset();
		enrich_cek_nama2Field.setValue(null);
		enrich_cek_no2Field.setValue("");
		enrich_cek_valid2Field.setValue("");
		enrich_cek_bank2Field.setValue("");
		enrich_cek_nilai2Field.setValue(null);
		enrich_cek_nilai2_cfField.setValue(null);
	}
	// Reset cek-3 option
	function cek3_jual_produk_reset_form(){
		enrich_cek_nama3Field.reset();
		enrich_cek_no3Field.reset();
		enrich_cek_valid3Field.reset();
		enrich_cek_bank3Field.reset();
		enrich_cek_nilai3Field.reset();
		enrich_cek_nilai3_cfField.reset();
		enrich_cek_nama3Field.setValue(null);
		enrich_cek_no3Field.setValue("");
		enrich_cek_valid3Field.setValue("");
		enrich_cek_bank3Field.setValue("");
		enrich_cek_nilai3Field.setValue(null);
		enrich_cek_nilai3_cfField.setValue(null);
	}
	
	// Reset transfer option
	function transfer_enrichment_reset_form(){
		enrichment_transfer_bankField.reset();
		enrichment_transfer_namaField.reset();
		enrichment_transfer_nilaiField.reset();
		enrich_transfer_nilai_cfField.reset();
		enrichment_transfer_bankField.setValue("");
		enrichment_transfer_namaField.setValue(null);
		enrichment_transfer_nilaiField.setValue(null);
		enrich_transfer_nilai_cfField.setValue(null);
	}
	// Reset transfer-2 option
	function transfer2_enrichment_reset_form(){
		enrichment_transfer_bank2Field.reset();
		enrichment_transfer_nama2Field.reset();
		enrichment_transfer_nilai2Field.reset();
		enrich_transfer_nilai2_cfField.reset();
		enrichment_transfer_bank2Field.setValue("");
		enrichment_transfer_nama2Field.setValue(null);
		enrichment_transfer_nilai2Field.setValue(null);
		enrich_transfer_nilai2_cfField.setValue(null);
	}
	// Reset transfer-3 option
	function transfer3_enrichment_reset_form(){
		enrichment_transfer_bank3Field.reset();
		enrichment_transfer_nama3Field.reset();
		enrichment_transfer_nilai3Field.reset();
		enrich_transfer_nilai3_cfField.reset();
		enrichment_transfer_bank3Field.setValue("");
		enrichment_transfer_nama3Field.setValue(null);
		enrichment_transfer_nilai3Field.setValue(null);
		enrich_transfer_nilai3_cfField.setValue(null);
	}

	// Reset tunai option
	function tunai_enrichment_reset_form(){
		enrichment_tunai_nilaiField.reset();
		enrichment_tunai_nilaiField.setValue(null);
		enrichment_tunai_nilai_cfField.reset();
		enrichment_tunai_nilai_cfField.setValue(null);
	}
	// Reset tunai-2 option
	function tunai2_enrichment_reset_form(){
		enrichment_tunai_nilai2Field.reset();
		enrichment_tunai_nilai2Field.setValue(null);
		enrich_tunai_nilai2_cfField.reset();
		enrich_tunai_nilai2_cfField.setValue(null);
	}
	// Reset tunai-3 option
	function tunai3_enrichment_reset_form(){
		enrichment_tunai_nilai3Field.reset();
		enrichment_tunai_nilai3Field.setValue(null);
		enrich_tunai_nilai3_cfField.reset();
		enrich_tunai_nilai3_cfField.setValue(null);
	}

	//Reset voucher option
	function voucher_jual_produk_reset_form(){
		enrich_voucher_noField.reset();
		enrich_voucher_cashbackField.reset();
		enrich_voucher_cashback_cfField.reset();
		enrich_voucher_noField.setValue("");
		enrich_voucher_cashbackField.setValue(null);
		enrich_voucher_cashback_cfField.setValue(null);
	}
	//Reset voucher-2 option
	function voucher2_jual_produk_reset_form(){
		enrich_voucher_no2Field.reset();
		enrich_voucher_cashback2Field.reset();
		enrich_voucher_cashback2_cfField.reset();
		enrich_voucher_no2Field.setValue("");
		enrich_voucher_cashback2Field.setValue(null);
		enrich_voucher_cashback2_cfField.setValue(null);
	}
	//Reset voucher-3 option
	function voucher3_jual_produk_reset_form(){
		enrich_voucher_no3Field.reset();
		enrich_voucher_cashback3Field.reset();
		enrich_voucher_cashback3_cfField.reset();
		enrich_voucher_no3Field.setValue("");
		enrich_voucher_cashback3Field.setValue(null);
		enrich_voucher_cashback3_cfField.setValue(null);
	}
	
	/* Reset form before loading */
	function master_enrichment_reset_form(){
		enrichment_idField.reset();
		enrichment_idField.setValue(null);
		enrich_karyawanField.reset();
		enrich_karyawanField.setValue(null);
		enrich_nikkaryawanField.reset();
		enrich_nikkaryawanField.setValue(null);
		enrichment_noField.reset();
		enrichment_noField.setValue(null);
		enrichment_studentField.reset();
		enrichment_studentField.setValue(null);
		enrichment_classLPField.reset();
		enrichment_classLPField.setValue(null);
		enrich_cust_nomemberField.reset();
		enrich_cust_nomemberField.setValue(null);
		enrich_valid_memberField.setValue("");
		enrich_cust_ultahField.setValue("");
		enrichment_tanggalField.setValue(dt.format('Y-m-d'));
		enrich_diskonField.reset();
		enrich_diskonField.setValue(null);
		enrichment_stat_dokField.reset();
		enrichment_stat_dokField.setValue('Terbuka');
		enrich_stat_timeField.reset();
		enrich_stat_timeField.setValue('Pagi');
		enrichment_caraField.reset();
		enrichment_caraField.setValue(null);
		enrichment_cara2Field.reset();
		enrichment_cara2Field.setValue(null);
		enrichment_cara3Field.reset();
		enrichment_cara3Field.setValue(null);
		
		enrich_cashbackField.reset();
		enrich_cashbackField.setValue(null);
		enrich_cashback_cfField.reset();
		enrich_cashback_cfField.setValue(null);
		
		enrich_ket_diskField.reset();
		enrich_ket_diskField.setValue(null);
		
		enrichment_keteranganField.reset();
		enrichment_keteranganField.setValue(null);

		enrichment_subTotalField.reset();
		enrichment_subTotalField.setValue(null);
		enrichment_subTotal_cfField.reset();
		enrichment_subTotal_cfField.setValue(null);
		enrichment_subTotalLabel.reset();
		enrichment_subTotalLabel.setValue(null);

		enrichment_totalField.reset();
		enrichment_totalField.setValue(null);

		enrichment_kembalianField.reset();
		enrichment_kembalianField.setValue(null);

		enrichment_total_cfField.reset();
		enrichment_total_cfField.setValue(null);
		enrichment_TotalLabel.reset();
		enrichment_TotalLabel.setValue(null);

		enrichment_kembalianLabel.reset();
		enrichment_kembalianLabel.setValue(null);

		enrich_hutangField.reset();
		enrich_hutangField.setValue(null);
		enrich_hutang_cfField.reset();
		enrich_hutang_cfField.setValue(null);
		enrichment_sisabayarLabel.reset();
		enrichment_sisabayarLabel.setValue(null);

		enrich_jumlahField.reset();
		enrich_jumlahField.setValue(null);
		enrich_jumlahLabel.reset();
		enrich_jumlahLabel.setValue(null);
		
		enrichment_pesanLabel.setText("");

		tunai_enrichment_reset_form();
		tunai2_enrichment_reset_form();
		tunai3_enrichment_reset_form();

		kwitansi_enrichment_reset_form();
		kwitansi2_enrichment_reset_form();
		kwitansi3_enrichment_reset_form();

		card_enrichment_reset_form();
		card2_enrichment_reset_form();
		card3_enrichment_reset_form();

		cek_jual_produk_reset_form();
		cek2_jual_produk_reset_form();
		cek3_jual_produk_reset_form();

		transfer_enrichment_reset_form();
		transfer2_enrichment_reset_form();
		transfer3_enrichment_reset_form();

		voucher_jual_produk_reset_form();
		voucher2_jual_produk_reset_form();
		voucher3_jual_produk_reset_form();

		update_group_carabayar_enrichment();
		update_group_carabayar2_enrichment();
		update_group_carabayar3_enrichment();

		enrichment_bayarField.reset();
		enrichment_bayarField.setValue(null);
		enrichment_bayar_cfField.reset();
		enrichment_bayar_cfField.setValue(null);
		enrichment_TotalBayarLabel.reset();
		enrichment_TotalBayarLabel.setValue(null);
		
		/* Enable if jpaket_post2db="CREATE" */
		enrichment_studentField.setDisabled(false);
		enrichment_classLPField.setDisabled(false);
		enrichment_tanggalField.setDisabled(false);
		enrich_karyawanField.setDisabled(false);
		enrich_nikkaryawanField.setDisabled(false);
		enrichment_tanggalField.setDisabled(false);
		enrichment_keteranganField.setDisabled(false);
		enrichment_master_cara_bayarTabPanel.setDisabled(false);
		detail_enrichmentListEditorGrid.setDisabled(false);
		enrich_diskonField.setDisabled(false);
		enrich_cashback_cfField.setDisabled(false);
		enrich_ket_diskField.setDisabled(false);
		enrichment_stat_dokField.setDisabled(false);
		enrich_stat_timeField.setDisabled(false);
		enrichment_tunai_nilai_cfField.setDisabled(false);
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_ENRICHMENT'))){ ?>
		detail_enrichmentListEditorGrid.denrich_add.enable();
        detail_enrichmentListEditorGrid.denrich_delete.enable();
		<?php } ?>
		
		enrichment_caraField.setDisabled(false);
		master_enrichment_tunaiGroup.setDisabled(false);
		master_enrichment_cardGroup.setDisabled(false);
		master_enrichment_cekGroup.setDisabled(false);
		master_enrichment_kwitansiGroup.setDisabled(false);
		master_enrichment_transferGroup.setDisabled(false);
		master_enrichment_voucherGroup.setDisabled(false);
		
		enrichment_cara2Field.setDisabled(false);
		master_enrichment_tunai2Group.setDisabled(false);
		master_enrichment_card2Group.setDisabled(false);
		master_enrichment_cek2Group.setDisabled(false);
		master_enrichment_kwitansi2Group.setDisabled(false);
		master_enrichment_transfer2Group.setDisabled(false);
		master_enrichment_voucher2Group.setDisabled(false);
		
		enrichment_cara3Field.setDisabled(false);
		master_enrichment_tunai3Group.setDisabled(false);
		master_enrichment_card3Group.setDisabled(false);
		master_enrichment_cek3Group.setDisabled(false);
		master_enrichment_kwitansi3Group.setDisabled(false);
		master_enrichment_transfer3Group.setDisabled(false);
		master_enrichment_voucher3Group.setDisabled(false);
		
		combo_jual_enrichment.setDisabled(false);
		combo_satuan_enrichment.setDisabled(false);
		djumlah_beli_enrichmentField.setDisabled(false);
		dharga_enrichment_konversiField.setDisabled(true);
		denrich_sub_totalField.setDisabled(false);
		// denrich_sub_totalField.setDisabled(false);
		denrich_jenis_diskonField.setDisabled(false);
		denrich_jumlah_diskonField.setDisabled(false);
		denrich_subtotal_netField.setDisabled(true);
		combo_enrich_supplier.setDisabled(false);
		denrich_harga_defaultField.setDisabled(false);
				
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_ENRICHMENT'))){ ?>
		master_enrichment_createForm.enrich_savePrint.enable();
		//master_enrichment_createForm.enrich_savePrint2.enable();
		<?php } ?>
	}
 	/* End of Function */
    
	/* setValue to EDIT */
	function master_enrichment_set_form(){
		var hutang_temp=0;
		var subtotal_field=0;
		var denrich_jumlah_field=0;
		var total_field=0;
		var hutang_field=0;
		var diskon_field=0;
		var cashback_field=0;
		var kembalian_temp = 0;
				
		enrichment_idField.setValue(master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_id'));
		enrichment_noField.setValue(master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_no'));
		enrich_karyawanField.setValue(master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('karyawan_nama'));
		enrich_karyawan_idField.setValue(master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('karyawan_id'));
		enrich_nikkaryawanField.setValue(master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('karyawan_no'));
		enrichment_studentField.setValue(master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_student'));
		enrichment_classLPField.setValue(master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('class_name'));
		enrichment_student_idField.setValue(master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_student_id'));
		enrichment_tanggalField.setValue(master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_date'));
		enrichment_caraField.setValue(master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_cara'));
		enrichment_stat_dokField.setValue(master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_stat_dok'));
		enrich_stat_timeField.setValue(master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_stat_time'));
		enrichment_cara2Field.setValue(master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_cara2'));
		enrichment_cara3Field.setValue(master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_cara3'));
		enrich_diskonField.setValue(master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('jproduk_diskon'));
		enrich_cashbackField.setValue(master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_cashback'));
		enrich_ket_diskField.setValue(master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('jproduk_ket_disk'));
		enrich_cashback_cfField.setValue(CurrencyFormatted(master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_cashback')));
		enrichment_bayarField.setValue(master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_total_bayar'));
		enrichment_bayar_cfField.setValue(CurrencyFormatted(master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_total_bayar')));
		enrichment_TotalBayarLabel.setValue(CurrencyFormatted(master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_total_bayar')));
		enrichment_keteranganField.setValue(master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_note'));
		enrichment_kembalianField.setValue(master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_kembalian'));

		
		for(i=0;i<detail_enrichment_DataStore.getCount();i++){
			// subtotal_field+= /*detail_enrichment_DataStore.getAt(i).data.denrich_jumlah * */ detail_enrichment_DataStore.getAt(i).data.denrich_price * ((100 - detail_enrichment_DataStore.getAt(i).data.denrich_disc)/100);   // -detail_enrichment_DataStore.getAt(i).data.denrich_disc;
			subtotal_field+= detail_enrichment_DataStore.getAt(i).data.denrich_subtot;
			denrich_jumlah_field+=detail_enrichment_DataStore.getAt(i).data.denrich_jumlah;
		}
		if(enrich_diskonField.getValue()!==""){
			diskon_field=enrich_diskonField.getValue();
		}
		
		if(enrich_cashbackField.getValue()!==""){
			cashback_field=enrich_cashbackField.getValue();
		}
		total_field=subtotal_field*(100-diskon_field)/100-cashback_field;
		
		enrich_jumlahField.setValue(denrich_jumlah_field);
		enrich_jumlahLabel.setValue(denrich_jumlah_field);
		enrichment_subTotalField.setValue(subtotal_field);
		enrichment_subTotal_cfField.setValue(CurrencyFormatted(subtotal_field));
		enrichment_subTotalLabel.setValue(CurrencyFormatted(subtotal_field));
		
		enrichment_totalField.setValue(total_field);
		enrichment_total_cfField.setValue(CurrencyFormatted(total_field));
		enrichment_TotalLabel.setValue(CurrencyFormatted(total_field));
		
		hutang_temp=total_field-enrichment_bayarField.getValue();
		hutang_temp=(hutang_temp>0?Math.round(hutang_temp):0);
		enrich_hutangField.setValue(hutang_temp);
		enrich_hutang_cfField.setValue(CurrencyFormatted(hutang_temp));
		enrichment_sisabayarLabel.setValue(CurrencyFormatted(hutang_temp));

		kembalian_temp = enrichment_kembalianField.getValue();
		// alert(kembalian_temp);
		enrichment_kembalianLabel.setValue(CurrencyFormatted(kembalian_temp));

		load_membership();
		// load_karyawan();
		update_group_carabayar_enrichment();
		update_group_carabayar2_enrichment();
		update_group_carabayar3_enrichment();
		
		switch(enrichment_caraField.getValue()){
			case 'kwitansi':
				kwitansi_enrichment_DataStore.load({
					params : {
						no_faktur: enrichment_noField.getValue(),
						cara_bayar_ke: 1
					},
					callback: function(opts, success, response)  {
						  if (success) {
							if(kwitansi_enrichment_DataStore.getCount()){
								enrich_kwitansi_record=kwitansi_enrichment_DataStore.getAt(0).data;
								enrich_kwitansi_idField.setValue(enrich_kwitansi_record.kwitansi_id);
								enrichment_kwitansi_noField.setValue(enrich_kwitansi_record.kwitansi_no);
								enrichment_kwitansi_namaField.setValue(enrich_kwitansi_record.cust_nama);
								enrich_kwitansi_sisaField.setValue(enrich_kwitansi_record.kwitansi_sisa);
								enrichment_kwitansi_nilaiField.setValue(enrich_kwitansi_record.jkwitansi_nilai);
								enrich_kwitansi_nilai_cfField.setValue(CurrencyFormatted(enrich_kwitansi_record.jkwitansi_nilai));
								enrich_kwitansi_idField1.setValue(enrich_kwitansi_record.jkwitansi_id);
							}
						  }
					  }
				});
				break;
			case 'card' :
				card_enrichment_DataStore.load({
					params : {
						no_faktur: enrichment_noField.getValue(),
						cara_bayar_ke: 1
					},
					callback: function(opts, success, response)  {
						 if (success) { 
							if(card_enrichment_DataStore.getCount()){
								enrich_card_record=card_enrichment_DataStore.getAt(0).data;
								enrichment_card_namaField.setValue(enrich_card_record.jcard_nama);
								enrichment_card_edcField.setValue(enrich_card_record.jcard_edc);
								enrichment_card_noField.setValue(enrich_card_record.jcard_no);
								enrichment_card_nilaiField.setValue(enrich_card_record.jcard_nilai);
								enrich_card_nilai_cfField.setValue(CurrencyFormatted(enrich_card_record.jcard_nilai));
							}
						 }
					}
				});
				break;
			case 'cek/giro':
				cek_enrichment_DataStore.load({
					params : {
						no_faktur: enrichment_noField.getValue(),
						cara_bayar_ke: 1
					},
					callback: function(opts, success, response)  {
							if (success) {
								if(cek_enrichment_DataStore.getCount()){
									enrich_cek_record=cek_enrichment_DataStore.getAt(0).data;
									enrich_cek_namaField.setValue(enrich_cek_record.jcek_nama);
									enrich_cek_noField.setValue(enrich_cek_record.jcek_no);
									enrich_cek_validField.setValue(enrich_cek_record.jcek_valid);
									enrich_cek_bankField.setValue(enrich_cek_record.jcek_bank);
									enrich_cek_nilaiField.setValue(enrich_cek_record.jcek_nilai);
									enrich_cek_nilai_cfField.setValue(CurrencyFormatted(enrich_cek_record.jcek_nilai));
								}
							}
					 	}
				  });
				break;								
			case 'transfer' :
				transfer_enrichment_DataStore.load({
						params : {
							no_faktur: enrichment_noField.getValue(),
							cara_bayar_ke: 1
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(transfer_enrichment_DataStore.getCount()){
										enrich_transfer_record=transfer_enrichment_DataStore.getAt(0);
										enrichment_transfer_bankField.setValue(enrich_transfer_record.data.jtransfer_bank);
										enrichment_transfer_namaField.setValue(enrich_transfer_record.data.jtransfer_nama);
										enrichment_transfer_nilaiField.setValue(enrich_transfer_record.data.jtransfer_nilai);
										enrich_transfer_nilai_cfField.setValue(CurrencyFormatted(enrich_transfer_record.data.jtransfer_nilai));
									}
							}
					 	}
				  });
				break;
			case 'tunai' :
				tunai_enrichment_DataStore.load({
						params : {
							no_faktur: enrichment_noField.getValue(),
							cara_bayar_ke: 1
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(tunai_enrichment_DataStore.getCount()){
										enrich_tunai_record=tunai_enrichment_DataStore.getAt(0);
										enrichment_tunai_nilaiField.setValue(enrich_tunai_record.data.jtunai_nilai);
										enrichment_tunai_nilai_cfField.setValue(CurrencyFormatted(enrich_tunai_record.data.jtunai_nilai));
									}
							}
					 	}
				  });
				break;
			case 'voucher' :
				voucher_enrichment_DataStore.load({
						params : {
							no_faktur: enrichment_noField.getValue(),
							cara_bayar_ke: 1
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(voucher_enrichment_DataStore.getCount()){
										enrich_voucher_record=voucher_enrichment_DataStore.getAt(0);
										enrich_voucher_noField.setValue(enrich_voucher_record.data.tvoucher_novoucher);
										enrich_voucher_cashbackField.setValue(enrich_voucher_record.data.tvoucher_nilai);
										enrich_voucher_cashback_cfField.setValue(CurrencyFormatted(enrich_voucher_record.data.tvoucher_nilai));
									}
							}
					 	}
				  });
				break;
		}

		switch(enrichment_cara2Field.getValue()){
			case 'kwitansi':
				kwitansi_enrichment_DataStore.load({
					params : {
						no_faktur: enrichment_noField.getValue(),
						cara_bayar_ke: 2
					},
					callback: function(opts, success, response)  {
						  if (success) {
							if(kwitansi_enrichment_DataStore.getCount()){
								enrich_kwitansi_record=kwitansi_enrichment_DataStore.getAt(0).data;
								enrich_kwitansi_id2Field.setValue(enrich_kwitansi_record.kwitansi_id);
								enrichment_kwitansi_no2Field.setValue(enrich_kwitansi_record.kwitansi_no);
								enrichment_kwitansi_nama2Field.setValue(enrich_kwitansi_record.cust_nama);
								enrichment_kwitansi_nilai2Field.setValue(enrich_kwitansi_record.jkwitansi_nilai);
								enrich_kwitansi_nilai2_cfField.setValue(CurrencyFormatted(enrich_kwitansi_record.jkwitansi_nilai));
								enrich_kwitansi_idField2.setValue(enrich_kwitansi_record.jkwitansi_id);
							}
						  }
					  }
				});
				break;
			case 'card' :
				card_enrichment_DataStore.load({
					params : {
						no_faktur: enrichment_noField.getValue(),
						cara_bayar_ke: 2
					},
					callback: function(opts, success, response)  {
						 if (success) { 
							 if(card_enrichment_DataStore.getCount()){
								 enrich_card_record=card_enrichment_DataStore.getAt(0).data;
								 enrichment_card_nama2Field.setValue(enrich_card_record.jcard_nama);
								 enrichment_card_edc2Field.setValue(enrich_card_record.jcard_edc);
								 enrichment_card_no2Field.setValue(enrich_card_record.jcard_no);
								 enrichment_card_nilai2Field.setValue(enrich_card_record.jcard_nilai);
								 enrich_card_nilai2_cfField.setValue(CurrencyFormatted(enrich_card_record.jcard_nilai));
							 }
						 }
					}
				});
				break;
			case 'cek/giro':
				cek_enrichment_DataStore.load({
					params : {
						no_faktur: enrichment_noField.getValue(),
						cara_bayar_ke: 2
					},
					callback: function(opts, success, response)  {
							if (success) {
								if(cek_enrichment_DataStore.getCount()){
									enrich_cek_record=cek_enrichment_DataStore.getAt(0).data;
									enrich_cek_nama2Field.setValue(enrich_cek_record.jcek_nama);
									enrich_cek_no2Field.setValue(enrich_cek_record.jcek_no);
									enrich_cek_valid2Field.setValue(enrich_cek_record.jcek_valid);
									enrich_cek_bank2Field.setValue(enrich_cek_record.jcek_bank);
									enrich_cek_nilai2Field.setValue(enrich_cek_record.jcek_nilai);
									enrich_cek_nilai2_cfField.setValue(CurrencyFormatted(enrich_cek_record.jcek_nilai));
								}
							}
					 	}
				  });
				break;								
			case 'transfer' :
				transfer_enrichment_DataStore.load({
						params : {
							no_faktur: enrichment_noField.getValue(),
							cara_bayar_ke: 2
						},
					  	callback: function(opts, success, response)  {
							if (success) {
								enrich_transfer_record=transfer_enrichment_DataStore.getAt(0);
									if(transfer_enrichment_DataStore.getCount()){
										enrich_transfer_record=transfer_enrichment_DataStore.getAt(0);
										enrichment_transfer_bank2Field.setValue(enrich_transfer_record.data.jtransfer_bank);
										enrichment_transfer_nama2Field.setValue(enrich_transfer_record.data.jtransfer_nama);
										enrichment_transfer_nilai2Field.setValue(enrich_transfer_record.data.jtransfer_nilai);
										enrich_transfer_nilai2_cfField.setValue(CurrencyFormatted(enrich_transfer_record.data.jtransfer_nilai));
									}
							}
					 	}
				  });
				break;
			case 'tunai' :
				tunai_enrichment_DataStore.load({
						params : {
							no_faktur: enrichment_noField.getValue(),
							cara_bayar_ke: 2
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(tunai_enrichment_DataStore.getCount()){
										enrich_tunai_record=tunai_enrichment_DataStore.getAt(0);
										enrichment_tunai_nilai2Field.setValue(enrich_tunai_record.data.jtunai_nilai);
										enrich_tunai_nilai2_cfField.setValue(CurrencyFormatted(enrich_tunai_record.data.jtunai_nilai));
									}
							}
					 	}
				  });
				break;
			case 'voucher' :
				voucher_enrichment_DataStore.load({
						params : {
							no_faktur: enrichment_noField.getValue(),
							cara_bayar_ke: 2
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(voucher_enrichment_DataStore.getCount()){
										enrich_voucher_record=voucher_enrichment_DataStore.getAt(0);
										enrich_voucher_no2Field.setValue(enrich_voucher_record.data.tvoucher_novoucher);
										enrich_voucher_cashback2Field.setValue(enrich_voucher_record.data.tvoucher_nilai);
										enrich_voucher_cashback2_cfField.setValue(CurrencyFormatted(enrich_voucher_record.data.tvoucher_nilai));
									}
							}
					 	}
				  });
				break;
		}

		switch(enrichment_cara3Field.getValue()){
			case 'kwitansi':
				kwitansi_enrichment_DataStore.load({
					params : {
						no_faktur: enrichment_noField.getValue(),
						cara_bayar_ke: 3
					},
					callback: function(opts, success, response)  {
						  if (success) {
							if(kwitansi_enrichment_DataStore.getCount()){
								enrich_kwitansi_record=kwitansi_enrichment_DataStore.getAt(0).data;
								enrich_kwitansi_id3Field.setValue(enrich_kwitansi_record.kwitansi_id);
								enrichment_kwitansi_no3Field.setValue(enrich_kwitansi_record.kwitansi_no);
								enrichment_kwitansi_nama3Field.setValue(enrich_kwitansi_record.cust_nama);
								enrichment_kwitansi_nilai3Field.setValue(enrich_kwitansi_record.jkwitansi_nilai);
								enrich_kwitansi_nilai3_cfField.setValue(CurrencyFormatted(enrich_kwitansi_record.jkwitansi_nilai));
								enrich_kwitansi_idField3.setValue(enrich_kwitansi_record.jkwitansi_id);
							}
						  }
					  }
				});
				break;
			case 'card' :
				card_enrichment_DataStore.load({
					params : {
						no_faktur: enrichment_noField.getValue(),
						cara_bayar_ke: 3
					},
					callback: function(opts, success, response)  {
						 if (success) { 
							 if(card_enrichment_DataStore.getCount()){
								 enrich_card_record=card_enrichment_DataStore.getAt(0).data;
								 enrichment_card_nama3Field.setValue(enrich_card_record.jcard_nama);
								 enrichment_card_edc3Field.setValue(enrich_card_record.jcard_edc);
								 enrichment_card_no3Field.setValue(enrich_card_record.jcard_no);
								 enrichment_card_nilai3Field.setValue(enrich_card_record.jcard_nilai);
								 enrich_card_nilai3_cfField.setValue(CurrencyFormatted(enrich_card_record.jcard_nilai));
							 }
						 }
					}
				});
				break;
			case 'cek/giro':
				cek_enrichment_DataStore.load({
					params : {
						no_faktur: enrichment_noField.getValue(),
						cara_bayar_ke: 3
					},
					callback: function(opts, success, response)  {
							if (success) {
								if(cek_enrichment_DataStore.getCount()){
									enrich_cek_record=cek_enrichment_DataStore.getAt(0).data;
									enrich_cek_nama3Field.setValue(enrich_cek_record.jcek_nama);
									enrich_cek_no3Field.setValue(enrich_cek_record.jcek_no);
									enrich_cek_valid3Field.setValue(enrich_cek_record.jcek_valid);
									enrich_cek_bank3Field.setValue(enrich_cek_record.jcek_bank);
									enrich_cek_nilai3Field.setValue(enrich_cek_record.jcek_nilai);
									enrich_cek_nilai3_cfField.setValue(CurrencyFormatted(enrich_cek_record.jcek_nilai));
								}
							}
					 	}
				  });
				break;								
			case 'transfer' :
				transfer_enrichment_DataStore.load({
						params : {
							no_faktur: enrichment_noField.getValue(),
							cara_bayar_ke: 3
						},
					  	callback: function(opts, success, response)  {
							if (success) {
								enrich_transfer_record=transfer_enrichment_DataStore.getAt(0);
									if(transfer_enrichment_DataStore.getCount()){
										enrich_transfer_record=transfer_enrichment_DataStore.getAt(0);
										enrichment_transfer_bank3Field.setValue(enrich_transfer_record.data.jtransfer_bank);
										enrichment_transfer_nama3Field.setValue(enrich_transfer_record.data.jtransfer_nama);
										enrichment_transfer_nilai3Field.setValue(enrich_transfer_record.data.jtransfer_nilai);
										enrich_transfer_nilai3_cfField.setValue(CurrencyFormatted(enrich_transfer_record.data.jtransfer_nilai));
									}
							}
					 	}
				  });
				break;
			case 'tunai' :
				tunai_enrichment_DataStore.load({
						params : {
							no_faktur: enrichment_noField.getValue(),
							cara_bayar_ke: 3
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(tunai_enrichment_DataStore.getCount()){
										enrich_tunai_record=tunai_enrichment_DataStore.getAt(0);
										enrichment_tunai_nilai3Field.setValue(enrich_tunai_record.data.jtunai_nilai);
										enrich_tunai_nilai3_cfField.setValue(CurrencyFormatted(enrich_tunai_record.data.jtunai_nilai));
									}
							}
					 	}
				  });
				break;
			case 'voucher' :
				voucher_enrichment_DataStore.load({
						params : {
							no_faktur: enrichment_noField.getValue(),
							cara_bayar_ke: 3
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(voucher_enrichment_DataStore.getCount()){
										enrich_voucher_record=voucher_enrichment_DataStore.getAt(0);
										enrich_voucher_no3Field.setValue(enrich_voucher_record.data.tvoucher_novoucher);
										enrich_voucher_cashback3Field.setValue(enrich_voucher_record.data.tvoucher_nilai);
										enrich_voucher_cashback3_cfField.setValue(CurrencyFormatted(enrich_voucher_record.data.tvoucher_nilai));
									}
							}
					 	}
				  });
				break;
		}
        
        //Jika enrichment_post2db='UPDATE' dan enrich_stat_dok='Tertutup' ==> detail_enrichmentListEditorGrid.denrich_add di-disable
        if(master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_stat_dok')=='Tertutup'){
            <?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_ENRICHMENT'))){ ?>
			detail_enrichmentListEditorGrid.denrich_add.disable();
            detail_enrichmentListEditorGrid.denrich_delete.disable();
			<?php } ?>
        }else if(master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_stat_dok')=='Terbuka'){
            <?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_ENRICHMENT'))){ ?>
			detail_enrichmentListEditorGrid.denrich_add.enable();
            detail_enrichmentListEditorGrid.denrich_delete.enable();
			<?php } ?>
        }
		
		enrichment_stat_dokField.on("select",function(){
		var status_awal = master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_stat_dok');
		if(status_awal =='Terbuka' && enrichment_stat_dokField.getValue()=='Tertutup')
		{
		Ext.MessageBox.show({
			msg: 'Dokumen tidak bisa ditutup. Gunakan Save & Print untuk menutup dokumen',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		enrichment_stat_dokField.setValue('Terbuka');
		}
		
		else if(status_awal =='Tertutup' && enrichment_stat_dokField.getValue()=='Terbuka')
		{
		Ext.MessageBox.show({
			msg: 'Status yang sudah Tertutup tidak dapat diganti Terbuka',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		enrichment_stat_dokField.setValue('Tertutup');
		}
		
		else if(status_awal =='Batal' && enrichment_stat_dokField.getValue()=='Terbuka')
		{
		Ext.MessageBox.show({
			msg: 'Status yang sudah Tertutup tidak dapat diganti Terbuka',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		enrichment_stat_dokField.setValue('Tertutup');
		}
		
		else if(enrichment_stat_dokField.getValue()=='Batal')
		{
		Ext.MessageBox.confirm('Confirmation','Anda yakin untuk membatalkan dokumen ini? Pembatalan dokumen tidak bisa dikembalikan lagi', enrichment_status_batal);
		}
        
        else if(status_awal =='Tertutup' && enrichment_stat_dokField.getValue()=='Tertutup'){
            <?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_ENRICHMENT'))){ ?>
			master_enrichment_createForm.enrich_savePrint.enable();
			//master_enrichment_createForm.enrich_savePrint2.enable();
			<?php } ?>
        }
		});		
	}
	/* End setValue to EDIT*/
	
	function enrichment_status_batal(btn){
	if(btn=='yes')
	{
		enrichment_stat_dokField.setValue('Batal');
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_ENRICHMENT'))){ ?>
        master_enrichment_createForm.enrich_savePrint.disable();
		//master_enrichment_createForm.enrich_savePrint2.disable();
		<?php } ?>
	}  
	else
		enrichment_stat_dokField.setValue(master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_stat_dok'));
	}

	function master_enrichment_set_updating(){
		if(enrichment_post2db=="UPDATE" && master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_stat_dok')=="Terbuka"){
			enrichment_studentField.setDisabled(true);
			enrichment_tanggalField.setDisabled(true);
			enrichment_keteranganField.setDisabled(false);
			enrich_karyawanField.setDisabled(true);
			enrich_nikkaryawanField.setDisabled(false);
			enrichment_caraField.setDisabled(false);
			master_enrichment_tunaiGroup.setDisabled(false);
			master_enrichment_cardGroup.setDisabled(false);
			master_enrichment_cekGroup.setDisabled(false);
			master_enrichment_kwitansiGroup.setDisabled(false);
			master_enrichment_transferGroup.setDisabled(false);
			master_enrichment_voucherGroup.setDisabled(false);
			
			enrichment_cara2Field.setDisabled(false);
			master_enrichment_tunai2Group.setDisabled(false);
			master_enrichment_card2Group.setDisabled(false);
			master_enrichment_cek2Group.setDisabled(false);
			master_enrichment_kwitansi2Group.setDisabled(false);
			master_enrichment_transfer2Group.setDisabled(false);
			master_enrichment_voucher2Group.setDisabled(false);
			
			enrichment_cara3Field.setDisabled(false);
			master_enrichment_tunai3Group.setDisabled(false);
			master_enrichment_card3Group.setDisabled(false);
			master_enrichment_cek3Group.setDisabled(false);
			master_enrichment_kwitansi3Group.setDisabled(false);
			master_enrichment_transfer3Group.setDisabled(false);
			master_enrichment_voucher3Group.setDisabled(false);
			
			master_enrichment_createForm.enrich_savePrint.enable();
			//master_enrichment_createForm.enrich_savePrint2.enable();
			
			combo_jual_enrichment.setDisabled(false);
			combo_satuan_enrichment.setDisabled(false);
			djumlah_beli_enrichmentField.setDisabled(false);
			denrich_sub_totalField.setDisabled(false);
			denrich_jenis_diskonField.setDisabled(false);
			denrich_subtotal_netField.setDisabled(true);
			combo_enrich_supplier.setDisabled(false);
			denrich_harga_defaultField.setDisabled(false);
            enrich_diskonField.setDisabled(false);
            enrich_cashback_cfField.setDisabled(false);
			enrich_ket_diskField.setDisabled(false);
            enrichment_stat_dokField.setDisabled(false);
			enrich_stat_timeField.setDisabled(false);
			enrichment_tunai_nilai_cfField.setDisabled(false);
			
			denrich_jumlah_diskonField.setDisabled(false);
			dharga_enrichment_konversiField.setDisabled(true);
			// denrich_sub_totalField.setDisabled(true);
		}
		if(enrichment_post2db=="UPDATE" && master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_stat_dok')=="Tertutup"){
			enrichment_studentField.setDisabled(true);
			enrichment_tanggalField.setDisabled(true);
			enrichment_keteranganField.setDisabled(true);
			enrich_karyawanField.setDisabled(true);
			enrich_nikkaryawanField.setDisabled(true);
			enrichment_caraField.setDisabled(true);
			master_enrichment_tunaiGroup.setDisabled(true);
			master_enrichment_cardGroup.setDisabled(true);
			master_enrichment_cekGroup.setDisabled(true);
			master_enrichment_kwitansiGroup.setDisabled(true);
			master_enrichment_transferGroup.setDisabled(true);
			master_enrichment_voucherGroup.setDisabled(true);
			
			enrichment_cara2Field.setDisabled(true);
			master_enrichment_tunai2Group.setDisabled(true);
			master_enrichment_card2Group.setDisabled(true);
			master_enrichment_cek2Group.setDisabled(true);
			master_enrichment_kwitansi2Group.setDisabled(true);
			master_enrichment_transfer2Group.setDisabled(true);
			master_enrichment_voucher2Group.setDisabled(true);
			
			enrichment_cara3Field.setDisabled(true);
			master_enrichment_tunai3Group.setDisabled(true);
			master_enrichment_card3Group.setDisabled(true);
			master_enrichment_cek3Group.setDisabled(true);
			master_enrichment_kwitansi3Group.setDisabled(true);
			master_enrichment_transfer3Group.setDisabled(true);
			master_enrichment_voucher3Group.setDisabled(true);
			
			master_enrichment_createForm.enrich_savePrint.disable();
			//master_enrichment_createForm.enrich_savePrint2.disable();
			
			combo_jual_enrichment.setDisabled(true);
			combo_satuan_enrichment.setDisabled(true);
			djumlah_beli_enrichmentField.setDisabled(true);
			dharga_enrichment_konversiField.setDisabled(true);
			denrich_sub_totalField.setDisabled(true);
			denrich_jenis_diskonField.setDisabled(true);
			denrich_jumlah_diskonField.setDisabled(true);
			denrich_subtotal_netField.setDisabled(true);
			combo_enrich_supplier.setDisabled(true);
			denrich_harga_defaultField.setDisabled(true);
			enrich_diskonField.setDisabled(true);
			enrich_cashback_cfField.setDisabled(true);
			enrich_ket_diskField.setDisabled(true);
			enrichment_stat_dokField.setDisabled(false);
			enrich_stat_timeField.setDisabled(true);
			enrichment_tunai_nilai_cfField.setDisabled(true);
		}
		if(enrichment_post2db=="UPDATE" && master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_stat_dok')=="Batal"){
			enrichment_studentField.setDisabled(true);
			enrichment_tanggalField.setDisabled(true);
			enrichment_keteranganField.setDisabled(true);
			enrichment_stat_dokField.setDisabled(true);
			enrich_stat_timeField.setDisabled(true);
			enrichment_tunai_nilai_cfField.setDisabled(true);
			enrichment_caraField.setDisabled(true);
			enrich_karyawanField.setDisabled(true);
			enrich_nikkaryawanField.setDisabled(true);
			master_enrichment_tunaiGroup.setDisabled(true);
			master_enrichment_cardGroup.setDisabled(true);
			master_enrichment_cekGroup.setDisabled(true);
			master_enrichment_kwitansiGroup.setDisabled(true);
			master_enrichment_transferGroup.setDisabled(true);
			master_enrichment_voucherGroup.setDisabled(true);
			
			enrichment_cara2Field.setDisabled(true);
			master_enrichment_tunai2Group.setDisabled(true);
			master_enrichment_card2Group.setDisabled(true);
			master_enrichment_cek2Group.setDisabled(true);
			master_enrichment_kwitansi2Group.setDisabled(true);
			master_enrichment_transfer2Group.setDisabled(true);
			master_enrichment_voucher2Group.setDisabled(true);
			
			enrichment_cara3Field.setDisabled(true);
			master_enrichment_tunai3Group.setDisabled(true);
			master_enrichment_card3Group.setDisabled(true);
			master_enrichment_cek3Group.setDisabled(true);
			master_enrichment_kwitansi3Group.setDisabled(true);
			master_enrichment_transfer3Group.setDisabled(true);
			master_enrichment_voucher3Group.setDisabled(true);
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_ENRICHMENT'))){ ?>
			detail_enrichmentListEditorGrid.denrich_add.disable();
			detail_enrichmentListEditorGrid.denrich_delete.disable();
			<?php } ?>
			combo_jual_enrichment.setDisabled(true);
			combo_satuan_enrichment.setDisabled(true);
			djumlah_beli_enrichmentField.setDisabled(true);
			dharga_enrichment_konversiField.setDisabled(true);
			denrich_sub_totalField.setDisabled(true);
			denrich_jenis_diskonField.setDisabled(true);
			denrich_jumlah_diskonField.setDisabled(true);
			denrich_subtotal_netField.setDisabled(true);
			combo_enrich_supplier.setDisabled(true);
			denrich_harga_defaultField.setDisabled(true);
			enrich_diskonField.setDisabled(true);
			enrich_cashback_cfField.setDisabled(true);
			enrich_ket_diskField.setDisabled(true);

			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_ENRICHMENT'))){ ?>
			master_enrichment_createForm.enrich_savePrint.disable();
			//master_enrichment_createForm.enrich_savePrint2.disable();
			<?php } ?>
		}
	}
  
    function load_membership(){
		var cust_id=0;
		if(enrichment_post2db=="CREATE"){
			cust_id=enrichment_studentField.getValue();
		}else if(enrichment_post2db=="UPDATE"){
			cust_id=enrichment_student_idField.getValue();
		}
		
		if(enrichment_studentField.getValue()!=''){
			enrich_memberDataStore.load({
					params : { member_cust: cust_id},
					callback: function(opts, success, response)  {
						 if (success) {
							if(enrich_memberDataStore.getCount()){
								enrich_member_record=enrich_memberDataStore.getAt(0).data;
								enrich_cust_nomemberField.setValue(enrich_member_record.member_no);
								enrich_valid_memberField.setValue(enrich_member_record.member_valid);
								enrich_cust_ultahField.setValue(enrich_member_record.cust_tgllahir);
								enrich_cust_priorityField.setValue(enrich_member_record.cust_priority_star);
									if (enrich_cust_priorityField.getValue()=='*') {
										enrich_cust_priorityLabel.setText("*");
									}
									else {
										enrich_cust_priorityLabel.setText("");
									}	
								
							}
						}
					}
			}); 
		}
	}
	
	function load_karyawan(){
		var karyawan_id=0;
		if(enrichment_post2db=="CREATE"){
			karyawan_id=enrich_karyawanField.getValue();
		}else if(enrichment_post2db=="UPDATE"){
			karyawan_id=enrich_karyawan_idField.getValue();
		}
		
		if(enrich_karyawanField.getValue()!=''){
			enrich_karyawanDataStore.load({
					params : { karyawan_id: karyawan_id},
					callback: function(opts, success, response)  {
						 if (success) {
							if(enrich_karyawanDataStore.getCount()){
								enrich_karyawan_record=enrich_karyawanDataStore.getAt(0).data;
								enrich_nikkaryawanField.setValue(enrich_karyawan_record.karyawan_no);
							}
						}
					}
			}); 
		}
	}
	/* Function for Check if the form is valid */
	function is_master_enrichment_form_valid(){
		return (enrich_diskonField.isValid() && enrich_karyawanField.isValid() );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){	
		master_enrichment_reset_form();
		detail_enrichment_DataStore.load({params: {master_id:-1}});
		master_enrichment_createForm.render();
		enrichment_caraField.setValue('tunai');
		enrichment_stat_dokField.setValue('Terbuka');
		enrich_stat_timeField.setValue('Pagi');
		enrichment_tanggalField.setValue(dt.format('Y-m-d'));
		master_enrichment_tunaiGroup.setVisible(true);
		enrichment_master_cara_bayarTabPanel.setActiveTab(0);
		enrichment_post2db="CREATE";
		enrich_diskonField.setValue(0);
		enrich_cashbackField.setValue(0);
		enrich_diskonField.allowBlank=true;
		enrichment_pesanLabel.setText('');
		enrich_lunasLabel.setText('');
		enrich_cust_priorityLabel.setText('');
		master_enrichment_createWindow.hide();
	
		
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function master_enrichment_confirm_delete(){
		// only one master_jual_produk is selected here
		if(master_enrichmentListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', master_enrichment_delete);
		} else if(master_enrichmentListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', master_enrichment_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Anda belum memilih data yang akan dihapus',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
	/* Function for Update Confirm */
	function master_enrichment_confirm_update(){
		master_enrichment_reset_form();
		/* only one record is selected here */
		if(master_enrichmentListEditorGrid.selModel.getCount() == 1) {
			cbo_denrichment_DataStore.load({
				params: {
					query: master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_id'),
					aktif: 'yesno'
				},
				callback: function(opts, success, response){
					cbo_denrich_satuanDataStore.setBaseParam('produk_id', 0);
					cbo_denrich_satuanDataStore.setBaseParam('query', master_enrichmentListEditorGrid.getSelectionModel().getSelected().get('enrich_id'));
					cbo_denrich_satuanDataStore.load({
						callback: function(opts, success, response){
							// cbo_denrichment_supplierDataStore.load({
								// callback: function(opts, success, response){
									detail_enrichment_DataStore.load({
										params : {master_id : eval(get_enrichment_pk()), start:0, limit:750},
										callback: function(opts, success, response){
											if(success){
												master_enrichment_set_form();
												master_enrichment_set_updating();
											}
										}
									});
								// }
							// });
						}
					});
				}
			});
			enrichment_post2db='UPDATE';
			enrichment_master_cara_bayarTabPanel.setActiveTab(2);
			enrichment_master_cara_bayarTabPanel.setActiveTab(1);
			enrichment_master_cara_bayarTabPanel.setActiveTab(0);
			msg='updated';
			master_enrichment_createWindow.hide();
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Anda belum memilih data yang akan diedit',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
  	/* Function for Delete Record */
	function master_enrichment_delete(btn){
		if(btn=='yes'){
			var selections = master_enrichmentListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< master_enrichmentListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.enrich_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_master_enrichment&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							master_enrichment_DataStore.reload();
							break;
						default:
							Ext.MessageBox.show({
								title: 'Warning',
								msg: 'Could not delete the entire selection',
								buttons: Ext.MessageBox.OK,
								animEl: 'save',
								icon: Ext.MessageBox.WARNING
							});
							break;
					}
				},
				failure: function(response){
					var result=response.responseText;
					Ext.MessageBox.show({
					   title: 'Error',
					   msg: 'Could not connect to the database. retry later.',
					   buttons: Ext.MessageBox.OK,
					   animEl: 'database',
					   icon: Ext.MessageBox.ERROR
					});	
				}
			});
		}  
	}
  	/* End of Function */
  
	/* Function for Retrieve DataStore */
	master_enrichment_DataStore = new Ext.data.Store({
		id: 'master_enrichment_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_enrichment&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'enrich_id'
		},[
		/* dataIndex => insert intomaster_enrichment_ColumnModel, Mapping => for initiate table column */ 
			{name: 'enrich_id', type: 'int', mapping: 'enrich_id'}, 
			{name: 'enrich_no', type: 'string', mapping: 'enrich_no'}, 
			{name: 'class_name', type: 'string', mapping: 'class_name'}, 
			{name: 'enrich_student', type: 'string', mapping: 'cust_nama'}, 
			{name: 'jproduk_cust_edit', type: 'string', mapping: 'cust_nama_edit'}, 
			{name: 'jproduk_cust_no', type: 'string', mapping: 'cust_no'}, 
			{name: 'jproduk_cust_member', type: 'string', mapping: 'cust_member'}, 
			{name: 'jproduk_cust_member_no', type: 'string', mapping: 'member_no'}, 
			{name: 'enrich_student_id', type: 'int', mapping: 'enrich_student'}, 
			{name: 'enrich_date', type: 'date', dateFormat: 'Y-m-d', mapping: 'enrich_date'}, 
			{name: 'jproduk_diskon', type: 'int', mapping: 'jproduk_diskon'}, 
			{name: 'enrich_cashback', type: 'float', mapping: 'enrich_cashback'},
			{name: 'enrich_cara', type: 'string', mapping: 'enrich_cara'}, 
			{name: 'enrich_cara2', type: 'string', mapping: 'enrich_cara2'}, 
			{name: 'enrich_cara3', type: 'string', mapping: 'enrich_cara3'}, 
			{name: 'enrich_total_bayar', type: 'float', mapping: 'enrich_total_bayar'}, 
			{name: 'enrich_kembalian', type: 'float', mapping: 'enrich_kembalian'}, 
			{name: 'enrich_total_biaya', type: 'float', mapping: 'enrich_total_biaya'}, 
			{name: 'enrich_note', type: 'string', mapping: 'enrich_note'},
			{name: 'jproduk_ket_disk', type: 'string', mapping: 'jproduk_ket_disk'},
			{name: 'enrich_stat_dok', type: 'string', mapping: 'enrich_stat_dok'}, 	
			{name: 'enrich_stat_time', type: 'string', mapping: 'enrich_stat_time'}, 			
			{name: 'enrich_creator', type: 'string', mapping: 'enrich_creator'}, 
			{name: 'enrich_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'enrich_date_create'}, 
			{name: 'enrich_updater', type: 'string', mapping: 'enrich_updater'}, 
			{name: 'enrich_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'enrich_date_update'}, 
			{name: 'jproduk_revised', type: 'int', mapping: 'jproduk_revised'} 
		]),
		sortInfo:{field: 'enrich_id', direction: "DESC"}
	});
	/* End of Function */
		
	/* Function for Retrieve DataStore */
	cbo_student_enrichment_DataStore = new Ext.data.Store({
		id: 'cbo_student_enrichment_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_enrichment&m=get_customer_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit: 10 }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cust_id'
		},[
		/* dataIndex => insert intocustomer_note_ColumnModel, Mapping => for initiate table column */ 
			{name: 'cust_id', type: 'int', mapping: 'cust_id'},
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'cust_tgllahir', type: 'date', dateFormat: 'Y-m-d', mapping: 'cust_tgllahir'},
			{name: 'cust_alamat', type: 'string', mapping: 'cust_alamat'},
			{name: 'cust_telprumah', type: 'string', mapping: 'cust_telprumah'}
		]),
		sortInfo:{field: 'cust_no', direction: "ASC"}
	});

	/* Function for Retrieve DataStore Class Lesson Plan*/
	cbo_class_lessonplan_DataStore = new Ext.data.Store({
		id: 'cbo_class_lessonplan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_enrichment&m=get_class_lp_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit: 10 }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'class_id'
		},[
		/* dataIndex => insert intocustomer_note_ColumnModel, Mapping => for initiate table column */ 
			{name: 'class_id', type: 'int', mapping: 'class_id'},
			{name: 'class_location', type: 'string', mapping: 'class_location'},
			{name: 'class_name', type: 'string', mapping: 'class_name'},
			{name: 'class_teacher1', type: 'string', mapping: 'class_teacher1'},
			{name: 'class_teacher2', type: 'string', mapping: 'class_teacher2'},
			{name: 'class_time_start', type: 'time', mapping: 'class_time_start'},
			{name: 'class_time_end', type: 'time', mapping: 'class_time_end'},
			{name: 'class_capacity', type: 'int', mapping: 'class_capacity'},
			{name: 'class_usage', type: 'int', mapping: 'class_usage'},
			{name: 'class_notes', type: 'string', mapping: 'class_notes'}
		]),
		sortInfo:{field: 'class_id', direction: "ASC"}
	});

	cbo_transaction_setting_DataStore = new Ext.data.Store({
		id: 'cbo_transaction_setting_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_enrichment&m=get_transaction_setting', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'trans_author'
		},[
			{name: 'trans_author', type: 'varchar', mapping: 'trans_author'},
			{name: 'uang_pangkal_enrichment', type: 'float', mapping: 'uang_pangkal_enrichment'}
		]),
		sortInfo:{field: 'trans_author', direction: "ASC"}
	});

	enrich_enrich_karyawanDataStore = new Ext.data.Store({
		id: 'enrich_enrich_karyawanDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_enrichment&m=get_allkaryawan_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
		},[
		/* dataIndex => insert intotbl_usersColumnModel, Mapping => for initiate table column */ 
			{name: 'supplier_display', type: 'string', mapping: 'karyawan_nama'},
			{name: 'karyawan_id', type: 'int', mapping: 'karyawan_id'},
			{name: 'karyawan_no', type: 'string', mapping: 'karyawan_no'},
			{name: 'karyawan_username', type: 'string', mapping: 'karyawan_username'},
			{name: 'karyawan_value', type: 'int', mapping: 'karyawan_id'}
			//{name: 'karyawan_jmltindakan', type: 'int', mapping: 'reportt_jmltindakan'},
		]),
		sortInfo:{field: 'karyawan_no', direction: "ASC"}
	});
	
	var enrich_karyawan_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{supplier_display}</b> | {karyawan_no}</span>',
        '</div></tpl>'
    );
	
	/* Function for Retrieve Combo Kwitansi DataStore */
	cbo_kwitansi_enrichment_DataStore = new Ext.data.Store({
		id: 'cbo_kwitansi_enrichment_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_enrichment&m=get_kwitansi_list', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'kwitansi_id'
		},[
		/* dataIndex => insert intomaster_enrichment_ColumnModel, Mapping => for initiate table column */ 
			{name: 'ckwitansi_id', type: 'int', mapping: 'kwitansi_id'},
			{name: 'ckwitansi_no', type: 'string', mapping: 'kwitansi_no'},
			{name: 'ckwitansi_cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'ckwitansi_cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'ckwitansi_cust_alamat', type: 'string', mapping: 'cust_alamat'},
			{name: 'kwitansi_keterangan', type: 'string', mapping: 'kwitansi_keterangan'},
			{name: 'total_sisa', type: 'int', mapping: 'total_sisa'}
		]),
		sortInfo:{field: 'ckwitansi_no', direction: "ASC"}
	});
	/* End of Function */
	
	/* Function for Retrieve Kwitansi DataStore */
	kwitansi_enrichment_DataStore = new Ext.data.Store({
		id: 'kwitansi_enrichment_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_enrichment&m=get_kwitansi_by_ref', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jkwitansi_id'
		},[
		/* dataIndex => insert intomaster_enrichment_ColumnModel, Mapping => for initiate table column */ 
			{name: 'jkwitansi_id', type: 'int', mapping: 'jkwitansi_id'},
			{name: 'kwitansi_no', type: 'string', mapping: 'kwitansi_no'},
			{name: 'jkwitansi_nilai', type: 'float', mapping: 'jkwitansi_nilai'},
			{name: 'kwitansi_sisa', type: 'float', mapping: 'kwitansi_sisa'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'kwitansi_id', type: 'int', mapping: 'kwitansi_id'}
		]),
		sortInfo:{field: 'jkwitansi_id', direction: "DESC"}
	});
	/* End of Function */
	
	/* Function for Retrieve Kwitansi DataStore */
	card_enrichment_DataStore = new Ext.data.Store({
		id: 'card_enrichment_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_enrichment&m=get_card_by_ref', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jcard_id'
		},[
		/* dataIndex => insert intomaster_enrichment_ColumnModel, Mapping => for initiate table column */ 
			{name: 'jcard_id', type: 'int', mapping: 'jcard_id'}, 
			{name: 'jcard_no', type: 'string', mapping: 'jcard_no'},
			{name: 'jcard_nama', type: 'string', mapping: 'jcard_nama'},
			{name: 'jcard_edc', type: 'string', mapping: 'jcard_edc'},
			{name: 'jcard_nilai', type: 'float', mapping: 'jcard_nilai'}
		]),
		sortInfo:{field: 'jcard_id', direction: "DESC"}
	});
	/* End of Function */
	
	/* Function for Retrieve Kwitansi DataStore */
	cek_enrichment_DataStore = new Ext.data.Store({
		id: 'cek_enrichment_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_enrichment&m=get_cek_by_ref', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jcek_id'
		},[
		/* dataIndex => insert intomaster_enrichment_ColumnModel, Mapping => for initiate table column */ 
			{name: 'jcek_id', type: 'int', mapping: 'jcek_id'}, 
			{name: 'jcek_nama', type: 'string', mapping: 'jcek_nama'},
			{name: 'jcek_no', type: 'string', mapping: 'jcek_no'},
			{name: 'jcek_valid', type: 'string', mapping: 'jcek_valid'}, 
			{name: 'jcek_bank', type: 'string', mapping: 'jcek_bank'},
			{name: 'jcek_nilai', type: 'double', mapping: 'jcek_nilai'}
		]),
		sortInfo:{field: 'jcek_id', direction: "DESC"}
	});
	/* End of Function */
	
	/* Function for Retrieve Transfer DataStore */
	transfer_enrichment_DataStore = new Ext.data.Store({
		id: 'transfer_enrichment_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_enrichment&m=get_transfer_by_ref', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jtransfer_id'
		},[
		/* dataIndex => insert intomaster_enrichment_ColumnModel, Mapping => for initiate table column */ 
			{name: 'jtransfer_id', type: 'int', mapping: 'jtransfer_id'}, 
			{name: 'jtransfer_bank', type: 'int', mapping: 'jtransfer_bank'},
			{name: 'jtransfer_nama', type: 'string', mapping: 'jtransfer_nama'},
			{name: 'jtransfer_nilai', type: 'float', mapping: 'jtransfer_nilai'}
		]),
		sortInfo:{field: 'jtransfer_id', direction: "DESC"}
	});
	/* End of Function */
	
	/* Function for Retrieve Cash DataStore */
	tunai_enrichment_DataStore = new Ext.data.Store({
		id: 'tunai_enrichment_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_enrichment&m=get_tunai_by_ref', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jtunai_id'
		},[
		/* dataIndex => insert intomaster_enrichment_ColumnModel, Mapping => for initiate table column */ 
			{name: 'jtunai_id', type: 'int', mapping: 'jtunai_id'}, 
			{name: 'jtunai_nilai', type: 'float', mapping: 'jtunai_nilai'}
		]),
		sortInfo:{field: 'jtunai_id', direction: "DESC"}
	});
	/* End of Function */
	
	/* GET Bank-List.Store */
	enrichment_bankDataStore = new Ext.data.Store({
		id:'enrichment_bankDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_enrichment&m=get_bank_list', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'mbank_id'
		},[
		/* dataIndex => insert intomaster_enrichment_ColumnModel, Mapping => for initiate table column */ 
			{name: 'jproduk_bank_value', type: 'int', mapping: 'mbank_id'}, 
			{name: 'jproduk_bank_display', type: 'string', mapping: 'mbank_nama'}
		]),
		sortInfo:{field: 'jproduk_bank_display', direction: "DESC"}
		});
	/* END GET Bank-List.Store */
	
	/* GET Voucher-Terima-List.Store */
	voucher_enrichment_DataStore = new Ext.data.Store({
		id: 'voucher_enrichment_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_enrichment&m=get_voucher_by_ref', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'tvoucher_id'
		},[
		/* dataIndex => insert intomaster_enrichment_ColumnModel, Mapping => for initiate table column */ 
			{name: 'tvoucher_id', type: 'int', mapping: 'tvoucher_id'}, 
			{name: 'tvoucher_novoucher', type: 'string', mapping: 'tvoucher_novoucher'}, 
			{name: 'tvoucher_nilai', type: 'float', mapping: 'tvoucher_nilai'}
		]),
		sortInfo:{field: 'tvoucher_id', direction: "DESC"}
	});
	/* End of GET Voucher-Terima-List.Store */
	
	/* GET Voucher-Terima-List.Store */
	enrichment_diskon_promoDataStore = new Ext.data.Store({
		id: 'enrichment_diskon_promoDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_enrichment&m=get_promo_onerow',
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'tvoucher_id'
		},[
		/* dataIndex => insert intomaster_enrichment_ColumnModel, Mapping => for initiate table column */ 
			{name: 'tvoucher_id', type: 'int', mapping: 'tvoucher_id'}, 
			{name: 'tvoucher_novoucher', type: 'string', mapping: 'tvoucher_novoucher'}, 
			{name: 'tvoucher_nilai', type: 'float', mapping: 'tvoucher_nilai'}
		]),
		sortInfo:{field: 'tvoucher_id', direction: "DESC"}
	});
	/* End of GET Voucher-Terima-List.Store */
	
  	/* Function for Identify of Window Column Model */
	master_enrichment_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'enrich_id',
			width: 5,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: '<div align="center">' + 'Date' + '</div>',
			dataIndex: 'enrich_date',
			width: 70,	//150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			editor: new Ext.form.DateField({
				format: 'd-m-Y'
			})
		}, 
		{
			header: '<div align="center">' + 'No. Code' + '</div>',
			dataIndex: 'enrich_no',
			width: 80,	//150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 30
          	})
		}, 

		{
			header: '<div align="center">' + 'Student' + '</div>',
			dataIndex: 'enrich_student',
			width: 200,	//185,
			sortable: true,
			readOnly: true
		}, 

		{
			header: '<div align="center">' + 'Class' + '</div>',
			dataIndex: 'class_name',
			width: 80,	//185,
			sortable: true,
			readOnly: true
		}, 

		{
			header: '<div align="center">' + 'Total (Rp)' + '</div>',
			align: 'right',
			dataIndex: 'enrich_total_biaya',
			width: 80,	//150,
			sortable: true,
			readOnly: true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{
			header: '<div align="center">' + 'Tot Pay (Rp)' + '</div>',
			align: 'right',
			dataIndex: 'enrich_total_bayar',
			width: 80,	//150,
			sortable: true,
			readOnly: true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{
			header: '<div align="center">' + 'Notes' + '</div>',
			dataIndex: 'enrich_note',
			width: 150,	//150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
		}, 
		{
			header: '<div align="center">' + 'Status' + '</div>',
			dataIndex: 'enrich_stat_dok',
			width: 60,	//150,
			sortable: true
		}, 
		/*
		{
			header: '<div align="center">' + 'Shift' + '</div>',
			dataIndex: 'enrich_stat_time',
			width: 60,	//150,
			sortable: true
		}, 	
		*/
		{
			header: 'Creator',
			dataIndex: 'enrich_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Date Create',
			dataIndex: 'enrich_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Update',
			dataIndex: 'enrich_updater',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Date Update',
			dataIndex: 'enrich_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}	
		]);
	
	master_enrichment_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	master_enrichmentListEditorGrid =  new Ext.grid.GridPanel({
		id: 'master_enrichmentListEditorGrid',
		el: 'fp_master_enrichment',
		//title: 'Daftar Enrichment',
		//autoHeight: true,
		height : 550,
		store: master_enrichment_DataStore, // DataStore
		cm: master_enrichment_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		trackMouseOver: false,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1220,	//800,
		bbar: new Ext.PagingToolbar({
			pageSize: enrich_pageS,
			store: master_enrichment_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new record',
			id : 'Add_detail',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: master_enrichment_confirm_update   // Confirm before updating
		}, '-',/*{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			disabled: true,
			handler: master_enrichment_confirm_delete   // Confirm before deleting
		}, '-', */{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: master_enrichment_DataStore,
			params: {task: 'LIST',start: 0, limit: enrich_pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						master_enrichment_DataStore.baseParams={task:'LIST',start: 0, limit: enrich_pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- No Cust<br>- Nama Cust<br>- No Code'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: master_enrichment_reset_search,
			iconCls:'icon-refresh'
		}
		/*
		'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: master_enrichment_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: master_enrichment_print  
		}
		*/
		]
	});
	/* End of DataStore */
	 
	/* Create Context Menu */
	master_enrichment_ContextMenu = new Ext.menu.Menu({
		id: 'master_jual_produk_ListEditorGridContextMenu',
		items: [
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: master_enrichment_editContextMenu 
		}
		/*
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: master_enrichment_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: master_enrichment_export_excel 
		}
		*/
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onmaster_enrichment_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		master_enrichment_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		master_enrichment_SelectedRow=rowIndex;
		master_enrichment_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function master_enrichment_editContextMenu(){
		//master_enrichmentListEditorGrid.startEditing(master_enrichment_SelectedRow,1);
		master_enrichment_confirm_update();
  	}
	/* End of Function */
  	
	master_enrichmentListEditorGrid.addListener('rowcontextmenu', onmaster_enrichment_ListEditGridContextMenu);
	
	// Custom rendering Template
    var student_enrichment_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{cust_no} : {cust_nama}</b><br /></span>',
            '{cust_alamat} | {cust_telprumah}<br>',
			'Tgl-Lahir:{cust_tgllahir:date("j M Y")}',
        '</div></tpl>'
    );
    var class_lesson_plan_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{class_name} : {class_notes}</b><br /></span>',
            '{class_time_start} - {class_time_end}<br>',
			'Capacity:{}<br>',
			'Usage:{}',
        '</div></tpl>'
    );
	var voucher_enrichment_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{voucher_nomor}</b>| {voucher_nama}<br/></span>',
			'Jenis: {voucher_jenis}&nbsp;&nbsp;&nbsp;[Nilai: {voucher_cashback}]',
		'</div></tpl>'
    );
	var kwitansi_enrichment_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{ckwitansi_no}</b> <br/>',
			'a/n {ckwitansi_cust_nama} [ {ckwitansi_cust_no} ]<br/>',
			'{ckwitansi_cust_alamat}, <br>Sisa: <b>Rp. {total_sisa}</b>, <br>Ket : {kwitansi_keterangan} </span>',
		'</div></tpl>'
    );
	var enrich_jual_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{dproduk_produk_kode}| <b>{dproduk_produk_display} </b>| Rp. {dproduk_produk_harga}</b>',
		'</div></tpl>'
    );
		
	/* Identify  enrich_id Field */
	enrichment_idField= new Ext.form.NumberField({
		id: 'enrichment_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  enrich_no Field */
	enrichment_noField= new Ext.form.TextField({
		id: 'enrichment_noField',
		fieldLabel: 'No. Code',
		width: 100,
		emptyText : '(Auto)',
		readOnly:true,
		disabled : true,
		maxLength: 30
	});
	/* Identify  enrichment_student Field */
	enrichment_studentField= new Ext.form.ComboBox({
		id: 'enrichment_studentField',
		fieldLabel: 'Student/Baby',
		store: cbo_student_enrichment_DataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
		forceSelection: true,
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: student_enrichment_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '75%'
		//hidden: true
	});

	/* Identify  enrichment_classLP Field */
	enrichment_classLPField= new Ext.form.ComboBox({
		id: 'enrichment_classLPField',
		fieldLabel: 'Class (Lesson Plan)',
		store: cbo_class_lessonplan_DataStore,
		mode: 'remote',
		displayField:'class_name',
		valueField: 'class_id',
		forceSelection: true,
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: class_lesson_plan_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '75%'
		//hidden: true
	});
	
	enrichment_student_idField= new Ext.form.NumberField();
	enrich_karyawan_idField = new Ext.form.NumberField();

	/* Identify Cost Note Field */
	enrichment_cost_noteField= new Ext.form.ComboBox({
		id: 'enrichment_cost_noteField',
		typeAhead: true,
		triggerAction: 'all',
		store:new Ext.data.SimpleStore({
			fields:['note_value', 'note_display'],
			data: [['uang_pangkal','Uang Pangkal'],['uang_seragam','Uang Seragam'],['uang_sekolah','Uang Sekolah']]
			}),
		mode: 'local',
      	displayField: 'note_display',
        valueField: 'note_value',
        enableKeyEvents : true,
        lazyRender:true,
        listClass: 'x-combo-list-small'	
	});
	
	/*Untuk ngecek value, apakah nilai nya * , jika iya, maka akan menampilkan / mengaktifkan label Priortiy */
	enrich_cust_priorityField= new Ext.form.TextField({
		id: 'enrich_cust_priorityField',
		readOnly: true
	});
	
	// Label ini jika aktif, akan menampilkan bintang (*) besar , dimana tujuan label ini adlh menunjukkan bahwa Student tersebut adalah Student High Priority
	enrich_cust_priorityLabel= new Ext.form.Label({
		style: {
			marginLeft: '100px',
			fontSize: '35px',
			//color: '#006600',
			color: '#CC0000'
		}
	});
	
	enrich_cust_nomemberLabel=new Ext.form.Label({ html: 'No Member: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'});
	
	enrich_cust_nomemberField= new Ext.form.TextField({
		id: 'enrich_cust_nomemberField',
		fieldLabel: 'Kategori',
		emptyText : '(Auto)',
		disabled : true,
		readOnly: true
		// hidden : true
	});
	
	enrich_valid_memberLabel=new Ext.form.Label({ html: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Member Valid: &nbsp;&nbsp;'});	
	
	enrich_valid_memberField= new Ext.form.DateField({
		id: 'enrich_valid_memberField',
		//fieldLabel: 'Member Valid',
		emptyText : '(Auto)',
		readOnly: true,
		disabled : true,
		format : 'd-m-Y',
		hidden: true
	});
	
	enrich_cust_ultahLabel=new Ext.form.Label({ html: 'Tanggal Ultah : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'});
	
	enrich_cust_ultahField= new Ext.form.DateField({
		id: 'enrich_cust_ultahField',
		fieldLabel: 'Tanggal Ultah',
		emptyText : '(Auto)',
		readOnly: true,
		disabled : true,
		format : 'd-m-Y',
		hidden : true
	});
	
	/* Identify  jproduk_cust Field */
	enrich_karyawanField= new Ext.form.ComboBox({
		id: 'enrich_karyawanField',
		fieldLabel: 'Karyawan',
		store: enrich_enrich_karyawanDataStore,
		mode: 'remote',
		displayField:'supplier_display',
		valueField: 'karyawan_value',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
		allowBlank : false,
        hideTrigger:false,
        tpl: enrich_karyawan_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});

	enrich_nikkaryawanField= new Ext.form.TextField({
		id: 'enrich_nikkaryawanField',
		fieldLabel: 'NIK',
		emptyText : '(Auto)',
		readOnly: true,
		renderer: function(value, cell, record){
				return value.substring(0,6) + '-' + value.substring(6,12) + '-' + value.substring(12);
			}
	});
	
	enrich_groomingGroup = new Ext.form.FieldSet({
		id : 'enrich_groomingGroup',
		title: 'Grooming',
		checkboxToggle:false,
		autoHeight: true,
		layout:'column',
		hidden: true,
		collapsible: true,
		collapsed : true,
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [enrich_karyawanField, enrich_nikkaryawanField] 
			}]
	
	});
	
	/* Identify  enrich_date Field */
	enrichment_tanggalField= new Ext.form.DateField({
		id: 'enrichment_tanggalField',
		fieldLabel: 'Date',
		width: 100,
		format : 'd-m-Y'
	});
	/* Identify  jproduk_diskon Field */
	enrich_diskonField= new Ext.form.NumberField({
		id: 'enrich_diskonField',
		fieldLabel: 'Disk Tambahan (%)',
		allowNegatife : false,
		blankText: '0',
		emptyText: '0',
		allowDecimals: true,
		enableKeyEvents: true,
		width: 120,
		maxLength: 3,
		maskRe: /([0-9]+)$/
	});
	
	enrich_ket_diskField= new Ext.form.TextField({
		id: 'jproduk_ket_disk',
		fieldLabel: 'No Voucher',
		itemCls : 'rata_kanan',
		hidden: true,
		width: 120
	});

	/*Uang Muka */
	enrich_cashback_cfField= new Ext.form.TextField({
		id: 'enrich_cashback_cfField',
		fieldLabel: 'Discount (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rata_kanan',
		anchor: '80%',
		//hidden: true,
		maskRe: /([0-9]+)$/
	});
	enrich_cashbackField= new Ext.form.NumberField({
		id: 'enrich_cashbackField',
		fieldLabel: 'Discount (Rp)',
		allowNegatife : false,
		blankText: '0',
		emptyText: '0',
		enableKeyEvents: true,
		readOnly : true,
		allowDecimals: false,
		width: 120,
		maskRe: /([0-9]+)$/
	});
	
	/* Identify  enrich_cara Field */
	enrichment_caraField= new Ext.form.ComboBox({
		id: 'enrichment_caraField',
		fieldLabel: 'Payment Method',
		store:new Ext.data.SimpleStore({
			fields:['enrich_cara_value', 'enrich_cara_display'],
			data:[['tunai','Cash'],['kwitansi','Kuitansi'],['card','Kartu Kredit']/*,['cek/giro','Cek/Giro']*/,['transfer','Transfer']]
		}),
		mode: 'local',
		displayField: 'enrich_cara_display',
		valueField: 'enrich_cara_value',
		editable: false,
		width: 40,
		triggerAction: 'all'
		//hidden: true		
	});
	/* Identify  enrich_cara2 Field */
	enrichment_cara2Field= new Ext.form.ComboBox({
		id: 'enrichment_cara2Field',
		fieldLabel: 'Payment Method 2',
		// hidden: true,
		store:new Ext.data.SimpleStore({
			fields:['enrich_cara_value', 'enrich_cara_display'],
			data:[['tunai','Cash'],['kwitansi','Kuitansi'],['card','Kartu Kredit']/*,['cek/giro','Cek/Giro']*/,['transfer','Transfer']]
		}),
		mode: 'local',
		displayField: 'enrich_cara_display',
		valueField: 'enrich_cara_value',
		editable: false,
		width: 100,
		triggerAction: 'all'	
	});
	/* Identify  enrich_cara3 Field */
	enrichment_cara3Field= new Ext.form.ComboBox({
		id: 'enrichment_cara3Field',
		fieldLabel: 'Payment Method 3',
		store:new Ext.data.SimpleStore({
			fields:['enrich_cara_value', 'enrich_cara_display'],
			data:[['tunai','Cash'],['kwitansi','Kuitansi'],['card','Kartu Kredit']/*,['cek/giro','Cek/Giro']*/,['transfer','Transfer']]
		}),
		mode: 'local',
		displayField: 'enrich_cara_display',
		valueField: 'enrich_cara_value',
		editable: false,
		width: 100,
		triggerAction: 'all'	
	});
	
	enrichment_stat_dokField= new Ext.form.ComboBox({
		id: 'enrichment_stat_dokField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['enrich_stat_dok_value', 'enrich_stat_dok_display'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal','Batal']]
		}),
		mode: 'local',
		displayField: 'enrich_stat_dok_display',
		valueField: 'enrich_stat_dok_value',
		editable: false,
		width: 100,
		triggerAction: 'all'	
	});
	
	enrich_stat_timeField= new Ext.form.ComboBox({
		id: 'enrich_stat_timeField',
		fieldLabel: 'Shift',
		store:new Ext.data.SimpleStore({
			fields:['enrich_stat_time_value', 'enrich_stat_time_display'],
			data:[['Pagi','Pagi'],['Malam','Malam']]
		}),
		mode: 'local',
		displayField: 'enrich_stat_time_display',
		valueField: 'enrich_stat_time_value',
		editable: false,
		width: 100,
		triggerAction: 'all'	
	});
	
	/* Identify  enrich_note Field */
	enrichment_keteranganField= new Ext.form.TextArea({
		id: 'enrichment_keteranganField',
		fieldLabel: 'Notes',
		maxLength: 250,
		height: 60,
		anchor: '95%'
	});
	
	enrich_voucher_noField= new Ext.form.TextField({
		id: 'enrich_voucher_noField',
		fieldLabel: 'Nomor Voucher',
		maxLength: 10,
		anchor: '95%'
	});

	enrich_voucher_cashback_cfField= new Ext.form.TextField({
		id: 'enrich_voucher_cashback_cfField',
		fieldLabel: 'Nilai Cashback',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	enrich_voucher_cashbackField= new Ext.form.NumberField({
		id: 'enrich_voucher_cashbackField',
		enableKeyEvents: true,
		fieldLabel: 'Nilai Cashback',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	master_enrichment_voucherGroup= new Ext.form.FieldSet({
		title: 'Voucher',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [enrich_voucher_noField,enrich_voucher_cashback_cfField] 
			}
		]
	
	});
	// END Field Voucher
	
	// START Field Voucher-2
	enrich_voucher_no2Field=new Ext.form.TextField({
		id: 'enrich_voucher_no2Field',
		fieldLabel: 'Nomor Voucher',
		maxLength: 10,
		anchor: '95%'
	});
	
	enrich_voucher_cashback2_cfField= new Ext.form.TextField({
		id: 'enrich_voucher_cashback2_cfField',
		fieldLabel: 'Nilai Cashback',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	enrich_voucher_cashback2Field= new Ext.form.NumberField({
		id: 'enrich_voucher_cashback2Field',
		enableKeyEvents: true,
		fieldLabel: 'Nilai Cashback',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	master_enrichment_voucher2Group= new Ext.form.FieldSet({
		title: 'Voucher',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [enrich_voucher_no2Field,enrich_voucher_cashback2_cfField] 
			}
		]
	
	});
	// END Field Voucher-2
	
	// START Field Voucher-3
	enrich_voucher_no3Field=new Ext.form.TextField({
		id: 'enrich_voucher_no3Field',
		fieldLabel: 'Nomor Voucher',
		maxLength: 10,
		anchor: '95%'
	});
	
	enrich_voucher_cashback3_cfField= new Ext.form.TextField({
		id: 'enrich_voucher_cashback3_cfField',
		fieldLabel: 'Nilai Cashback',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	enrich_voucher_cashback3Field= new Ext.form.NumberField({
		id: 'enrich_voucher_cashback3Field',
		enableKeyEvents: true,
		fieldLabel: 'Nilai Cashback',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	master_enrichment_voucher3Group= new Ext.form.FieldSet({
		title: 'Voucher',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [enrich_voucher_no3Field,enrich_voucher_cashback3_cfField] 
			}
		]
	
	});
	// END Field Voucher-3
	
	// START Field Card
	enrichment_card_namaField= new Ext.form.ComboBox({
		id: 'enrichment_card_namaField',
		fieldLabel: 'Jenis Kartu',
		store:new Ext.data.SimpleStore({
			fields:['jproduk_card_value', 'jproduk_card_display'],
			data:[['VISA','VISA'],['MASTERCARD','MASTERCARD'],['Debit','Debit']]
		}),
		mode: 'local',
		displayField: 'jproduk_card_display',
		valueField: 'jproduk_card_value',
		allowBlank: true,
		anchor: '75%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	
	enrichment_card_edcField= new Ext.form.ComboBox({
		id: 'enrichment_card_edcField',
		fieldLabel: 'EDC',
		store:new Ext.data.SimpleStore({
			fields:['enrich_card_edc_value', 'enrich_card_edc_display'],
			data:[['1','1'],['2','2'],['3','3']]
		}),
		mode: 'local',
		displayField: 'enrich_card_edc_display',
		valueField: 'enrich_card_edc_value',
		allowBlank: true,
		anchor: '75%',
		triggerAction: 'all',
		lazyRenderer: true,
		hidden: true
	});

	enrichment_card_noField= new Ext.form.TextField({
		id: 'enrichment_card_noField',
		fieldLabel: 'No Kartu',
		maxLength: 30,
		anchor: '95%'
	});
	
	enrich_card_nilai_cfField= new Ext.form.TextField({
		id: 'enrich_card_nilai_cfField',
		fieldLabel: 'Nominal (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	enrichment_card_nilaiField= new Ext.form.NumberField({
		id: 'enrichment_card_nilaiField',
		fieldLabel: 'Nominal (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	master_enrichment_cardGroup= new Ext.form.FieldSet({
		title: 'Credit Card',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [enrichment_card_namaField,enrichment_card_edcField,enrichment_card_noField,enrich_card_nilai_cfField] 
			}
		]
	
	});
	// END Field Card
	// START Field Card-2
	enrichment_card_nama2Field= new Ext.form.ComboBox({
		id: 'enrichment_card_nama2Field',
		fieldLabel: 'Jenis Kartu',
		store:new Ext.data.SimpleStore({
			fields:['jproduk_card_value', 'jproduk_card_display'],
			data:[['VISA','VISA'],['MASTERCARD','MASTERCARD'],['Debit','Debit']]
		}),
		mode: 'local',
		displayField: 'jproduk_card_display',
		valueField: 'jproduk_card_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	
	enrichment_card_edc2Field= new Ext.form.ComboBox({
		id: 'enrichment_card_edc2Field',
		fieldLabel: 'EDC',
		store:new Ext.data.SimpleStore({
			fields:['enrich_card_edc_value', 'enrich_card_edc_display'],
			data:[['1','1'],['2','2'],['3','3']]
		}),
		mode: 'local',
		displayField: 'enrich_card_edc_display',
		valueField: 'enrich_card_edc_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});

	enrichment_card_no2Field= new Ext.form.TextField({
		id: 'enrichment_card_no2Field',
		fieldLabel: 'No Kartu',
		maxLength: 30,
		anchor: '95%'
	});
	
	enrich_card_nilai2_cfField= new Ext.form.TextField({
		id: 'enrich_card_nilai2_cfField',
		fieldLabel: 'Nominal (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	enrichment_card_nilai2Field= new Ext.form.NumberField({
		id: 'enrichment_card_nilai2Field',
		fieldLabel: 'Nominal (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	master_enrichment_card2Group= new Ext.form.FieldSet({
		title: 'Credit Card',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [enrichment_card_nama2Field,enrichment_card_edc2Field,enrichment_card_no2Field,enrich_card_nilai2_cfField] 
			}
		]
	
	});
	// END Field Card-2
	// START Field Card-3
	enrichment_card_nama3Field= new Ext.form.ComboBox({
		id: 'enrichment_card_nama3Field',
		fieldLabel: 'Jenis Kartu',
		store:new Ext.data.SimpleStore({
			fields:['jproduk_card_value', 'jproduk_card_display'],
			data:[['VISA','VISA'],['MASTERCARD','MASTERCARD'],['Debit','Debit']]
		}),
		mode: 'local',
		displayField: 'jproduk_card_display',
		valueField: 'jproduk_card_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	
	enrichment_card_edc3Field= new Ext.form.ComboBox({
		id: 'enrichment_card_edc3Field',
		fieldLabel: 'EDC',
		store:new Ext.data.SimpleStore({
			fields:['enrich_card_edc_value', 'enrich_card_edc_display'],
			data:[['1','1'],['2','2'],['3','3']]
		}),
		mode: 'local',
		displayField: 'enrich_card_edc_display',
		valueField: 'enrich_card_edc_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});

	enrichment_card_no3Field= new Ext.form.TextField({
		id: 'enrichment_card_no3Field',
		fieldLabel: 'No Kartu',
		maxLength: 30,
		anchor: '95%'
	});
	
	enrich_card_nilai3_cfField= new Ext.form.TextField({
		id: 'enrich_card_nilai3_cfField',
		fieldLabel: 'Nominal (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	enrichment_card_nilai3Field= new Ext.form.NumberField({
		id: 'enrichment_card_nilai3Field',
		fieldLabel: 'Nominal (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	master_enrichment_card3Group= new Ext.form.FieldSet({
		title: 'Credit Card',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [enrichment_card_nama3Field,enrichment_card_edc3Field,enrichment_card_no3Field,enrich_card_nilai3_cfField] 
			}
		]
	
	});
	// END Field Card-3
	
	// StART Field Cek
	enrich_cek_namaField= new Ext.form.TextField({
		id: 'enrich_cek_namaField',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%'
	});
	
	enrich_cek_noField= new Ext.form.TextField({
		id: 'enrich_cek_noField',
		fieldLabel: 'No Cek/Giro',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	
	enrich_cek_validField= new Ext.form.DateField({
		id: 'enrich_cek_validField',
		allowBlank: true,
		fieldLabel: 'Valid',
		format: 'Y-m-d'
	});
	
	enrich_cek_bankField= new Ext.form.ComboBox({
		id: 'enrich_cek_bankField',
		fieldLabel: 'Bank',
		store: enrichment_bankDataStore,
		mode: 'remote',
		displayField: 'jproduk_bank_display',
		valueField: 'jproduk_bank_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true,
		renderer: Ext.util.Format.comboRenderer(enrich_cek_bankField)
	});
	
	enrich_cek_nilai_cfField= new Ext.form.TextField({
		id: 'enrich_cek_nilai_cfField',
		fieldLabel: 'Nominal (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	enrich_cek_nilaiField= new Ext.form.NumberField({
		id: 'enrich_cek_nilaiField',
		fieldLabel: 'Nominal (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	master_enrichment_cekGroup = new Ext.form.FieldSet({
		title: 'Check/Giro',
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [enrich_cek_namaField,enrich_cek_noField,enrich_cek_validField,enrich_cek_bankField,enrich_cek_nilai_cfField] 
			}
		]
	
	});
	// END Field Cek
	// StART Field Cek-2
	enrich_cek_nama2Field= new Ext.form.TextField({
		id: 'enrich_cek_nama2Field',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%'
	});
	
	enrich_cek_no2Field= new Ext.form.TextField({
		id: 'enrich_cek_no2Field',
		fieldLabel: 'No Cek/Giro',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	
	enrich_cek_valid2Field= new Ext.form.DateField({
		id: 'enrich_cek_valid2Field',
		allowBlank: true,
		fieldLabel: 'Valid',
		format: 'Y-m-d'
	});
	
	enrich_cek_bank2Field= new Ext.form.ComboBox({
		id: 'enrich_cek_bank2Field',
		fieldLabel: 'Bank',
		store: enrichment_bankDataStore,
		mode: 'remote',
		displayField: 'jproduk_bank_display',
		valueField: 'jproduk_bank_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true,
		renderer: Ext.util.Format.comboRenderer(enrich_cek_bankField)
	});
	
	enrich_cek_nilai2_cfField= new Ext.form.TextField({
		id: 'enrich_cek_nilai2_cfField',
		fieldLabel: 'Nominal (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	enrich_cek_nilai2Field= new Ext.form.NumberField({
		id: 'enrich_cek_nilai2Field',
		fieldLabel: 'Nominal (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	master_enrichment_cek2Group = new Ext.form.FieldSet({
		title: 'Check/Giro',
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [enrich_cek_nama2Field,enrich_cek_no2Field,enrich_cek_valid2Field,enrich_cek_bank2Field,enrich_cek_nilai2_cfField] 
			}
		]
	
	});
	// END Field Cek-2
	// StART Field Cek-3
	enrich_cek_nama3Field= new Ext.form.TextField({
		id: 'enrich_cek_nama3Field',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%'
	});
	
	enrich_cek_no3Field= new Ext.form.TextField({
		id: 'enrich_cek_no3Field',
		fieldLabel: 'No Cek/Giro',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	
	enrich_cek_valid3Field= new Ext.form.DateField({
		id: 'enrich_cek_valid3Field',
		allowBlank: true,
		fieldLabel: 'Valid',
		format: 'Y-m-d'
	});
	
	enrich_cek_bank3Field= new Ext.form.ComboBox({
		id: 'enrich_cek_bank3Field',
		fieldLabel: 'Bank',
		store: enrichment_bankDataStore,
		mode: 'remote',
		displayField: 'jproduk_bank_display',
		valueField: 'jproduk_bank_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true,
		renderer: Ext.util.Format.comboRenderer(enrich_cek_bankField)
	});
	
	enrich_cek_nilai3_cfField= new Ext.form.TextField({
		id: 'enrich_cek_nilai3_cfField',
		fieldLabel: 'Nominal (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	enrich_cek_nilai3Field= new Ext.form.NumberField({
		id: 'enrich_cek_nilai3Field',
		fieldLabel: 'Nominal (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	master_enrichment_cek3Group = new Ext.form.FieldSet({
		title: 'Check/Giro',
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [enrich_cek_nama3Field,enrich_cek_no3Field,enrich_cek_valid3Field,enrich_cek_bank3Field,enrich_cek_nilai3_cfField] 
			}
		]
	
	});
	// END Field Cek-3
	
	// START Field Transfer
	enrichment_transfer_bankField= new Ext.form.ComboBox({
		id: 'enrichment_transfer_bankField',
		fieldLabel: 'Bank',
		store: enrichment_bankDataStore,
		mode: 'remote',
		displayField: 'jproduk_bank_display',
		valueField: 'jproduk_bank_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true,
		renderer: Ext.util.Format.comboRenderer(enrichment_transfer_bankField)
	});

	enrichment_transfer_namaField= new Ext.form.TextField({
		id: 'enrichment_transfer_namaField',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	
	enrich_transfer_nilai_cfField= new Ext.form.TextField({
		id: 'enrich_transfer_nilai_cfField',
		fieldLabel: 'Nominal (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	enrichment_transfer_nilaiField= new Ext.form.NumberField({
		id: 'enrichment_transfer_nilaiField',
		enableKeyEvents: true,
		fieldLabel: 'Nominal (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	master_enrichment_transferGroup= new Ext.form.FieldSet({
		title: 'Transfer',
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [enrichment_transfer_bankField,enrichment_transfer_namaField,enrich_transfer_nilai_cfField] 
			}
		]
	
	});
	// END Field Transfer
	// START Field Transfer-2
	enrichment_transfer_bank2Field= new Ext.form.ComboBox({
		id: 'enrichment_transfer_bank2Field',
		fieldLabel: 'Bank',
		store: enrichment_bankDataStore,
		mode: 'remote',
		displayField: 'jproduk_bank_display',
		valueField: 'jproduk_bank_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});

	enrichment_transfer_nama2Field= new Ext.form.TextField({
		id: 'enrichment_transfer_nama2Field',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	
	enrich_transfer_nilai2_cfField= new Ext.form.TextField({
		id: 'enrich_transfer_nilai2_cfField',
		fieldLabel: 'Nominal (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	enrichment_transfer_nilai2Field= new Ext.form.NumberField({
		id: 'enrichment_transfer_nilai2Field',
		fieldLabel: 'Nominal (Rp)',
		enableKeyEvents: true,
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	master_enrichment_transfer2Group= new Ext.form.FieldSet({
		title: 'Transfer',
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [enrichment_transfer_bank2Field,enrichment_transfer_nama2Field,enrich_transfer_nilai2_cfField] 
			}
		]
	
	});
	// END Field Transfer-2
	// START Field Transfer-3
	enrichment_transfer_bank3Field= new Ext.form.ComboBox({
		id: 'enrichment_transfer_bank3Field',
		fieldLabel: 'Bank',
		store: enrichment_bankDataStore,
		mode: 'remote',
		displayField: 'jproduk_bank_display',
		valueField: 'jproduk_bank_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});

	enrichment_transfer_nama3Field= new Ext.form.TextField({
		id: 'enrichment_transfer_nama3Field',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	
	enrich_transfer_nilai3_cfField= new Ext.form.TextField({
		id: 'enrich_transfer_nilai3_cfField',
		fieldLabel: 'Nominal (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	enrichment_transfer_nilai3Field= new Ext.form.NumberField({
		id: 'enrichment_transfer_nilai3Field',
		fieldLabel: 'Nominal (Rp)',
		enableKeyEvents: true,
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	master_enrichment_transfer3Group= new Ext.form.FieldSet({
		title: 'Transfer',
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [enrichment_transfer_bank3Field,enrichment_transfer_nama3Field,enrich_transfer_nilai3_cfField] 
			}
		]
	
	});
	// END Field Transfer-3
	//START Field Cash-1
	enrichment_tunai_nilai_cfField= new Ext.form.TextField({
		id: 'enrichment_tunai_nilai_cfField',
		fieldLabel: 'Nominal (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rata_kanan',
		anchor: '80%',
		maskRe: /([0-9]+)$/ 
	});
	enrichment_tunai_nilaiField= new Ext.form.NumberField({
		id: 'enrichment_tunai_nilaiField',
		enableKeyEvents: true,
		fieldLabel: 'Nominal (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	master_enrichment_tunaiGroup = new Ext.form.FieldSet({
		title: 'Cash',
		autoHeight: true,
		//collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [enrichment_tunai_nilai_cfField] 
			}
		]
	
	});
	// END Cash-1
	
	//START Field Cash-2
	enrich_tunai_nilai2_cfField= new Ext.form.TextField({
		id: 'enrich_tunai_nilai2_cfField',
		fieldLabel: 'Nominal (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	enrichment_tunai_nilai2Field= new Ext.form.NumberField({
		id: 'enrichment_tunai_nilai2Field',
		enableKeyEvents: true,
		fieldLabel: 'Nominal (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	master_enrichment_tunai2Group = new Ext.form.FieldSet({
		title: 'Cash',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		// hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [enrich_tunai_nilai2_cfField] 
			}
		]
	
	});
	// END Cash-2
	
	//START Field Cash-3
	enrich_tunai_nilai3_cfField= new Ext.form.TextField({
		id: 'enrich_tunai_nilai3_cfField',
		fieldLabel: 'Nominal (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	enrichment_tunai_nilai3Field= new Ext.form.NumberField({
		id: 'enrichment_tunai_nilai3Field',
		enableKeyEvents: true,
		fieldLabel: 'Nominal (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	master_enrichment_tunai3Group = new Ext.form.FieldSet({
		title: 'Cash',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [enrich_tunai_nilai3_cfField] 
			}
		]
	
	});
	// END Cash-3
	
	//START Field Kwitansi-1
	enrichment_kwitansi_namaField= new Ext.form.TextField({
		id: 'enrichment_kwitansi_namaField',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		readOnly: true,
		anchor: '95%'
	});
	
	enrich_kwitansi_nilai_cfField= new Ext.form.TextField({
		id: 'enrich_kwitansi_nilai_cfField',
		fieldLabel: 'Diambil (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	enrichment_kwitansi_nilaiField= new Ext.form.NumberField({
		id: 'enrichment_kwitansi_nilaiField',
		enableKeyEvents: true,
		fieldLabel: 'Diambil (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/*Field ini dipakai untuk menyimpan ID dari tabel jual_kwitansi, dimana ID ini berperan untuk mengetahui apakah kwitansi tersebut akan di Insert atau di Update */
	enrich_kwitansi_idField1= new Ext.form.NumberField();
	enrich_kwitansi_idField2= new Ext.form.NumberField();
	enrich_kwitansi_idField3= new Ext.form.NumberField();
	
	enrich_kwitansi_idField= new Ext.form.NumberField();
	enrichment_kwitansi_noField= new Ext.form.ComboBox({
		id: 'enrichment_kwitansi_noField',
		fieldLabel: 'Nomor Kuitansi',
		store: cbo_kwitansi_enrichment_DataStore,
		mode: 'remote',
		displayField:'ckwitansi_no',
		valueField: 'ckwitansi_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: kwitansi_enrichment_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		//queryDelay:720,
		anchor: '95%'
		
	});
	
	enrich_kwitansi_sisaField= new Ext.form.NumberField({
		id: 'enrich_kwitansi_sisaField',
		fieldLabel: 'Sisa (Rp)',
		readOnly: true,
		anchor: '95%'
	});
	
	enrichment_kwitansi_noField.on("select",function(){
			j=cbo_kwitansi_enrichment_DataStore.findExact('ckwitansi_id',enrichment_kwitansi_noField.getValue(),0);
			if(j>-1){
				enrichment_kwitansi_namaField.setValue(cbo_kwitansi_enrichment_DataStore.getAt(j).data.ckwitansi_cust_nama);
				enrich_kwitansi_sisaField.setValue(cbo_kwitansi_enrichment_DataStore.getAt(j).data.total_sisa);
			}
		});
	// END Kwitansi-1
	
	//START Field Kwitansi-2
	enrichment_kwitansi_nama2Field= new Ext.form.TextField({
		id: 'enrichment_kwitansi_nama2Field',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		readOnly: true,
		anchor: '95%'
	});
	
	enrich_kwitansi_nilai2_cfField= new Ext.form.TextField({
		id: 'enrich_kwitansi_nilai2_cfField',
		fieldLabel: 'Diambil (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	enrichment_kwitansi_nilai2Field= new Ext.form.NumberField({
		id: 'enrichment_kwitansi_nilai2Field',
		enableKeyEvents: true,
		fieldLabel: 'Diambil (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	enrich_kwitansi_id2Field= new Ext.form.NumberField();
	enrichment_kwitansi_no2Field= new Ext.form.ComboBox({
		id: 'enrichment_kwitansi_no2Field',
		fieldLabel: 'Nomor Kuitansi',
		store: cbo_kwitansi_enrichment_DataStore,
		mode: 'remote',
		displayField:'ckwitansi_no',
		valueField: 'ckwitansi_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: kwitansi_enrichment_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'query',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		queryDelay:720,
		anchor: '95%'
	});
	
	enrich_kwitansi_sisa2Field= new Ext.form.NumberField({
		id: 'enrich_kwitansi_sisa2Field',
		fieldLabel: 'Sisa (Rp)',
		readOnly: true,
		anchor: '95%'
	});
	
	enrichment_kwitansi_no2Field.on("select",function(){
			j=cbo_kwitansi_enrichment_DataStore.findExact('ckwitansi_id',enrichment_kwitansi_no2Field.getValue(),0);
			if(j>-1){
				enrichment_kwitansi_nama2Field.setValue(cbo_kwitansi_enrichment_DataStore.getAt(j).data.ckwitansi_cust_nama);
				enrich_kwitansi_sisa2Field.setValue(cbo_kwitansi_enrichment_DataStore.getAt(j).data.total_sisa);
			}
		});
	// END Kwitansi-2
	
	//START Field Kwitansi-3
	enrichment_kwitansi_nama3Field= new Ext.form.TextField({
		id: 'enrichment_kwitansi_nama3Field',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		readOnly: true,
		anchor: '95%'
	});
	
	enrich_kwitansi_nilai3_cfField= new Ext.form.TextField({
		id: 'enrich_kwitansi_nilai3_cfField',
		fieldLabel: 'Diambil (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	enrichment_kwitansi_nilai3Field= new Ext.form.NumberField({
		id: 'enrichment_kwitansi_nilai3Field',
		enableKeyEvents: true,
		fieldLabel: 'Diambil (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	enrich_kwitansi_id3Field= new Ext.form.NumberField();
	enrichment_kwitansi_no3Field= new Ext.form.ComboBox({
		id: 'enrichment_kwitansi_no3Field',
		fieldLabel: 'Nomor Kuitansi',
		store: cbo_kwitansi_enrichment_DataStore,
		mode: 'remote',
		displayField:'ckwitansi_no',
		valueField: 'ckwitansi_id',
        typeAhead: false,
        loadingText: 'Searching...',
       pageSize:10,
        hideTrigger:false,
        tpl: kwitansi_enrichment_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'query',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		queryDelay:720,
		anchor: '95%'
	});
	
	enrich_kwitansi_sisa3Field= new Ext.form.NumberField({
		id: 'enrich_kwitansi_sisa3Field',
		fieldLabel: 'Sisa (Rp)',
		readOnly: true,
		anchor: '95%'
	});
	
	enrichment_kwitansi_no3Field.on("select",function(){
			j=cbo_kwitansi_enrichment_DataStore.findExact('ckwitansi_id',enrichment_kwitansi_no3Field.getValue(),0);
			if(j>-1){
				enrichment_kwitansi_nama3Field.setValue(cbo_kwitansi_enrichment_DataStore.getAt(j).data.ckwitansi_cust_nama);
				enrich_kwitansi_sisa3Field.setValue(cbo_kwitansi_enrichment_DataStore.getAt(j).data.total_sisa);
			}
		});
	// END Kwitansi-3
	
	master_enrichment_kwitansiGroup = new Ext.form.FieldSet({
		title: 'Kwitansi',
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [enrichment_kwitansi_noField,enrichment_kwitansi_namaField,enrich_kwitansi_sisaField,enrich_kwitansi_nilai_cfField] 
			}
		]
	
	});
	
	master_enrichment_kwitansi2Group = new Ext.form.FieldSet({
		title: 'Kwitansi',
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [enrichment_kwitansi_no2Field,enrichment_kwitansi_nama2Field,enrich_kwitansi_sisa2Field,enrich_kwitansi_nilai2_cfField] 
			}
		]
	
	});
	
	master_enrichment_kwitansi3Group = new Ext.form.FieldSet({
		title: 'Kwitansi',
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [enrichment_kwitansi_no3Field,enrichment_kwitansi_nama3Field,enrich_kwitansi_sisa3Field,enrich_kwitansi_nilai3_cfField] 
			}
		]
	
	});
	
	//* Bayar
	enrich_jumlahLabel= new Ext.form.DisplayField({
		fieldLabel : 'Jumlah',
		itemCls : 'rata_kanan'
	});
	enrichment_subTotalLabel= new Ext.form.DisplayField({
		fieldLabel : 'Sub Total (Rp)',
		itemCls : 'rata_kanan'
		//itemCls : 'rmoney2'
	});
	enrichment_TotalLabel= new Ext.form.DisplayField({
		fieldLabel : '<span style="font-weight:bold"><font size=4>Total (Rp)</span>',
		itemCls : 'rmoney2'
	});
	
	enrichment_TotalBayarLabel= new Ext.form.DisplayField({
		fieldLabel : '<span style="font-weight:bold"><font size=4>Total Payment (Rp)</span>',
		itemCls : 'rmoney2'
	});
	
	enrichment_sisabayarLabel= new Ext.form.DisplayField({
		id: 'enrichment_sisabayarLabel',
		fieldLabel : '<font color=red size=2>Payment Rest (Rp)<font>',
		itemCls : 'rmoney_hutang',
		// hidden: true
	});
	
	enrich_jumlahField= new Ext.form.NumberField({
		id: 'enrich_jumlahField',
		fieldLabel: 'Jumlah Item',
		allowBlank: true,
		readOnly: true,
		allowDecimals: false,
		width: 40,
		maxLength: 50,
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	enrichment_subTotal_cfField= new Ext.form.TextField({
		id: 'enrichment_subTotal_cfField',
		fieldLabel: 'Sub Total (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		allowDecimals : false,
		itemCls: 'rmoney',
		width: 120,
		maskRe: /([0-9]+)$/ 
	});
	
	enrichment_subTotalField= new Ext.form.NumberField({
		id: 'enrichment_subTotalField',
		enableKeyEvents: true,
		fieldLabel: 'Sub Total (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	//SUB TOTAL DPP
	enrichment_dpp_Field= new Ext.form.NumberField({
		id: 'enrichment_dpp_Field',
		fieldLabel: 'Sub Total DPP (Rp)',
		valueRenderer: 'numberToCurrency',
		readOnly: true,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		width: 120
	});
	enrichment_dpp_cfField= new Ext.form.TextField({
		id: 'enrichment_dpp_cfField',
		allowNegatife : false,
		enableKeyEvents: true,
		allowDecimals : false,
		itemCls: 'rmoney',
		width: 120,
		readOnly : true,
		maskRe: /([0-9]+)$/ 
	});

	enrichment_total_cfField= new Ext.form.TextField({
		id: 'enrichment_total_cfField',
		fieldLabel: '<span style="font-weight:bold">Total (Rp)</span>',
		allowNegatife : false,
		enableKeyEvents: true,
		allowDecimals : false,
		itemCls: 'rmoney',
		width: 120,
		readOnly : true,
		maskRe: /([0-9]+)$/ 
	});
	enrichment_totalField= new Ext.form.NumberField({
		id: 'enrichment_totalField',
		enableKeyEvents: true,
		fieldLabel: '<span style="font-weight:bold">Total (Rp)</span>',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	enrichment_kembalianField= new Ext.form.NumberField({
		id: 'enrichment_totalField',
		enableKeyEvents: true,
		fieldLabel: '<span style="font-weight:bold">Total (Rp)</span>',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	enrichment_bayar_cfField= new Ext.form.TextField({
		id: 'enrichment_bayar_cfField',
		fieldLabel: 'Total Bayar (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		width: 120,
		readOnly : true,
		maskRe: /([0-9]+)$/ 
	});
	enrichment_bayarField= new Ext.form.NumberField({
		id: 'enrichment_bayarField',
		enableKeyEvents: true,
		fieldLabel: 'Total Bayar (Rp)',
		allowDecimals : false,
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	enrich_hutang_cfField= new Ext.form.TextField({
		id: 'enrich_hutang_cfField',
		fieldLabel: 'Hutang (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		width: 120,
		maskRe: /([0-9]+)$/,
		hidden: true
	});
	enrich_hutangField= new Ext.form.NumberField({
		id: 'enrich_hutangField',
		enableKeyEvents: true,
		fieldLabel: 'Hutang (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/,
		hidden: true
	});

	enrichment_pesanLabel= new Ext.form.Label({
		style: {
			fieldLabel : 'Test', 
			marginLeft: '100px',
			fontSize: '14px',
			color: '#CC0000'
		}
	});
	
	enrichment_kembalianLabel= new Ext.form.DisplayField({
		fieldLabel : '<font color=green size=3>Change (Rp)<font>',
		itemCls : 'rmoney2'
	});

	enrich_lunasLabel= new Ext.form.Label({
		style: {
			marginLeft: '100px',
			fontSize: '14px',
			color: '#006600'
		}
	});
	
	enrichment_master_cara_bayarTabPanel = new Ext.TabPanel({
		plain:true,
		activeTab: 0,
		frame: true,
		height: 275,
		width: 370,
		defaults:{bodyStyle:'padding:10px'},
		items:[{
                title:'Payment Method',
                layout:'form',
				frame: true,
                defaults: {width: 230},
                defaultType: 'textfield',
                items: [enrichment_caraField,master_enrichment_tunaiGroup,master_enrichment_cardGroup,master_enrichment_cekGroup,master_enrichment_kwitansiGroup,master_enrichment_transferGroup,master_enrichment_voucherGroup]
            },{
                title:'Payment Method 2',
                layout:'form',
				frame: true,
                defaults: {width: 230},
                defaultType: 'textfield',
                items: [enrichment_cara2Field, master_enrichment_tunai2Group, master_enrichment_kwitansi2Group ,master_enrichment_card2Group, master_enrichment_cek2Group, master_enrichment_transfer2Group, master_enrichment_voucher2Group]
            },{
                title:'Payment Method 3',
                layout:'form',
				frame: true,
                defaults: {width: 230},
                defaultType: 'textfield',
                items: [enrichment_cara3Field, master_enrichment_tunai3Group, master_enrichment_kwitansi3Group, master_enrichment_card3Group, master_enrichment_cek3Group, master_enrichment_transfer3Group, master_enrichment_voucher3Group]
            }
			
			]
	});
	
	master_enrichment_bayarGroup = new Ext.form.FieldSet({
		//title: '-',
		//autoHeight: true,
		width: 978,
		height: 250,
		//collapsible: true,
		layout:'column',
		frame: true,
		items:[
		
			   {
				columnWidth:0.4,
				layout: 'form',
				border:false,
				items: [enrichment_master_cara_bayarTabPanel] 
			}
			,
			
			{
				columnWidth:0.4,
				labelWidth: 200,
				layout: 'form',
    			labelPad: 0, 
				baseCls: 'x-plain',
				border:false,
				labelAlign: 'left',
				items: [/*enrich_jumlahField*/ /*enrich_jumlahLabel,*/ /*enrichment_subTotal_cfField*/ enrichment_subTotalLabel , enrich_cashback_cfField,
			  /*enrich_ket_diskField, {xtype: 'spacer',height:10} *//*enrichment_total_cfField,*/enrichment_TotalLabel, /*enrichment_bayar_cfField*/ /*enrichment_tunai_nilai_cfField,*/ enrichment_TotalBayarLabel, /*enrich_hutang_cfField,*/enrichment_sisabayarLabel, enrichment_kembalianLabel, enrichment_pesanLabel, enrich_lunasLabel] 
			}
			]
	});
	
	/*Fieldset Master*/
	master_enrichment_masterGroup = new Ext.form.FieldSet({
		title: 'Enrichment Registration',
		autoHeight: true,
		//collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.6,
				layout: 'form',
				border:false,
				items: [enrichment_noField,enrichment_tanggalField, enrichment_studentField , enrichment_classLPField /*, enrich_stat_timeField*/
						/*{
							columnWidth:0.5,
							layout: 'column',
							border:false,
							items:[enrich_cust_nomemberField,enrich_valid_memberField]
						}, {xtype: 'spacer',height:5},
						{
							columnWidth:0.5,
							layout: 'column',
							border:false,
							items:[enrich_cust_ultahField,enrich_cust_priorityLabel]
						}*/
						] 
			},
			{
				columnWidth:0.4,
				layout: 'form',
				border:false,
				items: [enrichment_keteranganField, enrichment_stat_dokField] 
			}
			]
	});
	
	/*Detail Declaration */
		
	// Function for json reader of detail
	var detail_enrichment_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: ''
	},[
	/* dataIndex => insert intopeprodukan_ColumnModel, Mapping => for initiate table column */ 
			{name: 'denrich_id', type: 'int', mapping: 'denrich_id'}, 
			{name: 'dproduk_master', type: 'int', mapping: 'dproduk_master'}, 
			{name: 'denrich_jasa', type: 'int', mapping: 'denrich_jasa'}, 
			{name: 'denrich_satuan', type: 'int', mapping: 'denrich_satuan'}, 
			{name: 'denrich_jumlah', type: 'int', mapping: 'denrich_jumlah'}, 
			{name: 'denrich_price', type: 'float', mapping: 'denrich_price'}, 
			{name: 'denrich_disc', type: 'float', mapping: 'denrich_disc'},
			{name: 'denrich_diskon_jenis', type: 'string', mapping: 'denrich_diskon_jenis'},
			{name: 'nama_karyawan', type: 'string', mapping: 'karyawan_username'},
			// {name: 'denrich_subtot', type: 'int', mapping: 'denrich_subtot'},
			{name: 'dproduk_subtotal', type: 'float', mapping: 'dproduk_subtotal'},
			{name: 'denrich_subtot', type: 'float', mapping: 'denrich_subtot'},
			{name: 'enrich_total_bayar', type: 'float', mapping: 'enrich_total_bayar'},
			{name: 'jproduk_diskon', type: 'int', mapping: 'jproduk_diskon'},
			{name: 'enrich_cashback', type: 'float', mapping: 'enrich_cashback'},
			{name: 'produk_harga_default', type: 'float', mapping: 'produk_harga_default'}
	]);
	//eof
	
	//function for json writer of detail
	var detail_enrichment_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	/* Function for Retrieve DataStore of detail*/
	detail_enrichment_DataStore = new Ext.data.Store({
		id: 'detail_enrichment_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_enrichment&m=detail_detail_enrichment_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 750},
		reader: detail_enrichment_reader,
		sortInfo:{field: 'denrich_id', direction: "ASC"}
	});
	/* End of Function */
	
	//function for editor of detail
	var editor_detail_enrichment= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof
	
	cbo_denrichment_DataStore = new Ext.data.Store({
		id: 'cbo_denrichment_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_enrichment&m=get_enrichment_list', 
			method: 'POST'
		}),baseParams: {aktif: 'yes', start: 0, limit: 15 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'rawat_id'
		},[
			{name: 'dproduk_produk_value', type: 'int', mapping: 'rawat_id'},
			{name: 'dproduk_produk_harga', type: 'float', mapping: 'rawat_harga'},
			{name: 'dproduk_produk_kode', type: 'string', mapping: 'rawat_kode'},
			{name: 'dproduk_produk_satuan', type: 'string', mapping: 'satuan_kode'},
			{name: 'dproduk_produk_group', type: 'string', mapping: 'group_nama'},
			{name: 'dproduk_produk_kategori', type: 'string', mapping: 'kategori_nama'},
			{name: 'dproduk_produk_du', type: 'float', mapping: 'rawat_du'},
			{name: 'dproduk_produk_dm', type: 'float', mapping: 'produk_dm'},
			{name: 'dproduk_produk_dultah', type: 'float', mapping: 'produk_dultah'},
			{name: 'dproduk_produk_dcard', type: 'float', mapping: 'produk_dcard'},
			{name: 'dproduk_produk_dkolega', type: 'float', mapping: 'produk_dkolega'},
			{name: 'dproduk_produk_dkeluarga', type: 'float', mapping: 'produk_dkeluarga'},
			{name: 'dproduk_produk_downer', type: 'float', mapping: 'produk_downer'},
			{name: 'dproduk_produk_dgrooming', type: 'float', mapping: 'produk_dgrooming'},
			{name: 'dproduk_produk_dwartawan', type: 'float', mapping: 'produk_dwartawan'},
			{name: 'dproduk_produk_dstaffdokter', type: 'float', mapping: 'produk_dstaffdokter'},
			{name: 'dproduk_produk_dstaffnondokter', type: 'float', mapping: 'produk_dstaffnondokter'},
			{name: 'dproduk_produk_dpromo', type: 'float', mapping: 'produk_dpromo'},
			{name: 'dproduk_produk_display', type: 'string', mapping: 'rawat_nama'}
		]),
		sortInfo:{field: 'dproduk_produk_display', direction: "ASC"}
	});
	
	cbo_denrichment_supplierDataStore = new Ext.data.Store({
		id: 'cbo_denrichment_supplierDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_enrichment&m=get_supplier_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 100 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
		},[
			{name: 'supplier_display', type: 'string', mapping: 'supplier_nama'},
			{name: 'supplier_alamat', type: 'string', mapping: 'supplier_alamat'},
			{name: 'supplier_notelp', type: 'string', mapping: 'supplier_notelp'},
			{name: 'supplier_value', type: 'int', mapping: 'supplier_id'}
		]),
		sortInfo:{field: 'supplier_display', direction: "ASC"}
	});
	var enrich_supplier_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{supplier_display}</b> | {supplier_alamat}</span>',
        '</div></tpl>'
    );
	
	cbo_denrich_satuanDataStore = new Ext.data.Store({
		id: 'cbo_denrich_satuanDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_enrichment&m=get_satuan_bydjproduk_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'satuan_id'
		},[
			{name: 'djproduk_satuan_value', type: 'int', mapping: 'satuan_id'},
			{name: 'djproduk_satuan_nama', type: 'string', mapping: 'satuan_nama'},
			{name: 'djproduk_satuan_nilai', type: 'float', mapping: 'konversi_nilai'},
			{name: 'djproduk_satuan_display', type: 'string', mapping: 'satuan_kode'},
			{name: 'djproduk_satuan_default', type: 'string', mapping: 'konversi_default'},
			{name: 'djproduk_satuan_harga', type: 'float', mapping: 'produk_harga'},
			{name: 'djproduk_kode', type: 'string', mapping: 'produk_kode'}
		]),
		sortInfo:{field: 'djproduk_satuan_default', direction: "DESC"}
	});
	
	enrich_memberDataStore = new Ext.data.Store({
		id: 'enrich_memberDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_enrichment&m=get_member_by_cust', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'member_id'
		},[
		/* dataIndex => insert intotbl_usersColumnModel, Mapping => for initiate table column */ 
			{name: 'member_id', type: 'int', mapping: 'member_id'},
			{name: 'member_no', type: 'string', mapping: 'member_no'},
			{name: 'cust_kategori', type: 'string', mapping: 'cust_kategori'},
			{name: 'member_valid', type: 'date', dateFormat: 'Y-m-d', mapping: 'member_valid'}, 
			{name: 'member_point' , type: 'int', mapping: 'member_point'},
			{name: 'member_jenis' , type: 'string', mapping: 'member_jenis'},
			{name: 'member_aktif' , type: 'string', mapping: 'member_aktif'},
			{name: 'cust_tgllahir' , type: 'date', dateFormat: 'Y-m-d', mapping: 'cust_tgllahir'},
			{name: 'cust_priority_star' , type: 'string', mapping: 'cust_priority_star'}
		]),
		sortInfo:{field: 'member_id', direction: "ASC"}
	});
	
	enrich_karyawanDataStore = new Ext.data.Store({
		id: 'enrich_karyawanDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_enrichment&m=get_nik', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'karyawan_id'
		},[
		/* dataIndex => insert intotbl_usersColumnModel, Mapping => for initiate table column */ 
			{name: 'karyawan_id', type: 'int', mapping: 'karyawan_id'},
			{name: 'karyawan_no', type: 'string', mapping: 'karyawan_no'}
		]),
		sortInfo:{field: 'karyawan_id', direction: "ASC"}
	});
	
	var combo_jual_enrichment=new Ext.form.ComboBox({
		store: cbo_denrichment_DataStore,
		mode: 'remote',
		displayField: 'dproduk_produk_display',
		valueField: 'dproduk_produk_value',
		typeAhead: false,
		loadingText: 'Searching...',
		pageSize:enrich_pageS,
		hideTrigger:false,
		tpl: enrich_jual_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		enableKeyEvents: true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	
	var combo_enrich_supplier=new Ext.form.ComboBox({
		store: cbo_denrichment_supplierDataStore,
		mode: 'remote',
		displayField: 'supplier_display',
		valueField: 'supplier_value',
		typeAhead: false,
		loadingText: 'Searching...',
		pageSize:enrich_pageS,
		hideTrigger:false,
		tpl: enrich_supplier_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	
	var combo_satuan_enrichment=new Ext.form.ComboBox({
		store: cbo_denrich_satuanDataStore,
		mode:'local',
		typeAhead: true,
		displayField: 'djproduk_satuan_display',
		valueField: 'djproduk_satuan_value',
		triggerAction: 'all',
		allowBlank : false,
		anchor: '95%'
	});
	
	denrich_idField=new Ext.form.NumberField();
	denrich_satuan_nilaiField=new Ext.form.NumberField();	

	

	temp_konv_nilai=new Ext.form.NumberField({
		readOnly: true,
		allowDecimals: true,
		decimalPrecision: 9
	});

	combo_satuan_enrichment.on('focus', function(){
		cbo_denrich_satuanDataStore.setBaseParam('produk_id',combo_jual_enrichment.getValue());
		cbo_denrich_satuanDataStore.load();
	});
	combo_satuan_enrichment.on('select', function(){
		var j=cbo_denrich_satuanDataStore.findExact('djproduk_satuan_value',combo_satuan_enrichment.getValue(),0);
		var jt=cbo_denrich_satuanDataStore.findExact('djproduk_satuan_default','true',0);
		var nilai_terpilih=0;
		var nilai_default=0;
		var dtotal_konversi_field = 0;
		var dsub_total_field = 0;
		var dtotal_net_field = 0;
		
		if(cbo_denrich_satuanDataStore.getCount()>=0){
			if(cbo_denrich_satuanDataStore.getAt(j).data.djproduk_satuan_default=="true"){
				//Harga_Produk=harga yg tercantum di Master Produk tanpa proses bagi/kali
				denrich_satuan_nilaiField.setValue(1);
				
				dtotal_konversi_field = 1*denrich_harga_defaultField.getValue();
				dtotal_konversi_field = (dtotal_konversi_field>0?Math.round(dtotal_konversi_field):0);
				dharga_enrichment_konversiField.setValue(dtotal_konversi_field);
				
				dsub_total_field = djumlah_beli_enrichmentField.getValue()*(1*denrich_harga_defaultField.getValue());
				dsub_total_field = (dsub_total_field>0?Math.round(dsub_total_field):0);
				denrich_sub_totalField.setValue();
				
				//dtotal_net_field = dsub_total_field -denrich_jumlah_diskonField.getValue();
				dtotal_net_field = ((100-denrich_jumlah_diskonField.getValue())/100)*djumlah_beli_enrichmentField.getValue()*(1*denrich_harga_defaultField.getValue());
				dtotal_net_field = (dtotal_net_field>0?Math.round(dtotal_net_field):0);
				denrich_subtotal_netField.setValue(dtotal_net_field);
			}else if(cbo_denrich_satuanDataStore.getAt(j).data.djproduk_satuan_default=="false"){
				//ambil satuan_nilai dr satuan_id yg terpilih, ambil satuan_nilai dr satuan_default=true
				//jika [satuan_nilai dr satuan_default=true] === 1 => Harga_Produk=[satuan_nilai dr satuan_id yg terpilih]*data.djproduk_satuan_harga
				//jika [satuan_nilai dr satuan_default=true] !== 1 AND [satuan_nilai dr satuan_default=true] < [satuan_nilai dr satuan_id yg terpilih] => Harga_Produk=([satuan_nilai dr satuan_id yg terpilih]/[satuan_nilai dr satuan_default=true])*data.djproduk_satuan_harga 
				//jika [satuan_nilai dr satuan_default=true] !== 1 AND [satuan_nilai dr satuan_default=true] > [satuan_nilai dr satuan_id yg terpilih] => Harga_Produk=data.djproduk_satuan_harga/[satuan_nilai dr satuan_default=true]
				nilai_terpilih=cbo_denrich_satuanDataStore.getAt(j).data.djproduk_satuan_nilai;
				nilai_default=cbo_denrich_satuanDataStore.getAt(jt).data.djproduk_satuan_nilai;
				if(nilai_default===1){
					denrich_satuan_nilaiField.setValue(cbo_denrich_satuanDataStore.getAt(j).data.djproduk_satuan_nilai);
					
					dtotal_konversi_field = cbo_denrich_satuanDataStore.getAt(j).data.djproduk_satuan_nilai*denrich_harga_defaultField.getValue();
					dtotal_konversi_field = (dtotal_konversi_field>0?Math.round(dtotal_konversi_field):0);
					dharga_enrichment_konversiField.setValue(dtotal_konversi_field);
					
					dsub_total_field = djumlah_beli_enrichmentField.getValue()*(cbo_denrich_satuanDataStore.getAt(j).data.djproduk_satuan_nilai*denrich_harga_defaultField.getValue());
					dsub_total_field = (dsub_total_field>0?Math.round(dsub_total_field):0);
					denrich_sub_totalField.setValue(dsub_total_field);
					
					// dtotal_net_field = dsub_total_field -denrich_jumlah_diskonField.getValue();
					dtotal_net_field = ((100-denrich_jumlah_diskonField.getValue())/100)*djumlah_beli_enrichmentField.getValue()*(cbo_denrich_satuanDataStore.getAt(j).data.djproduk_satuan_nilai*denrich_harga_defaultField.getValue());
					dtotal_net_field = (dtotal_net_field>0?Math.round(dtotal_net_field):0);
					denrich_subtotal_netField.setValue(dtotal_net_field);
				}else if(nilai_default!==1 && nilai_default<nilai_terpilih){
					denrich_satuan_nilaiField.setValue(nilai_terpilih/nilai_default);
					
					dtotal_konversi_field = (nilai_terpilih/nilai_default)*denrich_harga_defaultField.getValue();
					dtotal_konversi_field = (dtotal_konversi_field>0?Math.round(dtotal_konversi_field):0);
					dharga_enrichment_konversiField.setValue(dtotal_konversi_field);
					
					dsub_total_field = djumlah_beli_enrichmentField.getValue()*((nilai_terpilih/nilai_default)*denrich_harga_defaultField.getValue());
					dsub_total_field = (dsub_total_field>0?Math.round(dsub_total_field):0);
					denrich_sub_totalField.setValue(dsub_total_field);
					
					// dtotal_net_field = dsub_total_field -denrich_jumlah_diskonField.getValue();
					dtotal_net_field = ((100-denrich_jumlah_diskonField.getValue())/100)*djumlah_beli_enrichmentField.getValue()*((nilai_terpilih/nilai_default)*denrich_harga_defaultField.getValue());
					dtotal_net_field = (dtotal_net_field>0?Math.round(dtotal_net_field):0);
					denrich_subtotal_netField.setValue(dtotal_net_field);
				}else if(nilai_default!==1 && nilai_default>nilai_terpilih){
					denrich_satuan_nilaiField.setValue(1/nilai_default);
					
					dtotal_konversi_field = (1/nilai_default)*denrich_harga_defaultField.getValue();
					dtotal_konversi_field = (dtotal_konversi_field>0?Math.round(dtotal_konversi_field):0);
					dharga_enrichment_konversiField.setValue(dtotal_konversi_field);
					
					dsub_total_field = djumlah_beli_enrichmentField.getValue()*((1/nilai_default)*denrich_harga_defaultField.getValue());
					dsub_total_field = (dsub_total_field>0?Math.round(dsub_total_field):0);
					denrich_sub_totalField.setValue(dsub_total_field);
					
					// dtotal_net_field = djumlah_beli_enrichmentField.getValue()*((1/nilai_default)*denrich_harga_defaultField.getValue()) - denrich_jumlah_diskonField.getValue();
					dtotal_net_field = ((100-denrich_jumlah_diskonField.getValue())/100)*djumlah_beli_enrichmentField.getValue()*((1/nilai_default)*denrich_harga_defaultField.getValue());
					dtotal_net_field = (dtotal_net_field>0?Math.round(dtotal_net_field):0);
					denrich_subtotal_netField.setValue(dtotal_net_field);
				}
			}
		}
	});
	
	var denrich_jenis_diskonField = new Ext.form.ComboBox({
		store:new Ext.data.SimpleStore({
			fields:['diskon_jenis_value'],
			data:[['Tanpa Diskon'],['Umum'],['Member'],['Ultah'],['Card'],['Owner'],['Staff'],['Promo']]
		}),
		mode: 'local',
		displayField: 'diskon_jenis_value',
		valueField: 'diskon_jenis_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	denrich_jenis_diskonField.on('select', function(){
		var dtotal_net_field = 0;
		var djumlah_beli_produk = djumlah_beli_enrichmentField.getValue();
		var j=cbo_denrichment_DataStore.findExact('dproduk_produk_value',combo_jual_enrichment.getValue(),0);
		var djenis_diskon = 0;
		if(denrich_jenis_diskonField.getValue()=='Umum'){
			djenis_diskon = cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_du;
			denrich_jumlah_diskonField.setValue(cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_du);
			//denrich_jumlah_diskonField.setReadOnly(true);
			denrich_jumlah_diskonField.setDisabled(true);
		}else if(denrich_jenis_diskonField.getValue()=='Member'){
			djenis_diskon = cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_dm;
			denrich_jumlah_diskonField.setValue(cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_dm);
			//denrich_jumlah_diskonField.setReadOnly(true);
			denrich_jumlah_diskonField.setDisabled(true);
		}else if(denrich_jenis_diskonField.getValue()=='Ultah'){
			djenis_diskon = cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_dultah;
			denrich_jumlah_diskonField.setValue(cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_dultah);
			//denrich_jumlah_diskonField.setReadOnly(true);
			denrich_jumlah_diskonField.setDisabled(true);
		}else if(denrich_jenis_diskonField.getValue()=='Card'){
			djenis_diskon = cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_dcard;
			denrich_jumlah_diskonField.setValue(cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_dcard);
			//denrich_jumlah_diskonField.setReadOnly(false);
			denrich_jumlah_diskonField.setDisabled(false);
		}else if(denrich_jenis_diskonField.getValue()=='Kolega'){
			djenis_diskon = cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_dkolega;
			denrich_jumlah_diskonField.setValue(cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_dkolega);
			//denrich_jumlah_diskonField.setReadOnly(true);
			denrich_jumlah_diskonField.setDisabled(true);
		}else if(denrich_jenis_diskonField.getValue()=='Keluarga'){
			djenis_diskon = cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_dkeluarga;
			denrich_jumlah_diskonField.setValue(cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_dkeluarga);
			//denrich_jumlah_diskonField.setReadOnly(true);
			denrich_jumlah_diskonField.setDisabled(true);
		}else if(denrich_jenis_diskonField.getValue()=='Owner'){
			djenis_diskon = cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_downer;
			denrich_jumlah_diskonField.setValue(cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_downer);
			//denrich_jumlah_diskonField.setReadOnly(true);
			denrich_jumlah_diskonField.setDisabled(true);
		}else if(denrich_jenis_diskonField.getValue()=='Grooming'){
			djenis_diskon = cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_dgrooming;
			denrich_jumlah_diskonField.setValue(cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_dgrooming);
			//denrich_jumlah_diskonField.setReadOnly(true);
			denrich_jumlah_diskonField.setDisabled(true);
		}else if(denrich_jenis_diskonField.getValue()=='Wartawan'){
			djenis_diskon = cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_dwartawan;
			denrich_jumlah_diskonField.setValue(cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_dwartawan);
			//denrich_jumlah_diskonField.setReadOnly(true);
			denrich_jumlah_diskonField.setDisabled(true);
		}else if(denrich_jenis_diskonField.getValue()=='Staff'){
			djenis_diskon = cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_dstaffdokter;
			denrich_jumlah_diskonField.setValue(cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_dstaffdokter);
			//denrich_jumlah_diskonField.setReadOnly(true);
			denrich_jumlah_diskonField.setDisabled(true);
		}else if(denrich_jenis_diskonField.getValue()=='Staf Non Dokter'){
			djenis_diskon = cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_dstaffnondokter;
			denrich_jumlah_diskonField.setValue(cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_dstaffnondokter);
			//denrich_jumlah_diskonField.setReadOnly(true);
			denrich_jumlah_diskonField.setDisabled(true);
		}else if(denrich_jenis_diskonField.getValue()=='Promo'){
			djenis_diskon = cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_dpromo;
			denrich_jumlah_diskonField.setValue(cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_dpromo);
			denrich_jumlah_diskonField.setReadOnly(true);
			denrich_jumlah_diskonField.setDisabled(true); //default
			/*untuk YESS*///denrich_jumlah_diskonField.setDisabled(false); /*eof YESS*/ 
		}
		else{
			denrich_jumlah_diskonField.setValue(0);
			//denrich_jumlah_diskonField.setReadOnly(true);
			denrich_jumlah_diskonField.setDisabled(true);
		}
		dtotal_net_field = ((100-djenis_diskon)/100) * (djumlah_beli_produk*cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_harga);
		dtotal_net_field = (dtotal_net_field>0?Math.round(dtotal_net_field):0);
		denrich_subtotal_netField.setValue(dtotal_net_field);
	});
	
	var denrich_jumlah_diskonField = new Ext.form.NumberField({
		id : 'denrich_jumlah_diskonField',
		name : 'denrich_jumlah_diskonField',
		allowDecimals: true,
		allowNegative: false,
		maxLength: 10,
		enableKeyEvents: true,
		readOnly : false,
		maskRe: /([0-9]+)$/
	});
	denrich_jumlah_diskonField.on('keyup', function(){
		var sub_total_net = ((100-denrich_jumlah_diskonField.getValue())/100)*dharga_enrichment_konversiField.getValue();
		sub_total_net = (sub_total_net>0?Math.round(sub_total_net):0);
		denrich_subtotal_netField.setValue(sub_total_net);
		/*
		if(this.getRawValue()>15 && denrich_jenis_diskonField.getValue()=='Card'){
			this.setRawValue(15);
		}else if(this.getRawValue()>20 && denrich_jenis_diskonField.getValue()=='Promo'){
			this.setRawValue(20);
		}
		*/
	});
	
	var djumlah_beli_enrichmentField = new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		maxLength: 11,
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	var dproduk_kode_produkField = new Ext.form.TextField({
		readOnly : true
	});
	
	djumlah_beli_enrichmentField.on('keyup', function(){
		var dtotal_net_field = 0;
		var sub_total = djumlah_beli_enrichmentField.getValue()*dharga_enrichment_konversiField.getValue();
		denrich_sub_totalField.setValue(sub_total);
		dtotal_net_field = sub_total * ((100-denrich_jumlah_diskonField.getValue())/100);//-denrich_jumlah_diskonField.getValue();
		dtotal_net_field = (dtotal_net_field>0?Math.round(dtotal_net_field):0);
		denrich_subtotal_netField.setValue(dtotal_net_field);
	});
	
	var dharga_enrichment_konversiField = new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		maxLength: 11,
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	
	var denrich_harga_defaultField = new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		maxLength: 11,
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	
	var denrich_sub_totalField = new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		maxLength: 11,
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	
	var denrich_subtotal_netField = new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		maxLength: 11,
		readOnly: true,
		maskRe: /([0-9]+)$/,
		enableKeyEvents : true
	});

	dpp_Field=new Ext.form.NumberField();
	subtot_dpp_Field=new Ext.form.NumberField();
	
	//declaration of detail coloumn model
	detail_enrichment_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'Left',
			header: 'ID',
			dataIndex: 'denrich_id',
            hidden: true
		},
		/*
		{
			align : 'right',
			header: '<div align="center">' + 'No' + '</div>',
			renderer: function(v, p, r, rowIndex, i, ds){return '' + (rowIndex+1)},
			width: 30
		},
		*/
		
        {
			header: '<div align="center">' + 'Cost Note' + '</div>',
			dataIndex: 'denrich_jasa',
			width: 250,
			sortable: false,
			editor: combo_jual_enrichment,
			renderer: Ext.util.Format.comboRenderer(combo_jual_enrichment)
		},
		{
			align : 'Right',
			header: '<div align="center">' + 'Price (Rp)' + '</div>',
			dataIndex: 'denrich_price',
			readOnly : true,
			width: 120,
			sortable: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_ENRICHMENT'))){ ?>
			editor: dharga_enrichment_konversiField,
			<?php } ?>
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		/*
		{
			align : 'Right',
			header: '<div align="center">' + 'Sub Total (Rp)' + '</div>',
			dataIndex: 'dproduk_subtotal',
			width: 100,
			sortable: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_ENRICHMENT'))){ ?>
			editor: denrich_sub_totalField,
			<?php } ?>
			renderer: function(v, params, record){
				return Ext.util.Format.number(record.data.denrich_jumlah*record.data.denrich_price,'0,000');
            }
		},
		*/
		{
			align : 'Right',
			header: '<div align="center">' + 'Disc (%)' + '</div>',
			dataIndex: 'denrich_disc',
			width: 100,
			sortable: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_ENRICHMENT'))){ ?>
			editor: denrich_jumlah_diskonField
			<?php } ?>
		},
		/*
		{
			align : 'Left',
			header: '<div align="center">' + 'Jns Disk' + '</div>',
			dataIndex: 'denrich_diskon_jenis',
			width: 70,
			sortable: false
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_ENRICHMENT'))){ ?>
			,
			editor: denrich_jenis_diskonField
			<?php } ?>
		},
		*/
		
		{
			align :'Right',
			header: '<div align="center">' + 'Sub Tot Net (Rp)' + '</div>',
			dataIndex: 'denrich_subtot',
			width: 150,
			sortable: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_ENRICHMENT'))){ ?>
			editor: denrich_subtotal_netField,
			<?php } ?>
			renderer: Ext.util.Format.numberRenderer('0,000')
			/*
			renderer: function(v, params, record){
				var record_dtotal_net = (record.data.denrich_jumlah*record.data.denrich_price) * ((100-record.data.denrich_disc)/100);//-record.data.denrich_disc;
				record_dtotal_net = (record_dtotal_net>0?Math.round(record_dtotal_net):0);
				return Ext.util.Format.number(record_dtotal_net,'0,000');
            }
            */
		}
		/*
		{
			align : 'Left',
			header: '<div align="center">' + 'Supplier' + '</div>',
			dataIndex: 'dproduk_supplier',
			width: 100,
			sortable: false,
			allowBlank: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_ENRICHMENT'))){ ?>
			editor: combo_enrich_supplier,
			<?php } ?>
			renderer: Ext.util.Format.comboRenderer(combo_enrich_supplier)
		}
		*/
		/*
		{
			//field ini HARUS dimunculkan, utk penghitungan harga
			align : 'Right',
			header: '<div align="center">' + 'Harga Default' + '</div>',
			dataIndex: 'produk_harga_default',
			width: 100,
			sortable: false,
			hidden: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_ENRICHMENT'))){ ?>
			editor: denrich_harga_defaultField,
			<?php } ?>
			renderer: Ext.util.Format.numberRenderer('0,000')
		}
		*/
		]
	);
	detail_enrichment_ColumnModel.defaultSortable= true;
	//eof

	//declaration of detail list editor grid
	detail_enrichmentListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_enrichmentListEditorGrid',
		el: 'fp_detail_enrichment',
		title: 'Detail Cost',
		height: 200,
		width: 1000,	//918,
		autoScroll: true,
		store: detail_enrichment_DataStore, // DataStore
		colModel: detail_enrichment_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_ENRICHMENT'))){ ?>
		plugins: [editor_detail_enrichment],
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		<?php } ?>
		frame: true,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:false}
		/*
		bbar: new Ext.PagingToolbar({
			store: detail_enrichment_DataStore,
			displayInfo: true
		})
		*/
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_ENRICHMENT'))){ ?>
		,
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			ref : '../denrich_add',
			handler: detail_enrichment_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			ref : '../denrich_delete',
			handler: detail_enrichment_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof
	
	//function of detail add
	function detail_enrichment_add(){
		//denrich_jumlah_diskonField.setReadOnly(true);
		denrich_jumlah_diskonField.setDisabled(false);
		dharga_enrichment_konversiField.setDisabled(true);
		denrich_subtotal_netField.setDisabled(true);
		denrich_sub_totalField.setDisabled(true);
		//jika detail sudah ada 1, maka referal akan mengikuti row sebelumnya
		if(detail_enrichmentListEditorGrid.selModel.getCount() == 1)
		{
			// temp ini berfungsi utk menyimpan ID dari referal yang terakhir kali diinput. Jika program di Refresh / Cancel, maka akan kembali ke kondisi semula
			var temp_produk = combo_enrich_supplier.getValue(1);
			var edit_detail_enrichment= new detail_enrichmentListEditorGrid.store.recordType({
				denrich_id	:0,
				denrich_jasa	:'',
				denrich_satuan	:'',
				denrich_jumlah	:1,
				denrich_price	:0,
				dproduk_subtotal:0,
				denrich_diskon_jenis: '',
				denrich_disc	:0,
				denrich_subtot:0,
				dproduk_supplier:temp_produk,
				produk_harga_default:0
			});
			editor_detail_enrichment.stopEditing();
			detail_enrichment_DataStore.insert(0, edit_detail_enrichment);
			detail_enrichmentListEditorGrid.getSelectionModel().selectRow(0);
			editor_detail_enrichment.startEditing(0);
		}else
		{
			var edit_detail_enrichment= new detail_enrichmentListEditorGrid.store.recordType({
				denrich_id	:0,
				denrich_jasa	:'',
				denrich_satuan	:'',
				denrich_jumlah	:1,
				denrich_price	:0,
				dproduk_subtotal:0,
				denrich_diskon_jenis: '',
				denrich_disc	:0,
				denrich_subtot:0,
				// denrich_subtot:'',
				produk_harga_default:0
			});
			editor_detail_enrichment.stopEditing();
			detail_enrichment_DataStore.insert(0, edit_detail_enrichment);
			detail_enrichmentListEditorGrid.getSelectionModel().selectRow(0);
			editor_detail_enrichment.startEditing(0);
		}
	}

	//function for insert detail
	function detail_enrichment_insert(){
		var denrich_id=[];
		var denrich_jasa=[];
		var denrich_subtot=[];
		var denrich_satuan=[];
		var denrich_jumlah=[];
		var denrich_price=[];
		// var denrich_subtot=[];
		var denrich_disc=[];
		var denrich_diskon_jenis=[];
		var dproduk_sales=[];
		var dcount = detail_enrichment_DataStore.getCount() - 1;
		
		if(detail_enrichment_DataStore.getCount()>0){
			for(i=0; i<detail_enrichment_DataStore.getCount();i++){
				if((/^\d+$/.test(detail_enrichment_DataStore.getAt(i).data.denrich_jasa))
				   && detail_enrichment_DataStore.getAt(i).data.denrich_jasa!==undefined
				   && detail_enrichment_DataStore.getAt(i).data.denrich_jasa!==''
				   && detail_enrichment_DataStore.getAt(i).data.denrich_jasa!==0){
					if(detail_enrichment_DataStore.getAt(i).data.denrich_id==undefined){
						denrich_id.push('');
					}else{
						denrich_id.push(detail_enrichment_DataStore.getAt(i).data.denrich_id);
					}
					
					denrich_jasa.push(detail_enrichment_DataStore.getAt(i).data.denrich_jasa);
					
					if(detail_enrichment_DataStore.getAt(i).data.denrich_subtot==undefined){
						denrich_subtot.push('');
					}else{
						denrich_subtot.push(detail_enrichment_DataStore.getAt(i).data.denrich_subtot);
					}
					
					if(detail_enrichment_DataStore.getAt(i).data.denrich_satuan==undefined){
						denrich_satuan.push('');
					}else{
						denrich_satuan.push(detail_enrichment_DataStore.getAt(i).data.denrich_satuan);
					}
					
					if(detail_enrichment_DataStore.getAt(i).data.denrich_jumlah==undefined){
						denrich_jumlah.push('');
					}else{
						denrich_jumlah.push(detail_enrichment_DataStore.getAt(i).data.denrich_jumlah);
					}
					
					if(detail_enrichment_DataStore.getAt(i).data.denrich_price==undefined){
						denrich_price.push('');
					}else{
						denrich_price.push(detail_enrichment_DataStore.getAt(i).data.denrich_price);
					}
					/*
					if(detail_enrichment_DataStore.getAt(i).data.denrich_subtot==undefined){
						denrich_subtot.push('');
					}else{
						denrich_subtot.push(detail_enrichment_DataStore.getAt(i).data.denrich_subtot);
					}
					*/
					
					if(detail_enrichment_DataStore.getAt(i).data.denrich_disc==undefined){
						denrich_disc.push('');
					}else{
						denrich_disc.push(detail_enrichment_DataStore.getAt(i).data.denrich_disc);
					}
					
					if(detail_enrichment_DataStore.getAt(i).data.denrich_diskon_jenis==undefined){
						denrich_diskon_jenis.push('');
					}else{
						denrich_diskon_jenis.push(detail_enrichment_DataStore.getAt(i).data.denrich_diskon_jenis);
					}
					
					if(detail_enrichment_DataStore.getAt(i).data.dproduk_sales==undefined){
						dproduk_sales.push('');
					}else{
						dproduk_sales.push(detail_enrichment_DataStore.getAt(i).data.dproduk_sales);
					}
				}
				
				if(i==dcount){
					var encoded_array_denrich_id = Ext.encode(denrich_id);
					var encoded_array_dproduk_produk = Ext.encode(denrich_jasa);
					// var encoded_array_denrich_subtot = Ext.encode(denrich_subtot);
					var encoded_array_denrich_satuan = Ext.encode(denrich_satuan);
					var encoded_array_denrich_jumlah = Ext.encode(denrich_jumlah);
					var encoded_array_denrich_price = Ext.encode(denrich_price);
					var encoded_array_denrich_subtot = Ext.encode(denrich_subtot);
					var encoded_array_denrich_disc = Ext.encode(denrich_disc);
					var encoded_array_denrich_diskon_jenis = Ext.encode(denrich_diskon_jenis);
					var encoded_array_dproduk_sales = Ext.encode(dproduk_sales);
					Ext.Ajax.request({
						waitMsg: 'Mohon tunggu...',
						url: 'index.php?c=c_master_enrichment&m=detail_detail_enrichment_insert',
						params:{
							cetak_enrichment	: cetak_enrichment,
							denrich_id	: encoded_array_denrich_id,
							dproduk_master	: eval(get_enrichment_pk()),
							denrich_jasa	: encoded_array_dproduk_produk,
							// denrich_subtot: encoded_array_denrich_subtot,
							denrich_satuan	: encoded_array_denrich_satuan,
							denrich_jumlah	: encoded_array_denrich_jumlah,
							denrich_price	: encoded_array_denrich_price,
							denrich_subtot	: encoded_array_denrich_subtot,
							denrich_disc	: encoded_array_denrich_disc,
							denrich_diskon_jenis	: encoded_array_denrich_diskon_jenis,
							dproduk_sales			: encoded_array_dproduk_sales
						},
						timeout: 60000,
						success: function(response){
							var result=eval(response.responseText);
							if(result==0){
								detail_enrichment_DataStore.load({params: {master_id:-1}});
								Ext.MessageBox.alert(enrichment_post2db+' OK','Data penjualan produk berhasil disimpan');
								enrichment_post2db="CREATE";
							}else if(result==-1){
								detail_enrichment_DataStore.load({params: {master_id:-1}});
								enrichment_post2db="CREATE";
								Ext.MessageBox.show({
								   title: 'Warning',
								   msg: 'Data penjualan produk tidak bisa disimpan',
								   buttons: Ext.MessageBox.OK,
								   animEl: 'save',
								   icon: Ext.MessageBox.WARNING
								});
							}else if(result>0){
								detail_enrichment_DataStore.load({params: {master_id:-1}});
								// enrichment_cetak(result); //di matiin dl sampe query di M di perbaikin
								cetak_enrichment=0;
								enrichment_post2db="CREATE";
							}
							enrich_btn_cancel();
						},
						failure: function(response){
							var result=response.responseText;
							Ext.MessageBox.show({
							   title: 'Error',
							   msg: 'Could not connect to the database. retry later.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'database',
							   icon: Ext.MessageBox.ERROR
							});
							enrich_btn_cancel();
						}		
					});
				}
			}
		}
	}
	//eof
	
	/* Function for Delete Confirm of detail */
	function detail_enrichment_confirm_delete(){
		if(detail_enrichmentListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', detail_enrichment_delete);
		}else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'You can\'t really delete something you haven\'t selected?',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
	//eof
	
	//function for Delete of detail
	function detail_enrichment_delete(btn){
		if(btn=='yes'){
            var selections = detail_enrichmentListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, record; record = selections[i]; i++){
                if(record.data.denrich_id==''){
                    detail_enrichment_DataStore.remove(record);
					enrich_load_dstore_enrichment();
                }else if((/^\d+$/.test(record.data.denrich_id))){
                    //Delete dari db.detail_jual_produk
                    Ext.MessageBox.show({
                        title: 'Please wait',
                        msg: 'Loading items...',
                        progressText: 'Initializing...',
                        width:300,
                        wait:true,
                        waitConfig: {interval:200},
                        closable:false
                    });
                    detail_enrichment_DataStore.remove(record);
                    Ext.Ajax.request({ 
                        waitMsg: 'Please Wait',
                        url: 'index.php?c=c_master_enrichment&m=get_action', 
                        params: { task: "DDELETE", denrich_id:  record.data.denrich_id }, 
                        success: function(response){
                            var result=eval(response.responseText);
                            switch(result){
                                case 1:  // Success : simply reload
									enrich_load_dstore_enrichment();
                                    Ext.MessageBox.hide();
                                    break;
                                default:
                                    Ext.MessageBox.hide();
                                    Ext.MessageBox.show({
                                        title: 'Warning',
                                        msg: 'Could not delete the entire selection',
                                        buttons: Ext.MessageBox.OK,
                                        animEl: 'save',
                                        icon: Ext.MessageBox.WARNING
                                    });
                                    break;
                            }
                        },
                        failure: function(response){
                            Ext.MessageBox.hide();
                            var result=response.responseText;
                            Ext.MessageBox.show({
                               title: 'Error',
                               msg: 'Could not connect to the database. retry later.',
                               buttons: Ext.MessageBox.OK,
                               animEl: 'database',
                               icon: Ext.MessageBox.ERROR
                            });	
                        }
                    });
                }
			}
		} 
	}
	//eof
	
	function update_group_carabayar_enrichment(){
		var value=enrichment_caraField.getValue();
		master_enrichment_tunaiGroup.setVisible(false);
		master_enrichment_cardGroup.setVisible(false);
		master_enrichment_cekGroup.setVisible(false);
		master_enrichment_transferGroup.setVisible(false);
		master_enrichment_kwitansiGroup.setVisible(false);
		master_enrichment_voucherGroup.setVisible(false);
		//RESET Nilai di Payment Method-1
		enrichment_tunai_nilaiField.reset();
		enrichment_tunai_nilai_cfField.reset();
		enrichment_card_nilaiField.reset();
		enrich_card_nilai_cfField.reset();
		enrich_cek_nilaiField.reset();
		enrich_cek_nilai_cfField.reset();
		enrichment_transfer_nilaiField.reset();
		enrich_transfer_nilai_cfField.reset();
		enrichment_kwitansi_nilaiField.reset();
		enrich_kwitansi_nilai_cfField.reset();
		enrich_voucher_cashbackField.reset();
		
		if(value=='card'){
			master_enrichment_cardGroup.setVisible(true);
		}else if(value=='cek/giro'){
			master_enrichment_cekGroup.setVisible(true);
		}else if(value=='transfer'){
			master_enrichment_transferGroup.setVisible(true);
		}else if(value=='kwitansi'){
			master_enrichment_kwitansiGroup.setVisible(true);
		}else if(value=='voucher'){
			master_enrichment_voucherGroup.setVisible(true);
		}else if(value=='tunai'){
			master_enrichment_tunaiGroup.setVisible(true);
		}
	}
	
	function update_group_carabayar2_enrichment(){
		var value=enrichment_cara2Field.getValue();
		master_enrichment_tunai2Group.setVisible(false);
		master_enrichment_card2Group.setVisible(false);
		master_enrichment_cek2Group.setVisible(false);
		master_enrichment_transfer2Group.setVisible(false);
		master_enrichment_kwitansi2Group.setVisible(false);
		master_enrichment_voucher2Group.setVisible(false);
		//RESET Nilai di Payment Method-1
		enrichment_tunai_nilai2Field.reset();
		enrich_tunai_nilai2_cfField.reset();
		enrichment_card_nilai2Field.reset();
		enrich_card_nilai2_cfField.reset();
		enrich_cek_nilai2Field.reset();
		enrich_cek_nilai2_cfField.reset();
		enrichment_transfer_nilai2Field.reset();
		enrich_transfer_nilai2_cfField.reset();
		enrichment_kwitansi_nilai2Field.reset();
		enrich_kwitansi_nilai2_cfField.reset();
		enrich_voucher_cashback2Field.reset();
		
		if(value=='card'){
			master_enrichment_card2Group.setVisible(true);
		}else if(value=='cek/giro'){
			master_enrichment_cek2Group.setVisible(true);
		}else if(value=='transfer'){
			master_enrichment_transfer2Group.setVisible(true);
		}else if(value=='kwitansi'){
			master_enrichment_kwitansi2Group.setVisible(true);
		}else if(value=='voucher'){
			master_enrichment_voucher2Group.setVisible(true);
		}else if(value=='tunai'){
			master_enrichment_tunai2Group.setVisible(true);
		}
	}
	
	function update_group_carabayar3_enrichment(){
		var value=enrichment_cara3Field.getValue();
		master_enrichment_tunai3Group.setVisible(false);
		master_enrichment_card3Group.setVisible(false);
		master_enrichment_cek3Group.setVisible(false);
		master_enrichment_transfer3Group.setVisible(false);
		master_enrichment_kwitansi3Group.setVisible(false);
		master_enrichment_voucher3Group.setVisible(false);
		//RESET Nilai di Payment Method-1
		enrichment_tunai_nilai3Field.reset();
		enrich_tunai_nilai3_cfField.reset();
		enrichment_card_nilai3Field.reset();
		enrich_card_nilai3_cfField.reset();
		enrich_cek_nilai3Field.reset();
		enrich_cek_nilai3_cfField.reset();
		enrichment_transfer_nilai3Field.reset();
		enrich_transfer_nilai3_cfField.reset();
		enrichment_kwitansi_nilai3Field.reset();
		enrich_kwitansi_nilai3_cfField.reset();
		enrich_voucher_cashback3Field.reset();
		
		if(value=='card'){
			master_enrichment_card3Group.setVisible(true);
		}else if(value=='cek/giro'){
			master_enrichment_cek3Group.setVisible(true);
		}else if(value=='transfer'){
			master_enrichment_transfer3Group.setVisible(true);
		}else if(value=='kwitansi'){
			master_enrichment_kwitansi3Group.setVisible(true);
		}else if(value=='voucher'){
			master_enrichment_voucher3Group.setVisible(true);
		}else if(value=='tunai'){
			master_enrichment_tunai3Group.setVisible(true);
		}
	}
	
	function enrich_load_totalbayar_updating(){
		var update_total_field=0;
		var update_hutang_field=0;
		var enrich_total_bayar_temp=enrichment_bayarField.getValue();
		var total_bayar=0;
		var kembalian = 0;

		var transfer_nilai=0;
		var transfer_nilai2=0;
		var transfer_nilai3=0;
		var kwitansi_nilai=0;
		var kwitansi_nilai2=0;
		var kwitansi_nilai3=0;
		var card_nilai=0;
		var card_nilai2=0;
		var card_nilai3=0;
		var cek_nilai=0;
		var cek_nilai2=0;
		var cek_nilai3=0;
		var voucher_nilai=0;
		var voucher_nilai2=0;
		var voucher_nilai3=0;
		
		transfer_nilai=enrichment_transfer_nilaiField.getValue();
		if(/^\d+$/.test(transfer_nilai))
			transfer_nilai=enrichment_transfer_nilaiField.getValue();
		else
			transfer_nilai=0;

		transfer_nilai2=enrichment_transfer_nilai2Field.getValue();
		if(/^\d+$/.test(transfer_nilai2))
			transfer_nilai2=enrichment_transfer_nilai2Field.getValue();
		else
			transfer_nilai2=0;
		
		transfer_nilai3=enrichment_transfer_nilai3Field.getValue();
		if(/^\d+$/.test(transfer_nilai3))
			transfer_nilai3=enrichment_transfer_nilai3Field.getValue();
		else
			transfer_nilai3=0;
		
		kwitansi_nilai=enrichment_kwitansi_nilaiField.getValue();
		if(/^\d+$/.test(kwitansi_nilai))
			kwitansi_nilai=enrichment_kwitansi_nilaiField.getValue();
		else
			kwitansi_nilai=0;
		
		kwitansi_nilai2=enrichment_kwitansi_nilai2Field.getValue();
		if(/^\d+$/.test(kwitansi_nilai2))
			kwitansi_nilai2=enrichment_kwitansi_nilai2Field.getValue();
		else
			kwitansi_nilai2=0;
		
		kwitansi_nilai3=enrichment_kwitansi_nilai3Field.getValue();
		if(/^\d+$/.test(kwitansi_nilai3))
			kwitansi_nilai3=enrichment_kwitansi_nilai3Field.getValue();
		else
			kwitansi_nilai3=0;
		
		card_nilai=enrichment_card_nilaiField.getValue();
		if(/^\d+$/.test(card_nilai))
			card_nilai=enrichment_card_nilaiField.getValue();
		else
			card_nilai=0;
		
		card_nilai2=enrichment_card_nilai2Field.getValue();
		if(/^\d+$/.test(card_nilai2))
			card_nilai2=enrichment_card_nilai2Field.getValue();
		else
			card_nilai2=0;
		
		card_nilai3=enrichment_card_nilai3Field.getValue();
		if(/^\d+$/.test(card_nilai3))
			card_nilai3=enrichment_card_nilai3Field.getValue();
		else
			card_nilai3=0;
		
		cek_nilai=enrich_cek_nilaiField.getValue();
		if(/^\d+$/.test(cek_nilai))
			cek_nilai=enrich_cek_nilaiField.getValue();
		else
			cek_nilai=0;
		
		cek_nilai2=enrich_cek_nilai2Field.getValue();
		if(/^\d+$/.test(cek_nilai2))
			cek_nilai2=enrich_cek_nilai2Field.getValue();
		else
			cek_nilai2=0;
		
		cek_nilai3=enrich_cek_nilai3Field.getValue();
		if(/^\d+$/.test(cek_nilai3))
			cek_nilai3=enrich_cek_nilai3Field.getValue();
		else
			cek_nilai3=0;
		
		voucher_nilai=enrich_voucher_cashbackField.getValue();
		if(/^\d+$/.test(voucher_nilai))
			voucher_nilai=enrich_voucher_cashbackField.getValue();
		else
			voucher_nilai=0;
		
		voucher_nilai2=enrich_voucher_cashback2Field.getValue();
		if(/^\d+$/.test(voucher_nilai2))
			voucher_nilai2=enrich_voucher_cashback2Field.getValue();
		else
			voucher_nilai2=0;
		
		voucher_nilai3=enrich_voucher_cashback3Field.getValue();
		if(/^\d+$/.test(voucher_nilai3))
			voucher_nilai3=enrich_voucher_cashback3Field.getValue();
		else
			voucher_nilai3=0;

		tunai_nilai=enrichment_tunai_nilaiField.getValue();
		if(/^\d+$/.test(tunai_nilai))
			tunai_nilai=enrichment_tunai_nilaiField.getValue();
		else
			tunai_nilai=0;

		tunai_nilai2=enrichment_tunai_nilai2Field.getValue();
		if(/^\d+$/.test(tunai_nilai2))
			tunai_nilai2=enrichment_tunai_nilai2Field.getValue();
		else
			tunai_nilai2=0;

		tunai_nilai3=enrichment_tunai_nilai3Field.getValue();
		if(/^\d+$/.test(tunai_nilai3))
			tunai_nilai3=enrichment_tunai_nilai3Field.getValue();
		else
			tunai_nilai3=0;

		total_bayar=transfer_nilai+transfer_nilai2+transfer_nilai3+kwitansi_nilai+kwitansi_nilai2+kwitansi_nilai3+card_nilai+card_nilai2+card_nilai3+cek_nilai+cek_nilai2+cek_nilai3+voucher_nilai+voucher_nilai2+voucher_nilai3+tunai_nilai+tunai_nilai2+tunai_nilai3;
		
		update_total_field=enrichment_subTotalField.getValue()*((100-enrich_diskonField.getValue())/100)-enrich_cashbackField.getValue();
		enrichment_totalField.setValue(update_total_field);
		enrichment_total_cfField.setValue(CurrencyFormatted(update_total_field));
		enrichment_TotalLabel.setValue(CurrencyFormatted(update_total_field));

		enrichment_bayarField.setValue(total_bayar);
		enrichment_bayar_cfField.setValue(CurrencyFormatted(total_bayar));
		enrichment_TotalBayarLabel.setValue(CurrencyFormatted(total_bayar));
		
		update_hutang_field=update_total_field-total_bayar;
		enrich_hutangField.setValue(update_hutang_field);
		update_hutang_field=(update_hutang_field>0?Math.round(update_hutang_field):0);
		enrich_hutang_cfField.setValue(CurrencyFormatted(update_hutang_field));
		enrichment_sisabayarLabel.setValue(CurrencyFormatted(update_hutang_field));

		enrich_diskonField.setValue(enrich_diskonField.getValue());
		enrich_cashbackField.setValue(enrich_cashbackField.getValue());
		enrich_cashback_cfField.setValue(CurrencyFormatted(enrich_cashbackField.getValue()));

		kembalian = total_bayar - update_total_field;
		enrichment_kembalianField.setValue(kembalian);
		
		if(total_bayar>update_total_field){
			//enrichment_pesanLabel.setText("Kelebihan Jumlah Bayar");
			enrichment_kembalianLabel.setValue(CurrencyFormatted(kembalian));
			enrichment_kembalianField.setValue(kembalian);
		}else if(total_bayar<update_total_field || total_bayar==update_total_field){
			enrichment_pesanLabel.setText("");
			enrichment_kembalianLabel.setValue(0);
		}
		if(total_bayar==update_total_field){
			enrich_lunasLabel.setText("LUNAS");
			enrichment_kembalianLabel.setValue(0);
		}else if(total_bayar!==update_total_field){
			enrich_lunasLabel.setText("");
		}
	}
	
	function enrich_load_dstore_enrichment(){
		/*
		 * yang terlibat adalah:
		 * 1. Grid Detail Pembelian
		 * 2. Sub Total Biaya
		 * 3. Disk Tambahan (%)
		 * 4. Voucher (Rp)
		 * 5. Total Biaya
		 * 6. Total Bayar
		 * 7. Total Hutang
		*/

		var disk_tambahan_field = enrich_diskonField.getValue();
		if(disk_tambahan_field==''){
			disk_tambahan_field = 0;
		}
		
		var voucher_rp_field = enrich_cashbackField.getValue();
		if(voucher_rp_field==''){
			voucher_rp_field = 0;
		}
		
		var total_bayar_field = enrichment_bayarField.getValue();
		var jumlah_item = 0;
		var temp_sub_total_field = 0;
		var total_biaya_field = 0;
		var total_hutang_field = 0;
		
		for(i=0;i<detail_enrichment_DataStore.getCount();i++){
			jumlah_item+=detail_enrichment_DataStore.getAt(i).data.denrich_jumlah;
			temp_sub_total_field+=detail_enrichment_DataStore.getAt(i).data.denrich_jumlah * detail_enrichment_DataStore.getAt(i).data.denrich_price * ((100 - detail_enrichment_DataStore.getAt(i).data.denrich_disc)/100);
			//sub_total_field+=detail_enrichment_DataStore.getAt(i).data.denrich_jumlah * detail_enrichment_DataStore.getAt(i).data.denrich_price * ((100 - detail_enrichment_DataStore.getAt(i).data.denrich_disc)/100);
		}

		enrich_jumlahField.setValue(jumlah_item);
		enrich_jumlahLabel.setValue(jumlah_item);
		enrichment_subTotalField.setValue(temp_sub_total_field);
		enrichment_subTotal_cfField.setValue(CurrencyFormatted(temp_sub_total_field));
		enrichment_subTotalLabel.setValue(CurrencyFormatted(temp_sub_total_field));
		
		total_biaya_field = temp_sub_total_field * ((100 - disk_tambahan_field)/100) - voucher_rp_field;
		total_biaya_field = (total_biaya_field>0?Math.round(total_biaya_field):0);
		enrichment_totalField.setValue(total_biaya_field);
		enrichment_total_cfField.setValue(CurrencyFormatted(total_biaya_field));
		enrichment_TotalLabel.setValue(CurrencyFormatted(total_biaya_field));
		
		total_hutang_field = total_biaya_field - total_bayar_field;
		enrich_hutang_cfField.setValue(CurrencyFormatted(total_hutang_field));
		total_hutang_field=(total_hutang_field>0?Math.round(total_hutang_field):0);
		enrichment_sisabayarLabel.setValue(CurrencyFormatted(total_hutang_field));
		console.clear(); // mengclear console, agar tidak membingungkan user ketika terjadi error pada firebug yg disebabkan "enter" keypress saat input detail
	}
	
	function enrich_load_totalbiaya(){
		/*
		 * Field-field yang terlibat adalah:
		 * 1. Sub Total Biaya
		 * 2. Disk Tambahan (%)
		 * 3. Voucher (Rp)
		 * 4. Total Biaya
		 * 5. Total Bayar
		 * 6. Total Hutang
		 * 7. Notifikasi Kelebihan Bayar
		*/
		var sub_total_biaya_field = enrichment_subTotalField.getValue();
		var disk_tambahan_field = enrich_diskonField.getValue();
		var voucher_rp_field = enrich_cashbackField.getValue();
		var total_bayar_field = enrichment_bayarField.getValue();
		
		if(disk_tambahan_field==''){
			disk_tambahan_field = 0;
		}
		
		if(voucher_rp_field==''){
			voucher_rp_field = 0;
		}
		
		var total_biaya_field = 0;
		var total_hutang_field = 0;
		
		total_biaya_field += sub_total_biaya_field * ((100 - disk_tambahan_field)/100) - voucher_rp_field;
		total_biaya_field = (total_biaya_field>0?Math.round(total_biaya_field):0);
		enrichment_totalField.setValue(total_biaya_field);
		enrichment_total_cfField.setValue(CurrencyFormatted(total_biaya_field));
		enrichment_TotalLabel.setValue(CurrencyFormatted(total_biaya_field));
		
		total_hutang_field = total_biaya_field - total_bayar_field;
		enrich_hutangField.setValue(total_hutang_field);
		enrich_hutang_cfField.setValue(CurrencyFormatted(total_hutang_field));
		total_hutang_field=(total_hutang_field>0?Math.round(total_hutang_field):0);
		enrichment_sisabayarLabel.setValue(CurrencyFormatted(total_hutang_field));

	}
	
	function enrich_load_totalbayar(){
		/*
		 * Field-field yang terlibat adalah:
		 * 1. Payment Method
		 * 2. Total Biaya
		 * 3. Total Bayar
		 * 4. Total Hutang
		*/
		var total_hutang_field = 0;
		var total_bayar_field = 0;
		var total_biaya_field = enrichment_totalField.getValue();
		var transfer_nilai=0;
		var transfer_nilai2=0;
		var transfer_nilai3=0;
		var kwitansi_nilai=0;
		var kwitansi_nilai2=0;
		var kwitansi_nilai3=0;
		var card_nilai=0;
		var card_nilai2=0;
		var card_nilai3=0;
		var cek_nilai=0;
		var cek_nilai2=0;
		var cek_nilai3=0;
		var voucher_nilai=0;
		var voucher_nilai2=0;
		var voucher_nilai3=0;

		var kembalian = 0;
		
		transfer_nilai=enrichment_transfer_nilaiField.getValue();
		if(/^\d+$/.test(transfer_nilai))
			transfer_nilai=enrichment_transfer_nilaiField.getValue();
		else
			transfer_nilai=0;
		
		transfer_nilai2=enrichment_transfer_nilai2Field.getValue();
		if(/^\d+$/.test(transfer_nilai2))
			transfer_nilai2=enrichment_transfer_nilai2Field.getValue();
		else
			transfer_nilai2=0;
		
		transfer_nilai3=enrichment_transfer_nilai3Field.getValue();
		if(/^\d+$/.test(transfer_nilai3))
			transfer_nilai3=enrichment_transfer_nilai3Field.getValue();
		else
			transfer_nilai3=0;
		
		kwitansi_nilai=enrichment_kwitansi_nilaiField.getValue();
		if(/^\d+$/.test(kwitansi_nilai))
			kwitansi_nilai=enrichment_kwitansi_nilaiField.getValue();
		else
			kwitansi_nilai=0;
		
		kwitansi_nilai2=enrichment_kwitansi_nilai2Field.getValue();
		if(/^\d+$/.test(kwitansi_nilai2))
			kwitansi_nilai2=enrichment_kwitansi_nilai2Field.getValue();
		else
			kwitansi_nilai2=0;
		
		kwitansi_nilai3=enrichment_kwitansi_nilai3Field.getValue();
		if(/^\d+$/.test(kwitansi_nilai3))
			kwitansi_nilai3=enrichment_kwitansi_nilai3Field.getValue();
		else
			kwitansi_nilai3=0;
		
		card_nilai=enrichment_card_nilaiField.getValue();
		if(/^\d+$/.test(card_nilai))
			card_nilai=enrichment_card_nilaiField.getValue();
		else
			card_nilai=0;
		
		card_nilai2=enrichment_card_nilai2Field.getValue();
		if(/^\d+$/.test(card_nilai2))
			card_nilai2=enrichment_card_nilai2Field.getValue();
		else
			card_nilai2=0;
		
		card_nilai3=enrichment_card_nilai3Field.getValue();
		if(/^\d+$/.test(card_nilai3))
			card_nilai3=enrichment_card_nilai3Field.getValue();
		else
			card_nilai3=0;
		
		cek_nilai=enrich_cek_nilaiField.getValue();
		if(/^\d+$/.test(cek_nilai))
			cek_nilai=enrich_cek_nilaiField.getValue();
		else
			cek_nilai=0;
		
		cek_nilai2=enrich_cek_nilai2Field.getValue();
		if(/^\d+$/.test(cek_nilai2))
			cek_nilai2=enrich_cek_nilai2Field.getValue();
		else
			cek_nilai2=0;
		
		cek_nilai3=enrich_cek_nilai3Field.getValue();
		if(/^\d+$/.test(cek_nilai3))
			cek_nilai3=enrich_cek_nilai3Field.getValue();
		else
			cek_nilai3=0;
		
		voucher_nilai=enrich_voucher_cashbackField.getValue();
		if(/^\d+$/.test(voucher_nilai))
			voucher_nilai=enrich_voucher_cashbackField.getValue();
		else
			voucher_nilai=0;
		
		voucher_nilai2=enrich_voucher_cashback2Field.getValue();
		if(/^\d+$/.test(voucher_nilai2))
			voucher_nilai2=enrich_voucher_cashback2Field.getValue();
		else
			voucher_nilai2=0;
		
		voucher_nilai3=enrich_voucher_cashback3Field.getValue();
		if(/^\d+$/.test(voucher_nilai3))
			voucher_nilai3=enrich_voucher_cashback3Field.getValue();
		else
			voucher_nilai3=0;

		tunai_nilai=enrichment_tunai_nilaiField.getValue();
		if(/^\d+$/.test(tunai_nilai))
			tunai_nilai=enrichment_tunai_nilaiField.getValue();
		else
			tunai_nilai=0;

		tunai_nilai2=enrichment_tunai_nilai2Field.getValue();
		if(/^\d+$/.test(tunai_nilai2))
			tunai_nilai2=enrichment_tunai_nilai2Field.getValue();
		else
			tunai_nilai2=0;

		tunai_nilai3=enrichment_tunai_nilai3Field.getValue();
		if(/^\d+$/.test(tunai_nilai3))
			tunai_nilai3=enrichment_tunai_nilai3Field.getValue();
		else
			tunai_nilai3=0;
			
		total_bayar_field=transfer_nilai+transfer_nilai2+transfer_nilai3+kwitansi_nilai+kwitansi_nilai2+kwitansi_nilai3+card_nilai+card_nilai2+card_nilai3+cek_nilai+cek_nilai2+cek_nilai3+voucher_nilai+voucher_nilai2+voucher_nilai3+tunai_nilai+tunai_nilai2+tunai_nilai3;
		total_bayar_field=(total_bayar_field>0?Math.round(total_bayar_field):0);
		enrichment_bayarField.setValue(total_bayar_field);
		enrichment_bayar_cfField.setValue(CurrencyFormatted(total_bayar_field));
		enrichment_TotalBayarLabel.setValue(CurrencyFormatted(total_bayar_field));

		total_hutang_field=total_biaya_field-total_bayar_field;
		total_hutang_field=(total_hutang_field>0?Math.round(total_hutang_field):0);
		enrich_hutangField.setValue(total_hutang_field);
		enrich_hutang_cfField.setValue(CurrencyFormatted(total_hutang_field));
		enrichment_sisabayarLabel.setValue(CurrencyFormatted(total_hutang_field));

		kembalian = total_bayar_field - total_biaya_field;
		
		if(total_bayar_field>total_biaya_field){
			// enrichment_pesanLabel.setText("Kelebihan Jumlah Bayar");
			enrichment_kembalianLabel.setValue(CurrencyFormatted(kembalian));
			enrichment_kembalianField.setValue(kembalian);
		}else if(total_bayar_field<total_biaya_field || total_bayar_field==total_biaya_field){
			enrichment_pesanLabel.setText("");
			enrichment_kembalianLabel.setValue(0);
		}
		if(total_bayar_field==total_biaya_field){
			enrich_lunasLabel.setText("LUNAS");
			enrichment_kembalianLabel.setValue(0);
		}else if(total_bayar_field!==total_biaya_field){
			enrich_lunasLabel.setText("");
		}
	}
	
	//event on update of detail data store
	detail_enrichment_DataStore.on("update",enrich_load_dstore_enrichment);
	enrich_diskonField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
		enrich_load_totalbiaya();
	});
	enrich_cashback_cfField.on("keyup",function(){
		var cf_value = enrich_cashback_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		enrich_cashbackField.setValue(cf_tonumber);
		enrich_load_totalbiaya();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	//kwitansi
	enrich_kwitansi_nilai_cfField.on("keyup",function(){
		var cf_value = enrich_kwitansi_nilai_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		if(cf_tonumber>enrich_kwitansi_sisaField.getValue()){
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Maaf, Jumlah yang Anda ambil melebihi dari Sisa Kuitansi.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
			cf_tonumber = enrich_kwitansi_sisaField.getValue();
			enrichment_kwitansi_nilaiField.setValue(cf_tonumber);
			enrich_load_totalbayar();
			
			var number_tocf = CurrencyFormatted(cf_tonumber);
			this.setRawValue(number_tocf);
		}else{
			enrichment_kwitansi_nilaiField.setValue(cf_tonumber);
			enrich_load_totalbayar();
			
			var number_tocf = CurrencyFormatted(cf_value);
			this.setRawValue(number_tocf);
		}
	});
	enrich_kwitansi_nilai2_cfField.on("keyup",function(){
		var cf_value = enrich_kwitansi_nilai2_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		if(cf_tonumber>enrich_kwitansi_sisa2Field.getValue()){
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Maaf, Jumlah yang Anda ambil melebihi dari Sisa Kuitansi.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
			cf_tonumber = enrich_kwitansi_sisa2Field.getValue();
			enrichment_kwitansi_nilai2Field.setValue(cf_tonumber);
			enrich_load_totalbayar();
			
			var number_tocf = CurrencyFormatted(cf_tonumber);
			this.setRawValue(number_tocf);
		}else{
			enrichment_kwitansi_nilai2Field.setValue(cf_tonumber);
			enrich_load_totalbayar();
			
			var number_tocf = CurrencyFormatted(cf_value);
			this.setRawValue(number_tocf);
		}
	});
	enrich_kwitansi_nilai3_cfField.on("keyup",function(){
		var cf_value = enrich_kwitansi_nilai3_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		if(cf_tonumber>enrich_kwitansi_sisa3Field.getValue()){
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Maaf, Jumlah yang Anda ambil melebihi dari Sisa Kuitansi.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
			cf_tonumber = enrich_kwitansi_sisa3Field.getValue();
			enrichment_kwitansi_nilai3Field.setValue(cf_tonumber);
			enrich_load_totalbayar();
			
			var number_tocf = CurrencyFormatted(cf_tonumber);
			this.setRawValue(number_tocf);
		}else{
			enrichment_kwitansi_nilai3Field.setValue(cf_tonumber);
			enrich_load_totalbayar();
			
			var number_tocf = CurrencyFormatted(cf_value);
			this.setRawValue(number_tocf);
		}
	});
	//card
	enrich_card_nilai_cfField.on("keyup",function(){
		var cf_value = enrich_card_nilai_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		enrichment_card_nilaiField.setValue(cf_tonumber);
		enrich_load_totalbayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	enrich_card_nilai2_cfField.on("keyup",function(){
		var cf_value = enrich_card_nilai2_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		enrichment_card_nilai2Field.setValue(cf_tonumber);
		enrich_load_totalbayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	enrich_card_nilai3_cfField.on("keyup",function(){
		var cf_value = enrich_card_nilai3_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		enrichment_card_nilai3Field.setValue(cf_tonumber);
		enrich_load_totalbayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	//cek/giro
	enrich_cek_nilai_cfField.on("keyup",function(){
		var cf_value = enrich_cek_nilai_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		enrich_cek_nilaiField.setValue(cf_tonumber);
		enrich_load_totalbayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	enrich_cek_nilai2_cfField.on("keyup",function(){
		var cf_value = enrich_cek_nilai2_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		enrich_cek_nilai2Field.setValue(cf_tonumber);
		enrich_load_totalbayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	enrich_cek_nilai3_cfField.on("keyup",function(){
		var cf_value = enrich_cek_nilai3_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		enrich_cek_nilai3Field.setValue(cf_tonumber);
		enrich_load_totalbayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	//transfer
	enrich_transfer_nilai_cfField.on("keyup",function(){
		var cf_value = enrich_transfer_nilai_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		enrichment_transfer_nilaiField.setValue(cf_tonumber);
		enrich_load_totalbayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	enrich_transfer_nilai2_cfField.on("keyup",function(){
		var cf_value = enrich_transfer_nilai2_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		enrichment_transfer_nilai2Field.setValue(cf_tonumber);
		enrich_load_totalbayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	enrich_transfer_nilai3_cfField.on("keyup",function(){
		var cf_value = enrich_transfer_nilai3_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		enrichment_transfer_nilai3Field.setValue(cf_tonumber);
		enrich_load_totalbayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	//voucher
	enrich_voucher_cashbackField.on("keyup",function(){if(enrichment_post2db=="CREATE"){enrich_load_totalbayar();}else if(enrichment_post2db=="UPDATE"){enrich_load_totalbayar_updating();}});
	enrich_voucher_cashback2Field.on("keyup",function(){if(enrichment_post2db=="CREATE"){enrich_load_totalbayar();}else if(enrichment_post2db=="UPDATE"){enrich_load_totalbayar_updating();}});
	enrich_voucher_cashback3Field.on("keyup",function(){if(enrichment_post2db=="CREATE"){enrich_load_totalbayar();}else if(enrichment_post2db=="UPDATE"){enrich_load_totalbayar_updating();}});
	//tunai
	enrichment_tunai_nilai_cfField.on("keyup",function(){
		var cf_value = enrichment_tunai_nilai_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		enrichment_tunai_nilaiField.setValue(cf_tonumber);
		enrich_load_totalbayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	enrich_tunai_nilai2_cfField.on("keyup",function(){
		var cf_value = enrich_tunai_nilai2_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		enrichment_tunai_nilai2Field.setValue(cf_tonumber);
		enrich_load_totalbayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	enrich_tunai_nilai3_cfField.on("keyup",function(){
		var cf_value = enrich_tunai_nilai3_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		enrichment_tunai_nilai3Field.setValue(cf_tonumber);
		enrich_load_totalbayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	
	enrich_voucher_cashback_cfField.on("keyup",function(){
		var cf_value = enrich_voucher_cashback_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		enrich_voucher_cashbackField.setValue(cf_tonumber);
		enrich_load_totalbayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	enrich_voucher_cashback2_cfField.on("keyup",function(){
		var cf_value = enrich_voucher_cashback2_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		enrich_voucher_cashback2Field.setValue(cf_tonumber);
		enrich_load_totalbayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	enrich_voucher_cashback3_cfField.on("keyup",function(){
		var cf_value = enrich_voucher_cashback3_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		enrich_voucher_cashback3Field.setValue(cf_tonumber);
		enrich_load_totalbayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	
	//enrichment_caraField.on("select",update_group_carabayar_enrichment);
	//enrichment_cara2Field.on("select",update_group_carabayar2_enrichment);
	//enrichment_cara3Field.on("select",update_group_carabayar3_enrichment);
	/*Sistem baru, dimana setiap kali user mengganti cara bayar, maka akan meng-reset ulang total perhitungan, hal ini dilakukan agar tidak terjadi bug(cara bayar sudah diisi nominal,lalu diganti ke cara bayar lain, lalu sudah mengurangi total biaya dan mengisi total bayar, sehingga ketika di save / print maka total bayar / total biaya sudah terakumulasi, namun cara bayarnya masih 0 (ditabel jual2 masih 0). Coba nyalakan comment diatas utk membuktikan bug tersebut */
	enrichment_caraField.on("select",function(){
		update_group_carabayar_enrichment();
		enrich_load_totalbiaya();
		enrich_load_totalbayar();
		enrich_load_dstore_enrichment();
	});
	enrichment_cara2Field.on("select",function(){
		update_group_carabayar2_enrichment();
		enrich_load_totalbiaya();
		enrich_load_totalbayar();
		enrich_load_dstore_enrichment();
	});
	enrichment_cara3Field.on("select",function(){
		update_group_carabayar3_enrichment();
		enrich_load_totalbiaya();
		enrich_load_totalbayar();
		enrich_load_dstore_enrichment();
	});
	
	enrich_karyawanField.on("select",function(){
		var karyawan_id=enrich_karyawanField.getValue();		
		if(karyawan_id!==0){
			enrich_karyawanDataStore.load({
					params : { karyawan_id: karyawan_id},
					callback: function(opts, success, response)  {
						 if (success) {
							if(enrich_karyawanDataStore.getCount()){
								enrich_karyawan_record=enrich_karyawanDataStore.getAt(0).data;
								enrich_nikkaryawanField.setValue(enrich_karyawan_record.karyawan_no);
							}else{
								enrich_cust_nomemberField.setValue("");
							}
						}
					}
			}); }
	});
	
	enrichment_studentField.on("select",function(){
		var cust_id=enrichment_studentField.getValue();
		if(cust_id!==0){
			enrich_memberDataStore.load({
					params : { member_cust: cust_id},
					callback: function(opts, success, response)  {
						 if (success) {
							if(enrich_memberDataStore.getCount()){
								enrich_member_record=enrich_memberDataStore.getAt(0).data;
								enrich_cust_nomemberField.setValue(enrich_member_record.cust_kategori);
								enrich_valid_memberField.setValue(enrich_member_record.member_valid);
								enrich_cust_ultahField.setValue(enrich_member_record.cust_tgllahir);
								enrich_cust_priorityField.setValue(enrich_member_record.cust_priority_star);
								if (cust_id== '9'){
									enrich_karyawanField.setDisabled(false);
									enrich_cust_priorityLabel.setText("");
								}
								else if (cust_id !== '9' && enrich_cust_priorityField.getValue()=='*') {
									enrich_cust_priorityLabel.setText("*");
									enrich_karyawanField.setDisabled(true);
								}
								else {
									enrich_karyawanField.setDisabled(true);
									enrich_karyawanField.setValue(null);
									enrich_nikkaryawanField.setValue(null);
									enrich_cust_priorityLabel.setText("");
								}
							}else{
								enrich_cust_nomemberField.setValue("");
								enrich_valid_memberField.setValue("");
								enrich_cust_ultahField.setValue("");
								enrich_cust_priorityLabel.setText("");
							}
						}
					}
			}); 
		}
		
		cbo_cust=cbo_student_enrichment_DataStore.findExact('cust_id',enrichment_studentField.getValue(),0);
		if(cbo_cust>-1){
			//cbo_kwitansi_enrichment_DataStore.load({params: {kwitansi_cust: cbo_student_enrichment_DataStore.getAt(cbo_cust).data.cust_id}});
			enrich_cek_namaField.setValue(cbo_student_enrichment_DataStore.getAt(cbo_cust).data.cust_nama);
			enrich_cek_nama2Field.setValue(cbo_student_enrichment_DataStore.getAt(cbo_cust).data.cust_nama);
			enrich_cek_nama3Field.setValue(cbo_student_enrichment_DataStore.getAt(cbo_cust).data.cust_nama);
			enrichment_transfer_namaField.setValue(cbo_student_enrichment_DataStore.getAt(cbo_cust).data.cust_nama);
			enrichment_transfer_nama2Field.setValue(cbo_student_enrichment_DataStore.getAt(cbo_cust).data.cust_nama);
			enrichment_transfer_nama3Field.setValue(cbo_student_enrichment_DataStore.getAt(cbo_cust).data.cust_nama);
		}
		
		
	});
	
	function show_windowGrid(){
		master_enrichment_DataStore.load({
			params: {start: 0, limit: enrich_pageS},
			callback: function(opts, success, response){
				if(success){
					master_enrichment_createWindow.show();
				}
			}
		});	// load DataStore
	}
	
	/* Function for retrieve create Window Panel*/ 
	master_enrichment_createForm = new Ext.FormPanel({
		//title: 'Kasir',
		labelAlign: 'left',
		el: 'form_enrichment_addEdit',
		bodyStyle:'padding:5px',
		//autoHeight:true,
		height: 675,
		width: 	850,	//940,
		frame: true,
		items: [master_enrichment_masterGroup /*,enrich_groomingGroup*/ , detail_enrichmentListEditorGrid,master_enrichment_bayarGroup]
		,
		buttons: [
			{
				text: '<span style="font-weight:bold">List Enrichment</span>',
				handler: show_windowGrid
			},
			/*
			{
				text: 'Print Only2',
				ref: '../PrintOnlyButton2',
				handler: print_only2
			},
			*/
			
			{
				text: 'Print Only',
				ref: '../PrintOnlyButton',
				handler: print_only
			},
			
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_ENRICHMENT'))){ ?>
			
			/*
			{
				text: 'Save and Print 2',
				ref: '../enrich_savePrint2',
				handler: save_andPrint2
			},
			*/
			{
				text: 'Save and Print',
				ref: '../enrich_savePrint',
				handler: save_andPrint
			},
			{
				text: 'Save',
				handler: save_button
			},
			{
				text: 'Cancel',
				handler: enrich_btn_cancel
			}
			<?php } ?>
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	master_enrichment_createWindow= new Ext.Window({
		id: 'master_enrichment_createWindow',
		title: 'List Enrichment Registration',
		closable:true,
		closeAction: 'hide',
		width: 820,	//810,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_master_enrichment_create',
		items: master_enrichmentListEditorGrid
	});
	/* End Window */
	
	/* Function for action list search */
	function master_enrichment_list_search(){
		var enrich_no_search=null;
		var jproduk_cust_search=null;
		var enrich_tanggal_search_date="";
		var enrich_tanggal_akhir_search_date="";
		var jproduk_diskon_search=null;
		var enrich_cara_search=null;
		var enrich_note_search=null;

		if(enrichment_noSearchField.getValue()!==null){enrich_no_search=enrichment_noSearchField.getValue();}
		if(enrichment_custSearchField.getValue()!==null){jproduk_cust_search=enrichment_custSearchField.getValue();}
		if(enrichment_tanggal_awalSearchField.getValue()!==""){enrich_tanggal_search_date=enrichment_tanggal_awalSearchField.getValue().format('Y-m-d');}
		if(enrichment_tanggal_akhirSearchField.getValue()!==""){enrich_tanggal_akhir_search_date=enrichment_tanggal_akhirSearchField.getValue().format('Y-m-d');}
		if(enrich_diskonSearchField.getValue()!==null){jproduk_diskon_search=enrich_diskonSearchField.getValue();}
		if(enrichment_caraSearchField.getValue()!==null){enrich_cara_search=enrichment_caraSearchField.getValue();}
		if(enrichment_keteranganSearchField.getValue()!==null){enrich_note_search=enrichment_keteranganSearchField.getValue();}
		if(enrichment_stat_dokSearchField.getValue()!==null){enrich_stat_dok_search=enrichment_stat_dokSearchField.getValue();}
		if(enrich_stat_timeSearchField.getValue()!==null){jproduk_shift_search=enrich_stat_timeSearchField.getValue();}
		// change the store parameters
		master_enrichment_DataStore.baseParams = {
			task  				: 'SEARCH',
			start  				: 0,
			limit  				: enrich_pageS,
			enrich_no			:	enrich_no_search, 
			enrich_student		:	jproduk_cust_search, 
			enrich_tanggal		:	enrich_tanggal_search_date, 
			enrich_tanggal_akhir:	enrich_tanggal_akhir_search_date, 
			jproduk_diskon		:	jproduk_diskon_search, 
			enrich_cara			:	enrich_cara_search, 
			enrich_note			:	enrich_note_search, 
			enrich_stat_dok		:	enrich_stat_dok_search,
			jproduk_shift		:	jproduk_shift_search
		};
		master_enrichment_DataStore.reload({params: {start: 0, limit: enrich_pageS}});
	}
		
	/* Function for reset search result */
	function master_enrichment_reset_search(){
		master_enrichment_DataStore.baseParams = { task: 'LIST' };
		master_enrichment_DataStore.reload({params: {start: 0, limit: enrich_pageS}});
	};
	/* End of Fuction */

	function master_jual_produk_reset_SearchForm(){
		enrichment_noSearchField.reset();
		enrichment_custSearchField.reset();
		enrichment_tanggal_awalSearchField.reset();
		enrichment_tanggal_akhirSearchField.reset();
		enrichment_tanggal_akhirSearchField.setValue(today);
		enrich_diskonSearchField.reset();
		enrichment_caraSearchField.reset();
		enrichment_keteranganSearchField.reset();
		enrichment_stat_dokSearchField.reset();
		enrich_stat_timeSearchField.reset();
		
	}
	
	/* Field for search */
	/* Identify  enrich_id Search Field */
	enrichment_idSearchField= new Ext.form.NumberField({
		id: 'enrichment_idSearchField',
		fieldLabel: 'Jproduk Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  enrich_no Search Field */
	enrichment_noSearchField= new Ext.form.TextField({
		id: 'enrichment_noSearchField',
		fieldLabel: 'No. Code',
		maxLength: 30
	});
	/* Identify  enrich_student Search Field */
	enrichment_custSearchField= new Ext.form.ComboBox({
		id: 'enrichment_custSearchField',
		fieldLabel: 'Student',
		store: cbo_student_enrichment_DataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
       	pageSize:10,
        hideTrigger:false,
        tpl: student_enrichment_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '80%'
		// hidden: true
	});
	/* Identify  enrich_tanggal Search Field */
	enrichment_tanggal_awalSearchField= new Ext.form.DateField({
		id: 'enrichment_tanggal_awalSearchField',
		fieldLabel: 'Date',
		format : 'd-m-Y',
		minValue: MIN_CREATE_DATE
	});
	enrichment_tanggal_akhirSearchField= new Ext.form.DateField({
		id: 'enrichment_tanggal_akhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y',
		minValue: MIN_CREATE_DATE
	});
	/* Identify  jproduk_diskon Search Field */
	enrich_diskonSearchField= new Ext.form.NumberField({
		id: 'enrich_diskonSearchField',
		fieldLabel: 'Diskon',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  enrich_cara Search Field */
	enrichment_caraSearchField= new Ext.form.ComboBox({
		id: 'enrichment_caraSearchField',
		fieldLabel: 'Payment Method',
		store:new Ext.data.SimpleStore({
			fields:['value', 'enrich_cara'],
			data:[['tunai','Cash'],['kwitansi','Kwitansi'],['card','Kartu Kredit'],['cek/giro','Cek/Giro'],['transfer','Transfer']]
		}),
		mode: 'local',
		displayField: 'enrich_cara',
		valueField: 'value',
		width: 96,
		triggerAction: 'all',
		hidden: true
	});
	/* Identify  enrich_note Search Field */
	enrichment_keteranganSearchField= new Ext.form.TextArea({
		id: 'enrichment_keteranganSearchField',
		fieldLabel: 'Notes',
		maxLength: 250,
		anchor: '95%'	
	});
	enrichment_stat_dokSearchField= new Ext.form.ComboBox({
		id: 'enrichment_stat_dokSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['value', 'enrich_stat_dok'],
			data:[['Terbuka','Terbuka'], ['Tertutup','Tertutup'], ['Batal','Batal']]
		}),
		mode: 'local',
		displayField: 'enrich_stat_dok',
		valueField: 'value',
		width: 96,
		triggerAction: 'all'
	});
	
	enrich_stat_timeSearchField= new Ext.form.ComboBox({
		id: 'enrich_stat_timeSearchField',
		fieldLabel: 'Shift',
		store:new Ext.data.SimpleStore({
			fields:['value_shift', 'display_shift'],
			data:[['Pagi','Pagi'], ['Malam','Malam']]
		}),
		mode: 'local',
		displayField: 'display_shift',
		valueField: 'value_shift',
		width: 96,
		triggerAction: 'all'
	});
	

	/* Function for retrieve search Form Panel */
	master_enrichment_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 500,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [enrichment_noSearchField, enrichment_custSearchField, 
					{
						layout:'column',
						border:false,
						items:[
						{
							columnWidth:0.45,
							layout: 'form',
							border:false,
							defaultType: 'datefield',
							items: [						
								enrichment_tanggal_awalSearchField
							]
						},
						{
							columnWidth:0.30,
							layout: 'form',
							border:false,
							labelWidth:30,
							defaultType: 'datefield',
							items: [						
								enrichment_tanggal_akhirSearchField
							]
						}						
				        ]
					},
				enrichment_caraSearchField, 
				enrichment_keteranganSearchField,
				enrichment_stat_dokSearchField
				/*,
				enrich_stat_timeSearchField*/
				] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: master_enrichment_list_search
			},{
				text: 'Close',
				handler: function(){
					master_enrichment_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	master_enrichment_searchWindow = new Ext.Window({
		title: 'Pencarian Penjualan Produk',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_master_enrichment_search',
		items: master_enrichment_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!master_enrichment_searchWindow.isVisible()){
			master_jual_produk_reset_SearchForm();
			master_enrichment_searchWindow.show();
		} else {
			master_enrichment_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function master_enrichment_print(){
		var searchquery = "";
		var enrich_no_print=null;
		var jproduk_cust_print=null;
		var enrich_tanggal_print_date="";
		var enrich_tanggal_akhir_print_date="";
		var jproduk_diskon_print=null;
		var enrich_cara_print=null;
		var enrich_note_print=null;
		var win;              
		// check if we do have some search data...
		if(master_enrichment_DataStore.baseParams.query!==null){searchquery = master_enrichment_DataStore.baseParams.query;}
		if(master_enrichment_DataStore.baseParams.enrich_no!==null){enrich_no_print = master_enrichment_DataStore.baseParams.enrich_no;}
		if(master_enrichment_DataStore.baseParams.enrich_student!==null){jproduk_cust_print = master_enrichment_DataStore.baseParams.enrich_student;}
		if(master_enrichment_DataStore.baseParams.enrich_tanggal!==""){enrich_tanggal_print_date = master_enrichment_DataStore.baseParams.enrich_tanggal;}
		if(master_enrichment_DataStore.baseParams.enrich_tanggal_akhir!==""){enrich_tanggal_akhir_print_date = master_enrichment_DataStore.baseParams.enrich_tanggal_akhir;}
		if(master_enrichment_DataStore.baseParams.jproduk_diskon!==null){jproduk_diskon_print = master_enrichment_DataStore.baseParams.jproduk_diskon;}
		if(master_enrichment_DataStore.baseParams.enrich_cara!==null){enrich_cara_print = master_enrichment_DataStore.baseParams.enrich_cara;}
		if(master_enrichment_DataStore.baseParams.enrich_note!==null){enrich_note_print = master_enrichment_DataStore.baseParams.enrich_note;}
		if(master_enrichment_DataStore.baseParams.enrich_stat_dok!==null){enrich_stat_dok_print = master_enrichment_DataStore.baseParams.enrich_stat_dok;}

		Ext.Ajax.request({   
		waitMsg: 'Mohon tunggu...',
		url: 'index.php?c=c_master_enrichment&m=get_action',
		params: {
			task   				: "PRINT",
		  	query  				: searchquery,                    		// if we are doing a quicksearch, use this
			enrich_no			:	enrich_no_print, 
			enrich_student		:	jproduk_cust_print, 
			enrich_tanggal		:	enrich_tanggal_print_date, 
			enrich_tanggal_akhir:	enrich_tanggal_akhir_print_date, 
			jproduk_diskon		:	jproduk_diskon_print, 
			enrich_cara			:	enrich_cara_print, 
			enrich_note			:	enrich_note_print, 
			enrich_stat_dok		:	enrich_stat_dok_print,
		  	currentlisting 		: master_enrichment_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/master_jual_produklist.html','master_jual_produklist','height=400,width=900,resizable=1,scrollbars=1, menubar=1');
				break;
		  	default:
				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Unable to print the grid!',
					buttons: Ext.MessageBox.OK,
					animEl: 'save',
					icon: Ext.MessageBox.WARNING
				});
				break;
		  	}  
		},
		failure: function(response){
		  	var result=response.responseText;
			Ext.MessageBox.show({
			   title: 'Error',
			   msg: 'Could not connect to the database. retry later.',
			   buttons: Ext.MessageBox.OK,
			   animEl: 'database',
			   icon: Ext.MessageBox.ERROR
			});		
		} 	                     
		});
	}
	/* Enf Function */
	
	/* Function for print Export to Excel Grid */
	function master_enrichment_export_excel(){
		var searchquery = "";
		var enrich_no_2excel=null;
		var jproduk_cust_2excel=null;
		var enrich_tanggal_2excel_date="";
		var enrich_tanggal_akhir_2excel_date="";
		var jproduk_diskon_2excel=null;
		var enrich_cara_2excel=null;
		var enrich_note_2excel=null;
		var win;              
		// check if we do have some search data...
		if(master_enrichment_DataStore.baseParams.query!==null){searchquery = master_enrichment_DataStore.baseParams.query;}
		if(master_enrichment_DataStore.baseParams.enrich_no!==null){enrich_no_2excel = master_enrichment_DataStore.baseParams.enrich_no;}
		if(master_enrichment_DataStore.baseParams.enrich_student!==null){jproduk_cust_2excel = master_enrichment_DataStore.baseParams.enrich_student;}
		if(master_enrichment_DataStore.baseParams.enrich_tanggal!==""){enrich_tanggal_2excel_date = master_enrichment_DataStore.baseParams.enrich_tanggal;}
		if(master_enrichment_DataStore.baseParams.enrich_tanggal_akhir!==""){enrich_tanggal_akhir_2excel_date = master_enrichment_DataStore.baseParams.enrich_tanggal_akhir;}
		if(master_enrichment_DataStore.baseParams.jproduk_diskon!==null){jproduk_diskon_2excel = master_enrichment_DataStore.baseParams.jproduk_diskon;}
		if(master_enrichment_DataStore.baseParams.enrich_cara!==null){enrich_cara_2excel = master_enrichment_DataStore.baseParams.enrich_cara;}
		if(master_enrichment_DataStore.baseParams.enrich_note!==null){enrich_note_2excel = master_enrichment_DataStore.baseParams.enrich_note;}
		if(master_enrichment_DataStore.baseParams.enrich_stat_dok!==null){enrich_stat_dok_2excel = master_enrichment_DataStore.baseParams.enrich_stat_dok;}
		
		Ext.Ajax.request({   
		waitMsg: 'Mohon tunggu...',
		url: 'index.php?c=c_master_enrichment&m=get_action',
		params: {
			task 				: "EXCEL",
		  	query  				: searchquery,                    		// if we are doing a quicksearch, use this
			enrich_no			:	enrich_no_2excel, 
			enrich_student		:	jproduk_cust_2excel, 
			enrich_tanggal		:	enrich_tanggal_2excel_date, 
			enrich_tanggal_akhir:	enrich_tanggal_akhir_2excel_date, 
			jproduk_diskon		:	jproduk_diskon_2excel, 
			enrich_cara			:	enrich_cara_2excel, 
			enrich_note			:	enrich_note_2excel, 
			enrich_stat_dok		:	enrich_stat_dok_2excel,
		  	currentlisting 		: master_enrichment_DataStore.baseParams.task // this tells us if we are searching or not
		},
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.location=('./export2excel.php');
				break;
		  	default:
				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Unable to convert excel the grid!',
					buttons: Ext.MessageBox.OK,
					animEl: 'save',
					icon: Ext.MessageBox.WARNING
				});
				break;
		  	}  
		},
		failure: function(response){
		  	var result=response.responseText;
			Ext.MessageBox.show({
			   title: 'Error',
			   msg: 'Could not connect to the database. retry later.',
			   buttons: Ext.MessageBox.OK,
			   animEl: 'database',
			   icon: Ext.MessageBox.ERROR
			});    
		} 	                     
		});
	}
	/*End of Function */
	function enrich_btn_cancel(){
		master_enrichment_reset_form();
		detail_enrichment_DataStore.load({params: {master_id:-1}});
		enrichment_caraField.setValue("tunai");
		master_enrichment_tunaiGroup.setVisible(true);
		enrichment_master_cara_bayarTabPanel.setActiveTab(0);
		enrichment_post2db="CREATE";
		enrich_diskonField.setValue(0);
		enrich_cashbackField.setValue(0);
		enrich_diskonField.allowBlank=true;
		enrichment_pesanLabel.setText('');
		enrich_lunasLabel.setText('');
		enrich_cust_priorityLabel.setText('');
	}
	
	function pertamax(){
		enrichment_post2db="CREATE";
		enrichment_stat_dokField.setValue('Terbuka');
		enrich_stat_timeField.setValue('Pagi');
		enrichment_tanggalField.setValue(dt.format('Y-m-d'));
		master_enrichment_createForm.render();
		enrichment_caraField.setValue('tunai');
		master_enrichment_tunaiGroup.setVisible(true);
		enrich_cashbackField.setValue(0);
		enrich_diskonField.setValue(0);
		enrich_diskonField.allowBlank=true;
		enrich_karyawanField.setDisabled(true);
	}
	pertamax();
	

	combo_jual_enrichment.on('select',function(){
		var j=cbo_denrichment_DataStore.findExact('dproduk_produk_value',combo_jual_enrichment.getValue(),0);

            //Untuk me-lock screen sementara, menunggu data selesai di-load ==> setelah selesai di-load, hide Ext.MessageBox.show() di bawah ini
			// detail_enrichmentListEditorGrid.setDisabled(true);
			// editor_detail_enrichment.disable();
			
            denrich_idField.setValue(cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_value);
			dharga_enrichment_konversiField.setValue(cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_harga);
			denrich_jumlah_diskonField.setValue(cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_du);
			denrich_subtotal_netField.setValue(cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_harga);

			// denrich_subtotal_netField.setValue((cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_harga) * ((100-cbo_denrichment_DataStore.getAt(j).data.dproduk_produk_du)/100));


		});


	// Event ketika memilih Uang Pangkal
	enrichment_cost_noteField.on('select',function(){
		if(enrichment_cost_noteField.getValue() == 'uang_pangkal'){
		cbo_transaction_setting_DataStore.load({
						params : {},
						callback : function(opts, success, response){
							if (success) {
								enrichment_record=cbo_transaction_setting_DataStore.getAt(0).data;
								dharga_enrichment_konversiField.setValue(enrichment_record.uang_pangkal_enrichment);
							}
						}
		});
		}
		else
		{
		dharga_enrichment_konversiField.setValue(0);
		}
	});

	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_master_enrichment"></div>
         <div id="fp_detail_enrichment"></div>
		<div id="elwindow_master_enrichment_create"></div>
        <div id="elwindow_master_enrichment_search"></div>
        <div id="form_enrichment_addEdit"></div>
    </div>
</div>
</body>