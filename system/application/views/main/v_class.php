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
var class_DataStore;
var class_ColumnModel;
var class_ListEditorGrid;
var class_createForm;
var class_createWindow;
var class_searchForm;
var class_searchWindow;
var class_SelectedRow;
var class_ContextMenu;
//declare konstant
var post2db = '';
var msg = '';
var pageS_class=15;

/* declare variable here */
var class_idField;
var class_namaField;
var class_lokasiField;
var class_time_startField;
var class_time_endField;
var class_capacityField;
var class_age_downField;
var class_age_upField;
var class_keteranganField;
var class_aktifField;

var class_idSearchField;
var class_namaSearchField;
var class_lokasiSearchField;
var class_keteranganSearchField;
var class_aktifSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */

  	Ext.util.Format.comboRenderer = function(combo){
  	    return function(value){
  	        var record = combo.findRecord(combo.valueField, value);
  	        return record ? record.get(combo.displayField) : combo.valueNotFoundText;
  	    }
  	}
  
  	/* Function for Saving inLine Editing */
	function class_update(oGrid_event){
	var class_id_update_pk="";
	var class_nama_update=null;
	var class_lokasi_update=null;
	var class_keterangan_update=null;
	var class_aktif_update=null;


	class_id_update_pk = oGrid_event.record.data.class_id;
	if(oGrid_event.record.data.class_name!== null){class_nama_update = oGrid_event.record.data.class_name;}
	if(oGrid_event.record.data.class_location!== null){class_lokasi_update = oGrid_event.record.data.class_location;}
	if(oGrid_event.record.data.class_notes!== null){class_keterangan_update = oGrid_event.record.data.class_notes;}
	if(oGrid_event.record.data.class_stat!== null){class_aktif_update = oGrid_event.record.data.class_stat;}
	

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_class&m=get_action',
			params: {
				task: "UPDATE",
				class_id	: class_id_update_pk,				
				class_name	:class_nama_update,		
				class_location	:class_lokasi_update,		
				class_notes	:class_keterangan_update,		
				class_stat	:class_aktif_update	
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						class_DataStore.commitChanges();
						class_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Class tidak bisa disimpan.',
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
							   msg: 'Tidak bisa terhubung dengan database server',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'database',
							   icon: Ext.MessageBox.ERROR
				});	
			}									    
		});   
	}
  	/* End of Function */
  
  	/* Function for add data, open window create form */
	function class_create(){
		if(is_class_form_valid()){
		
		var class_id_create_pk=null;
		var class_nama_create=null;
		var class_lokasi_create=null;
		var class_time_start_create=null;
		var class_time_end_create=null;
		var class_capacity_create=null;
		var class_age_down_create=null;
		var class_age_up_create=null;
		var class_keterangan_create=null;
		var class_aktif_create=null;
		var class_teacher1_create=null;
		var class_teacher2_create=null;
		var class_teacher3_create=null;

		class_id_create_pk=get_pk_id();
		if(class_namaField.getValue()!== null){class_nama_create = class_namaField.getValue();}
		if(class_lokasiField.getValue()!== null){class_lokasi_create = class_lokasiField.getValue();}
		if(class_time_startField.getValue()!== null){class_time_start_create = class_time_startField.getValue();}
		if(class_time_endField.getValue()!== null){class_time_end_create = class_time_endField.getValue();}
		if(class_capacityField.getValue()!== null){class_capacity_create = class_capacityField.getValue();}
		if(class_age_downField.getValue()!== null){class_age_down_create = class_age_downField.getValue();}
		if(class_age_upField.getValue()!== null){class_age_up_create = class_age_upField.getValue();}
		if(class_keteranganField.getValue()!== null){class_keterangan_create = class_keteranganField.getValue();}
		if(class_aktifField.getValue()!== null){class_aktif_create = class_aktifField.getValue();}
		if(class_teacher1Field.getValue()!== null){class_teacher1_create = class_teacher1Field.getValue();}
		if(class_teacher2Field.getValue()!== null){class_teacher2_create = class_teacher2Field.getValue();}
		if(class_teacher3Field.getValue()!== null){class_teacher3_create = class_teacher3Field.getValue();}

		// Penambahan Detail List Student Class
		var dclass_id = [];
        var dclass_master = [];
        var dclass_student = [];
        var dclass_note = [];
        var dclass_aktif = [];
        if(detail_class_student_DataStore.getCount()>0){
            for(i=0; i<detail_class_student_DataStore.getCount();i++){
                if(detail_class_student_DataStore.getAt(i).data.dclass_student!==""){
                  	dclass_id.push(detail_class_student_DataStore.getAt(i).data.dclass_id);
					dclass_student.push(detail_class_student_DataStore.getAt(i).data.dclass_student);
                   	dclass_note.push(detail_class_student_DataStore.getAt(i).data.dclass_note);
					dclass_aktif.push(detail_class_student_DataStore.getAt(i).data.dclass_aktif);
                }
            }
			var encoded_array_dclass_id = Ext.encode(dclass_id);
			var encoded_array_dclass_student = Ext.encode(dclass_student);
			var encoded_array_dclass_note = Ext.encode(dclass_note);
			var encoded_array_dclass_aktif = Ext.encode(dclass_aktif);
		}

		
			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_class&m=get_action',
				params: {
					task				: post2db,
					class_id			: class_id_create_pk,	
					class_name			: class_nama_create,	
					class_location		: class_lokasi_create,	
					class_time_start	: class_time_start_create,	
					class_time_end		: class_time_end_create,	
					class_capacity		: class_capacity_create,	
					class_age_down		: class_age_down_create,	
					class_age_up		: class_age_up_create,	
					class_notes			: class_keterangan_create,	
					class_stat			: class_aktif_create,
					class_teacher1		: class_teacher1_create,
					class_teacher2		: class_teacher2_create,
					class_teacher3		: class_teacher3_create,

					//detail List Student Class
					dclass_id 			: encoded_array_dclass_id,
					dclass_master		: eval(get_pk_id()),
					dclass_student 		: encoded_array_dclass_student,
					dclass_note 		: encoded_array_dclass_note,
					dclass_aktif 		: encoded_array_dclass_aktif

				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db+' OK','Data Class berhasil disimpan');
							class_DataStore.reload();
							class_createWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Class tidak bisa disimpan !.',
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
								   msg: 'Tidak bisa terhubung dengan database server',
								   buttons: Ext.MessageBox.OK,
								   animEl: 'database',
								   icon: Ext.MessageBox.ERROR
					});	
				}                      
			});
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Isian belum sempurna!.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
 	/* End of Function */
  
  	/* Function for get PK field */
	function get_pk_id(){
		if(post2db=='UPDATE')
			return class_ListEditorGrid.getSelectionModel().getSelected().get('class_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function class_reset_form(){
		class_namaField.reset();
		class_lokasiField.reset();
		class_time_startField.reset();
		class_time_endField.reset();
		class_capacityField.reset();
		class_age_downField.reset();
		class_age_upField.reset();
		class_keteranganField.reset();
		class_aktifField.reset();
		class_teacher1Field.reset();
		class_teacher2Field.reset();
		class_teacher3Field.reset();

		detail_class_student_DataStore.load({params : {master_id : -1}});

	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function class_set_form(){
		class_namaField.setValue(class_ListEditorGrid.getSelectionModel().getSelected().get('class_name'));
		class_lokasiField.setValue(class_ListEditorGrid.getSelectionModel().getSelected().get('class_location'));
		class_time_startField.setValue(class_ListEditorGrid.getSelectionModel().getSelected().get('class_time_start'));
		class_time_endField.setValue(class_ListEditorGrid.getSelectionModel().getSelected().get('class_time_end'));
		class_capacityField.setValue(class_ListEditorGrid.getSelectionModel().getSelected().get('class_capacity'));
		class_age_downField.setValue(class_ListEditorGrid.getSelectionModel().getSelected().get('class_age_down'));
		class_age_upField.setValue(class_ListEditorGrid.getSelectionModel().getSelected().get('class_age_up'));
		class_keteranganField.setValue(class_ListEditorGrid.getSelectionModel().getSelected().get('class_notes'));
		class_aktifField.setValue(class_ListEditorGrid.getSelectionModel().getSelected().get('class_stat'));
		class_teacher1Field.setValue(class_ListEditorGrid.getSelectionModel().getSelected().get('class_teacher1'));
		class_teacher2Field.setValue(class_ListEditorGrid.getSelectionModel().getSelected().get('class_teacher2'));
		class_teacher3Field.setValue(class_ListEditorGrid.getSelectionModel().getSelected().get('class_teacher3'));

		cbo_class_student_DataStore.load({
			params: {
					query: class_ListEditorGrid.getSelectionModel().getSelected().get('class_id'),
					aktif: 'yesno'
				},
				callback: function(opts, success, response){
						detail_class_student_DataStore.load({params : {master_id : get_pk_id() }});
				}

			});

	

	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_class_form_valid(){
		return (class_namaField.isValid());
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!class_createWindow.isVisible()){
			
			post2db='CREATE';
			msg='created';
			class_reset_form();
			
			class_createWindow.show();
		} else {
			class_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function class_confirm_delete(){
		// only one gudang is selected here
		if(class_ListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', gudang_delete);
		} else if(class_ListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', gudang_delete);
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
	function class_confirm_update(){
		/* only one record is selected here */
		if(class_ListEditorGrid.selModel.getCount() == 1) {
			post2db='UPDATE';
			msg='updated';
			class_set_form();
			class_createWindow.show();
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Tidak ada data yang dipilih untuk diedit',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
  	/* Function for Delete Record */
	function gudang_delete(btn){
		if(btn=='yes'){
			var selections = class_ListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< class_ListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.class_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_class&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							class_DataStore.reload();
							break;
						default:
							Ext.MessageBox.show({
								title: 'Warning',
								msg: 'Tidak bisa menghapus data yang diplih',
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
					   msg: 'Tidak bisa terhubung dengan database server',
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
	class_DataStore = new Ext.data.Store({
		id: 'class_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_class&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit:pageS_class}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'class_id'
		},[
			{name: 'class_id', type: 'int', mapping: 'class_id'},
			{name: 'class_name', type: 'string', mapping: 'class_name'},
			{name: 'class_location', type: 'string', mapping: 'class_location'},
			{name: 'class_time_start', type: 'time', mapping: 'time_start'},
			{name: 'class_time_end', type: 'time', mapping: 'time_end'},
			{name: 'class_capacity', type: 'string', mapping: 'class_capacity'},
			{name: 'class_age_down', type: 'string', mapping: 'class_age_down'},
			{name: 'class_age_up', type: 'string', mapping: 'class_age_up'},
			{name: 'class_notes', type: 'string', mapping: 'class_notes'},
			{name: 'class_stat', type: 'string', mapping: 'class_stat'},
			{name: 'class_teacher1', type: 'string', mapping: 'class_teacher1'},
			{name: 'class_teacher2', type: 'string', mapping: 'class_teacher2'},
			{name: 'class_teacher3', type: 'string', mapping: 'class_teacher3'},
			{name: 'class_creator', type: 'string', mapping: 'class_creator'},
			{name: 'class_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'class_date_create'},
			{name: 'class_update', type: 'string', mapping: 'class_update'},
			{name: 'class_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'class_date_update'},
			{name: 'class_revised', type: 'int', mapping: 'class_revised'}
		]),
		sortInfo:{field: 'class_name', direction: "ASC"}
	});
	/* End of Function */

	/* Function for Retrieve DataStore */
	cbo_class_student_DataStore = new Ext.data.Store({
		id: 'cbo_class_student_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_class&m=get_student_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit: 10000 }, // parameter yang di $_POST ke Controller
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

	//Custom rendering Template
    var class_student_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{cust_no} : {cust_nama}</b><br /></span>',
            '{cust_alamat} | {cust_telprumah}<br>',
			'Tgl-Lahir:{cust_tgllahir:date("j M Y")}',
        '</div></tpl>'
    );

    //DataStore for Class Teacher DataStore
    class_teacher_DataStore = new Ext.data.Store({
		id: 'class_teacher_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_class&m=get_teacher_list',
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: pageS_class},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'karyawan_id'
		},[
			{name: 'karyawan_id', type: 'int', mapping: 'karyawan_id'},
			{name: 'karyawan_no', type: 'string', mapping: 'karyawan_no'},
			{name: 'karyawan_nama', type: 'string', mapping: 'karyawan_nama'},
			{name: 'cust_tgllahir', type: 'date', dateFormat: 'Y-m-d', mapping: 'cust_tgllahir'},
			{name: 'karyawan_kelamin', type: 'string', mapping: 'karyawan_kelamin'},
			{name: 'cust_telprumah', type: 'string', mapping: 'cust_telprumah'}
		]),
		sortInfo:{field: 'karyawan_no', direction: "ASC"}
	});

    var class_teacher_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>({karyawan_no}) {karyawan_nama}</b><br /></span>',
			'Jenis Kelamin : {karyawan_kelamin}',
            /*'{cust_alamat} | {cust_telprumah}',*/
        '</div></tpl>'
    );
    
  	/* Function for Identify of Window Column Model */
	class_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'class_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: '<div align="center">' + 'Class Name' + '</div>',
			dataIndex: 'class_name',
			width: 200,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CLASS'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			header: '<div align="center">' + 'Location' + '</div>',
			dataIndex: 'class_location',
			width: 100,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Time Start' + '</div>',
			dataIndex: 'class_time_start',
			width: 100,
			//renderer: Ext.util.Format.dateRenderer('H:i:s'),
			sortable: true
		},
		{
			header: '<div align="center">' + 'Time End' + '</div>',
			dataIndex: 'class_time_end',
			width: 100,
			//renderer: Ext.util.Format.dateRenderer('H:i:s'),
			sortable: true
		},
		{
			header: '<div align="center">' + 'Capacity' + '</div>',
			dataIndex: 'class_capacity',
			width: 100,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Age Lowest (month)' + '</div>',
			dataIndex: 'class_age_down',
			width: 100,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Age Highest (month)' + '</div>',
			dataIndex: 'class_age_up',
			width: 100,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Notes' + '</div>',
			dataIndex: 'class_notes',
			width: 200,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CLASS'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			header: '<div align="center">' + 'Stat' + '</div>',
			dataIndex: 'class_stat',
			width: 80,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CLASS'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['gudang_aktif_value', 'gudang_aktif_display'],
					data: [['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
					}),
				mode: 'local',
               	displayField: 'gudang_aktif_display',
               	valueField: 'gudang_aktif_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		},
		{
			header: 'Creator',
			dataIndex: 'class_creator',
			width: 150,
			sortable: true,
			hidden: true
		},
		{
			header: 'Create on',
			dataIndex: 'class_date_create',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden: true
		},
		{
			header: 'Last Update by',
			dataIndex: 'class_update',
			width: 150,
			sortable: true,
			hidden: true
		},
		{
			header: 'Last Update on',
			dataIndex: 'class_date_update',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden: true
		},
		{
			header: 'Revised',
			dataIndex: 'class_revised',
			width: 150,
			sortable: true,
			hidden: true
		}]
	);
	class_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	class_ListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'class_ListEditorGrid',
		el: 'fp_class',
		title: 'Class List',
		autoHeight: true,
		store: class_DataStore, // DataStore
		cm: class_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 800,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS_class,
			store: class_DataStore,
			displayInfo: true
		}),
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_CLASS'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_CLASS'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: class_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_CLASS'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: class_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: class_DataStore,
			params: {task: 'LIST',start: 0, limit: pageS_class},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						class_DataStore.baseParams={task:'LIST',start: 0, limit: pageS_class};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- Class Name<br>- Location<br>- Notes'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: class_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: class_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: class_print  
		}
		]
	});
	class_ListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	class_ContextMenu = new Ext.menu.Menu({
		id: 'gudang_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_CLASS'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: class_confirm_update 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_CLASS'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: class_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: class_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: class_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onclass_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		class_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		class_SelectedRow=rowIndex;
		class_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function class_editContextMenu(){
      class_ListEditorGrid.startEditing(class_SelectedRow,1);
  	}
	/* End of Function */
  	
	class_ListEditorGrid.addListener('rowcontextmenu', onclass_ListEditGridContextMenu);
	class_DataStore.load({params: {start: 0, limit: pageS_class}});	// load DataStore
	class_ListEditorGrid.on('afteredit', class_update); // inLine Editing Record
	
	/* Identify  class_name Field */
	class_namaField= new Ext.form.TextField({
		id: 'class_namaField',
		fieldLabel: 'Class Name <span style="color: #ec0000">*</span>',
		maxLength: 250,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  class_location Field */
	class_lokasiField= new Ext.form.TextField({
		id: 'class_lokasiField',
		fieldLabel: 'Location',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  class_time_startField Field */
	class_time_startField= new Ext.form.TimeField({
		id: 'class_time_startField',
		minValue: '07:30',
		maxValue: '13:00',
		increment: 5,
		fieldLabel: 'Time Start',
		format : 'H:i',
		allowBlank: false,
	});
	/* Identify  class_time_endField Field */
	class_time_endField= new Ext.form.TimeField({
		id: 'class_time_endField',
		minValue: '07:30',
		maxValue: '13:00',
		increment: 5,
		fieldLabel: 'Time End',
		format : 'H:i',
		allowBlank: false,
	});
	/* Identify  class_capacity Field */
	class_capacityField= new Ext.form.TextField({
		id: 'class_capacity',
		fieldLabel: 'Capacity',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  class_age_down Field */
	class_age_downField= new Ext.form.TextField({
		id: 'class_age_down',
		fieldLabel: 'Age Lowest(month)',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  class_age_up Field */
	class_age_upField= new Ext.form.TextField({
		id: 'class_age_up',
		fieldLabel: 'Age Highest(month)',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  class_notes Field */
	class_keteranganField= new Ext.form.TextArea({
		id: 'class_keteranganField',
		fieldLabel: 'Notes',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  class_stat Field */
	class_aktifField= new Ext.form.ComboBox({
		id: 'class_aktifField',
		fieldLabel: 'Stat',
		store:new Ext.data.SimpleStore({
			fields:['gudang_aktif_value', 'gudang_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		editable:false,
		displayField: 'gudang_aktif_display',
		valueField: 'gudang_aktif_value',
		emptyText: 'Aktif',
		width: 80,
		triggerAction: 'all'	
	});
	
	/* Identify combo_class_student Field */
	combo_class_student= new Ext.form.ComboBox({
		id: 'combo_class_student',
		fieldLabel: 'Student/Baby',
		store: cbo_class_student_DataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
		forceSelection: true,
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: class_student_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '75%'
		//hidden: true
	});

	// Identify class Teacher Field
	class_teacher1Field= new Ext.form.ComboBox({
		id: 'class_teacher1Field',
		fieldLabel: 'Teacher 1',
		store: class_teacher_DataStore,
		mode: 'remote',
		displayField:'karyawan_nama',
		valueField: 'karyawan_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: class_teacher_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '65%'
		// allowBlank: false
	});

	class_teacher2Field= new Ext.form.ComboBox({
		id: 'class_teacher2Field',
		fieldLabel: 'Teacher 2',
		store: class_teacher_DataStore,
		mode: 'remote',
		displayField:'karyawan_nama',
		valueField: 'karyawan_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: class_teacher_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '65%'
		// allowBlank: false
	});

	class_teacher3Field= new Ext.form.ComboBox({
		id: 'class_teacher3Field',
		fieldLabel: 'Teacher 3',
		store: class_teacher_DataStore,
		mode: 'remote',
		displayField:'karyawan_nama',
		valueField: 'karyawan_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: class_teacher_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '65%'
		// allowBlank: false
	});

  	
	/* Function for retrieve create Window Panel*/ 
	/*
	class_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 300,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [class_namaField, class_lokasiField, class_time_startField, class_time_endField, class_capacityField, class_age_downField, class_age_upField, class_keteranganField, class_aktifField] 
			}
			]
		}]
		,
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_CLASS'))){ ?>
			{
				text: 'Save and Close',
				handler: class_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					class_createWindow.hide();
				}
			}
		]
	});
*/
	/* End  of Function*/


	/* Function for action list search */
	function class_list_search(){
		// render according to a SQL date format.
		var gudang_id_search=null;
		var gudang_nama_search=null;
		var gudang_lokasi_search=null;
		var gudang_keterangan_search=null;
		var gudang_aktif_search=null;


		if(class_idSearchField.getValue()!==null){gudang_id_search=class_idSearchField.getValue();}
		if(class_namaSearchField.getValue()!==null){gudang_nama_search=class_namaSearchField.getValue();}
		if(class_lokasiSearchField.getValue()!==null){gudang_lokasi_search=class_lokasiSearchField.getValue();}
		if(class_keteranganSearchField.getValue()!==null){gudang_keterangan_search=class_keteranganSearchField.getValue();}
		if(class_aktifSearchField.getValue()!==null){gudang_aktif_search=class_aktifSearchField.getValue();}

		// change the store parameters
		class_DataStore.baseParams = {
			task: 'SEARCH',
			start: 0,
			limit: pageS_class,
			class_id	:	gudang_id_search, 
			class_name	:	gudang_nama_search, 
			class_location	:	gudang_lokasi_search, 
			class_notes	:	gudang_keterangan_search, 
			class_stat	:	gudang_aktif_search
	};
		// Cause the datastore to do another query : 
		class_DataStore.reload({params: {start: 0, limit: pageS_class}});
	}
		
	/* Function for reset search result */
	function class_reset_search(){
		// reset the store parameters
		class_DataStore.baseParams = { task: 'LIST', start:0, limit:pageS_class };
		class_DataStore.reload({params: {start: 0, limit: pageS_class}});
		//class_searchWindow.close();
	};
	/* End of Fuction */
	
	function class_reset_SearchForm(){
		class_namaSearchField.reset();
		class_lokasiSearchField.reset();
		class_keteranganSearchField.reset();
		class_aktifSearchField.reset();
	}
	
	/* Field for search */
	/* Identify  class_id Search Field */
	class_idSearchField= new Ext.form.NumberField({
		id: 'class_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  class_name Search Field */
	class_namaSearchField= new Ext.form.TextField({
		id: 'class_namaSearchField',
		fieldLabel: 'Class Name',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  class_location Search Field */
	class_lokasiSearchField= new Ext.form.TextField({
		id: 'class_lokasiSearchField',
		fieldLabel: 'Location',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  class_notes Search Field */
	class_keteranganSearchField= new Ext.form.TextField({
		id: 'class_keteranganSearchField',
		fieldLabel: 'Notes',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  class_stat Search Field */
	class_aktifSearchField= new Ext.form.ComboBox({
		id: 'class_aktifSearchField',
		fieldLabel: 'Stat',
		store:new Ext.data.SimpleStore({
			fields:['value', 'class_stat'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		displayField: 'class_stat',
		valueField: 'value',
		emptyText: 'Aktif',
		width: 80,
		triggerAction: 'all'	 
	
	});
	    
	/* Function for retrieve search Form Panel */
	class_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 300,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [class_namaSearchField, class_lokasiSearchField, class_keteranganSearchField, class_aktifSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: class_list_search
			},{
				text: 'Close',
				handler: function(){
					class_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 

    // Function for json reader of detail
	var detail_class_student_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: ''
	},[
		{name: 'dclass_id', type: 'int', mapping: 'dclass_id'}, 
		{name: 'dclass_master', type: 'int', mapping: 'dclass_master'}, 
		{name: 'dclass_note', type: 'string', mapping: 'dclass_note'}, 
		{name: 'dclass_student', type: 'int', mapping: 'dclass_student'}, 
		{name: 'dclass_aktif', type: 'string', mapping: 'dclass_aktif'}
	]);
	//eof
	
	//function for json writer of detail
	var detail_class_student_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	/* Function for Retrieve DataStore of detail*/
	detail_class_student_DataStore = new Ext.data.Store({
		id: 'detail_class_student_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_class&m=detail_student_class_list', 
			method: 'POST'
		}),
		reader: detail_class_student_reader,
		baseParams:{start: 0, limit: pageS_class},
		sortInfo:{field: 'dclass_id', direction: "ASC"}
	});
	/* End of Function */
	
	//function for editor of detail
	var editor_detail_class_student= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof

    //declaration of detail coloumn model
	detail_class_student_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: 'ID',
			dataIndex: 'dclass_id',
			width: 70,
			sortable: false,
			hidden : true
		},
		{
			header: 'Student/Baby Name',
			dataIndex: 'dclass_student',
			width: 115,
			sortable: false,
			editor: combo_class_student,
			renderer: Ext.util.Format.comboRenderer(combo_class_student)
		},
		{
			header: 'Notes',
			dataIndex: 'dclass_note',
			width: 115,
			sortable: false,
			editor: new Ext.form.TextArea({
				maxLength: 250
          	})
		},
		{
			header: 'Active',
			dataIndex: 'dclass_aktif',
			width: 115,
			sortable: false,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['class_aktif_value', 'class_aktif_display'],
					data: [['Aktif','Active'],['Tidak Aktif','Not Active']]
					}),
				mode: 'local',
               	displayField: 'class_aktif_display',
               	valueField: 'class_aktif_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		}
		]
	);
	detail_class_student_ColumnModel.defaultSortable= true;
	//eof


    // Detail Student List
	detail_class_student_ListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_class_student_ListEditorGrid',
		el: 'fp_detail_class_student',
		title: 'List Student',
		height: 300,
		width: 600,
		autoScroll: true,
		store: detail_class_student_DataStore, // DataStore
		colModel: detail_class_student_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_detail_class_student],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:false},
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_CLASS'))){ ?>
		
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: detail_add_student_class
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			handler: detail_student_list_delete
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: student_print  
		}
		]
		<?php } ?>
	});

	//function of detail add Class Student List
	function detail_add_student_class(){
		var edit_detail_student= new detail_class_student_ListEditorGrid.store.recordType({
			dclass_id			:'',		
			dclass_student 		:'',		
			dclass_note 		:'',		
			dclass_aktif 		:''	
		});
		editor_detail_class_student.stopEditing();
		detail_class_student_DataStore.insert(0, edit_detail_student);
		detail_class_student_ListEditorGrid.getView().refresh();
		detail_class_student_ListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_class_student.startEditing(0);
	}

	/* Function for Delete Confirm of detail */
	function detail_student_list_delete(){
		// only one record is selected here
		if(detail_class_student_ListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Are you sure to delete this data?', detail_student_delete);
		} else if(detail_class_student_ListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Are you sure to delete all of this data?', detail_student_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'No data selected',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
	//eof

	//function for Delete of detail
	/*
	function detail_student_delete(btn){
		if(btn=='yes'){
			var s = detail_class_student_ListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				detail_class_student_DataStore.remove(r);
			}
		}  
	}
	*/
	//eof
	//function for Delete of detail
	function detail_student_delete(btn){
		if(btn=='yes'){
            var selections = detail_class_student_ListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, record; record = selections[i]; i++){
                if(record.data.dclass_id==''){
                    detail_class_student_DataStore.remove(record);
                }else if((/^\d+$/.test(record.data.dclass_id))){
                    //Delete dari db.class
                    Ext.MessageBox.show({
                        title: 'Please wait',
                        msg: 'Loading items...',
                        progressText: 'Initializing...',
                        width:300,
                        wait:true,
                        waitConfig: {interval:200},
                        closable:false
                    });
                    detail_class_student_DataStore.remove(record);
                    Ext.Ajax.request({ 
                        waitMsg: 'Please Wait',
                        url: 'index.php?c=c_class&m=get_action', 
                        params: { task: "DDELETE", dclass_id:  record.data.dclass_id }, 
                        success: function(response){
							var result=eval(response.responseText);
							switch(result){
								case 1:
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
	// EOF PENDIDIKAN


	
	/* Function for print List Grid */
	function student_print(){
		var searchquery = "";
		var win;              
		// check if we do have some search data...
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_class&m=get_action',
		params: {
			task		: "PRINT_STUDENT",
			class_name 	: class_namaField.getValue(),
		  	query		: searchquery,
			master_id 	: get_pk_id()
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./kategorilist.html','kategorilist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
				break;
		  	default:
				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Tidak bisa mencetak data!',
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
			   msg: 'Tidak bisa terhubung dengan database server',
			   buttons: Ext.MessageBox.OK,
			   animEl: 'database',
			   icon: Ext.MessageBox.ERROR
			});		
		} 	                     
		});
	}
	/* End Function */
	

	/* Function for retrieve create Window Panel*/ 
	class_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 600,        
		items: [class_namaField, class_lokasiField, class_time_startField, class_time_endField, class_capacityField, 
			class_teacher1Field, class_teacher2Field, class_teacher3Field,
		class_age_downField, class_age_upField, class_keteranganField, class_aktifField,detail_class_student_ListEditorGrid],
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_CLASS'))){ ?>
			{
				text: 'Save and Close',
				handler: class_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					class_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/

	/* Function for retrieve create Window Form */
	class_createWindow= new Ext.Window({
		id: 'class_createWindow',
		title: post2db+'Class',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_class_create',
		items: class_createForm
	});
	/* End Window */


	 
	/* Function for retrieve search Window Form, used for andvaced search */
	class_searchWindow = new Ext.Window({
		title: 'Class Searching',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_class_search',
		items: class_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!class_searchWindow.isVisible()){
			class_reset_SearchForm();
			class_searchWindow.show();
		} else {
			class_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function class_print(){
		var searchquery = "";
		var gudang_nama_print=null;
		var gudang_lokasi_print=null;
		var gudang_keterangan_print=null;
		var gudang_aktif_print=null;
		var win;              
		// check if we do have some search data...
		if(class_DataStore.baseParams.query!==null){searchquery = class_DataStore.baseParams.query;}
		if(class_DataStore.baseParams.class_name!==null){gudang_nama_print = class_DataStore.baseParams.class_name;}
		if(class_DataStore.baseParams.class_location!==null){gudang_lokasi_print = class_DataStore.baseParams.class_location;}
		if(class_DataStore.baseParams.class_notes!==null){gudang_keterangan_print = class_DataStore.baseParams.class_notes;}
		if(class_DataStore.baseParams.class_stat!==null){gudang_aktif_print = class_DataStore.baseParams.class_stat;}
		

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_class&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		
			class_name : gudang_nama_print,
			class_location : gudang_lokasi_print,
			class_notes : gudang_keterangan_print,
			class_stat : gudang_aktif_print,
		  	currentlisting: class_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./gudanglist.html','gudanglist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
				break;
		  	default:
				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Tidak bisa mencetak data!',
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
			   msg: 'Tidak bisa terhubung dengan database server',
			   buttons: Ext.MessageBox.OK,
			   animEl: 'database',
			   icon: Ext.MessageBox.ERROR
			});		
		} 	                     
		});
	}
	/* Enf Function */
	
	/* Function for print Export to Excel Grid */
	function class_export_excel(){
		var searchquery = "";
		var gudang_nama_2excel=null;
		var gudang_lokasi_2excel=null;
		var gudang_keterangan_2excel=null;
		var gudang_aktif_2excel=null;
		var win;              
		// check if we do have some search data...
		if(class_DataStore.baseParams.query!==null){searchquery = class_DataStore.baseParams.query;}
		if(class_DataStore.baseParams.class_name!==null){gudang_nama_2excel = class_DataStore.baseParams.class_name;}
		if(class_DataStore.baseParams.class_location!==null){gudang_lokasi_2excel = class_DataStore.baseParams.class_location;}
		if(class_DataStore.baseParams.class_notes!==null){gudang_keterangan_2excel = class_DataStore.baseParams.class_notes;}
		if(class_DataStore.baseParams.class_stat!==null){gudang_aktif_2excel = class_DataStore.baseParams.class_stat;}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_class&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		
			class_name : gudang_nama_2excel,
			class_location : gudang_lokasi_2excel,
			class_notes : gudang_keterangan_2excel,
			class_stat : gudang_aktif_2excel,
		  	currentlisting: class_DataStore.baseParams.task // this tells us if we are searching or not
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
					msg: 'Tidak bisa meng-export data ke dalam format excel!',
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
			   msg: 'Tidak bisa terhubung dengan database server',
			   buttons: Ext.MessageBox.OK,
			   animEl: 'database',
			   icon: Ext.MessageBox.ERROR
			});    
		} 	                     
		});
	}
	/*End of Function */
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_class"></div>
        <div id="fp_detail_class_student"></div>
		<div id="elwindow_class_create"></div>
        <div id="elwindow_class_search"></div>
    </div>
</div>
</body>