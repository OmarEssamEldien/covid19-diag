<h4 id="item-4">Patients CT Scans</h4>
<p>After a Patient was Added to Infected Patients Table in The Database, Patient CT Scans Should be Uploaded to Check Whether it's CoronaVirus, Pneumonia or Nothing</p>
<span class="badge bg-warning text-dark">This API Section Must Be Used by Radiologist (User Role) Only</span>
<!-- Fetch Patients -->
<div class="py-3 section" id="item-4-1">

<p><strong>#1 - Fetch CT Scans</strong> <span class="float-end">Request method： <span style="color:#3edf3e">POST</span></span></p>
<p>URL : </p>
<input type="text" value="<?php echo $api_url; ?>/patient_ct_scans" style="max-width:500px" class="form-control" readonly>
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
                To fetch data set it to "fetch"
            </td>
        </tr>
        <tr>
            <td>infected_id</td>
            <td>No</td>
            <td>int</td>
            <td>-</td>
            <td>ID of the infected patient (From infected_patients Table) to fetch CT Scans</td>
        </tr>
    </tbody>
    </table>
</div>
<p>Request Example:</p>
<pre class="alert alert-light" style="width:max-content">
{
    "action" : "fetch",
    "infected_id": "27"
}
</pre>
<p>Response:</p>
<pre class="alert alert-light" style="width:max-content">
{
    "data":[
        {
            "ID":"6",
            "infected_id":"27",
            "date":"2022-04-03",
            "num_of_imgs":"3"
        }
    ]
}
</pre>
</div>
<hr>


<!-- Add CT Scans -->
<div class="py-3 section" id="item-4-2">

<p><strong>#2 - Add CT Scans</strong> <span class="float-end">Request method： <span style="color:#3edf3e">POST</span></span></p>
<p>URL : </p>
<input type="text" value="<?php echo $api_url; ?>/patient_ct_scans" style="max-width:500px" class="form-control" readonly>
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
                To add data set it to "add"
            </td>
        </tr>
        <tr>
            <td>ct_scans</td>
            <td>Yes</td>
            <td>file</td>
            <td>-</td>
            <td>CT Scans Images to Upload, Can Upload Multiple Files at Once Within Array. <span class="badge bg-warning text-dark">.dcm File Type Only Allowed</span></td>
        </tr>
        <tr>
            <td>infected_id</td>
            <td>Yes</td>
            <td>int</td>
            <td>-</td>
            <td>ID of the infected patient (From infected_patients Table) to fetch CT Scans</td>
        </tr>
        <tr>
            <td>date</td>
            <td>No</td>
            <td>string</td>
            <td>-</td>
            <td>Date of Upload, By Default Current Date</td>
        </tr>
    </tbody>
    </table>
</div>
<p>Request Example:</p>
<pre class="alert alert-light" style="width:max-content">
{
    "action" : "add",
    "infected_id" : 1,
    "files": [binary, binary]
}
</pre>
<p>Response:</p>
<pre class="alert alert-light" style="width:max-content">
{
    "uploaded_scans":2,
    "success":true,
    "row_id":"61",
    "ai_infection_prob":{"covid19":87,"pneumonia":9,"none":4},
    "ai_max_label_percent":87,
    "ai_max_label":"covid19",
    "min":80,
    "infection_status":"covid19"
}
</pre>
</div>
<hr>

<!-- Delete Data -->
<div class="py-3 section" id="item-4-3">

<p><strong>#3 - Delete CT Scans</strong> <span class="float-end">Request method： <span style="color:#3edf3e">POST</span></span></p>
<p>URL : </p>
<input type="text" value="<?php echo $api_url; ?>/patient_ct_scans" style="max-width:500px" class="form-control" readonly>
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
                To delete data set it to "delete"
            </td>
        </tr>
        <tr>
            <td>row_id</td>
            <td>Yes</td>
            <td>int</td>
            <td>-</td>
            <td>Record or Row ID to be deleted</td>
        </tr>
    </tbody>
    </table>
</div>
<p>Request Example:</p>
<pre class="alert alert-light" style="width:max-content">
{
    "action" : "delete",
    "row_id" : 1
</pre>
<p>Response:</p>
<pre class="alert alert-light" style="width:max-content">
{
    "success": true
}
</pre>
</div>
<hr>