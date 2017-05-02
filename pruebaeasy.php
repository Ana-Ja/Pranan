<h2>Row Editing in DataGrid</h2>
  <p>Click the row to start editing.</p>
  <div style="margin:20px 0;"></div>

  <table id="dg" class="easyui-datagrid" title="Row Editing in DataGrid" style="width:700px;height:auto"
      data-options="
        iconCls: 'icon-edit',
        singleSelect: true,
        toolbar: '#tb',
        url: 'datagrid_data1.json',
        method: 'get',
        onClickCell: onClickCell,
        onEndEdit: onEndEdit
      ">
    <thead>
      <tr>
        <th data-options="field:'itemid',width:80">Item ID</th>
        <th data-options="field:'productid',width:100,
            formatter:function(value,row){
              return row.productname;
            },
            editor:{
              type:'combobox',
              options:{
                valueField:'productid',
                textField:'productname',
                method:'get',
                url:'products.json',
                required:true
              }
            }">Product</th>
        <th data-options="field:'listprice',width:80,align:'right',editor:{type:'numberbox',options:{precision:1}}">List Price</th>
        <th data-options="field:'unitcost',width:80,align:'right',editor:'numberbox'">Unit Cost</th>
        <th data-options="field:'attr1',width:250,editor:'textbox'">Attribute</th>
        <th data-options="field:'status',width:60,align:'center',editor:{type:'checkbox',options:{on:'P',off:''}}">Status</th>
      </tr>
    </thead>
  </table>

  <div id="tb" style="height:auto">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="append()">Append</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeit()">Remove</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="accept()">Accept</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="reject()">Reject</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:true" onclick="getChanges()">GetChanges</a>
  </div>

  <script type="text/javascript">
    var editIndex = undefined;
    function endEditing(){
      if (editIndex == undefined){return true}
      if ($('#dg').datagrid('validateRow', editIndex)){
        $('#dg').datagrid('endEdit', editIndex);
        editIndex = undefined;
        return true;
      } else {
        return false;
      }
    }
    function onClickCell(index, field){
      if (editIndex != index){
        if (endEditing()){
          $('#dg').datagrid('selectRow', index)
              .datagrid('beginEdit', index);
          var ed = $('#dg').datagrid('getEditor', {index:index,field:field});
          if (ed){
            ($(ed.target).data('textbox') ? $(ed.target).textbox('textbox') : $(ed.target)).focus();
          }
          editIndex = index;
        } else {
          setTimeout(function(){
            $('#dg').datagrid('selectRow', editIndex);
          },0);
        }
      }
    }
    function onEndEdit(index, row){
      var ed = $(this).datagrid('getEditor', {
        index: index,
        field: 'productid'
      });
      row.productname = $(ed.target).combobox('getText');
    }
    function append(){
      if (endEditing()){
        $('#dg').datagrid('appendRow',{status:'P'});
        editIndex = $('#dg').datagrid('getRows').length-1;
        $('#dg').datagrid('selectRow', editIndex)
            .datagrid('beginEdit', editIndex);
      }
    }
    function removeit(){
      if (editIndex == undefined){return}
      $('#dg').datagrid('cancelEdit', editIndex)
          .datagrid('deleteRow', editIndex);
      editIndex = undefined;
    }
    function accept(){
      if (endEditing()){
        $('#dg').datagrid('acceptChanges');
      }
    }
    function reject(){
      $('#dg').datagrid('rejectChanges');
      editIndex = undefined;
    }
    function getChanges(){
      var rows = $('#dg').datagrid('getChanges');
      alert(rows.length+' rows are changed!');
    }
  </script>