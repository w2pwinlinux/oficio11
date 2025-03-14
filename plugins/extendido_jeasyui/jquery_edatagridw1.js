/**
 * edatagrid - jQuery EasyUI
 * 
 * Licensed under the GPL:
 *   http://www.gnu.org/licenses/gpl.txt
 *
 * Copyright 2011 stworthy [ stworthy@gmail.com ] 
 * 
 * Dependencies:
 *   datagrid
 *   messager
 * 
 */
 var gdg;
(function($){
	function buildGrid(target){
		var opts = $.data(target, 'edatagrid').options;
		$(target).datagrid($.extend({}, opts, {
			onDblClickCell:function(index,field){
				
				//console.log("doble click");

				if (opts.editing){
					$(this).edatagrid('editRow', index);
					focusEditor(field);// add para el tamaño al editar
					//$(".datagrid-body .datagrid-editable .datagrid-editable-input").css("height","200px");// todos 
					$(".datagrid-body .datagrid-editable textarea").css("height","150px");// solo text area

				}
			},
			onClickCell:function(index,field){
				if (opts.editing && opts.editIndex >= 0){
					$(this).edatagrid('editRow', index);
					focusEditor(field);
				}
			},
			onAfterEdit: function(index, row){
				opts.editIndex = undefined;
				var url = row.isNewRecord ? opts.saveUrl : opts.updateUrl;
				//console.log(url);//la url de update o insert 
				//console.log(row);//la data
				//console.log(index)//el ultimo indice del grid
				
				if (url){
					$.post(url, row, function(data){
						//console.log(data);//resultado de la base 
						if (data.fila_afectada>=0){

							$.messager.show({title:"Info",msg:data.mensaje});
							$(gdg).datagrid('reload');
						}else{
							//console.log("no datos");
							//if (data.fila_afectada!=-2){
							$.messager.alert("Info-err",data.mensaje);		
							//}
							//if (data.fila_afectada!=-1){
							//	$.messager.alert("Info-err",data.mensaje);		
							//}
							
						}
						
						data.isNewRecord = null;
						$(target).datagrid('updateRow', {
							index: index,
							row: data
						});
						//console.log(data);
						
						//console.log(data);//se agrega a la data el isnewrecord
						//console.log(opts.tree);//algo graba
						if (opts.tree){
							var idValue = row[opts.idField||'id'];
							var t = $(opts.tree);
							var node = t.tree('find', idValue);
							if (node){
								node.text = row[opts.treeTextField];
								t.tree('update', node);
							} else {
								var pnode = t.tree('find', row[opts.treeParentField]);
								t.tree('append', {
									parent: (pnode ? pnode.target : null),
									data: [{id:idValue,text:row[opts.treeTextField]}]
								});
							}
						}
						//console.log(target);
						//console.log(index);
						//console.log(row);
						opts.onSave.call(target, index, row);
					},'json');
				} else {
					opts.onSave.call(target, index, row);
				}
				if (opts.onAfterEdit) opts.onAfterEdit.call(target, index, row);
			},
			onCancelEdit: function(index, row){
				opts.editIndex = undefined;
				if (row.isNewRecord) {
					$(this).datagrid('deleteRow', index);
				}
				if (opts.onCancelEdit) opts.onCancelEdit.call(target, index, row);
			},
			onBeforeLoad: function(param){
				//console.log(param);//parametors de paginas
				if (opts.onBeforeLoad.call(target, param) == false){return false}
				$(this).datagrid('rejectChanges');
				if (opts.tree){
					var node = $(opts.tree).tree('getSelected');
					param[opts.treeParentField] = node ? node.id : undefined;
				}
			}
		}));
		
		function focusEditor(field){
			var editor = $(target).datagrid('getEditor', {index:opts.editIndex,field:field});
			if (editor){
				editor.target.focus();
			} else {
				var editors = $(target).datagrid('getEditors', opts.editIndex);
				if (editors.length){
					editors[0].target.focus();
				}
			}
		}
		
		if (opts.tree){
			$(opts.tree).tree({
				url: opts.treeUrl,
				onClick: function(node){
					$(target).datagrid('load');
				},
				onDrop: function(dest,source,point){
					var targetId = $(this).tree('getNode', dest).id;
//					console.log(opts.treeDndUrl)
					$.ajax({
						url: opts.treeDndUrl,
						type:'post',
						data:{
							id:source.id,
							targetId:targetId,
							point:point
						},
						dataType:'json',
						success:function(){
							$(target).datagrid('load');
						}
					});
				}
			});
		}
	}
	
	$.fn.edatagrid = function(options, param){
		if (typeof options == 'string'){
			var method = $.fn.edatagrid.methods[options];
			if (method){
				return method(this, param);
			} else {
				return this.datagrid(options, param);
			}
		}
		
		options = options || {};
		return this.each(function(){
			var state = $.data(this, 'edatagrid');
			if (state){
				$.extend(state.options, options);
			} else {
				$.data(this, 'edatagrid', {
					options: $.extend({}, $.fn.edatagrid.defaults, $.fn.edatagrid.parseOptions(this), options)
				});
			}
			buildGrid(this);
		});
	};
	
	$.fn.edatagrid.parseOptions = function(target){
		return $.extend({}, $.fn.datagrid.parseOptions(target), {
		});
	};
	
	$.fn.edatagrid.methods = {
		options: function(jq){
			var opts = $.data(jq[0], 'edatagrid').options;
			return opts;
		},
		enableEditing: function(jq){
			return jq.each(function(){
				var opts = $.data(this, 'edatagrid').options;
				opts.editing = true;
			});
		},
		disableEditing: function(jq){
			return jq.each(function(){
				var opts = $.data(this, 'edatagrid').options;
				opts.editing = false;
			});
		},
		editRow: function(jq, index){
			return jq.each(function(){
				var dg = $(this);
				var opts = $.data(this, 'edatagrid').options;
				var editIndex = opts.editIndex;
				if (editIndex != index){
					if (dg.datagrid('validateRow', editIndex)){
						if (editIndex>=0){
							if (opts.onBeforeSave.call(this, editIndex) == false) {
								setTimeout(function(){
									dg.datagrid('selectRow', editIndex);
								},0);
								return;
							}
						}
						dg.datagrid('endEdit', editIndex);
						dg.datagrid('beginEdit', index);
						opts.editIndex = index;
						var rows = dg.datagrid('getRows');
						opts.onEdit.call(this, index, rows[index]);
					} else {
						setTimeout(function(){
							dg.datagrid('selectRow', editIndex);
						}, 0);
					}
				}
			});
		},
		addRow: function(jq){
			return jq.each(function(){
				var dg = $(this);
				gdg = $(this);
				//console.log(gdg);
				var opts = $.data(this, 'edatagrid').options;
				if (opts.editIndex >= 0){
					if (!dg.datagrid('validateRow', opts.editIndex)){
						dg.datagrid('selectRow', opts.editIndex);
						return;
					}
					if (opts.onBeforeSave.call(this, opts.editIndex) == false){
						setTimeout(function(){
							dg.datagrid('selectRow', opts.editIndex);
						},0);
						return;
					}
					dg.datagrid('endEdit', opts.editIndex);
				}
				dg.datagrid('appendRow', {isNewRecord:true});
				var rows = dg.datagrid('getRows');
				opts.editIndex = rows.length - 1;
				dg.datagrid('beginEdit', opts.editIndex);
				dg.datagrid('selectRow', opts.editIndex);
				
				if (opts.tree){
					var node = $(opts.tree).tree('getSelected');
					rows[opts.editIndex][opts.treeParentField] = (node ? node.id : 0);
				}
				
				opts.onAdd.call(this, opts.editIndex, rows[opts.editIndex]);
			});
		},
		saveRow: function(jq){
			//console.log(jq);
			return jq.each(function(){
				var dg = $(this);
				
				var opts = $.data(this, 'edatagrid').options;
				//console.log(opts);//
				//console.log(dg);//
				var rows = dg.datagrid('getRows');//toda la data
				//console.log(rows.length);//largo de la data
				//for (i=0;i<)
				if (opts.onBeforeSave.call(this, opts.editIndex) == false) {
					setTimeout(function(){
						dg.datagrid('selectRow', opts.editIndex);
					},0);
					return;
				}
				
				//console.log(this.url);
				//console.log(updateUrl);
				//console.log(opts.editIndex);
				$(this).datagrid('endEdit', opts.editIndex);
				$(this).datagrid('reload');
				
			});
		},
		cancelRow: function(jq){
			return jq.each(function(){
				var index = $(this).edatagrid('options').editIndex;
				$(this).datagrid('cancelEdit', index);
			});
		},
		destroyRow: function(jq){
			return jq.each(function(){
				var dg = $(this);
				var opts = $.data(this, 'edatagrid').options;
				var row = dg.datagrid('getSelected');
				if (!row){
					$.messager.show({
						title: opts.destroyMsg.norecord.title,
						msg: opts.destroyMsg.norecord.msg
					});
					return;
				}
				$.messager.confirm(opts.destroyMsg.confirm.title,opts.destroyMsg.confirm.msg,function(r){
					if (r){
						var index = dg.datagrid('getRowIndex', row);
						if (row.isNewRecord){
							dg.datagrid('cancelEdit', index);
						} else {
							if (opts.destroyUrl){
								var idValue = row[opts.idField||'ID_EXTRA'];
								$.post(opts.destroyUrl, {ID_EXTRA:idValue}, function(){
									if (opts.tree){
										dg.datagrid('reload');
										var t = $(opts.tree);
										var node = t.tree('find', idValue);
										if (node){
											t.tree('remove', node.target);
										}
									} else {
										dg.datagrid('cancelEdit', index);
										dg.datagrid('deleteRow', index);
									}
									opts.onDestroy.call(dg[0], index, row);
								});
							} else {
								dg.datagrid('cancelEdit', index);
								dg.datagrid('deleteRow', index);
								opts.onDestroy.call(dg[0], index, row);
							}
						}
					}
				});
			});
		}
	};
	
	$.fn.edatagrid.defaults = $.extend({}, $.fn.datagrid.defaults, {
		editing: true,
		editIndex: -1,
		destroyMsg:{
			norecord:{
				title:'Warning',
				msg:'No record is selected.'
			},
			confirm:{
				title:'Confirmar',
				msg:'Esta seguro de realizar esta operacion?'
			}
		},
//		destroyConfirmTitle: 'Confirm',
//		destroyConfirmMsg: 'Are you sure you want to delete?',
		
		url: null,	// return the datagrid data
		saveUrl: null,	// return the added row
		updateUrl: null,	// return the updated row
		destroyUrl: null,	// return {success:true}
		
		tree: null,		// the tree selector
		treeUrl: null,	// return tree data
		treeDndUrl: null,	// to process the drag and drop operation, return {success:true}
		treeTextField: 'name',
		treeParentField: 'parentId',
		
		onAdd: function(index, row){},
		onEdit: function(index, row){},
		onBeforeSave: function(index){},
		onSave: function(index, row){},
		onDestroy: function(index, row){}
	});
})(jQuery);