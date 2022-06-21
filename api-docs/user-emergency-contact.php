<h4 id="item-2">User Emergency Contact</h4>

<!-- Fetch Contacts -->
<div class="py-3 section" id="item-2-1">

<p><strong>#1 - Fetch Contacts</strong> <span class="float-end">Request method： <span style="color:#3edf3e">POST</span></span></p>
<p>URL : </p>
<input type="text" value="<?php echo $api_url; ?>/user_emergency_contact" style="max-width:500px" class="form-control" readonly>
<p class="mb-0 mt-2">Request parameters:</p>
<div class="alert alert-light p-0" style="width:max-content">
    <table class="table" style="width:unset">
    <thead>
        <tr>
        <th scope="col">Name</th>
        <th scope="col">Required</th>
        <th scope="col">Type</th>
        <th scope="col">Length</th>
        <th scope="col">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>action</td>
            <td>Yes</td>
            <td>string</td>
            <td>-</td>
            <td>Specify the required action (eg. Fetch, Add, Edit, Delete)
                <br>
                To fetch contacts data set it to "fetch"
            </td>
        </tr>
        <tr>
            <td>user_id</td>
            <td>Yes</td>
            <td>int</td>
            <td>-</td>
            <td>ID of the user to add to his emergency contacts</td>
        </tr>
    </tbody>
    </table>
</div>
<p>Request Example:</p>
<pre class="alert alert-light" style="width:max-content">
{
    "action" : "fetch",
    "user_id" : 1
}
</pre>
<p>Response:</p>
<pre class="alert alert-light" style="width:max-content">
{
    "data": [
        {
            "ID": "2",
            "user_id": "1",
            "address": "45 Nigeria - Orora 308",
            "name": "Ahmed Ali",
            "phone_num": "012534634"
        }
    ],
    "success": "Ok"
}
</pre>
</div>
<hr>


<!-- Add Contacts -->
<div class="py-3 section" id="item-2-2">

<p><strong>#2 - Add Contact</strong> <span class="float-end">Request method： <span style="color:#3edf3e">POST</span></span></p>
<p>URL : </p>
<input type="text" value="<?php echo $api_url; ?>/user_emergency_contact" style="max-width:500px" class="form-control" readonly>
<p class="mb-0 mt-2">Request parameters:</p>
<div class="alert alert-light p-0" style="width:max-content">
    <table class="table" style="width:unset">
    <thead>
        <tr>
        <th scope="col">Name</th>
        <th scope="col">Required</th>
        <th scope="col">Type</th>
        <th scope="col">Length</th>
        <th scope="col">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>action</td>
            <td>Yes</td>
            <td>string</td>
            <td>-</td>
            <td>Specify the required action (eg. Fetch, Add, Edit, Delete)
                <br>
                To add contact data set it to "add"
            </td>
        </tr>
        <tr>
            <td>user_id</td>
            <td>Yes</td>
            <td>int</td>
            <td>-</td>
            <td>ID of the user to get his emergency contacts</td>
        </tr>
        <tr>
            <td>name</td>
            <td>Yes</td>
            <td>string</td>
            <td>3 : 30</td>
            <td>Name of the contact</td>
        </tr>
        <tr>
            <td>address</td>
            <td>Yes</td>
            <td>string</td>
            <td>0 : 250</td>
            <td>Address of the contact</td>
        </tr>
        <tr>
            <td>phone_num</td>
            <td>Yes</td>
            <td>string</td>
            <td>11</td>
            <td>Phone Number of The Contact (eg. 0111xxxxxxx)</td>
        </tr>
    </tbody>
    </table>
</div>
<p>Request Example:</p>
<pre class="alert alert-light" style="width:max-content">
{
    "action" : "add",
    "user_id" : 1,
    "name": "Ahmed Ali",
    "address": "45 Nigeria - Orora 308",
    "phone_num": "012534634"
}
</pre>
<p>Response:</p>
<pre class="alert alert-light" style="width:max-content">
{
    "success": "Ok",
    "contact_id": 3
}
</pre>
</div>
<hr>

<!-- Update Contacts -->
<div class="py-3 section" id="item-2-3">

<p><strong>#3 - Update Contact</strong> <span class="float-end">Request method： <span style="color:#3edf3e">POST</span></span></p>
<p>URL : </p>
<input type="text" value="<?php echo $api_url; ?>/user_emergency_contact" style="max-width:500px" class="form-control" readonly>
<p class="mb-0 mt-2">Request parameters:</p>
<div class="alert alert-light p-0" style="width:max-content">
    <table class="table" style="width:unset">
    <thead>
        <tr>
        <th scope="col">Name</th>
        <th scope="col">Required</th>
        <th scope="col">Type</th>
        <th scope="col">Length</th>
        <th scope="col">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>action</td>
            <td>Yes</td>
            <td>string</td>
            <td>-</td>
            <td>Specify the required action (eg. Fetch, Add, Edit, Delete)
                <br>
                To update contact data set it to "update"
            </td>
        </tr>
        <tr>
            <td>user_id</td>
            <td>Yes</td>
            <td>int</td>
            <td>-</td>
            <td>ID of the user to get his emergency contacts</td>
        </tr>
        <tr>
            <td>name</td>
            <td>Yes</td>
            <td>string</td>
            <td>3 : 30</td>
            <td>Name of the contact</td>
        </tr>
        <tr>
            <td>address</td>
            <td>Yes</td>
            <td>string</td>
            <td>0 : 250</td>
            <td>Address of the contact</td>
        </tr>
        <tr>
            <td>phone_num</td>
            <td>Yes</td>
            <td>string</td>
            <td>11</td>
            <td>Phone Number of The Contact (eg. 0111xxxxxxx)</td>
        </tr>
    </tbody>
    </table>
</div>
<p>Request Example:</p>
<pre class="alert alert-light" style="width:max-content">
{
    "action" : "update",
    "contact_id" : 1,
    "user_id" : 1,
    "name": "Ahmed Ali",
    "address": "45 Nigeria - Orora 308",
    "phone_num": "012534634"
}
</pre>
<p>Response:</p>
<pre class="alert alert-light" style="width:max-content">
{
    "success": "Ok"
}
</pre>
</div>
<hr>


<!-- Delete Contacts -->
<div class="py-3 section" id="item-2-4">

<p><strong>#4 - Delete Contact</strong> <span class="float-end">Request method： <span style="color:#3edf3e">POST</span></span></p>
<p>URL : </p>
<input type="text" value="<?php echo $api_url; ?>/user_emergency_contact" style="max-width:500px" class="form-control" readonly>
<p class="mb-0 mt-2">Request parameters:</p>
<div class="alert alert-light p-0" style="width:max-content">
    <table class="table" style="width:unset">
    <thead>
        <tr>
        <th scope="col">Name</th>
        <th scope="col">Required</th>
        <th scope="col">Type</th>
        <th scope="col">Length</th>
        <th scope="col">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>action</td>
            <td>Yes</td>
            <td>string</td>
            <td>-</td>
            <td>Specify the required action (eg. Fetch, Add, Edit, Delete)
                <br>
                To delete contact data set it to "delete"
            </td>
        </tr>
        <tr>
            <td>contact_id</td>
            <td>Yes</td>
            <td>int</td>
            <td>-</td>
            <td>Contact ID to be deleted</td>
        </tr>
    </tbody>
    </table>
</div>
<p>Request Example:</p>
<pre class="alert alert-light" style="width:max-content">
{
    "action" : "delete",
    "contact_id" : 1
</pre>
<p>Response:</p>
<pre class="alert alert-light" style="width:max-content">
{
    "success": "Ok"
}
</pre>
</div>
<hr>