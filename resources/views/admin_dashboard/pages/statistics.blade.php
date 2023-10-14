@if(in_array('latest_lection_statistic', $permissions, true))
    @include('admin_dashboard.latest_lection')
@endif
@if(in_array('most_perspective_users_statistic', $permissions, true))
    @include('admin_dashboard.most_perspective_users')
@endif
@if(in_array('user_changes_statistic', $permissions, true))
    @include('admin_dashboard.user_changes')
@endif