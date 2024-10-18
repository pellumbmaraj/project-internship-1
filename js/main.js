let data_to_modify = new FormData();

const approveAuthorButtonEdit = document.getElementById('btnApproveEditAuthor');
const approveAuthorButtonDelete = document.getElementById('btnApproveDeleteAuthor');
const approveCategoryButtonEdit = document.getElementById('btnApproveEditCategory');
const approveCategoryButtonDelete = document.getElementById('btnApproveDeleteCategory');
const approveBookButtonEdit = document.getElementById('btnApproveEditBook');
const approveBookButtonDelete = document.getElementById('btnApproveDeleteBook');

const modalEditBook = new bootstrap.Modal(document.getElementById('staticBackdropEditBook'));
const modalDeleteBook = new bootstrap.Modal(document.getElementById('staticBackdropDeleteBook'));
const modalEditAuthor = new bootstrap.Modal(document.getElementById('staticBackdropEditAuthor'));
const modalDeleteAuthor = new bootstrap.Modal(document.getElementById('staticBackdropDeleteAuthor'));
const modalEditCategory = new bootstrap.Modal(document.getElementById('staticBackdropEditCategory'));
const modalDeleteCategory = new bootstrap.Modal(document.getElementById('staticBackdropDeleteCategory'));

document.querySelectorAll('.button-author').forEach(button => {
  button.addEventListener('click', function() {
  	data_to_modify = new FormData();
    // Find the closest table row <tr> element (where the clicked button is located)
    const row = this.closest('tr');
    
    // Get all <td> elements in that row and collect their text content
    const rowData = Array.from(row.querySelectorAll('td')).map(td => td.textContent);
    
    // Remove the last element, which is the button's cell
    rowData.pop();
    
    data_to_modify.append('option', 'author');
    data_to_modify.append('old_author', rowData[1]);
  });
});

document.querySelectorAll('.button-category').forEach(button => {
  button.addEventListener('click', function() {
  	data_to_modify = new FormData();
    // Find the closest table row <tr> element (where the clicked button is located)
    const row = this.closest('tr');
          
    // Get all <td> elements in that row and collect their text content
    const rowData = Array.from(row.querySelectorAll('td')).map(td => td.textContent);
          
    // Remove the last element, which is the button's cell
    rowData.pop();

    data_to_modify.append('option', 'category');
    data_to_modify.append('old_category', rowData[1]);      
  });
});

document.querySelectorAll('.button-book').forEach(button => {
  button.addEventListener('click', function() {
  	data_to_modify = new FormData();
    // Find the closest table row <tr> element (where the clicked button is located)
    const row = this.closest('tr');

    // Getting the names of the files
    const imagePath = row.querySelector('img').src;
    const filePath = row.querySelector('a').href;
    const imageName = imagePath.substring(imagePath.lastIndexOf('/') + 1);
  	const fileName = filePath.substring(filePath.lastIndexOf('/') + 1);
    
  	const title = row.querySelector('a').textContent.trim();

    // Get all <td> elements in that row and collect their text content
    const rowData = Array.from(row.querySelectorAll('td')).map(td => td.textContent);
        
    // Remove the last element, which is the button's cell
    rowData.pop();

    data_to_modify.append('option', 'book');
    data_to_modify.append('old_author', rowData[2]);
    data_to_modify.append('old_title', title);
    data_to_modify.append('old_desc', rowData[3]); 
    data_to_modify.append('old_category', rowData[4]);
    data_to_modify.append('old_image', imageName);
    data_to_modify.append('old_file', fileName);

   	
  });
});

approveAuthorButtonEdit.addEventListener('click', () => {
	const author = document.getElementById('authorNameAuth').value;
	const alertBox = document.getElementById('alertBox');

	modalEditAuthor.hide();
	alertBox.className = 'alert';
	
	if (author != "") {
		data_to_modify.append('action', 'edit');
		data_to_modify.append('new_author', author);

		fetch('edit.php', {  
	    method: 'POST',
	    body: data_to_modify
	  })
	  .then(response => response.json())
	  .then(data => {
	  	if (data.status == 'success')	  		
	  		alertBox.classList.add('alert-success');
	  	else
	  		alertBox.classList.add('alert-danger');
	    
	    alertBox.textContent = data.message;
	  })
	  .catch(error => {
	    console.error('Error sending the data   ', error);
	  });

	}

	alertBox.style.display = 'block';
	setTimeout(() => {
    alertBox.style.display = 'none';
  }, 5000);
	setTimeout(() => {
		location.reload();
  }, 5000);
});

approveAuthorButtonDelete.addEventListener('click', () => {
	data_to_modify.append('action', 'delete');
	modalEditAuthor.hide();
	alertBox.className = 'alert';

	fetch('edit.php', {  
    method: 'POST',
    body: data_to_modify
  })
  .then(response => response.json())
  .then(data => {
  	if (data.status == 'success')	  		
  		alertBox.classList.add('alert-success');
  	else
  		alertBox.classList.add('alert-danger');
    
    alertBox.textContent = data.message;
  })
  .catch(error => {
    console.error('Error sending the data   ', error);
  });

  alertBox.style.display = 'block';
	setTimeout(() => {
    alertBox.style.display = 'none';
  }, 5000);
	setTimeout(() => {
		location.reload();
  }, 5000);
});

approveCategoryButtonEdit.addEventListener('click', () => {
	const category = document.getElementById('newCategoryCat').value;
	const alertBox = document.getElementById('alertBox');

	modalEditAuthor.hide();
	alertBox.className = 'alert';
	
	if (author != "") {
		data_to_modify.append('action', 'edit');
		data_to_modify.append('new_category', category);

		fetch('edit.php', {  
	    method: 'POST',
	    body: data_to_modify
	  })
	  .then(response => response.json())
	  .then(data => {
	  	if (data.status == 'success')	  		
	  		alertBox.classList.add('alert-success');
	  	else
	  		alertBox.classList.add('alert-danger');
	    
	    alertBox.textContent = data.message;
	  })
	  .catch(error => {
	    console.error('Error sending the data   ', error);
	  });

	}

	alertBox.style.display = 'block';
	setTimeout(() => {
    alertBox.style.display = 'none';
  }, 5000);
	setTimeout(() => {
		location.reload();
  }, 5000);
});

approveCategoryButtonDelete.addEventListener('click', () => {
	data_to_modify.append('action', 'delete');
	modalEditAuthor.hide();
	alertBox.className = 'alert';

	fetch('edit.php', {  
    method: 'POST',
    body: data_to_modify
  })
  .then(response => response.json())
  .then(data => {
  	if (data.status == 'success')	  		
  		alertBox.classList.add('alert-success');
  	else
  		alertBox.classList.add('alert-danger');
    
    alertBox.textContent = data.message;
  })
  .catch(error => {
    console.error('Error sending the data   ', error);
  });

  alertBox.style.display = 'block';
	setTimeout(() => {
    alertBox.style.display = 'none';
  }, 5000);
	setTimeout(() => {
		location.reload();
  }, 5000);
});

approveBookButtonEdit.addEventListener('click', () => {

});

approveBookButtonDelete.addEventListener('click', () => {
	data_to_modify.append('action', 'delete');
	modalEditAuthor.hide();
	alertBox.className = 'alert';

	fetch('edit.php', {  
    method: 'POST',
    body: data_to_modify
  })
  .then(response => response.json())
  .then(data => {
  	if (data.status == 'success')	  		
  		alertBox.classList.add('alert-success');
  	else
  		alertBox.classList.add('alert-danger');
    
    alertBox.textContent = data.message;
  })
  .catch(error => {
    console.error('Error sending the data   ', error);
  });

  alertBox.style.display = 'block';
	setTimeout(() => {
    alertBox.style.display = 'none';
  }, 5000);
	setTimeout(() => {
		location.reload();
  }, 5000);
});
