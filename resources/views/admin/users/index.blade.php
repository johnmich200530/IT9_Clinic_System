@extends('layouts.admin')
@section('title', 'User Accounts')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0">User Accounts</h1>
    <a href="{{ route('admin.users.create') }}" class="btn-submit">
         Add Account
    </a>
</div>

{{-- Search --}}
<form method="GET" action="{{ route('admin.users.index') }}" class="mb-3">
    <div class="search-wrap">
        <i class="bi bi-search search-icon"></i>
        <input type="text" name="search" class="search-input"
               placeholder="Search by name, email or role…"
               value="{{ $search ?? '' }}">
        @if(!empty($search))
            <a href="{{ route('admin.users.index') }}" class="search-clear">
                <i class="bi bi-x-lg"></i>
            </a>
        @endif
    </div>
</form>

<div class="table-responsive">
    <table class="product-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td class="td-id">{{ $user->id }}</td>
                <td class="td-name">
                    {{ $user->name }}
                    @if($user->id === auth()->id())
                        <span class="badge ms-1" style="background:#EEF2FF;color:#4F46E5;font-size:10px;">You</span>
                    @endif
                </td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->role === 'admin')
                        <span class="badge" style="background:#EEF2FF;color:#4F46E5;">
                            Admin
                        </span>
                    @elseif($user->role === 'doctor')
                        <span class="badge" style="background:#ECFDF5;color:#065F46;">
                            Doctor
                        </span>
                    @else
                        <span class="badge" style="background:#FEF3C7;color:#92400E;">
                            Patient
                        </span>
                    @endif
                </td>
                <td style="color:#9CA3AF;font-size:13px;">
                    {{ $user->created_at->format('M d, Y') }}
                </td>
                <td>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn-edit">
                         Edit
                    </a>
                    @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Delete account for {{ addslashes($user->name) }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-delete">
                                 Delete
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-muted py-4">No accounts found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
