@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3 class="fw-bold">Team Allocation</h3>

        <a href="{{ route('contacts.create') }}" class="btn btn-primary">
            + Team Allocation
        </a>

    </div>


    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif


    <div class="card shadow-sm">

        <div class="card-body">

            <form method="GET" class="mb-3">

                <div class="input-group">

                    <input type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search contact...">

                    <button class="btn btn-outline-secondary">
                        Search
                    </button>

                </div>

            </form>


            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Company</th>
                        <th>Assigned</th>
                        <th width="180">Actions</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($contacts as $contact)

                    <tr>

                        <td>{{ $contact->name }}</td>

                        <td>{{ $contact->email }}</td>

                        <td>{{ $contact->phone }}</td>

                        <td>{{ $contact->company }}</td>

                        <td>
                            {{ $contact->employee->name ?? '-' }}
                        </td>
                        <td class="text-center">

                            <a href="{{ route('contacts.show', $contact->id) }}"
                                class="btn btn-sm btn-view">
                                View
                            </a>

                            <a href="{{ route('contacts.edit', $contact->id) }}"
                                class="btn btn-sm btn-edit">
                                Edit
                            </a>

                            <form action="{{ route('contacts.destroy', $contact->id) }}"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Pakka Bhai?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-delete">
                                    Delete
                                </button>
                            </form>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

            {{ $contacts->links() }}

        </div>

    </div>

</div>

@endsection