# Edit Page

<figure><img src="../.gitbook/assets/image (3).png" alt=""><figcaption><p>Edit Page - Edit Pages URL be like  /edit-product/39 - 39 is the id of the product</p></figcaption></figure>

Main Functionalities:

1. Edit Selected product if it's exist
2. Edit Request go through some validation.
   * Filter inputs from any malicious script.
   * Check if all required fields come with request or not.
   * Check if the SKU exists in the database. If it does not, verify whether it is unique or not.
   * Check if price and product type properties are numeric.
   * List Error of each input below it
3. Before rendering the page, I exploded the Product Type Properties Fields and used type casting to send the properties to the frontend, allowing them to be rendered in their respective fields. Then, using JavaScript, I checked the type coming with the request so I could append the inputs for the specific property.
4. Request **Scenario:**
   1. after you click on save button ajax request are sent with value of every field.
   2. In Backend, i validate all fields with validations i said before and reply with a response with errors if exists
   3. If ajax catch that the response contain errors i start to list all errors under its specific field.
   4. if there isn't any error, product will be edited to database using its type Model and based on its id then i reply with success response and display a success message to user.

{% hint style="info" %}
**All validations are performed on the server-side. Requests to add or edit products are made using AJAX, and the success messages or errors are received and displayed using JavaScript and jQuery.**
{% endhint %}
