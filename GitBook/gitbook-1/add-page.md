# Add Page

<figure><img src="../.gitbook/assets/image (4).png" alt=""><figcaption><p>Product Add Page</p></figcaption></figure>

Main Functionalities:

1. Add product with unique SKU.
2. Add Request go through some validation.
   * Filter inputs from any malicious script.
   * Check if all required fields come with request or not.
   * Check if SKU is unique or exist in Database.
   * Check if price and product type properties are numeric.
   * List Error of each input below it
3. Product Type Properties Fields changed dynamically depend on type with jQuery
   * ![](<../.gitbook/assets/image (2).png>)
   * ![](<../.gitbook/assets/image (1).png>)
   * ![](<../.gitbook/assets/image (5).png>)
4. Request **Scenario:**
   1. after you click on save button ajax request are sent with value of every field.
   2. In Backend, i validate all fields with validations i said before and reply with a response with errors if exists
   3. If ajax catch that the response contain errors i start to list all errors under its specific field.
   4. if there isn't any error, product will be added to database using its type Model then i reply with success response and display a success message to user.

{% hint style="info" %}
**All validations are performed on the server-side. Requests to add or edit products are made using AJAX, and the success messages or errors are received and displayed using JavaScript and jQuery.**
{% endhint %}

&#x20;    &#x20;
