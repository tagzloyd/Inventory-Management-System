<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        /* MUI-inspired CSS */
        :root {
            --primary: #1976d2;
            --secondary: #dc004e;
            --background: #f5f5f5;
            --paper: #ffffff;
            --text-primary: rgba(0, 0, 0, 0.87);
            --text-secondary: rgba(0, 0, 0, 0.54);
        }

        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--background);
            color: var(--text-primary);
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .paper {
            background-color: var(--paper);
            border-radius: 8px;
            box-shadow: 0px 2px 1px -1px rgba(0,0,0,0.2), 
                        0px 1px 1px 0px rgba(0,0,0,0.14), 
                        0px 1px 3px 0px rgba(0,0,0,0.12);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .title {
            font-size: 1.5rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            color: var(--text-primary);
        }

        .table-container {
            overflow-x: auto;
        }

        .user-table {
            width: 100%;
            border-collapse: collapse;
        }

        .user-table thead tr {
            border-bottom: 1px solid rgba(224, 224, 224, 1);
        }

        .user-table th {
            text-align: left;
            padding: 1rem;
            font-weight: 500;
            color: var(--text-secondary);
        }

        .user-table td {
            padding: 1rem;
            border-bottom: 1px solid rgba(224, 224, 224, 1);
        }

        .user-table tr:hover {
            background-color: rgba(0, 0, 0, 0.04);
        }

        .action-btns {
            white-space: nowrap;
        }

        .action-btn {
            background: none;
            border: none;
            color: var(--primary);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 4px;
            transition: background-color 150ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
        }

        .action-btn:hover {
            background-color: rgba(25, 118, 210, 0.04);
        }

        .btn-delete {
            color: var(--secondary);
        }

        .btn-delete:hover {
            background-color: rgba(220, 0, 78, 0.04);
        }

        /* Modal styles */
        .modal-header {
            border-bottom: none;
            padding-bottom: 0;
        }

        .modal-footer {
            border-top: none;
            padding-top: 0;
            justify-content: space-between;
        }

        .modal-title {
            font-weight: 500;
        }

        .modal-body {
            padding-top: 0;
            color: var(--text-secondary);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="paper">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="title">User Management</h1>
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add User
                </a>
            </div>
            
            @if(isset($users) && $users->count() > 0)
                <div class="table-container">
                    <table class="user-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created At</th>
                                <th>Updated At</th> <!-- Added column -->
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('M d, Y H:i') }}</td>
                                    <td>{{ $user->updated_at->format('M d, Y H:i') }}</td> <!-- Display updated_at -->
                                    <td class="action-btns">
                                        <a href="{{ route('users.edit', $user->id) }}" class="action-btn" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="action-btn btn-delete" title="Delete" data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal" data-user-id="{{ $user->id }}"
                                                data-user-name="{{ $user->first_name }} {{ $user->last_name }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($users->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $users->links() }}
                    </div>
                @endif
                
            @else
                <div class="alert alert-info">No users found.</div>
            @endif
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete user <span id="userName"></span>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Delete modal handler
        document.addEventListener('DOMContentLoaded', function() {
            const deleteModal = document.getElementById('deleteModal');
            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const userId = button.getAttribute('data-user-id');
                const userName = button.getAttribute('data-user-name');
                
                document.getElementById('userName').textContent = userName;
                document.getElementById('deleteForm').action = `/users/${userId}`;
            });
        });
    </script>
</body>
</html>