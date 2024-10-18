document.querySelectorAll('.downloadBtn').forEach(button => {
	button.addEventListener('click', function() {
		const row = this.closest('tr');
        const path = "uploads/files/";

        // Getting the names of the file
        const filePath = row.querySelector('a').href;
        const fileName = filePath.substring(filePath.lastIndexOf('/') + 1);

        const link = document.createElement('a');  
        link.href = path+fileName;
        link.download = fileName;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
	});
});