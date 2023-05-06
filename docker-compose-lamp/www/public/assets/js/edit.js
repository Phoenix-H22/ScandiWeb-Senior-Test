$(document).ready(function() {
    const button = $('#submit-btn');
    const property = $('#properties');
    const productType = $('#productType');
    if (type == 'dvd') {
      addPropertyInput('Size (MB)', 'size', 'Please, provide size in MB',size);
    } else if (type == 'book') {
      addPropertyInput('Weight (KG)', 'weight', 'Please, provide weight in KG',weight);
    } else if (type == 'furniture') {
      addPropertyInput('Height (CM)', 'height',"",height);
      addPropertyInput('Width (CM)', 'width',"",width);
      addPropertyInput('Length (CM)', 'length', 'Please, provide dimensions in HxWxL',length);
    }
    // Handle product type change
    productType.change(function() {
      property.empty();
  
      const typeValue = productType.val();
  
      if (typeValue == 'dvd' || (type == 'DVD' && size != "")) {
        addPropertyInput('Size (MB)', 'size', 'Please, provide size in MB',size);
      } else if (typeValue == 'book' || (type == 'Book' && weight != "")) {
        addPropertyInput('Weight (KG)', 'weight', 'Please, provide weight in KG',weight);
      } else if (typeValue == 'furniture' || (type == 'furniture' && height != "" && width != "" && length != "")) {
        addPropertyInput('Height (CM)', 'height',"",height);
        addPropertyInput('Width (CM)', 'width',"",width);
        addPropertyInput('Length (CM)', 'length', 'Please, provide dimensions in HxWxL',length);
      }
    });
  
    // Add a new property input to the form
    function addPropertyInput(labelText, inputName, descriptionText = '',value= "") {
      const propertyInput = $(`
        <div class="mb-3 row">
          <label for="${inputName}" class="col-sm-2 col-form-label">${labelText} <span class="red">*</span></label>
          <div class="col-sm-4">
            <input type="number" class="form-control" name="${inputName}" value="${value}" id="${inputName}" required>
          </div>
          <p class="description">${descriptionText}</p>
        </div>
      `);
  
      property.append(propertyInput);
    }
  
    // Handle form submission
    button.click(function() {
      $('.alert-danger').remove();
      $('.alert-success').remove();
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
        url: `/edit-product/${id}`,
        type: 'post',
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
            const successNotification = $(`
                <div class="alert alert-success" role="alert">
                  <p>${data.message}</p>
                </div>
              `);
            // Redirect to homepage on success
            document.getElementById("loader-overlay").style.display = "none";
            document.getElementById("loader").style.display = "none";
            window.location.href = "/edit-product/"+id;
            // $(`main`).prepend(successNotification);
          } else {
            alert('Something went wrong. Please, try again later.');
          }
        }
      });
      
    });
  });
  