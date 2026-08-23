<?php

// routes/breadcrumbs.php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Consultation
Breadcrumbs::for('consultation', function (BreadcrumbTrail $trail) {
    $trail->push('Consultation', route('consultation'));
});
Breadcrumbs::for('consultation.details', function (BreadcrumbTrail $trail, string $id) {
    $trail->parent('consultation');
    $trail->push('Consultation Details', route('consultation.details', ['id' => $id]));
});

// Patient
Breadcrumbs::for('patients', function (BreadcrumbTrail $trail) {
    $trail->push('Patient List', route('patients'));
});
Breadcrumbs::for('patient.details', function (BreadcrumbTrail $trail, string $id) {
    $trail->parent('patients');
    $trail->push('Patient Details', route('patient.details', ['id' => $id]));
});

// User
Breadcrumbs::for('users', function (BreadcrumbTrail $trail) {
    $trail->push('Users', route('users'));
});
Breadcrumbs::for('user.details', function (BreadcrumbTrail $trail, string $id) {
    $trail->parent('users');
    $trail->push('User Details', route('user.details', ['id' => $id]));
});

// Front Desk
Breadcrumbs::for('front-desk', function (BreadcrumbTrail $trail) {
    $trail->push('Front Desk', route('front-desk'));
});