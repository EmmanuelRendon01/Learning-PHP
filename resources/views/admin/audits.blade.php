<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Learning php</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="bg-body-tertiary">
    <div class="container">
        <h1>Audit Date</h1>
        <!-- Search Section -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <form action="{{ route('audits') }}" method="GET" class="row g-3">
                    
                    <div class="col-md-4">
                        <label class="form-label fw-bold">User Name</label>
                        <input type="text" name="user" class="form-control" placeholder="Search by user..." value="{{ request('user') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Event</label>
                        <select name="event" class="form-select">
                            <option value="">All Events</option>
                            <option value="created" {{ request('event') == 'created' ? 'selected' : '' }}>Created</option>
                            <option value="updated" {{ request('event') == 'updated' ? 'selected' : '' }}>Updated</option>
                            <option value="deleted" {{ request('event') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">IP Address</label>
                        <input type="text" name="ip" class="form-control" placeholder="0.0.0.0" value="{{ request('ip') }}">
                    </div>

                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                        <a href="{{ route('audits') }}" class="btn btn-outline-secondary">Clear</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Event</th>
                        <th>Model Type</th>
                        <th>IP Address</th>
                        <th>Date</th>
                        <th>Old Values</th>
                        <th>New Values</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($audits as $audit)
                        <tr>
                            <td>{{ $audit->id }}</td>
                            <td>{{ $audit->user->name ?? 'System' }}</td>
                            <td>
                                <span class="badge {{ $audit->event == 'created' ? 'bg-success' : ($audit->event == 'updated' ? 'bg-info' : 'bg-danger') }}">
                                    {{ ucfirst($audit->event) }}
                                </span>
                            </td>
                            <td>{{ $audit->auditable_type }}</td>
                            <td><code>{{ $audit->ip_address }}</code></td>
                            <td>{{ $audit->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <button type="button" 
                                class="btn btn-primary" 
                                data-bs-toggle="modal" 
                                data-bs-target="#valuesModal"
                                data-values="{{ json_encode($audit->old_values) }}"
                                data-title="Old Values"><i class="fas fa-plus"></i> Old values</button></td>
                            <td>
                                <button type="button" 
                                class="btn btn-primary" 
                                data-bs-toggle="modal" 
                                data-bs-target="#valuesModal"
                                data-values="{{ json_encode($audit->new_values) }}"
                                data-title="New Values"><i class="fas fa-plus"></i> New values</button>
                            </td>


                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No audit logs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $audits->links() }}
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="valuesModal" tabindex="-1" aria-labelledby="valuesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="valuesModalLabel">Old Values</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="mb-3 mx-5 mt-2">
                    <label for="id" class="form-label">ID</label>
                    <input type="text" class="form-control" id="id" name="id" disabled>
                </div>
                
                <div class="mb-3 mx-5 mt-2">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" disabled>
                </div>

                <div class="mb-3 mx-5">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" disabled> 
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

        <script>
            document.getElementById('valuesModal').addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                

                const values = JSON.parse(button.getAttribute('data-values') || '{}');
                const title = button.getAttribute('data-title');

                this.querySelector('.modal-title').textContent = title;


                document.getElementById('id').value = values.id || 'Not changed';
                document.getElementById('name').value = values.name || 'Not changed';
                document.getElementById('email').value = values.email || 'Not changed';
            });
        </script>
</body>

</html>