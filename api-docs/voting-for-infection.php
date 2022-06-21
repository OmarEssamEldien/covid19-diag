<h4 id="item-5">Voting For Infection</h4>
<p>After a Patients CT Scans was Uploaded and AI Failed to Say Whether it's CoronaVirus, Pneumonia or Nothing with High Accuracy, 
    Then We Take Some Doctors Voting (7 Votes) and Get Most Diagnose as A Result to CT Scans
</p>
<span class="badge bg-warning text-dark">This API Section Must Be Used by Doctor (User Role) Only</span>
<!-- Fetch Patients -->
<div class="py-3 section" id="item-5-1">

<p><strong>#1 - Fetch Infection Votes</strong> <span class="float-end">Request method： <span style="color:#3edf3e">POST</span></span></p>
<p>URL : </p>
<input type="text" value="<?php echo $api_url; ?>/voting_for_infection" style="max-width:500px" class="form-control" readonly>
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
        <tr>
            <td>doctor_id</td>
            <td>No</td>
            <td>int</td>
            <td>-</td>
            <td>ID of the user (Doctor) Voted for Infection</td>
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
            "ID":"20",
            "infected_id":"32",
            "diagnose":"covid19",
            "doctor_id":"10",
            "doctor":"Ali",
            "patient":"Mohamed",
            "ct_scans":[]
        },
        {
            "ID":"21",
            "infected_id":"32",
            "diagnose":"pneumonia",
            "doctor_id":"11",
            "doctor":"Ahmed",
            "patient":"Mohamed",
            "ct_scans":[]
        }
    ],
    "success":true
}
</pre>
</div>
<hr>


<!-- Add Vote -->
<div class="py-3 section" id="item-5-2">

<p><strong>#2 - Doctor Vote</strong> <span class="float-end">Request method： <span style="color:#3edf3e">POST</span></span></p>
<p>URL : </p>
<input type="text" value="<?php echo $api_url; ?>/voting_for_infection" style="max-width:500px" class="form-control" readonly>
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
            <td>ID of the infected patient (From infected_patients Table) to fetch CT Scans</td>
        </tr>
        <tr>
            <td>doctor_id</td>
            <td>Yes</td>
            <td>int</td>
            <td>-</td>
            <td>ID of the user (Doctor) Voting for Infection</td>
        </tr>
        <tr>
            <td>diagnose</td>
            <td>Yes</td>
            <td>string</td>
            <td>-</td>
            <td>Diagnose for The Patient Must be One of The Following : (covid19, pneumonia, none)</td>
        </tr>
    </tbody>
    </table>
</div>
<p>Request Example:</p>
<pre class="alert alert-light" style="width:max-content">
{
    "action" : "add",
    "infected_id" : 1,
    "doctor_id" : 10,
    "diagnose" : "covid19"
}
</pre>
<p>Response:</p>
<pre class="alert alert-light" style="width:max-content">
{
    "success":true,
    "row_id":"21",
    "votes_taken":2
}
</pre>
</div>
<hr>

<!-- Delete Data -->
<div class="py-3 section" id="item-5-3">

<p><strong>#3 - Delete Vote</strong> <span class="float-end">Request method： <span style="color:#3edf3e">POST</span></span></p>
<p>URL : </p>
<input type="text" value="<?php echo $api_url; ?>/voting_for_infection" style="max-width:500px" class="form-control" readonly>
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