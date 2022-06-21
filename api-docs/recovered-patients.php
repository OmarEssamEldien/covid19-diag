<h4 id="item-6">Recovered Patients</h4>
<p>When a Patient was Added to Infected Patients Table in Database, A Patient Should be Moved to Recovered Patients Table
    After a Recovery Time
</p>
<span class="badge bg-warning text-dark">This API Section Must Be Used by Doctor (User Role) Only</span>
<!-- Fetch Patients -->
<div class="py-3 section" id="item-6-1">

<p><strong>#1 - Fetch Patients</strong> <span class="float-end">Request method： <span style="color:#3edf3e">POST</span></span></p>
<p>URL : </p>
<input type="text" value="<?php echo $api_url; ?>/recovered" style="max-width:500px" class="form-control" readonly>
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
            <td>ID of the user (Patient) to fetch his recovery history / data</td>
        </tr>
        <tr>
            <td>doctor_id</td>
            <td>No</td>
            <td>int</td>
            <td>-</td>
            <td>ID of the user (Doctor) Who Diagnosed The Patient as Recovered Patient</td>
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
            "ID":"2",
            "patient_id":"7",
            "date_of_recovery":"2022-04-08",
            "doctor_id":"8",
            "alive":"0",
            "doctor":"Omar",
            "patient":"Ali"
        }
    ]
}
</pre>
</div>
<hr>


<!-- Add Patient -->
<div class="py-3 section" id="item-6-2">

<p><strong>#2 - Add Patient</strong> <span class="float-end">Request method： <span style="color:#3edf3e">POST</span></span></p>
<p>URL : </p>
<input type="text" value="<?php echo $api_url; ?>/recovered" style="max-width:500px" class="form-control" readonly>
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
            <td>infected_id</td>
            <td>Yes</td>
            <td>int</td>
            <td>-</td>
            <td>ID of the infected patient (From infected_patients Table) to Move to Recovered Patients</td>
        </tr>
        <tr>
            <td>alive</td>
            <td>Yes</td>
            <td>boolean</td>
            <td>1</td>
            <td>Specifics Whether a Patient is Alive or Not After Recovery (Alive =  1, Not Alive = 0)</td>
        </tr>
        <tr>
            <td>doctor_id</td>
            <td>No</td>
            <td>int</td>
            <td>-</td>
            <td>ID of the user (Doctor) Who Diagnosed The Patient as Recovered Patient</td>
        </tr>
        <tr>
            <td>date_of_recovery</td>
            <td>No</td>
            <td>string</td>
            <td>-</td>
            <td>Date of Recovery, By Default Current Date</td>
        </tr>
    </tbody>
    </table>
</div>
<p>Request Example:</p>
<pre class="alert alert-light" style="width:max-content">
{
    "action" : "add",
    "infected_id" : 25,
    "doctor_id" : 10,
    "data_of_recovery" : "2022-03-25",
    "alive": 1
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
<div class="py-3 section" id="item-6-3">

<p><strong>#3 - Delete Patient</strong> <span class="float-end">Request method： <span style="color:#3edf3e">POST</span></span></p>
<p>URL : </p>
<input type="text" value="<?php echo $api_url; ?>/recovered" style="max-width:500px" class="form-control" readonly>
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