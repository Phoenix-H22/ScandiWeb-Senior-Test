$(function() {
    const button = $('#submit-btn');
    const property = $('#properties');
    const productType = $('#productType');
    
    // Handle product type change
    productType.change(function() {
      property.empty();
  
      const type = productType.val();
  
      if (type == 'dvd') {
        addPropertyInput('Size (MB)', 'size', 'Please, provide size in MB');
      } else if (type == 'book') {
        addPropertyInput('Weight (KG)', 'weight', 'Please, provide weight in KG');
      } else if (type == 'furniture') {
        addPropertyInput('Height (CM)', 'height');
        addPropertyInput('Width (CM)', 'width');
        addPropertyInput('Length (CM)', 'length', 'Please, provide dimensions in HxWxL');
      }
    });
  
    // Add a new property input to the form
    function addPropertyInput(labelText, inputName, descriptionText = '') {
      const propertyInput = $(`
        <div class="mb-3 row">
          <label for="${inputName}" class="col-sm-2 col-form-label">${labelText} <span class="red">*</span></label>
          <div class="col-sm-4">
            <input type="number" class="form-control" name="${inputName}" id="${inputName}" required>
          </div>
          <p class="description">${descriptionText}</p>
        </div>
      `);
  
      property.append(propertyInput);
    }
  
    // Handle form submission
    button.click(function() {
      $('.alert-danger').remove();
      document.getElementById("loader-overlay").style.display = "block";
  document.getElementById("loader").style.display = "block";
      // Collect form data
      const formData = {
        sku: $('#sku').val(),
        productType: productType.val(),
        name: $('#name').val(),
        price: $('#price').val(),
        size: $('#size').val(),
        weight: $('#weight').val(),
        height: $('#height').val(),
        width: $('#width').val(),
        length: $('#length').val(),
      };
  
      // Send form data via AJAX
      $.ajax({
        method: 'POST',
        url: '/add-product',
        data: formData,
  
        success: function(data) {
          if (data.status == 'error') {
            // Display error messages
            $.each(data, function(index, value) {
              const errorNotification = $(`
                <div class="alert alert-danger p-1 mt-1 mb-0" role="alert">
                  <p>${value}</p>
                </div>
              `);
              $(`#${index}`).parent().append(errorNotification);
            });
            document.getElementById("loader-overlay").style.display = "none";
            document.getElementById("loader").style.display = "none";
            return false;
          } else if (data.status == 'success') {
            // Redirect to homepage on success
            console.log(data);
            document.getElementById("loader-overlay").style.display = "none";
            document.getElementById("loader").style.display = "none";
            window.location.href = '/';
          } else {
            console.log(data);
          }
        }
      });
    });
  });
  