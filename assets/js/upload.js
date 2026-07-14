const invoiceFile = document.getElementById("invoiceFile");
const fileName = document.getElementById("fileName");

if (invoiceFile) {

    invoiceFile.addEventListener("change", function () {

        if (this.files.length > 0) {
            fileName.value = this.files[0].name;
        }

    });

}