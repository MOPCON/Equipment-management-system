<html>
<body>
<div id="print" class="container-fluid spark-screen">
    <div id="print_parts" style="height: 29.6cm; width: 21cm; background-color: #00a7d0; position: absolute; left: 0; top: 0; bottom: 0; overflow: auto;">
        <div
             style="height: 2.48cm; width: 4.2cm; float: left; text-align: center; background-color: #00a65a">
            <br/>
            EQ00001


        </div>
    </div>
</div>
</body>
<script src="{{ asset('/js/jspdf.min.js') }}" charset="utf-8"></script>
<script src="https://cdn.rawgit.com/MrRio/jsPDF/master/libs/html2pdf.js" charset="utf-8"></script>
<script>
    var pdf = new jsPDF('p', 'pt', 'a4');
    pdf.canvas.height = 72 * 11;
    pdf.canvas.width = 72 * 8.5;
    html2pdf(document.getElementById("print_parts"), pdf, function (pdf) {
        var iframe = document.createElement('iframe');
        iframe.setAttribute('style', 'position:absolute;right:0; top:0; bottom:0; height:100%; width:500px');
        document.body.appendChild(iframe);
        iframe.src = pdf.output('datauristring');
    });
</script>
</html>
