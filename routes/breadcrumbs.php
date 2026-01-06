<?php

use App\Models\User;
use App\Models\Property;
use App\Models\Report;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Breadcrumbs Translation Strategy
|--------------------------------------------------------------------------
| Using 'menu' translation file for all breadcrumb labels.
*/

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push(__('menu.home'), route('dashboard'));
});

// Home > Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('menu.dashboard'), route('dashboard'));
});

// Home > Dashboard > Documents Management
Breadcrumbs::for('user-management.documents.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(__('menu.documents_management'), route('user-management.documents.index'));
});

// Home > Dashboard > User Management
Breadcrumbs::for('user-management.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(__('menu.user_management'), route('user-management.users.index'));
});

// Home > Dashboard > User Management > Users
Breadcrumbs::for('user-management.users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push(__('menu.users'), route('user-management.users.index'));
});

// Home > Dashboard > User Management > Users > [User Name]
Breadcrumbs::for('user-management.users.show', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('user-management.users.index');
    $trail->push(ucwords($user->name), route('user-management.users.show', $user));
});

// Home > Dashboard > User Management > Properties
Breadcrumbs::for('user-management.properties.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push(__('menu.properties'), route('user-management.properties.index'));
});

// Home > Dashboard > User Management > Properties > [Owner Name]
Breadcrumbs::for('user-management.properties.show', function (BreadcrumbTrail $trail, Property $property) {
    $trail->parent('user-management.properties.index');
    $trail->push(ucwords($property->property_owner), route('user-management.properties.show', $property));
});

// Home > Dashboard > User Management > Reports
Breadcrumbs::for('user-management.reports.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push(__('menu.reports'), route('user-management.reports.index'));
});

// Home > Dashboard > User Management > Reports > [Report Info]
Breadcrumbs::for('user-management.reports.show', function (BreadcrumbTrail $trail, Report $report) {
    $trail->parent('user-management.reports.index');
    $trail->push(__('menu.report_details') . ' #' . $report->id, route('user-management.reports.show', $report));
});

// Home > Dashboard > User Management > Roles
Breadcrumbs::for('user-management.roles.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push(__('menu.roles'), route('user-management.roles.index'));
});

// Home > Dashboard > User Management > Roles > [Role Name]
Breadcrumbs::for('user-management.roles.show', function (BreadcrumbTrail $trail, Role $role) {
    $trail->parent('user-management.roles.index');
    $trail->push(ucwords($role->name), route('user-management.roles.show', $role));
});

// Home > Dashboard > User Management > Permissions
Breadcrumbs::for('user-management.permissions.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push(__('menu.permissions'), route('user-management.permissions.index'));
});
