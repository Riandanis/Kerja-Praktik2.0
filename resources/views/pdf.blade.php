    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.0.28/jspdf.plugin.autotable.js"></script>

<div id="ignorePDF">
</div>
<div id="content">
    <table class="table table-striped" id="basic-table">

    </table>
</div>
<script>
    var columns = ["ID", "Name", "Age", "City"];

     var data = [
        [1, "Jonathan", 25, "Gothenburg"],
        [2, "Simon", 23, "Gothenburg"],
        [3, "Hanna", 21, "Stockholm"]
    ];

    var doc = new jsPDF('p', 'pt');
    doc.autoTable(columns.splice(1, 4), data, {
        base: {},
        horizontal: {
            drawHeaderRow: function() {
                return true;
            },
            columnStyles: {
                name: {fillColor: [41, 128, 185], textColor: 255, fontStyle: 'bold'}
            }
        }

    });
    doc.output("dataurlnewwindow");
</script>
