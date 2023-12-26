@extends('layouts.app')

@section('content')
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('inc.menu')
            <!-- / Menu -->
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('inc.nav')

                <!-- / Navbar -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <!---Layout -->
                            <div class="col col-12 col-md-6 ">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5>Add User</h5>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('create.user') }}">
                                            @csrf
                                            <label class="my-2" for="">Name</label>
                                            <input type="text" name="name" class="form-control mb-3"
                                                value="{{ old('name', @$user->name) }}" placeholder="Name" required />
                                            <input type="hidden" name="user_id" value="{{ @$user->id }}">
                                            @error('name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <label class="my-2" for="">Email</label>
                                            <input type="email" name="email" class="form-control mb-3"
                                                value=" {{ old('email', @$user->email) }}" placeholder="Email" required />
                                            @error('email')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <label class="my-2" for="">Select Action</label>
                                            <select name="status" class="form-select form-control mb-3" required>
                                                <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}
                                                    {{ @$user->active == 'Active' ? 'selected' : '' }}>
                                                    Activate
                                                </option>
                                                <option value="InActive" {{ old('status') == 'InActive' ? 'selected' : '' }}
                                                    {{ @$user->active == 'InActive' ? 'selected' : '' }}>
                                                    Deactivate</option>
                                            </select>

                                            <label class="my-2" for="">Select Parent</label>
                                            <select name="parent[]" class="form-select form-control mb-3" required multiple>
                                                @foreach (@$createUsers as $createUser)
                                                    <option value="{{ $createUser->id }}"
                                                        {{ in_array($createUser->id, old('parent', [])) ? 'selected' : '' }}
                                                        {{ in_array($createUser->id, explode(',', @$user->parent_id)) ? 'selected' : '' }}>
                                                        {{ $createUser->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label class="my-2" for="">Password</label>
                                            <input type="password" name="password" class="form-control mb-3"
                                                placeholder="Password" required />
                                            @error('password')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror

                                            <label class="my-2" for="">Confirm Password</label>
                                            <input type="password" name="password_confirmation" class="form-control mb-3"
                                                placeholder="Confirm password" required />
                                            @error('password_confirmation')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <button class="btn btn-primary d-grid "
                                                type="submit">{{ @$user ? 'Update' : 'Submit' }}</button>

                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-12 col-md-6 ">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5>Add Roles</h5>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('roles.store') }}">
                                            @csrf
                                            <input type="name" class="form-control mb-3" name="name" required
                                                placeholder="Role Name" />
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    name="lead" value="Y" id="flexSwitchCheckDefault">
                                                <label class="form-check-label" for="flexSwitchCheckDefault">Leads</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    name="user" value="Y" id="flexSwitchCheckChecked">
                                                <label class="form-check-label" for="flexSwitchCheckChecked">User</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    name="meeting" value="Y" id="flexSwitchCheckDisabled">
                                                <label class="form-check-label"
                                                    for="flexSwitchCheckDisabled">Meetings</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    name="proposal" value="Y" id="flexSwitchCheckCheckedDisabled">
                                                <label class="form-check-label"
                                                    for="flexSwitchCheckCheckedDisabled">Proposal</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    name="certificate" value="Y"id="certificateToggle">
                                                <label class="form-check-label"
                                                    for="flexSwitchCheckCheckedDisabled1">Certificate</label>
                                                <!-- Additional options for Certificate -->
                                                <div id="certificateOptions" style="display: none;">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="radio"
                                                            name="certificate_option" value="Q">
                                                        <label class="form-check-label">Q</label>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="radio"
                                                            name="certificate_option" value="H">
                                                        <label class="form-check-label">H</label>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="radio"
                                                            name="certificate_option" value="I">
                                                        <label class="form-check-label">I</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    name="account" value="Y" id="flexSwitchCheckCheckedDisabled1">
                                                <label class="form-check-label"
                                                    for="flexSwitchCheckCheckedDisabled1">Account</label>
                                            </div>
                                            <button class="btn btn-primary d-grid " type="submit">Submit</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5>Allocate Roles to Users</h5>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('assign.role') }}">
                                            @csrf
                                            <label class="my-2" for="">Select User</label>
                                            <select class="form-select form-control mb-3" name="user_id" required>
                                                <option value="">Select an option</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                            <label class="my-2" for="">Select Role</label>
                                            <select class="form-select form-control mb-3" name="role_id" required>
                                                <option value="">Select an option</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>

                                            <button class="btn btn-primary d-grid " type="submit">Submit</button>

                                        </form>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5>All Roles</h5>
                                        </div>
                                        <div class="card-body">
                                            <table id="example" class="table " style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Permission</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach (@$roles as $index => $role)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $role->name }}</td>
                                                            <td>
                                                                @if ($role->lead == 'Y')
                                                                    L,
                                                                @endif
                                                                @if ($role->user == 'Y')
                                                                    U,
                                                                @endif
                                                                @if ($role->meeting == 'Y')
                                                                    M,
                                                                @endif
                                                                @if ($role->proposal == 'Y')
                                                                    P,
                                                                @endif
                                                                @if ($role->certificate == 'Y')
                                                                    C,
                                                                @endif
                                                                @if ($role->account == 'Y')
                                                                    A,
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-sm btn-primary edit-role-button"
                                                                    data-role-id="{{ $role->id }}"
                                                                    data-role-name="{{ $role->name }}"
                                                                    data-role-lead="{{ $role->lead }}"
                                                                    data-role-user="{{ $role->user }}"
                                                                    data-role-meeting="{{ $role->meeting }}"
                                                                    data-role-proposal="{{ $role->proposal }}"
                                                                    data-role-account="{{ $role->account }}"
                                                                    data-role-certificate="{{ $role->certificate }}"
                                                                    data-role-option="{{ $role->certificate_option }}">
                                                                    Edit
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card mb-4 " id="editRoleForm" style="display: none;">
                                        <div class="card-header">
                                            <h5>Edit Role</h5>
                                        </div>
                                        <div class="card-body">
                                            <form method="POST" action="{{ route('role.edit') }}">
                                                @csrf
                                                <input type="hidden" id="editRoleId" name="roleId">
                                                <input type="name" class="form-control mb-3" name="name" required
                                                    id="editRoleName" placeholder="Role Name" />
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="editRoleLead" name="lead" value="Y">
                                                    <label class="form-check-label" for="editRoleLead">Leads</label>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        name="user" value="Y" id="editRoleUser">
                                                    <label class="form-check-label" for="editRoleUser">User</label>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        name="meeting" value="Y" id="editRoleMeeting">
                                                    <label class="form-check-label" for="editRoleMeeting">Meetings</label>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        name="proposal" value="Y" id="editRoleProposal">
                                                    <label class="form-check-label"
                                                        for="editRoleProposal">Proposal</label>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        name="certificate" value="Y" id="editRoleCertificate">
                                                    <label class="form-check-label"
                                                        for="editRoleCertificate">Certificate</label>
                                                    <div id="certificateEditRole" style="display: none;">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="radio"
                                                                name="certificate_option" value="Q"
                                                                id="certificateOptionQ">
                                                            <label class="form-check-label">Q</label>
                                                        </div>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="radio"
                                                                name="certificate_option" value="H"
                                                                id="certificateOptionH">
                                                            <label class="form-check-label">H</label>
                                                        </div>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="radio"
                                                                name="certificate_option" value="I"
                                                                id="certificateOptionI">
                                                            <label class="form-check-label">I</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-check form-switch mb-3">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        name="account" value="Y" id="editRoleAccount">
                                                    <label class="form-check-label" for="editRoleAccount">Account</label>
                                                </div>
                                                <button class="btn btn-primary d-grid " type="submit">Submit</button>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="col col-12 col-md-12 ">

                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5>All Users</h5>
                                    </div>
                                    <div class="card-body">

                                        <table id="example2" class="table " style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>User</th>
                                                    <th>Role</th>
                                                    <th>Permission</th>
                                                    <th>Status</th>
                                                    <th>Parent</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach (@$users as $index => $user)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->role ? $user->role->name : 'Not assign' }}</td>
                                                        <td>
                                                            @if ($user->role)
                                                                @if ($user->role->lead == 'Y')
                                                                    L,
                                                                @endif
                                                                @if ($user->role->user == 'Y')
                                                                    U,
                                                                @endif
                                                                @if ($user->role->meeting == 'Y')
                                                                    M,
                                                                @endif
                                                                @if ($user->role->proposal == 'Y')
                                                                    P,
                                                                @endif
                                                                @if ($user->role->certificate == 'Y')
                                                                    C,
                                                                @endif
                                                                @if ($user->role->account == 'Y')
                                                                    A,
                                                                @endif
                                                            @else
                                                                --
                                                            @endif

                                                        </td>
                                                        <td>{{ $user->active == 'N' ? 'Activate' : 'Deactivate' }}</td>
                                                        <td>
                                                            @php
                                                                $parentIds = explode(',', $user->parent_id);

                                                            @endphp
                                                            @foreach ($parentIds as $parentId)
                                                                @foreach ($createUsers as $parentUser)
                                                                    @if ($parentUser->id == $parentId)
                                                                        {{ $parentUser->name }} ,
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('users.updateActive', ['id' => $user->id]) }}"
                                                                class="btn btn-sm {{ $user->active == 'Y' ? 'btn-secondary' : 'btn-primary' }}">
                                                                {{ $user->active == 'Y' ? 'Deactivate' : 'Activate' }}
                                                            </a>
                                                            <a href="{{ route('user.edit', ['id' => $user->id]) }}"
                                                                class="btn btn-sm btn-warning">
                                                                Edit
                                                            </a>


                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>

                                        </table>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- / Content -->
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#certificateToggle').change(function() {
                $('#certificateOptions').toggle(this.checked);
            });
        });
        $(document).ready(function() {
            $('#editRoleCertificate').change(function() {
                $('#certificateEditRole').toggle(this.checked);
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const editRoleButton = document.querySelectorAll('.edit-role-button');
            const editRoleForm = document.getElementById('editRoleForm');
            const roleIdInput = document.getElementById('editRoleId');
            const editRoleName = document.getElementById('editRoleName');
            const editRoleLead = document.getElementById('editRoleLead');
            const editRoleUser = document.getElementById('editRoleUser');
            const editRoleMeeting = document.getElementById('editRoleMeeting');
            const editRoleProposal = document.getElementById('editRoleProposal');
            const editRoleCertificate = document.getElementById('editRoleCertificate');
            const editRoleAccount = document.getElementById('editRoleAccount');
            const certificateOptionQ = document.getElementById('certificateOptionQ');
            const certificateOptionH = document.getElementById('certificateOptionH');
            const certificateOptionI = document.getElementById('certificateOptionI');

            editRoleButton.forEach(button => {
                button.addEventListener('click', function() {
                    const roleId = this.getAttribute('data-role-id');
                    const roleName = this.getAttribute('data-role-name');
                    const roleLead = this.getAttribute('data-role-lead');
                    const roleUser = this.getAttribute('data-role-user');
                    const roleMeeting = this.getAttribute('data-role-meeting');
                    const roleProposal = this.getAttribute('data-role-proposal');
                    const roleCertificate = this.getAttribute('data-role-certificate');
                    const roleAccount = this.getAttribute('data-role-account');
                    const roleOption = this.getAttribute('data-role-option');

                    roleIdInput.value = roleId;
                    editRoleName.value = roleName;
                    editRoleLead.checked = roleLead === 'Y';
                    editRoleUser.checked = roleUser === 'Y';
                    editRoleMeeting.checked = roleMeeting === 'Y';
                    editRoleProposal.checked = roleProposal === 'Y';
                    editRoleCertificate.checked = roleCertificate === 'Y';
                    editRoleAccount.checked = roleAccount === 'Y';
                    certificateOptionQ.checked = roleOption === 'Q';
                    certificateOptionH.checked = roleOption === 'H';
                    certificateOptionI.checked = roleOption === 'I';

                    if (editRoleForm.style.display === 'none') {
                        editRoleForm.style.display = 'block';
                    } else {
                        editRoleForm.style.display = 'none';
                    }
                    if (roleCertificate === 'Y') {
                        certificateEditRole.style.display = 'block';
                    } else {
                        certificateEditRole.style.display = 'none';
                    }


                });
            });
        });
    </script>
@endsection
