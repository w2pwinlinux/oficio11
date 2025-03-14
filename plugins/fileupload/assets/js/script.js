var cuenta =0;
$(function(){

    var ul = $('#upload ul');

    $('#drop a').click(function(){
        // Simulate a click on the file input button
        // to show the file browser dialog
        $(this).parent().find('input').click();
    });

    // Initialize the jQuery File Upload plugin
    $('#upload').fileupload({

        // This element will accept file drag/drop uploading
        dropZone: $('#drop'),

        // This function is called when a file is added to the queue;
        // either via the browse button, or via drag/drop:
        add: function (e, data) {
			gdata = data;

			//var n=str.indexOf("success");
			//if (cuenta==0){
			if (true){

			var aux1 = data.files[0].name;
			//console.log(aux1);
			var n=aux1.indexOf("xls","xlsx");
			n= n+3;
//			console.log(n);
//			console.log(aux1.length);
			//if (n==aux1.length){
			if (true){
			
			var tpl = $('<li class="working"><input type="text" value="0" data-width="48" data-height="48"'+
                ' data-fgColor="#0788a5" data-readOnly="1" data-bgColor="#3e4043" /><p></p><span></span></li>');

            // Append the file name and file size
			///console.log(data.files[0].name);
			//            str=gdata.jqXHR;//.responseText;
			//console.log(str);
			var registro = "UPLOADS/"+data.files[0].name+".txt";
            tpl.find('p').text(data.files[0].name).append('<i>' + formatFileSize(data.files[0].size) + '</i>'+'<i><a href="'+registro+'" target ="_blank" >Reg Subida</a></i>'+'<div id="cerrar" onClick="javascript:cerrar()">CERRAR</div>');//wilson
			//window.close();
			
            // Add the HTML to the UL element
            data.context = tpl.appendTo(ul);//wilson

            // Initialize the knob plugin
            tpl.find('input').knob();

            // Listen for clicks on the cancel icon
            tpl.find('span').click(function(){

                if(tpl.hasClass('working')){
                    jqXHR.abort();
                }

                tpl.fadeOut(function(){
                    tpl.remove();
                });

            });

            // Automatically upload the file once it is added to the queue
            var jqXHR = data.submit();
 //           var str=gdata.jqXHR.responseText;
//			console.log(str);
//			var n=str.indexOf("welcome");
//			console.log(n);
//			setTimeout("console.log(gdata.jqXHR.responseText)",2000);
			cuenta++;
//			var aux1 = data.jqXHR.responseText;
//			var n=aux1.indexOf("success");
//			console.log(n);
			}else{
				alert("Solo archivos tipo excel (.xls) ");	
			}
			

		}else{
			alert("Solo se puede subir un archivo ");
		}
			
        },

        progress: function(e, data){

            // Calculate the completion percentage of the upload
            var progress = parseInt(data.loaded / data.total * 100, 10);

            // Update the hidden input field and trigger a change
            // so that the jQuery knob plugin knows to update the dial
            data.context.find('input').val(progress).change();//wilson

            if(progress == 100){
                data.context.removeClass('working');
            }
			//console.log(data.jqXHR.responseText);
        },

        fail:function(e, data){
            // Something has gone wrong!
            data.context.addClass('error');
        }

    });


    // Prevent the default action when a file is dropped on the window
    $(document).on('drop dragover', function (e) {
        e.preventDefault();
    });

    // Helper function that formats the file sizes
    function formatFileSize(bytes) {
        if (typeof bytes !== 'number') {
            return '';
        }

        if (bytes >= 1000000000) {
            return (bytes / 1000000000).toFixed(2) + ' GB';
        }

        if (bytes >= 1000000) {
            return (bytes / 1000000).toFixed(2) + ' MB';
        }

        return (bytes / 1000).toFixed(2) + ' KB';
    }

});

function cerrar(){
	console.log("cerrar");
	
	window.close();
	
}
$(document).ready(function(e) {
    $("#cerrar").click(function(e) {
        cerrar();
    });
});