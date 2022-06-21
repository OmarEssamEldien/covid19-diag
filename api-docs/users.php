<h4 id="item-1">Users</h4>

                <div class="py-3" id="user_roles">

                    <h6># User Roles</h6>
                    Here's all user roles in the system, each user in the system should be one of these roles
                    <div class="alert alert-light p-0" style="width:max-content">
                        <table class="table" style="width:unset">
                        <thead>
                            <tr>
                            <th scope="col">Role_ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($con->query("SELECT * FROM user_roles")->fetchAll() as $role) {
                                echo '<tr>
                                        <td>'.$role['ID'].'</td>
                                        <td>'.$role['role'].'</td>
                                        <td>'.str_replace("\r\n", "<br>", $role['description']).'
                                        </td>
                                    </tr>';
                            }
                            ?>
                        </tbody>
                        </table>
                    </div>
                </div>
                        
                <hr>

                <!-- Fetch Users -->
                <div class="py-3 section" id="item-1-1">
                    
                    <p><strong>#1 - Fetch users</strong> <span class="float-end">Request method： <span style="color:#3edf3e">POST</span></span></p>
                    <p>URL : </p>
                    <input type="text" value="<?php echo $api_url; ?>/users" style="max-width:500px" class="form-control" readonly>
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
                                    To fetch users data set it to "fetch"
                                </td>
                            </tr>
                            <tr>
                                <td>user_id</td>
                                <td>No</td>
                                <td>int</td>
                                <td>-</td>
                                <td>If you want a specific user set the user's ID</td>
                            </tr>
                            <tr>
                                <td>role_id</td>
                                <td>No</td>
                                <td>int</td>
                                <td>-</td>
                                <td>If you want a specific role (eg. Patient = 4 )</td>
                            </tr>
                            <tr>
                                <td>gender</td>
                                <td>No</td>
                                <td>string</td>
                                <td>1</td>
                                <td>If you want a specific gender (F, M)</td>
                            </tr>
                            <tr>
                                <td>governorate</td>
                                <td>No</td>
                                <td>string</td>
                                <td>0:30</td>
                                <td>If you want a specific governorate</td>
                            </tr>
                            <tr>
                                <td>ssn</td>
                                <td>No</td>
                                <td>string</td>
                                <td>0:14</td>
                                <td>If you want a specific ssn</td>
                            </tr>
                            <tr>
                                <td>query</td>
                                <td>No</td>
                                <td>string</td>
                                <td>0:100</td>
                                <td>Query about Any Field in Database Related to User (username, email, address, etc .. )</td>
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
    "data": [
        {
            "ID": "6",
            'username' : "JohnDoe", 
            'gender' => "M", 
            'dob' => "1986-03-25", 
            'job' => "Doctor", 
            'address' => "11th District - 6 october", 
            'governorate' => "Giza", 
            'email' => "johndoe@example.com", 
            'phone_num' => "01553402492",
            'social_status' => "Single", 
            'ssn' => "30303030301245",
            'no_of_kids' => 0, 
            'coordinates' => "29.95583899, 30.91410849", 
            'role_id' => 1, 
            'vaccination_type' => "Pfizer"
        },
        {
            "ID": "7",
            'username' : "JohnDoe2", 
            'gender' => "M", 
            'dob' => "1986-03-25", 
            'job' => "Doctor", 
            'address' => "11th District - 6 october", 
            'governorate' => "Giza", 
            'email' => "johndoe2@example.com", 
            'phone_num' => "01553402492",
            'social_status' => "Single", 
            'ssn' => "30303030301242",
            'no_of_kids' => 0, 
            'coordinates' => "29.95583899, 30.91410849", 
            'role_id' => 1, 
            'vaccination_type' => "Pfizer"
        }
    ],
    "success": "Ok"
}
</pre>
                </div>
                <hr>

                <!-- Add User -->
                <div class="py-3 section" id="item-1-2">
                    
                    <p><strong>#2 - Add user</strong> <span class="float-end">Request method： <span style="color:#3edf3e">POST</span></span></p>
                    <p>URL : </p>
                    <input type="text" value="<?php echo $api_url; ?>/users" style="max-width:500px" class="form-control" readonly>
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
                                    To add user set it to "add"
                                </td>
                            </tr>
                            <tr>
                                <td>username</td>
                                <td>Yes</td>
                                <td>string</td>
                                <td>3 : 30</td>
                                <td>Username of the user <span class="alert alert-warning d-inline-block py-0 px-1">should be unique</span></td>
                            </tr>
                            <tr>
                                <td>gender</td>
                                <td>Yes</td>
                                <td>string</td>
                                <td>1</td>
                                <td>Gender of the user, explain it by character (F, M)</td>
                            </tr>
                            <tr>
                                <td>email</td>
                                <td>Yes</td>
                                <td>string</td>
                                <td>6 : 100</td>
                                <td>Email address of the user</td>
                            </tr>
                            <tr>
                                <td>phone_num</td>
                                <td>Yes</td>
                                <td>string</td>
                                <td>11</td>
                                <td>Phone Number of The user (eg. 0111xxxxxxx)</td>
                            </tr>
                            <tr>
                                <td>password</td>
                                <td>Yes</td>
                                <td>string</td>
                                <td>Min 6 </td>
                                <td>Password of the user's account 
                                    <span class="alert alert-warning d-inline-block py-0 px-1">should be sent as plaintext</span></td>
                            </tr>
                            <tr>
                                <td>ssn</td>
                                <td>Yes</td>
                                <td>string</td>
                                <td>14</td>
                                <td>Social Security Number (SSN) of the user (eg. 29292xxxxxxxxx)</td>
                            </tr>
                            <tr>
                                <td>role_id</td>
                                <td>Yes</td>
                                <td>int</td>
                                <td>-</td>
                                <td>The role ID of the user, <a href="#user_roles">check roles</a></td>
                            </tr>
                            <tr>
                                <td>governorate</td>
                                <td>Yes</td>
                                <td>string</td>
                                <td>0 : 30</td>
                                <td>Governorate that user lives in. <a href="json/governorates.json" target="_blank">Check Egypt Governorates</a></td>
                            </tr>
                            <tr>
                                <td>dob</td>
                                <td>No</td>
                                <td>string</td>
                                <td>10</td>
                                <td>Date of Birth of the user, (yyyy-mm-dd)</td>
                            </tr>
                            <tr>
                                <td>job</td>
                                <td>No</td>
                                <td>string</td>
                                <td>0 : 50</td>
                                <td>Profession or Job of the user (eg. Doctor, Nurse,...)</td>
                            </tr>
                            <tr>
                                <td>address</td>
                                <td>No</td>
                                <td>string</td>
                                <td>0 : 250</td>
                                <td>Address of the user</td>
                            </tr>
                            <tr>
                                <td>social_status</td>
                                <td>No</td>
                                <td>string</td>
                                <td>0 : 20</td>
                                <td>Social Status of the user (eg. Married, Single,...)</td>
                            </tr>
                            <tr>
                                <td>no_of_kids</td>
                                <td>No</td>
                                <td>int</td>
                                <td>-</td>
                                <td>Number of Kids the user have</td>
                            </tr>
                            <tr>
                                <td>coordinates</td>
                                <td>No</td>
                                <td>string</td>
                                <td>0:100</td>
                                <td>Coordinates of the user's address using Google Maps (lat, lng) in order 
                                    <br>(eg. 29.955838990767948, 30.91410849124169)</td>
                            </tr>
                            <tr>
                                <td>vaccination_type</td>
                                <td>No</td>
                                <td>int</td>
                                <td>0:20</td>
                                <td>Covid19 Vaccine Type the user have</td>
                            </tr>
                            <tr>
                                <td>img</td>
                                <td>No</td>
                                <td>file</td>
                                <td>-</td>
                                <td>User Photo Image to Upload.</td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    <p>Request Example:</p>
                    <pre class="alert alert-light" style="width:max-content">
{
    "action" : "add", 
    'username' : "JohnDoe", 
    'gender' => "M", 
    'dob' => "1986-03-25", 
    'job' => "Doctor", 
    'address' => "11th District - 6 october", 
    'governorate' => "Giza", 
    'email' => "johndoe@example.com", 
    'phone_num' => "01553402492",
    'password' => "P@$$123",
    'social_status' => "Single", 
    'ssn' => "30303030301245",
    'no_of_kids' => 0, 
    'coordinates' => "29.95583899, 30.91410849", 
    'role_id' => 1, 
    'vaccination_type' => "Pfizer"
}
</pre>
                    <p>Response:</p>
                    <pre class="alert alert-light" style="width:max-content">
{
    "success":'OK',
    "user_id": 1
}
</pre>
                </div>
                <hr>
                <!-- Edit User -->
                <div class="py-3 section" id="item-1-3">
                    
                    <p><strong>#3 - Edit user</strong> <span class="float-end">Request method： <span style="color:#3edf3e">POST</span></span></p>
                    <p>URL : </p>
                    <input type="text" value="<?php echo $api_url; ?>/users" style="max-width:500px" class="form-control" readonly>
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
                                    To edit user set it to "edit"
                                </td>
                            </tr>
                            <tr>
                                <td>user_id</td>
                                <td>Yes</td>
                                <td>int</td>
                                <td>-</td>
                                <td>ID of the user</td>
                            </tr>
                            <tr>
                                <td>username</td>
                                <td>No</td>
                                <td>string</td>
                                <td>3 : 30</td>
                                <td>Username of the user <span class="alert alert-warning d-inline-block py-0 px-1">should be unique</span></td>
                            </tr>
                            <tr>
                                <td>gender</td>
                                <td>No</td>
                                <td>string</td>
                                <td>1</td>
                                <td>Gender of the user, explain it by character (F, M)</td>
                            </tr>
                            <tr>
                                <td>dob</td>
                                <td>No</td>
                                <td>string</td>
                                <td>10</td>
                                <td>Date of Birth of the user, (yyyy-mm-dd)</td>
                            </tr>
                            <tr>
                                <td>job</td>
                                <td>No</td>
                                <td>string</td>
                                <td>0 : 50</td>
                                <td>Profession or Job of the user (eg. Doctor, Nurse,...)</td>
                            </tr>
                            <tr>
                                <td>address</td>
                                <td>No</td>
                                <td>string</td>
                                <td>0 : 250</td>
                                <td>Address of the user</td>
                            </tr>
                            <tr>
                                <td>governorate</td>
                                <td>No</td>
                                <td>string</td>
                                <td>0 : 30</td>
                                <td>Governorate that user lives in. <a href="json/governorates.json" target="_blank">Check Egypt Governorates</a></td>
                            </tr>
                            <tr>
                                <td>email</td>
                                <td>No</td>
                                <td>string</td>
                                <td>6 : 100</td>
                                <td>Email address of the user</td>
                            </tr>
                            <tr>
                                <td>phone_num</td>
                                <td>No</td>
                                <td>string</td>
                                <td>11</td>
                                <td>Phone Number of The user (eg. 0111xxxxxxx)</td>
                            </tr>
                            <tr>
                                <td>password</td>
                                <td>No</td>
                                <td>string</td>
                                <td>Min 6 </td>
                                <td>Password of the user's account 
                                    <span class="alert alert-warning d-inline-block py-0 px-1">should be sent as plaintext</span></td>
                            </tr>
                            <tr>
                                <td>social_status</td>
                                <td>No</td>
                                <td>string</td>
                                <td>0 : 20</td>
                                <td>Social Status of the user (eg. Married, Single,...)</td>
                            </tr>
                            <tr>
                                <td>ssn</td>
                                <td>No</td>
                                <td>string</td>
                                <td>14</td>
                                <td>Social Security Number (SSN) of the user (eg. 29292xxxxxxxxx)</td>
                            </tr>
                            <tr>
                                <td>no_of_kids</td>
                                <td>No</td>
                                <td>int</td>
                                <td>-</td>
                                <td>Number of Kids the user have</td>
                            </tr>
                            <tr>
                                <td>coordinates</td>
                                <td>No</td>
                                <td>string</td>
                                <td>0:100</td>
                                <td>Coordinates of the user's address using Google Maps (lat, lng) in order 
                                    <br>(eg. 29.955838990767948, 30.91410849124169)</td>
                            </tr>
                            <tr>
                                <td>role_id</td>
                                <td>No</td>
                                <td>int</td>
                                <td>-</td>
                                <td>The role ID of the user, <a href="#user_roles">check roles</a></td>
                            </tr>
                            <tr>
                                <td>vaccination_type</td>
                                <td>No</td>
                                <td>int</td>
                                <td>0:20</td>
                                <td>Covid19 Vaccine Type the user have</td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    <span class="alert alert-warning d-inline-block py-0 px-1">One Column at least required to be sent</span>
                    <p>Request Example:</p>
                    <pre class="alert alert-light" style="width:max-content">
{
    "action" : "edit", 
    "user_id" : 1,
    'username' : "JohnDoe", 
    'gender' => "M", 
    'dob' => "1986-03-25", 
    'job' => "Doctor", 
    'address' => "11th District - 6 october", 
    'governorate' => "Giza", 
    'email' => "johndoe@example.com", 
    'phone_num' => "01553402492",
    'password' => "P@$$123",
    'social_status' => "Single", 
    'ssn' => "30303030301245",
    'no_of_kids' => 0, 
    'coordinates' => "29.95583899, 30.91410849", 
    'role_id' => 1, 
    'vaccination_type' => "Pfizer"
}
</pre>
                    <p>Response:</p>
                    <pre class="alert alert-light" style="width:max-content">
{
    "success":'OK'
}
</pre>
                </div>
                <hr>
                <!-- Delete User -->
                <div class="py-3 section" id="item-1-4">
                    
                    <p><strong>#4 - Delete user</strong> <span class="float-end">Request method： <span style="color:#3edf3e">POST</span></span></p>
                    <p>URL : </p>
                    <input type="text" value="<?php echo $api_url; ?>/users" style="max-width:500px" class="form-control" readonly>
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
                                    To delete user set it to "delete"
                                </td>
                            </tr>
                            <tr>
                                <td>user_id</td>
                                <td>Yes</td>
                                <td>int</td>
                                <td>-</td>
                                <td>ID of the user to be deleted</td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    <p>Request Example:</p>
                    <pre class="alert alert-light" style="width:max-content">
{
    "action" : "delete", 
    "user_id" : 1
}
</pre>
                    <p>Response:</p>
                    <pre class="alert alert-light" style="width:max-content">
{
    "success":'OK'
}
</pre>
                </div>
                <hr>
                <!-- Login User -->
                <div class="py-3 section" id="item-1-5">
                    
                    <p><strong>#5 - Login user</strong> <span class="float-end">Request method： <span style="color:#3edf3e">POST</span></span></p>
                    <p>URL : </p>
                    <input type="text" value="<?php echo $api_url; ?>/users" style="max-width:500px" class="form-control" readonly>
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
                                    To log in a user set it to "login"
                                </td>
                            </tr>
                            <tr>
                                <td>email</td>
                                <td>Yes</td>
                                <td>string</td>
                                <td>-</td>
                                <td>Email of any user's account trying to login</td>
                            </tr>
                            <tr>
                                <td>password</td>
                                <td>Yes</td>
                                <td>string</td>
                                <td>-</td>
                                <td>Password of the user</td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    <p>Request Example:</p>
                    <pre class="alert alert-light" style="width:max-content">
{
    "action" : "login", 
    "email" : "johndoe@example.com",
    "password" : "P@$$123"
}
</pre>
                    <p>Response:</p>
                    <pre class="alert alert-light" style="width:max-content">
{
    "success":'OK',
    "user_id":1,
    "role_id":5,
    "user_role":'Patient'
}
</pre>
                </div>