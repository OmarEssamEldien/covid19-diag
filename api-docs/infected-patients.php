<h4 id="item-3">Infected Patients</h4>
<p>Infected Patients Table in Database is For Potential Patients Infected with The Virus, 
    After a Patient is Inserted into database His CT Scans must be uploaded to Check Wether he got CoronaVirus, Pneumonia or Nothing
</p>
<span class="badge bg-warning text-dark">This API Section Must Be Used by Radiologist (User Role) Only</span>
<!-- Fetch Patients -->
<div class="py-3 section" id="item-3-1">

<p><strong>#1 - Fetch Patients</strong> <span class="float-end">Request method： <span style="color:#3edf3e">POST</span></span></p>
<p>URL : </p>
<input type="text" value="<?php echo $api_url; ?>/infected" style="max-width:500px" class="form-control" readonly>
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
            <td>patient_id</td>
            <td>No</td>
            <td>int</td>
            <td>-</td>
            <td>ID of the user (Patient) to fetch his infection history / data</td>
        </tr>
        <tr>
            <td>doctor_id</td>
            <td>No</td>
            <td>int</td>
            <td>-</td>
            <td>ID of the user (Doctor) to fetch infection records supervised by doctor</td>
        </tr>
        <tr>
            <td>infected_id</td>
            <td>No</td>
            <td>int</td>
            <td>-</td>
            <td>Infected Record / Row ID</td>
        </tr>
    </tbody>
    </table>
</div>
<p>Request Example:</p>
<pre class="alert alert-light" style="width:max-content">
{
    "action" : "fetch"
}
</pre>
<p>Response:</p>
<pre class="alert alert-light" style="width:max-content">
{
    "data":[
        {
            "ID":"8",
            "patient_id":"7",
            "infection_date":"2022-03-26",
            "doctor_id":"8",
            "doctor":"Ahmed",
            "patient":"Ali",
            "ct_scans":[]
        }
    ]
}
</pre>
</div>
<hr>


<!-- Add Contacts -->
<div class="py-3 section" id="item-3-2">

<p><strong>#2 - Add Patient</strong> <span class="float-end">Request method： <span style="color:#3edf3e">POST</span></span></p>
<p>URL : </p>
<input type="text" value="<?php echo $api_url; ?>/infected" style="max-width:500px" class="form-control" readonly>
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
            <td>patient_id</td>
            <td>Yes</td>
            <td>int</td>
            <td>-</td>
            <td>ID of the user (Patient) to add as a suspicion of infection</td>
        </tr>
        <tr>
            <td>doctor_id</td>
            <td>Yes</td>
            <td>string</td>
            <td>3 : 30</td>
            <td>ID of the user (Doctor) to add as a supervisor doctor</td>
        </tr>
        <tr>
            <td>infection_date</td>
            <td>Yes</td>
            <td>string</td>
            <td>0 : 250</td>
            <td>Date of Infection</td>
        </tr>
        <tr>
            <td>diseases</td>
            <td>No</td>
            <td>string</td>
            <td>0 : 150</td>
            <td>Any Diseases the patient might have</td>
        </tr>
        <tr>
            <td>notes</td>
            <td>No</td>
            <td>string</td>
            <td>0 : 150</td>
            <td>Any notes about the patient</td>
        </tr>
    </tbody>
    </table>
</div>
<p>Request Example:</p>
<pre class="alert alert-light" style="width:max-content">
{
    "action" : "add",
    "patient_id" : 1,
    "doctor_id" : 2,
    "infection_date": "2022-03-25",
    "diseases": "diabetes",
    "notes": "smoker"
}
</pre>
<p>Response:</p>
<pre class="alert alert-light" style="width:max-content">
{
    "success": "Ok",
    "row_id": 3
}
</pre>
</div>
<hr>

<!-- Delete Data -->
<div class="py-3 section" id="item-3-3">

<p><strong>#3 - Delete Patient</strong> <span class="float-end">Request method： <span style="color:#3edf3e">POST</span></span></p>
<p>URL : </p>
<input type="text" value="<?php echo $api_url; ?>/infected" style="max-width:500px" class="form-control" readonly>
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
    "success": "Ok"
}
</pre>
</div>
<hr>