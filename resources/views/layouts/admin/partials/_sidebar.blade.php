<div class="profile-sidebar">
    <ul class="list-group">
        <li>
            <a class="list-group-item"><i class="fa fa-home"></i> <span>Navigation</span></a>
        </li>
        <li><a href="{{ route('admin.dashboard') }}" class="list-group-item {{ (request()->is('admin/dashboard'))? 'active' :'' }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
        </li>
        <li><a href="{{ route('admin.album.index') }}" class="list-group-item {{ (request()->is('admin/photo/album*'))? 'active' :'' }}"><i class="fa fa-photo"></i> <span>Photos</span></a>
            <ul class="submenu" style="display: {{ (request()->is('admin/photo/album/new'))? 'block' :'' }};">
                <li><a href="{{ route('admin.album.new') }}" class="list-group-item"><i class="fa fa-file-photo-o"></i> <span>New album</span></a></li>
            </ul>
        </li>
    </ul>
</div>
