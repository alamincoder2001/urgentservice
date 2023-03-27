@extends("layouts.app")

@section("title", "Admin Permission Page")

@section("content")

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary
                            d-flex justify-content-between py-1">
                <h4 class="card-title m-0 pt-2">User Permission</h4>
                <a href="{{ route('admin.user.create') }}" class="btn btn-info px-3">
                    Users List
                </a>
            </div>
            <div class="card-body">

                @if (session('message'))
                <div class="alert alert-{{ session('type') }}">{{ session('message') }}</div>
                @endif

                <form action="{{ route('store.permission') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="text-center">User Name: <?= $user->name ?> | Role:
                                <?= $user->role ?></label>
                        </div>
                    </div>
                    <input type="hidden" name="user_id" value="<?= $user->id ?>">
                    <table class="table table-bordered">
                        <tr>
                            <td colspan="2">
                                <input type="checkbox" id="all" value="1">
                                <label for="all">All</label>
                            </td>
                        </tr>
                        @foreach ($group_name as $group)
                        <tr>
                            <td>
                                <input type="checkbox" id="role-{{ $group }}" value="{{ $group }}" onclick="selectGroup(this.id)">
                                <label for="role-{{ $group }}">{{ $group }}</label>
                            </td>
                            <td class="role-{{ $group }}">
                                @foreach ($permissions as $item)
                                @if ($group == $item->group_name)
                                <input type="checkbox" name="permissions[]" id="{{ $item->permissions }}" value="{{ $item->id }}" {{ in_array($item->permissions, $userAccess) ? 'checked' : '' }}>
                                <label for="{{ $item->permissions }}">{{ $item->permissions }}</label><br>
                                @endif
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <div class="text-right">
                        <button type="submit" class="btn btn-success">Save Permissions</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


@endsection

@push("js")
<script>
    $('#all').on('click', function() {
        if ($(this).is(':checked')) {
            $('input[type=checkbox').prop('checked', true);
        } else {
            $('input[type=checkbox').prop('checked', false);
        }
    })

    function selectGroup(className) {
        const checkbox = $('.' + className + ' input');
        console.log(checkbox);
        if ($('#' + className).is(':checked')) {
            checkbox.prop('checked', true);
        } else {
            checkbox.prop('checked', false);
        }
    }
</script>
@endpush