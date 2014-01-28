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

Ext.ns('Ext.ux.form');

/**
 * @class Ext.ux.form.FileUploadField
 * @extends Ext.form.TextField
 * Creates a file upload field.
 * @xtype fileuploadfield
 */
Ext.ux.form.FileUploadField = Ext.extend(Ext.form.TextField,  {
    /**
     * @cfg {String} buttonText The button text to display on the upload button (defaults to
     * 'Browse...').  Note that if you supply a value for {@link #buttonCfg}, the buttonCfg.text
     * value will be used instead if available.
     */
    buttonText: 'Browse...',
    /**
     * @cfg {Boolean} buttonOnly True to display the file upload field as a button with no visible
     * text field (defaults to false).  If true, all inherited TextField members will still be available.
     */
    buttonOnly: false,
    /**
     * @cfg {Number} buttonOffset The number of pixels of space reserved between the button and the text field
     * (defaults to 3).  Note that this only applies if {@link #buttonOnly} = false.
     */
    buttonOffset: 3,
    /**
     * @cfg {Object} buttonCfg A standard {@link Ext.Button} config object.
     */

    // private
    readOnly: true,

    /**
     * @hide
     * @method autoSize
     */
    autoSize: Ext.emptyFn,

    // private
    initComponent: function(){
        Ext.ux.form.FileUploadField.superclass.initComponent.call(this);

        this.addEvents(
            /**
             * @event fileselected
             * Fires when the underlying file input field's value has changed from the user
             * selecting a new file from the system file selection dialog.
             * @param {Ext.ux.form.FileUploadField} this
             * @param {String} value The file value returned by the underlying file input field
             */
            'fileselected'
        );
    },

    // private
    onRender : function(ct, position){
        Ext.ux.form.FileUploadField.superclass.onRender.call(this, ct, position);

        this.wrap = this.el.wrap({cls:'x-form-field-wrap x-form-file-wrap'});
        this.el.addClass('x-form-file-text');
        this.el.dom.removeAttribute('name');
        this.createFileInput();

        var btnCfg = Ext.applyIf(this.buttonCfg || {}, {
            text: this.buttonText
        });
        this.button = new Ext.Button(Ext.apply(btnCfg, {
            renderTo: this.wrap,
            cls: 'x-form-file-btn' + (btnCfg.iconCls ? ' x-btn-icon' : '')
        }));

        if(this.buttonOnly){
            this.el.hide();
            this.wrap.setWidth(this.button.getEl().getWidth());
        }

        this.bindListeners();
        this.resizeEl = this.positionEl = this.wrap;
    },
    
    bindListeners: function(){
        this.fileInput.on({
            scope: this,
            mouseenter: function() {
                this.button.addClass(['x-btn-over','x-btn-focus'])
            },
            mouseleave: function(){
                this.button.removeClass(['x-btn-over','x-btn-focus','x-btn-click'])
            },
            mousedown: function(){
                this.button.addClass('x-btn-click')
            },
            mouseup: function(){
                this.button.removeClass(['x-btn-over','x-btn-focus','x-btn-click'])
            },
            change: function(){
                var v = this.fileInput.dom.value;
                this.setValue(v);
                this.fireEvent('fileselected', this, v);    
            }
        }); 
    },
    
    createFileInput : function() {
        this.fileInput = this.wrap.createChild({
            id: this.getFileInputId(),
            name: this.name||this.getId(),
            cls: 'x-form-file',
            tag: 'input',
            type: 'file',
            size: 1
        });
    },
    
    reset : function(){
        if (this.rendered) {
            this.fileInput.remove();
            this.createFileInput();
            this.bindListeners();
        }
        Ext.ux.form.FileUploadField.superclass.reset.call(this);
    },

    // private
    getFileInputId: function(){
        return this.id + '-file';
    },

    // private
    onResize : function(w, h){
        Ext.ux.form.FileUploadField.superclass.onResize.call(this, w, h);

        this.wrap.setWidth(w);

        if(!this.buttonOnly){
            var w = this.wrap.getWidth() - this.button.getEl().getWidth() - this.buttonOffset;
            this.el.setWidth(w);
        }
    },

    // private
    onDestroy: function(){
        Ext.ux.form.FileUploadField.superclass.onDestroy.call(this);
        Ext.destroy(this.fileInput, this.button, this.wrap);
    },
    
    onDisable: function(){
        Ext.ux.form.FileUploadField.superclass.onDisable.call(this);
        this.doDisable(true);
    },
    
    onEnable: function(){
        Ext.ux.form.FileUploadField.superclass.onEnable.call(this);
        this.doDisable(false);

    },
    
    // private
    doDisable: function(disabled){
        this.fileInput.dom.disabled = disabled;
        this.button.setDisabled(disabled);
    },

    // private
    preFocus : Ext.emptyFn,

    // private
    alignErrorIcon : function(){
        this.errorIcon.alignTo(this.wrap, 'tl-tr', [2, 0]);
    }

});

Ext.reg('fileuploadfield', Ext.ux.form.FileUploadField);

// backwards compat
Ext.form.FileUploadField = Ext.ux.form.FileUploadField;


var absen_enrich_DataStore;
var absen_enrich_ColumnModel;
var absen_enrichListEditorGrid;
var absen_enrichCreateForm;
var absen_enrich_CreateWindow;
var absen_enrich_SearchForm;
var absen_enrich_SearchWindow;
var absen_enrich_SelectedRow;
var absen_enrich_ContextMenu;
//declare konstant
var absen_post2db = 'CREATE';
var msg = '';
var absen_pageS=15;

var temp_pengantar1='';
var temp_pengantar2='';
var temp_pengantar3='';
var temp_pengantar4='';
var temp_pengantar5='';

var today=new Date().format('Y-m-d');

/* declare variable here */
var absen_enrich_idField;
var absen_enrich_custField;
var absen_enrich_tglField;
var absen_enrich_keteranganField;
var absen_enrich_statusField;

var absen_idSearchField;
var absen_enrich_custSearchField;
var absen_enrich_tglSearchField;
var absen_enrich_keteranganSearchField;
var absen_enrich_statusSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function absenrich_update(oGrid_event){
		var absen_enrich_id_update_pk="";
		var absen_enrich_cust_update=null;
		var absen_enrich_tgl_update=null;
		var absen_enrich_keterangan_update=null;
		var absen_enrich_status_update=null;

		absen_enrich_id_update_pk = oGrid_event.record.data.absenrich_id;
		if(oGrid_event.record.data.absenrich_cust!== null){absen_enrich_cust_update = oGrid_event.record.data.absenrich_cust;}
		if(oGrid_event.record.data.absenrich_tgl!== null){absen_enrich_tgl_update = oGrid_event.record.data.absenrich_tgl;}
		if(oGrid_event.record.data.absenrich_keterangan!== null){absen_enrich_keterangan_update = oGrid_event.record.data.absenrich_keterangan;}
		if(oGrid_event.record.data.absenrich_status!== null){absen_enrich_status_update = oGrid_event.record.data.absenrich_status;}
	
		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_absensi_enrichment&m=get_action',
			params: {
				task: "UPDATE",
				absenrich_id		: absen_enrich_id_update_pk,				
				absenrich_cust		:absen_enrich_cust_update,		
				absenrich_tgl		:absen_enrich_tgl_update,		
				absenrich_keterangan	:absen_enrich_keterangan_update,		
				absenrich_status		:absen_enrich_status_update	
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						absen_enrich_DataStore.commitChanges();
						absen_enrich_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Absensi Enrichment tidak bisa disimpan.',
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
	function absensi_enrichment_create(){
		if(is_absensi_enrichment_form_valid()){
		
		var absenrich_id_create_pk=null;
		var absenrich_cust_create=null;
		var absenrich_tgl_create="";
		var absenrich_class_create=null;
		var absenrich_keterangan_create=null;
		var absenrich_status_create=null;
		var absenrich_namapengantar1_create=null;
		var absenrich_namapengantar2_create=null;
		var absenrich_namapengantar3_create=null;
		var absenrich_namapengantar4_create=null;
		var absenrich_namapengantar5_create=null;

		absenrich_id_create_pk=get_pk_id();
		if(absen_enrich_custField.getValue()!== null){absenrich_cust_create = absen_enrich_custField.getValue();}
		if(absen_enrich_tglField.getValue()!== ""){absenrich_tgl_create = absen_enrich_tglField.getValue().format('Y-m-d');} 
		if(absen_enrich_classField.getValue()!== null){absenrich_class_create = absen_enrich_classField.getValue();}
		if(absen_enrich_keteranganField.getValue()!== null){absenrich_keterangan_create = absen_enrich_keteranganField.getValue();}
		if(absen_enrich_statusField.getValue()!== null){absenrich_status_create = absen_enrich_statusField.getValue();}
		if(absenrich_nama_pengantar1Field.getValue()!== null){absenrich_namapengantar1_create = absenrich_nama_pengantar1Field.getValue();}
		if(absenrich_nama_pengantar2Field.getValue()!== null){absenrich_namapengantar2_create = absenrich_nama_pengantar2Field.getValue();}
		if(absenrich_nama_pengantar3Field.getValue()!== null){absenrich_namapengantar3_create = absenrich_nama_pengantar3Field.getValue();}
		if(absenrich_nama_pengantar4Field.getValue()!== null){absenrich_namapengantar4_create = absenrich_nama_pengantar4Field.getValue();}
		if(absenrich_nama_pengantar5Field.getValue()!== null){absenrich_namapengantar5_create = absenrich_nama_pengantar5Field.getValue();}
		
			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_absensi_enrichment&m=get_action',
				params: {
					task 					: absen_post2db,
					absenrich_id			: absenrich_id_create_pk,	
					absenrich_cust			: absenrich_cust_create,	
					absenrich_class			: absenrich_class_create,	
					absenrich_tgl			: absenrich_tgl_create,	
					absenrich_keterangan 	: absenrich_keterangan_create,	
					absenrich_status		: absenrich_status_create,
					absenrich_pengantar1	: absenrich_namapengantar1_create,
					absenrich_pengantar2	: absenrich_namapengantar2_create,
					absenrich_pengantar3	: absenrich_namapengantar3_create,
					absenrich_pengantar4	: absenrich_namapengantar4_create,
					absenrich_pengantar5	: absenrich_namapengantar5_create,
					absenrich_check1 		: absenrich_checkpengantar1Field.getValue(),
					absenrich_check2 		: absenrich_checkpengantar2Field.getValue(),
					absenrich_check3		: absenrich_checkpengantar3Field.getValue(),
					absenrich_check4 		: absenrich_checkpengantar4Field.getValue(),
					absenrich_check5 		: absenrich_checkpengantar5Field.getValue()
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(absen_post2db+' OK','Data Absensi Enrichment berhasil disimpan');
							absen_enrich_DataStore.reload();
							absenrich_reset_form();
							absen_enrich_CreateWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Absensi Enrichment tidak bisa disimpan !.',
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
		if(absen_post2db=='UPDATE')
			return absen_enrichListEditorGrid.getSelectionModel().getSelected().get('absenrich_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function absenrich_reset_form(){
		absen_enrich_custField.reset();
		absen_enrich_custField.setValue(null);

		absen_enrich_tglField.reset();
		absen_enrich_tglField.setValue(today);
		absen_enrich_keteranganField.reset();
		absen_enrich_keteranganField.setValue(null);
		absen_enrich_statusField.reset();
		absen_enrich_statusField.setValue(null);
		absen_enrich_classField.reset();
		absen_enrich_classField.setValue(null);

		absenrich_checkpengantar1Field.reset();
		absenrich_checkpengantar1Field.setValue(null);
		absenrich_displayPengantar1Field.reset();
		absenrich_displayPengantar1Field.setValue(null);
		absenrich_nama_pengantar1Field.reset();
		absenrich_nama_pengantar1Field.setValue(null);
		absenrich_filepengantar1Field.reset();
		absenrich_filepengantar1Field.setValue(null);

		absenrich_checkpengantar2Field.reset();
		absenrich_checkpengantar2Field.setValue(null);
		absenrich_displayPengantar2Field.reset();
		absenrich_displayPengantar2Field.setValue(null);
		absenrich_nama_pengantar2Field.reset();
		absenrich_nama_pengantar2Field.setValue(null);
		absenrich_filepengantar2Field.reset();
		absenrich_filepengantar2Field.setValue(null);

		absenrich_checkpengantar3Field.reset();
		absenrich_checkpengantar3Field.setValue(null);
		absenrich_displayPengantar3Field.reset();
		absenrich_displayPengantar3Field.setValue(null);
		absenrich_nama_pengantar3Field.reset();
		absenrich_nama_pengantar3Field.setValue(null);
		absenrich_filepengantar3Field.reset();
		absenrich_filepengantar3Field.setValue(null);

		absenrich_checkpengantar4Field.reset();
		absenrich_checkpengantar4Field.setValue(null);
		absenrich_displayPengantar4Field.reset();
		absenrich_displayPengantar4Field.setValue(null);
		absenrich_nama_pengantar4Field.reset();
		absenrich_nama_pengantar4Field.setValue(null);
		absenrich_filepengantar4Field.reset();
		absenrich_filepengantar4Field.setValue(null);

		absenrich_checkpengantar5Field.reset();
		absenrich_checkpengantar5Field.setValue(null);
		absenrich_displayPengantar5Field.reset();
		absenrich_displayPengantar5Field.setValue(null);
		absenrich_nama_pengantar5Field.reset();
		absenrich_nama_pengantar5Field.setValue(null);
		absenrich_filepengantar5Field.reset();
		absenrich_filepengantar5Field.setValue(null);

	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function absenrich_set_form(){
		absen_enrich_custField.setValue(absen_enrichListEditorGrid.getSelectionModel().getSelected().get('cust_nama'));
		absen_enrich_tglField.setValue(absen_enrichListEditorGrid.getSelectionModel().getSelected().get('absenrich_tgl'));
		absen_enrich_classField.setValue(absen_enrichListEditorGrid.getSelectionModel().getSelected().get('absenrich_class'));
		absen_enrich_keteranganField.setValue(absen_enrichListEditorGrid.getSelectionModel().getSelected().get('absenrich_keterangan'));
		absen_enrich_statusField.setValue(absen_enrichListEditorGrid.getSelectionModel().getSelected().get('absenrich_status'));
		absenrich_nama_pengantar1Field.setValue(absen_enrichListEditorGrid.getSelectionModel().getSelected().get('absenrich_pengantar1'));
		absenrich_nama_pengantar2Field.setValue(absen_enrichListEditorGrid.getSelectionModel().getSelected().get('absenrich_pengantar2'));
		absenrich_nama_pengantar3Field.setValue(absen_enrichListEditorGrid.getSelectionModel().getSelected().get('absenrich_pengantar3'));
		absenrich_nama_pengantar4Field.setValue(absen_enrichListEditorGrid.getSelectionModel().getSelected().get('absenrich_pengantar4'));
		absenrich_nama_pengantar5Field.setValue(absen_enrichListEditorGrid.getSelectionModel().getSelected().get('absenrich_pengantar5'));
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_absensi_enrichment_form_valid(){
		return (absen_enrich_custField.isValid());
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
			absen_enrichCreateForm.render();
			absen_post2db='CREATE';
			msg='created';
			absenrich_reset_form();
			absen_enrich_CreateWindow.hide();
			// absen_enrich_CreateWindow.toFront();
		
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function absenrich_confirm_delete(){
		if(absen_enrichListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', absenrich_delete);
		} else if(absen_enrichListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', absenrich_delete);
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
	function absenrich_confirm_update(){
		/* only one record is selected here */
		if(absen_enrichListEditorGrid.selModel.getCount() == 1) {
			absen_post2db='UPDATE';
			msg='updated';
			absenrich_set_form();
			absen_enrich_CreateWindow.hide();
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
	function absenrich_delete(btn){
		if(btn=='yes'){
			var selections = absen_enrichListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< absen_enrichListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.absenrich_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_absensi_enrichment&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							absen_enrich_DataStore.reload();
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
	absen_enrich_DataStore = new Ext.data.Store({
		id: 'absen_enrich_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_absensi_enrichment&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit:absen_pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'absenrich_id'
		},[
			{name: 'absenrich_id', type: 'int', mapping: 'absenrich_id'},
			{name: 'absenrich_cust', type: 'string', mapping: 'absenrich_cust'},
			{name: 'absenrich_class', type: 'string', mapping: 'absenrich_class'},
			{name: 'absenrich_tgl', type: 'date', dateFormat: 'Y-m-d', mapping: 'absenrich_tgl'},
			{name: 'absenrich_keterangan', type: 'string', mapping: 'absenrich_keterangan'},
			{name: 'absenrich_pengantar1', type: 'string', mapping: 'absenrich_pengantar1'},
			{name: 'absenrich_pengantar2', type: 'string', mapping: 'absenrich_pengantar2'},
			{name: 'absenrich_pengantar3', type: 'string', mapping: 'absenrich_pengantar3'},
			{name: 'absenrich_pengantar4', type: 'string', mapping: 'absenrich_pengantar4'},
			{name: 'absenrich_pengantar5', type: 'string', mapping: 'absenrich_pengantar5'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'absenrich_status', type: 'string', mapping: 'absenrich_status'},
			{name: 'absenrich_creator', type: 'string', mapping: 'absenrich_creator'},
			{name: 'absenrich_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'absenrich_date_create'},
			{name: 'absenrich_updater', type: 'string', mapping: 'absenrich_updater'},
			{name: 'absenrich_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'absenrich_date_update'},
			{name: 'absenrich_bataler', type: 'string', mapping: 'absenrich_bataler'}
		]),
		sortInfo:{field: 'absenrich_cust', direction: "ASC"}
	});
	/* End of Function */
    
	/* Function for Retrieve DataStore Customer/Student/Baby */
	cbo_customer_absenrich_DataStore = new Ext.data.Store({
		id: 'cbo_customer_absenrich_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_absensi_enrichment&m=get_customer_list', 
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

	 var customer_absenrich_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{cust_no} : {cust_nama}</b><br /></span>',
            '{cust_alamat} | {cust_telprumah}<br>',
			'Tgl-Lahir:{cust_tgllahir:date("j M Y")}',
        '</div></tpl>'
    );

	 absenrich_datapengantarloadDataStore = new Ext.data.Store({
		id: 'absenrich_datapengantarloadDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_absensi_enrichment&m=get_info_data_pengantar', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cust_id'
		},[
		/* dataIndex => insert intotbl_usersColumnModel, Mapping => for initiate table column */ 
			{name: 'cust_id', type: 'int', mapping: 'cust_id'},
			{name: 'class_nama', type: 'string', mapping: 'class_name'},
			{name: 'cust_image_pengantar1', type: 'string', mapping: 'cust_image_pengantar1'},
			{name: 'cust_nama_pengantar1', type: 'string', mapping: 'cust_nama_pengantar1'},
			{name: 'cust_image_pengantar2', type: 'string', mapping: 'cust_image_pengantar2'},
			{name: 'cust_nama_pengantar2', type: 'string', mapping: 'cust_nama_pengantar2'},
			{name: 'cust_image_pengantar3', type: 'string', mapping: 'cust_image_pengantar3'},
			{name: 'cust_nama_pengantar3', type: 'string', mapping: 'cust_nama_pengantar3'},
			{name: 'cust_image_pengantar4', type: 'string', mapping: 'cust_image_pengantar4'},
			{name: 'cust_nama_pengantar4', type: 'string', mapping: 'cust_nama_pengantar4'},
			{name: 'cust_image_pengantar5', type: 'string', mapping: 'cust_image_pengantar5'},
			{name: 'cust_nama_pengantar5', type: 'string', mapping: 'cust_nama_pengantar5'},
			{name: 'member_valid', type: 'date', dateFormat: 'Y-m-d', mapping: 'member_valid'}, 
			{name: 'cust_priority_star' , type: 'string', mapping: 'cust_priority_star'}
		]),
		sortInfo:{field: 'cust_id', direction: "ASC"}
	});


  	/* Function for Identify of Window Column Model */
	absen_enrich_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'absenrich_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: '<div align="center">' + 'Tanggal Hadir' + '</div>',
			dataIndex: 'absenrich_tgl',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d')
		},
		{
			header: '<div align="center">' + 'Nama Customer/Baby' + '</div>',
			dataIndex: 'cust_nama',
			width: 120,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Class' + '</div>',
			dataIndex: 'absenrich_class',
			width: 200,
			sortable: true
		},

		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'absenrich_keterangan',
			width: 200,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Pengantar 1' + '</div>',
			dataIndex: 'absenrich_pengantar1',
			width: 120,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Pengantar 2' + '</div>',
			dataIndex: 'absenrich_pengantar2',
			width: 120,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Pengantar 3' + '</div>',
			dataIndex: 'absenrich_pengantar3',
			width: 120,
			sortable: true
		},
		{
			header: 'Creator',
			dataIndex: 'absenrich_creator',
			width: 150,
			sortable: true,
			hidden: true
		},
		{
			header: 'Create on',
			dataIndex: 'absenrich_date_create',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden: true
		},
		{
			header: 'Last Update by',
			dataIndex: 'absenrich_updater',
			width: 150,
			sortable: true,
			hidden: true
		},
		{
			header: 'Last Update on',
			dataIndex: 'absenrich_date_update',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden: true
		},
		{
			header: 'Bataler',
			dataIndex: 'absenrich_bataler',
			width: 150,
			sortable: true,
			hidden: true
		}]
	);
	absen_enrich_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	absen_enrichListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'absen_enrichListEditorGrid',
		el: 'fp_absen_enrichment',
		title: 'Daftar Absensi Enrichment',
		autoHeight: true,
		store: absen_enrich_DataStore, // DataStore
		cm: absen_enrich_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 800,
		bbar: new Ext.PagingToolbar({
			pageSize: absen_pageS,
			store: absen_enrich_DataStore,
			displayInfo: true
		}),
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_ABSEN_ENRICH'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_ABSEN_ENRICH'))){ ?>
		/*
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: absenrich_confirm_update   // Confirm before updating
		},
		*/
		 '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_ABSEN_ENRICH'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: absenrich_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		/*
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		},
		*/
		 '-', 
			new Ext.app.SearchField({
			store: absen_enrich_DataStore,
			params: {task: 'LIST',start: 0, limit: absen_pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						absen_enrich_DataStore.baseParams={task:'LIST',start: 0, limit: absen_pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- Nama Customer/Baby<br>- Lokasi<br>- Keterangan'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: absenrich_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: absenrich_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: absenrich_print  
		}
		]
	});
	absen_enrichListEditorGrid.render();
	/* End of DataStore */
     
	function show_windowGrid(){
		absen_enrich_DataStore.load({
			params: {start: 0, limit: absen_pageS},
			callback: function(opts, success, response){
				if(success){
					absen_enrich_CreateWindow.show();
				}
			}
		});	// load DataStore
	}


	/* Create Context Menu */
	absen_enrich_ContextMenu = new Ext.menu.Menu({
		id: 'absenrich_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_ABSEN_ENRICH'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: absenrich_confirm_update 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_ABSEN_ENRICH'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: absenrich_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: absenrich_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: absenrich_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onabsenrich_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		absen_enrich_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		absen_enrich_SelectedRow=rowIndex;
		absen_enrich_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function absenrich_editContextMenu(){
      absen_enrichListEditorGrid.startEditing(absen_enrich_SelectedRow,1);
  	}
	/* End of Function */
  	
	absen_enrichListEditorGrid.addListener('rowcontextmenu', onabsenrich_ListEditGridContextMenu);
	absen_enrich_DataStore.load({params: {start: 0, limit: absen_pageS}});	// load DataStore
	absen_enrichListEditorGrid.on('afteredit', absenrich_update); // inLine Editing Record
	
	absen_enrich_custField= new Ext.form.ComboBox({
		id: 'absen_enrich_custField',
		fieldLabel: 'Student/Baby',
		store: cbo_customer_absenrich_DataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
		forceSelection: true,
        typeAhead: false,
        hasfocus : true,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_absenrich_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '65%'
		//hidden: true
	});

	/* Identify Absen Enrich Tanggal Field */
	absen_enrich_tglField= new Ext.form.DateField({
		id: 'absen_enrich_tglField',
		fieldLabel: 'Tanggal Hadir',
		format : 'd-m-Y',
		width : 100
	});

	/* Identify Absen Enrich Class Field */
	absen_enrich_classField= new Ext.form.TextField({
		id: 'absen_enrich_classField',
		fieldLabel: 'Class',
		maxLength: 250,
		readOnly : true,
		anchor: '50%'
	});

	/* Identify Absen Enrich Keterangan Field */
	absen_enrich_keteranganField= new Ext.form.TextArea({
		id: 'absen_enrich_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '80%'
	});
	/* Identify Absen Enrich Status Field */
	absen_enrich_statusField= new Ext.form.ComboBox({
		id: 'absen_enrich_statusField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['absen_status_value', 'absen_status_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		editable:false,
		displayField: 'absen_status_display',
		valueField: 'absen_status_value',
		emptyText: 'Aktif',
		width: 80,
		triggerAction: 'all'	
	});
	
  	/*identify Pengantar Nama 1 Field */
	absenrich_nama_pengantar1Field= new Ext.form.TextField({
		id: 'absenrich_nama_pengantar1Field',
		fieldLabel: 'Nama Pengantar 1',
		maxLength: 250,
		readOnly : true,
		anchor: '75%'
	});
	absenrich_checkpengantar1Field=new Ext.form.Checkbox({
		id: 'absenrich_checkpengantar1Field',
		boxLabel: 'Check True',
		enableKeyEvents : true
	});
	absenrich_filepengantar1Field = new Ext.form.FileUploadField({
        fieldLabel : 'Upload Image',
        width: 250,
        hidden : true,
        enableKeyEvents: true
    });
	absenrich_displayPengantar1Field = new Ext.form.DisplayField({
		fieldLabel : 'Display 1',
		height : 150,
		enableKeyEvents: true
	});

	/*identify Pengantar Nama 2 Field */
	absenrich_nama_pengantar2Field= new Ext.form.TextField({
		id: 'absenrich_nama_pengantar2Field',
		fieldLabel: 'Nama Pengantar 2',
		maxLength: 250,
		readOnly : true,
		anchor: '75%'
	});
	absenrich_checkpengantar2Field=new Ext.form.Checkbox({
		// id: 'check_update',
		boxLabel: 'Check True',
		enableKeyEvents : true
	});
	absenrich_filepengantar2Field = new Ext.form.FileUploadField({
        fieldLabel : 'Upload Image',
        width: 250,
        hidden : true,
        enableKeyEvents: true
    });
	absenrich_displayPengantar2Field = new Ext.form.DisplayField({
		fieldLabel : 'Display 2',
		height : 150,
		enableKeyEvents: true
	});

	/*identify Pengantar Nama 3 Field */
	absenrich_nama_pengantar3Field= new Ext.form.TextField({
		id: 'absenrich_nama_pengantar3Field',
		fieldLabel: 'Nama Pengantar 3',
		maxLength: 250,
		readOnly : true,
		anchor: '75%'
	});
	absenrich_checkpengantar3Field=new Ext.form.Checkbox({
		// id: 'check_update',
		boxLabel: 'Check True',
		enableKeyEvents : true
	});
	absenrich_filepengantar3Field = new Ext.form.FileUploadField({
        fieldLabel : 'Upload Image',
        width: 250,
        hidden : true,
        enableKeyEvents: true
    });
	absenrich_displayPengantar3Field = new Ext.form.DisplayField({
		fieldLabel : 'Display 3',
		height : 150,
		enableKeyEvents: true
	});

	/*identify Pengantar Nama 4 Field */
	absenrich_nama_pengantar4Field= new Ext.form.TextField({
		id: 'absenrich_nama_pengantar4Field',
		fieldLabel: 'Nama Pengantar 4',
		maxLength: 250,
		readOnly : true,
		anchor: '75%'
	});
	absenrich_checkpengantar4Field=new Ext.form.Checkbox({
		// id: 'check_update',
		boxLabel: 'Check True',
		enableKeyEvents : true
	});
	absenrich_filepengantar4Field = new Ext.form.FileUploadField({
        fieldLabel : 'Upload Image',
        width: 250,
        hidden : true,
        enableKeyEvents: true
    });
	absenrich_displayPengantar4Field = new Ext.form.DisplayField({
		fieldLabel : 'Display 4',
		height : 150,
		enableKeyEvents: true
	});

	/*identify Pengantar Nama 5 Field */
	absenrich_nama_pengantar5Field= new Ext.form.TextField({
		id: 'absenrich_nama_pengantar5Field',
		fieldLabel: 'Nama Pengantar 5',
		maxLength: 250,
		readOnly : true,
		anchor: '75%'
	});
	absenrich_checkpengantar5Field=new Ext.form.Checkbox({
		// id: 'check_update',
		boxLabel: 'Check True',
		enableKeyEvents : true
	});
	absenrich_filepengantar5Field = new Ext.form.FileUploadField({
        fieldLabel : 'Upload Image',
        width: 250,
        hidden : true,
        enableKeyEvents: true
    });
	absenrich_displayPengantar5Field = new Ext.form.DisplayField({
		fieldLabel : 'Display 5',
		height : 150,
		enableKeyEvents: true
	});

	absenrich_data_pengantarGroupField = new Ext.form.FieldSet({
		title: 'Data Pengantar',
		autoHeight: true,
		// defaultType: 'textfield',
		// anchor: '95%',
		layout : 'column',
		items : 
		[
					{
						columnWidth:0.5,
						layout: 'form',
						border:false,
						labelAlign: 'left',
						labelWidth: 120,
						items: [absenrich_checkpengantar1Field, absenrich_displayPengantar1Field,absenrich_nama_pengantar1Field, {height : 50}, absenrich_checkpengantar3Field, absenrich_displayPengantar3Field,absenrich_nama_pengantar3Field,  {height : 50},absenrich_checkpengantar5Field, absenrich_displayPengantar5Field,absenrich_nama_pengantar5Field  ] 
					},
					{
						columnWidth:0.5,
						layout: 'form',
						labelAlign: 'left',
						labelWidth: 120,
						border:false,
						items: [absenrich_checkpengantar2Field, absenrich_displayPengantar2Field,absenrich_nama_pengantar2Field,  {height : 50},absenrich_checkpengantar4Field, absenrich_displayPengantar4Field,absenrich_nama_pengantar4Field,] 
					}
		]
	});

	/* Function for retrieve create Window Panel*/ 
	absen_enrichCreateForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		el: 'form_absenrich_create',
		// autoHeight:true,
		height: 975,
		width: 850, 
		frame : true,       
		items: [absen_enrich_custField,absen_enrich_classField, absen_enrich_tglField, absen_enrich_keteranganField, absenrich_data_pengantarGroupField],
		buttons: [

			{
				text: '<span style="font-weight:bold">List Absensi</span>',
				handler: show_windowGrid
			},

			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_ABSEN_ENRICH'))){ ?>
			{
				text: '<span style="font-weight:bold">Save and Close</span>',
				handler: absensi_enrichment_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					absenrich_reset_form();
					absen_enrich_CreateWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	absen_enrich_CreateWindow= new Ext.Window({
		id: 'absen_enrich_CreateWindow',
		title: absen_post2db+'Absensi Enrichment',
		closable:true,
		closeAction: 'hide',
		width: 800,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_absen_enrich_create',
		items: absen_enrichListEditorGrid
	});
	/* End Window */
	
	
	/* Function for action list search */
	function absenrich_list_search(){
		// render according to a SQL date format.
		var gudang_id_search=null;
		var gudang_nama_search=null;
		var gudang_lokasi_search=null;
		var gudang_keterangan_search=null;
		var gudang_aktif_search=null;


		if(absen_idSearchField.getValue()!==null){gudang_id_search=absen_idSearchField.getValue();}
		if(absen_enrich_custSearchField.getValue()!==null){gudang_nama_search=absen_enrich_custSearchField.getValue();}
		if(absen_enrich_tglSearchField.getValue()!==null){gudang_lokasi_search=absen_enrich_tglSearchField.getValue();}
		if(absen_enrich_keteranganSearchField.getValue()!==null){gudang_keterangan_search=absen_enrich_keteranganSearchField.getValue();}
		if(absen_enrich_statusSearchField.getValue()!==null){gudang_aktif_search=absen_enrich_statusSearchField.getValue();}

		// change the store parameters
		absen_enrich_DataStore.baseParams = {
			task: 'SEARCH',
			start: 0,
			limit: absen_pageS,
			absenrich_id			:	gudang_id_search, 
			absenrich_cust			:	gudang_nama_search, 
			absenrich_tgl			:	gudang_lokasi_search, 
			absenrich_keterangan	:	gudang_keterangan_search, 
			absenrich_status		:	gudang_aktif_search
	};
		// Cause the datastore to do another query : 
		absen_enrich_DataStore.reload({params: {start: 0, limit: absen_pageS}});
	}
		
	/* Function for reset search result */
	function absenrich_reset_search(){
		// reset the store parameters
		absen_enrich_DataStore.baseParams = { task: 'LIST', start:0, limit:absen_pageS };
		absen_enrich_DataStore.reload({params: {start: 0, limit: absen_pageS}});
		//absen_enrich_SearchWindow.close();
	};
	/* End of Fuction */
	
	function gudang_reset_SearchForm(){
		absen_enrich_custSearchField.reset();
		absen_enrich_tglSearchField.reset();
		absen_enrich_keteranganSearchField.reset();
		absen_enrich_statusSearchField.reset();
	}
	
	/* Field for search */
	/* Identify  absenrich_id Search Field */
	absen_idSearchField= new Ext.form.NumberField({
		id: 'absen_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  absenrich_cust Search Field */
	absen_enrich_custSearchField= new Ext.form.TextField({
		id: 'absen_enrich_custSearchField',
		fieldLabel: 'Nama Customer/Baby',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  absenrich_tgl Search Field */
	absen_enrich_tglSearchField= new Ext.form.TextField({
		id: 'absen_enrich_tglSearchField',
		fieldLabel: 'Lokasi',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  absenrich_keterangan Search Field */
	absen_enrich_keteranganSearchField= new Ext.form.TextField({
		id: 'absen_enrich_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '80%'
	
	});
	/* Identify  absenrich_status Search Field */
	absen_enrich_statusSearchField= new Ext.form.ComboBox({
		id: 'absen_enrich_statusSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['value', 'absenrich_status'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		displayField: 'absenrich_status',
		valueField: 'value',
		emptyText: 'Aktif',
		width: 80,
		triggerAction: 'all'	 
	
	});
	    
	/* Function for retrieve search Form Panel */
	absen_enrich_SearchForm = new Ext.FormPanel({
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
				items: [absen_enrich_custSearchField, absen_enrich_tglSearchField, absen_enrich_keteranganSearchField, absen_enrich_statusSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: absenrich_list_search
			},{
				text: 'Close',
				handler: function(){
					absen_enrich_SearchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	absen_enrich_SearchWindow = new Ext.Window({
		title: 'Pencarian Absensi Enrichment',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_absen_enrich_search',
		items: absen_enrich_SearchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!absen_enrich_SearchWindow.isVisible()){
			gudang_reset_SearchForm();
			absen_enrich_SearchWindow.show();
		} else {
			absen_enrich_SearchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function absenrich_print(){
		var searchquery = "";
		var gudang_nama_print=null;
		var gudang_lokasi_print=null;
		var gudang_keterangan_print=null;
		var gudang_aktif_print=null;
		var win;              
		// check if we do have some search data...
		if(absen_enrich_DataStore.baseParams.query!==null){searchquery = absen_enrich_DataStore.baseParams.query;}
		if(absen_enrich_DataStore.baseParams.absenrich_cust!==null){gudang_nama_print = absen_enrich_DataStore.baseParams.absenrich_cust;}
		if(absen_enrich_DataStore.baseParams.absenrich_tgl!==null){gudang_lokasi_print = absen_enrich_DataStore.baseParams.absenrich_tgl;}
		if(absen_enrich_DataStore.baseParams.absenrich_keterangan!==null){gudang_keterangan_print = absen_enrich_DataStore.baseParams.absenrich_keterangan;}
		if(absen_enrich_DataStore.baseParams.absenrich_status!==null){gudang_aktif_print = absen_enrich_DataStore.baseParams.absenrich_status;}
		

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_absensi_enrichment&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		
			absenrich_cust : gudang_nama_print,
			absenrich_tgl : gudang_lokasi_print,
			absenrich_keterangan : gudang_keterangan_print,
			absenrich_status : gudang_aktif_print,
		  	currentlisting: absen_enrich_DataStore.baseParams.task // this tells us if we are searching or not
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
	function absenrich_export_excel(){
		var searchquery = "";
		var gudang_nama_2excel=null;
		var gudang_lokasi_2excel=null;
		var gudang_keterangan_2excel=null;
		var gudang_aktif_2excel=null;
		var win;              
		// check if we do have some search data...
		if(absen_enrich_DataStore.baseParams.query!==null){searchquery = absen_enrich_DataStore.baseParams.query;}
		if(absen_enrich_DataStore.baseParams.absenrich_cust!==null){gudang_nama_2excel = absen_enrich_DataStore.baseParams.absenrich_cust;}
		if(absen_enrich_DataStore.baseParams.absenrich_tgl!==null){gudang_lokasi_2excel = absen_enrich_DataStore.baseParams.absenrich_tgl;}
		if(absen_enrich_DataStore.baseParams.absenrich_keterangan!==null){gudang_keterangan_2excel = absen_enrich_DataStore.baseParams.absenrich_keterangan;}
		if(absen_enrich_DataStore.baseParams.absenrich_status!==null){gudang_aktif_2excel = absen_enrich_DataStore.baseParams.absenrich_status;}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_absensi_enrichment&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		
			absenrich_cust : gudang_nama_2excel,
			absenrich_tgl : gudang_lokasi_2excel,
			absenrich_keterangan : gudang_keterangan_2excel,
			absenrich_status : gudang_aktif_2excel,
		  	currentlisting: absen_enrich_DataStore.baseParams.task // this tells us if we are searching or not
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

	absen_enrichCreateForm.render();
	absen_enrich_tglField.setValue(today);

	/*Event Event */
	absen_enrich_custField.on("select",function(){
		var cust_id=absen_enrich_custField.getValue();
		if(cust_id!==0){
			absenrich_datapengantarloadDataStore.load({
					params : { cust_id: cust_id},
					callback: function(opts, success, response){
						 if (success) {
							if(absenrich_datapengantarloadDataStore.getCount()){
								absenrich_record_temp=absenrich_datapengantarloadDataStore.getAt(0).data;
								absen_enrich_classField.setValue(absenrich_record_temp.class_nama);	

								// Menampilkan Data Pengantar 1
								absenrich_filepengantar1Field.setValue(absenrich_record_temp.cust_image_pengantar1);
								absenrich_nama_pengantar1Field.setValue(absenrich_record_temp.cust_nama_pengantar1);	
								temp_pengantar1 = '';
								temp_pengantar1 += '<img src="./photos/';
								temp_pengantar1 += absenrich_filepengantar1Field.getValue();
								temp_pengantar1 += '" alt="Thumbnail" width="150" height="150"/>';
								absenrich_displayPengantar1Field.setValue(temp_pengantar1);

								// Menampilkan Data Pengantar 2
								absenrich_filepengantar2Field.setValue(absenrich_record_temp.cust_image_pengantar2);
								absenrich_nama_pengantar2Field.setValue(absenrich_record_temp.cust_nama_pengantar2);	
								temp_pengantar2 = '';
								temp_pengantar2 += '<img src="./photos/';
								temp_pengantar2 += absenrich_filepengantar2Field.getValue();
								temp_pengantar2 += '" alt="Thumbnail" width="150" height="150"/>';
								absenrich_displayPengantar2Field.setValue(temp_pengantar2);

								// Menampilkan Data Pengantar 3
								absenrich_filepengantar3Field.setValue(absenrich_record_temp.cust_image_pengantar3);
								absenrich_nama_pengantar3Field.setValue(absenrich_record_temp.cust_nama_pengantar3);	
								temp_pengantar3 = '';
								temp_pengantar3 += '<img src="./photos/';
								temp_pengantar3 += absenrich_filepengantar3Field.getValue();
								temp_pengantar3 += '" alt="Thumbnail" width="150" height="150"/>';
								absenrich_displayPengantar3Field.setValue(temp_pengantar3);

								// Menampilkan Data Pengantar 4
								absenrich_filepengantar4Field.setValue(absenrich_record_temp.cust_image_pengantar4);
								absenrich_nama_pengantar4Field.setValue(absenrich_record_temp.cust_nama_pengantar4);	
								temp_pengantar4 = '';
								temp_pengantar4 += '<img src="./photos/';
								temp_pengantar4 += absenrich_filepengantar4Field.getValue();
								temp_pengantar4 += '" alt="Thumbnail" width="150" height="150"/>';
								absenrich_displayPengantar4Field.setValue(temp_pengantar4);

								// Menampilkan Data Pengantar 5
								absenrich_filepengantar5Field.setValue(absenrich_record_temp.cust_image_pengantar5);
								absenrich_nama_pengantar5Field.setValue(absenrich_record_temp.cust_nama_pengantar5);	
								temp_pengantar5 = '';
								temp_pengantar5 += '<img src="./photos/';
								temp_pengantar5 += absenrich_filepengantar5Field.getValue();
								temp_pengantar5 += '" alt="Thumbnail" width="150" height="150"/>';
								absenrich_displayPengantar5Field.setValue(temp_pengantar5);
							}
							else{
								absen_enrich_classField.setValue("");
							}
						}
					}
			}); 
		}	
	});

	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_absen_enrichment"></div>
		<div id="elwindow_absen_enrich_create"></div>
        <div id="elwindow_absen_enrich_search"></div>
        <div id="form_absenrich_create"></div>
    </div>
</div>
</body>